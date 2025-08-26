<?php

namespace App\Livewire\Forms;

use App\Models\Valuation;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Assignament;
use App\Models\Assignment;
use Masmerise\Toaster\Toaster;

class GeneralInfo extends Component
{
    //Obtenemos información de los modelos de datos
    public $users;

    // Arrays públicos para consumir datos para los input select largos
    public array $levels_input, $propertiesTypes_input, $propertiesTypesSigapred_input, $landUse_input;

    //Variables primer contenedor
    public $gi_folio, $gi_date, $gi_type, $gi_calculationType, $gi_valuator, $gi_preValuation = false;

    //Variables segundo contenedor
    public $gi_ownerTypePerson, $gi_ownerRfc, $gi_ownerCurp, $gi_ownerName, $gi_ownerFirstName, $gi_ownerSecondName,
        $gi_ownerCompanyName, $gi_ownerCp, $gi_ownerEntity, $gi_ownerLocality, $gi_ownerColony, $gi_ownerStreet,
        $gi_ownerAbroadNumber, $gi_ownerInsideNumber, $gi_copyFromProperty = false;

    //Variables tercer contenedor
    public $gi_applicTypePerson, $gi_applicRfc, $gi_applicCurp ,$gi_applicName, $gi_applicFirstName, $gi_applicSecondName,
        $gi_applicNss, $gi_applicCp, $gi_applicEntity, $gi_applicLocality, $gi_applicColony,
        $gi_applicStreet, $gi_applicAbroadNumber, $gi_applicInsideNumber, $gi_applicPhone, $gi_copyFromProperty2 = false;

    //Variables cuarto contenedor
    public $gi_propertyCp, $gi_propertyEntity, $gi_propertyLocality, $gi_propertyCity,
        $gi_propertyColony, $gi_propertyStreet, $gi_propertyAbroadNumber, $gi_propertyInsideNumber, $gi_propertyBlock,
        $gi_propertySuperBlock, $gi_propertyLot, $gi_propertyBuilding, $gi_propertyDepartament, $gi_propertyAccess,
        $gi_propertyLevel, $gi_propertyCondominium, $gi_propertyStreetBetween, $gi_propertyAndStreet,
        $gi_propertyHousingComplex, $gi_propertyTax, $gi_propertyWaterAccount, $gi_propertyType, $gi_propertyTypeSigapred, $gi_propertyLandUse,
        $gi_propertyTypeHousing, $gi_propertyConstructor, $gi_propertyRfcConstructor, $gi_propertyAdditionalData,
        $gi_copyFromOwner = false;

    //Variable quinto contenedor
    public $gi_purpose, $gi_purposeSigapred, $gi_objective, $gi_ownerShipRegime;

    public function mount()
    {
        //Obtenemos los datos para diferentes input select, desde el archivo de configuración properties_inputs
        $this->levels_input = config('properties_inputs.levels', []);
        $this->propertiesTypes_input = config('properties_inputs.property_types', []);
        $this->propertiesTypesSigapred_input = config('properties_inputs.property_types_sigapred');
        $this->landUse_input = config('properties_inputs.land_use');

        //Traemos el modelo users para poder mostrar en el select de valuadores
        $this->users = User::all();

        //Obtenemos los valores deL avalúo a partir de la variable de sesión del ID
        $valuation = Valuation::find(Session::get('valuation_id'));

        //Obtenemos el valor de la tabla de asignaciones
        $assignament = Assignment::where('valuation_id', $valuation->id)->first();

        //Igualamos a las variables públicas para mostrar la información en la vista
        $this->gi_folio = $valuation->folio;
        $this->gi_date = $valuation->date;
        $this->gi_type = $valuation->type;
        //Obtenemos el nombre del valuador a partir de las consultas ya generadas
        $this->gi_valuator = User::where('id', $assignament->appraiser_id)->value('name');
    }

    public function saveAll()
    {

        //Ejecutar función con todas las reglas de validación y validaciones condicionales
        $this->validateAllContainers();

        //Aquí se ejecutará la lógica de guardado

        //Al finalizar, aquí se puede generar un Toaster de guardado o bien, copiar alguna otra función para redireccionar
        //y a la vez enviar un toaster
        Toaster::success('Asignación individual generada con éxito');
    }

