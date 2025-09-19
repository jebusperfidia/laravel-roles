<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Valuation;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;
use App\Services\DipomexService;

class GeneralInfo extends Component
{
    //Obtenemos información de los modelos de datos
    public $users;

    // Arrays públicos para consumir datos para los input select largos
    public array $levels_input, $propertiesTypes_input, $propertiesTypesSigapred_input, $landUse_input;

    //Variables para almacenar los datos obtenidos desde la API de Dipomex

    //Variables para primer contenedor de direcciones
    public $states = [];
    public $municipalities = [];
    public $colonies = [];

    //Variables para primer contenedor de direcciones
    public $states2 = [];
    public $municipalities2 = [];
    public $colonies2 = [];

    //Variables para primer contenedor de direcciones
    public $states3 = [];
    public $municipalities3 = [];
    public $colonies3 = [];

    //Variables primer contenedor
    public $gi_folio, $gi_date, $gi_type, $gi_calculationType, $gi_valuator, $gi_preValuation = false;

    //Variables segundo contenedor
    public $gi_ownerTypePerson, $gi_ownerRfc, $gi_ownerCurp, $gi_ownerName, $gi_ownerFirstName, $gi_ownerSecondName,
        $gi_ownerCompanyName, $gi_ownerCp, $gi_ownerEntity, $gi_ownerLocality, $gi_ownerColony, $gi_ownerOtherColony, $gi_ownerStreet,
        $gi_ownerAbroadNumber, $gi_ownerInsideNumber, $gi_copyFromProperty = false;

    //Variables tercer contenedor
    public $gi_applicTypePerson, $gi_applicRfc, $gi_applicCurp ,$gi_applicName, $gi_applicFirstName, $gi_applicSecondName,
        $gi_applicNss, $gi_applicCp, $gi_applicEntity, $gi_applicLocality, $gi_applicColony, $gi_applicOtherColony,
        $gi_applicStreet, $gi_applicAbroadNumber, $gi_applicInsideNumber, $gi_applicPhone, $gi_copyFromProperty2 = false;

    //Variables cuarto contenedor
    public $gi_propertyCp, $gi_propertyEntity, $gi_propertyLocality, $gi_propertyCity, $gi_propertyColony, $gi_propertyOtherColony,
        $gi_propertyStreet, $gi_propertyAbroadNumber, $gi_propertyInsideNumber, $gi_propertyBlock,
        $gi_propertySuperBlock, $gi_propertyLot, $gi_propertyBuilding, $gi_propertyDepartament, $gi_propertyAccess,
        $gi_propertyLevel, $gi_propertyCondominium, $gi_propertyStreetBetween, $gi_propertyAndStreet,
        $gi_propertyHousingComplex, $gi_propertyTax, $gi_propertyWaterAccount, $gi_propertyType, $gi_propertyTypeSigapred, $gi_propertyLandUse,
        $gi_propertyTypeHousing, $gi_propertyConstructor, $gi_propertyRfcConstructor, $gi_propertyAdditionalData,
        $gi_copyFromOwner = false;

    //Variable quinto contenedor
    public $gi_purpose, $gi_purposeSigapred, $gi_objective, $gi_ownerShipRegime;


    /**
     * Usamos inyección de dependencias para obtener nuestro nuevo servicio.
     */
    public function mount(DipomexService $dipomex)
    {

        //Datos para cargar valores en los select de estados, municipios y colonias primer contenedor
        $this->gi_ownerCp = '37549';
       /*  $this->gi_ownerEntity = '11';
        $this->gi_ownerLocality = '13'; */
        $this->gi_ownerColony = '10 de Mayo';
        $this->gi_ownerOtherColony = 'La escondida 2';

        //Obtenemos los estados
        $this->states = $dipomex->getEstados();
        $this->states2 = $dipomex->getEstados();
        $this->states3 = $dipomex->getEstados();


        // 3. VERIFICAMOS SI EXISTE UN CP para buscar la dirección.
        if ($this->gi_ownerCp  !== '') {
            $data = $dipomex->buscarPorCodigoPostal($this->gi_ownerCp);


            // Buscar el ID del estado con base en el nombre
            $estadoId = array_search($data['estado'], $this->states);


            // Setear el id del estado seleccionado
            $this->gi_ownerEntity = $estadoId;

            // Poblar municipios inmediatamente
            $this->municipalities = $dipomex->getMunicipiosPorEstado($estadoId);
            //dd($this->municipalities);

            //Obtenemos el ID del municipio con base en el nombre
            $municipioId = array_search($data['municipio'], $this->municipalities);

            //Asignamos el valor del municipio
            $this->gi_ownerLocality = $municipioId;

            // Asignar colonias
            $this->colonies = $data['colonias'];
            //dd($this->colonies);
        }




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

        $this->gi_propertyType = $valuation->property_type;

        //Obtenemos el nombre del valuador a partir de las consultas ya generadas
        $this->gi_valuator = User::where('id', $assignament->appraiser_id)->value('name');
    }

