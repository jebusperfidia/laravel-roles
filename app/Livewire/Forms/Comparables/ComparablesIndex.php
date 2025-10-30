<?php

namespace App\Livewire\Forms\Comparables;


use App\Models\Forms\Comparable\ComparableModel;
use App\Models\Forms\Comparable\ValuationComparableModel;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Valuations\Valuation;
use Flux\Flux;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Validator;
use App\Services\DipomexService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
//Se importa flux para poder controlar el modal desde aquí

//use Livewire\Attributes\On;

class ComparablesIndex extends Component
{

    //Variable para mostrar el loader
    //public bool $isLoading = false;

    //Evento de escucha para ejecutar la función de asignación
    protected $listeners = ['assignedElement', 'editComparable', 'deallocatedElement', 'deleteElement'];


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

    public float $comparableFreeAreaRequired, $comparableSlope, $comparableOffers = 0, $comparableLandArea = 0,
        $comparableBuiltArea = 0, $comparableUnitValue = 0, $comparableBargainingFactor;


    //Variable para guardar los comparables asignados al avaluo
    public $assignedComparables = [];


    //Valor que se usará para la actualización de los comparables
    public $comparableId = null;


    public function mount(DipomexService $dipomex)
    {

        //Obtenemos los estados
        $this->states = $dipomex->getEstados();

        //Añadimos la variable de sesión que validará el acceso a este componente
        $this->id = Session::get('valuation_id');
        //Buscamos el valor del avaluó para mostrar el valor del folio correspondiente
        $this->valuation = Valuation::find($this->id);

        //Asignamos los comparables ya asignados al avalúo
        //$this->loadAssignedComparables();

        //Inicializar variables de ejemplos
        $this->comparableKey = 01;
        $this->comparableFolio = $this->valuation->folio;

        $this->userSession = Auth::user();

        //dd($this->userSession);

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

        //dd($this->assignedComparables);

        //dd($this->comparable);
    }




    //Función para abrirl modal de creación de comparable para el avalúo
    public function addComparable()
    {
        //Reseteamos las validaciones
        $this->resetValidation();
        //Reseteamos los campos del modal
        $this->resetComparableFields();
        //Abrimos el modal
        Flux::modal('modal-comparable')->show();
    }