    //Generamos todas las reglas de validación por contenedor en un solo método, pero que contenga las validaciones condicionales
    //Las cuales se generan dependiendo los valores definidos en el fonrmulario
    public function validateAllContainers()
    {
        //VALIDACIONES CONTAINER 1
        $container1 = [
            'gi_folio' => 'string',
            'gi_date' => 'required',
            'gi_type' => '',
            'gi_calculationType' => '',
            'gi_valuator' => 'required',
            'gi_preValuation' => ''
        ];

        //VALIDACIONES CONTAINER 2
        $container2 = [
            'gi_ownerTypePerson' => 'required',
            'gi_ownerRfc' => 'nullable|min:12',
            'gi_ownerCurp' => 'nullable|min:18',
            'gi_ownerCp' => 'required|min:5',
            'gi_ownerEntity' => 'required',
            'gi_ownerLocality' => 'required',
            'gi_ownerColony' => 'required',
            'gi_ownerStreet' => 'required|number',
            'gi_ownerAbroadNumber' => 'required|number',
            'gi_ownerInsideNumber' => 'nullable|number'
        ];

        //Validaciones Si el tipo de persona es Fisica
        if ($this->gi_ownerTypePerson !== 'Moral') {
            $container2 = array_merge($container2, [
                'gi_ownerName'  => 'required|string|max:50',
                'gi_ownerFirstName'   => 'required|string|max:50',
                'gi_ownerSecondName' => 'required|string|max:50',
            ]);
         //Validaciones si el tipo de persona es Moral
        } elseif ($this->gi_ownerTypePerson === 'Moral') {
            $container2['gi_ownerCompanyName'] = 'required|string|max:255';
        }

        //VALIDACIONES CONTAINER 3
        $container3 = [
            'gi_applicTypePerson' => 'required|in:Fisica,Moral',
            'gi_applicRfc'        => 'nullable|min:12',
            'gi_applicCurp' => 'nullable|min:18',
            'gi_applicNss' => 'nullable|min:11',
            'gi_applicCp' => 'required|min:5',
            'gi_applicEntity' => 'required',
            'gi_applicLocality' => 'required',
            'gi_applicColony' => 'required',
            'gi_applicStreet' => 'required|number',
            'gi_applicAbroadNumber' => 'required|number',
            'gi_applicInsideNumber' => 'nullable|number',
            'gi_applicPhone'    => 'nullable|number'
        ];

        //Validaciones específicas según tipo de solicitante
        if ($this->gi_applicTypePerson !== 'Moral') {
            $container3 = array_merge($container3, [
                'gi_applicName'  => 'required|string|max:50',
                'gi_applicFirstName'   => 'required|string|max:50',
                'gi_applicSecondName' => 'required|string|max:50',
            ]);
        } elseif ($this->gi_applicTypePerson === 'Moral') {
            $container3['gi_applicNameCompany'] = 'required|string|max:255';
        }

    //VALIDACIONES CONTAINER 4
        $container4 = [
            'gi_propertyCp' => 'required|min:5',
            'gi_propertyEntity' => 'required',
            'gi_propertyLocality' => 'required',
            'gi_propertyCity' => 'required',
            'gi_propertyColony' => 'required',
            'gi_propertyStreet' => 'required|number',
            'gi_propertyAbroadNumber' => 'required|number',
            'gi_propertyInsideNumber' => 'nullable|number',
            'gi_propertyBlock' => 'nullable',
            'gi_propertySuperBlock' => 'nullable',
            'gi_propertyLot' => 'nullable',
            'gi_propertyBuilding' => 'nullable',
            'gi_propertyDepartament' => 'nullable',
            'gi_propertyAccess' => 'nullable',
            'gi_propertyLevel' => 'nullable',
            'gi_propertyCondominium' => 'nullable',
            'gi_propertyStreetBetween' => 'nullable',
            'gi_propertyAndStreet' => 'nullable',
            'gi_propertyHousingComplex' => 'nullable',
            'gi_propertyTax' => 'required|number',
            'gi_propertyWaterAccount' => 'required',
            'gi_propertyType' => 'required',
            'gi_propertyTypeSigapred' => 'required',
            'gi_propertyLandUse' => 'required',
            'gi_propertyTypeHousing' => 'required',
            'gi_propertyConstructor' => 'required',
            'gi_propertyRfcConstructor' => 'required|min:12',
            'gi_propertyAdditionalData' => 'nullable'
        ];

    //Variable quinto contenedor

        $container5 = [
            'gi_purpose' => 'required',
            'gi_purposeSigapred' => 'required',
            'gi_objective' => 'required',
            'gi_ownerShipRegime' => 'required'
        ];

        //Una vez almacenadas todas las reglas de validación, primero guardamos las reglas del contenedor 1
        $rules = $container1;

        //Si el valor del checkbox de preAvaluo es falso, añadimos las reglas del contenedor 2 y 3
        //Si es falso, no se añadiran, ya que al ser preAvaluo, el contenedor 2 y 3 no se deben de llenar
        if (! $this->gi_preValuation) {
            $rules = array_merge($rules, $container2, $container3);
        }

        //Finalmente, añadiremos las reglas del contenedor 4 y 5 en nuestro arreglo general
        $rules = array_merge($rules, $container4, $container5);

        //Una vez añaditas todas las reglas de validación de nuestro flujo de validaciones,
        //hacemos la validación final enviando 3 atributos, el primero las reglas
        //el segundo un atributo para no reemplazar los mensajes de validación
        //Y el tercero es para obtener los valores de los atributos traducidos
        $this->validate($rules, [],      $this->validationAttributes());

    }

