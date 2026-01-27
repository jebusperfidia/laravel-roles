<?php

namespace App\Livewire\Valuations;

use App\Models\Valuations\Valuation;
use App\Models\Users\Assignment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\On;

final class ReviewedTable extends PowerGridComponent
{
    // Nombre único para esta tabla para evitar conflictos
    public string $tableName = 'reviewed-table';

    public $user;

    public function setUp(): array
    {
        /* $this->showCheckBox(); */
        $this->user = Auth::user();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        // Usamos la misma lógica de Joins que en CapturedTable
        // PERO filtramos por status = 2 (En Revisión)
        return Assignment::query()
            ->join('valuations', 'assignments.valuation_id', '=', 'valuations.id')
            ->join('users as appraiserU', 'assignments.appraiser_id', '=', 'appraiserU.id')
            ->join('users as operatorU',  'assignments.operator_id',  '=', 'operatorU.id')
            ->where('valuations.status', 2)
            ->select([
                'valuations.id',
                'valuations.date        as valuation_date',
                'valuations.type        as valuation_type',
                'valuations.folio       as valuation_folio',
                'valuations.property_type   as property_type',
                'appraiserU.name        as appraiser_name',
                'operatorU.name         as operator_name',
            ]);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('valuation_date')
            ->add('valuation_type', fn(Assignment $model) => ucwords($model->valuation_type))
            ->add('valuation_folio')
            ->add('property_type', fn(Assignment $model) => ucwords(str_replace('_', ' ', $model->property_type)))
            ->add('appraiser_name')
            ->add('operator_name');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Fecha de avalúo', 'valuation_date')
                ->searchable()
                ->sortable(),

            Column::make('Tipo de avalúo', 'valuation_type')
                ->searchable()
                ->sortable(),

            Column::make('Folio', 'valuation_folio')
                ->searchable()
                ->sortable(),

            Column::make('Tipo de propiedad', 'property_type')
                ->searchable()
                ->sortable(),

            Column::make('Perito', 'appraiser_name')
                ->searchable()
                ->sortable(),

            // Column::make('Operador', 'operator_name')... (Lo tienes comentado en la otra)

            Column::action('Acciones')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    // --- ACCIONES ESPECÍFICAS DE ESTA TABLA ---

    #[On('approveValuation')]
    public function approveValuation($rowId)
    {
        $valuation = Valuation::find($rowId);
        if ($valuation) {
            // Pasamos a estatus 3 (Completado)
            $valuation->update(['status' => 3]);

            Toaster::success('Avalúo finalizado con éxito.');

            // Refrescamos el índice principal para actualizar contadores
            $this->dispatch('refreshValuationsIndex');
        }
    }

    public function actions(Assignment $row): array
    {
        return [
            // 1. REVISAR: Dispara 'openForms' que ahora sí escucha Reviewed.php
            Button::add('review')
                ->slot('Revisar')
                ->id()
                ->class('cursor-pointer btn-intermediary btn-table pr-3')
                ->dispatch('openForms', ['id' => $row->id]),

            // 2. CAMBIAR ESTATUS:
            // OJO AQUÍ: Le vamos a pasar el estatus actual (2) para la regla de oro
            Button::add('status')
                ->slot('Cambiar estatus')
                ->id()
                ->class('cursor-pointer btn-change btn-table pr-3')
                // Enviamos ID y el Status actual (2) para que el modal sepa qué opciones mostrar
                ->dispatch('openStatusModal', ['valuationId' => $row->id, 'currentStatus' => 2])
                ->can($this->user->type === 'Administrador'),

            // 3. FINALIZAR:
            Button::add('approve')
                ->slot('Finalizar')
                ->id()
                ->class('cursor-pointer btn-primary btn-table pr-3')
                ->confirm('¿Estás seguro de finalizar este avalúo? \n Este proceso no podrá revertirse')
                ->dispatch('approveValuation', ['rowId' => $row->id])
                ->can($this->user->type === 'Administrador'),
        ];
    }
}
