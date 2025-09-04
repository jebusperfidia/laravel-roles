<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class ConstructionElements extends Component
{
    public $acabados1_pasta, $carpinteria_notas, $hidraulicas_tuberia, $acabados1_espesor, $hidraulicas_diametro, $obraNegra_ladrillo;

    // 1. Estado del tab activo
    public string $activeTab = 'obra_negra';

    // 2. Inicializar con el tab por defecto
    public function mount()
    {
        $this->activeTab = 'obra_negra';
    }

    // 3. Método para cambiar de tab
    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }



    public function render()
    {
        return view('livewire.forms.construction-elements');
    }
}
