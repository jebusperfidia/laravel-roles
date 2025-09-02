<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class ConstructionElements extends Component
{
    public $sli_dateDeed = '';
    public $sli_notaryDeed = '';

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


    // Método para el campo de fecha
    public function appendDate(string $textToAppend): void
    {
        // Si el textarea no está vacío, añade un espacio antes del nuevo texto.
        $prefix = !empty($this->sli_dateDeed) ? ' ' : '';
        $this->sli_dateDeed .= $prefix . $textToAppend;
    }

    // Método para el campo de notario
    public function appendNotary(string $textToAppend): void
    {
        $prefix = !empty($this->sli_notaryDeed) ? ' ' : '';
        $this->sli_notaryDeed .= $prefix . $textToAppend;
    }


    public function render()
    {
        return view('livewire.forms.construction-elements');
    }
}
