<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use App\Models\Valuations\Valuation;
use App\Models\Forms\LandDetails\LandDetailsModel;
use App\Models\Forms\ConstructionElements\ConstructionElementModel;
use App\Models\Forms\Building\BuildingModel;
use App\Services\HomologationValuationService;

class ValuationCreate extends Component
{
    public $type, $folio, $date, $property_type;

    public array $propertiesTypes_input;

    public function mount() {
    $this->propertiesTypes_input = config('properties_inputs.property_types', []);
    }


    public function save(HomologationValuationService $homologationValuationService){

       /*  $this->validate([
            "type" => 'required',
            "folio" => 'required|unique:valuations|regex:/^[A-Za-z0-9\-]+$/',
            "date" => 'required',
            "property_type" => 'required'
        ]); */

        $rules = [
            "type" => 'required',
            // asignar un guion y espacios en blanco
            'folio' => 'required|unique:valuations|regex:/^[a-zA-Z0-9\-= ]*$/',

            "date" => 'required',
            "property_type" => 'required'
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributes()
        );

        $newValuation =Valuation::create([
            "type" => $this->type,
            "folio" => $this->folio,
            "date" => $this->date,
            "property_type" => $this->property_type
        ]);

        $idValuation = $newValuation->id;

        // Justo después de crear el avalúo, llamamos al servicio
        // para que cree los 7 factores por defecto y los ligue
        $homologationValuationService->createValuationFactors($newValuation);

        //Creamos un registro en la tabla land_details
        LandDetailsModel::create(
            ['valuation_id' => $idValuation]
        );

        //Creamos un registro en la tabla construction_elements
        ConstructionElementModel::create([
            'valuation_id' => $idValuation
        ]);

        //Creamos un registro en la tabla buildings
        BuildingModel::create([
            'valuation_id' => $idValuation
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
