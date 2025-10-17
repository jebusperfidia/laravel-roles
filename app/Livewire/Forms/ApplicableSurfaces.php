<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Valuations\Valuation;
use App\Models\Forms\Building\BuildingModel;
use App\Models\Forms\Building\BuildingConstructionModel;
use App\Models\Forms\LandDetails\LandDetailsModel;
use App\Models\Forms\ApplicableSurface\ApplicableSurfaceModel;
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
    public array $elementApplyState = [];

    //Obtenemos el valor del terreno para los valores recomendados
    public $landDetail;

    //Generamos una variable para guardar el total de todas las superficies agregadas en terreno
    public $landSurfacesTotal;

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


    //Variables del único contenedor
    public $sourceSurfaceArea, $sourcePrivateLot, $sourcePrivateLotType, $sourceApplicableUndivided, $sourceProporcionalLand;

    public float $builtArea, $surfaceArea, $privateLot, $privateLotType, $applicableUndivided,
        $proporcionalLand, $surplusLandArea;

    public bool $calculationBuiltArea; // Variable para el checkbox cálculo de superficie construida

    //Obtenemos los valores de las superficies desde la BD
    public $applicableSurface;


    //Obtenemos el valor del tipo de propiedad
    public $propertyType;


    public function mount()
    {

        //Obtenemos el tipo de propiedad del avaluo para la asignación de campos condicionales
        $this->propertyType = Valuation::find(session('valuation_id'))->property_type;

        //Obtenemos el valor del landDetail para las sugerencias
        $this->landDetail = LandDetailsModel::find(session('valuation_id'));

        $this->landSurfacesTotal = $this->landDetail->landSurfaces()->sum('surface');

        //Asignamos el valor del checkbox de cálculo de terreno excedente
        $this->useExcessCalculation = $this->landDetail ? (bool) $this->landDetail->use_excess_calculation : false;

        //Obtenemos el valor del building para las construcciones
        $this->building = BuildingModel::where('valuation_id', session('valuation_id'))->first();

        //Obtenemos las construcciones privadas y comunes
        $this->buildingConstructionsPrivate = collect($this->building->privates()->get());

        $this->buildingConstructionsFilter = $this->buildingConstructionsPrivate->filter(function ($item) {
            // Hacemos el filtro robusto para obtener 'superficie vendible' o 'superficie accesoria'
            $type = strtolower(trim($item->surface_vad));
            return $type === 'superficie accesoria' || $type === 'superficie vendible';
        });


        // Recorremos la colección de construcciones filtradas.
        foreach ($this->buildingConstructionsFilter as $construction) {
            // Inicializamos el array Livewire:
            // El ID de la construcción es la clave.
            // El valor (0 o 1) se convierte a booleano (true/false) para el checkbox.
            $this->elementApplyState[$construction->id] = (bool) $construction->surface_apply;
        }


        $this->buildingConstructionsCommon = collect($this->building->commons()->get());


        // Cálculo y asignación de la superficie total privada
        $this->totalSurfacePrivate = collect($this->buildingConstructionsPrivate)->sum('surface');

        // Cálculo y asignación de la superficie total común
        $this->totalSurfaceCommon = collect($this->buildingConstructionsCommon)->sum('surface');

        // Subtotal para 'superficie vendible'
        $this->totalSurfacePrivateVendible = collect($this->buildingConstructionsPrivate)
            ->filter(fn($item) => $item->surface_vad === 'superficie vendible')
            ->sum('surface');

        // Subtotal para 'superficie accesoria'
        $this->totalSurfacePrivateAccesoria = collect($this->buildingConstructionsPrivate)
            ->filter(fn($item) => $item->surface_vad === 'superficie accesoria')
            ->sum('surface');




        // Inicializa las variables con los datos del archivo de configuración
        $this->construction_source_information = config('properties_inputs.construction_source_information');


        //Obtenemos los valores de las superficies desde la BD
        $this->applicableSurface = ApplicableSurfaceModel::where('valuation_id', session('valuation_id'))->first();

        if($this->applicableSurface){
            //$this->saleableArea = $this->applicableSurface->saleable_area;
            $this->calculationBuiltArea = $this->applicableSurface->calculation_built_area;

            // Ejecuta el cálculo inicial
           // $this->updateBuiltArea();

            //dd($this->calculationBuiltArea);
            $this->builtArea = $this->applicableSurface->built_area;
            $this->surfaceArea = $this->applicableSurface->surface_area;
            $this->privateLot = $this->applicableSurface->private_lot;
            $this->privateLotType = $this->applicableSurface->private_lot_type;
            $this->surplusLandArea = $this->applicableSurface->surplus_land_area;
            $this->applicableUndivided = $this->applicableSurface->applicable_undivided;
            $this->proporcionalLand = $this->applicableSurface->proporcional_land;
            $this->sourceSurfaceArea = $this->applicableSurface->source_surface_area;
            $this->sourcePrivateLot = $this->applicableSurface->source_private_lot;
            $this->sourcePrivateLotType = $this->applicableSurface->source_private_lot_type;
            $this->sourceApplicableUndivided = $this->applicableSurface->source_applicable_undivided;
            $this->sourceProporcionalLand = $this->applicableSurface->source_proporcional_land;



        } else {
            //$this->saleableArea = 0;
            $this->calculationBuiltArea = false;
            $this->builtArea = 0;
            $this->surfaceArea = 0;
            $this->privateLot = 0;
            $this->privateLotType = 0;
            $this->surplusLandArea = 0;
            $this->applicableUndivided = 0;
            $this->proporcionalLand = 0;

        }
    }



    public function save()
    {
        $rules = [
            //'saleableArea' => 'required|numeric',
            //'calculationBuiltArea' => 'required|numeric|gt:0',
            'builtArea' => 'required|numeric|min:0',

            'surfaceArea' => 'required|numeric|min:0',
            'sourceSurfaceArea' => 'required',


            'applicableUndivided' => 'required|numeric|between:0,100',
            'sourceApplicableUndivided' => 'required',

            'proporcionalLand' => 'required|numeric|gt:1',
            'sourceProporcionalLand' => 'required',

        ];


        if($this->useExcessCalculation){
            $rules = array_merge($rules, [
                'privateLot' => 'required|numeric|min:0',
                'sourcePrivateLot' => 'required',

                'privateLotType' => 'required|numeric|min:0',
                'sourcePrivateLotType' => 'required',

                'surplusLandArea' => 'required|numeric|min:0'
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
            // Campos de Superficies y Booleano
            //'saleable_area' => $this->saleableArea,
            'calculation_built_area' => $this->calculationBuiltArea, // El campo booleano que se guarda
            'built_area' => $this->builtArea,
            'surface_area' => $this->surfaceArea,

            // Campos Condicionales (nullable)
            'private_lot' => $this->privateLot,
            'private_lot_type' => $this->privateLotType,
            'surplus_land_area' => $this->surplusLandArea,

            // Campos de Indiviso y Terreno Proporcional
            'applicable_undivided' => $this->applicableUndivided,
            'proporcional_land' => $this->proporcionalLand,

            // Campos de Fuentes de Información
            'source_surface_area' => $this->sourceSurfaceArea,
            'source_private_lot' => $this->sourcePrivateLot,
            'source_private_lot_type' => $this->sourcePrivateLotType,
            'source_applicable_undivided' => $this->sourceApplicableUndivided,
            'source_proporcional_land' => $this->sourceProporcionalLand,
        ];

        ApplicableSurfaceModel::updateOrCreate(
            ['valuation_id' => session('valuation_id')],
            $data
        );


        // Actualizar la columna 'surface_apply' en building_constructions
        // El array $this->elementApplyState contiene [id_construccion => estado_checkbox]
        foreach ($this->elementApplyState as $constructionId => $applyState) {

            // 2. Buscar el registro de la construcción por su ID.
            // Usamos el ID que Livewire nos pasó como clave del array.
            $construction = BuildingConstructionModel::find($constructionId);

            // 3. Actualizar la columna 'surface_apply' con el estado del checkbox.
            // $applyState es un booleano (true/false) gracias a la reactividad de Livewire.
            if ($construction) {
                $construction->update([
                    'surface_apply' => $applyState, // Se guarda 1 (true) o 0 (false) en la BD.
                ]);
            }
        }


        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'special-installations']);
    }


    //FUNCIONES PARA IGUALAR LOS VALORES DE SUPERFICIE APLICABLES A LOS VALORES SUGERIDOS

    public function setSurfaceAreaToSuggested()
    {
        $this->surfaceArea = $this->landSurfacesTotal;
    }

    public function setPrivateLotToSuggested()
    {
        $this->privateLot = $this->landDetail->surface_private_lot;
    }

    public function setPrivateLotTypeToSuggested()
    {
        $this->privateLotType = $this->landDetail->surface_private_lot_type;
    }

    public function setApplicableUndividedToSuggested()
    {
        $this->applicableUndivided = $this->landDetail->undivided_only_condominium;
    }

    public function setProporcionalLandToSuggested()
    {
        $this->proporcionalLand = $this->landDetail->undivided_surface_land;
    }

    public function setSurplusLandAreaToSuggested()
    {
        $this->surplusLandArea = $this->landDetail->surplus_land_area;
    }






    //Creamos un watcher para validar asignar o no el valor de supercicie construida
    public function updatedCalculationBuiltArea($value){

        if($value){
            //Si el valor es false, dejamos el campo editable y no hacemos nada
            $this->updateBuiltArea();
        } else {
            return;
            //$this->builtArea = 0; // Reseteamos el valor a 0 o cualquier otro valor predeterminado
        }
    }

    public function updatedElementApplyState()
    {
        $this->updateBuiltArea();
    }





    public function updateBuiltArea()
    {
        // Si el checkbox principal NO está marcado (false),
        // el campo 'builtArea' debe ser editable, y Livewire no debe reescribirlo.
        if (!$this->calculationBuiltArea) {
            // No hacemos nada para respetar el valor manual.
            return;
        }

        $sum = 0.0;

        // Iterar sobre los elementos de la tabla
        foreach ($this->buildingConstructionsFilter as $item) {
            $itemId = $item->id;

            // 1. Verificar si el elemento está marcado en el array de estados
            // Usamos $this->elementApplyState[$itemId] ?? false para obtener el valor booleano
            $isApplied = $this->elementApplyState[$itemId] ?? false;

            // 2. Si está marcado (true), sumar su superficie
            if ($isApplied) {
                // Asegurarse de que el campo 'surface' sea tratado como un número (float)
                $sum += (float) $item->surface;
            }
        }

        // Asignar el total al campo de superficie construida (builtArea)
        $this->builtArea = $sum;
    }



    protected function validationAttributes(): array
    {
        return [
            //'saleableArea' => 'superficie vendible',
            'calculationBuiltArea' => 'cálculo de superficie construida',
            'builtArea' => 'superficie construida',

            'surfaceArea' => 'total del terreno',
            'sourceSurfaceArea' => 'fuente de información',
            'privateLot' => 'lote privativo',
            'sourcePrivateLot' => 'fuente de información',
            'privateLotType' => 'lote privativo tipo',
            'sourcePrivateLotType' => 'fuente de información',
            'applicableUndivided' => 'indiviso aplicable',
            'sourceApplicableUndivided' => 'fuente de información',
            'proporcionalLand' => 'terreno proporcional',
            'sourceProporcionalLand' => 'fuente de información',
            'surplusLandArea' => 'sup. terreno excedente',
        ];
    }

    public function render()
    {
        return view('livewire.forms.applicable-surfaces');
    }
}
