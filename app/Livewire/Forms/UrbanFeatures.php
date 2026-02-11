<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Validator;
use App\Models\Forms\UrbanFeatures\UrbanFeaturesModel;
use App\Traits\ValuationLockTrait;
use App\Models\Valuations\Valuation;



class UrbanFeatures extends Component
{
    use ValuationLockTrait;

    public $valuation_id;

    // Arrays públicos para consumir datos para los input select largos
    public array $zone_classification_input, $zone_saturation_index_input;


    //Variables primer contenedor
    public $cu_zoneClassification, $cu_predominantBuildings, $cu_zoneBuildingLevels, $cu_buildingUsage, $cu_zoneSaturationIndex,
        $cu_populationDensity, $cu_housingDensity, $cu_zoneSocioeconomicLevel, $cu_accessRoutesImportance, $cu_environmentalPollution;

    public bool $inf_allServices = false;

    //Variables segundo contenedor
    public $inf_waterDistribution, $inf_wastewaterCollection, $inf_streetStormDrainage, $inf_zoneStormDrainage,
        $inf_mixedDrainageSystem, $inf_otherWaterDisposal, $inf_electricSupply, $inf_electricalConnection, $inf_publicLighting,
        $inf_naturalGas, $inf_security, $inf_garbageCollection, $inf_garbageCollectionFrecuency, $inf_telephoneService, $inf_telephoneConnection,
        $inf_roadSignage, $inf_streetNaming, $inf_roadways, $inf_roadwaysMts, $inf_roadwaysOthers, $inf_sidewalks, $inf_sidewalksMts, $inf_sidewalksOthers, $inf_curbs, $inf_curbsMts, $inf_curbsOthers;

    //Variables tercer contenedor
    public $luse_landUse, $luse_descriptionSourceLand;
    public float $luse_mandatoryFreeArea, $luse_allowedLevels, $luse_landCoefficientArea;

