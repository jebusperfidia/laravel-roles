<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;
use Flux\Flux;

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

        //Inicializamos los valores de los input radio en caso de que no se tenga asignado un valor en la bd
        $this->hs_hiddenApparentHydraulicBranches = 'Oculta';
        $this->hs_hiddenApparentSanitaryBranches = 'Oculta';
        $this->hs_hiddenApparentElectrics = 'Oculta';

        $this->oe_elevator = 'Si cuenta';


        //Inicializamos el valor de la ventana que se abrirá por defecto
        $this->activeTab = 'obra_negra';
    }

    // 3. Método para cambiar de tab
    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function save(){
        $validator = $this->validateAll();

        if ($validator->fails()) {
            //Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            //Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            //Hacemos un return para detener el flujo del sistema
            return;
        }

        Toaster::success('Archivos guardados con éxito con éxito');
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
