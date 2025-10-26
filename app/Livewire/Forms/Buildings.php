<?php

namespace App\Livewire\Forms;

use App\Models\Forms\Building\BuildingModel;
use App\Models\Forms\Building\BuildingConstructionModel;
use Livewire\Component;
use App\Models\Valuations\Valuation;
use Illuminate\Support\Facades\Session;
use Masmerise\Toaster\Toaster;
use Flux\Flux;

class Buildings extends Component
{


    // Variable para saber si la clasificación ya fue asignada
    public bool $isClassificationAssigned;

    //Estos valores los usaremos para obtener el total de las superficies en privativas y comunes
    public float $totalSurfacePrivate;
    public float $totalSurfaceCommon;


    //Usaremos estos valores para asignar la cantidad de superficie accesoria y vendible y accesoria
    public float $totalSurfacePrivateVendible;
    public float $totalSurfacePrivateAccesoria;

    // Arrays públicos para consumir datos para los input select largos
    public array $construction_classification, $construction_use, $construction_source_information,
                 $construction_conservation_state, $construction_life_values;

    // Estado del tab activo
    public string $activeTab;

    //Generamos una variable para guardar la información del avaluo
    public $valuation;

    //Obtenemos el valor del building
    public $building;

    public $modalType; // 'privativa' o 'comun'
    public $constructionId;


    //Obtenemos los valores de las construcciones privativas y comunes
    public $buildingConstructionsCommon = [];
    public $buildingConstructionsPrivate = [];

    //Variables del tercer contenedor
    public $sourceReplacementObtained, $conservationStatus, $observationsStateConservation,
           $generalTypePropertiesZone, $generalClassProperty, $yearCompletedWork;



    /* public int $profitableUnitsSubject, $profitableUnitsGeneral, $profitableUnitsCondominiums,
        $numberSubjectLevels;

    public float  $progressGeneralWorks, $degreeProgressCommonAreas;
 */

    public $profitableUnitsSubject, $profitableUnitsGeneral, $profitableUnitsCondominiums,
           $numberSubjectLevels;

    public $progressGeneralWorks, $degreeProgressCommonAreas;


    //Variables para generar elementos en tablas, el valor type nos ayudará a saber en qué tabla renderizarse
    public $description, $clasification, $use, $sourceInformation, $conservationState, $surfaceVAD, $type;

    public int $buildingLevels, $levelsConstructionType, $age;

    public float $surface, $unitCostReplacement, $progressWork;


    // Valores para la asignación de los valores totales
    public $sumValuesTotalsPriv, $sumValuesTotalsCom;

    //Valores para la asignación de totales del apartado promedios y ponderaciones
    public $totalUsefulLifeProperty, $usefulLifeProperty, $ageProperty, $totalAgeProperty;



