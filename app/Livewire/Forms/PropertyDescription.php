<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;

class PropertyDescription extends Component
{
    public $submitted = false;      // ← Arranca en false

    //Valor para obtener datos de archivo de configuración
    public $usages;
  /*   public $selectedClave = ''; */

    //Variables del contenedor
    public $urbanProximity, $actualUse, $multipleUseSpace, $projectQuality;

    public int $levelBuilding;

    public function mount()
    {
        // Carga la configuración
        $this->usages = config('properties_inputs.proximity_urban_reference', []);

        /* $this->urbanProximity = '2'; */

        $this->resetErrorBag();
    }

    public function save()
    {

        $this->resetValidation('urbanProximity');

        $rules = [
            "urbanProximity" => 'required',
            "actualUse" => 'required',
            "multipleUseSpace" => 'required',
            "projectQuality" => 'required',
            "levelBuilding" => 'required'
           /*  "longitud" => 'required',
            "altitud" => 'required', */
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


        Toaster::success('Datos guardados con éxito');
    }

    public function updatedLevelBuilding($value)
    {
        if ($value === null) {
            $this->levelBuilding = 0;
            return;
        }
        $this->levelBuilding = $this->sanitizeDecimal($value);
       /*  $this->calculateLandCoefficientArea(); */
    }


    private function sanitizeDecimal(int $value): int
    {
        // 1. Quitar caracteres que no sean dígito o punto
        $clean = preg_replace('/[^0-9.]/', '', $value);

        /*  // 2. Si hay más de un punto, mantener solo el primero
        $parts = explode('.', $clean);
        if (count($parts) > 1) {
            $clean = $parts[0] . '.' . implode('', array_slice($parts, 1));
        } */

        return $clean;
    }

    protected function validationAttributes(): array
    {
        return [
            "urbanProximity" => 'Referencia de proximidad urbana',
            "actualUse" => 'Uso actual',
            "multipleUseSpace" => 'Espacio de uso múltiple',
            "projectQuality" => 'Calidad de proyecto',
            "levelBuilding" => 'Nivel en edificio (condominio)'
        ];

    }


    public function render()
    {
        return view('livewire.forms.property-description');
    }
}
