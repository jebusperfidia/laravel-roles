<?php

namespace App\Livewire\Forms;

use App\Models\Valuation;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormIndex extends Component
{
    /* public $IdValuation; */
     public $id;
    public $valuation;

    public function mount()
    {/*
        $this->IdValuation = $id; */
        //dd('Valoración ID recibida:', $id, gettype($id));

        $this->id = Session::get('valuation_id');
        Session::forget('valuation_id');
        $this->valuation = Valuation::find($this->id);
        /* dd($this->id); */
        /* $this->valuation = Valuation::find($id); */
       /*  dd('Valoración ID recibida:', $this->valuation); */


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