    public function saveAll()
    {

        //Ejecutar función con todas las reglas de validación y validaciones condicionales, guardando todo en una variable
        $validator = $this->validateAllContainers();

        //Comprobamos si se obtuvieron errores de validación
        if ($validator->fails()) {
            //Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            //Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            //Hacemos un return para detener el flujo del sistema
            return;
        }

        //AQUI SE EJECUTARÁ LA LÓGICA DE GUARDADO



        //Al finalizar, aquí se puede generar un Toaster de guardado o bien, copiar alguna otra función para redireccionar
        //y a la vez enviar un toaster

        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'property-location']);
    }

    //Generamos todas las reglas de validación por contenedor en un solo método, pero que contenga las validaciones condicionales
    //Las cuales se generan dependiendo los valores definidos en el formulario
    public function validateAllContainers()
    {
        //VALIDACIONES CONTAINER 1
        $container1 = [
            'gi_folio' => 'string',
            'gi_date' => 'required',
            'gi_type' => 'required',
            /* 'gi_calculationType' => 'required', */
            'gi_valuator' => 'required',
            'gi_preValuation' => 'nullable'
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
            'gi_ownerStreet' => 'required',
            'gi_ownerAbroadNumber' => 'required|numeric',
            'gi_ownerInsideNumber' => 'nullable|numeric'
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


        //Validaciones si la colonia no está listada
          if ($this->gi_ownerColony === 'no-listada') {
            $container2 = array_merge($container2, [
                'gi_ownerOtherColony'  => 'required|string|max:50'
            ]);
        }

        //dd($container2);


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
            'gi_applicStreet' => 'required',
            'gi_applicAbroadNumber' => 'required|numeric',
            'gi_applicInsideNumber' => 'nullable|numeric',
            'gi_applicPhone'    => 'nullable|numeric'
        ];

        //Validaciones si la colonia no está listada
       /*  if ($this->gi_applicColony === 'no-listada') {
            $container2 = array_merge($container3, [
                'gi_applicOtherColony'  => 'required|string|max:50'
            ]);
        }
 */

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

        //Validaciones si la colonia no está listada
        if ($this->gi_applicColony === 'no-listada') {
            $container3 = array_merge($container3, [
                'gi_applicOtherColony'  => 'required|string|max:50'
            ]);
        }


        //VALIDACIONES CONTAINER 4
        $container4 = [
            'gi_propertyCp' => 'required|min:5',
            'gi_propertyEntity' => 'required',
            'gi_propertyLocality' => 'required',
            'gi_propertyCity' => 'required',
            'gi_propertyColony' => 'required',
            'gi_propertyStreet' => 'required',
            'gi_propertyAbroadNumber' => 'required|numeric',
            'gi_propertyInsideNumber' => 'nullable|numeric',
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
            'gi_propertyTax' => 'required|numeric',
            'gi_propertyWaterAccount' => 'required',
            'gi_propertyType' => 'required',
            'gi_propertyTypeSigapred' => 'required',
            'gi_propertyLandUse' => 'required',
            'gi_propertyTypeHousing' => 'required',
            'gi_propertyConstructor' => 'required',
            'gi_propertyRfcConstructor' => 'required|min:12',
            'gi_propertyAdditionalData' => 'nullable'
        ];

        //Validaciones si la colonia no está listada
        if ($this->gi_propertyColony === 'no-listada') {
            $container4 = array_merge($container4, [
                'gi_propertyOtherColony'  => 'required|string|max:50'
            ]);
        }


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


    //Función para búsqueda del código postal del propietario, usando API Dipomex
    //Las funciones se repiten para cáda uno, seperando la lógica y evitando que se mezclen los datos
    public function buscarCP1(DipomexService $dipomex)
    {
        //Validamos que el campo no esté vacío y contenga 5 dígitos
        $this->validate([
            'gi_ownerCp' => 'required|digits:5'
        ]);

        $data = $dipomex->buscarPorCodigoPostal($this->gi_ownerCp);

        //Si por alguna razón la respueta está vacía, reseteamos los campos y mostramos un error
        if (empty($data)) {
            Toaster::error('No se encontró información para el código postal proporcionado.');
            $this->reset(['gi_ownerCp','gi_ownerEntity', 'gi_ownerLocality', 'gi_ownerColony', 'municipalities', 'colonies']);
            return;
        }

        // Buscar el ID del estado con base en el nombre
        $estadoId = array_search($data['estado'], $this->states);

        //Si no se encuentra el estado, mostramos un error
        if ($estadoId === false) {
            Toaster::error('No se encontró el estado correspondiente al código postal.');
            return;
        }

        // Setear el id del estado seleccionado
        $this->gi_ownerEntity = $estadoId;

        // Poblar municipios inmediatamente
        $this->municipalities = $dipomex->getMunicipiosPorEstado($estadoId);
        //dd($this->municipalities);

        //Obtenemos el ID del municipio con base en el nombre
        $municipioId = array_search($data['municipio'], $this->municipalities);

        //Asignamos el valor del municipio
        $this->gi_ownerLocality = $municipioId;

        // Asignar colonias
        $this->colonies = $data['colonias'];
        //dd($this->colonies);

        Toaster::success('Información encontrada correctamente.');
    }



    //Creamos un watcher para cuando se actualice el valor del select de estados
    //Este llamará al método del servicio para poblar los municipios
    public function updatedGiOwnerEntity($estadoId, DipomexService $dipomex)
    {
        $this->reset(['gi_ownerLocality', 'gi_ownerColony', 'municipalities', 'colonies']);

        if ($estadoId) {
            $this->municipalities = $dipomex->getMunicipiosPorEstado($estadoId);
        }
    }

    //Creamos un watcher para cuando se actualice el valor del select de municipios
    //Este llamará al método del servicio para poblar las colonias
    public function updatedGiOwnerLocality($municipioId, DipomexService $dipomex)
    {
        /* $this->reset(['gi_ownerColony', 'colonies']);

        if ($selectedMunicipio && $this->gi_ownerEntity) {

            $municipios = $dipomex->getMunicipiosPorEstado($this->gi_ownerEntity); // método que devuelve todos
            $municipio = collect($municipios)->firstWhere('MUNICIPIO', $selectedMunicipio);

            if ($municipio) {
                $municipioId = $municipio['MUNICIPIO_ID'];
                $this->colonies = $dipomex->getColoniasPorMunicipio($this->gi_ownerEntity, $municipioId);
            }
        } */

        $this->reset(['gi_ownerColony', 'colonies']);

        if ($municipioId && $this->gi_ownerEntity) {
            // Como ahora gi_ownerLocality tiene el MUNICIPIO_ID, lo pasamos directo
            $this->colonies = $dipomex->getColoniasPorMunicipio($this->gi_ownerEntity, $municipioId);
        }
    }



    //Función para búsqueda del código postal del solicitante, usando API Dipomex
    public function buscarCP2(DipomexService $dipomex)
    {

        $this->validate([
            'gi_applicCp' => 'required|digits:5'
        ]);

        $data = $dipomex->buscarPorCodigoPostal($this->gi_applicCp);

        if (empty($data)) {
            Toaster::error('No se encontró información para el código postal proporcionado.');
            $this->reset(['gi_applicCp','gi_applicEntity', 'gi_applicLocality', 'gi_applicColony', 'municipalities2', 'colonies2']);
            return;
        }

        // Buscar el ID del estado con base en el nombre
        $estadoId = array_search($data['estado'], $this->states);

        if ($estadoId === false) {
            Toaster::error('No se encontró el estado correspondiente al código postal.');
            return;
        }

        // Setear el id del estado seleccionado
        $this->gi_applicEntity = $estadoId;

        //  Poblar municipios inmediatamente
        $this->municipalities2 = $dipomex->getMunicipiosPorEstado($estadoId);
        //dd($this->municipalities);

        //Obtenemos el ID del municipio con base en el nombre
        $municipioId = array_search($data['municipio'], $this->municipalities2);

        //Asignamos el valor del municipio
        $this->gi_applicLocality = $municipioId;

        //dd($this->gi_ownerLocality);


        //dd($municipio);

        // Asignar colonias
        $this->colonies2 = $data['colonias'];

        Toaster::success('Información encontrada correctamente.');
        //Toaster::success('Hasta aquí todo bien');
    }


    //Creamos un watcher para cuando se actualice el valor del select de estados
    public function updatedGiApplicEntity($estadoId, DipomexService $dipomex)
    {
        $this->reset(['gi_applicLocality', 'gi_applicColony', 'municipalities2', 'colonies2']);

        if ($estadoId) {
            $this->municipalities2 = $dipomex->getMunicipiosPorEstado($estadoId);
        }
    }

    //Creamos un watcher para cuando se actualice el valor del select de municipios
    public function updatedGiApplicLocality($municipioId, DipomexService $dipomex)
    {


        $this->reset(['gi_applicColony', 'colonies2']);

        if ($municipioId && $this->gi_applicEntity) {
            // Como ahora gi_ownerLocality tiene el MUNICIPIO_ID, lo pasamos directo
            $this->colonies2 = $dipomex->getColoniasPorMunicipio($this->gi_applicEntity, $municipioId);
        }
    }


    //Función para búsqueda del código postal del inmueble, usando API Dipomex
    public function buscarCP3(DipomexService $dipomex)
    {

        $this->validate([
            'gi_propertyCp' => 'required|digits:5'
        ]);

        $data = $dipomex->buscarPorCodigoPostal($this->gi_propertyCp);

        if (empty($data)) {
            Toaster::error('No se encontró información para el código postal proporcionado.');
            $this->reset(['gi_propertyCp','gi_propertyEntity', 'gi_propertyLocality', 'gi_propertyColony', 'municipalities3', 'colonies3']);
            return;
        }

        // Buscar el ID del estado con base en el nombre
        $estadoId = array_search($data['estado'], $this->states);

        if ($estadoId === false) {
            Toaster::error('No se encontró el estado correspondiente al código postal.');
            return;
        }

        // Setear el id del estado seleccionado
        $this->gi_propertyEntity = $estadoId;

        // Poblar municipios inmediatamente
        $this->municipalities3 = $dipomex->getMunicipiosPorEstado($estadoId);

        //Obtenemos el ID del municipio con base en el nombre
        $municipioId = array_search($data['municipio'], $this->municipalities3);

        //Asignamos el valor del municipio
        $this->gi_propertyLocality = $municipioId;


        // Asignar colonias
        $this->colonies3 = $data['colonias'];

        Toaster::success('Información encontrada correctamente.');
        //Toaster::success('Hasta aquí todo bien');
    }



    //Creamos un watcher para cuando se actualice el valor del select de estados
    public function updatedGiPropertyEntity($estadoId, DipomexService $dipomex)
    {
        $this->reset(['gi_propertyLocality', 'gi_propertyColony', 'municipalities3', 'colonies3']);

        if ($estadoId) {
            $this->municipalities3 = $dipomex->getMunicipiosPorEstado($estadoId);
        }
    }

    //Creamos un watcher para cuando se actualice el valor del select de municipios
    public function updatedGiPropertyLocality($municipioId, DipomexService $dipomex)
    {


        $this->reset(['gi_propertyColony', 'colonies3']);

        if ($municipioId && $this->gi_propertyEntity) {
            // Como ahora gi_ownerLocality tiene el MUNICIPIO_ID, lo pasamos directo
            $this->colonies3 = $dipomex->getColoniasPorMunicipio($this->gi_propertyEntity, $municipioId);
        }
    }


    //Generamos los watcher para los checkbox de copiar direcciones
    public function updatedGiCopyFromProperty($value){
        if($value){

            /*  $this->validate([
                'gi_propertyCp' => 'required|min:5',
            ]); */

            /* if (
                !is_string($this->gi_propertyCp) ||
                strlen($this->gi_propertyCp) !== 5 ||
                !ctype_digit($this->gi_propertyCp)
            ) {
                Toaster::error('El código postal del inmueble es un valor inválido');
                $this->reset('gi_copyFromProperty');
                return;
            } */

            // Ejecutar la validación manual
            $validator = Validator::make(
                ['gi_propertyCp' => $this->gi_propertyCp],
                ['gi_propertyCp' => ['required', 'digits:5']],
                [],
                ['gi_propertyCp' => 'código postal']
            );

            // Comprobar si hubo errores
            if ($validator->fails()) {
                // Mostrar mensaje personalizado
                Toaster::error('El código postal del inmueble es inválido. Debe contener exactamente 5 dígitos.');

                $this->reset('gi_copyFromProperty');
                // Mostrar los errores en pantalla (Livewire los usa para @error en Blade)
                $this->setErrorBag($validator->getMessageBag());

                // Detener el flujo
                return;
            }

            $this->gi_ownerCp = $this->gi_propertyCp;
            $this->gi_ownerEntity = $this->gi_propertyEntity;
            $this->gi_ownerLocality = $this->gi_propertyLocality;
            $this->gi_ownerColony = $this->gi_propertyColony;
            //dd($this->gi_ownerColony, $this->gi_propertyColony);
            $this->gi_ownerStreet = $this->gi_propertyStreet;
            $this->gi_ownerAbroadNumber = $this->gi_propertyAbroadNumber;
            $this->gi_ownerInsideNumber = $this->gi_propertyInsideNumber;

            //dd($this->gi_ownerColony, $this->gi_propertyColony);
            //Llenamos los municipios y colonias para que se muestren correctamente
            $this->municipalities = $this->municipalities3;
            $this->colonies = $this->colonies3;
            $this->reset('gi_copyFromProperty');
            Toaster::success('Datos copiados correctamente');

        } else {
           /*  $this->reset(['gi_ownerCp', 'gi_ownerEntity', 'gi_ownerLocality', 'gi_ownerColony', 'gi_ownerStreet', 'gi_ownerAbroadNumber', 'gi_ownerInsideNumber', 'municipalities', 'colonies']); */
        }
    }


    public function updatedGiCopyFromProperty2($value){
        if($value){

            /* if(empty($this->gi_propertyCp)){
                Toaster::error('Primero debe llenar los datos del inmueble');
                $this->reset('gi_copyFromProperty2');
                return;
            } */

            $validator = Validator::make(
                ['gi_propertyCp' => $this->gi_propertyCp],
                ['gi_propertyCp' => ['required', 'digits:5']],
                [],
                ['gi_propertyCp' => 'código postal']
            );

            // Comprobar si hubo errores
            if ($validator->fails()) {
                // Mostrar mensaje personalizado
                Toaster::error('El código postal del inmueble es inválido. Debe contener exactamente 5 dígitos.');

                $this->reset('gi_copyFromProperty2');
                // Mostrar los errores en pantalla (Livewire los usa para @error en Blade)
                $this->setErrorBag($validator->getMessageBag());

                // Detener el flujo
                return;
            }

            $this->gi_applicCp = $this->gi_propertyCp;
            $this->gi_applicEntity = $this->gi_propertyEntity;
            $this->gi_applicLocality = $this->gi_propertyLocality;
            $this->gi_applicColony = $this->gi_propertyColony;
            $this->gi_applicStreet = $this->gi_propertyStreet;
            $this->gi_applicAbroadNumber = $this->gi_propertyAbroadNumber;
            $this->gi_applicInsideNumber = $this->gi_propertyInsideNumber;

            //Llenamos los municipios y colonias para que se muestren correctamente
            $this->municipalities2 = $this->municipalities3;
            $this->colonies2 = $this->colonies3;
            $this->reset('gi_copyFromProperty2');
            Toaster::success('Datos copiados correctamente');

        } else {
           /*  $this->reset(['gi_ownerCp', 'gi_ownerEntity', 'gi_ownerLocality', 'gi_ownerColony', 'gi_ownerStreet', 'gi_ownerAbroadNumber', 'gi_ownerInsideNumber', 'municipalities', 'colonies']); */
        }
    }


    public function updatedGiCopyFromOwner($value){
        if($value){

            /* if(empty($this->gi_ownerCp)){
                Toaster::error('Primero debe llenar los datos del propietario');
                $this->reset('gi_copyFromOwner');
                return;
            } */


            $validator = Validator::make(
                ['gi_ownerCp' => $this->gi_ownerCp],
                ['gi_ownerCp' => ['required', 'digits:5']],
                [],
                ['gi_ownerCp' => 'código postal']
            );

            // Comprobar si hubo errores
            if ($validator->fails()) {
                // Mostrar mensaje personalizado
                Toaster::error('El código postal del propietario es inválido. Debe contener exactamente 5 dígitos.');

                $this->reset('gi_copyFromOwner');
                // Mostrar los errores en pantalla (Livewire los usa para @error en Blade)
                $this->setErrorBag($validator->getMessageBag());

                // Detener el flujo
                return;
            }

            $this->gi_propertyCp = $this->gi_ownerCp;
            $this->gi_propertyEntity = $this->gi_ownerEntity;
            $this->gi_propertyLocality = $this->gi_ownerLocality;
            $this->gi_propertyColony = $this->gi_ownerColony;
            $this->gi_propertyStreet = $this->gi_ownerStreet;
            $this->gi_propertyAbroadNumber = $this->gi_ownerAbroadNumber;
            $this->gi_propertyInsideNumber = $this->gi_ownerInsideNumber;

            //Llenamos los municipios y colonias para que se muestren correctamente
            $this->municipalities3 = $this->municipalities;
            $this->colonies3 = $this->colonies;
            $this->reset('gi_copyFromOwner');
            Toaster::success('Datos copiados correctamente');

        }
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
            'gi_ownerCp'             => 'código postal',
            'gi_ownerEntity'         => 'antidad',
            'gi_ownerLocality'       => 'alcaldía/municipio',
            'gi_ownerColony'         => 'colonia',
            'gi_ownerOtherColony'    => 'otra colonia',
            'gi_ownerStreet'         => 'calle',
            'gi_ownerAbroadNumber'   => 'número exterior',
            'gi_ownerInsideNumber'   => 'número interior',

            // Contenedor 3: Datos del solicitante
            'gi_applicTypePerson'    => 'tipo de persona',
            'gi_applicRfc'           => 'RFC',
            'gi_applicCurp'          => 'CURP',
            'gi_applicName'          => 'nombre',
            'gi_applicFirstName'     => 'apellido paterno',
            'gi_applicSecondName'    => 'apellido materno',
            'gi_applicCompanyName'   => 'empresa',
            'gi_applicNss'           => 'NSS',
            'gi_copyFromProperty2'   => 'copiar dirección inmueble',
            'gi_applicCp'            => 'código postal',
            'gi_applicEntity'        => 'entidad',
            'gi_applicLocality'      => 'alcaldía/municipio',
            'gi_applicColony'        => 'colonia',
            'gi_applicOtherColony'   => 'otra colonia',
            'gi_applicStreet'        => 'calle',
            'gi_applicAbroadNumber'  => 'número exterior',
            'gi_applicInsideNumber'  => 'número interior',
            'gi_applicPhone'         => 'teléfono',

            // Contenedor 4: Dirección del inmueble
            'gi_propertyCp'          => 'código postal',
            'gi_propertyEntity'      => 'entidad',
            'gi_propertyLocality'    => 'alcaldía/municipio',
            'gi_propertyCity'        => 'ciudad',
            'gi_propertyColony'      => 'colonia',
            'gi_propertyOtherColony' => 'otra colonia',
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