    public function editComparable($idComparable, DipomexService $dipomex) {
        //Reseteamos las validaciones
        $this->resetValidation();
        //Reseteamos los campos del modal
        $this->resetComparableFields();

        $this->comparableId = $idComparable;

        //Usamos el id recibido para obtenemos los valoresl del comparable desde la BD
        $comparable = ComparableModel::find($idComparable);

        /* $this->comparable = $comparable; */


        // Mapeo completo de MODELO (snake_case) a PROPIEDADES (camelCase)
        $this->comparableKey = $comparable->comparable_key;
        $this->comparableFolio = $comparable->comparable_folio;
        $this->comparableDischargedBy = $comparable->comparable_discharged_by;
        $this->comparableProperty = $comparable->comparable_property;
        $this->comparableEntity = $comparable->comparable_entity;
        $this->comparableEntityName = $comparable->comparable_entity_name;
        $this->comparableLocality = $comparable->comparable_locality;
        $this->comparableLocalityName = $comparable->comparable_locality_name;
        $this->comparableColony = $comparable->comparable_colony;
        $this->comparableOtherColony = $comparable->comparable_other_colony;
        $this->comparableStreet = $comparable->comparable_street;
        $this->comparableBetweenStreet = $comparable->comparable_between_street;
        $this->comparableAndStreet = $comparable->comparable_and_street;
        $this->comparableCp = $comparable->comparable_cp;
        $this->comparableName = $comparable->comparable_name;
        $this->comparableLastName = $comparable->comparable_last_name;
        $this->comparablePhone = $comparable->comparable_phone;
        $this->comparableUrl = $comparable->comparable_url;
        $this->comparableLandUse = $comparable->comparable_land_use;
        $this->comparableDescServicesInfraestructure = $comparable->comparable_desc_services_infraestructure;
        $this->comparableServicesInfraestructure = $comparable->comparable_services_infraestructure;
        $this->comparableShape = $comparable->comparable_shape;
        $this->comparableDensity = $comparable->comparable_density;
        $this->comparableFront = $comparable->comparable_front;
        $this->comparableFrontType = $comparable->comparable_front_type;
        $this->comparableDescriptionForm = $comparable->comparable_description_form;
        $this->comparableTopography = $comparable->comparable_topography;
        $this->comparableCharacteristics = $comparable->comparable_characteristics;
        $this->comparableCharacteristicsGeneral = $comparable->comparable_characteristics_general;
        $this->comparableLocationBlock = $comparable->comparable_location_block;
        $this->comparableStreetLocation = $comparable->comparable_street_location;
        $this->comparableGeneralPropArea = $comparable->comparable_general_prop_area;
        $this->comparableUrbanProximityReference = $comparable->comparable_urban_proximity_reference;
        $this->comparableSourceInfImages = $comparable->comparable_source_inf_images;
        $this->comparableAbroadNumber = $comparable->comparable_abroad_number;
        $this->comparableInsideNumber = $comparable->comparable_inside_number;
        $this->comparableAllowedLevels = $comparable->comparable_allowed_levels;
        $this->comparableNumberFronts = $comparable->comparable_number_fronts;
        $this->comparableFreeAreaRequired = $comparable->comparable_free_area_required;
        $this->comparableSlope = $comparable->comparable_slope;

        // Campos que también son outputs de cálculo (aseguramos el tipo float)
        $this->comparableOffers = (float) $comparable->comparable_offers;
        $this->comparableLandArea = (float) $comparable->comparable_land_area;
        $this->comparableBuiltArea = (float) $comparable->comparable_built_area;
        $this->comparableUnitValue = (float) $comparable->comparable_unit_value;
        $this->comparableBargainingFactor = (float) $comparable->comparable_bargaining_factor;

        $this->comparableActive = $comparable->is_active;

        // Foto: Cargamos la RUTA existente en la propiedad del archivo.
        $this->comparablePhotosFile = $comparable->comparable_photos;

        /*  $this->comparable = $comparable; */

        // 1. Cargamos Localidades/Municipios (si la Entidad existe)
        if ($this->comparableEntity) {
            $this->municipalities = $dipomex->getMunicipiosPorEstado($this->comparableEntity);
        }


        // 2. Cargamos Colonias/Asentamientos (si la Localidad existe)
        if ($this->comparableLocality && $this->comparableCp) {
            // Asumo que tu servicio Dipomex tiene un método para buscar colonias por Localidad o CP
            // Utilizaremos la lógica del otro componente: buscar por CP.
            $data = $dipomex->buscarPorCodigoPostal($this->comparableCp);

            // Asignar las colonias obtenidas del CP
            $this->colonies = $data['colonias'] ?? [];
        }

        Flux::modal('modal-comparable')->show();
    }


