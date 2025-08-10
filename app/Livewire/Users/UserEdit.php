<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserEdit extends Component
{

    public $user, $name, $email, $type, $password, $confirm_password;

    public function mount($id){
        $this->user = User::find($id);
        $this->name = $this->user->name;
        $this->type = $this->user->type;
        $this->email = $this->user->email;
    }

    public function render()
    {
        return view('livewire.users.user-edit');
    }

    public function save()
    {
        $this->validate([
            "name" => 'required',
            "email" => 'required|email',
            "type" => 'required',
            "password" => 'same:confirmar_password',
        ]);

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->type = $this->type;

        if($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();

        return to_route("user.index")->success('Usuario editado con éxito');
    }
}

