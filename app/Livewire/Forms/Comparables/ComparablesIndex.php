<?php

namespace App\Livewire\Forms\Comparables;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Valuation;
use Flux\Flux;
use Masmerise\Toaster\Toaster;
use App\Services\DipomexService;

class ComparablesIndex extends Component
{
    public $id;
    public $valuation;

    //Variables para obtener valores en el modal
    public $states = [];
    public $municipalities = [];
    public $colonies = [];



    //Variables para el modal de creación de comparables para el avaluo
    public $comparableKey, $comparableFolio, $comparableDischargedBy, $Comparableproperty, $comparableCp,
    $comparableEntity, $comparableLocality, $comparableColony, $comparableOtherColony, $comparableStreet,
    $comparableAbroadNumber, $comparableInsideNumber, $comparableBetweenStreet, $comparableAndStreet,
    $comparableName, $comparableLastName, $comparablePho;


    public function mount(DipomexService $dipomex)
    {


        //Obtenemos los estados
        $this->states = $dipomex->getEstados();

        //Añadimos la variable de sesión que validará el acceso a este componente
        $this->id = Session::get('valuation_id');
        //Buscamos el valor del avaluó para mostrar el valor del folio correspondiente
        $this->valuation = Valuation::find($this->id);
    }


    //Función para agregar un comparable para el avalúo
    public function openAddComparable()
    {
        $this->resetValidation();
        Flux::modal('add-comparable')->show();
    }


    public function save(){
        Toaster::success('Comparable añadido');
        Flux::modal('add-comparable')->close();
    }






    //Función para búsqueda del código postal del propietario, usando API Dipomex
    //Las funciones se repiten para cáda uno, seperando la lógica y evitando que se mezclen los datos
    public function buscarCP(DipomexService $dipomex)
    {
        //Validamos que el campo no esté vacío y contenga 5 dígitos
        $this->validate([
            'comparableCp' => 'required|digits:5'
        ]);

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


        $this->reset(['gi_ownerColony', 'colonies']);

        if ($municipioId && $this->comparableEntity) {
            // Como ahora gi_ownerLocality tiene el MUNICIPIO_ID, lo pasamos directo
            $this->colonies = $dipomex->getColoniasPorMunicipio($this->comparableEntity, $municipioId);
        }
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
