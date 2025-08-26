<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserEdit extends Component
{

    public $user, $name, $email, $type, $password, $confirm_password;

    public function mount($id)
    {
        $this->user = User::find($id);
        $this->name = $this->user->name;
        $this->type = $this->user->type;
        $this->email = $this->user->email;
    }

    public function save()
    {
        $rules = [
            "name" => 'required',
            "email" => 'required|email',
            "type" => 'required',
            "password" => 'same:confirmar_password',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributes()
        );


        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->type = $this->type;

        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();

        return to_route("user.index")->success('Usuario editado con éxito');
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
        return view('livewire.users.user-edit');
    }
}
