<?php

namespace App\Livewire\Valuations;

use App\Models\Valuations\Valuation;
use App\Models\Users\Assignment;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\On;

final class CapturedTable extends PowerGridComponent
{
    public string $tableName = 'captured-table';

    public $user;
    public $ValuationId;


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
        /* return Assignment::query(); */
        return Assignment::query()
            ->join('valuations', 'assignments.valuation_id', '=', 'valuations.id')
            ->join('users as appraiserU', 'assignments.appraiser_id', '=', 'appraiserU.id')
            ->join('users as operatorU',  'assignments.operator_id',  '=', 'operatorU.id')
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

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            /* ->add('id')
            ->add('valuation_id')
            ->add('appraiser_id')
            ->add('operator_id')
            ->add('created_at'); */
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
            /* Column::make('Id', 'id'),
            Column::make('Valuation id', 'valuation_id'),
            Column::make('Appraiser id', 'appraiser_id'),
            Column::make('Operator id', 'operator_id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(), */

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

           /*  Column::make('Operador', 'operator_name')
                ->searchable()
                ->sortable(), */

            Column::action('Acciones')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    #[on('deleteValuation')]
    public function deleteValuation($rowId): void
    {
        //dd($id, Valuation::find($id));
        $valuation = Valuation::find($rowId);
        //dd($valuation);
        $valuation?->delete();
        /*  session()->flash("info", "Usuario eliminado con éxito");
        // Fuerza una recarga de página y muestra el mensaje */
        Toaster::error('Avalúo eliminado con éxito');
        //$this->emitUp('$refresh');
        $this->dispatch('refreshValuationsIndex');
        //redirect()->route('dashboard', ['currentView' => 'captured']);
        //$this->dispatch('pg:eventRefresh-' . $this->tableName);
    }


    public function actions(Assignment $row): array
    {
        return [
            Button::add('edit')
                ->slot('Capturar')
                ->id()
                ->class('cursor-pointer btn-primary btn-table pr-3')
                ->dispatch('openForms', ['id' => $row->id]),
                /* ->route('form.index', ['id' => $row->id]), */

            Button::add()
                ->slot('Cambiar estatus')
                ->id()
                ->class('cursor-pointer btn-change btn-table')
                ->dispatch('openStatusModal', ['Id' => $row->id])
                ->can($this->user->type === 'Administrador'),

            Button::add()
                ->confirm('¿Estás seguro de eliminar el avalúo?')
                ->slot('Eliminar')
                ->id()
                ->class('cursor-pointer btn-deleted btn-table pr-3')
                ->dispatch('deleteValuation', ['rowId' => $row->id])
                ->can($this->user->type === 'Administrador'),
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