    public function mount()
    {

        //Obtenemos los datos para diferentes input select, desde el archivo de configuración properties_inputs
        $this->zone_classification_input = config('properties_inputs.zone_classification', []);
        $this->zone_saturation_index_input = config('properties_inputs.zone_saturation_index', []);

        $valuationId = session('valuation_id');
        // Guardar el valuationId en una propiedad pública
        $this->valuation_id = $valuationId;

        $valuation = Valuation::find($valuationId);

        if (!$valuation) return;

        $this->checkReadOnlyStatus($valuation);

        // Asignar el modelo solo si valuationId existe para evitar errores
        $urbanFeatures = UrbanFeaturesModel::where('valuation_id', $valuationId)->first();

        if ($urbanFeatures) {
            // Variables primer contenedor (cu_)
            $this->cu_zoneClassification = $urbanFeatures->zone_classification;
            $this->cu_predominantBuildings = $urbanFeatures->predominant_buildings;
            $this->cu_zoneBuildingLevels = $urbanFeatures->zone_building_levels;
            $this->cu_buildingUsage = $urbanFeatures->building_usage;
            $this->cu_zoneSaturationIndex = $urbanFeatures->zone_saturation_index;
            $this->cu_populationDensity = $urbanFeatures->population_density;
            $this->cu_housingDensity = $urbanFeatures->housing_density;
            $this->cu_zoneSocioeconomicLevel = $urbanFeatures->zone_socioeconomic_level;
            $this->cu_accessRoutesImportance = $urbanFeatures->access_routes_importance;
            $this->cu_environmentalPollution = $urbanFeatures->environmental_pollution;

            // Variables segundo contenedor (inf_)
            //$this->inf_allServices = $urbanFeatures->allServices ?? false;
            $this->inf_waterDistribution = $urbanFeatures->water_distribution;
            $this->inf_wastewaterCollection = $urbanFeatures->wastewater_collection;
            $this->inf_streetStormDrainage = $urbanFeatures->street_storm_drainage;
            $this->inf_zoneStormDrainage = $urbanFeatures->zone_storm_drainage;
            $this->inf_mixedDrainageSystem = $urbanFeatures->mixed_drainage_system;
            $this->inf_otherWaterDisposal = $urbanFeatures->other_water_disposal;
            $this->inf_electricSupply = $urbanFeatures->electric_supply;
            $this->inf_electricalConnection = $urbanFeatures->electrical_connection;
            $this->inf_publicLighting = $urbanFeatures->public_lighting;
            $this->inf_naturalGas = $urbanFeatures->natural_gas;
            $this->inf_security = $urbanFeatures->security;
            $this->inf_garbageCollection = $urbanFeatures->garbage_collection;
            $this->inf_garbageCollectionFrecuency = $urbanFeatures->garbage_collection_frecuency;
            $this->inf_telephoneService = $urbanFeatures->telephone_service;
            $this->inf_telephoneConnection = $urbanFeatures->telephone_connection;
            $this->inf_roadSignage = $urbanFeatures->road_signage;
            $this->inf_streetNaming = $urbanFeatures->street_naming;
            $this->inf_roadways = $urbanFeatures->roadways;
            $this->inf_roadwaysMts = $urbanFeatures->roadways_mts;
            $this->inf_roadwaysOthers = $urbanFeatures->roadways_others;
            $this->inf_sidewalks = $urbanFeatures->sidewalks;
            $this->inf_sidewalksMts = $urbanFeatures->sidewalks_mts;
            $this->inf_sidewalksOthers = $urbanFeatures->sidewalks_others;
            $this->inf_curbs = $urbanFeatures->curbs;
            $this->inf_curbsMts = $urbanFeatures->curbs_mts;
            $this->inf_curbsOthers = $urbanFeatures->curbs_others;

            // Variables tercer contenedor (luse_)
            $this->luse_landUse = $urbanFeatures->land_use;
            $this->luse_descriptionSourceLand = $urbanFeatures->description_source_land;

            //
            $this->luse_mandatoryFreeArea = $urbanFeatures->mandatory_free_area;

            $this->luse_allowedLevels = $urbanFeatures->allowed_levels;

            //
            $this->luse_landCoefficientArea = $urbanFeatures->land_coefficient_area;

        } else {
            //Primer contenedor
            $this->inf_waterDistribution = 2;
            $this->inf_wastewaterCollection = 3;
            $this->inf_streetStormDrainage = 2;
            $this->inf_zoneStormDrainage = 2;
            $this->inf_mixedDrainageSystem = 2;
            $this->inf_otherWaterDisposal = 2;
            $this->inf_electricSupply = 1;
            $this->inf_electricalConnection = 2;
            $this->inf_publicLighting = 1;
            $this->inf_naturalGas = 3;
            $this->inf_security = 3;
            $this->inf_garbageCollection = 2;
            //Se inicializa la variable condicional
            $this->inf_garbageCollectionFrecuency = 0;
            $this->inf_telephoneService = 3;
            $this->inf_telephoneConnection = 2;
            $this->inf_roadSignage = 2;
            $this->inf_streetNaming = 2;

            //Apartado tabla segundo contenedor
            $this->inf_roadways = '1. Terraceria';
            $this->inf_roadwaysOthers = "";
            $this->inf_roadwaysMts = 0;
            $this->inf_sidewalks = '5. No presenta';
            $this->inf_sidewalksOthers = "";
            $this->inf_sidewalksMts = 0;
            $this->inf_curbs = '3. No existe';
            $this->inf_curbsOthers = "";
            $this->inf_curbsMts = 0;

            //Variables tercer contenedor:
            $this->luse_mandatoryFreeArea = 0;
            $this->luse_allowedLevels = 0;
            $this->luse_landCoefficientArea = 0;
        }




    }

