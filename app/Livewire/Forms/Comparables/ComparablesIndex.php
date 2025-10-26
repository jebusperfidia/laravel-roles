<?php

namespace App\Livewire\Forms\Comparables;


use App\Models\Forms\Comparable\ComparableModel;
use App\Models\Forms\Comparable\ValuationComparableModel;
use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Valuations\Valuation;
use Flux\Flux;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Validator;
use App\Services\DipomexService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
//use Livewire\Attributes\On;

class ComparablesIndex extends Component
{

    //Variable para mostrar el loader
    //public bool $isLoading = false;

    //Evento de escucha para ejecutar la función de asignación
    protected $listeners = ['assignedElement'];


    use WithFileUploads;

    public $comparablePhotosFile;

    // PROPIEDADES AGREGADAS PARA LATITUD Y LONGITUD
    //public float $comparableLatitude = 19.4326; // VALOR INICIAL DEFAULT (CDMX)
    //public float $comparableLongitude = -99.1332; // VALOR INICIAL DEFAULT (CDMX)

    // LISTENER PARA RECIBIR COORDENADAS DESDE JAVASCRIPT/ALPINE.JS
    //protected $listeners = ['set-map-coordinates' => 'setMapCoordinates'];

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
    public $comparableKey, $comparableFolio, $comparableDischargedBy, $comparableProperty,
    $comparableEntity, $comparableLocality, $comparableColony, $comparableOtherColony, $comparableStreet,
    $comparableBetweenStreet, $comparableAndStreet, $comparableCp,
    $comparableName, $comparableLastName, $comparablePhone, $comparableUrl, $comparableLandUse,
    $comparableDescServicesInfraestructure,
    $comparableServicesInfraestructure, $comparableShape, $comparableDensity,
    $comparableFront, $comparableFrontType, $comparableDescriptionForm, $comparableTopography,
    $comparableCharacteristics, $comparableCharacteristicsGeneral,  $comparableLocationBlock,
    $comparableStreetLocation, $comparableGeneralPropArea, $comparableUrbanProximityReference,
    $comparableSourceInfImages, $comparableActive;

    //Variables para obtener los nombres de estado, ciudad y colonia sin consultar API Dipomex
    public $comparableEntityName, $comparableLocalityName;

    public $comparableAbroadNumber, $comparableInsideNumber, $comparableAllowedLevels,
    $comparableNumberFronts;

    public float $comparableFreeAreaRequired, $comparableSlope, $comparableOffers, $comparableLandArea,
        $comparableBuiltArea, $comparableUnitValue, $comparableBargainingFactor;


    //Variable para guardar los comparables asignados al avaluo
    public $assignedComparables = [];



    public function mount(DipomexService $dipomex)
    {

        //Obtenemos los estados
        $this->states = $dipomex->getEstados();

        //Añadimos la variable de sesión que validará el acceso a este componente
        $this->id = Session::get('valuation_id');
        //Buscamos el valor del avaluó para mostrar el valor del folio correspondiente
        $this->valuation = Valuation::find($this->id);

        //Asignamos los comparables ya asignados al avalúo
        $this->loadAssignedComparables();

        //Inicializar variables de ejemplos
        $this->comparableKey = 01;
        $this->comparableFolio = $this->valuation->folio;

        $this->userSession = Auth::user();

        //dd($this->userSession->id);

        $this->comparableDischargedBy = $this->userSession->name;

     }

    // NUEVA FUNCIÓN PARA ACTUALIZAR COORDENADAS DESDE EL MAPA (JAVASCRIPT)
    /*  public function setMapCoordinates($latitude, $longitude)
    {
        $this->comparableLatitude = (float) $latitude;
        $this->comparableLongitude = (float) $longitude; */
    // OPCIONAL: MOSTRAR UN TOAST PARA CONFIRMAR LA ACTUALIZACIÓN
    /*        Toaster::info('Coordenadas actualizadas desde el mapa.');
    }

 */

     //Generamos una función para actualizar los valores de los comparables asignados al avaluo
    public function loadAssignedComparables(){
        $this->assignedComparables = $this->valuation->comparables()->orderByPivot('position')->get();
    }



