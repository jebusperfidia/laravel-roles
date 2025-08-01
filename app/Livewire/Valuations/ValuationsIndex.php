<?php

namespace App\Livewire\Valuations;

use Livewire\Component;

class ValuationsIndex extends Component
{
    public string $currentView = 'captured';

    public function setView($view)
    {
        $this->currentView = $view;
    }

    public function render()
    {
        return view('livewire.valuations.valuations-index');
    }
}
