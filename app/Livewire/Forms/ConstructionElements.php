<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;
use Flux\Flux;
use Illuminate\Support\Facades\DB;


use App\Models\Forms\ConstructionElements\ConstructionElementModel;

class ConstructionElements extends Component
{


    /* Obra negra */
    public $sc_structure, $sc_shallowFoundation, $sc_intermediateFloor, $sc_ceiling, $sc_walls, $sc_beamsColumns,
           $sc_roof, $sc_fences;

    /* Acabados 1 */
    public $fn1_hallFlats, $fn1_hallWalls, $fn1_hallCeilings,
           $fn1_stdrFlats, $fn1_stdrWalls, $fn1_stdrCeilings,
           $fn1_kitchenFlats, $fn1_kitchenWalls, $fn1_kitchenCeilings,
           $fn1_bedroomsNumber, $fn1_bedroomsFlats, $fn1_bedroomsWalls, $fn1_bedroomsCeilings,
           $fn1_bathroomsNumber, $fn1_bathroomsFlats, $fn1_bathroomsWalls, $fn1_bathroomsCeilings,
           $fn1_halfBathroomsNumber, $fn1_halfBathroomsFlats, $fn1_halfBathroomsWalls, $fn1_halfBathroomsCeilings,
           $fn1_utyrFlats, $fn1_utyrWalls, $fn1_utyrCeilings,
           $fn1_stairsFlats, $fn1_stairsWalls, $fn1_stairsCeilings,
           $fn1_copaNumber, $fn1_copaFlats, $fn1_copaWalls, $fn1_copaCeilings,
           $fn1_unpaNumber, $fn1_unpaFlats, $fn1_unpaWalls, $fn1_unpaCeilings;

    /* Acabados 2 */
    public $fn2_cementPlaster, $fn2_ceilings, $fn2_furredWalls, $fn2_stairs, $fn2_flats, $fn2_plinths,
           $fn2_paint, $fn2_specialCoating;

    /* Carpientaria */
    public $car_doorsAccess, $car_insideDoors, $car_fixedFurnitureBedrooms, $car_fixedFurnitureInsideBedrooms;

    /* Hidráulicas y sanitarias */
    public $hs_bathroomFurniture,
           $hs_hiddenApparentHydraulicBranches, $hs_hydraulicBranches,
           $hs_hiddenApparentSanitaryBranches, $hs_SanitaryBranches,
           $hs_hiddenApparentElectrics, $hs_electrics;

    /* Herrería */
    public $sm_serviceDoor, $sm_windows, $sm_others;

    /* Otros elementos */
    public $oe_structure, $oe_locksmith, $oe_facades, $oe_elevator;

    // Estado del tab activo
    public string $activeTab;

    //Variables para agregar elemento a tabla de acabados 1
    public $space, $amount, $floors, $walls, $ceilings;


