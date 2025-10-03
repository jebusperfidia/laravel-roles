<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Valuations\Valuation;
use Illuminate\Support\Facades\Session;
use Masmerise\Toaster\Toaster;
use Flux\Flux;

class Buildings extends Component
{



    // Arrays públicos para consumir datos para los input select largos
    public array $construction_classification, $construction_use, $construction_source_information,
                 $construction_conservation_state;

    // Estado del tab activo
    public string $activeTab;

    //Generamos una variable para guardar la información del avaluo
    public $valuation;

    //Variables del tercer contenedor
    public $sourceReplacementObtained, $conservationStatus, $observationsStateConservation,
           $generalTypePropertiesZone, $generalClassProperty, $yearCompletedWork;

    public int $profitableUnitsSubject, $profitableUnitsGeneral, $profitableUnitsCondominiums,
           $numberSubjectLevels;

    public float  $progressGeneralWorks, $degreeProgressCommonAreas;


    //Variables para generar elementos en tablas
    public $description, $clasification, $use, $sourceInformation, $conservationState, $surfaceVAD;

    public int $buildingLevels, $levelsConstructionType, $age;

    public float $surface, $unitCostReplacement, $progressWork;

    public bool $rangeBasedHeight;


    public function mount(){
        //Inicializamos el valor de la pestaña que se abrirá por defecto
        $this->activeTab = 'privativas';

        //Obtenemos los valores deL avalúo a partir de la variable de sesión del ID
        $this->valuation = Valuation::find(Session::get('valuation_id'));

        //Inicialización dato año de terminación
        $this->yearCompletedWork = 2024;

        $this->progressGeneralWorks = 100;



        //Obtenemos los datos para diferentes input select, desde el archivo de configuración properties_inputs
        $this->construction_classification = config('properties_inputs.construction_classification', []);
        $this->construction_use = config('properties_inputs.construction_use', []);
        $this->construction_source_information = config('properties_inputs.construction_source_information', []);
        $this->construction_conservation_state = config('properties_inputs.construction_conservation_state', []);
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


        $this->validate(
            $rules,
            [],
            $this->validationAttributes()
        );
    }




    //FUNCIONES PARA ELEMENTOS DE TABLAS

    public function openAddElement()
    {
        $this->resetValidation();
        Flux::modal('add-element')->show();      // 3) Abre el modal
    }

    public function openEditElement()
    {
        $this->resetValidation();
        Flux::modal('edit-element')->show();      // 3) Abre el modal

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
            'progressWork' => 'required|numeric',

            // Booleano
            /* 'rangeBasedHeight' => 'required|boolean', */
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );

        $this->description = '';
        $this->clasification = '';
        $this->use = '';
        $this->sourceInformation = '';
        $this->conservationState = '';
        $this->surfaceVAD = '';

        // Enteros
        $this->buildingLevels = 0;
        $this->levelsConstructionType = 0;
        $this->age = 0;

        // Flotantes
        $this->surface = 0;
        $this->unitCostReplacement = 0;
        $this->progressWork = 0;


        Toaster::error("Elemento creado con éxito");
        $this->modal('add-element')->close();
    }


    public function editElement()
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
            'progressWork' => 'required|numeric',

            // Booleano
            /* 'rangeBasedHeight' => 'required|boolean', */
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );

        $this->description = '';
        $this->clasification = '';
        $this->use = '';
        $this->sourceInformation = '';
        $this->conservationState = '';
        $this->surfaceVAD = '';

        // Enteros
        $this->buildingLevels = 0;
        $this->levelsConstructionType = 0;
        $this->age = 0;

        // Flotantes
        $this->surface = 0;
        $this->unitCostReplacement = 0;
        $this->progressWork = 0;

        Toaster::error("Elemento editado con éxito");
        $this->modal('edit-element')->close();
    }


    public function deleteElement(){
        Toaster::error("Elemento eliminado con éxito");
    }







    // Método para cambiar de tab
    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }




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
            'rangeBasedHeight' => ' ',
        ];
    }

    public function render()
    {
        return view('livewire.forms.buildings');
    }
}