    public function comparableUpdate(){
        // 1. Validaciones
        $validator = $this->validateModal();

        if ($validator->fails()) {
            Toaster::error('Existen errores de validación');
            $this->setErrorBag($validator->getMessageBag());
            return;
        }

        // --- 2. MANEJO DE FOTO Y RUTA FINAL ---

        // Inicializa la variable que finalmente se guardará en el campo 'comparable_photos'.
        // Si la lógica no encuentra nada, el valor final será null (eliminando la referencia de la foto).
        $photoPath = null;

        // ----------------------------------------------------------------------------------
        // CASO A: MANTENER FOTO EXISTENTE (Modo Edición)
        // ----------------------------------------------------------------------------------
        if (is_string($this->comparablePhotosFile) && $this->comparablePhotosFile) {

            // is_string(): Verifica que la propiedad contiene una CADENA (la ruta vieja que trajimos de la BD).
            // $this->comparablePhotosFile: Verifica que esa cadena no esté vacía o sea nula.

            // Si ambas son ciertas, simplemente mantenemos la ruta de la foto existente.
            $photoPath = $this->comparablePhotosFile;

            // ----------------------------------------------------------------------------------
            // CASO B: SUBIR Y REEMPLAZAR FOTO (Creación o Edición con archivo nuevo)
            // ----------------------------------------------------------------------------------
        } elseif ($this->comparablePhotosFile instanceof TemporaryUploadedFile) {

            // instanceof TemporaryUploadedFile: Verifica que el valor es un OBJETO de Livewire,
            // lo que significa que el usuario ha seleccionado un archivo nuevo para subir.

            // 1. Lógica de Eliminación de la Vieja Foto (Solo si estamos editando)
            if ($this->comparableId) {
                // Verifica si estamos en modo edición (si comparableId tiene un valor)

                $oldComparable = ComparableModel::find($this->comparableId);
                // Busca el comparable antiguo en la BD.

                if ($oldComparable && $oldComparable->comparable_photos) {
                    // Verifica que el registro exista y que tenga una ruta de foto guardada.

                    // Borramos el archivo del disco 'comparables_public'.
                    // Esto es crucial para no dejar archivos basura en el servidor.
                    Storage::disk('comparables_public')->delete(basename($oldComparable->comparable_photos));
                }
            }

            // 2. Subir la NUEVA foto al disco 'comparables_public'.
            // El método store devuelve la ruta o nombre de archivo que se debe guardar en la BD.
            $photoPath = $this->comparablePhotosFile->store('/', 'comparables_public');
        }

        // ----------------------------------------------------------------------------------
        // FALLBACK: ¿QUÉ PASA SI SE ELIMINÓ O NUNCA HUBO FOTO?
        // ----------------------------------------------------------------------------------

        // Si $this->comparablePhotosFile era NULL (el usuario la eliminó usando 'removePhoto' o nunca subió nada):
        // Las condiciones 'if' y 'elseif' fallan, y $photoPath se queda en 'null',
        // lo que actualizará el campo 'comparable_photos' de la BD a NULL.

        // --- 3. CREAR ARRAY DE DATOS ($data) ---
        $data = [
            //'valuation_id' => $this->id,
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
            'comparable_photos' => $photoPath, // <--- RUTA FINAL
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
            'is_active' => $this->comparableActive,
          /*   'created_by' => $this->userSession->id ?? null, */
        ];

        $comparable = ComparableModel::find($this->comparableId);


        $comparable->update($data);

        // 5. Limpieza y UI
        $this->resetComparableFields();
        // Asumo que el modal de creación/edición se llama 'modal-comparable'
        Flux::modal('modal-comparable')->close();

        // Refrescamos PowerGrid
        $this->dispatch('pg:eventRefresh-comparables-table');

        $this->comparableId = null;

        Toaster::success('Comparable actualzado con éxito');
    }




    // #[On('assigned')]
    /* public function openForms(array $IdValuation) */
    public function assignedElement($idComparable, $showToaster = true)
    {


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
        // Solo mostramos el toaster si $showToaster es true
        if ($showToaster) {
            Toaster::success('Comparable asignado correctamente.');
        }

        //$this->dispatch('refreshComparablesTable');
        /* $this->isLoading = false; */
    }


    //Método para desasignar un comparable
    public function deallocatedElement($idComparable)
    {
        //dd('El método llega con éxito', $idComparable);


        //Primero encontramos el registro de la tabla valuation_comparables
        $valuationComparable = ValuationComparableModel::where('valuation_id', $this->id)->where('comparable_id', $idComparable)->first();

        //dd($valuationComparable);

        //Si existe alguna coincidencia, se elimina el registro, de no ser así, se omite
        $valuationComparable?->delete();

        //Primero ejecutamos la función de reordenar los elementos
        $this->reorderPositions();

        //Refrescamos la tabla de comparables
        $this->loadAssignedComparables();

        //Refrescamos la tabla de comparables x asignar
        $this->dispatch('pg:eventRefresh-comparables-table');

        //Finalmente, enviamos un mensaje en pantalla indicamando que el comparable fue desasignado
        Toaster::success('Comparable desasignado correctamente.');


    }


