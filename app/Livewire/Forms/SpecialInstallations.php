<?php

namespace App\Livewire\Forms;

use App\Models\Forms\Specialnstallation\SpecialInstallationModel;
use Livewire\Component;
use App\Models\Valuations\Valuation;
use Illuminate\Support\Facades\Session;
use Masmerise\Toaster\Toaster;
use Flux\Flux;

class SpecialInstallations extends Component
{

    //Variable que guardará el valor del elemento a editar
    public $specialInstallationId;

    //Propiedades para input select tipo tabla
    public array $select_SI, $select_AE, $select_CW,
                 $select_units,
                 $select_conservation_factor;


    // Estado del tab activo
    public string $activeTab;

    //Generamos una variable para guardar la información del avaluo
    public $valuation;

    public $elementId;

    //Generamos diferentes variables para obtener los datos de cada una de las tablas
    public $privateInstallations = [];
    public $privateAccessories = [];
    public $privateWorks = [];

    public $commonInstallations = [];
    public $commonAccessories = [];
    public $commonWorks = [];

    //Variables para generar elementos en tablas
    public $key, $descriptionSI, $descriptionAE, $descriptionCW,
    $unit, $quantity, $age, $usefulLife, $newRepUnitCost, $ageFactor, $conservationFactor,
    $netRepUnitCost, $undivided, $amount;

    //Estas variables también son para asignar en la BD pero se asignan mediante la lógica del sistema
    public $classificationType, $elementType;

    public function mount()
    {

        //Obtenemos los valores para los input

        //valores para los input de instalaciones especiales
        $this->select_SI = config('properties_inputs.special_installations', []);
        $this->select_AE = config('properties_inputs.elements_accessories', []);
        $this->select_CW = config('properties_inputs.complementary_works', []);
        $this->select_units = config('properties_inputs.special_installations_unit', []);
        $this->select_conservation_factor = config('properties_inputs.special_installations_conservationFactor', []);


        //Inicializamos el valor de la pestaña que se abrirá por defecto
        $this->activeTab = 'privativas';

        //Obtenemos los valores deL avalúo a partir de la variable de sesión del ID
        $this->valuation = Valuation::find(Session::get('valuation_id'));

        //Obtenemos los valores de las tablas
        $this->privateInstallations = $this->valuation->privateInstallations;
        $this->privateAccessories = $this->valuation->privateAccessories;
        $this->privateWorks = $this->valuation->privateWorks;

        if (stripos($this->valuation->property_type, 'condominio') !== false) {
        $this->commonInstallations = $this->valuation->commonInstallations;
        $this->commonAccessories = $this->valuation->commonAccessories;
        $this->commonWorks = $this->valuation->commonWorks;
        }


        //dd($this->commonWorks);
    }



    //Función de modales para instalaciones especiales (privativas y comunes)
    public function openAddElement($classType,$elemType)
    {
        $this->classificationType =  $classType;
        $this->elementType = $elemType;
        $this->resetValidation();
        $this->resetModalsFields();
        Flux::modal('add-element')->show();
    }

    public function openEditElement($classType, $elemType, $elementId)
    {
        //dd($elementId);
        $this->elementId = $elementId;
        $this->classificationType =  $classType;
        $this->elementType = $elemType;

        $element = SpecialInstallationModel::findOrFail($elementId);

        $this->unit = $element->unit;
        $this->quantity = $element->quantity;
        $this->age = $element->age;
        $this->usefulLife = $element->useful_life;
        $this->newRepUnitCost = $element->new_rep_unit_cost;
        $this->ageFactor = $element->age_factor;
        $this->conservationFactor = $element->conservation_factor;
        $this->netRepUnitCost = $element->net_rep_unit_cost;
        $this->undivided = $element->undivided;
        $this->amount = $element->amount;

        $this->classificationType = $element->classification_type;
        $this->elementType = $element->element_type;

        if ($this->elementType === 'installations') {
            $this->descriptionSI = $element->key; // IE01, IE02, etc.
        } elseif ($this->elementType === 'accessories') {
            $this->descriptionAE = $element->key; // EA01, EA02, etc.
        } elseif ($this->elementType === 'works') {
            $this->descriptionCW = $element->key; // OC01, OC02, etc.
        }


        $this->resetValidation();
        Flux::modal('edit-element')->show();
    }


