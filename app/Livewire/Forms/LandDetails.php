<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Masmerise\Toaster\Toaster;
use Livewire\WithFileUploads;
use Flux\Flux;
use App\Models\Valuations\Valuation;
use App\Models\Forms\LandDetails\LandDetailsModel;
use App\Models\Forms\PropertyLocation\PropertyLocationModel;
use App\Models\Forms\LandDetails\GroupsNeighborsModel;
use App\Models\Forms\LandDetails\GroupNeighborDetailsModel;
use App\Models\Forms\LandDetails\LandSurfaceModel;
use App\Models\Forms\LandDetails\MeasureBoundaryModel;
use Illuminate\Support\Facades\Storage;


class LandDetails extends Component
{

    //Variable para obtener los valores del avaluo
    public $valuation;

    //Valor para asignar el ID del avaluo para funciones de creación o edición
    public $valuation_id;

    //Variable para obtener los datos del formulario de terreno
    //Además de otras obtenr valores para funciones de creación o edición
    public $landDetail;

    //Se obtienen los grupos asignados al registro de la tabla land_details
    public $groupsWithNeighbors = [];

    //Variable para asignar el ID de grupo, utilizado para generar los detalles de cada tabla
    public $groupId;

    //Variable para asignar el id del detalle para un grupo, utilizado para editar o eliminar un elemento
    public $groupDetailId;

    //Obtenemos de propertyLocation para renderizar los valores en el componente
    public $propertyLocation;

    //Lista de elementos de superficie del terreno ligados al land_details
    public $landSurfaces = [];

    //Variable para guardar el id del landSurface seleccionado para editar o eliminar
    public $landSurfaceId;

    //Cargamos la lista de archivos ligados al land_details
    public $measureBoundaries = [];

    use WithFileUploads;
    public $photos = []; // Propiedad para almacenar múltiples archivos

    //PRIMER CONTENEDOR
    public $sli_sourceLegalInformation;
    //Variables select escritura
    public $sli_notaryOfficeDeed, $sli_deedDeed, $sli_volumeDeed, $sli_dateDeed, $sli_notaryDeed, $sli_judicialDistricDeed;
    //Variables select sentencia
    public $sli_fileJudgment, $sli_dateJudgment, $sli_courtJudgment, $sli_municipalityJudgment;
    //Variables select contrato privado
    public $sli_datePrivCont, $sli_namePrivContAcq, $sli_firstNamePrivContAcq, $sli_secondNamePrivContAcq,
        $sli_namePrivContAlt, $sli_firstNamePrivContAlt, $sli_secondNamePrivContAlt;
    //Variante select alineamiento y numero oficial
    public $sli_folioAon, $sli_dateAon, $sli_municipalityAon;
    //Variante select título de propiedad
    public $sli_recordPropReg, $sli_datePropReg, $sli_instrumentPropReg, $sli_placePropReg;
    //Variante select otra fuente de informacion legal
    public $sli_especifyAsli, $sli_dateAsli, $sli_emittedByAsli, $sli_folioAsli;


    //SEGUNDO CONTENEDOR

    //Vatiable para crear grupo
    public $group;

    //Variables para crear elemento de grupo
    public $orientation, $adjacent;
    public float $extent;


    //TERCER CONTENEDOR
    public $ct_streetWithFront, $ct_CrossStreet1, $ct_crossStreetOrientation1, $ct_CrossStreet2, $ct_crossStreetOrientation2,
        $ct_borderStreet1, $ct_borderStreetOrientation1, $ct_borderStreet2, $ct_borderStreetOrientation2, $ct_location,
        $ct_configuration, $ct_topography, $ct_typeOfRoad, $ct_panoramicFeatures, $ct_EasementRestrictions, $ct_EasementRestrictionsOthers;


    //CUARTO CONTENEDOR
    public bool $ls_useExcessCalculation;

    public float $ls_surfacePrivateLot, $ls_surfacePrivateLotType, $ls_undividedOnlyCondominium, $ls_undividedSurfaceLand, $ls_surplusLandArea;

