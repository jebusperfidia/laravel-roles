<?php

namespace App\Livewire\Users;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Log;


class UserCreate extends Component
{

    public $name, $email, $password, $type, $confirmar_password;

    public function render()
    {
        return view('livewire.users.user-create');
    }

    public function save(){
        $this->validate([
            "name" => 'required',
            "email" => 'required|email|unique:users',
            "type" => 'required',
            "password" => 'required|same:confirmar_password',
        ]);


        User::create([
            "name" => $this->name,
            "email" => $this->email,
            "type" => $this->type,
            "password" => Hash::make($this->password)
        ]);

        return to_route("user.index")->with("success", "Usuario creado");

    }
}
