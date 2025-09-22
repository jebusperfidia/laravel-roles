<?php

namespace App\Livewire\Forms\Comparables;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Valuation;
use Flux\Flux;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Validator;
use App\Services\DipomexService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ComparablesIndex extends Component
{
    public $id;
    public $valuation;

    //Variables para obtener valores en el modal
    public $states = [];
    public $municipalities = [];
    public $colonies = [];

    //Variable para la generación de la ruta corta
    public $comparableShortUrl;

    //Valores del usuario logueado
    public $userSession;

    //Variables para el modal de creación de comparables para el avaluo
    public $comparableKey, $comparableFolio, $comparableDischargedBy, $Comparableproperty,
    $comparableEntity, $comparableLocality, $comparableColony, $comparableOtherColony, $comparableStreet,
    $comparableBetweenStreet, $comparableAndStreet, $comparableCp,
    $comparableName, $comparableLastName, $comparablePhone, $comparableUrl, $comparablelandUse,
    $comparableDescServicesInfraestructure,
    $comparableServicesInfraestructure, $comparableShape, $comparableDensity,
    $comparableFront, $comparableFrontType, $comparableDescriptionForm, $comparableTopography,
    $comparableCharacteristics, $comparableCharacteristicsGeneral,  $comparableLocationBlock,
    $comparableStreetLocation, $comparableGeneralPropArea, $comparableUrbanProximityReference,
    $comparableSourceInfImages, $comparablePhotos, $comparableActive;

    public int $comparableAbroadNumber, $comparableInsideNumber, $comparableAllowedLevels,
    $comparableNumberFronts;

    public float $comparableFreeAreaRequired, $comparableSlope, $comparableOffers, $comparableLandArea,
        $comparableBuiltArea, $comparableUnitValue, $comparableBargainingFactor;


    public function mount(DipomexService $dipomex)
    {

        //Obtenemos los estados
        $this->states = $dipomex->getEstados();

        //Añadimos la variable de sesión que validará el acceso a este componente
        $this->id = Session::get('valuation_id');
        //Buscamos el valor del avaluó para mostrar el valor del folio correspondiente
        $this->valuation = Valuation::find($this->id);

        //Inicializar variables de ejemplos
        $this->comparableKey = 01;
        $this->comparableFolio = $this->valuation->folio;

        $userSession = Auth::user();

        $this->comparableDischargedBy = $userSession->name;


    }


    //Función para agregar un comparable para el avalúo
    public function openAddComparable()
    {
        $this->resetValidation();
        Flux::modal('add-comparable')->show();
    }


    public function save(){

        //Ejecutar función con todas las reglas de validación y validaciones condicionales, guardando todo en una variable
        $validator = $this->validateModal();

        //Comprobamos si se obtuvieron errores de validación
        if ($validator->fails()) {
            //Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            //Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            //Hacemos un return para detener el flujo del sistema
            return;
        }

       $this->resetComparableFields();

        Toaster::success('Comparable añadido');
        Flux::modal('add-comparable')->close();
    }



    //Función para búsqueda del código postal del propietario, usando API Dipomex
    //Las funciones se repiten para cáda uno, seperando la lógica y evitando que se mezclen los datos
    public function buscarCP(DipomexService $dipomex)
    {
        //Validamos que el campo no esté vacío y contenga 5 dígitos
        $this->validate(
            [
                'comparableCp' => 'required|integer|digits:5',
            ],
            [], // Mensajes personalizados (si quieres)
            [   // Atributos personalizados (lo que quieres hacer)
                'comparableCp' => 'código postal',
            ]
        );

        $data = $dipomex->buscarPorCodigoPostal($this->comparableCp);

        //Si por alguna razón la respueta está vacía, reseteamos los campos y mostramos un error
        if (empty($data)) {
            Toaster::error('No se encontró información para el código postal proporcionado.');
            $this->reset(['comparableCp', 'comparableEntity', 'comparableLocality', 'comparableColony', 'municipalities', 'colonies']);
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
        $this->comparableEntity = $estadoId;

        // Poblar municipios inmediatamente
        $this->municipalities = $dipomex->getMunicipiosPorEstado($estadoId);
        //dd($this->municipalities);

        //Obtenemos el ID del municipio con base en el nombre
        $municipioId = array_search($data['municipio'], $this->municipalities);

        //Asignamos el valor del municipio
        $this->comparableLocality = $municipioId;

        // Asignar colonias
        $this->colonies = $data['colonias'];
        //dd($this->colonies);

        Toaster::success('Información encontrada correctamente.');
    }



    //Creamos un watcher para cuando se actualice el valor del select de estados
    //Este llamará al método del servicio para poblar los municipios
    public function updatedComparableEntity($estadoId, DipomexService $dipomex)
    {
        $this->reset(['comparableLocality', 'comparableColony', 'municipalities', 'colonies']);

        if ($estadoId) {
            $this->municipalities = $dipomex->getMunicipiosPorEstado($estadoId);
        }
    }

    //Creamos un watcher para cuando se actualice el valor del select de municipios
    //Este llamará al método del servicio para poblar las colonias
    public function updatedComparableLocality($municipioId, DipomexService $dipomex)
    {


        $this->reset(['comparableColony', 'colonies']);

        if ($municipioId && $this->comparableEntity) {
            // Como ahora gi_ownerLocality tiene el MUNICIPIO_ID, lo pasamos directo
            $this->colonies = $dipomex->getColoniasPorMunicipio($this->comparableEntity, $municipioId);
        }
    }


    //Función para acortar URL usando URL clean https://urlclean.com
    public function shortUrl(){
        $this->validate([
            'comparableUrl' => 'required|url',
        ]);

        try {
            $response = Http::asForm()->post('https://cleanuri.com/api/v1/shorten', [
                'url' => $this->comparableUrl,
            ]);

            if ($response->successful() && isset($response['result_url'])) {
                $this->comparableUrl = $response['result_url'];
                Toaster::success('URL acortada exitosamente.');
            } else {
                Toaster::error('No se pudo acortar la URL. Intenta de nuevo.');
            }
        } catch (\Exception $e) {
            Toaster::error('Error al conectar con CleanURL: ' . $e->getMessage());
        }
    }


    public function validateModal(){
        // VALIDACIONES COMPARABLES
        $comparableRules = [
            'comparableKey' => 'required',
            'comparableFolio' => 'required',
            'comparableDischargedBy' => 'required',
            'Comparableproperty' => 'required',
            'comparableCp' => 'required|integer|digits:5',
            'comparableEntity' => 'nullable',
            'comparableLocality' => 'nullable',
            'comparableColony' => 'nullable',
            /* 'comparableOtherColony' => 'required', */
            'comparableStreet' => 'required',
            'comparableAbroadNumber' => 'required|integer',
            'comparableInsideNumber' => 'nullable|integer',
            'comparableBetweenStreet' => 'required',
            'comparableAndStreet' => 'required',
            'comparableName' => 'required',
            'comparableLastName' => 'required',
            //Bail detiene las validaciones en cuanto ocurra el primero error y lo muestra en pantalla
            /* 'comparablePhone' => 'bail|required|regex:/^[0-9]+$/|digits_between:7,15', */
            'comparablePhone' => 'bail|required|integer|digits_between:7,15',
            'comparableUrl' => 'required|url',
            'comparablelandUse' => 'required',
            'comparableFreeAreaRequired' => 'required|integer|between:0,100',
            'comparableAllowedLevels' => 'required|integer',
            'comparableServicesInfraestructure' => 'nullable',
            'comparableDescServicesInfraestructure' => 'required',
            'comparableShape' => 'required',
            'comparableSlope' => 'required',
            'comparableDensity' => 'required',
            'comparableFront' => 'required',
            'comparableFrontType' => 'nullable',
            'comparableDescriptionForm' => 'nullable',
            'comparableTopography' => 'required',
            'comparableCharacteristics' => 'required',
            'comparableCharacteristicsGeneral' => 'nullable',
            'comparableOffers' => 'required|numeric',
            'comparableLandArea' => 'required|numeric',
            'comparableBuiltArea' => 'required|numeric',
            'comparableUnitValue' => 'required|numeric',
            'comparableBargainingFactor' => 'required|numeric|between:0.8,1',
            'comparableLocationBlock' => 'required',
            'comparableStreetLocation' => 'required',
            'comparableGeneralPropArea' => 'required',
            'comparableUrbanProximityReference' => 'required',
            'comparableNumberFronts' => 'required|integer',
            'comparableSourceInfImages' => 'required',
            'comparablePhotos' => 'required',
            /* 'comparableActive' => 'required', */
        ];

        if($this->comparableOtherColony === 'no-listada'){
            $comparableRules = array_merge($comparableRules, [
                'comparableOtherColony'  => 'required|max:100'
            ]);
        }


        return  Validator::make(
            $this->all(),
            $comparableRules,
            [],
            $this->validateModalAttributes()
        );


    }



    protected function validateModalAttributes(): array {
        return [
            'comparableKey' => 'clave',
            'comparableFolio' => 'folio',
            'comparableDischargedBy' => 'dado de alta por',
            'Comparableproperty' => 'tipo de inmueble',
            'comparableCp' => 'código postal',
            'comparableEntity' => 'estado',
            'comparableLocality' => 'municipio',
            'comparableColony' => 'colonia',
            'comparableOtherColony' => 'otra colonia',
            'comparableStreet' => 'calle',
            'comparableAbroadNumber' => 'número exterior',
            'comparableInsideNumber' => 'número interior',
            'comparableBetweenStreet' => 'entre calle',
            'comparableAndStreet' => 'y calle',
            'comparableName' => 'nombre',
            'comparableLastName' => 'apellido',
            'comparablePhone' => 'teléfono',
            'comparableUrl' => 'URL',
            'comparablelandUse' => 'uso de suelo',
            'comparableFreeAreaRequired' => 'área libre requerido',
            'comparableAllowedLevels' => 'niveles permitidos',
            'comparableServicesInfraestructure' => 'servicios/infraestructura',
            'comparableDescServicesInfraestructure' => 'descripción de servicios/infraestructura',
            'comparableShape' => 'forma',
            'comparableSlope' => '% de pendiente',
            'comparableDensity' => 'densidad',
            'comparableFront' => 'frente (ML)',
            'comparableFrontType' => 'frente tipo',
            'comparableDescriptionForm' => 'descripción de forma',
            'comparableTopography' => 'topografía',
            'comparableCharacteristics' => 'características',
            'comparableCharacteristicsGeneral' => 'características generales',
            'comparableOffers' => 'oferta',
            'comparableLandArea' => 'superficie del terreno',
            'comparableBuiltArea' => 'superficie construida',
            'comparableUnitValue' => 'valor unitario',
            'comparableBargainingFactor' => 'factor de negociación',
            'comparableLocationBlock' => 'ubicación en la manzana',
            'comparableStreetLocation' => 'ubicación en la calle',
            'comparableGeneralPropArea' => 'clase general de la zona',
            'comparableUrbanProximityReference' => 'referencia de proximidad urbana',
            'comparableNumberFronts' => 'número de frentes',
            'comparableSourceInfImages' => 'fuente de imágenes',
            'comparablePhotos' => 'fotos',
            'comparableActive' => 'activo',
        ];
    }


    public function resetComparableFields()
    {
        $this->reset([
            'comparableCp',
            'comparableEntity',
            'comparableLocality',
            'comparableColony',
            'comparableOtherColony',
            'comparableStreet',
            'comparableAbroadNumber',
            'comparableInsideNumber',
            'comparableBetweenStreet',
            'comparableAndStreet',
            'comparableName',
            'comparableLastName',
            'comparablePhone',
            'comparableUrl',
            'comparablelandUse',
            'comparablefreeAreaRequired',
            'comparableAllowedLevels',
            'comparableServicesInfraestructure',
            'comparableDescServicesInfraestructure',
            'comparableShape',
            'comparableSlope',
            'comparableDensity',
            'comparableFront',
            'comparableFrontType',
            'comparableDescriptionForm',
            'comparableTopography',
            'comparableCharacteristics',
            'comparableCharacteristicsGeneral',
            'comparableOffers',
            'comparableLandArea',
            'comparableBuiltArea',
            'comparableUnitValue',
            'comparableBargainingFactor',
            'comparableLocationBlock',
            'comparableStreetLocation',
            'comparableGeneralPropArea',
            'comparableUrbanProximityReference',
            'comparableNumberFronts',
            'comparableSourceInfImages',
            'comparablePhotos',
            'comparableActive',
        ]);
    }


    //Función para volver a los formularios del avaluo
    public function backForms()
    {
        //Eliminamos la variable de sesión
        Session::pull('comparables-active-session');

        //Redirigimos al usuario a formIndex, específicamente a enfoque de mercado
        return $this->redirect(route('form.index', ['section' => 'market-focus']), navigate: true);
    }



    public function render()
    {
        return view('livewire.forms.comparables.comparables-index');
    }
}
