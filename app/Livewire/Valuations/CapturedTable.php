<?php

namespace App\Livewire\Valuations;

use App\Models\Assignment;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Illuminate\Support\Facades\Auth;

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

            Column::make('Operador', 'operator_name')
                ->searchable()
                ->sortable(),

            Column::action('Acciones')
        ];
    }

    public function filters(): array
    {
        return [];
    }

/*     #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    } */

    public function actions(Assignment $row): array
    {
        return [
            Button::add('edit')
                ->slot('Capturar: ' . $row->id)
                ->id()
                ->class('cursor-pointer pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('openForms', ['id' => $row->id]),
                /* ->route('form.index', ['id' => $row->id]), */

            Button::add()
                ->slot('Cambiar Estatus ' . $row->id)
                ->id()
                ->class('cursor-pointer pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('openStatusModal', ['Id' => $row->id])
                ->can($this->user->type === 'Administrador')
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
