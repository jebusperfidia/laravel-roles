<?php

namespace App\Livewire\Forms;

use App\Models\Forms\LandDetails\LandDetailsModel;
use App\Models\Forms\SpecialInstallation\SpecialInstallationModel;
use App\Models\Forms\Building\BuildingModel;
use Livewire\Component;
use App\Models\Valuations\Valuation;
use Illuminate\Support\Facades\Session;
use Masmerise\Toaster\Toaster;
use Flux\Flux;
/* use Psy\Command\WhereamiCommand; */

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

    //Variable para obtener el valor del building, necesario para el dato de vida util total
    public $building;

    public $elementId;

    //Generamos diferentes variables para obtener los datos de cada una de las tablas
    public $privateInstallations = [];
    public $privateAccessories = [];
    public $privateWorks = [];

    public $commonInstallations = [];
    public $commonAccessories = [];
    public $commonWorks = [];

    //Generamos variables para obtener los importes totales de cada tabla
    public $subTotalPrivateInstallations = 0;
    public $subTotalPrivateAccessories = 0;
    public $subTotalPrivateWorks = 0;
    public $totalPrivateInstallations = 0;


    public $subTotalCommonInstallations = 0;
    public $subTotalCommonAccessories = 0;
    public $subTotalCommonWorks = 0;
    public $totalCommonInstallations = 0;

    //Finalmente generamos una variable para obtener el total del indiviso
    public float $totalCommonProportional = 0;

    //Variables para generar elementos en tablas
    public $key, $descriptionSI, $descriptionAE, $descriptionCW, $descriptionOther,
    $unit, $quantity, $age, $usefulLife, $newRepUnitCost, $ageFactor, $conservationFactor,
    $netRepUnitCost, $undivided, $amount;


    //Estas variables también son para asignar en la BD pero se asignan mediante la lógica del sistema
    public $classificationType, $elementType;

    //Asignamos el valor del indivso desde terreno:
    public $undividedOnlyCondominium;

    //Asignamos la vida util total del inmueble, desde construcciones (modelo building)
    public $usefulLifeProperty;


    public $construction_life_values;

    public function mount()
    {

        $this->construction_life_values = config('properties_inputs.construction_life_values', []);

        //Obtenemos la vida util total del inmueble

        //Primero obtenemos el valor general de building construction, apartir del id del avaluo de nuestra variable de sesión
        $this->building = BuildingModel::where('valuation_id', $this->valuation->id)->first();
        //dd($this->building);

        //Si existe registro en la base de datos, obtenemos el valor
        if($this->building) {

            //inicializamos internamente el valor del total
            $totalUsefulLifeProperty = 0;

            //Mediantel la variable de building, obtenemos el valor de todos los registros privativos
            //ligados al modelo, desde la tabla buildingConstruction
            $buildingConstructionsPrivate = $this->building->privates()->get();

            //dd($buildingConstructionsPrivate);

            //Generamos la suma del total de todas las superficies para el cálculo
            $totalSurfacePrivate = collect($buildingConstructionsPrivate)->sum('surface');

            //Recorremos todos los resultados obtenidos de buildingConstruction para generar la suma total
            foreach($buildingConstructionsPrivate as $item) {

                //Obtenemos el valor de la vida útll a partir de la combinación generada en el registro
                $claveCombinacion = $item->clasification . '_' . $item->use;
                //Del valor generado guardamos el valor de la vida útil total
                $vidaUtilTotal = $this->construction_life_values[$claveCombinacion] ?? 0;

                //Al total le sumamos el valor de la iteración, obtenido de la vida total * superficie
                $totalUsefulLifeProperty += ($vidaUtilTotal * $item->surface);
            }

            //Una que termina de iterar todos los elementos, generamos primero el total dividiendo este entre la superficie
            $this->usefulLifeProperty = $totalUsefulLifeProperty / $totalSurfacePrivate;

            //Al valor obtenido, generamos un redondeo para generar el valor total, 0.5 sube a 1, valores inferiores bajan a 0
            $this->usefulLifeProperty = round($this->usefulLifeProperty, 0);

            //dd($this->usefulLifeProperty);
        }


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

        //Obtenemos los valores de las tablas, así como los subtotales
        $this->privateInstallations = $this->valuation->privateInstallations;
        $this->subTotalPrivateInstallations = collect($this->privateInstallations)->sum('amount');

        $this->privateAccessories = $this->valuation->privateAccessories;
        $this->subTotalPrivateAccessories = collect($this->privateAccessories)->sum('amount');

        $this->privateWorks = $this->valuation->privateWorks;
        $this->subTotalPrivateWorks = collect($this->privateWorks)->sum('amount');

        //Finalmente, obtenemos el total de las instalaciones privativas
        $this->getTotalPrivateInstallations();

        if (stripos($this->valuation->property_type, 'condominio') !== false) {
        $this->commonInstallations = $this->valuation->commonInstallations;
        $this->subTotalCommonInstallations = collect($this->commonInstallations)->sum('amount');

        $this->commonAccessories = $this->valuation->commonAccessories;
        $this->subTotalCommonAccessories = collect($this->commonAccessories)->sum('amount');

        $this->commonWorks = $this->valuation->commonWorks;
        $this->subTotalCommonWorks = collect($this->commonWorks)->sum('amount');

        // Obtener el total proporcional del indiviso
        $this->getTotalCommonProportional();

        //Finalmente, obtenemos el total de las instalaciones comunes
        $this->getTotalCommonInstallations();

        //Obtenemos el valor del indiviso aplicado en terreno
        $this->undividedOnlyCondominium = LandDetailsModel::findOrFail(Session::get('valuation_id'))->undivided_only_condominium;


        //dd($this->undividedOnlyCondominium);

        }


        //dd($this->commonWorks);
    }

    public function nextComponent(){
        /* Toaster::success('Formulario guardado con éxito'); */
        return redirect()->route('form.index', ['section' => 'pre-appraisal-considerations']);
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
            $this->descriptionOther = $element->description_other;
        } elseif ($this->elementType === 'accessories') {
            $this->descriptionAE = $element->key; // EA01, EA02, etc.
            $this->descriptionOther = $element->description_other;
        } elseif ($this->elementType === 'works') {
            $this->descriptionCW = $element->key; // OC01, OC02, etc.
            $this->descriptionOther = $element->description_other;
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
            //'ageFactor' => 'required|numeric|gt:0',
            'conservationFactor' => 'required|numeric|gt:0',
            //'netRepUnitCost' => 'required|numeric|gt:0',

            //'undivided' => 'required|numeric|gt:0',

            //'amount' => 'required|numeric|gt:0',
        ];

        // Lógica dinámica para la descripción y el mapeo del valor
        $selectedClave = null; // Variable temporal para guardar la clave elegida (Ej: 'IE01')
        $configArray = [];      // Variable temporal para guardar el array de configuración (Ej: $this->select_SI)
        $selectedDescriptionName = null;

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


        // Estas claves (IE19, EA12, OC17) no tienen descripción predefinida,
        // así que se debe escribir una manualmente
        $manualKeys = ['IE19', 'EA12', 'OC17'];
        $isManualDescription = in_array($selectedClave, $manualKeys, true);


        // Si la clave requiere descripción manual, hacemos que 'descriptionOther' sea obligatoria.
        // Si no, simplemente la dejamos como opcional.
        if ($isManualDescription) {
            $rules['descriptionOther'] = 'required|string';
        } else {
            $rules['descriptionOther'] = 'nullable|string';
        }

        //Finalmente, si el valor de   classificationType es común, asignamos la validación
        if ($this->classificationType === 'common') {

            //$this->undividedOnlyCondominium = $this->undivided;
            $rules = array_merge($rules, [
                'undividedOnlyCondominium'  => 'required|numeric|between:0,100',
            ]);
        }

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );


        // Si no es una descripción manual, buscamos el texto del catálogo
        // (esto se salta para IE19, EA12, OC17)
        if ($selectedClave && !$isManualDescription) {
            $item = collect($configArray)->firstWhere('clave', $selectedClave);
            $selectedDescriptionName = $item['descripcion'] ?? $selectedClave;
        }


        $this->key = $selectedClave;

        /* if ($selectedClave) { */
            // Busca el elemento completo en el array de configuración usando la clave seleccionada.
            // Ejemplo: Busca 'IE01' en $this->select_SI y devuelve el array completo.
           /*  $item = collect($configArray)->firstWhere('clave', $selectedClave); */

            //  1. Asignamos la CLAVE (IE01) a la propiedad 'key' del modelo.
     /*        $this->key = $selectedClave; */



            //  2. Asignamos la DESCRIPCIÓN LARGA (Elevadores) a la variable que se va a persistir.
            // Si no encuentra la descripción, usa la clave como fallback (seguridad).
      /*       $selectedDescriptionName = $item['descripcion'] ?? $selectedClave;
        }
 */



        //Hacemos algunos cálculos para asignar valores a campos que no se ingresan directamente

        //Factor de edad
        $this->ageFactor = 1 - ((($this->age * 100) / $this->usefulLife) * 0.01);

        //Costo unitario de neto reposición
        $this->netRepUnitCost = $this->newRepUnitCost * $this->ageFactor;
        //dd($this->netRepUnitCost, $this->newRepUnitCost, $this->ageFactor);

        //Calcular el importe
        $this->amount = $this->netRepUnitCost * $this->quantity;

        $data = [
            'valuation_id' => Session::get('valuation_id'),
            'classification_type' => $this->classificationType,
            'element_type' => $this->elementType,

            // NO incluimos 'valuation_id', 'classification_type' ni 'element_type' ya que no deberían cambiar al editar
            'key' => $this->key,
            /*    'description' => $selectedDescriptionName,
            'description_other' => $this->descriptionOther, */

            // Si es manual → 'description' va null y se usa 'description_other'
            // Si no es manual → 'description_other' va null

            'description' => $isManualDescription ? null : $selectedDescriptionName,
            'description_other' => $isManualDescription ? $this->descriptionOther : null,


            'unit' => $this->unit,
            'quantity' => $this->quantity,
            'age' => $this->age,
            'useful_life' => $this->usefulLife,
            'new_rep_unit_cost' => $this->newRepUnitCost,
            'age_factor' => $this->ageFactor,
            'conservation_factor' => $this->conservationFactor,
            'net_rep_unit_cost' => $this->netRepUnitCost,
            'undivided' => $this->undividedOnlyCondominium,
            'amount' => $this->amount,
        ];

        //dd($data);

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
            //'ageFactor' => 'required|numeric|gt:0',
            'conservationFactor' => 'required|numeric|gt:0',
            //'netRepUnitCost' => 'required|numeric|gt:0',

            //'undivided' => 'required|numeric|gt:0',

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

        // Claves que requieren descripción manual
        $manualKeys = ['IE19', 'EA12', 'OC17'];
        $isManualDescription = in_array($selectedClave, $manualKeys, true);


        // Validación condicional
        if ($isManualDescription) {
            $rules['descriptionOther'] = 'required|string';
        } else {
            $rules['descriptionOther'] = 'nullable|string';
        }

        //  EXTRACCIÓN Y MAPEAMENTO DE CLAVE/DESCRIPCIÓN ---
       /*  if ($selectedClave) {
            $item = collect($configArray)->firstWhere('clave', $selectedClave);

            $this->key = $selectedClave;
            $selectedDescriptionName = $item['descripcion'] ?? $selectedClave;
        }
 */
        //Finalmente, si el valor de   classificationType es común, asignamos la validación
        if ($this->classificationType === 'common') {
            $rules = array_merge($rules, [
                'undivided'  => 'required|numeric|between:0,100',
            ]);
        }

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );

        //Factor de edad
        $this->ageFactor = 1 - ((($this->age * 100) / $this->usefulLife) * 0.01);

        //Costo unitario de neto reposición
        $this->netRepUnitCost = $this->newRepUnitCost * $this->ageFactor;
        //dd($this->netRepUnitCost, $this->newRepUnitCost, $this->ageFactor);

        //Calcular el importe
        $this->amount = $this->netRepUnitCost * $this->quantity;



        // Asignamos la clave y la descripción correcta para el guardado
        if ($selectedClave) {
            $this->key = $selectedClave;

            if (!$isManualDescription) {
                // Para claves normales, obtenemos la descripción del catálogo
                $item = collect($configArray)->firstWhere('clave', $selectedClave);
                $selectedDescriptionName = $item['descripcion'] ?? $selectedClave;
            } else {
                // Para claves manuales, description se deja null
                $selectedDescriptionName = null;
            }
        }

        $data = [
            // Excluimos 'valuation_id', 'classification_type' y 'element_type' ya que NO deben cambiar
            'key' => $this->key,
            'description' => $selectedDescriptionName, // El valor que va a la BD
            'description_other' => $isManualDescription ? $this->descriptionOther : null,
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
            'descriptionOther',
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
            $this->usefulLife = $this->usefulLifeProperty;
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
        //Obtenemos nuevamente los valores para renderizarlos en la tabla en específico
        $this->privateInstallations = $this->valuation->privateInstallations()->get();

        //Una vez que tenemos los datos, los sumamos para obtener el subtotal
        $this->subTotalPrivateInstallations = collect($this->privateInstallations)->sum('amount');

        //Finalmente, obtenemos el total de las instalaciones privativas
        $this->getTotalPrivateInstallations();
    }

    public function loadPrivateAccessories()
    {

        $this->privateAccessories = $this->valuation->privateAccessories()->get();

        $this->subTotalPrivateAccessories = collect($this->privateAccessories)->sum('amount');

        $this->getTotalPrivateInstallations();
    }


    public function loadPrivateWorks()
    {

        $this->privateWorks = $this->valuation->privateWorks()->get();

        $this->subTotalPrivateWorks = collect($this->privateWorks)->sum('amount');

        $this->getTotalPrivateInstallations();
    }



    //Función carga de tablas comunes
    public function loadCommonInstallations()
    {

        $this->commonInstallations = $this->valuation->commonInstallations()->get();
        $this->subTotalCommonInstallations = collect($this->commonInstallations)->sum('amount');
        $this->getTotalCommonInstallations();
        //En cada actualización, usaremos esta función para obtener el total proporcional del indiviso actualizado
        $this->getTotalCommonProportional();
    }

    public function loadCommonAccessories()
    {

        $this->commonAccessories = $this->valuation->commonAccessories()->get();
        $this->subTotalCommonAccessories = collect($this->commonAccessories)->sum('amount');
        $this->getTotalCommonInstallations();
        $this->getTotalCommonProportional();
    }


    public function loadCommonWorks()
    {

        $this->commonWorks = $this->valuation->commonWorks()->get();
        $this->subTotalCommonWorks = collect($this->commonWorks)->sum('amount');
        $this->getTotalCommonInstallations();
        $this->getTotalCommonProportional();
    }



    //Función para obtener el total de privativas y comunes
    public function getTotalPrivateInstallations()
    {
        $this->totalPrivateInstallations = $this->subTotalPrivateInstallations + $this->subTotalPrivateAccessories + $this->subTotalPrivateWorks;
    }

    public function getTotalCommonInstallations()
    {
        $this->totalCommonInstallations = $this->subTotalCommonInstallations + $this->subTotalCommonAccessories + $this->subTotalCommonWorks;
    }






    public function getTotalCommonProportional()
    {
        // 1. Obtener todos los registros comunes del avalúo actual
        // Asumo que tienes una relación 'specialInstallations' en el modelo Valuation,
        // o puedes usar la consulta directa con el modelo y el ID.
        $commonRecords = SpecialInstallationModel::where('valuation_id', $this->valuation->id)
            ->where('classification_type', 'common')
            ->get();

        // Variable temporal para acumular el total
        $proportionalSum = 0.0;

        // 2. Recorrer los registros y calcular la parte proporcional
        foreach ($commonRecords as $record) {
            // Aseguramos que 'undivided' y 'amount' existan y sean numéricos
            if (isset($record->amount) && isset($record->undivided)) {
                // Cálculo: amount * (undivided / 100)
                $indivisoFactor = $record->undivided / 100;
                $proportionalValue = (float) $record->amount * $indivisoFactor;

                // Sumar al acumulado
                $proportionalSum += $proportionalValue;
            }
        }

        // 3. Asignar el resultado final a la propiedad pública
        $this->totalCommonProportional = $proportionalSum;
    }


    public function render()
    {
        return view('livewire.forms.special-installations');
    }
}
