<?php

namespace App\Livewire\Forms\Comparables;


use App\Models\Forms\Comparable\ComparableModel;
use App\Models\Forms\Comparable\ValuationLandComparableModel;
use App\Models\Forms\Comparable\ValuationBuildingComparableModel;
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
use Illuminate\Support\Str; // <-- Import Str to avoid Undefined type error
//Se importa flux para poder controlar el modal desde aquí
use App\Services\HomologationComparableService;
use App\Models\Forms\Homologation\HomologationComparableSelectionModel;

//use Livewire\Attributes\On;

class ComparablesIndex extends Component
{


    // Arrays públicos para consumir datos para los input select largos
    public array $levels_input;

    //Variable para mostrar el loader
    //public bool $isLoading = false;

    //Evento de escucha para ejecutar la función de asignación
    protected $listeners = ['assignedElement', 'editComparable', 'deallocatedElement', 'deleteElement', 'copyComparable'];


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
    /*  public $comparableKey, $comparableFolio, $comparableDischargedBy, $comparableProperty,
    $comparableEntity, $comparableLocality, $comparableColony, $comparableOtherColony, $comparableStreet,
    $comparableBetweenStreet, $comparableAndStreet, $comparableCp,
    $comparableName, $comparableLastName, $comparablePhone, $comparableUrl, $comparableLandUse,
    $comparableDescServicesInfraestructure,
    $comparableServicesInfraestructure, $comparableShape, $comparableDensity,
    $comparableFront, $comparableFrontType, $comparableDescriptionForm, $comparableTopography,
    $comparableCharacteristics, $comparableCharacteristicsGeneral,  $comparableLocationBlock,
    $comparableStreetLocation, $comparableGeneralPropArea, $comparableUrbanProximityReference,
    $comparableSourceInfImages, $comparableActive; */

    //Variables para obtener los nombres de estado, ciudad y colonia sin consultar API Dipomex
    /*   public $comparableEntityName, $comparableLocalityName;

    public $comparableAbroadNumber, $comparableInsideNumber, $comparableAllowedLevels,
    $comparableNumberFronts; */

    /*  public float $comparableFreeAreaRequired, $comparableSlope, $comparableOffers = 0, $comparableLandArea = 0,
        $comparableBuiltArea = 0, $comparableUnitValue = 0, $comparableBargainingFactor;
 */

    // --- CAMPOS COMPARTIDOS (Ambos tipos) ---
    public $comparableFolio, $comparableDischargedBy, $comparableProperty,
        $comparableEntity, $comparableLocality, $comparableColony, $comparableOtherColony, $comparableStreet,
        $comparableBetweenStreet, $comparableAndStreet, $comparableCp,
        $comparableName, $comparableLastName, $comparablePhone, $comparableUrl,
        $comparableCharacteristics, $comparableCharacteristicsGeneral,  $comparableLocationBlock,
        $comparableStreetLocation, $comparableGeneralPropArea, $comparableUrbanProximityReference,
        $comparableSourceInfImages, $comparableActive = true; // <--- Inicializado en true

    //Variables para obtener los nombres de estado, ciudad y colonia sin consultar API Dipomex
    public $comparableEntityName, $comparableLocalityName;

    public $comparableAbroadNumber, $comparableInsideNumber, $comparableNumberFronts;

    // **NOTA: comparableLandArea movido aquí (es común según el nuevo Blade)**
    public float $comparableOffers = 0, $comparableLandArea = 0, $comparableBuiltArea = 0, $comparableUnitValue = 0, $comparableBargainingFactor;


    // --- CAMPOS ESPECÍFICOS DE LAND (Terreno) ---
    public $comparableLandUse, $comparableDescServicesInfraestructure,
        $comparableServicesInfraestructure, $comparableShape, $comparableDensity,
        $comparableFront, $comparableFrontType, $comparableDescriptionForm, $comparableTopography,
        $comparableAllowedLevels;

    public float $comparableFreeAreaRequired = 0, $comparableSlope = 0;


    // --- CAMPOS ESPECÍFICOS DE BUILDING (Construcción) ---
    public $comparableNumberBedrooms, $comparableNumberToilets, $comparableNumberHalfbaths,
        $comparableNumberParkings, $comparableFeaturesAmenities, $comparableNumberFloorLevel,
        $comparableQuality, $comparableConservation, $comparableLevels, $comparableClasification,
        $comparableAge, $comparableVut;

    public bool $comparableElevator = false, $comparableStore = false, $comparableRoofGarden = false; // <--- Inicializados

    public float $comparableSeleableArea = 0;


    //Variable para guardar los comparables asignados al avaluo
    public $assignedComparables = [];


    //Valor que se usará para la actualización de los comparables
    public $comparableId = null;

    //Obtenemos el valor del tipo de comparable
    public $comparableType;

    //Variable para mostrar el valor del futuro ID al crear comparable o el valor real al editar
    public $comparableInformativeId;

