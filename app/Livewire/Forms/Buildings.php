<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class Buildings extends Component
{
    // Estado del tab activo
    public string $activeTab;
    public function mount(){
        $this->activeTab = 'privativas';
    }
    // 3. Método para cambiar de tab
    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }


    public function render()
    {
        return view('livewire.forms.buildings');
    }
}