   // #[On('assigned')]
    /* public function openForms(array $IdValuation) */
    public function assignedElement($idComparable)
    {
        //dd($this->userSession);

        //dd('El método llega con éxito', $idComparable);
        //return redirect()->route('form.index');


        /* $this->isLoading = true; */

        //Obtenemos el valor de la última posición asignada
        $max_position = $this->valuation->comparables()->max('position');

        //A ese valor le sumamos un 1 para asignar en la posición del nuevo elemento a asignar
        $new_position = $max_position + 1;

        ValuationComparableModel::create([
            'valuation_id' => $this->id,
            'comparable_id' => $idComparable,
            'created_by' => $this->userSession->id,
            'position' => $new_position
        ]);


        //Actualizamos la tabla de los comparables
        $this->dispatch('pg:eventRefresh-comparables-table');

        //Actualizamos los valores de la tabla de las asignaciones de comparables ligadas al avaluo
        $this->loadAssignedComparables();

        //Enviamos un mensaje para notificar al usuario sobre la correcta asignación
        Toaster::success('Comparable asignado correctamente.');

        //$this->dispatch('refreshComparablesTable');
        /* $this->isLoading = false; */
    }


    //Función para agregar un comparable para el avalúo
    public function openAddComparable()
    {
        $this->resetValidation();
        Flux::modal('add-comparable')->show();
    }

    public function save()
    {
        // Ejecutar función con todas las reglas de validación y validaciones condicionales, guardando todo en una variable
        $validator = $this->validateModal();

        // Comprobamos si se obtuvieron errores de validación
        if ($validator->fails()) {
            // Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            // Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            // Hacemos un return para detener el flujo del sistema

            //dd($validator->errors()->all());
            return;
        }

        // --- MANEJO Y SUBIDA DE ARCHIVO (Solo si la validación pasa) ---
        $photoPath = null;
        if ($this->comparablePhotosFile) {
            // Guarda el archivo en el disco 'public' y devuelve la ruta.
            $photoPath = $this->comparablePhotosFile->store('/', 'comparables_public');
        }

        // --- CREACIÓN DEL REGISTRO EN LA BASE DE DATOS (Mapeo completo) ---
        ComparableModel::create([
            'valuation_id' => $this->id,
            'comparable_key' => $this->comparableKey,
            'comparable_folio' => $this->comparableFolio,
            'comparable_discharged_by' => $this->comparableDischargedBy,
            'comparable_property' => $this->comparableProperty,
            'comparable_entity' => $this->comparableEntity,
            'comparable_entity_name' => $this->comparableEntityName,
            'comparable_locality' => $this->comparableLocality,
            'comparable_locality_name' => $this->comparableLocalityName,
            'comparable_colony' => $this->comparableColony,
            'comparable_other_colony' => $this->comparableOtherColony,
            'comparable_street' => $this->comparableStreet,
            'comparable_between_street' => $this->comparableBetweenStreet,
            'comparable_and_street' => $this->comparableAndStreet,
            'comparable_cp' => $this->comparableCp,
            'comparable_name' => $this->comparableName,
            'comparable_last_name' => $this->comparableLastName,
            'comparable_phone' => $this->comparablePhone,
            'comparable_url' => $this->comparableUrl,
            'comparable_land_use' => $this->comparableLandUse,
            'comparable_desc_services_infraestructure' => $this->comparableDescServicesInfraestructure,
            'comparable_services_infraestructure' => $this->comparableServicesInfraestructure,
            'comparable_shape' => $this->comparableShape,
            'comparable_density' => $this->comparableDensity,
            'comparable_front' => $this->comparableFront,
            'comparable_front_type' => $this->comparableFrontType,
            'comparable_description_form' => $this->comparableDescriptionForm,
            'comparable_topography' => $this->comparableTopography,
            'comparable_characteristics' => $this->comparableCharacteristics,
            'comparable_characteristics_general' => $this->comparableCharacteristicsGeneral,
            'comparable_location_block' => $this->comparableLocationBlock,
            'comparable_street_location' => $this->comparableStreetLocation,
            'comparable_general_prop_area' => $this->comparableGeneralPropArea,
            'comparable_urban_proximity_reference' => $this->comparableUrbanProximityReference,
            'comparable_source_inf_images' => $this->comparableSourceInfImages ?? '',
            'comparable_photos' => $photoPath, // <--- RUTA DEL ARCHIVO SUBIDO
            'comparable_abroad_number' => $this->comparableAbroadNumber,
            'comparable_inside_number' => $this->comparableInsideNumber,
            'comparable_allowed_levels' => $this->comparableAllowedLevels,
            'comparable_number_fronts' => $this->comparableNumberFronts,
            'comparable_free_area_required' => $this->comparableFreeAreaRequired,
            'comparable_slope' => $this->comparableSlope,
            'comparable_offers' => $this->comparableOffers,
            'comparable_land_area' => $this->comparableLandArea,
            'comparable_built_area' => $this->comparableBuiltArea,
            'comparable_unit_value' => $this->comparableUnitValue,
            'comparable_bargaining_factor' => $this->comparableBargainingFactor,
           // 'comparable_latitude' => $this->comparableLatitude,
            //'comparable_longitude' => $this->comparableLongitude,
            'is_active' => $this->comparableActive,
        ]);

        //Actualizamos la tabla
        $this->dispatch('pg:eventRefresh-comparables-table');

        // Limpiamos los campos después de guardar
        $this->resetComparableFields();

        // Enviamos mensaje de éxito
        Toaster::success('Comparable añadido exitosamente');


        // Cerramos el modal
        Flux::modal('add-comparable')->close();
    }



