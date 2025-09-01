<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Validator;


class DeclarationsWarnings extends Component
{

    //Variables primero contenedor
    public $dec_idDoc, $dec_areaDoc, $dec_constState, $dec_occupancy, $dec_urbanPlan,
    $dec_inahMonument, $dec_inbaHeritage;

    //Variables segundo contenedor
    public $war_noRelevantDoc, $war_war_InsufficientComparable, $war_UncertainUsage,
    $war_serviceImpact, $war_otherNotes;

    //Variables tercer contenedor
    public $cyb_conclusionValue, $cyb_inmediateTypology, $cyb_immediateMarketing, $cyb_surfaceIncludesExtras;



    public function mount(){

        //Valores por defecto, posteriormente definiremos regla para obtenerlos solo si no hay
        //valores guardados en la base de datos
        $this->dec_idDoc = 1;
        $this->dec_areaDoc = 1;
        $this->dec_constState = 1;
        $this->dec_occupancy = 1;
        $this->dec_urbanPlan = 1;
        $this->dec_inahMonument = 2;
        $this->dec_inbaHeritage = 2;
    }

    public function save(){

        $rules = [
            "cyb_conclusionValue" => 'required',
            "cyb_inmediateTypology" => 'required',
            "cyb_immediateMarketing" => 'required',
            "cyb_surfaceIncludesExtras" => 'required',
        ];

        $validator = Validator::make(
            $this->all(),
            $rules,
            [],
            $this->validationAttributes()
        );

        //Comprobamos si se obtuvieron errores de validación
        if ($validator->fails()) {
            //Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            //Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            //Hacemos un return para detener el flujo del sistema
            return;
        }

        //
        Toaster::success('Los datos fueron guardados con éxito');

    }


    protected function validationAttributes(): array
    {
        return [
            'cyb_conclusionValue' => ' ',
            'cyb_inmediateTypology' => ' ',
            'cyb_immediateMarketing' => ' ',
            'cyb_surfaceIncludesExtras' => ' ',
        ];
    }

    public function render()
    {
        return view('livewire.forms.declarations-warnings');
    }
}
