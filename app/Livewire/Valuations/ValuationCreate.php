<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use App\Models\Valuation;

class ValuationCreate extends Component
{
    public $type, $folio, $date, $property_type;

    public array $propertiesTypes_input;

    public function mount() {
    $this->propertiesTypes_input = config('properties_inputs.property_types', []);
    }


    public function save(){

       /*  $this->validate([
            "type" => 'required',
            "folio" => 'required|unique:valuations|regex:/^[A-Za-z0-9\-]+$/',
            "date" => 'required',
            "property_type" => 'required'
        ]); */

        $rules = [
            "type" => 'required',
            "folio" => 'required|unique:valuations|regex:/^[A-Za-z0-9\-]+$/',
            "date" => 'required',
            "property_type" => 'required'
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributes()
        );

        Valuation::create([
            "type" => $this->type,
            "folio" => $this->folio,
            "date" => $this->date,
            "property_type" => $this->property_type
        ]);


        /* $this->reset(); */
        /* return redirect()->route('dashboard', ['currentView' => 'assigned']); */
        return redirect()->route('dashboard', ['currentView' => 'assigned'])
        ->success('Avaluo creado con éxito');
    }

    protected function validationAttributes(): array {
        return [
            'type' => 'tipo de avaluo',
            'date' => 'fecha de avaluo',
            'property_type' => 'tipo de propiedad'
        ];
    }

    public function render()
    {
        $this->date = now()->format('Y-m-d');
        return view('livewire.valuations.valuation-create');
    }
}