    public function mount(){
        //Inicializamos el valor de la pestaña que se abrirá por defecto
        $this->activeTab = 'privativas';

        //Obtenemos los datos para diferentes input select, desde el archivo de configuración properties_inputs
        $this->construction_classification = config('properties_inputs.construction_classification', []);
        $this->construction_use = config('properties_inputs.construction_use', []);
        $this->construction_source_information = config('properties_inputs.construction_source_information', []);
        $this->construction_conservation_state = config('properties_inputs.construction_conservation_state', []);
        $this->construction_life_values = config('properties_inputs.construction_life_values', []);



        //Obtenemos los valores deL avalúo a partir de la variable de sesión del ID
        $this->valuation = Valuation::find(session('valuation_id'));
        //dd($this->valuation);



        //Obtenemos el valor del building
        $this->building = BuildingModel::where('valuation_id', $this->valuation->id)->first();

        //Hacemos la asignación a los valores

        // Variables tercer contenedor
        $this->sourceReplacementObtained = $this->building->source_replacement_obtained;
        $this->conservationStatus = $this->building->conservation_status;
        $this->observationsStateConservation = $this->building->observations_state_conservation;
        $this->generalTypePropertiesZone = $this->building->general_type_properties_zone;
        $this->generalClassProperty = $this->building->general_class_property;
        $this->yearCompletedWork = $this->building->year_completed_work;

        // Variables enteras
        $this->profitableUnitsSubject = $this->building->profitable_units_subject;
        $this->profitableUnitsGeneral = $this->building->profitable_units_general;
        $this->profitableUnitsCondominiums = $this->building->profitable_units_condominiums;
        $this->numberSubjectLevels = $this->building->number_subject_levels;

        // Variables flotantes
        $this->progressGeneralWorks = $this->building->progress_general_works;
        $this->degreeProgressCommonAreas = $this->building->degree_progress_common_areas;

        //Obtenemos los valores para building construction tipo privadas
        /* $this->buildingConstructionsPrivate = $this->building->privates()->get(); */

        $this->loadPrivateConstructions();


        if (stripos($this->valuation->property_type, 'condominio') !== false) {
            //Obtenemos los valores para building construction tipo comun
            /* $this->buildingConstructionsCommon = $this->building->commons()->get(); */
            $this->loadCommonConstructions();
        }


        $this->assignInputPrivateValues();

        //dd($this->totalSurfacePrivate);



        //dd($this->buildingConstructionsPrivate);


        //Inicialización dato año de terminación
      /*   $this->yearCompletedWork = 2024;

        $this->progressGeneralWorks = 100; */


    }



