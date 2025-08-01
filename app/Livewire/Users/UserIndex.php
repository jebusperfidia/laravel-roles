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
        /* $users = User::get(); */
        $users = User::where("name","LIKE","%{$this->search}%")->orWhere("email", "LIKE", "%{$this->search}%")->Paginate(2);
        return view('livewire.users.user-index', compact(("users")));

        /* return view('livewire.users.user-index', compact("users")); */
    }

    public function delete($id) {
        /* dd($id); */
        $user = User::find($id);
        $user->delete();

        session()->flash("success", "Usuario eliminado con exito");
    }
}