    public function addElement()
    {
        $rules = [
            // Campos de tipo string
            /* 'key' => 'required|string', */
            /* 'descriptionSI' => 'required|string', */
            'unit' => 'required|string',

            // Campos de tipo numérico (flotante) que deben ser mayores a 0
            'quantity' => 'nullable|numeric|gt:0',
            'age' => 'required|numeric|gt:0',
            'usefulLife' => 'required|numeric|gt:0',
            'newRepUnitCost' => 'required|numeric|gt:0',
            'ageFactor' => 'required|numeric|gt:0',
            'conservationFactor' => 'required|numeric|gt:0',
            'netRepUnitCost' => 'required|numeric|gt:0',
            'undivided' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ];

        // Lógica dinámica para la descripción y el mapeo del valor
        $selectedClave = null; // Variable temporal para guardar la clave elegida (Ej: 'IE01')
        $configArray = [];      // Variable temporal para guardar el array de configuración (Ej: $this->select_SI)

        if($this->elementType === 'installations'){
            $rules = array_merge($rules, [
                'descriptionSI'  => 'required',
            ]);
            $selectedClave = $this->descriptionSI;
            //Mapea el valor de la clave seleccionada y el array de búsqueda
            $configArray = $this->select_SI;

        }elseif($this->elementType === 'accessories'){
            $rules = array_merge($rules, [
                'descriptionAE'  => 'required',
            ]);
            $selectedClave = $this->descriptionAE;
            //Mapea el valor de la clave seleccionada y el array de búsqueda
            $configArray = $this->select_AE;

        }elseif($this->elementType === 'works'){
            $rules = array_merge($rules, [
                'descriptionCW'  => 'required',
            ]);
            $selectedClave = $this->descriptionCW;
            //Mapea el valor de la clave seleccionada y el array de búsqueda
            $configArray = $this->select_CW;

        }

        if ($selectedClave) {
            // Busca el elemento completo en el array de configuración usando la clave seleccionada.
            // Ejemplo: Busca 'IE01' en $this->select_SI y devuelve el array completo.
            $item = collect($configArray)->firstWhere('clave', $selectedClave);

            // 🔑 1. Asignamos la CLAVE (IE01) a la propiedad 'key' del modelo.
            $this->key = $selectedClave;

            // 🔑 2. Asignamos la DESCRIPCIÓN LARGA (Elevadores) a la variable que se va a persistir.
            // Si no encuentra la descripción, usa la clave como fallback (seguridad).
            $selectedDescriptionName = $item['descripcion'] ?? $selectedClave;
        }

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );


        $data = [
            'valuation_id' => Session::get('valuation_id'),
            'classification_type' => $this->classificationType,
            'element_type' => $this->elementType,

            // NO incluimos 'valuation_id', 'classification_type' ni 'element_type' ya que no deberían cambiar al editar
            'key' => $this->key,
            'description' => $selectedDescriptionName, // El valor que va a la BD
            'unit' => $this->unit,
            'quantity' => $this->quantity,
            'age' => $this->age,
            'useful_life' => $this->usefulLife,
            'new_rep_unit_cost' => $this->newRepUnitCost,
            'age_factor' => $this->ageFactor,
            'conservation_factor' => $this->conservationFactor,
            'net_rep_unit_cost' => $this->netRepUnitCost,
            'undivided' => $this->undivided,
            'amount' => $this->amount,
        ];

        SpecialInstallationModel::create($data);


        //Recargamos cada una de las tabla en específico
        if ($this->classificationType === 'private'){
            if($this->elementType === 'installations') $this->loadPrivateInstallations();
            if($this->elementType === 'accessories') $this->loadPrivateAccessories();
            if($this->elementType === 'works') $this->loadPrivateWorks();
        } elseif ($this->classificationType === 'common') {
            if ($this->elementType === 'installations') $this->loadCommonInstallations();
            if ($this->elementType === 'accessories') $this->loadCommonAccessories();
            if ($this->elementType === 'works') $this->loadCommonWorks();
        }

