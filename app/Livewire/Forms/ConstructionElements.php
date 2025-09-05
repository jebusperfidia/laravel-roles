<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class ConstructionElements extends Component
{


    /* Primera parte */
    public $sc_structure, $sc_shallowFoundation;

    /* Segunda parte */
    public $fn1_hallFlats, $fn1_hallWalls;

    /* Tercera parte */
    public $fn2_cementPlaster;

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
