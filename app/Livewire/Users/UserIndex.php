<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;
    public $search;

    public function render()
    {

        //creamos una variable para obtener la colección de datos de los usuarios, y generamos la búsqueda de coincidencias para la búsqueda
        $users = User::where("name","LIKE","%{$this->search}%")
        ->orWhere("email", "LIKE", "%{$this->search}%")
        ->orWhere("type", "LIKE", "%{$this->search}%")
        //Paginamos los elementos por la cantidad indicada
        ->Paginate(10);

        /* //Si eliminamos el último usuario y no hay datos, debe devolvernos a la página 1 para no dejar el componente en blanco
        if ($users->isEmpty() && $users->currentPage() > 1) {
        // Redirige a la primera página
        return redirect()->route('user.index', ['page' => 1]);
        } */
        // Si la página actual no tiene datos y no es la primera,
        // establece la propiedad 'page' de la paginación en 1.
       /*  if ($users->currentPage() > 1 && $users->isEmpty()) {
            $this->previousPage();
        } */

        //Devolvemos la colección de datos después de verificar la búsqueda y el if para evitar problemas en la páginación
        return view('livewire.users.user-index', compact(("users")));

        /* return view('livewire.users.user-index', compact("users")); */
    }

    /*     public function delete($id) {

        $user = User::find($id);
        $user->delete();


        // Obtener la colección de usuarios después de la eliminación.
        $users = User::where("name", "LIKE", "%{$this->search}%")
            ->orWhere("email", "LIKE", "%{$this->search}%")
            ->paginate(2);

        // Si la página actual no tiene datos, redirige a la página anterior
        if ($users->currentPage() > 1 && $users->isEmpty()) {
            $this->previousPage();
        }



        return to_route("user.index")->with("info", "Usuario eliminado con éxito");
    } */
    public function delete($id)
    {
        $usersBefore = User::where("name", "LIKE", "%{$this->search}%")
            ->orWhere("email", "LIKE", "%{$this->search}%")
            ->orWhere("type", "LIKE", "%{$this->search}%")
            ->paginate(10);

        $countBefore = $usersBefore->count();
        $user = User::find($id);
        $user?->delete();

        // Si había solo uno, y no estábamos en la primera página, retroceder
        if ($countBefore === 1 && $usersBefore->currentPage() > 1) {
            $this->previousPage();
        }

        session()->flash("info", "Usuario eliminado con éxito");
    }
}
