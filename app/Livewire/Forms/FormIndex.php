<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormIndex extends Component
{


    public function mount()
    {
        Session::put('valuation-active-form', true);
    }

    // Nuevo método para regresar al menú principal
    public function backMain()
    {
        // 1. Eliminar la variable de sesión
        Session::forget('valuation-active-form');

        // 2. Redirigir al usuario a la página principal (raíz)
        return $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.forms.form-index');
    }
}
