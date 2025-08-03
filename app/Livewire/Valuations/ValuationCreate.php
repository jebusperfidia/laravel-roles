<?php

namespace App\Livewire\Valuations;

use Livewire\Component;

class ValuationCreate extends Component
{
    public $type, $folio, $date, $type_inmueble;

    public function render()
    {
        $this->date = now()->format('Y-m-d');
        return view('livewire.valuations.valuation-create');
    }

    public function save(){

        $this->validate([
            "type" => 'required',
            /* "folio" => 'required|regex:/^[A-Za-z0-9\-]+$/'|unique:valuations, */
            "folio" => 'required|regex:/^[A-Za-z0-9\-]+$/',
            "date" => 'required',
            "type_inmueble" => 'required'
        ]);

        $this->reset();
        /* return redirect()->route('dashboard', ['currentView' => 'assigned']); */
        return redirect()->route('dashboard', ['currentView' => 'assigned'])
            ->with('success', 'Avalúo creado con éxito');
    }
}
