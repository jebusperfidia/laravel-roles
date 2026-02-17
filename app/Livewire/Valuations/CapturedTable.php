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
        return Assignment::query()
            ->join('valuations', 'assignments.valuation_id', '=', 'valuations.id')
            ->join('users as appraiserU', 'assignments.appraiser_id', '=', 'appraiserU.id')
            ->join('users as operatorU',  'assignments.operator_id',  '=', 'operatorU.id')
            ->where('valuations.status', 1)
            ->select([
                'valuations.id',
                'valuations.date        as valuation_date',
                'valuations.type        as valuation_type',
                'valuations.folio       as valuation_folio',
                'valuations.property_type   as property_type',

                // --- MATERIA PRIMA PARA LA DIRECCIÓN ---
                'valuations.property_street',
                'valuations.property_abroad_number',
                'valuations.property_inside_number',
                'valuations.property_block',
                'valuations.property_lot',
                'valuations.property_condominium',
                'valuations.property_colony',
                'valuations.property_cp',
                'valuations.property_locality',
                'valuations.property_entity',
                // ---------------------------------------

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
            ->add('id')
            ->add('valuation_date')
            ->add('valuation_type', fn(Assignment $model) => ucwords($model->valuation_type))
            ->add('valuation_folio')
            ->add('property_type', fn(Assignment $model) => ucwords(str_replace('_', ' ', $model->property_type)))
            ->add('appraiser_name')
            ->add('operator_name')

            // --- NUESTRO CAMPO VIRTUAL ---
            ->add('full_address', function (Assignment $model) {
                // Trucazo: Llenamos un modelo Valuation en memoria con los datos traídos por el Select
                $val = new Valuation($model->getAttributes());

                // Devolvemos la dirección o el mensaje de que falta
                return $val->full_address
                    ?: 'PENDIENTE DE CAPTURAR';
            });
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

            // --- AQUÍ APARECE LA MAGIA ---
            Column::make('Ubicación', 'full_address'),

            Column::make('Perito', 'appraiser_name')
                ->searchable()
                ->sortable(),

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
            // 1. CAPTURAR
            Button::add('edit')
                ->slot('Capturar')
                ->id()
                ->class('cursor-pointer btn-primary btn-table pr-3')
                ->dispatch('openForms', ['id' => $row->id]),

            // 2. CAMBIAR ESTATUS (Corregido)
            Button::add()
                ->slot('Cambiar estatus')
                ->id()
                ->class('cursor-pointer btn-change btn-table')
                // AQUÍ EL CAMBIO: Enviamos valuationId y currentStatus = 1
                ->dispatch('openStatusModal', ['valuationId' => $row->id, 'currentStatus' => 1])
                ->can($this->user->type === 'Administrador'),

            // 3. ELIMINAR
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
