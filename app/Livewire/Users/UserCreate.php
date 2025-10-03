<?php

namespace App\Livewire\Users;

use Illuminate\Support\Facades\Hash;
use App\Models\Users\User;
use Livewire\Component;


class UserCreate extends Component
{

    public $name, $email, $password, $type, $confirmar_password;


    public function save()
    {
        $rules = [
            "name" => 'required',
            "email" => 'required|email|unique:users',
            "type" => 'required',
            "password" => 'required|same:confirmar_password',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributes()
        );


        User::create([
            "name" => $this->name,
            "email" => $this->email,
            "type" => $this->type,
            "password" => Hash::make($this->password)
        ]);

        /* return to_route("user.index")->with("success", "Usuario creado"); */
        return to_route("user.index")->success('Usuario creado con éxito');
    }


    protected function validationAttributes(): array
    {
        return [
            'name' => 'nombre',
            'type' => 'tipo de usuario',
        ];
    }

    public function render()
    {
        return view('livewire.users.user-create');
    }
}
