<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;
// --- IMPORTACIONES AÑADIDAS ---
use App\Models\Valuations\Valuation; // Asegúrate que la ruta a tu modelo Valuation sea correcta
use App\Models\Forms\Comparable\ValuationLandComparableModel; // Importar pivot Land
use App\Models\Forms\Comparable\ValuationBuildingComparableModel; // Importar pivot Building
use App\Models\Forms\ApplicableSurface\ApplicableSurfaceModel;

class MarketFocus extends Component
{
    // --- PROPIEDADES PARA CONTEOS Y CÁLCULOS ---
    public $valuationId;
    public $landCount = 0;
    public $buildingCount = 0;

    // --- PROPIEDADES PARA CÁLCULOS (TABLA 1: Enfoque de mercado) ---
    public $landAvgUnitValue = 0.00;
    public $landHomologatedValue = 0.00;
    public $landProbableValue = 0.00;
    public $buildingAvgUnitValue = 0.00;
    public $buildingHomologatedValue = 0.00;
    public $buildingProbableValue = 0.00;

    // --- PROPIEDADES PARA CÁLCULOS (TABLA 2: Valor del terreno) ---
    public $terrainSurface = 1.00; // O cárgalo desde tu avalúo
    public $marketUnitValue = 0.00; // Este probablemente viene de $landProbableValue
    public $totalTerrainAmount = 0.00;
    public $applicableUndividedPercent = 0; // O cárgalo desde tu avalúo
    public $terrainValue = 0.00;

    // --- PROPIEDADES PARA CÁLCULOS (TABLA 3: Valor de construcciones) ---
   /*  public $sellableBuiltArea = 100.00; // O cárgalo desde tu avalúo */
    public $constructionMarketUnitValue = 0.00; // Este probablemente viene de $buildingProbableValue
    public $marketValue = 0.00;



    //variables para obtener el valor de la superficie vendible
    public $applicableSurface;

    public $saleableBuiltArea;



    /**
     * Se ejecuta al cargar el componente.
     */
    public function mount()
    {
        // Obtenemos el ID del avalúo activo desde la sesión
        $this->valuationId = Session::get('valuation_id');

        //Obtenemos el valor de superficie construida
        $this->applicableSurface = ApplicableSurfaceModel::where('valuation_id', session('valuation_id'))->first();

        if(!$this->applicableSurface) $this->saleableBuiltArea = 0;
        else $this->saleableBuiltArea = $this->applicableSurface->built_area;






        // Cargamos todos los datos iniciales
        $this->loadData();
    }

    /**
     * Función principal para cargar y refrescar todos los datos.
     */
    public function loadData()
    {

        if (!$this->valuationId) {
            // Si no hay avalúo en sesión, dejamos los contadores en 0
            $this->landCount = 0;
            $this->buildingCount = 0;
            return;
        }

        // Usamos los modelos PIVOT para contar eficientemente
        $this->landCount = ValuationLandComparableModel::where('valuation_id', $this->valuationId)->count();
        $this->buildingCount = ValuationBuildingComparableModel::where('valuation_id', $this->valuationId)->count();
        //$this->getComparableCounts();
       // $this->calculateMarketValues(); // Llama a tu lógica de cálculos
    }

    /**
     * Cuenta los comparables asignados de cada tipo para el avalúo actual.
     */
   /*  public function getComparableCounts()
    {

    } */

    /**
     * STUB: Aquí debes integrar tu lógica de cálculo.
     * Esta función debe llenar las propiedades públicas (ej. $this->landAvgUnitValue).
     */
    /* public function calculateMarketValues()
    { */
        // **INTEGRA TU LÓGICA DE CÁLCULO AQUÍ**

        // Ejemplo de cómo podrías llenarlas (debes reemplazar esto):
        // 1. Obtener valores de la BD o de cálculos previos
        // $this->landProbableValue = ... (resultado de tu cálculo)
        // $this->buildingProbableValue = ... (resultado de tu cálculo)

        // 2. Llenar las tablas de resumen
        // $this->marketUnitValue = $this->landProbableValue;
        // $this->totalTerrainAmount = $this->terrainSurface * $this->marketUnitValue;
        // $this->terrainValue = $this->totalTerrainAmount * ($this->applicableUndividedPercent / 100);

        // $this->constructionMarketUnitValue = $this->buildingProbableValue;
        // $this->marketValue = $this->sellableBuiltArea * $this->constructionMarketUnitValue;

        // ...etc.
 /*    } */


    /* Tus funciones existentes para abrir comparables */
    /* (Estas ya manejan la sesión, así que están perfectas) */
    public function openComparablesLand()
    {
        Session::put('comparables-active-session', true);
        Session::put('comparable-type', 'land');
        return redirect()->route('form.comparables.index');
    }

    public function openComparablesBuilding()
    {
        Session::put('comparables-active-session', true);
        Session::put('comparable-type', 'building');
        return redirect()->route('form.comparables.index');
    }

    /*
        public function comparativeMarketLand(){
            Toaster::success('Aquí se ejecutará la función para cambiar variables para nuevo menú y enviar directamente al componente de comparativas de mercado');
        }

        public function comparativeMarketBuilding(){
            Toaster::success('Aquí se ejecutará la función para cambiar variables para nuevo menú y enviar directamente al componente de comparativas de mercado');
        }
    */







    public function toHomologationLand()
    {

        if ($this->landCount < 4) {
            Toaster::warning('Se requieren al menos 4 comparables de terreno para homologar.');
            return;
        }

        return redirect()->route('form.index', ['section' => 'homologation-lands']);

    }


    public function toHomologationBuilding()
    {
        // 1. Doble validación
        if ($this->buildingCount < 6) {
            Toaster::warning('Se requieren al menos 6 comparables de construcción para homologar.');
            return;
        }

        return redirect()->route('form.index', ['section' => 'homologation-buildings']);
    }



    public function render()
    {
        return view('livewire.forms.market-focus');
    }
}
