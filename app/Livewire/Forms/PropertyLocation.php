<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;

class PropertyLocation extends Component
{

    public $latitud, $longitud, $altitud;

    public function save(){

        $rules = [
            "latitud" => 'required',
            "longitud" => 'required',
            "altitud" => 'required',
        ];

        $validator = Validator::make(
            $this->all(),
            $rules,
            []
        /*     $this->validationAttributes() */
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


        Toaster::success('Datos guardados con éxito');
    }




    public function render()
    {
        return view('livewire.forms.property-location');
    }
}