    public function save(){

        $rules = [
            'sourceReplacementObtained' => 'required',
            'conservationStatus' => 'required',
            'observationsStateConservation' => 'required',
            'generalTypePropertiesZone' => 'required',
            'generalClassProperty' => 'required',
            'yearCompletedWork' => 'required',
            'profitableUnitsSubject' => 'required',
            'profitableUnitsGeneral' => 'required',
            'profitableUnitsCondominiums' => 'required',
            'numberSubjectLevels' => 'required',
            'progressGeneralWorks' => 'required',
            'degreeProgressCommonAreas' => 'required',
        ];

        if (stripos($this->valuation->property_type, 'condominio') !== false) {
            $rules = array_merge($rules, [
                'degreeProgressCommonAreas' => 'required',
            ]);
        }

        $this->validate(
            $rules,
            [],
            $this->validationAttributes()
        );


        $data = [
            'source_replacement_obtained' => $this->sourceReplacementObtained,
            'conservation_status' => $this->conservationStatus,
            'observations_state_conservation' => $this->observationsStateConservation,
            'general_type_properties_zone' => $this->generalTypePropertiesZone,
            'general_class_property' => $this->generalClassProperty,
            'year_completed_work' => $this->yearCompletedWork,
            'profitable_units_subject' => $this->profitableUnitsSubject,
            'profitable_units_general' => $this->profitableUnitsGeneral,
            'profitable_units_condominiums' => $this->profitableUnitsCondominiums,
            'number_subject_levels' => $this->numberSubjectLevels,
            'progress_general_works' => $this->progressGeneralWorks,

        ];

        if (stripos($this->valuation->property_type, 'condominio') !== false) {
            $data = array_merge($data, [
                'degree_progress_common_areas' => $this->degreeProgressCommonAreas,
            ]);
        }


        //Actualizamos los datos en la tabla
        $this->building->update($data);

        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'applicable-surfaces']);
    }


    //Funciones auxiliares para actualizar los valores de cada tabla
    public function loadPrivateConstructions()
    {
/*
        $this->buildingConstructionsPrivate = collect($this->building->privates()->get());


        $this->assignInputPrivateValues(); */


        $this->buildingConstructionsPrivate = $this->building->privates()->get();


        $this->assignInputPrivateValues();

        // Cálculo y asignación de la superficie total privada
        $this->totalSurfacePrivate = collect($this->buildingConstructionsPrivate)->sum('surface');



        // Subtotal para 'superficie vendible'
        $this->totalSurfacePrivateVendible = collect($this->buildingConstructionsPrivate)
            ->filter(fn($item) => $item->surface_vad === 'superficie vendible')
            ->sum('surface');

        // Subtotal para 'superficie accesoria'
        $this->totalSurfacePrivateAccesoria = collect($this->buildingConstructionsPrivate)
            ->filter(fn($item) => $item->surface_vad === 'superficie accesoria')
            ->sum('surface');

        //dd($this->totalSurfacePrivateVendible, $this->totalSurfacePrivateAccesoria);
    }

    public function loadCommonConstructions()
    {

        $this->buildingConstructionsCommon = $this->building->commons()->get();

        $this->totalSurfaceCommon = collect($this->buildingConstructionsCommon)->sum('surface');

    }






    //FUNCION PARA ACTUALIZAR VALORES DE INPUT A PARTIR DE PRIVATE CONSTRUCTIONS
    public function assignInputPrivateValues(){

        $constructions = collect($this->buildingConstructionsPrivate);

        // 1. Verificar si la colección está vacía
        if ($constructions->isEmpty()) {


            $this->isClassificationAssigned = false;

            // --- CASO A: COLECCIÓN VACÍA (Asignar Valores por Defecto) ---

            // Asignación de valores por defecto (ejemplo)
            $this->progressGeneralWorks = 100.0;
            $this->yearCompletedWork = date('Y'); // Año actual
            // ... Asigna aquí los demás inputs por defecto que necesites ...

        } else {

            $this->isClassificationAssigned = true;
            // --- CASO B: COLECCIÓN CON REGISTROS (Tomar el Primero y Calcular) ---

            $totalProgressWork = $constructions->sum('progress_work');

            // 2. OBTENER LA CANTIDAD DE REGISTROS
            $numberOfConstructions = $constructions->count();

          $this->progressGeneralWorks = $totalProgressWork / $numberOfConstructions;

            // 2. Tomar el primer registro
            $firstConstruction = $constructions->first();

            //dd($firstConstruction);

            // 3. Asignar/Calcular valores a los inputs

            // a) Asignación directa desde el primer registro (ejemplo)
           /*  $this->sourceReplacementObtained = $firstConstruction->source_information;
            $this->conservationStatus = $firstConstruction->conservation_state; */

            // b) Cálculo basado en el primer registro (ejemplo)
            // Ejemplo de cálculo: Año de término = Año actual - Edad de la construcción
            $this->yearCompletedWork = date('Y') - $firstConstruction->age;

            $this->generalClassProperty = $firstConstruction->clasification;

            // c) Podrías calcular totales aquí si quisieras:
            // $this->totalSurface = $this->buildingConstructionsPrivate->sum('surface');

            // ... Asigna aquí los demás inputs calculados o asignados ...
        }
    }




    //FUNCIONES PARA ELEMENTOS DE TABLAS

    public function openAddElement($type)
    {
        $this->modalType = $type;
        $this->resetValidation();
        $this->reset([
            'description',
            'clasification',
            'use',
            'sourceInformation',
            'conservationState',
            'surfaceVAD',
            'buildingLevels',
            'levelsConstructionType',
            'age',
            'surface',
            'unitCostReplacement',
            'progressWork',
           /*  'rangeBasedHeight', */
        ]);
        Flux::modal('add-element')->show();
    }



    public function openEditElement($constructionId)
    {

        $construction = BuildingConstructionModel::findOrFail($constructionId);


        $this->constructionId = $construction->id;
        $this->modalType = $construction->type;


        $this->description = $construction->description;
        $this->clasification = $construction->clasification;
        $this->use = $construction->use;
        $this->sourceInformation = $construction->source_information;
        $this->conservationState = $construction->conservation_state;
        $this->surfaceVAD = $construction->surface_vad;
        $this->buildingLevels = $construction->building_levels;
        $this->levelsConstructionType = $construction->levels_construction_type;
        $this->age = $construction->age;
        $this->surface = $construction->surface;
        $this->unitCostReplacement = $construction->unit_cost_replacement;
        $this->progressWork = $construction->progress_work;
       /*  $this->rangeBasedHeight = $construction->range_based_height; */



        $this->resetValidation();
        Flux::modal('edit-element')->show();

    }



    public function addElement()
    {
        $rules = [
            // Strings
            'description' => 'required',
            'clasification' => 'required',
            'use' => 'required',
            'sourceInformation' => 'required',
            'conservationState' => 'required',
            'surfaceVAD' => 'required',

            // Enteros
            'buildingLevels' => 'required|integer',
            'levelsConstructionType' => 'required|integer',
            'age' => 'required|integer',

            // Flotantes
            'surface' => 'required|numeric',
            'unitCostReplacement' => 'required|numeric',
            'progressWork' => 'required|numeric|min:0|max:100',

            // Booleano
            /* 'rangeBasedHeight' => 'required|boolean', */
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );

        $data = [
            // CLAVES: Relación y Tipo
            'building_id' => $this->building->id,
            'type' => $this->modalType,

            // Mapeo de variables públicas a columnas de la DB (snake_case)
            'description' => $this->description,
            'clasification' => $this->clasification,
            'use' => $this->use,
            'source_information' => $this->sourceInformation,
            'conservation_state' => $this->conservationState,
            'surface_vad' => $this->surfaceVAD,

            'building_levels' => $this->buildingLevels,
            'levels_construction_type' => $this->levelsConstructionType,
            'age' => $this->age,

            'surface' => $this->surface,
            'unit_cost_replacement' => $this->unitCostReplacement,
            'progress_work' => $this->progressWork,
            /* 'range_based_height' => (bool) $this->rangeBasedHeight, */
        ];

        //Guardamos la información en la base de datos
        BuildingConstructionModel::create($data);

        // Solo recarga la tabla que fue modificada, usando el tipo definido al abrir el modal.
        if ($this->modalType === 'private') {
            $this->loadPrivateConstructions();
        } elseif ($this->modalType === 'common') {
            $this->loadCommonConstructions();
        }

        //Reseteamos los valores para el próximo save
        $this->reset([
            'description',
            'clasification',
            'use',
            'sourceInformation',
            'conservationState',
            'surfaceVAD',
            'buildingLevels',
            'levelsConstructionType',
            'age',
            'surface',
            'unitCostReplacement',
            'progressWork',
            'modalType'
        ]);

        $this->loadPrivateConstructions();

        Toaster::success("Elemento creado con éxito");
        $this->modal('add-element')->close();
    }


    public function editElement()
    {
        //dd($this->constructionId);
        $rules = [
            // Strings
            'description' => 'required',
            'clasification' => 'required',
            'use' => 'required',
            'sourceInformation' => 'required',
            'conservationState' => 'required',
            'surfaceVAD' => 'required',

            // Enteros
            'buildingLevels' => 'required|integer',
            'levelsConstructionType' => 'required|integer',
            'age' => 'required|integer',

            // Flotantes
            'surface' => 'required|numeric',
            'unitCostReplacement' => 'required|numeric',
            'progressWork' => 'required|numeric',

            // Booleano
            /* 'rangeBasedHeight' => 'required|boolean', */
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );




        $data = [
            /* 'building_id' => $buildingConstruction->id, */
            //'type' => $this->modalType,

            'description' => $this->description,
            'clasification' => $this->clasification,
            'use' => $this->use,
            'source_information' => $this->sourceInformation,
            'conservation_state' => $this->conservationState,
            'surface_vad' => $this->surfaceVAD,
            'building_levels' => $this->buildingLevels,
            'levels_construction_type' => $this->levelsConstructionType,
            'age' => $this->age,
            'surface' => $this->surface,
            'unit_cost_replacement' => $this->unitCostReplacement,
            'progress_work' => $this->progressWork,
            /* 'range_based_height' => (bool) $this->rangeBasedHeight, */
        ];

        $buildingConstruction = BuildingConstructionModel::find($this->constructionId);

        $buildingConstruction->update($data);

        if ($this->modalType === 'private') {
            $this->loadPrivateConstructions();
        } elseif ($this->modalType === 'common') {
            $this->loadCommonConstructions();
        }

        $this->reset([
            'description',
            'clasification',
            'use',
            'sourceInformation',
            'conservationState',
            'surfaceVAD',
            'buildingLevels',
            'levelsConstructionType',
            'age',
            'surface',
            'unitCostReplacement',
            'progressWork',
            'constructionId',
            'modalType'
        ]);

        Toaster::success("Elemento editado con éxito");
        $this->modal('edit-element')->close();
    }


    public function deleteElement($constructionId){


        $construction = BuildingConstructionModel::findOrFail($constructionId);

        // Obtenemos el tipo antes de que se elimine el registro.
        $type = $construction->type;

        $construction->delete();

        // Recarga de la tabla dependiendo del tipo
        if ($type === 'private') {
            $this->loadPrivateConstructions();
        } elseif ($type === 'common') {
            $this->loadCommonConstructions();
        }

        Toaster::error("Elemento eliminado con éxito");
    }







    // Método para cambiar de tab
    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }



    //Función para convertir valores a enteros
    private function sanitizeInteger($value): int
    {
        // Si el valor es nulo o una cadena vacía, se retorna 0
        if ($value === null || trim((string)$value) === '') {
            return 0;
        }

        // Elimina cualquier carácter que no sea un número
        // Esto remueve signos +, - y otros símbolos no numéricos
        $clean = preg_replace('/[^0-9]/', '', (string)$value);

        // Convierte el resultado a entero
        return (int) $clean;
    }

    public function updatedProfitableUnitsSubject($value){
        $this->profitableUnitsSubject = $this->sanitizeInteger($value);
    }

    public function updatedProfitableUnitsGeneral($value){
        $this->profitableUnitsGeneral = $this->sanitizeInteger($value);
    }

    public function updatedProfitableUnitsCondominiums($value){
        $this->profitableUnitsCondominiums = $this->sanitizeInteger($value);
    }

    public function updatedNumberSubjectLevels($value){
        $this->numberSubjectLevels = $this->sanitizeInteger($value);
    }





    protected function validationAttributes(): array
    {
        return [
            'sourceReplacementObtained' => 'fuente donde se obtuvo el valor',
            'conservationStatus' => 'estado de conservación',
            'observationsStateConservation' => 'observaciones al estado',
            'generalTypePropertiesZone' => 'clase general de los inmuebles',
            'generalClassProperty' => 'clase general del inmueble',
            'yearCompletedWork' => 'año terminacion de la obra',
            'profitableUnitsSubject' => 'unidades rentables (sujeto)',
            'profitableUnitsGeneral' => 'unidades rentables (general)',
            'profitableUnitsCondominiums' => 'unidades rentables (condominios)',
            'numberSubjectLevels' => 'número de niveles del sujeto',
            'progressGeneralWorks' => '% avance de obra general',
            'degreeProgressCommonAreas' => '% avance de áreas comunes',
        ];
    }


    protected function validationAttributesItems(): array
    {
        return [
            // Strings
            'description' => 'descripción',
            'clasification' => 'clasificacion',
            'use' => 'uso',
            'sourceInformation' => 'fuente de información',
            'conservationState' => 'estado de conservación',
            'surfaceVAD' => ' ',

            // Enteros
            'buildingLevels' => ' ',
            'levelsConstructionType' => ' ',
            'age' => ' ',

            // Flotantes
            'surface' => ' ',
            'unitCostReplacement' => ' ',
            'progressWork' => ' ',

            // Booleano
            /* 'rangeBasedHeight' => ' ', */
        ];
    }

    public function render()
    {
        return view('livewire.forms.buildings');
    }
}