    //Función para búsqueda del código postal del propietario, usando API Dipomex
    //Las funciones se repiten para cáda uno, seperando la lógica y evitando que se mezclen los datos
    public function buscarCP(DipomexService $dipomex)
    {
        //Validamos que el campo no esté vacío y contenga 5 dígitos
        $this->validate(
            [
                'comparableCp' => 'required|string|digits:5',
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
            $this->reset(['comparableCp', 'comparableEntity', 'comparableLocality', 'comparableColony', 'municipalities', 'colonies', 'comparableEntityName', 'comparableLocalityName']);
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

        // <-- AGREGADO: Asignar el NOMBRE del estado
        $this->comparableEntityName = $data['estado'];
        //dd($this->comparableEntityName);

        // Poblar municipios inmediatamente
        $this->municipalities = $dipomex->getMunicipiosPorEstado($estadoId);
        //dd($this->municipalities);

        //Obtenemos el ID del municipio con base en el nombre
        $municipioId = array_search($data['municipio'], $this->municipalities);

        //Asignamos el valor del municipio
        $this->comparableLocality = $municipioId;

        // <-- AGREGADO: Asignar el NOMBRE del municipio
        $this->comparableLocalityName = $data['municipio'];

        // Asignar colonias
        $this->colonies = $data['colonias'];

        //dd($this->colonies);

        //dd($this->comparableLocalityName, $this->comparableEntityName, $this->comparableEntity, $this->comparableLocality);

        Toaster::success('Información encontrada correctamente.');
    }



    //Creamos un watcher para cuando se actualice el valor del select de estados
    //Este llamará al método del servicio para poblar los municipios
    //Creamos un watcher para cuando se actualice el valor del select de estados
    public function updatedComparableEntity($estadoId, DipomexService $dipomex)
    {
        // <-- MODIFICADO: Reiniciar también los nombres de ubicación al cambiar el estado
        $this->reset(['comparableLocality', 'comparableColony', 'municipalities', 'colonies', 'comparableLocalityName']);

        // <-- AGREGADO: Asignar el NOMBRE del estado si el ID es válido
        $this->comparableEntityName = $this->states[$estadoId] ?? null;

        if ($estadoId) {
            $this->municipalities = $dipomex->getMunicipiosPorEstado($estadoId);
        }
    }

    //Creamos un watcher para cuando se actualice el valor del select de municipios
    public function updatedComparableLocality($municipioId, DipomexService $dipomex)
    {
        // <-- MODIFICADO: Reiniciar también el nombre de la colonia al cambiar el municipio
        $this->reset(['comparableColony', 'colonies']);

        // <-- AGREGADO: Asignar el NOMBRE del municipio si el ID es válido
        // Asumiendo que $this->municipalities es un array ID => Nombre
        $this->comparableLocalityName = $this->municipalities[$municipioId] ?? null;

        if ($municipioId && $this->comparableEntity) {
            // Como ahora gi_ownerLocality tiene el MUNICIPIO_ID, lo pasamos directo
            $this->colonies = $dipomex->getColoniasPorMunicipio($this->comparableEntity, $municipioId);
        }
    }


    //Función para acortar URL usando URL clean https://urlclean.com
    public function shortUrl()
    {
        $this->validate([
            'comparableUrl' => 'required|url',
        ]);

        try {
            $response = Http::get('https://is.gd/create.php', [
                'format' => 'simple',
                'url' => $this->comparableUrl,
            ]);

            if ($response->successful()) {
                $short = trim($response->body());

                if (str_starts_with($short, 'Error:')) {
                    Toaster::error('Error al acortar la URL: ' . $short);
                    return;
                }

                $this->comparableUrl = $short;
                Toaster::success('URL acortada exitosamente.');
            } else {
                Toaster::error('No se pudo acortar la URL. Intenta de nuevo.');
            }
        } catch (\Exception $e) {
            Toaster::error('Error al conectar con is.gd: ' . $e->getMessage());
        }
    }


    /**
     * Mueve un comparable hacia arriba o abajo en la lista asignada
     *
     * @param int $idComparable ID del comparable que queremos mover
     * @param string $direction Dirección del movimiento: 'up' = subir, 'down' = bajar
     */
    public function moveComparable($idComparable, $direction)
    {
        // Buscamos el comparable que queremos mover dentro de la valoración actual
        // Usamos la relación 'comparables' y filtramos por el ID recibido
        $current = $this->valuation->comparables()->where('comparables.id', $idComparable)->first();

        // Si no existe, salimos de la función
        if (!$current) {
            return;
        }

        // Guardamos la posición actual de este comparable desde la tabla pivot
        // Ejemplo: si está en la posición 2, $currentPosition = 2
        $currentPosition = $current->pivot->position;

        // --- Caso "subir" ---
        if ($direction === 'up' && $currentPosition > 1) {
            // Buscamos el comparable que está justo arriba del actual
            // Ejemplo: si $currentPosition = 3, buscamos el que tiene posición = 2
            $swap = $this->valuation->comparables()->wherePivot('position', $currentPosition - 1)->first();

            if ($swap) {
                // Intercambiamos las posiciones en la tabla pivot
                // El comparable que estaba arriba ($swap) pasa a la posición actual del que se mueve
                $this->valuation->comparables()->updateExistingPivot($swap->id, ['position' => $currentPosition]);
                // El comparable actual pasa a la posición del que estaba arriba
                $this->valuation->comparables()->updateExistingPivot($current->id, ['position' => $currentPosition - 1]);
            }

            // --- Caso "bajar" ---
        } elseif ($direction === 'down') {
            // Primero obtenemos la posición máxima de los comparables asignados
            // Esto nos asegura no mover más allá del último
            $maxPosition = $this->valuation->comparables()
                ->max('valuation_comparables.position');

            if ($currentPosition < $maxPosition) {
                // Buscamos el comparable que está justo debajo del actual
                // Ejemplo: si $currentPosition = 2, buscamos el que tiene posición = 3
                $swap = $this->valuation->comparables()->wherePivot('position', $currentPosition + 1)->first();

                if ($swap) {
                    // Intercambiamos las posiciones
                    // El comparable que estaba abajo ($swap) pasa a la posición actual del que se mueve
                    $this->valuation->comparables()->updateExistingPivot($swap->id, ['position' => $currentPosition]);
                    // El comparable actual pasa a la posición del que estaba abajo
                    $this->valuation->comparables()->updateExistingPivot($current->id, ['position' => $currentPosition + 1]);
                }
            }
        }

        // Después de mover, reordenamos todas las posiciones para que queden consecutivas (1, 2, 3...)
        $this->reorderPositions();

        // Finalmente, recargamos la lista de comparables para refrescar la tabla en la vista
        $this->loadAssignedComparables();
    }


    /**
     * Reordena las posiciones de los comparables asignados
     * Esto evita huecos o duplicados después de mover o eliminar elementos
     */
    public function reorderPositions()
    {
        // Obtenemos todos los comparables asignados, ordenados por posición actual
        $comparables = $this->valuation->comparables()->orderByPivot('position')->get();

        $position = 1; // Empezamos a contar desde 1

        foreach ($comparables as $comp) {
            // Si la posición actual del pivot no coincide con la secuencia, la actualizamos
            // Ejemplo: si el primer comparable tiene position=2, lo cambiamos a 1
            if ($comp->pivot->position != $position) {
                $this->valuation->comparables()->updateExistingPivot($comp->id, ['position' => $position]);
            }

            $position++; // Incrementamos para el siguiente comparable
        }
    }








    public function validateModal(){
        // VALIDACIONES COMPARABLES
        $comparableRules = [
            'comparableKey' => 'required',
            'comparableFolio' => 'required',
            'comparableDischargedBy' => 'required',
            'comparableProperty' => 'required',
            'comparableCp' => 'required|string|digits:5',
            'comparableEntity' => 'required',
            //'comparableEntityName' => 'nullable',
            'comparableLocality' => 'required',
            //'comparableLocalityName' => 'nullable',
            'comparableColony' => 'required',
            /* 'comparableOtherColony' => 'required', */
            'comparableStreet' => 'required',
            'comparableAbroadNumber' => 'required',
            'comparableInsideNumber' => 'nullable',
            'comparableBetweenStreet' => 'required',
            'comparableAndStreet' => 'required',
            'comparableName' => 'required',
            'comparableLastName' => 'required',
            //Bail detiene las validaciones en cuanto ocurra el primero error y lo muestra en pantalla
            /* 'comparablePhone' => 'bail|required|regex:/^[0-9]+$/|digits_between:7,15', */
            'comparablePhone' => 'required',
            'comparableUrl' => 'required|url',
            'comparableLandUse' => 'required',
            'comparableFreeAreaRequired' => 'required|numeric|between:0,100',
            'comparableAllowedLevels' => 'required|integer',
            'comparableServicesInfraestructure' => 'nullable',
            'comparableDescServicesInfraestructure' => 'required',
            'comparableShape' => 'required',
            'comparableSlope' => 'required|numeric|between:0,100',
            'comparableDensity' => 'required',
            'comparableFront' => 'required',
            'comparableFrontType' => 'nullable',
            'comparableDescriptionForm' => 'nullable',
            'comparableTopography' => 'required',
            'comparableCharacteristics' => 'required',
            'comparableCharacteristicsGeneral' => 'nullable',
            'comparableOffers' => 'required|numeric|gt:0',
            'comparableLandArea' => 'required|numeric|gt:0',
            'comparableBuiltArea' => 'required|numeric|gt:0',
            'comparableUnitValue' => 'required|numeric|gt:0',
            'comparableBargainingFactor' => 'required|numeric|between:0.8,1',
            'comparableLocationBlock' => 'required',
            'comparableStreetLocation' => 'required',
            'comparableGeneralPropArea' => 'required',
            'comparableUrbanProximityReference' => 'required',
            'comparableNumberFronts' => 'required|integer',
            'comparableSourceInfImages' => 'required',
            //'comparablePhotos' => 'required',
            /* 'comparableActive' => 'required', */

            // REGLAS PARA COORDENADAS: REQUIERE UN VALOR NUMÉRICO VÁLIDO
            //'comparableLatitude' => 'required|numeric|between:-90,90',
            //'comparableLongitude' => 'required|numeric|between:-180,180',

            // Regla específica para el archivo de foto
            'comparablePhotosFile' => 'required|mimes:jpg,jpeg,png|max:2048', // Máximo 5MB
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
            'comparableProperty' => 'tipo de inmueble',
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
            'comparableLandUse' => 'uso de suelo',
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
            'comparablePhotosFile' => 'fotos',
            'comparableActive' => 'activo',

            // ATRIBUTOS AÑADIDOS PARA MENSAJES DE ERROR MÁS CLAROS
            'comparableLatitude' => 'latitud (Mapa)',
            'comparableLongitude' => 'longitud (Mapa)',
        ];
    }


    public function resetComparableFields()
    {
     /*    $this->comparableLatitude = 19.4326;
        $this->comparableLongitude = -99.1332; */


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
            'comparableLandUse',
            'comparableFreeAreaRequired',
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
            //'comparablePhotos',
            'comparableActive',

            'comparablePhotosFile', // Resetear el archivo temporal
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