    public function save()
    {
        $this->ensureNotReadOnly();

        //Ejecutar función con todas las reglas de validación y validaciones condicionales, guardando todo en una variable
        $validator = $this->validateAllContainers();

        //dd($validator);

        //Comprobamos si se obtuvieron errores de validación
        if ($validator->fails()) {
            //Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            //Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            //Hacemos un return para detener el flujo del sistema
            return;
        }

        // Mapea las propiedades del componente a un array con nombres de columnas de la DB
        $data = [
            'valuation_id' => $this->valuation_id,

            // Variables primer contenedor (cu_)
            'zone_classification' => $this->cu_zoneClassification,
            'predominant_buildings' => $this->cu_predominantBuildings,
            'zone_building_levels' => $this->cu_zoneBuildingLevels,
            'building_usage' => $this->cu_buildingUsage,
            'zone_saturation_index' => $this->cu_zoneSaturationIndex,
            'population_density' => $this->cu_populationDensity,
            'housing_density' => $this->cu_housingDensity,
            'zone_socioeconomic_level' => $this->cu_zoneSocioeconomicLevel,
            'access_routes_importance' => $this->cu_accessRoutesImportance,
            'environmental_pollution' => $this->cu_environmentalPollution,

            // Variables segundo contenedor (inf_)
            //'all_services' => $this->inf_allServices,
            'water_distribution' => $this->inf_waterDistribution,
            'wastewater_collection' => $this->inf_wastewaterCollection,
            'street_storm_drainage' => $this->inf_streetStormDrainage,
            'zone_storm_drainage' => $this->inf_zoneStormDrainage,
            'mixed_drainage_system' => $this->inf_mixedDrainageSystem,
            'other_water_disposal' => $this->inf_otherWaterDisposal,
            'electric_supply' => $this->inf_electricSupply,
            'electrical_connection' => $this->inf_electricalConnection,
            'public_lighting' => $this->inf_publicLighting,
            'natural_gas' => $this->inf_naturalGas,
            'security' => $this->inf_security,
            'garbage_collection' => $this->inf_garbageCollection,
            'garbage_collection_frecuency' => $this->inf_garbageCollectionFrecuency,
            'telephone_service' => $this->inf_telephoneService,
            'telephone_connection' => $this->inf_telephoneConnection,
            'road_signage' => $this->inf_roadSignage,
            'street_naming' => $this->inf_streetNaming,
            'roadways' => $this->inf_roadways,
            'roadways_mts' => $this->inf_roadwaysMts,
            'roadways_others' => $this->inf_roadwaysOthers,
            'sidewalks' => $this->inf_sidewalks,
            'sidewalks_mts' => $this->inf_sidewalksMts,
            'sidewalks_others' => $this->inf_sidewalksOthers,
            'curbs' => $this->inf_curbs,
            'curbs_mts' => $this->inf_curbsMts,
            'curbs_others' => $this->inf_curbsOthers,

            // Variables tercer contenedor (luse_)
            'land_use' => $this->luse_landUse,
            'description_source_land' => $this->luse_descriptionSourceLand,
            'mandatory_free_area' => $this->luse_mandatoryFreeArea,
            'allowed_levels' => $this->luse_allowedLevels,
            'land_coefficient_area' => $this->luse_landCoefficientArea,
        ];

        //dd($data);

        // Guardar o actualizar
        UrbanFeaturesModel::updateOrCreate(
            ['valuation_id' => $this->valuation_id],
            $data
        );

        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'urban-equipment']);
    }

    public function validateAllContainers()
    {
        $container1 = [
            'cu_zoneClassification'    => 'required',
            'cu_predominantBuildings'  => 'required',
            'cu_zoneBuildingLevels'    => 'required|numeric|gt:0',
            'cu_buildingUsage'         => 'required',
            'cu_zoneSaturationIndex'   => 'required',
            'cu_populationDensity'     => 'required',
            'cu_housingDensity'        => 'required',
            'cu_zoneSocioeconomicLevel' => 'required',
            'cu_accessRoutesImportance' => 'required',
            'cu_environmentalPollution' => 'required',
        ];

        $container2 = [
            /* 'inf_allServices'          => 'required|boolean', */
            'inf_waterDistribution'    => 'required',
            'inf_wastewaterCollection' => 'required',
            'inf_streetStormDrainage'  => 'required',
            'inf_zoneStormDrainage'    => 'required',
            'inf_mixedDrainageSystem'  => 'required',
            'inf_otherWaterDisposal'   => 'nullable',
            'inf_electricSupply'       => 'required',
            'inf_electricalConnection' => 'required',
            'inf_publicLighting'       => 'required',
            'inf_naturalGas'           => 'required',
            'inf_security'             => 'required',
            'inf_garbageCollection'    => 'required',

            //Este valor será condicional
            /* 'inf_garbageCollecFrequen' => 'nullable', */

            'inf_telephoneService'     => 'required',
            'inf_telephoneConnection'  => 'required',
            'inf_roadSignage'          => 'required',
            'inf_streetNaming'         => 'required',

            'inf_roadways'             => 'required',
            'inf_roadwaysMts'          => 'required|numeric|gte:0',
            'inf_sidewalks'            => 'required',
            'inf_sidewalksMts'         => 'required|numeric|gte:0',
            'inf_curbs'                => 'required',
            'inf_curbsMts'             => 'nullable|numeric|gte:0',
        ];

        //VALORES CONDICIONALES

        //valor de recolección de basura
        if ($this->inf_garbageCollection === '1') {
            $container2 = array_merge(
                $container2,
                ['inf_garbageCollectionFrecuency' => 'required|numeric|gt:0']
            );
        }

        if ($this->inf_roadways === '6. Otros') {
            $container2 = array_merge(
                $container2,
                ['inf_roadwaysOthers'  => 'required']
            );
        }

        if ($this->inf_sidewalks === '4. Otros') {
            $container2 = array_merge(
                $container2,
                ['inf_sidewalksOthers'  => 'required']
            );
        }

        if ($this->inf_curbs === '2. Otro') {
            $container2 = array_merge(
                $container2,
                ['inf_curbsOthers'   => 'required']
            );
        }


        $container3 = [
            'luse_landUse'               => 'required|string',
            'luse_descriptionSourceLand' => 'required|string',
            'luse_mandatoryFreeArea'     => 'required|numeric|gte:0',
            'luse_allowedLevels'         => 'required|numeric|gte:0',
            'luse_landCoefficientArea'   => 'required|numeric|gte:0',
        ];

        $rules = array_merge($container1, $container2, $container3);


        //Genereamos una variable para validar posteriormente si hay algún error de validación desde el método save
        return  Validator::make(
            $this->all(),
            //hacemos la validación final enviando 3 atributos, el primero las reglas
            //el segundo un atributo para no reemplazar los mensajes de validación
            //Y el tercero es para obtener los valores de los atributos traducidos
            $rules,
            [],
            $this->validationAttributes()
        );
    }


    /**
     * Elimina todo menos dígitos y un único punto decimal
     */
    private function sanitizeDecimal(?string $value): float
    {
        // Si el valor es nulo o una cadena vacía, se retorna 0.0
        if ($value === null || trim($value) === '') {
            return 0.0;
        }

        // Se reemplazan las comas por puntos para que PHP lo interprete como decimal
        $value = str_replace(',', '.', $value);

        // Se elimina cualquier carácter que no sea un número o un punto decimal.
        $clean = preg_replace('/[^0-9.]/', '', $value);

        // Se convierte el string limpio a un tipo flotante.
        return (float) $clean;
    }


    /**
     * Cada vez que cambie luse_mandatoryFreeArea:z
     *  - sanea el valor
     *  - recalcula el coeficiente
     */
    public function updatedLuseMandatoryFreeArea($value)
    {
        // Se sanea el valor de entrada y se asigna a la propiedad.
        // Se usa un casting (float) para garantizar que el valor sea un número.
        $this->luse_mandatoryFreeArea = (float) $this->sanitizeDecimal($value);
        // Se llama a la función para recalcular el coeficiente.
        $this->calculateLandCoefficientArea();
    }

    /**
     * Cada vez que cambie luse_allowedLevels:
     *  - sanea el valor
     *  - recalcula el coeficiente
     */
    public function updatedLuseAllowedLevels($value)
    {
        // Se sanea el valor de entrada y se asigna a la propiedad.
        // Se usa un casting (float) para garantizar que el valor sea un número.
        $this->luse_allowedLevels = (float) $this->sanitizeDecimal($value);
        // Se llama a la función para recalcular el coeficiente.
        $this->calculateLandCoefficientArea();
    }

    /**
     * Suma ambos campos y asigna el resultado
     */
    protected function calculateLandCoefficientArea(): void
    {
        // Los valores ya son flotantes gracias a los métodos `updated`.
        $a = $this->luse_mandatoryFreeArea;
        $b = $this->luse_allowedLevels;

        // Se realiza el cálculo y se asigna el resultado.
        $result = $b * (1 - ($a * 0.01));

        // Redondea el resultado a 2 decimales y lo asigna
        $this->luse_landCoefficientArea = round($result, 2);
    }


    //Watcher para asignar todos los servicios
    public function updatedInfAllServices($value)
    {
        if ($value === true) {
            /* dd('si funciona'); */
            $this->inf_waterDistribution = 1;
            $this->inf_wastewaterCollection = 1;
            $this->inf_streetStormDrainage = 1;
            $this->inf_zoneStormDrainage = 1;
            $this->inf_mixedDrainageSystem = 1;
            $this->inf_otherWaterDisposal = 2;
            $this->inf_electricSupply = 1;
            $this->inf_electricalConnection = 1;
            $this->inf_publicLighting = 2;
            $this->inf_naturalGas = 1;
            $this->inf_security = 1;
            $this->inf_garbageCollection = 1;
            $this->inf_garbageCollectionFrecuency = 1;
            $this->inf_telephoneService = 1;
            $this->inf_telephoneConnection = 1;
            $this->inf_roadSignage = 1;
            $this->inf_streetNaming = 1;

            $this->inf_allServices = false;
        }
    }


    // Watcher para Vialidades
    public function updatedInfRoadways($value)
    {
        if ($value === '7. No presenta') {
            $this->inf_roadwaysMts = 0;
        }
    }

    // Watcher para Banquetas
    public function updatedInfSidewalks($value)
    {
        if ($value === '5. No presenta') {
            $this->inf_sidewalksMts = 0;
        }
    }

    //  Watcher para Guarniciones
    public function updatedInfCurbs($value)
    {
        if ($value === '3. No existe') {
            $this->inf_curbsMts = 0;
        }
    }


    protected function validationAttributes(): array
    {
        return [
            // Contenedor 1: Zonificación y características del área
            'cu_zoneClassification'     => ' ',
            'cu_predominantBuildings'   => ' ',
            'cu_zoneBuildingLevels'     => ' ',
            'cu_buildingUsage'          => ' ',
            'cu_zoneSaturationIndex'    => ' ',
            'cu_populationDensity'      => ' ',
            'cu_housingDensity'         => ' ',
            'cu_zoneSocioeconomicLevel' => ' ',
            'cu_accessRoutesImportance' => ' ',
            'cu_environmentalPollution' => ' ',

            // Contenedor 2: Infraestructura y servicios
            'inf_allServices'           => ' ',
            'inf_waterDistribution'     => ' ',
            'inf_wastewaterCollection'  => ' ',
            'inf_streetStormDrainage'   => ' ',
            'inf_zoneStormDrainage'     => ' ',
            'inf_mixedDrainageSystem'   => ' ',
            'inf_otherWaterDisposal'    => ' ',
            'inf_electricSupply'        => ' ',
            'inf_electricalConnection'  => ' ',
            'inf_publicLighting'        => ' ',
            'inf_naturalGas'            => ' ',
            'inf_security'              => ' ',
            'inf_garbageCollection'     => ' ',
            'inf_garbageCollectionFrecuency' => ' ',
            'inf_telephoneService'      => ' ',
            'inf_telephoneConnection'   => ' ',
            'inf_roadSignage'           => ' ',
            'inf_streetNaming'          => ' ',
            'inf_roadways'              => ' ',
            'inf_roadwaysMts'           => ' ',
            'inf_roadwaysOthers'        => ' ',
            'inf_sidewalks'             => ' ',
            'inf_sidewalksMts'          => ' ',
            'inf_sidewalksOthers'       => ' ',
            'inf_curbs'                 => ' ',
            'inf_curbsMts'              => ' ',
            'inf_curbsOthers'           => ' ',

            // Contenedor 3: Uso de suelo y normativa
            'luse_landUse'               => ' ',
            'luse_descriptionSourceLand' => ' ',
            'luse_mandatoryFreeArea'     => ' ',
            'luse_allowedLevels'         => ' ',
            'luse_landCoefficientArea'   => ' ',

        ];
    }

    public function render()
    {
        return view('livewire.forms.urban-features');
    }
}