        //Resetamos los valores de los input del modal
        $this->resetModalsFields();
        $this->reset('classificationType', 'elementType');

        Toaster::success("Elemento creado con éxito");
        $this->modal('add-element')->close();


    }

    public function editElement()
    {

        $rules = [
            /* 'description' => 'required|string', */
            'unit' => 'required|string',

            // Campos de tipo numérico (flotante) que deben ser mayores a 0
            'quantity' => 'nullable|numeric|gt:0',
            'age' => 'required|numeric|gt:0',
            'usefulLife' => 'required|numeric|gt:0',
            'newRepUnitCost' => 'required|numeric|gt:0',
            'ageFactor' => 'required|numeric|gt:0',
            'conservationFactor' => 'required|numeric|gt:0',
            'netRepUnitCost' => 'required|numeric|gt:0',
            'undivided' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ];

        // Variables para mapeo de clave/descripción
        $selectedClave = null;
        $configArray = [];
        $selectedDescriptionName = null; // Inicializar aquí para usar en $data

        // Agrega la regla 'required' al campo de descripción activo y mapea las variables
        if ($this->elementType === 'installations') {
            $rules = array_merge($rules, ['descriptionSI' => 'required']);
            $selectedClave = $this->descriptionSI;
            $configArray = $this->select_SI;
        } elseif ($this->elementType === 'accessories') {
            $rules = array_merge($rules, ['descriptionAE' => 'required']);
            $selectedClave = $this->descriptionAE;
            $configArray = $this->select_AE;
        } elseif ($this->elementType === 'works') {
            $rules = array_merge($rules, ['descriptionCW' => 'required']);
            $selectedClave = $this->descriptionCW;
            $configArray = $this->select_CW;
        }

        //  EXTRACCIÓN Y MAPEAMENTO DE CLAVE/DESCRIPCIÓN ---
        if ($selectedClave) {
            $item = collect($configArray)->firstWhere('clave', $selectedClave);

            $this->key = $selectedClave;
            $selectedDescriptionName = $item['descripcion'] ?? $selectedClave;
        }


        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );



        $data = [
            // Excluimos 'valuation_id', 'classification_type' y 'element_type' ya que NO deben cambiar
            'key' => $this->key,
            'description' => $selectedDescriptionName, // El valor que va a la BD
            'unit' => $this->unit,
            'quantity' => $this->quantity,
            'age' => $this->age,
            'useful_life' => $this->usefulLife,
            'new_rep_unit_cost' => $this->newRepUnitCost,
            'age_factor' => $this->ageFactor,
            'conservation_factor' => $this->conservationFactor,
            'net_rep_unit_cost' => $this->netRepUnitCost,
            'undivided' => $this->undivided,
            'amount' => $this->amount,
        ];

        SpecialInstallationModel::find($this->elementId)->update($data);

        if ($this->classificationType === 'private') {
            if ($this->elementType === 'installations') $this->loadPrivateInstallations();
            if ($this->elementType === 'accessories') $this->loadPrivateAccessories();
            if ($this->elementType === 'works') $this->loadPrivateWorks();
        } elseif ($this->classificationType === 'common') {
            if ($this->elementType === 'installations') $this->loadCommonInstallations();
            if ($this->elementType === 'accessories') $this->loadCommonAccessories();
            if ($this->elementType === 'works') $this->loadCommonWorks();
        }

        // Limpiamos los campos y el ID
        $this->resetModalsFields();
        $this->specialInstallationId = null;
        $this->reset('classificationType', 'elementType');

        Toaster::success("Elemento editado con éxito");
        $this->modal('edit-element')->close();


    }

    public function deleteElement($classType, $elemType, $elementId)
    {

        $element = SpecialInstallationModel::findOrFail($elementId);
        //dd($elemType);
        $element->delete();

        if ($classType === 'private') {
            if ($elemType === 'installations') $this->loadPrivateInstallations();
            if ($elemType === 'accessories') $this->loadPrivateAccessories();
            if ($elemType === 'works') $this->loadPrivateWorks();
        } elseif ($classType === 'common') {
            if ($elemType === 'installations') $this->loadCommonInstallations();
            if ($elemType === 'accessories') $this->loadCommonAccessories();
            if ($elemType === 'works') $this->loadCommonWorks();
        }



        Toaster::error("Elemento eliminado con éxito");
    }







    //Método para cambiar de tab
    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }


    protected function validationAttributesItems(): array
    {
        return [
            'key' => 'clave',
            'descriptionSI' => 'descripción',
            'descriptionAE' => 'descripción',
            'descriptionCW' => 'descripción',
            'unit' => 'unidad',
            'quantity' => 'cantidad',
            'age' => 'edad',
            'usefulLife' => 'vida útil',
            'newRepUnitCost' => 'costo unit de rep nuevo',
            'ageFactor' => 'factor de edad',
            'conservationFactor' => 'factor de conservación',
            'netRepUnitCost' => 'costo unit de rep neto',
            'undivided' => 'indiviso',
            'amount' => 'importe',
        ];
    }

    public function resetModalsFields(){
        $this->reset([
            'key',
            'descriptionSI',
            'descriptionAE',
            'descriptionCW',
            'unit',
            'quantity',
            'age',
            'usefulLife',
            'newRepUnitCost',
            'ageFactor',
            'conservationFactor',
            'netRepUnitCost',
            'undivided',
            'amount',
        ]);
    }

    //Watcher para asignar el valor de descriptionSI
    public function updatedDescriptionSI($value)
    {

        if (in_array($value, ['IE12', 'IE18', 'IE09', 'IE01', 'IE05', 'IE16', 'IE04', 'IE03', 'IE02','IE13'])) {
            $this->usefulLife = 25;
        }

        if (in_array($value, ['IE10', 'IE17', 'IE15', 'IE07', 'IE08', 'IE06', 'IE11', 'IE14'])) {
            $this->usefulLife = 15;
        }

        if($value === 'IE19') $this->usefulLife = null;
    }


    public function updatedDescriptionAE($value){

        if (in_array($value, ['EA08', 'EA02', 'EA10', 'EA03', 'EA07'])) {
            $this->usefulLife = 15;
        }

        if (in_array($value, ['EA05', 'EA06', 'EA09', 'EA04'])) {
            $this->usefulLife = 25;
        }

        if ($value === 'EA11') $this->usefulLife = 10;
        if ($value === 'EA01') $this->usefulLife = 50;
        if ($value === 'EA12') $this->usefulLife = null;
    }


    public function updatedDescriptionCW($value){


        if (in_array($value, ['OC11', 'OC01', 'OC16', 'OC10', 'OC14', 'OC03', 'OC12'])) {
            $this->usefulLife = 90;
        }

        if (in_array($value, ['OC15', 'OC04', 'OC08'])) {
            $this->usefulLife = 70;
        }

        if (in_array($value, ['OC13', 'OC09', 'OC02'])) {
            $this->usefulLife = 25;
        }

        if (in_array($value, ['OC06', 'OC18', 'OC17'])) {
            $this->usefulLife = null;
        }

        if ($value === 'OC07') $this->usefulLife = 30;
        if ($value === 'OC05') $this->usefulLife = 50;

    }


    //Función carga de tablas privativas
    public function loadPrivateInstallations()
    {

        $this->privateInstallations = $this->valuation->privateInstallations()->get();
    }

    public function loadPrivateAccessories()
    {

        $this->privateAccessories = $this->valuation->privateAccessories()->get();
    }


    public function loadPrivateWorks()
    {

        $this->privateWorks = $this->valuation->privateWorks()->get();
    }



    //Función carga de tablas comunes
    public function loadCommonInstallations()
    {

        $this->commonInstallations = $this->valuation->commonInstallations()->get();
    }

    public function loadCommonAccessories()
    {

        $this->commonAccessories = $this->valuation->commonAccessories()->get();
    }


    public function loadCommonWorks()
    {

        $this->commonWorks = $this->valuation->commonWorks()->get();
    }




    public function render()
    {
        return view('livewire.forms.special-installations');
    }
}
