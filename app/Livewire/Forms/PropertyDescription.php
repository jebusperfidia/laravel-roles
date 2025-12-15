<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;
use App\Models\Valuations\Valuation;
use App\Models\Forms\PropertyDescription\PropertyDescriptionModel;

class PropertyDescription extends Component
{

    public $valuationId;

    public $propertyType;

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

        //Recuperamos el id del avaluo desde la variable de sesión
        $this->valuationId = session('valuation_id');

        //Obtenemos el valor del tipo de propiedad para el renderizado y guardado condicional
        $this->propertyType = Valuation::where('id', $this->valuationId)->value('property_type');

        //Verificamos si existe algún registro en la base de datos
        $propertyDescription = PropertyDescriptionModel::where('valuation_id', $this->valuationId)->first();

        //Si existe algún registro previo en la base de datos, recuperamos los valores para mostrarlos en la vista
        if($propertyDescription){
            $this->urbanProximity = $propertyDescription->urban_proximity;
            $this->actualUse = $propertyDescription->actual_use;
            $this->multipleUseSpace = $propertyDescription->multiple_use_space;
            $this->projectQuality = $propertyDescription->project_quality;

        if (stripos($this->propertyType, 'condominio') !== false) {

            $this->levelBuilding = $propertyDescription->level_building;

            }
        }

    }

    public function save()
    {

        $this->resetValidation('urbanProximity');

        $rules = [
            "urbanProximity" => 'required',
            "actualUse" => 'required',
            "multipleUseSpace" => 'required',
            "projectQuality" => 'required',
        ];

        //Validaciones si la colonia no está listada
        if (stripos($this->propertyType, 'condominio') !== false) {
            $rules = array_merge($rules, [
                "levelBuilding" => 'required|integer|min:0',
            ]);
        }


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

        $data = [
            'urban_proximity' => $this->urbanProximity,
            'actual_use' => $this->actualUse,
            'multiple_use_space' => $this->multipleUseSpace,
            'project_quality' => $this->projectQuality,
         /*    'level_building' => $this->levelBuilding, */
        ];


        //Validaciones si la colonia no está listada
        if (stripos($this->propertyType, 'condominio') !== false) {
            $data = array_merge($data, [
           /*  'multiple_use_space' => $this->multipleUseSpace,
            'project_quality' => $this->projectQuality, */
            'level_building' => $this->levelBuilding,
            ]);
        }



        PropertyDescriptionModel::updateOrCreate(
            ['valuation_id' => $this->valuationId],
            $data
        );


        Toaster::success('Datos guardados con éxito');
        return redirect()->route('form.index', ['section' => 'construction-elements']);
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
