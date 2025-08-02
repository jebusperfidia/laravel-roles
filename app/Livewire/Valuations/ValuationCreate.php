<?php

namespace App\Livewire\Valuations;

use Livewire\Component;

class ValuationCreate extends Component
{
    public function render()
    {
        return view('livewire.valuations.valuation-create');
    }

    public function save(){
        return redirect()->route('dashboard', ['currentView' => 'assigned']);
    }
}