    //  Inicializar con el tab por defecto
    public function mount()
    {


        $constructionElement = ConstructionElementModel::where('valuation_id', session('valuation_id'))->first();

        if($constructionElement){
            // 1. Obra Estructural (StructuralWork)
            if ($structuralWork = $constructionElement->structuralWork) {
                $this->sc_structure = $structuralWork->structure;
                $this->sc_shallowFoundation = $structuralWork->shallow_fundation;
                $this->sc_intermediateFloor = $structuralWork->intermeediate_floor;
                $this->sc_ceiling = $structuralWork->ceiling;
                $this->sc_walls = $structuralWork->walls;
                $this->sc_beamsColumns = $structuralWork->beams_columns;
                $this->sc_roof = $structuralWork->roof;
                $this->sc_fences = $structuralWork->fences;
            }

            // 2. Acabados 1 (Finishing1)
            if ($finishing1 = $constructionElement->finishing1) {
                // Campos numéricos
                $this->fn1_bedroomsNumber = $finishing1->bedrooms_number;
                $this->fn1_bathroomsNumber = $finishing1->bathrooms_number;
                $this->fn1_halfBathroomsNumber = $finishing1->half_bathrooms_number;
                $this->fn1_copaNumber = $finishing1->copa_number;
                $this->fn1_unpaNumber = $finishing1->unpa_number;


                // --- B. SALA (Hall) ---
                $this->fn1_hallFlats = $finishing1->hall_flats;
                $this->fn1_hallWalls = $finishing1->hall_walls;
                $this->fn1_hallCeilings = $finishing1->hall_ceilings;

                // --- C. COMEDOR (Stdr) ---
                $this->fn1_stdrFlats = $finishing1->stdr_flats;
                $this->fn1_stdrWalls = $finishing1->stdr_walls;
                $this->fn1_stdrCeilings = $finishing1->stdr_ceilings;

                // --- D. COCINA (Kitchen) ---
                $this->fn1_kitchenFlats = $finishing1->kitchen_flats;
                $this->fn1_kitchenWalls = $finishing1->kitchen_walls;
                $this->fn1_kitchenCeilings = $finishing1->kitchen_ceilings;

                // --- E. RECÁMARAS (Bedrooms) ---
                $this->fn1_bedroomsFlats = $finishing1->bedrooms_flats;
                $this->fn1_bedroomsWalls = $finishing1->bedrooms_walls;
                $this->fn1_bedroomsCeilings = $finishing1->bedrooms_ceilings;

                // --- F. BAÑOS (Bathrooms) ---
                $this->fn1_bathroomsFlats = $finishing1->bathrooms_flats;
                $this->fn1_bathroomsWalls = $finishing1->bathrooms_walls;
                $this->fn1_bathroomsCeilings = $finishing1->bathrooms_ceilings;

                // --- G. MEDIOS BAÑOS (Half Bathrooms) ---
                $this->fn1_halfBathroomsFlats = $finishing1->half_bathrooms_flats;
                $this->fn1_halfBathroomsWalls = $finishing1->half_bathrooms_walls;
                $this->fn1_halfBathroomsCeilings = $finishing1->half_bathrooms_ceilings;

                // --- H. CUARTO DE SERVICIO/LAVADO (Utyr) ---
                $this->fn1_utyrFlats = $finishing1->utyr_flats;
                $this->fn1_utyrWalls = $finishing1->utyr_walls;
                $this->fn1_utyrCeilings = $finishing1->utyr_ceilings;

                // --- I. ESCALERAS (Stairs) ---
                $this->fn1_stairsFlats = $finishing1->stairs_flats;
                $this->fn1_stairsWalls = $finishing1->stairs_walls;
                $this->fn1_stairsCeilings = $finishing1->stairs_ceilings;

                // --- J. COPA (Copa) ---
                $this->fn1_copaFlats = $finishing1->copa_flats;
                $this->fn1_copaWalls = $finishing1->copa_walls;
                $this->fn1_copaCeilings = $finishing1->copa_ceilings;

                // --- K. ESPACIOS SIN PISOS (Unpa) ---
                $this->fn1_unpaFlats = $finishing1->unpa_flats;
                $this->fn1_unpaWalls = $finishing1->unpa_walls;
                $this->fn1_unpaCeilings = $finishing1->unpa_ceilings;
            }

            // 3. Acabados 2 (Finishing2)
            if ($finishing2 = $constructionElement->finishing2) {
                $this->fn2_cementPlaster = $finishing2->cement_plaster;
                $this->fn2_ceilings = $finishing2->ceilings;
                $this->fn2_furredWalls = $finishing2->furred_walls;
                $this->fn2_stairs = $finishing2->stairs;
                $this->fn2_flats = $finishing2->flats;
                $this->fn2_plinths = $finishing2->plinths;
                $this->fn2_paint = $finishing2->paint;
                $this->fn2_specialCoating = $finishing2->special_coating;
            }

            // 4. Carpintería (Carpentry)
            if ($carpentry = $constructionElement->carpentry) {
                $this->car_doorsAccess = $carpentry->doors_access;
                $this->car_insideDoors = $carpentry->inside_doors;
                $this->car_fixedFurnitureBedrooms = $carpentry->fixed_furniture_bedrooms;
                $this->car_fixedFurnitureInsideBedrooms = $carpentry->fixed_furniture_inside_bedrooms;
            }

            // 5. Hidráulicas y Sanitarias (Hydraulic)
            if ($hydraulic = $constructionElement->hydraulic) { // Usando el método 'hydraulic()'
                $this->hs_bathroomFurniture = $hydraulic->bathroom_furniture;
                $this->hs_hiddenApparentHydraulicBranches = $hydraulic->hidden_apparent_hydraulic_branches;
                $this->hs_hydraulicBranches = $hydraulic->hydraulic_branches;
                $this->hs_hiddenApparentSanitaryBranches = $hydraulic->hidden_apparent_sanitary_branches;
                $this->hs_SanitaryBranches = $hydraulic->sanitary_branches;
                $this->hs_hiddenApparentElectrics = $hydraulic->hidden_apparent_electrics;
                $this->hs_electrics = $hydraulic->electrics;
            }

            // 6. Herrería (Ironwork)
            if ($ironwork = $constructionElement->ironwork) {
                $this->sm_serviceDoor = $ironwork->service_door;
                $this->sm_windows = $ironwork->windows;
                $this->sm_others = $ironwork->others;
            }

            // 7. Otros Elementos (OtherElement)
            if ($otherElement = $constructionElement->otherElements) { // Usando el método 'otherElements()'
                $this->oe_structure = $otherElement->structure;
                $this->oe_locksmith = $otherElement->locksmith;
                $this->oe_facades = $otherElement->facades;
                $this->oe_elevator = $otherElement->elevator;
            }
        } else {
            //Inicializamos los valores de los input radio en caso de que no se tenga asignado un valor en la bd
            $this->fn1_bedroomsNumber = 0;
            $this->fn1_bathroomsNumber = 0;
            $this->fn1_halfBathroomsNumber = 0;
            $this->fn1_copaNumber = 0;
            $this->fn1_unpaNumber = 0;

            $this->hs_hiddenApparentHydraulicBranches = 'Oculta';
            $this->hs_hiddenApparentSanitaryBranches = 'Oculta';
            $this->hs_hiddenApparentElectrics = 'Oculta';

            $this->oe_elevator = 'Si cuenta';

        }




        //Inicializamos el valor de la ventana que se abrirá por defecto
        $this->activeTab = 'obra_negra';
    }