    //Elementos del modal de superficie del terreno
    public float $modalSurface;





        public function mount(){


        $valuationId = session('valuation_id');

        // Guardar el valuationId en una propiedad pública
        $this->valuation_id = $valuationId;

        //Obtenemos los valores deL avalúo a partir de la variable de sesión del ID
        $this->valuation = Valuation::find(Session::get('valuation_id'));

        //obtenemos los valores de propertyLocation
        $this->propertyLocation = PropertyLocationModel::where('valuation_id', $valuationId)->first();

        if (!$this->propertyLocation) {
            // Asignar coordenadas por defecto (centro de México)
            $this->propertyLocation = (object)[
                'latitude' => '23.6345',
                'longitude' => '-102.5528',
                'altitude' => '0'
            ];
        }

        // Asignar el modelo solo si valuationId existe para evitar errores
        $this->landDetail = LandDetailsModel::where('valuation_id', $valuationId)->first();

        if ($this->landDetail) {

            //Obtenemos el valor de los grupos ligados al landDetail
            $this->groupsWithNeighbors = $this->landDetail->groupsNeighbors()->with('neighbors')->get();

            //Obtenemos el valor de los landSurfaces ligados al LandDetail
            $this->landSurfaces = $this->landDetail->landSurfaces()->get();

            //Obtenemos el valor de los archivos ligados al LandDetail
            $this->measureBoundaries = $this->landDetail->measureBoundaries()->get();

            // PRIMER CONTENEDOR - Información Legal
            $this->sli_sourceLegalInformation = $this->landDetail->source_legal_information;

            // Escritura
            $this->sli_notaryOfficeDeed = $this->landDetail->notary_office_deed;
            $this->sli_deedDeed = $this->landDetail->deed_deed;
            $this->sli_volumeDeed = $this->landDetail->volume_deed;
            $this->sli_dateDeed = $this->landDetail->date_deed;
            $this->sli_notaryDeed = $this->landDetail->notary_deed;
            $this->sli_judicialDistricDeed = $this->landDetail->judicial_distric_deed;

            // Sentencia
            $this->sli_fileJudgment = $this->landDetail->file_judgment;
            $this->sli_dateJudgment = $this->landDetail->date_judgment;
            $this->sli_courtJudgment = $this->landDetail->court_judgment;
            $this->sli_municipalityJudgment = $this->landDetail->municipality_judgment;

            // Contrato Privado
            $this->sli_datePrivCont = $this->landDetail->date_priv_cont;
            $this->sli_namePrivContAcq = $this->landDetail->name_priv_cont_acq;
            $this->sli_firstNamePrivContAcq = $this->landDetail->first_name_priv_cont_acq;
            $this->sli_secondNamePrivContAcq = $this->landDetail->second_name_priv_cont_acq;
            $this->sli_namePrivContAlt = $this->landDetail->name_priv_cont_alt;
            $this->sli_firstNamePrivContAlt = $this->landDetail->first_name_priv_cont_alt;
            $this->sli_secondNamePrivContAlt = $this->landDetail->second_name_priv_cont_alt;

            // Alineamiento y Número Oficial
            $this->sli_folioAon = $this->landDetail->folio_aon;
            $this->sli_dateAon = $this->landDetail->date_aon;
            $this->sli_municipalityAon = $this->landDetail->municipality_aon;

            // Título de Propiedad
            $this->sli_recordPropReg = $this->landDetail->record_prop_reg;
            $this->sli_datePropReg = $this->landDetail->date_prop_reg;
            $this->sli_instrumentPropReg = $this->landDetail->instrument_prop_reg;
            $this->sli_placePropReg = $this->landDetail->place_prop_reg;

            // Otra fuente de información legal
            $this->sli_especifyAsli = $this->landDetail->especify_asli;
            $this->sli_dateAsli = $this->landDetail->date_asli;
            $this->sli_emittedByAsli = $this->landDetail->emitted_by_asli;
            $this->sli_folioAsli = $this->landDetail->folio_asli;

            // TERCER CONTENEDOR - Circulación y tráfico
            $this->ct_streetWithFront = $this->landDetail->street_with_front;
            $this->ct_CrossStreet1 = $this->landDetail->cross_street_1;
            $this->ct_crossStreetOrientation1 = $this->landDetail->cross_street_orientation_1;
            $this->ct_CrossStreet2 = $this->landDetail->cross_street_2;
            $this->ct_crossStreetOrientation2 = $this->landDetail->cross_street_orientation_2;
            $this->ct_borderStreet1 = $this->landDetail->border_street_1;
            $this->ct_borderStreetOrientation1 = $this->landDetail->border_street_orientation_1;
            $this->ct_borderStreet2 = $this->landDetail->border_street_2;
            $this->ct_borderStreetOrientation2 = $this->landDetail->border_street_orientation_2;
            $this->ct_location = $this->landDetail->location;
            $this->ct_configuration = $this->landDetail->configuration;
            $this->ct_topography = $this->landDetail->topography;
            $this->ct_typeOfRoad = $this->landDetail->type_of_road;
            $this->ct_panoramicFeatures = $this->landDetail->panoramic_features;
            $this->ct_EasementRestrictions = $this->landDetail->easement_restrictions;
            $this->ct_EasementRestrictionsOthers = $this->landDetail->easement_restrictions_others;

            // CUARTO CONTENEDOR - Situación del Terreno
            $this->ls_useExcessCalculation = $this->landDetail->use_excess_calculation;

            $this->ls_surfacePrivateLot = $this->landDetail->surface_private_lot;
            $this->ls_surfacePrivateLotType = $this->landDetail->surface_private_lot_type;
            $this->ls_undividedOnlyCondominium = $this->landDetail->undivided_only_condominium;
            $this->ls_undividedSurfaceLand = $this->landDetail->undivided_surface_land;
            $this->ls_surplusLandArea = $this->landDetail->surplus_land_area;

            if (stripos($this->valuation->property_type, 'condominio') !== false) {
                $this->ls_undividedOnlyCondominium = 0;
                $this->ls_undividedSurfaceLand = 0;
            }

        }


        //$this->extent = 0;
        //$this->ls_useExcessCalculation = false;
    }

