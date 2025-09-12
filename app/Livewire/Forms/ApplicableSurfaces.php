<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Validator;

class ApplicableSurfaces extends Component
{

    // Arrays públicos para consumir datos para los input select largos
    public array $construction_source_information;

    //Checboxes de los valores obtenidos de superficie
    public bool $elementApply;

    //Variables del único contenedor
    public $saleableArea, $calculationBuiltArea, $builtArea,
            $hr_surfaceArea, $hr_informationSource,
            $ua_surfaceArea, $ua_informationSource,
            $pl_surfaceArea, $pl_informationSource;

    public function mount()
    {
        // Inicializa las variables con los datos del archivo de configuración
        $this->construction_source_information = config('properties_inputs.construction_source_information');
    }



    public function save()
    {
        $rules = [
            'saleableArea' => 'required',
            /* 'calculationBuiltArea' => 'required', */
            'builtArea' => 'required',
            'hr_surfaceArea' => 'required',
            'hr_informationSource' => 'required',
            'ua_surfaceArea' => 'required',
            'ua_informationSource' => 'required',
            'pl_surfaceArea' => 'required',
            'pl_informationSource' => 'required',
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


        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'special-installations']);
    }

    protected function validationAttributes(): array
    {
        return [
            'saleableArea' => 'superficie vendible',
            'calculationBuiltArea' => 'cálculo de superficie construida',
            'builtArea' => 'superficie construida',
            'hr_surfaceArea' => ' ',
            'hr_informationSource' => ' ',
            'ua_informationSource' => ' ',
            'ua_informationSource' => ' ',
            'pl_surfaceArea' => '',
            'pl_informationSource' => ' ',
        ];
    }

    public function render()
    {
        return view('livewire.forms.applicable-surfaces');
    }
}