    public function buscarCP()
    {
        Toaster::success('Hasta aquí todo bien');
    }

    //Generamos los atributos traducidos para cambiar el valor de los wire:model en los
    //mensajes de cada error de validación
    protected function validationAttributes(): array
    {
        return [
            // Contenedor 1: Datos del avalúo
            'gi_folio'               => 'Folio',
            'gi_date'                => 'Fecha de creación',
            'gi_type'                => 'Tipo de avalúo',
            'gi_calculationType'     => 'Tipo de cálculo',
            'gi_valuator'            => 'Valuador',
            'gi_preValuation'        => 'Pre-avalúo',

            // Contenedor 2: Datos del propietario
            'gi_ownerTypePerson'     => 'tipo de persona',
            'gi_ownerRfc'            => 'RFC',
            'gi_ownerCurp'           => 'CURP',
            'gi_ownerName'           => 'nombre',
            'gi_ownerFirstName'      => 'apellido paterno',
            'gi_ownerSecondName'     => 'apellido materno',
            'gi_ownerCompanyName'    => 'nombre de la empresa',
            'gi_ownerCp'             => 'Código postal',
            'gi_ownerEntity'         => 'Entidad',
            'gi_ownerLocality'       => 'Alcaldía/municipio',
            'gi_ownerColony'         => 'Colonia',
            'gi_ownerStreet'         => 'Calle',
            'gi_ownerAbroadNumber'   => 'Número exterior',
            'gi_ownerInsideNumber'   => 'Número interior',

            // Contenedor 3: Datos del solicitante
            'gi_applicTypePerson'    => 'Tipo de persona',
            'gi_applicRfc'           => 'RFC',
            'gi_applicCurp'          => 'CURP',
            'gi_applicName'          => 'Nombre',
            'gi_applicFirstName'     => 'Apellido paterno',
            'gi_applicSecondName'    => 'Apellido materno',
            'gi_applicCompanyName'   => 'Empresa',
            'gi_applicNss'           => 'NSS',
            'gi_copyFromProperty2'   => 'Copiar dirección inmueble',
            'gi_applicCp'            => 'Código postal',
            'gi_applicEntity'        => 'Entidad',
            'gi_applicLocality'      => 'Alcaldía/municipio',
            'gi_applicColony'        => 'Colonia',
            'gi_applicStreet'        => 'Calle',
            'gi_applicAbroadNumber'  => 'Número exterior',
            'gi_applicInsideNumber'  => 'Número interior',
            'gi_applicPhone'         => 'Teléfono',

            // Contenedor 4: Dirección del inmueble
            'gi_propertyCp'          => 'código postal',
            'gi_propertyEntity'      => 'entidad',
            'gi_propertyLocality'    => 'alcaldía/municipio',
            'gi_propertyCity'        => 'ciudad',
            'gi_propertyColony'      => 'colonia',
            'gi_propertyStreet'      => 'calle',
            'gi_propertyAbroadNumber' => 'número exterior',
            'gi_propertyInsideNumber' => 'número interior',
            'gi_propertyBlock'       => 'manzana',
            'gi_propertySuperBlock'  => 'super manzana',
            'gi_propertyLot'         => 'lote',
            'gi_propertyBuilding'    => 'edificio',
            'gi_propertyDepartament' => 'departamento',
            'gi_propertyAccess'      => 'entrada',
            'gi_propertyLevel'       => 'nivel',
            'gi_propertyCondominium' => 'condominio',
            'gi_propertyStreetBetween' => 'entre calle',
            'gi_propertyAndStreet'   => 'Y calle',
            'gi_propertyHousingComplex' => 'conjunto habitacional',
            'gi_propertyTax'             => 'cuenta predial',
            'gi_propertyWaterAccount'    => 'cuenta de agua',
            'gi_propertyType'            => 'tipo de inmueble',
            'gi_propertyTypeSigapred'    => 'tipo SIGAPRED',
            'gi_propertyLandUse'         => 'uso de suelo',
            'gi_propertyTypeHousing'     => 'tipo de vivienda',
            'gi_propertyConstructor'     => 'constructor',
            'gi_propertyRfcConstructor'  => 'RFC constructor',
            'gi_propertyAdditionalData'  => 'información adicional inmueble',

            // Contenedor 5: Detalles adicionales del inmueble
            'gi_purpose' => 'propósito del avalúo',
            'gi_purposeSigapred' => 'propósito del avalúo sigapred',
            'gi_objective' => 'Objeto del avalúo',
            'gi_ownerShipRegime' => 'Régimen del avalúo'
        ];
    }


    public function render()
    {
        return view('livewire.forms.general-info');
    }
}