    // 3. Método para cambiar de tab
    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function save(){


        //Validación de datos
        $validator = $this->validateAll();

        if ($validator->fails()) {
            //Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            //Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            //Hacemos un return para detener el flujo del sistema
            return;
        }

        //Generación de arreglos de datos para cada tabla

        $dataStructuralWork = [
            'structure'             => $this->sc_structure,
            'shallow_fundation'     => $this->sc_shallowFoundation,
            'intermeediate_floor'   => $this->sc_intermediateFloor,
            'ceiling'               => $this->sc_ceiling,
            'walls'                 => $this->sc_walls,
            'beams_columns'         => $this->sc_beamsColumns,
            'roof'                  => $this->sc_roof,
            'fences'                => $this->sc_fences,
        ];

        $dataFinishing1 = [
            'bedrooms_number'           => $this->fn1_bedroomsNumber,
            'bathrooms_number'          => $this->fn1_bathroomsNumber,
            'half_bathrooms_number'     => $this->fn1_halfBathroomsNumber,
            'copa_number'               => $this->fn1_copaNumber,
            'unpa_number'               => $this->fn1_unpaNumber,

            'hall_flats'                => $this->fn1_hallFlats,
            'hall_walls'                => $this->fn1_hallWalls,
            'hall_ceilings'             => $this->fn1_hallCeilings,

            'stdr_flats'                => $this->fn1_stdrFlats,
            'stdr_walls'                => $this->fn1_stdrWalls,
            'stdr_ceilings'             => $this->fn1_stdrCeilings,

            'kitchen_flats'             => $this->fn1_kitchenFlats,
            'kitchen_walls'             => $this->fn1_kitchenWalls,
            'kitchen_ceilings'          => $this->fn1_kitchenCeilings,

            'bedrooms_flats'            => $this->fn1_bedroomsFlats,
            'bedrooms_walls'            => $this->fn1_bedroomsWalls,
            'bedrooms_ceilings'         => $this->fn1_bedroomsCeilings,

            'bathrooms_flats'           => $this->fn1_bathroomsFlats,
            'bathrooms_walls'           => $this->fn1_bathroomsWalls,
            'bathrooms_ceilings'        => $this->fn1_bathroomsCeilings,

            'half_bathrooms_flats'      => $this->fn1_halfBathroomsFlats,
            'half_bathrooms_walls'      => $this->fn1_halfBathroomsWalls,
            'half_bathrooms_ceilings'   => $this->fn1_halfBathroomsCeilings,

            'utyr_flats'                => $this->fn1_utyrFlats,
            'utyr_walls'                => $this->fn1_utyrWalls,
            'utyr_ceilings'             => $this->fn1_utyrCeilings,

            'stairs_flats'              => $this->fn1_stairsFlats,
            'stairs_walls'              => $this->fn1_stairsWalls,
            'stairs_ceilings'           => $this->fn1_stairsCeilings,

            'copa_flats'                => $this->fn1_copaFlats,
            'copa_walls'                => $this->fn1_copaWalls,
            'copa_ceilings'             => $this->fn1_copaCeilings,

            'unpa_flats'                => $this->fn1_unpaFlats,
            'unpa_walls'                => $this->fn1_unpaWalls,
            'unpa_ceilings'             => $this->fn1_unpaCeilings,
        ];

        $dataFinishing2 = [
            'cement_plaster'    => $this->fn2_cementPlaster,
            'ceilings'          => $this->fn2_ceilings,
            'furred_walls'      => $this->fn2_furredWalls,
            'stairs'            => $this->fn2_stairs,
            'flats'             => $this->fn2_flats,
            'plinths'           => $this->fn2_plinths,
            'paint'             => $this->fn2_paint,
            'special_coating'   => $this->fn2_specialCoating,
        ];

        $dataCarpentry = [
            'doors_access'                  => $this->car_doorsAccess,
            'inside_doors'                  => $this->car_insideDoors,
            'fixed_furniture_bedrooms'      => $this->car_fixedFurnitureBedrooms,
            'fixed_furniture_inside_bedrooms' => $this->car_fixedFurnitureInsideBedrooms,
        ];

        $dataHydraulicSanitary = [
            'bathroom_furniture'                => $this->hs_bathroomFurniture,
            'hidden_apparent_hydraulic_branches' => $this->hs_hiddenApparentHydraulicBranches,
            'hydraulic_branches'                => $this->hs_hydraulicBranches,
            'hidden_apparent_sanitary_branches'  => $this->hs_hiddenApparentSanitaryBranches,
            'sanitary_branches'                 => $this->hs_SanitaryBranches,
            'hidden_apparent_electrics'         => $this->hs_hiddenApparentElectrics,
            'electrics'                         => $this->hs_electrics,
        ];

        $dataIronwork = [
            'service_door'  => $this->sm_serviceDoor,
            'windows'       => $this->sm_windows,
            'others'        => $this->sm_others,
        ];

        $dataOtherElement = [
            'structure'     => $this->oe_structure,
            'locksmith'     => $this->oe_locksmith,
            'facades'       => $this->oe_facades,
            'elevator'      => $this->oe_elevator,
        ];



        //Transacción de datos
        // ... después de la validación exitosa y la preparación de las 8 variables $data...

        try {
            // INICIO DE LA TRANSACCIÓN:
            // 1. Laravel llama al comando "START TRANSACTION" en la base de datos (MySQL, PostgreSQL, etc.).
            // 2. A partir de aquí, todas las operaciones de INSERT/UPDATE están "pendientes" y pueden ser deshechas.
            /* Las variables $data... se hacen accesibles dentro de esta función anónima (closure). */
            DB::transaction(function () use (
                $dataStructuralWork,
                $dataFinishing1,
                $dataFinishing2,
                $dataCarpentry,
                $dataIronwork,
                $dataHydraulicSanitary,
                $dataOtherElement,

            ) {
                // Si ConstructionElementModel SÓLO tiene la clave foránea y timestamps:
                $dataConstructionElement = [];
                // 1. CREAR/OBTENER EL ELEMENTO PADRE (construction_elements)
                // Esta es la tabla que actuará como "llave maestra" para el resto.
                $constructionElement = ConstructionElementModel::firstOrCreate(
                    ['valuation_id' => session('valuation_id')], // Criterio de búsqueda: Encuentra un registro con este ID de avalúo.
                    $dataConstructionElement               // Datos para usar SI el registro NO existe.
                );
                // Si el elemento ya existe, se obtiene. Si no, se crea y SE GENERA EL ID.
                // Este ID (ej. 150) es ahora el que se usará en todas las tablas auxiliares.

                // 2. GUARDAR RELACIONES 1:1 (HasOne)
                // Para cada tabla auxiliar que debe tener UN solo registro por elemento de construcción:

                // updateOrCreate: Busca un registro hijo ligado a $constructionElement.
                // Si existe, lo actualiza. Si NO existe, LO CREA.
                // 🔑 Eloquent INYECTA AUTOMÁTICAMENTE: 'construction_elements_id' => $constructionElement->id

                $constructionElement->structuralWork()->updateOrCreate([], $dataStructuralWork);
                $constructionElement->finishing1()->updateOrCreate([], $dataFinishing1);
                $constructionElement->finishing2()->updateOrCreate([], $dataFinishing2);
                $constructionElement->carpentry()->updateOrCreate([], $dataCarpentry);
                $constructionElement->ironwork()->updateOrCreate([], $dataIronwork);
                $constructionElement->hydraulic()->updateOrCreate([], $dataHydraulicSanitary);
                $constructionElement->otherElements()->updateOrCreate([], $dataOtherElement);
                // Todas estas operaciones están AHORA pendientes dentro de la transacción.



                // FIN DE LA FUNCIÓN ANÓNIMA: Si llegamos aquí sin errores...
                // 4. Se ejecuta el comando "COMMIT" en la base de datos.
                // Todos los INSERTs, UPDATEs y DELETEs pendientes se confirman y se vuelven permanentes.

            }); // Cierre de DB::transaction()

            // Éxito: Solo se llega aquí si el COMMIT fue exitoso.
            Toaster::success('Datos guardados con éxito.');
            return redirect()->route('form.index', ['section' => 'buildings']);
        } catch (\Exception $e) {
            // CUALQUIER ERROR: Si falla la validación, la base de datos (ej. un campo NOT NULL) o el PHP...
            // 5. Se ejecuta automáticamente el "ROLLBACK".
            // Todos los cambios realizados (INSERTs, UPDATEs, DELETEs) en las 8 tablas se deshacen.
           //  Toaster::error('Error al guardar los datos: ' . $e->getMessage());
            //dd($e->getMessage());
        }

        //Toaster::success('Archivos guardados con éxito con éxito');
    }



