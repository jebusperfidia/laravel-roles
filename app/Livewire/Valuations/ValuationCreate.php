<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use App\Models\Valuation;

class ValuationCreate extends Component
{
    public $type, $folio, $date, $property_type;

    public function render()
    {
        $this->date = now()->format('Y-m-d');
        return view('livewire.valuations.valuation-create');
    }

    public function save(){

        $this->validate([
            "type" => 'required',
            "folio" => 'required|unique:valuations|regex:/^[A-Za-z0-9\-]+$/',
            /* "folio" => 'required|regex:/^[A-Za-z0-9\-]+$/', */
            "date" => 'required',
            "property_type" => 'required'
        ]);

        Valuation::create([
            "type" => $this->type,
            "folio" => $this->folio,
            "date" => $this->date,
            "property_type" => $this->property_type
        ]);


        /* $this->reset(); */
        /* return redirect()->route('dashboard', ['currentView' => 'assigned']); */
        return redirect()->route('dashboard', ['currentView' => 'assigned'])
            ->with('success', 'Avalúo creado con éxito');
    }
}
