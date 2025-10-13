<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Forms\Building\BuildingModel;
use App\Models\Forms\LandDetails\LandDetailsModel;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Validator;

class ApplicableSurfaces extends Component
{
    public $building; // Para acceder a las relaciones (debes pasarlo al componente)
    public $buildingConstructionsPrivate; // Colección de construcciones privativas
    public $buildingConstructionsCommon; // Colección de construcciones privativas

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

    //Obtenemos el valor del checkbox cálculo del terreno excedente
    public bool $useExcessCalculation;

    //Estos valores los usaremos para obtener el total de las superficies en privativas y comunes
    public float $totalSurfacePrivate;
    public float $totalSurfaceCommon;


    //Variable para filtrar solo los valores de superficie accesoria y vendible
    public $buildingConstructionsFilter;


    //Usaremos estos valores para asignar la cantidad de superficie accesoria y vendible y accesoria
    public float $totalSurfacePrivateVendible;
    public float $totalSurfacePrivateAccesoria;




    public function mount()
    {

        // Obtiene el valor de la columna directamente.
        // Si el registro no existe, optional() devuelve null,
        // y usamos el operador de fusión de null (??) para establecer un valor seguro por defecto (ej. false).
        //$this->useExcessCalculation = optional(LandDetailsModel::find($valuationId))->use_excess_calculation ?? false;
        $this->useExcessCalculation = LandDetailsModel::find(session('valuation_id'))->use_excess_calculation;
        //dd($this->useExcessCalculation);

        $this->building = BuildingModel::where('valuation_id', session('valuation_id'))->first();

        $this->buildingConstructionsPrivate = collect($this->building->privates()->get());

        $this->buildingConstructionsFilter = $this->buildingConstructionsPrivate->filter(function ($item) {
            $type = strtolower(trim($item->surface_vad)); // Hacemos el filtro robusto

            return $type === 'superficie accesoria' || $type === 'superficie vendible';
        });


        $this->buildingConstructionsCommon = collect($this->building->commons()->get());


        // ✅ Cálculo y asignación de la superficie total privada
        $this->totalSurfacePrivate = collect($this->buildingConstructionsPrivate)->sum('surface');

        $this->totalSurfaceCommon = collect($this->buildingConstructionsCommon)->sum('surface');

        // Subtotal para 'superficie vendible'
        $this->totalSurfacePrivateVendible = collect($this->buildingConstructionsPrivate)
            ->filter(fn($item) => $item->surface_vad === 'superficie vendible')
            ->sum('surface');

        // Subtotal para 'superficie accesoria'
        $this->totalSurfacePrivateAccesoria = collect($this->buildingConstructionsPrivate)
            ->filter(fn($item) => $item->surface_vad === 'superficie accesoria')
            ->sum('surface');

            //dd($this->totalSurfacePrivateVendible);
        $this->saleableArea = $this->totalSurfacePrivateVendible;


        // Inicializa las variables con los datos del archivo de configuración
        $this->construction_source_information = config('properties_inputs.construction_source_information');
/*
        $this->saleableArea = 100.00;
        $this->builtArea = 100.00;
        $this->hr_surfaceArea = 0.00;
        $this->ua_surfaceArea = 0.00;
        $this->pl_surfaceArea = 0.00; */
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