    public function mount(DipomexService $dipomex)
    {

        //Obtenemos el valor de los niveles para el input correspondiente
        //desde el archivo de configuración
        $this->levels_input = config('properties_inputs.levels', []);

        $this->comparableType = Session::get('comparable-type');

        //dd($this->comparableType);

        //Obtenemos los estados
        $this->states = $dipomex->getEstados();

        //Añadimos la variable de sesión que validará el acceso a este componente
        $this->id = Session::get('valuation_id');
        //Buscamos el valor del avaluó para mostrar el valor del folio correspondiente
        $this->valuation = Valuation::find($this->id);

        //Asignamos los comparables ya asignados al avalúo
        //$this->loadAssignedComparables();

        //Inicializar variables de ejemplos
        //$this->comparableKey = 01;
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
    public function loadAssignedComparables()
    {

        if ($this->comparableType === 'land') {
            $this->assignedComparables = $this->valuation->landComparables()->orderByPivot('position')->get();
        } else {
            $this->assignedComparables = $this->valuation->buildingComparables()->orderByPivot('position')->get();
        }

        //dd($this->assignedComparables);

        //dd($this->comparable);
    }

    //Función del listener que se recibe desde el summary para generar la copia del comparable
    public function copyComparable(int $id)
    {
        // 1. Buscamos el comparable original.
        $original = ComparableModel::find($id);

        if (!$original) {
            session()->flash('error', 'No se encontró el comparable original para duplicar.');
            return;
        }

        // 2. Usamos replicate() para copiar todos los atributos.
        $newComparable = $original->replicate();

        // *** CORRECCIÓN CRÍTICA FINAL: Asignar el nuevo comparable al Avalúo actual ($this->id) ***
        $newComparable->valuation_id = $this->id;

        // 3. Lógica de Copia de Imágenes y Corrección de Nulabilidad
        $newComparable->comparable_photos = '';

        if ($original->comparable_photos) {
            try {
                // Generamos un nombre de archivo único para la copia
                $newFileName = time() . '_' . Str::random(10) . '_' . $original->comparable_photos;

                // Usamos Storage para copiar el archivo
                if (Storage::disk('public')->exists('comparables/' . $original->comparable_photos)) {
                    Storage::disk('public')->copy(
                        'comparables/' . $original->comparable_photos,
                        'comparables/' . $newFileName
                    );
                    $newComparable->comparable_photos = $newFileName;
                }
            } catch (\Exception $e) {
                session()->flash('warning', 'Comparable duplicado, pero la imagen original no pudo ser copiada. Favor de verificar el archivo.');
            }
        }

        // 4. Guardar el nuevo comparable en la BBDD.
        $newComparable->save();

        // 5. Cerrar el modal y recargar las tablas.
        Flux::modal('comparable-summary')->close();

        // Disparos para recargar datos en las tablas (Lógica validada por ti)
        if ($this->comparableType === 'land') {
            $this->dispatch('pg:eventRefresh-comparables-land-table');
        } else {
            $this->dispatch('pg:eventRefresh-comparables-building-table');
        }

        $this->dispatch('refreshData');


        Toaster::success('Comparable copiado exitosamente');
        //session()->flash('success', '¡Comparable duplicado exitosamente y ligado al avalúo actual!');
    }


    //Función para abrirl modal de creación de comparable para el avalúo
    public function addComparable()
    {

        //Reseteamos el valor del comparableId para poder ver el botón de agregar y el título condicional en la vista
        $this->comparableId = null;

        //Reseteamos las validaciones
        $this->resetValidation();
        //Reseteamos los campos del modal
        $this->resetComparableFields();

        //Obtenemos el valor del próximo ID o el que se asignará para el nuevo comparable
        $this->comparableInformativeId = ComparableModel::max('id') + 1;

        //Abrimos el modal
        Flux::modal('modal-comparable')->show();
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
        /*   $comparable = ComparableModel::create([
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
            'comparable_photos' => $photoPath,
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
            'created_by' => $this->userSession->id,
        ]);*/

        // --- 1. DATOS COMUNES ---
        // (Campos que se guardan sin importar el tipo)
        // --- 1. DATOS COMUNES (Campos que se guardan sin importar el tipo) ---
        $data = [
            'valuation_id' => $this->id,
            //'comparable_key' => $this->comparableKey,
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
            // 'comparable_number_fronts' => $this->comparableNumberFronts, // Omitido (no en Blade)
            'comparable_offers' => $this->comparableOffers,
            'comparable_land_area' => $this->comparableLandArea, // <--- CAMBIO: Ahora es común
            'comparable_built_area' => $this->comparableBuiltArea,
            'comparable_unit_value' => $this->comparableUnitValue,
            'comparable_bargaining_factor' => $this->comparableBargainingFactor,
            // 'comparable_latitude' => $this->comparableLatitude,
            //'comparable_longitude' => $this->comparableLongitude,
            'is_active' => $this->comparableActive,
            'created_by' => $this->userSession->id,
            'comparable_type' => $this->comparableType, // <-- MUY IMPORTANTE
        ];

        // --- 2. DATOS ESPECÍFICOS (Condicional) ---
        if ($this->comparableType === 'land') {
            $landData = [
                'comparable_land_use' => $this->comparableLandUse,
                'comparable_desc_services_infraestructure' => $this->comparableDescServicesInfraestructure,
                'comparable_services_infraestructure' => $this->comparableServicesInfraestructure,
                'comparable_shape' => $this->comparableShape,
                'comparable_density' => $this->comparableDensity,
                //'comparable_front' => $this->comparableFront,
                //'comparable_front_type' => $this->comparableFrontType,
                'comparable_front' => ($this->comparableFront === '' || $this->comparableFront === null) ? null : $this->comparableFront,
                'comparable_front_type' => ($this->comparableFrontType === '' || $this->comparableFrontType === null) ? null : $this->comparableFrontType,
                'comparable_description_form' => $this->comparableDescriptionForm,
                'comparable_topography' => $this->comparableTopography,
                'comparable_allowed_levels' => $this->comparableAllowedLevels,
                'comparable_free_area_required' => $this->comparableFreeAreaRequired,
                'comparable_slope' => $this->comparableSlope,
            ];
            // Limpieza de campos Building
            $nullBuildingData = [
                'comparable_number_bedrooms' => null,
                'comparable_number_toilets' => null,
                'comparable_number_halfbaths' => null,
                'comparable_number_parkings' => null,
                'comparable_features_amenities' => null,
                'comparable_floor_level' => null,
                'comparable_quality' => null,
                'comparable_conservation' => null,
                'comparable_levels' => null,
                'comparable_clasification' => null,
                'comparable_age' => null,
                'comparable_vut' => null,
                'comparable_elevator' => false,
                'comparable_store' => false,
                'comparable_roof_garden' => false,
                'comparable_seleable_area' => null,
            ];
            $data = array_merge($data, $landData, $nullBuildingData);
        } elseif ($this->comparableType === 'building') {
            $buildingData = [
                'comparable_number_bedrooms' => $this->comparableNumberBedrooms,
                'comparable_number_toilets' => $this->comparableNumberToilets,
                'comparable_number_halfbaths' => $this->comparableNumberHalfbaths,
                'comparable_number_parkings' => $this->comparableNumberParkings,
                'comparable_features_amenities' => $this->comparableFeaturesAmenities,
                'comparable_floor_level' => $this->comparableNumberFloorLevel,
                'comparable_quality' => $this->comparableQuality,
                'comparable_conservation' => $this->comparableConservation,
                'comparable_levels' => $this->comparableLevels,
                'comparable_clasification' => $this->comparableClasification,
                'comparable_age' => $this->comparableAge,
                'comparable_vut' => $this->comparableVut,
                'comparable_elevator' => $this->comparableElevator,
                'comparable_store' => $this->comparableStore,
                'comparable_roof_garden' => $this->comparableRoofGarden,
                'comparable_seleable_area' => $this->comparableSeleableArea,
            ];
            // Limpieza de campos Land
            $nullLandData = [
                'comparable_land_use' => null,
                'comparable_desc_services_infraestructure' => null,
                'comparable_services_infraestructure' => null,
                'comparable_shape' => null,
                'comparable_density' => null,
                'comparable_front' => null,
                'comparable_front_type' => null,
                'comparable_description_form' => null,
                'comparable_topography' => null,
                'comparable_allowed_levels' => null,
                'comparable_free_area_required' => null,
                'comparable_slope' => null,
                // comparable_land_area ya es común, no se anula
            ];
            $data = array_merge($data, $buildingData, $nullLandData);
        }


        // --- 3. CREACIÓN DEL REGISTRO ---
        $comparable = ComparableModel::create($data);

        //Asignamos el comparable recién creado directo al avalúo
        $this->assignedElement($comparable->id, false);


        //Actualizamos la tabla (CORREGIDO)
        if ($this->comparableType === 'land') {
            $this->dispatch('pg:eventRefresh-comparables-land-table');
        } else {
            $this->dispatch('pg:eventRefresh-comparables-building-table');
        }

        // Limpiamos los campos después de guardar
        $this->resetComparableFields();

        // Enviamos mensaje de éxito
        Toaster::success('Comparable añadido exitosamente');


        // Cerramos el modal
        Flux::modal('modal-comparable')->close();
    }






    public function editComparable($idComparable, DipomexService $dipomex)
    {
        //Reseteamos las validaciones
        $this->resetValidation();
        //Reseteamos los campos del modal
        $this->resetComparableFields();

        $this->comparableId = $idComparable;

        // *** LÓGICA DE EDICIÓN: Asignar el ID real para mostrar ***
        $this->comparableInformativeId = $idComparable;

        //Usamos el id recibido para obtenemos los valoresl del comparable desde la BD
        $comparable = ComparableModel::find($idComparable);




        // Mapeo completo de MODELO (snake_case) a PROPIEDADES (camelCase)
        /*  $this->comparableKey = $comparable->comparable_key;
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


        $this->comparableOffers = (float) $comparable->comparable_offers;
        $this->comparableLandArea = (float) $comparable->comparable_land_area;
        $this->comparableBuiltArea = (float) $comparable->comparable_built_area;
        $this->comparableUnitValue = (float) $comparable->comparable_unit_value;
        $this->comparableBargainingFactor = (float) $comparable->comparable_bargaining_factor;

        $this->comparableActive = $comparable->is_active;


        $this->comparablePhotosFile = $comparable->comparable_photos;
 */
        // --- Mapeo de Campos Comunes ---
        // --- Mapeo de Campos Comunes ---
        //$this->comparableKey = $comparable->comparable_key;
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
        $this->comparableCharacteristics = $comparable->comparable_characteristics;
        $this->comparableCharacteristicsGeneral = $comparable->comparable_characteristics_general;
        $this->comparableLocationBlock = $comparable->comparable_location_block;
        $this->comparableStreetLocation = $comparable->comparable_street_location;
        $this->comparableGeneralPropArea = $comparable->comparable_general_prop_area;
        $this->comparableUrbanProximityReference = $comparable->comparable_urban_proximity_reference;
        $this->comparableSourceInfImages = $comparable->comparable_source_inf_images;
        $this->comparableAbroadNumber = $comparable->comparable_abroad_number;
        $this->comparableInsideNumber = $comparable->comparable_inside_number;
        // $this->comparableNumberFronts = $comparable->comparable_number_fronts; // Omitido (no en Blade)
        $this->comparableActive = $comparable->is_active;
        $this->comparablePhotosFile = $comparable->comparable_photos; // Foto: Cargamos la RUTA

        // Campos (float) comunes
        $this->comparableOffers = (float) $comparable->comparable_offers;
        $this->comparableLandArea = (float) $comparable->comparable_land_area; // <--- CAMBIO: Ahora es común
        $this->comparableBuiltArea = (float) $comparable->comparable_built_area;
        $this->comparableUnitValue = (float) $comparable->comparable_unit_value;
        $this->comparableBargainingFactor = (float) $comparable->comparable_bargaining_factor;

        // --- Mapeo de Campos Land ---
        $this->comparableLandUse = $comparable->comparable_land_use;
        $this->comparableDescServicesInfraestructure = $comparable->comparable_desc_services_infraestructure;
        $this->comparableServicesInfraestructure = $comparable->comparable_services_infraestructure;
        $this->comparableShape = $comparable->comparable_shape;
        $this->comparableDensity = $comparable->comparable_density;
        $this->comparableFront = $comparable->comparable_front;
        $this->comparableFrontType = $comparable->comparable_front_type;
        $this->comparableDescriptionForm = $comparable->comparable_description_form;
        $this->comparableTopography = $comparable->comparable_topography;
        $this->comparableAllowedLevels = $comparable->comparable_allowed_levels;
        $this->comparableFreeAreaRequired = (float) $comparable->comparable_free_area_required;
        $this->comparableSlope = (float) $comparable->comparable_slope;

        // --- Mapeo de Campos Building ---
        $this->comparableNumberBedrooms = $comparable->comparable_number_bedrooms;
        $this->comparableNumberToilets = $comparable->comparable_number_toilets;
        $this->comparableNumberHalfbaths = $comparable->comparable_number_halfbaths;
        $this->comparableNumberParkings = $comparable->comparable_number_parkings;
        $this->comparableFeaturesAmenities = $comparable->comparable_features_amenities;
        $this->comparableNumberFloorLevel = $comparable->comparable_floor_level;
        $this->comparableQuality = $comparable->comparable_quality;
        $this->comparableConservation = $comparable->comparable_conservation;
        $this->comparableLevels = $comparable->comparable_levels;
        $this->comparableClasification = $comparable->comparable_clasification;
        $this->comparableAge = $comparable->comparable_age;
        $this->comparableVut = $comparable->comparable_vut;
        $this->comparableElevator = (bool) $comparable->comparable_elevator;
        $this->comparableStore = (bool) $comparable->comparable_store;
        $this->comparableRoofGarden = (bool) $comparable->comparable_roof_garden;
        $this->comparableSeleableArea = (float) $comparable->comparable_seleable_area;


        // 1. Verificamos que tengamos un CP para buscar
        if ($this->comparableCp) {
            $data = $dipomex->buscarPorCodigoPostal($this->comparableCp);

            if ($data && isset($data['estado'])) {
                // 2. Buscar el ID del estado con base en el nombre devuelto
                // (Asumiendo que $this->states ya fue cargado en el mount() o aquí)
                if (empty($this->states)) {
                    $this->states = $dipomex->getEstados(); // Aseguramos que los estados estén cargados
                }
                $estadoId = array_search($data['estado'], $this->states);

                if ($estadoId !== false) {
                    $this->comparableEntity = $estadoId; // Re-asignamos el ID del estado
                }

                // 3. Poblar municipios (AHORA que tenemos el ID del estado correcto)
                $this->municipalities = $dipomex->getMunicipiosPorEstado($this->comparableEntity);

                // 4. Buscar el ID del municipio con base en el nombre devuelto
                $municipioId = array_search($data['municipio'], $this->municipalities);
                if ($municipioId !== false) {
                    $this->comparableLocality = $municipioId; // Re-asignamos el ID del municipio
                }

                // 5. Asignar colonias
                // $this->comparableColony ya tiene el nombre correcto de la BD.
                // Solo poblamos la lista para que el <select> pueda encontrarlo.
                $this->colonies = $data['colonias'] ?? [];
            }
        }
        Flux::modal('modal-comparable')->show();
    }


    public function comparableUpdate()
    {
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
        /*  $data = [
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
            'comparable_photos' => $photoPath,
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
        ];
 */


        // (Campos comunes que siempre se actualizan)
        $data = [
            //'comparable_key' => $this->comparableKey,
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
            // 'comparable_number_fronts' => $this->comparableNumberFronts, // Omitido (no en Blade)
            'comparable_offers' => $this->comparableOffers,
            'comparable_land_area' => $this->comparableLandArea, // <--- CAMBIO: Ahora es común
            'comparable_built_area' => $this->comparableBuiltArea,
            'comparable_unit_value' => $this->comparableUnitValue,
            'comparable_bargaining_factor' => $this->comparableBargainingFactor,
            'is_active' => $this->comparableActive,
            // No actualizamos 'created_by' ni 'comparable_type'
        ];

        // --- 4. DATOS ESPECÍFICOS (Condicional) ---
        if ($this->comparableType === 'land') {
            $landData = [
                'comparable_land_use' => $this->comparableLandUse,
                'comparable_desc_services_infraestructure' => $this->comparableDescServicesInfraestructure,
                'comparable_services_infraestructure' => $this->comparableServicesInfraestructure,
                'comparable_shape' => $this->comparableShape,
                'comparable_density' => $this->comparableDensity,
                'comparable_front' => ($this->comparableFront === '' || $this->comparableFront === null) ? null : $this->comparableFront,
                'comparable_front_type' => ($this->comparableFrontType === '' || $this->comparableFrontType === null) ? null : $this->comparableFrontType,
                'comparable_description_form' => $this->comparableDescriptionForm,
                'comparable_topography' => $this->comparableTopography,
                'comparable_allowed_levels' => $this->comparableAllowedLevels,
                'comparable_free_area_required' => $this->comparableFreeAreaRequired,
                'comparable_slope' => $this->comparableSlope,
            ];
            // Limpieza de campos Building
            $nullBuildingData = [
                'comparable_number_bedrooms' => null,
                'comparable_number_toilets' => null,
                'comparable_number_halfbaths' => null,
                'comparable_number_parkings' => null,
                'comparable_features_amenities' => null,
                'comparable_floor_level' => null,
                'comparable_quality' => null,
                'comparable_conservation' => null,
                'comparable_levels' => null,
                'comparable_clasification' => null,
                'comparable_age' => null,
                'comparable_vut' => null,
                'comparable_elevator' => false,
                'comparable_store' => false,
                'comparable_roof_garden' => false,
                'comparable_seleable_area' => null,
            ];
            $data = array_merge($data, $landData, $nullBuildingData);
        } elseif ($this->comparableType === 'building') {
            $buildingData = [
                'comparable_number_bedrooms' => $this->comparableNumberBedrooms,
                'comparable_number_toilets' => $this->comparableNumberToilets,
                'comparable_number_halfbaths' => $this->comparableNumberHalfbaths,
                'comparable_number_parkings' => $this->comparableNumberParkings,
                'comparable_features_amenities' => $this->comparableFeaturesAmenities,
                'comparable_floor_level' => $this->comparableNumberFloorLevel,
                'comparable_quality' => $this->comparableQuality,
                'comparable_conservation' => $this->comparableConservation,
                'comparable_levels' => $this->comparableLevels,
                'comparable_clasification' => $this->comparableClasification,
                'comparable_age' => $this->comparableAge,
                'comparable_vut' => $this->comparableVut,
                'comparable_elevator' => $this->comparableElevator,
                'comparable_store' => $this->comparableStore,
                'comparable_roof_garden' => $this->comparableRoofGarden,
                'comparable_seleable_area' => $this->comparableSeleableArea,
            ];
            // Limpieza de campos Land
            $nullLandData = [
                'comparable_land_use' => null,
                'comparable_desc_services_infraestructure' => null,
                'comparable_services_infraestructure' => null,
                'comparable_shape' => null,
                'comparable_density' => null,
                'comparable_front' => null,
                'comparable_front_type' => null,
                'comparable_description_form' => null,
                'comparable_topography' => null,
                'comparable_allowed_levels' => null,
                'comparable_free_area_required' => null,
                'comparable_slope' => null,
            ];
            $data = array_merge($data, $buildingData, $nullLandData);
        }

        $comparable = ComparableModel::find($this->comparableId);


        $comparable->update($data);

        // 5. Limpieza y UI
        $this->resetComparableFields();
        // Asumo que el modal de creación/edición se llama 'modal-comparable'
        Flux::modal('modal-comparable')->close();

        // Refrescamos PowerGrid
        /* $this->dispatch('pg:eventRefresh-comparables-table'); */
        if ($this->comparableType === 'land') {
            $this->dispatch('pg:eventRefresh-comparables-land-table');
        } else {
            $this->dispatch('pg:eventRefresh-comparables-building-table');
        }

        $this->comparableId = null;

        Toaster::success('Comparable actualzado con éxito');
    }




    // #[On('assigned')]
    /* public function openForms(array $IdValuation) */
    public function assignedElement($idComparable, $showToaster = true)
    {


        // 2. "Sin Complicaciones" - Obtenemos el servicio aquí
        $comparableService = app(HomologationComparableService::class);

        // 3. ¡¡¡LA CORRECCIÓN CRÍTICA!!!
        // Buscamos el comparable para saber su TIPO REAL, no usamos el de la sesión.
        $comparable = ComparableModel::find($idComparable);
        if (!$comparable) {
            return;
        }
        $itemType = $comparable->comparable_type;

        // 1. Obtener posición nueva
        $max_position = $this->comparableType === 'land'
            ? $this->valuation->landComparables()->max('position')
            : $this->valuation->buildingComparables()->max('position');

        $new_position = ($max_position ?? 0) + 1;

        // 2. Crear la relación valuation <-> comparable
        if ($this->comparableType === 'land') {
            $pivot =  ValuationLandComparableModel::create([
                'valuation_id' => $this->id,
                'comparable_id' => $idComparable,
                'created_by' => $this->userSession->id,
                'position' => $new_position
            ]);
        } else {
            $pivot = ValuationBuildingComparableModel::create([
                'valuation_id' => $this->id,
                'comparable_id' => $idComparable,
                'created_by' => $this->userSession->id,
                'position' => $new_position
            ]);









            // LÓGICA DE SELECCIONES (Solo para Building)
            if ($itemType === 'building') {

                // 1. CLASE: Toma el valor de comparable_clasification
                HomologationComparableSelectionModel::create([
                    'valuation_building_comparable_id' => $pivot->id,
                    'variable' => 'clase',
                    'value' => $comparable->comparable_clasification ?? null,
                    'factor' => null,
                ]);

                // 2. CONSERVACIÓN: Inicia en NULL
                HomologationComparableSelectionModel::create([
                    'valuation_building_comparable_id' => $pivot->id,
                    'variable' => 'conservacion',
                    'value' => null,
                    'factor' => null,
                ]);

                // 3. LOCALIZACIÓN: Inicia en NULL
                HomologationComparableSelectionModel::create([
                    'valuation_building_comparable_id' => $pivot->id,
                    'variable' => 'localizacion',
                    'value' => null,
                    'factor' => null,
                ]);
            }
        }








        // 3. Generar los factores del comparable (AQUÍ VA EL SERVICIO)
        $comparableService->createComparableFactors(
            valuationId: $this->id,
            comparablePivot: $pivot,
            type: $this->comparableType
        );

        // INYECCIÓN DEL EQUIPAMIENTO (FEQ)
        $comparableService->createComparableEquipment(
            valuationId: $this->id,
            pivotId: $pivot->id, // Usamos el ID del pivot creado
            type: $this->comparableType
        );

        // 4. Actualizar tabla en frontend
        if ($this->comparableType === 'land') {
            $this->dispatch('pg:eventRefresh-comparables-land-table');
        } else {
            $this->dispatch('pg:eventRefresh-comparables-building-table');
        }

        // 5. Recalcular los asignados
        $this->loadAssignedComparables();

        // 6. Toaster opcional
        if ($showToaster) {
            Toaster::success('Comparable asignado correctamente.');
        }
    }


    //Método para desasignar un comparable
    public function deallocatedElement($idComparable)
    {

        // 1. Encontrar el comparable y su TIPO
        $comparable = ComparableModel::find($idComparable);

        // Si no existe, no podemos continuar
        if (!$comparable) {
            Toaster::error('Error: Comparable no encontrado.');
            return;
        }
        $itemType = $comparable->comparable_type;

        // Obtener el servicio de homologación
        $comparableService = app(HomologationComparableService::class);


        // --- ¡¡¡LÓGICA CORREGIDA Y LIMPIA!!! ---
        if ($itemType === 'land') {
            //Primero encontramos el registro de la tabla valuation_comparables
            $valuationLandComparable = ValuationLandComparableModel::where('valuation_id', $this->id)->where('comparable_id', $idComparable)->first();

            if ($valuationLandComparable) {
                // B. ¡BORRAR LOS FACTORES PRIMERO! (Usando el ID del pivote)
                $comparableService->deleteComparableFactors($valuationLandComparable->id, $itemType);

                // C. Ahora sí, eliminar el pivote
                $valuationLandComparable->delete();
            }
        } else { // 'building'
            $valuationBuildingComparable = ValuationBuildingComparableModel::where('valuation_id', $this->id)->where('comparable_id', $idComparable)->first();

            if ($valuationBuildingComparable) {
                // B. ¡BORRAR LOS FACTORES PRIMERO!
                $comparableService->deleteComparableFactors($valuationBuildingComparable->id, $itemType);

                // INYECCIÓN DE BORRADO DE EQUIPAMIENTO (FEQ)
                $comparableService->deleteComparableEquipment(
                    pivotId: $valuationBuildingComparable->id,
                    type: $itemType // 'building'
                );

                // BORRADO DE SELECCIONES
                HomologationComparableSelectionModel::where('valuation_building_comparable_id', $idComparable)->delete();

                // C. Ahora sí, eliminar el pivote (¡¡¡LÍNEA DESCOMENTADA!!!)
                $valuationBuildingComparable->delete();
            }
        }
        // --- FIN DE LA CORRECCIÓN ---

        //Primero ejecutamos la función de reordenar los elementos
        $this->reorderPositions($itemType);

        //Refrescamos la tabla de comparables
        $this->loadAssignedComparables();

        //Refrescamos la tabla de comparables x asignar
        if ($this->comparableType === 'land') {
            $this->dispatch('pg:eventRefresh-comparables-land-table');
        } else {
            $this->dispatch('pg:eventRefresh-comparables-building-table');
        }

        //Finalmente, enviamos un mensaje en pantalla indicamando que el comparable fue desasignado
        Toaster::success('Comparable desasignado correctamente.');
    }


    public function deleteElement($idComparable)
    {
        // 1. Encontrar el comparable y su TIPO
        $comparable = ComparableModel::find($idComparable);

        if (!$comparable) {
            Toaster::error('Error: Comparable no encontrado.');
            return;
        }
        $itemType = $comparable->comparable_type;

        // 2. *** NUEVA LÓGICA DE VERIFICACIÓN ***
        // (En lugar de solo contar, obtenemos los IDs de los avalúos)
        $assignedValuationIds = null;
        if ($itemType === 'land') {
            $assignedValuationIds = ValuationLandComparableModel::where('comparable_id', $idComparable)
                ->pluck('valuation_id');
        } else {
            $assignedValuationIds = ValuationBuildingComparableModel::where('comparable_id', $idComparable)
                ->pluck('valuation_id');
        }

        $assignmentCount = $assignedValuationIds->count();

        // 3. LÓGICA DE BORRADO (Si no está asignado)
        if ($assignmentCount < 1) {

            // --- Lógica de borrado de foto ---
            if ($comparable && $comparable->comparable_photos) {
                Storage::disk('comparables_public')->delete(basename($comparable->comparable_photos));
            }
            // --- Fin Lógica de borrado de foto ---

            $comparable->delete();

            // Reordenar posiciones
            $this->reorderPositions($itemType);

            // Recargar tabla de asignados
            $this->loadAssignedComparables();

            // Refrescar PowerGrid
            if ($this->comparableType === 'land') {
                $this->dispatch('pg:eventRefresh-comparables-land-table');
            } else {
                $this->dispatch('pg:eventRefresh-comparables-building-table');
            }

            Toaster::success('Comparable eliminado correctamente.');
        } else {
            // 4. *** NUEVO MENSAJE DE ERROR CON FOLIOS ***
            // Consultamos la tabla 'valuations' para obtener los folios
            $folios = Valuation::whereIn('id', $assignedValuationIds)
                ->pluck('folio')
                ->implode(' | ');

            Toaster::error("No se puede eliminar. Asignado a {$assignmentCount} avalúo(s) con folio(s): {$folios}");
        }
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
        // 1. OBTENER EL TIPO DE COMPARABLE (La lógica "inteligente")
        // Primero, buscamos el comparable en la BD usando su ID.
        // Esto es crucial porque no podemos confiar en $this->comparableType,
        // ya que ese es el "contexto" de la página, no el "contexto" del ítem.
        // Esta es la misma lógica que usamos en deallocatedElement() y deleteElement().
        $comparable = ComparableModel::find($idComparable);

        // Si por alguna razón no existe (ej. se borró en otra pestaña), paramos.
        if (!$comparable) {
            Toaster::error('Error: Comparable no encontrado.');
            return;
        }
        // Guardamos el tipo ('land' o 'building') de este ítem específico.
        $itemType = $comparable->comparable_type;

        // --- *** INICIO DE LA LÓGICA DE MOVIMIENTO *** ---
        // A diferencia de antes, NO guardamos la relación en una variable $relation.
        // ¿Por qué? Porque el objeto de relación de Eloquent se "muta" (cambia)
        // con cada consulta. Llamar a la función () cada vez nos da una
        // consulta "fresca" y evita que los "where" se acumulen y fallen.
        // Es más verboso, pero 100% seguro (como en la versión que sí funcionaba).

        // 2. BUSCAR EL ÍTEM ACTUAL Y SU POSICIÓN
        // Necesitamos saber la posición actual del ítem que queremos mover.
        if ($itemType === 'land') {
            // Buscamos el ítem DENTRO de la relación de este avalúo.
            $current = $this->valuation->landComparables()->where('comparables.id', $idComparable)->first();
        } else {
            // Hacemos lo mismo para la relación de 'building'.
            $current = $this->valuation->buildingComparables()->where('comparables.id', $idComparable)->first();
        }

        // Si no está (quizás ya se quitó de la relación), salimos.
        if (!$current) {
            return;
        }
        // Guardamos su posición actual (ej. 3)
        $currentPosition = $current->pivot->position;

        // 3. LÓGICA DE "SUBIR" (Mover a una posición menor: 3 -> 2)
        // Verificamos si la dirección es 'up' y si no es ya el primero (posición > 1).
        if ($direction === 'up' && $currentPosition > 1) {

            // Verificamos el tipo para saber qué relación consultar.
            if ($itemType === 'land') {
                // Buscamos el ítem que está justo arriba (posición - 1).
                $swap = $this->valuation->landComparables()->wherePivot('position', $currentPosition - 1)->first();
                // Si existe...
                if ($swap) {
                    // 1. Al ítem de arriba ($swap), le ponemos la posición del actual (ej. 3).
                    $this->valuation->landComparables()->updateExistingPivot($swap->id, ['position' => $currentPosition]);
                    // 2. Al ítem actual ($current), le ponemos la posición del de arriba (ej. 2).
                    $this->valuation->landComparables()->updateExistingPivot($current->id, ['position' => $currentPosition - 1]);
                }
            } else {
                // Repetimos la misma lógica para 'building'.
                $swap = $this->valuation->buildingComparables()->wherePivot('position', $currentPosition - 1)->first();
                if ($swap) {
                    $this->valuation->buildingComparables()->updateExistingPivot($swap->id, ['position' => $currentPosition]);
                    $this->valuation->buildingComparables()->updateExistingPivot($current->id, ['position' => $currentPosition - 1]);
                }
            }

            // 4. LÓGICA DE "BAJAR" (Mover a una posición mayor: 2 -> 3)
        } elseif ($direction === 'down') {

            // Verificamos el tipo...
            if ($itemType === 'land') {
                // 4a. Obtenemos la posición MÁXIMA actual.
                // Esta es la consulta CLAVE que fallaba antes.
                // Debe ser una consulta directa a la relación con la columna pivot.
                $maxPosition = $this->valuation->landComparables()->max('valuation_land_comparables.position');

                // 4b. Verificamos si no estamos ya en el último lugar.
                if ($currentPosition < $maxPosition) {
                    // Buscamos el ítem que está justo abajo (posición + 1).
                    $swap = $this->valuation->landComparables()->wherePivot('position', $currentPosition + 1)->first();
                    if ($swap) {
                        // 1. Al ítem de abajo ($swap), le ponemos la posición del actual (ej. 2).
                        $this->valuation->landComparables()->updateExistingPivot($swap->id, ['position' => $currentPosition]);
                        // 2. Al ítem actual ($current), le ponemos la posición del de abajo (ej. 3).
                        $this->valuation->landComparables()->updateExistingPivot($current->id, ['position' => $currentPosition + 1]);
                    }
                }
            } else {
                // Repetimos la misma lógica para 'building'.
                $maxPosition = $this->valuation->buildingComparables()->max('valuation_building_comparables.position');
                if ($currentPosition < $maxPosition) {
                    $swap = $this->valuation->buildingComparables()->wherePivot('position', $currentPosition + 1)->first();
                    if ($swap) {
                        $this->valuation->buildingComparables()->updateExistingPivot($swap->id, ['position' => $currentPosition]);
                        $this->valuation->buildingComparables()->updateExistingPivot($current->id, ['position' => $currentPosition + 1]);
                    }
                }
            }
        }
        // --- *** FIN DE LA LÓGICA DE MOVIMIENTO *** ---

        // 5. REORDENAR POSICIONES
        // Después de mover (ej. 3 -> 4), es posible que la BD quede (1, 2, 4, 3).
        // Llamamos a reorderPositions() para "barrer" y reordenar todo a (1, 2, 3, 4).
        // Le pasamos el $itemType correcto que obtuvimos al inicio.
        $this->reorderPositions($itemType);

        // 6. RECARGAR LA VISTA
        // Finalmente, llamamos a loadAssignedComparables() para refrescar
        // la variable $assignedComparables y que Livewire actualice la tabla.
        $this->loadAssignedComparables();
    }

    /**
     * Reordena las posiciones de los comparables asignados
     * Esto evita huecos o duplicados después de mover o eliminar elementos
     */
    /**
     * Reordena las posiciones de los comparables asignados
     * (Esta es la versión que acepta 1 parámetro)
     */


    public function reorderPositions($itemType) // <-- 1. PARÁMETRO REQUERIDO
    {
        // ****** CORRECCIÓN CRÍTICA ******
        // Usamos $itemType (no $this->comparableType) para la lógica
        if ($itemType === 'land') {
            $comparables = $this->valuation->landComparables()->orderByPivot('position')->get();
            $relation = $this->valuation->landComparables();
        } else {
            $comparables = $this->valuation->buildingComparables()->orderByPivot('position')->get();
            $relation = $this->valuation->buildingComparables();
        }
        // ****** FIN DE LA CORRECCIÓN ******

        $position = 1;

        foreach ($comparables as $comp) {
            if ($comp->pivot->position != $position) {
                // Usamos la variable $relation para actualizar el pivote
                $relation->updateExistingPivot($comp->id, ['position' => $position]);
            }
            $position++;
        }



        /*  // Obtenemos todos los comparables asignados, ordenados por posición actual
            $comparables = $this->valuation->landComparables()->orderByPivot('position')->get();

            $position = 1; // Empezamos a contar desde 1

            foreach ($comparables as $comp) {
                // Si la posición actual del pivot no coincide con la secuencia, la actualizamos
                // Ejemplo: si el primer comparable tiene position=2, lo cambiamos a 1
                if ($comp->pivot->position != $position) {
                    $this->valuation->landComparables()->updateExistingPivot($comp->id, ['position' => $position]);
                }

                $position++; // Incrementamos para el siguiente comparable
            } */
    }



    //FUNCIONES DE WATCHER

    public function updatedComparableOffers($value)
    {
        if ($value < 0) {
            // CORRECCIÓN: Aquí debe ser 'comparableOffers'
            $this->comparableOffers = 0;
        }

        $this->calcUnitValue();
    }

    public function updatedComparableLandArea($value)
    {
        if ($value < 0) {
            $this->comparableLandArea = 0;
        }

        $this->calcUnitValue();
    }

    public function updatedComparableBuiltArea($value)
    {
        if ($value < 0) {
            $this->comparableBuiltArea = 0;
        }

        $this->calcUnitValue();
    }


    /*
|--------------------------------------------------------------------------
| FUNCIÓN DE CÁLCULO (LÓGICA CORREGIDA)
|--------------------------------------------------------------------------
|
| REEMPLAZA tu 'calcUnitValue' por esta.
|
| Esta versión revisa el TIPO PRIMERO, y solo después
| valida la división por cero para ESE TIPO.
|
*/
    public function calcUnitValue()
    {
        // 1. Convertimos todos los valores a float.
        $offers = (float) $this->comparableOffers;
        $landArea = (float) $this->comparableLandArea;
        $builtArea = (float) $this->comparableBuiltArea;

        // 2. Inicializamos el resultado en 0.0 por seguridad.
        $result = 0.0;

        // 3. Revisamos el tipo PRIMERO.
        if ($this->comparableType === 'land') {

            // 4. Si es 'land', SOLO validamos 'landArea' para evitar división por cero.
            // No nos importa 'builtArea'.
            if ($landArea > 0) {
                $result = $offers / $landArea;
            }
        } elseif ($this->comparableType === 'building') {

            // 5. Si es 'building', SOLO validamos 'builtArea'.
            // No nos importa 'landArea'.
            if ($builtArea > 0) {
                $result = $offers / $builtArea;
            }
        }
        // Si el tipo es nulo, o el divisor es 0, $result se queda en 0.0

        // 6. Asignamos el resultado final.
        $this->comparableUnitValue = max(0.0, $result);
    }

    public function validateModal()
    {

        // --- 1. REGLAS COMUNES (Siempre se validan) ---
        $commonRules = [
            // 'comparableKey' => 'nullable', // readonlya
            'comparableFolio' => 'required',
            'comparableDischargedBy' => 'required',
            'comparableProperty' => 'required',
            'comparableCp' => 'required|string|digits:5',
            'comparableEntity' => 'required', // Aunque se autollena, debe estar seleccionado
            'comparableLocality' => 'required', // Aunque se autollena, debe estar seleccionado
            'comparableColony' => 'required',
            'comparableStreet' => 'required',
            'comparableAbroadNumber' => 'required',
            'comparableInsideNumber' => 'nullable', // Sin *
            'comparableBetweenStreet' => 'nullable',
            'comparableAndStreet' => 'nullable',
            'comparableName' => 'required',
            'comparableLastName' => 'required',
            'comparablePhone' => 'required',
            'comparableUrl' => 'required|url',
            'comparableCharacteristics' => 'required',
            'comparableCharacteristicsGeneral' => 'nullable', // Sin *
            'comparableOffers' => 'required|numeric|gt:0',
            'comparableLandArea' => 'required|numeric|gt:0', // <--- CAMBIO: Ahora es común
            'comparableBuiltArea' => 'required|numeric|min:0',
            'comparableUnitValue' => 'required|numeric|gt:0', // disabled, pero requerido
            'comparableBargainingFactor' => 'required|numeric|between:0.8,1',
            'comparableLocationBlock' => 'required',
            'comparableStreetLocation' => 'required',
            'comparableGeneralPropArea' => 'required',
            'comparableUrbanProximityReference' => 'required',
            'comparableSourceInfImages' => 'required',
            'comparableActive' => 'nullable|boolean', // Sin *
            // comparableNumberFronts no está en el Blade, lo omito de las reglas
        ];
        // --- 2. REGLAS LAND (Solo si comparableType es 'land') ---
        $landRules = [
            'comparableLandUse' => 'required',
            'comparableFreeAreaRequired' => 'required|numeric|between:0,100',
            'comparableAllowedLevels' => 'required|integer',
            'comparableServicesInfraestructure' => 'required', // <--- CAMBIO: Tiene *
            'comparableDescServicesInfraestructure' => 'required',
            'comparableShape' => 'required',
            'comparableSlope' => 'nullable|numeric|between:0,100',
            'comparableDensity' => 'nullable',
            'comparableFront' => 'nullable|numeric|min:0',
            'comparableFrontType' => 'nullable', // Sin *
            'comparableDescriptionForm' => 'nullable', // Sin *
            'comparableTopography' => 'required',
        ];

        // --- 3. REGLAS BUILDING (Solo si comparableType es 'building') ---
        $buildingRules = [
            // CAMBIO: Estos 5 son nullable ahora (sin *)
            'comparableNumberBedrooms' => 'nullable|integer|min:0',
            'comparableNumberToilets' => 'nullable|integer|min:0',
            'comparableNumberHalfbaths' => 'nullable|integer|min:0',
            'comparableNumberParkings' => 'nullable|integer|min:0',
            'comparableNumberFloorLevel' => 'nullable',
            // CAMBIO: Checkboxes son nullable
            'comparableElevator' => 'nullable|boolean',
            'comparableStore' => 'nullable|boolean',
            'comparableRoofGarden' => 'nullable|boolean',
            // CAMBIO: Este sí es requerido
            'comparableFeaturesAmenities' => 'required|string|max:500',
            'comparableQuality' => 'required|string|max:100',
            'comparableConservation' => 'required',
            'comparableLevels' => 'required|integer|min:0',
            'comparableSeleableArea' => 'required|numeric|gt:0',
            'comparableClasification' => 'required',
            'comparableAge' => 'required|integer|min:0',
            'comparableVut' => 'required|numeric|min:0',
        ];
        // --- 4. CONSTRUCCIÓN DE REGLAS FINALES ---
        $rules = $commonRules;

        if ($this->comparableType === 'land') {
            $rules = array_merge($rules, $landRules);
        } elseif ($this->comparableType === 'building') {
            $rules = array_merge($rules, $buildingRules);
        }

        // --- 5. REGLAS CONDICIONALES ADICIONALES (Se mantienen) ---
        if ($this->comparableColony === 'no-listada') { // Corregido de comparableOtherColony
            $rules = array_merge($rules, [
                'comparableOtherColony'  => 'required|max:100'
            ]);
        }

        $fileExists = $this->comparablePhotosFile && is_string($this->comparablePhotosFile);

        if ($fileExists) {
            $rules = array_merge($rules, [
                'comparablePhotosFile'  => 'nullable|string'
            ]);
        } else {
            if ($this->comparableId === null) {
                $rules = array_merge(
                    $rules,
                    [
                        'comparablePhotosFile'  => 'nullable|file|image|max:2048' // Permite nulo al crear
                    ]
                );
            } else {
                $rules = array_merge(
                    $rules,
                    [
                        'comparablePhotosFile'  => 'nullable|file|image|max:2048' // Permite nulo al editar también (por si no quiere cambiarla)
                    ]
                );
            }
        }

        // --- 6. RETORNO DEL VALIDADOR ---
        return  Validator::make(
            $this->all(),
            $rules,
            [], // Mensajes personalizados
            $this->validateModalAttributes() // Atributos en español
        );
    }


    protected function validateModalAttributes(): array
    {
        return [
            // 'comparableKey' => 'clave',
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
            'comparableCharacteristics' => 'características',
            'comparableCharacteristicsGeneral' => 'características generales',
            'comparableOffers' => 'oferta',
            'comparableBuiltArea' => 'superficie construida',
            'comparableUnitValue' => 'valor unitario',
            'comparableBargainingFactor' => 'factor de negociación',
            'comparableLocationBlock' => 'ubicación en la manzana',
            'comparableStreetLocation' => 'ubicación en la calle',
            'comparableGeneralPropArea' => 'clase general de la zona',
            'comparableUrbanProximityReference' => 'referencia de proximidad urbana',
            // 'comparableNumberFronts' => 'número de frentes', // Omitido (no en Blade)
            'comparableSourceInfImages' => 'fuente de imágenes',
            'comparablePhotosFile' => 'fotos',
            'comparableActive' => 'activo',

            // --- Atributos LAND ---
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
            'comparableLandArea' => 'superficie del terreno', // <--- CAMBIO: Ahora común

            // --- Atributos BUILDING ---
            'comparableNumberBedrooms' => 'N° de recámaras',
            'comparableNumberToilets' => 'N° de baños',
            'comparableNumberHalfbaths' => 'N° 1/2 baños',
            'comparableNumberParkings' => 'N° estacionamientos',
            'comparableElevator' => 'elevador',
            'comparableStore' => 'bodega',
            'comparableRoofGarden' => 'roof garden',
            'comparableFeaturesAmenities' => 'características amenidades',
            'comparableNumberFloorLevel' => 'piso/nivel',
            'comparableQuality' => 'calidad',
            'comparableConservation' => 'conservación',
            'comparableLevels' => 'niveles',
            'comparableSeleableArea' => 'superficie vendible',
            'comparableClasification' => 'clasificación del inmueble',
            'comparableAge' => 'edad',
            'comparableVut' => 'VUT',

            // ATRIBUTOS AÑADIDOS PARA MENSAJES DE ERROR MÁS CLAROS
            // 'comparableLatitude' => 'latitud (Mapa)',
            // 'comparableLongitude' => 'longitud (Mapa)',
        ];
    }


    public function resetComparableFields()
    {
        /* $this->comparableLatitude = 19.4326;
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
            'comparableCharacteristics',
            'comparableCharacteristicsGeneral',
            'comparableOffers',
            // 'comparableLandArea', // Se resetea abajo
            'comparableBuiltArea',
            'comparableUnitValue',
            'comparableBargainingFactor',
            'comparableLocationBlock',
            'comparableStreetLocation',
            'comparableGeneralPropArea',
            'comparableUrbanProximityReference',
            'comparableNumberFronts',
            'comparableSourceInfImages',
            'comparableActive',
            'comparablePhotosFile',

            // --- Campos LAND ---
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
            'comparableLandArea',

            // --- Campos BUILDING ---
            'comparableNumberBedrooms',
            'comparableNumberToilets',
            'comparableNumberHalfbaths',
            'comparableNumberParkings',
            'comparableElevator',
            'comparableStore',
            'comparableRoofGarden',
            'comparableFeaturesAmenities',
            'comparableNumberFloorLevel',
            'comparableQuality',
            'comparableConservation',
            'comparableLevels',
            'comparableSeleableArea',
            'comparableClasification',
            'comparableAge',
            'comparableVut',
        ]);

        // Reiniciar valores por defecto que no son null
        /*       $this->comparableActive = true; */
        $this->comparableElevator = false;
        $this->comparableStore = false;
        $thisRouteGuard = false;
        $this->comparableOffers = 0;
        $this->comparableLandArea = 0;
        $this->comparableBuiltArea = 0;
        $this->comparableUnitValue = 0;
    }


    //Función para volver a los formularios del avaluo
    public function backForms()
    {
        //Eliminamos la variable de sesión
        Session::pull('comparables-active-session');

        //Redirigimos al usuario a formIndex, específicamente a enfoque de mercado
        return $this->redirect(route('form.index', ['section' => 'market-focus']), navigate: true);
    }


    public function backToHomologationLand()
    {
        //Eliminamos la variable de sesión
        Session::pull('comparables-active-session');

        //Redirigimos al usuario a formIndex, específicamente a enfoque de mercado
        return $this->redirect(route('form.index', ['section' => 'homologation-lands']), navigate: true);
    }



    public function backToHomologationBuilding()
    {
        //Eliminamos la variable de sesión
        Session::pull('comparables-active-session');

        //Redirigimos al usuario a formIndex, específicamente a enfoque de mercado
        return $this->redirect(route('form.index', ['section' => 'homologation-buildings']), navigate: true);
    }


    public function render()
    {
        $this->loadAssignedComparables();
        return view('livewire.forms.comparables.comparables-index');
    }
}