    public function deleteElement($idComparable)
    {

        $assignmentCount = ValuationComparableModel::where('comparable_id', $idComparable)->count();

        //dd($assignmentCount);

        if ($assignmentCount < 1) {

            $comparable = ComparableModel::find($idComparable);
            $comparable->delete();

        //Primero ejecutamos la función de reordenar los elementos
        $this->reorderPositions();

        //Refrescamos la tabla de comparables
        $this->loadAssignedComparables();

        //Refrescamos la tabla de comparables x asignar
        $this->dispatch('pg:eventRefresh-comparables-table');

        //Finalmente, enviamos un mensaje en pantalla indicamando que el comparable fue desasignado
        Toaster::success('Comparable eliminado correctamente.');

        } else {
            Toaster::error('No se puede eliminar comparable, está asiagnado a '.$assignmentCount.' avaluo(s). Desasígnalo primero.');
    }

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
        $comparable = ComparableModel::create([
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
            'created_by' => $this->userSession->id,
        ]);

        //Asignamos el comparable recién creado directo al avalúo
        $this->assignedElement($comparable->id, false);

        //Actualizamos la tabla
        $this->dispatch('pg:eventRefresh-comparables-table');

        // Limpiamos los campos después de guardar
        $this->resetComparableFields();

        // Enviamos mensaje de éxito
        Toaster::success('Comparable añadido exitosamente');


        // Cerramos el modal
        Flux::modal('modal-comparable')->close();
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



    //FUNCIONES DE WATCHER
    public function updatedComparableOffers($value){
        if($value < 0){
            $this->comparableOffers = 0;
        }

        $this->calcUnitValue();
    }

    public function updatedComparableLandArea($value){
        if($value < 0){
            $this->comparableLandArea = 0;
        }

        $this->calcUnitValue();
    }


    public function calcUnitValue(){

        // Primero nos aseguramos que ambas variables sean tratadas como floats (o 0 si son null/vacio)
        $offers = (float) $this->comparableOffers;
        $area = (float) $this->comparableLandArea;


        // El divisor (área) no puede ser cero. Si lo es, o si la oferta es 0, el resultado es 0.
        if ($area === 0.0 || $offers === 0.0) {
            $this->comparableUnitValue = 0.0;
            return;
        }

        //Obtenemos el cálculo con las variables ya seteadas
        $result = $offers / $area;

        //Forzamos a que el resultado siempre sea mayor a 0
        $this->comparableUnitValue = max(0.0, $result);

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
            'comparableNumberFronts' => 'nullable|integer',
            'comparableSourceInfImages' => 'required',
            //'comparablePhotos' => 'required',
            /* 'comparableActive' => 'required', */

            // REGLAS PARA COORDENADAS: REQUIERE UN VALOR NUMÉRICO VÁLIDO
            //'comparableLatitude' => 'required|numeric|between:-90,90',
            //'comparableLongitude' => 'required|numeric|between:-180,180',

        ];

        if($this->comparableOtherColony === 'no-listada'){
            $comparableRules = array_merge($comparableRules, [
                'comparableOtherColony'  => 'required|max:100'
            ]);
        }

        $fileExists = $this->comparablePhotosFile && is_string($this->comparablePhotosFile);


        if($fileExists) {
            $comparableRules = array_merge($comparableRules, [

                'comparablePhotosFile'  => 'nullable|string'
            ]);
        } else {


            if ($this->comparableId === null) {
            $comparableRules = array_merge(
                $comparableRules,
                [
             'comparablePhotosFile'  => 'nullable|file|image|max:1024']);
                } else {
                $comparableRules = array_merge(
                    $comparableRules,
                    [
                        'comparablePhotosFile'  => 'required|file|image|max:1024'
                    ]
                );
                }
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
        $this->loadAssignedComparables();
        return view('livewire.forms.comparables.comparables-index');
    }
}
