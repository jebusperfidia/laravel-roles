<?php

namespace App\Livewire\Valuations;

use App\Models\Valuation;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use Livewire\Attributes\On;



final class AssignedTable extends PowerGridComponent
{
    public string $tableName = 'assigned-table';
    public $user;

    public array $ids = [];

    public function header(): array
    {


       /*  return [
            Button::add('assign-masive')

                ->slot(('Asignar masivamente (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)'))
                ->class('cursor-pointer block pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('AssignMasive.' . $this->tableName, []),
        ]; */

        $header = [];
        $user = Auth::user();

        // Solo se agrega el botón si el usuario es un 'Administrador'
        if ($user && $user->type === 'Administrador') {
            $header[] = Button::add('assign-masive')
                /* ->slot(('Asignar masivamente (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')) */
                ->slot('Asignar masivamente')
                ->class('cursor-pointer block pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('AssignMasive.' . $this->tableName, []);
        }

        return $header;
    }

    public function setUp(): array
    {
        $this->checkboxValues = [];
        $this->user = Auth::user();
        if ($this->user && $this->user->type === 'Administrador') {
        $this->showCheckBox();
        }
       /*  $this->user = auth()->user();
 */
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
        return Valuation::query()->where('status', 0);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('date_formatted', fn (Valuation $model) => Carbon::parse($model->date)->format('d/m/Y'))
            ->add('type')
            ->add('folio')
            ->add('property_type', fn (Valuation $model) => ucwords(str_replace('_', ' ', $model->property_type)));
            //->add('created_at');
    }

    public function columns(): array
    {
        $cols = [
            Column::make('Id', 'id'),
            Column::make('Fecha', 'date_formatted', 'date')
                ->sortable(),

            Column::make('Tipo', 'type')
                ->sortable()
                ->searchable(),

            Column::make('Folio', 'folio')
                ->sortable()
                ->searchable(),

            Column::make('Tipo de propiedad', 'property_type')
                ->sortable()
                ->searchable()

        /*    Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(), */
        ];


       /*  if ($this->user && $this->user->type === 'Administrador') { */
            $cols[] = Column::action('Acciones');
      /*   }
        // Conditionally add the 'Acciones' column for Administrador users
       /*  if ($this->user && $this->user->type === 'Administrador') { */
           /*  $cols[] = Column::action('Acciones'); */
     /*    } */

        return $cols;
    }

    public function filters(): array
    {
        return [
            /* Filter::datepicker('date'), */
        ];
    }

    /*     #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }
 */

    #[On('AssignMasive.assigned-table')]
    public function bulkAssign(): void
    {

        if($this->checkboxValues === []) {
            $this->js('alert("No hay filas seleccionadas")');
            return;
        }
         //$this->ids = $ids;
        /* dd($this->checkboxValues); */
        $this->dispatch('openAssignModal', $this->checkboxValues, 'massive');
        $this->dispatch('pg:eventRefresh-' . $this->tableName);

        //$this->js('alert(window.pgBulkActions.get(\'' . $this->tableName . '\'))');

        /* dd($this->checkboxValues); */
    }

    public function actions(Valuation $row): array
    {
        return [
            Button::add()
                ->slot('Asignar')
                /* ->slot('Asignar') */
                ->id()
                ->class('cursor-pointer pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('openAssignModal', ['ids' => [$row->id]])
                ->can($this->user->type === 'Administrador'),

                Button::add()
                ->slot('Cambiar Estatus')
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
