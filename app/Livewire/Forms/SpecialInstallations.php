<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Valuation;
use Illuminate\Support\Facades\Session;
use Masmerise\Toaster\Toaster;
use Flux\Flux;

class SpecialInstallations extends Component
{

    // Estado del tab activo
    public string $activeTab;

    //Generamos una variable para guardar la información del avaluo
    public $valuation;


    public function mount()
    {
        //Inicializamos el valor de la pestaña que se abrirá por defecto
        $this->activeTab = 'privativas';

        //Obtenemos los valores deL avalúo a partir de la variable de sesión del ID
        $this->valuation = Valuation::find(Session::get('valuation_id'));
    }


    //FUNCIONES PARA GRUPOS Y ELEMENTOS DEL MISMO

    public function openAddElement()
    {
        $this->resetValidation();
        Flux::modal('add-element')->show();      // 3) Abre el modal
    }

    public function openEditElement()
    {
        $this->resetValidation();
        Flux::modal('edit-element')->show();      // 3) Abre el modal

    }



    //Método para cambiar de tab
    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }


    public function render()
    {
        return view('livewire.forms.special-installations');
    }
}