    public function save()
    {

        //dd($this->ls_surfacePrivateLot);
        //Ejecutar función con todas las reglas de validación y validaciones condicionales, guardando todo en una variable
        $validator = $this->validateAllContainers();

        //Comprobamos si se obtuvieron errores de validación
        if ($validator->fails()) {
            //Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            //dd($validator);
            //Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            //Hacemos un return para detener el flujo del sistema
            return;
        }

        //dd($this->ct_EasementRestrictionsOthers);
        //Aquí se ejecutará la lógica de guardado
        // Mapea las propiedades del componente a un array con nombres de columnas de la DB
        $data = [
            // PRIMER CONTENEDOR - Información Legal
            'source_legal_information' => $this->sli_sourceLegalInformation,

            // Escritura
            'notary_office_deed' => $this->sli_notaryOfficeDeed,
            'deed_deed' => $this->sli_deedDeed,
            'volume_deed' => $this->sli_volumeDeed,
            'date_deed' => $this->sli_dateDeed,
            'notary_deed' => $this->sli_notaryDeed,
            'judicial_distric_deed' => $this->sli_judicialDistricDeed,

            // Sentencia
            'file_judgment' => $this->sli_fileJudgment,
            'date_judgment' => $this->sli_dateJudgment,
            'court_judgment' => $this->sli_courtJudgment,
            'municipality_judgment' => $this->sli_municipalityJudgment,

            // Contrato privado
            'date_priv_cont' => $this->sli_datePrivCont,
            'name_priv_cont_acq' => $this->sli_namePrivContAcq,
            'first_name_priv_cont_acq' => $this->sli_firstNamePrivContAcq,
            'second_name_priv_cont_acq' => $this->sli_secondNamePrivContAcq,
            'name_priv_cont_alt' => $this->sli_namePrivContAlt,
            'first_name_priv_cont_alt' => $this->sli_firstNamePrivContAlt,
            'second_name_priv_cont_alt' => $this->sli_secondNamePrivContAlt,

            // Alineamiento y número oficial
            'folio_aon' => $this->sli_folioAon,
            'date_aon' => $this->sli_dateAon,
            'municipality_aon' => $this->sli_municipalityAon,

            // Título de propiedad
            'record_prop_reg' => $this->sli_recordPropReg,
            'date_prop_reg' => $this->sli_datePropReg,
            'instrument_prop_reg' => $this->sli_instrumentPropReg,
            'place_prop_reg' => $this->sli_placePropReg,

            // Otra fuente de información legal
            'especify_asli' => $this->sli_especifyAsli,
            'date_asli' => $this->sli_dateAsli,
            'emitted_by_asli' => $this->sli_emittedByAsli,
            'folio_asli' => $this->sli_folioAsli,

            // TERCER CONTENEDOR - Circulación y tráfico
            'street_with_front' => $this->ct_streetWithFront,
            'cross_street_1' => $this->ct_CrossStreet1,
            'cross_street_orientation_1' => $this->ct_crossStreetOrientation1,
            'cross_street_2' => $this->ct_CrossStreet2,
            'cross_street_orientation_2' => $this->ct_crossStreetOrientation2,
            'border_street_1' => $this->ct_borderStreet1,
            'border_street_orientation_1' => $this->ct_borderStreetOrientation1,
            'border_street_2' => $this->ct_borderStreet2,
            'border_street_orientation_2' => $this->ct_borderStreetOrientation2,
            'location' => $this->ct_location,
            'configuration' => $this->ct_configuration,
            'topography' => $this->ct_topography,
            'type_of_road' => $this->ct_typeOfRoad,
            'panoramic_features' => $this->ct_panoramicFeatures,
            'easement_restrictions' => $this->ct_EasementRestrictions,
            'easement_restrictions_others' => $this->ct_EasementRestrictionsOthers,

            // CUARTO CONTENEDOR - Situación del Terreno
            'use_excess_calculation' => $this->ls_useExcessCalculation,
            'surface_private_lot' => $this->ls_surfacePrivateLot,
            'surface_private_lot_type' => $this->ls_surfacePrivateLotType,
            'undivided_only_condominium' => $this->ls_undividedOnlyCondominium,
            'undivided_surface_land' => $this->ls_undividedSurfaceLand,
            'surplus_land_area' => $this->ls_surplusLandArea,
        ];

        //dd($data);

            LandDetailsModel::updateOrCreate(
            ['valuation_id' => $this->valuation_id],
            $data
        );



        //Al finalizar, aquí se puede generar un Toaster de guardado o bien, copiar alguna otra función para redireccionar
        //y a la vez enviar un toaster
        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'property-description']);
    }




    //FUNCIONES PARA GRUPOS Y ELEMENTOS DEL MISMO


    //Abrir modal para crear grupo
    public function openAddGroup()
    {

        if(!$this->landDetail){
            Toaster::error('Primero debes guardar los datos principales');
            return;
        }

        $this->resetValidation();
        Flux::modal('add-group')->show();

    }


    //Abrir modal para crear elemento
    public function openAddElement($groupId)
    {
        $this->groupId = $groupId;
        $this->resetValidation();
        Flux::modal('add-element')->show();
    }



    //Abrir modal para editar elemento
    public function openEditElement($groupDetailId)
    {


        // Carga el detalle desde BD
        $detail = GroupNeighborDetailsModel::findOrFail($groupDetailId);

        // Asigna los datos a las propiedades del componente
        $this->groupDetailId = $groupDetailId; // necesitas esta propiedad para el update luego
        $this->orientation = $detail->orientation;
        $this->extent = $detail->extent;
        $this->adjacent = $detail->adjacent;

       /*  $this->$groupDetailId = $groupDetailId; */
        //$this->resetValidation();
        Flux::modal('edit-element')->show();

    }



    //Función para crear grupo
    public function addGroup(){


        $rules = [
            'group' => 'required|unique:groups_neighbors,name'
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributeGroup()
        );

        GroupsNeighborsModel::create([
            'land_detail_id' => $this->landDetail->id,
            'name' => $this->group,
        ]);


        // Recarga los grupos para que aparezca el nuevo en la vista
        $this->groupsWithNeighbors = $this->landDetail
            ->groupsNeighbors()
            ->with('neighbors')
            ->get();

        Toaster::success('Grupo agregado con éxito');
        $this->modal('add-group')->close();

        $this->reset('group');
    }


    //Función para eliminar un grupo
    public function deleteGroup($groupId){

        // Buscar el grupo por ID
        $group = GroupsNeighborsModel::findOrFail($groupId);

        // Eliminar el grupo (esto también debería eliminar sus vecinos si tienes ON DELETE CASCADE)
        $group->delete();

        // Recargar la lista de grupos
        $this->groupsWithNeighbors = $this->landDetail
            ->groupsNeighbors()
            ->with('neighbors')
            ->get();

        Toaster::error('Grupo eliminado con éxito');

    }

    //Función para crear elemento
    public function addElement()
    {
        $rules = [
            'orientation' => 'required',
            'extent' => 'required',
            'adjacent' => 'required',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItem()
        );

        GroupNeighborDetailsModel::create([
            'group_neighbor_id' => $this->groupId,
            'orientation' => $this->orientation,
            'extent' => $this->extent,
            'adjacent' => $this->adjacent,
        ]);

        // Recargar la lista de grupos
        $this->groupsWithNeighbors = $this->landDetail
            ->groupsNeighbors()
            ->with('neighbors')
            ->get();

        $this->reset('orientation', 'extent', 'adjacent');
        Toaster::success('Elemento agregado con éxito');
        $this->modal('add-element')->close();
    }

    //Función para editar un elemento
    public function editElement()
    {
        $rules = [
            'orientation' => 'required',
            'extent' => 'required',
            'adjacent' => 'required',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItem()
        );

        $detail = GroupNeighborDetailsModel::findOrFail($this->groupDetailId);

        $detail->update([
            'orientation' => $this->orientation,
            'extent' => $this->extent,
            'adjacent' => $this->adjacent,
        ]);

        // Recargar los datos actualizados en la vista
        $this->groupsWithNeighbors = $this->landDetail
            ->groupsNeighbors()
            ->with('neighbors')
            ->get();


        Toaster::success('Elemento editado con éxito');
        $this->modal('edit-element')->close();
    }

    //Función para editar un elemento
    public function deleteElement($groupDetailId){

        // Buscar el registro y eliminarlo
        $detail = GroupNeighborDetailsModel::findOrFail($groupDetailId);
        $detail->delete();

        // Recargar los grupos con sus vecinos actualizados
        $this->groupsWithNeighbors = $this->landDetail
            ->groupsNeighbors()
            ->with('neighbors')
            ->get();

        Toaster::error('Elemento eliminado con éxito');
    }













    //ELEMENTOS PARA AGREGAR ELEMENTOS A SUPERFICIES DEL TERRENO
    public function openAddLandSurface()
    {

        if (!$this->landDetail) {
            Toaster::error('Primero debes guardar los datos principales');
            return;
        }
        $this->resetValidation();
        Flux::modal('add-LandSurface')->show();
    }



    public function openEditLandSurface($landSurfaceId)
    {
        $landSurface = LandSurfaceModel::findOrFail($landSurfaceId);

        $this->landSurfaceId = $landSurfaceId;
        $this->modalSurface = $landSurface->surface;

        //$this->resetValidation();
        Flux::modal('edit-LandSurface')->show();

    }





    public function addLandSurface()
    {
        $this->resetValidation();
        $rules = [
            'modalSurface' => 'required|numeric|between:0,99999',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributeLandSurface()
        );

        LandSurfaceModel::create([
            'land_detail_id' => $this->landDetail->id,
            'surface' => $this->modalSurface
            /* 'value_area' => 0, */
        ]);

        $this->reset('modalSurface');
        //$this->modalSurface = 0;

        // Recargar las superficies
        $this->landSurfaces = $this->landDetail->landSurfaces()->get();

        Toaster::success('Elemento agregado con éxito');
        $this->modal('add-LandSurface')->close();
    }


    public function editLandSurface()
    {
        $rules = [
            'modalSurface' => 'required|numeric|between:0,99999',
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributeLandSurface()
        );

        $landSurface = LandSurfaceModel::findOrFail($this->landSurfaceId);
        //dd("si llega");

        //dd($landSurface);

        $landSurface->update([
            'surface' => $this->modalSurface
        ]);

        $this->landSurfaces = $this->landDetail->landSurfaces()->get();


        Toaster::success('Elemento editado con éxito');
        $this->modal('edit-LandSurface')->close();
    }


    public function deleteLandSurface($landSurfaceId)
    {
        $landSurface = LandSurfaceModel::findOrFail($landSurfaceId);
        $landSurface->delete();

        $this->landSurfaces = $this->landDetail->landSurfaces()->get();

        Toaster::error('Elemento eliminado con éxito');
    }














    public function validateAllContainers()
    {
        //VALIDACIONES CONTAINER 1
        $container1 = [
            'sli_sourceLegalInformation' => 'required',
        ];

        //Validaciones si el tipo de fuente de informacion legal es escritura
        if ($this->sli_sourceLegalInformation === 'Escritura') {
            $container1 = array_merge($container1, [
                'sli_notaryOfficeDeed'  => 'required',
                'sli_deedDeed'   => 'required',
                'sli_volumeDeed' => 'required',
                'sli_dateDeed' => 'required',
                'sli_notaryDeed' => 'required',
                'sli_judicialDistricDeed' => 'required',
            ]);
        }

        //Validaciones si el tipo de fuente de información legal es sentencia
        if ($this->sli_sourceLegalInformation === 'Sentencia') {
            $container1 = array_merge($container1, [
                'sli_fileJudgment'  => 'required',
                'sli_dateJudgment'   => 'required',
                'sli_courtJudgment' => 'required',
                'sli_municipalityJudgment' => 'required',

            ]);
        }

        //Validaciones si el tipo de fuente de información legal es contrato privado
        if ($this->sli_sourceLegalInformation === 'Contrato privado') {
            $container1 = array_merge($container1, [
                'sli_datePrivCont'  => 'required',
                'sli_namePrivContAcq'   => 'required',
                'sli_firstNamePrivContAcq' => 'required',
                'sli_secondNamePrivContAcq' => 'required',
                'sli_namePrivContAlt' => 'required',
                'sli_firstNamePrivContAlt' => 'required',
                'sli_secondNamePrivContAlt' => 'required',

            ]);
        }


        //Validaciones si el tipo de fuente de información legal es alineamiento y numero oficial
        if ($this->sli_sourceLegalInformation === 'Alineamiento y numero oficial') {
            $container1 = array_merge($container1, [
                'sli_folioAon'  => 'required',
                'sli_dateAon'   => 'required',
                'sli_municipalityAon' => 'required'
            ]);
        }


        //Validaciones si el tipo de fuente de información legal es titulo de propiedad
        if ($this->sli_sourceLegalInformation === 'Titulo de propiedad') {
            $container1 = array_merge($container1, [
                'sli_recordPropReg'  => 'required',
                'sli_datePropReg'   => 'required',
                'sli_instrumentPropReg' => 'required',
                'sli_placePropReg' => 'required',
            ]);
        }


        //Validaciones si el tipo de fuente de información legal es otra fuente de informacion legal
        if ($this->sli_sourceLegalInformation === 'Otra fuente de informacion legal') {
            $container1 = array_merge($container1, [
                'sli_especifyAsli'  => 'required',
                'sli_dateAsli'   => 'required',
                'sli_emittedByAsli' => 'required',
                'sli_folioAsli' => 'required',
            ]);
        }

        //VALIDACIONES CONTAINER 3
        $container3 = [
            'ct_streetWithFront' => 'required',
            'ct_CrossStreet1' => 'required',
            'ct_crossStreetOrientation1' => 'required',
            'ct_CrossStreet2' => 'required',
            'ct_crossStreetOrientation2' => 'required',
            'ct_borderStreet1' => 'required',
            'ct_borderStreetOrientation1' => 'required',
            'ct_borderStreet2' => 'required',
            'ct_borderStreetOrientation2' => 'required',
            'ct_location' => 'required',
            'ct_configuration' => 'required',
            'ct_topography' => 'required',
            'ct_typeOfRoad' => 'required',
            'ct_panoramicFeatures' => 'required',
            'ct_EasementRestrictions' => 'required'
        ];

        if ($this->ct_EasementRestrictions === 'Otras') {
            $container3 = array_merge($container3, [
                'ct_EasementRestrictionsOthers' => 'required',
            ]);
        }


        //VALIDACIONES CONTAINER 4
        $container4 = [
            /* 'ls_useExcessCalculation' => 'boolean', */
            'ls_useExcessCalculation' => 'required',
        ];

        if ($this->ls_useExcessCalculation === true) {
            $container4 = array_merge($container4, [
                'ls_surfacePrivateLot' => 'required|numeric|min:0',
                'ls_surfacePrivateLotType' => 'required|numeric|min:0',
                'ls_surplusLandArea' => 'required'
            ]);
        }


        if (stripos($this->valuation->property_type, 'condominio') !== false) {
            $container4 = array_merge($container4, [
                'ls_undividedOnlyCondominium'  => 'required|numeric|min:0',
                'ls_undividedSurfaceLand' => 'required|numeric|min:0'
            ]);
        }




        $rules = array_merge($container1, $container3, $container4);

        return  Validator::make(
            $this->all(),
            $rules,
            [],
            $this->validationAttributes()
        );

    }

    protected function validationAttributes(): array
    {
        return [
            'sli_sourceLegalInformation' => 'fuente de información legal',


            'sli_notaryOfficeDeed'  => 'notaria',
            'sli_deedDeed'   => 'escritura',
            'sli_volumeDeed' => 'volumen',
            'sli_dateDeed' => 'fecha',
            'sli_notaryDeed' => 'notario',
            'sli_judicialDistricDeed' => 'distrito judicial',


            'sli_fileJudgment'  => 'expediente',
            'sli_dateJudgment'   => 'fecha',
            'sli_courtJudgment' => 'juzgado',
            'sli_municipalityJudgment' => 'municipio/alcaldia',


            'sli_datePrivCont'  => 'fecha',
            'sli_namePrivContAcq'   => 'nombre',
            'sli_firstNamePrivContAcq' => 'apellido paterno',
            'sli_secondNamePrivContAcq' => 'apellido materno',
            'sli_namePrivContAlt' => 'nombre',
            'sli_firstNamePrivContAlt' => 'apellido paterno',
            'sli_secondNamePrivContAlt' => 'apellido materno',


            'sli_folioAon'  => 'folio',
            'sli_dateAon'   => 'fecha',
            'sli_municipalityAon' => 'municipio/alcaldia',


            'sli_recordPropReg'  => 'expediente',
            'sli_datePropReg'   => 'fecha',
            'sli_instrumentPropReg' => '# instrumento',
            'sli_placePropReg' => 'lugar',


            'sli_especifyAsli'  => 'especifique',
            'sli_dateAsli'   => 'fecha',
            'sli_emittedByAsli' => 'emitido por',
            'sli_folioAsli' => 'folio',



            'ct_streetWithFront' => 'calle con frente',
            'ct_CrossStreet1' => 'calle transversal',
            'ct_crossStreetOrientation1' => 'orientacion calle transversal',
            'ct_CrossStreet2' => 'calle transversal',
            'ct_crossStreetOrientation2' => 'orientacion calle transversal',
            'ct_borderStreet1' => 'calle limitrofe',
            'ct_borderStreetOrientation1' => 'orientacion calle limitrofe',
            'ct_borderStreet2' => 'calle limitrofe',
            'ct_borderStreetOrientation2' => 'orientacion calle limitrofe',
            'ct_location' => 'ubicacion',
            'ct_configuration' => 'configuracion',
            'ct_topography' => 'topografia',
            'ct_typeOfRoad' => 'tipo de vialidad',
            'ct_panoramicFeatures' => 'caracteristicas panoramicas',
            'ct_EasementRestrictions' => 'servidumbre y/o restricciones',
            'ct_EasementRestrictionsOthers' => 'otras (servidumbre y/o restricciones)',




            'ls_surfacePrivateLot' => 'superficie lote privado',
            'ls_surfacePrivateLotType' => 'superficie lote privado tipo',
            'ls_undividedOnlyCondominium' => 'indiviso'


        ];
    }


    protected function validationAttributeGroup(): array
    {
        return [
            'group' => 'grupo'
        ];
    }


    protected function validationAttributesItem(): array
    {
        return [
            'orientation' => 'orientacion',
            'extent' => ' medida',
            'adjacent' => 'colindancia',
        ];
    }

    protected function validationAttributeLandSurface(): array
    {
        return [
            'modalSurface' => 'superfcie',
        ];
    }


    //FUNCION PARA LA CARGA DE ARCHIVOS
 /*    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'required|mimes:pdf,jpg,jpeg|max:2048',
        ]);
    }
 */

    /**
     * Función principal para cargar y guardar los archivos en el servidor.
     * Esta función es llamada por el botón 'Cargar archivo'
     */
    public function uploadFiles()
    {



        if (!$this->landDetail) {
            Toaster::error('Primero debes guardar los datos principales');
            return;
        }


        $this->validate([
            'photos' => 'required', // Se asegura de que al menos un archivo haya sido seleccionado.
            'photos.*' => 'file|mimes:pdf,jpg,jpeg|max:2048',
        ], [
            // Mensaje de error personalizado para la validación del campo vacío
            'photos.required' => 'Por favor, selecciona al menos un archivo para cargar.',
            'photos.*.mimes' => 'Solo se permiten archivos en formato PDF, JPG o JPEG.',
            'photos.*.max' => 'Cada archivo no debe superar los 2MB.',
        ], [
            'photos' => 'foto',
            'photos.*' => 'foto',
        ]);

        // Itera sobre cada archivo en el array de 'photos'.
        foreach ($this->photos as $photo) {
            $originalName = $photo->getClientOriginalName();
            $extension = $photo->getClientOriginalExtension();
            $type = $extension === 'pdf' ? 'pdf' : 'image';

            // Guarda el archivo
            $path = $photo->store('/', 'land_details_public');

               if (!$path) {
                dd("Fallo al guardar el archivo.");
            }

            MeasureBoundaryModel::create([
                'land_detail_id' => $this->landDetail->id,
                'file_path' => $path,
                'original_name' => $originalName,
                'file_type' => $type,
            ]);
        }

        // Limpia el array de archivos para resetear el input.
        $this->photos = [];

        // Recarga archivos (opcional, si los estás listando en pantalla)
        //$this->loadMeasureBoundaries();

        // Recarga la lista de archivos
        $this->measureBoundaries = $this->landDetail->measureBoundaries()->get();

        // Muestra un mensaje de éxito que se puede mostrar en la vista.
        Toaster::success('Archivo(s) cargado con éxito.');
        //session()->flash('message', '¡Archivos cargados correctamente!');
    }



    public function deleteFile($id)
    {
        $file = MeasureBoundaryModel::find($id);

        if (!$file) {
            Toaster::error('Archivo no encontrado.');
            return;
        }

        // Elimina el archivo físico si existe
        if (Storage::disk('land_details_public')->exists($file->file_path)) {
            Storage::disk('land_details_public')->delete($file->file_path);
        }

        // Elimina el registro de base de datos
        $file->delete();

        // Recarga la lista de archivos
        $this->measureBoundaries = $this->landDetail->measureBoundaries()->get();

        Toaster::error('Archivo eliminado con éxito.');
    }

    public function updatedPhotos()
    {
        // Limpia todos los errores relacionados con 'photos' y sus índices.
        $this->resetErrorBag();
    }


    public function render()
    {
        return view('livewire.forms.land-details');
    }
}