    //FUNCIONES PARA GRUPOS Y ELEMENTOS DEL MISMO

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


    public function addItem()
    {
        $rules = [
            'space' => 'required',
            'amount' => 'required',
            'floors' => 'required',
            'walls' => 'required',
            'ceilings' => 'required'
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );


        $this->space = '';
        $this->amount = '';
        $this->floors = '';
        $this->walls = '';
        $this->ceilings = '';

        Toaster::success('Elemento agregado con éxito');
        $this->modal('add-item')->close();
    }



    public function deleteItem()
    {

        Toaster::error('Elemento eliminado con éxito');
    }



    public function editItem()
    {
         $rules = [
            'space' => 'required',
            'amount' => 'required',
            'floors' => 'required',
            'walls' => 'required',
            'ceilings' => 'required'
        ];

        $this->validate(
            $rules,
            [],
            $this->validationAttributesItems()
        );


        $this->space = '';
        $this->amount = '';
        $this->floors = '';
        $this->walls = '';
        $this->ceilings = '';

        Toaster::success('Elemento editado con éxito');
        $this->modal('edit-item')->close();
    }




    public function validateAll()
    {
        $rules = [
            /* Obra negra */
            'sc_structure'               => 'required',
            'sc_shallowFoundation'       => 'required',
            'sc_intermediateFloor'       => 'required',
            'sc_ceiling'                 => 'required',
            'sc_walls'                   => 'required',
            'sc_beamsColumns'            => 'required',
            'sc_roof'                    => 'required',
            'sc_fences'                  => 'required',

            /* Acabados 1 */
            'fn1_hallFlats'              => 'required',
            'fn1_hallWalls'              => 'required',
            'fn1_hallCeilings'           => 'required',
            'fn1_stdrFlats'              => 'required',
            'fn1_stdrWalls'              => 'required',
            'fn1_stdrCeilings'           => 'required',
            'fn1_kitchenFlats'           => 'required',
            'fn1_kitchenWalls'           => 'required',
            'fn1_kitchenCeilings'        => 'required',
            /* 'fn1_bedroomsNumber'         => 'required', */
            'fn1_bedroomsFlats'          => 'required',
            'fn1_bedroomsWalls'          => 'required',
            'fn1_bedroomsCeilings'       => 'required',
           /*  'fn1_bathroomsNumber'        => 'required', */
            'fn1_bathroomsFlats'         => 'required',
            'fn1_bathroomsWalls'         => 'required',
            'fn1_bathroomsCeilings'      => 'required',
            /* 'fn1_halfBathroomsNumber'          => 'required', */
            'fn1_halfBathroomsFlats'     => 'required',
            'fn1_halfBathroomsWalls'     => 'required',
            'fn1_halfBathroomsCeilings'  => 'required',
            'fn1_utyrFlats'              => 'required',
            'fn1_utyrWalls'              => 'required',
            'fn1_utyrCeilings'           => 'required',
            'fn1_stairsFlats'            => 'required',
            'fn1_stairsWalls'            => 'required',
            'fn1_stairsCeilings'         => 'required',
     /*        'fn1_copaNumber'             => 'required', */
            'fn1_copaFlats'              => 'required',
            'fn1_copaWalls'              => 'required',
            'fn1_copaCeilings'           => 'required',
        /*     'fn1_unpaNumber'             => 'required', */
            'fn1_unpaFlats'              => 'required',
            'fn1_unpaWalls'              => 'required',
            'fn1_unpaCeilings'           => 'required',

            /* Acabados 2 */
            'fn2_cementPlaster'          => 'required',
            'fn2_ceilings'               => 'required',
            'fn2_furredWalls'            => 'required',
            'fn2_stairs'                 => 'required',
            'fn2_flats'                  => 'required',
            'fn2_plinths'                => 'required',
            'fn2_paint'                  => 'required',
            'fn2_specialCoating'         => 'required',

            /* Carpientaria */
            'car_doorsAccess'            => 'required',
            'car_insideDoors'            => 'required',
            'car_fixedFurnitureBedrooms' => 'required',
            'car_fixedFurnitureInsideBedrooms' => 'required',


            /* Hidráulicas y sanitarias */
            'hs_bathroomFurniture'                  => 'required',
            /* 'hs_hiddenApparentHydraulicBranches'    => 'required', */
            'hs_hydraulicBranches'                  => 'required',
            /* 'hs_hiddenApparentSanitaryBranches'     => 'required', */
            'hs_SanitaryBranches'                   => 'required',
            /* 'hs_hiddenApparentElectrics'            => 'required', */
            'hs_electrics'                          => 'required',

            /* Herrería */
            'sm_serviceDoor'             => 'required',
            'sm_windows'                 => 'required',
            'sm_others'                  => 'required',

            /* Otros elementos */
            'oe_structure'               => 'required',
            'oe_locksmith'               => 'required',
            'oe_facades'                 => 'required',
            'oe_elevator'                => 'required'
        ];

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
            /* Obra negra */
            'sc_structure'               => 'estructura',
            'sc_shallowFoundation'       => 'cimientación',
            'sc_intermediateFloor'       => 'entrepisos',
            'sc_ceiling'                 => 'techos',
            'sc_walls'                   => 'muros',
            'sc_beamsColumns'            => 'trabes y columnas',
            'sc_roof'                    => 'azoteas',
            'sc_fences'                  => 'bardas',

            /* Acabados 1 */
            'fn1_hallFlats'              => ' ',
            'fn1_hallWalls'              => ' ',
            'fn1_hallCeilings'           => ' ',
            'fn1_stdrFlats'              => ' ',
            'fn1_stdrWalls'              => ' ',
            'fn1_stdrCeilings'           => ' ',
            'fn1_kitchenFlats'           => ' ',
            'fn1_kitchenWalls'           => ' ',
            'fn1_kitchenCeilings'        => ' ',
            /* 'fn1_bedroomsNumber'         => ' ', */
            'fn1_bedroomsFlats'          => ' ',
            'fn1_bedroomsWalls'          => ' ',
            'fn1_bedroomsCeilings'       => ' ',
            /* 'fn1_bathroomsNumber'        => ' ', */
            'fn1_bathroomsFlats'         => ' ',
            'fn1_bathroomsWalls'         => ' ',
            'fn1_bathroomsCeilings'      => ' ',
            /* 'fn1_halfBathroomsNumber'    => ' ', */
            'fn1_halfBathroomsFlats'     => ' ',
            'fn1_halfBathroomsWalls'     => ' ',
            'fn1_halfBathroomsCeilings'  => ' ',
            'fn1_utyrFlats'              => ' ',
            'fn1_utyrWalls'              => ' ',
            'fn1_utyrCeilings'           => ' ',
            'fn1_stairsFlats'            => ' ',
            'fn1_stairsWalls'            => ' ',
            'fn1_stairsCeilings'         => ' ',
            /* 'fn1_copaNumber'             => ' ', */
            'fn1_copaFlats'              => ' ',
            'fn1_copaWalls'              => ' ',
            'fn1_copaCeilings'           => ' ',
            /* 'fn1_unpaNumber'             => ' ', */
            'fn1_unpaFlats'              => ' ',
            'fn1_unpaWalls'              => ' ',
            'fn1_unpaCeilings'           => ' ',

            /* Acabados 2 */
            'fn2_cementPlaster'          => 'aplanados',
            'fn2_ceilings'               => 'plafones',
            'fn2_furredWalls'            => 'lambrines',
            'fn2_stairs'                 => 'escaleras',
            'fn2_flats'                  => 'pisos',
            'fn2_plinths'                => 'zoclos',
            'fn2_paint'                  => 'pintura',
            'fn2_specialCoating'         => 'Recubrimientos especiales',

            /* Carpientaria */
            'car_doorsAccess'            => 'puertas de acceso a la vivienda',
            'car_insideDoors'            => 'puertas interiores',
            'car_fixedFurnitureBedrooms' => 'muebles empotrados fuera recámaras',
            'car_fixedFurnitureInsideBedrooms' => 'muebles empotrados en recámaras',

            /* Hidráulicas y sanitarias */
            'hs_bathroomFurniture'                  => 'muebles de baño',
            /* 'hs_hiddenApparentHydraulicBranches'    => 'required', */
            'hs_hydraulicBranches'                  => 'ramaleos hidráulicos',
            /* 'hs_hiddenApparentSanitaryBranches'     => 'required', */
            'hs_SanitaryBranches'                   => 'ramaleos sanitarios',
            /* 'hs_hiddenApparentElectrics'            => 'required', */
            'hs_electrics'                          => 'eléctricas',


            /* Herrería */
            'sm_serviceDoor'             => 'puerta de patio de servicio',
            'sm_windows'                 => 'ventaneria',
            'sm_others'                  => 'otros',

            /* Otros elementos */
            'oe_structure'               => 'vidriería',
            'oe_locksmith'               => 'cerrajeria',
            'oe_facades'                 => 'fachadas',
            /* 'oe_elevator'                => 'cuenta con elevador */

        ];
    }

    protected function validationAttributesItems(): array
    {
        return [
            'space' => 'espacio',
            'amount' => 'cantidad',
            'floors' => 'pisos',
            'walls' => 'paredes',
            'ceilings' => 'plafones'
        ];
    }

    public function render()
    {
        return view('livewire.forms.construction-elements');
    }
}
