<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use Masmerise\Toaster\Toastable;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toaster;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class UserTable extends PowerGridComponent
{
    public string $tableName = 'userTable';

    public function setUp(): array
    {
        //Si se quiere poner un checkbox al principio para seleccionar uno o varios, se descomenta esta línea
        /*  $this->showCheckBox(); */

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
        return User::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('email')
            ->add('type')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Nombre', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Tipo', 'type')
                ->sortable()
                ->searchable(),

            Column::action('Acciones')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

 /*    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    } */

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void
    {
        /* $this->js('alert(' . $rowId . ')'); */
        $user = User::find($rowId);
        $user?->delete();
        /*  session()->flash("info", "Usuario eliminado con éxito");
        // Fuerza una recarga de página y muestra el mensaje */
        Toaster::error('Usuario eliminado con éxito');
        $this->dispatch('pg:eventRefresh-' . $this->tableName);

    }

    public function actions(User $row): array
    {
        return [
            Button::add()
                ->slot('Editar')
                ->id()
                ->class('cursor-pointer btn-intermediary btn-table pr-3')
                /* ->dispatch('edit', ['rowId' => $row->id]), */
                ->route('user.edit', ['id' => $row->id]),

            Button::add('delete')
                ->slot('Eliminar')
                ->id()
                /* ->class('cursor-pointer pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700') */
                ->class('cursor-pointer btn-deleted btn-table')
                ->attributes([
                    // Si confirma, dispara el dispatch; si no, corta la propagación
                    'onclick' => "if(!confirm('¿Estás seguro de eliminar este usuario?')) event.stopImmediatePropagation()"
                ])
                ->dispatch('delete', ['rowId' => $row->id])
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
