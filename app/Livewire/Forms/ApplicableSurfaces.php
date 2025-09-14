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
    public  $calculationBuiltArea,
             $hr_informationSource,
             $ua_informationSource,
             $pl_informationSource;

    public float $saleableArea, $builtArea, $hr_surfaceArea, $ua_surfaceArea, $pl_surfaceArea;

    public function mount()
    {
        // Inicializa las variables con los datos del archivo de configuración
        $this->construction_source_information = config('properties_inputs.construction_source_information');

     $this->saleableArea = 100.00;
     $this->builtArea = 100.00;
     $this->hr_surfaceArea = 0.00;
     $this->ua_surfaceArea = 0.00;
     $this->pl_surfaceArea = 0.00;
    }



    public function save()
    {
        $rules = [
            'saleableArea' => 'required|numeric',
            /* 'calculationBuiltArea' => 'required', */
            'builtArea' => 'required|numeric|gt:0',
            'hr_surfaceArea' => 'required|numeric|gt:0',
            'hr_informationSource' => 'required',
            'ua_surfaceArea' => 'required|numeric|between:0,100',
            'ua_informationSource' => 'required',
            'pl_surfaceArea' => 'required|numeric|gt:0',
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
        return redirect()->route('form.index', ['section' => '<special-install></special-install>ations']);
    }

    protected function validationAttributes(): array
    {
        return [
            'saleableArea' => 'superficie vendible',
            'calculationBuiltArea' => 'cálculo de superficie construida',
            'builtArea' => 'superficie construida',
            'hr_surfaceArea' => ' ',
            'hr_informationSource' => ' ',
            'ua_surfaceArea' => ' ',
            'ua_informationSource' => ' ',
            'pl_surfaceArea' => ' ',
            'pl_informationSource' => ' ',
        ];
    }

    public function render()
    {
        return view('livewire.forms.applicable-surfaces');
    }
}
