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
use App\Models\Forms\Homologation\HomologationLandAttributeModel;
use App\Models\Forms\Homologation\HomologationBuildingAttributeModel;
use App\Models\Forms\MarketFocus\MarketFocusModel;
use App\Models\Forms\LandDetails\LandDetailsModel;
use App\Traits\ValuationLockTrait;


class MarketFocus extends Component
{
    use ValuationLockTrait;

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



    // --- NUEVAS PROPIEDADES PARA EXCEDENTES ---
    public $surplusPercentage = 100; // Valor por defecto
    public $showExcessSection = false; // Controla si mostramos la sección

    // Valores calculados
    public $valLotePrivativo = 0.00;
    public $valLoteTipo = 0.00;
    public $valDiferenciaExcedente = 0.00;
    public $valTerrenoExcedente = 0.00; // El valor final tras aplicar porcentaje

    // Opciones del Select (Fixed Array)
    public $percentageOptions = [0, 10, 20, 30, 40, 50, 75, 100, 105, 110, 115, 120, 125];


    public $landExpiredCount = 0;
    public $buildingExpiredCount = 0;

    /**
     * Se ejecuta al cargar el componente.
     */
    public function mount()
    {
        // Obtenemos el ID del avalúo activo desde la sesión
        $this->valuationId = Session::get('valuation_id');

        $valuation = Valuation::find($this->valuationId);

        if (!$valuation) return;

        $this->checkReadOnlyStatus($valuation);



        //Obtenemos el valor de superficie construida
        $this->applicableSurface = ApplicableSurfaceModel::where('valuation_id', session('valuation_id'))->first();

        if(!$this->applicableSurface) $this->saleableBuiltArea = 0;
        else $this->saleableBuiltArea = $this->applicableSurface->built_area;






        // Cargamos todos los datos iniciales
        $this->loadData();
    }




    public function updatedSurplusPercentage($value)
    {
        // Guardar o Actualizar en BD
        MarketFocusModel::updateOrCreate(
            ['valuation_id' => $this->valuationId],
            ['surplus_percentage' => $value]
        );

        // Notificación Toast
        Toaster::success("Porcentaje de excedente actualizado al {$value}%");

        // Recalcular montos
        $this->calculateTotals();
    }





    /**
     * Función principal para cargar y refrescar todos los datos.
     */
    public function loadData()
    {
        if (!$this->valuationId) {
            $this->resetValues();
            return;
        }

        // 1. Conteos
        $this->landCount = ValuationLandComparableModel::where('valuation_id', $this->valuationId)->count();
        $this->buildingCount = ValuationBuildingComparableModel::where('valuation_id', $this->valuationId)->count();


        // Usamos whereHas para "asomarnos" a la tabla comparables y revisar el accessor indirectly
        // Nota: is_expired en tu modelo depende de la fecha, así que filtramos por la lógica de 6 meses
        $sixMonthsAgo = now()->subMonths(6);

        $this->landExpiredCount = ValuationLandComparableModel::where('valuation_id', $this->valuationId)
            ->whereHas('comparable', function ($query) use ($sixMonthsAgo) {
                $query->where('created_at', '<', $sixMonthsAgo);
            })->count();

        $this->buildingExpiredCount = ValuationBuildingComparableModel::where('valuation_id', $this->valuationId)
            ->whereHas('comparable', function ($query) use ($sixMonthsAgo) {
                $query->where('created_at', '<', $sixMonthsAgo);
            })->count();

        // 2. Obtener Atributos de TERRENO (HomologationLandAttributeModel)
        // Aquí viene el "Valor Probable" (unit_value_mode_lot) y la "Superficie Seleccionada" (subject_surface_value)
        $landAttributes = HomologationLandAttributeModel::where('valuation_id', $this->valuationId)->first();

        if ($landAttributes) {
            $this->landAvgUnitValue = $landAttributes->average_arithmetic ?? 0;
            $this->landHomologatedValue = $landAttributes->average_homologated ?? 0;
            $this->landProbableValue = $landAttributes->unit_value_mode_lot ?? 0;

            // SUPERFICIE SELECCIONADA EN EL INPUT (La que guardamos en el select)
            $this->terrainSurface = $landAttributes->subject_surface_value ?? 0;
        } else {
            $this->landAvgUnitValue = 0;
            $this->landHomologatedValue = 0;
            $this->landProbableValue = 0;
            $this->terrainSurface = 0;
        }

        // 1. CARGAR CONFIGURACIÓN DE PORCENTAJE (Tabla market_focus)
        $marketFocus = MarketFocusModel::where('valuation_id', $this->valuationId)->first();

        if ($marketFocus) {
            $this->surplusPercentage = (float)$marketFocus->surplus_percentage;
        } else {
            // Si no existe, dejamos el 100 por defecto (pero no guardamos aún para no llenar basura)
            $this->surplusPercentage = 100;
        }

        // 3. Obtener Atributos de CONSTRUCCIÓN
        $buildingAttributes = HomologationBuildingAttributeModel::where('valuation_id', $this->valuationId)->first();

        if ($buildingAttributes) {
            $this->buildingAvgUnitValue = $buildingAttributes->average_arithmetic ?? 0;
            $this->buildingHomologatedValue = $buildingAttributes->average_homologated ?? 0;
            $this->buildingProbableValue = $buildingAttributes->unit_value_mode_lot ?? 0;
        } else {
            // ... ceros ...
        }

        // 4. Calcular Totales
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        // ==========================================
        // === TABLA 2: VALOR DEL TERRENO ===
        // ==========================================

        // 1. Valor Unitario del Mercado = El resultado de la homologación de tierras
        $this->marketUnitValue = $this->landProbableValue;

        // 2. Importe Total del Terreno = Superficie Seleccionada * Valor Mercado
        $this->totalTerrainAmount = $this->terrainSurface * $this->marketUnitValue;

        // 3. Indiviso (Hardcodeado a 100% por ahora)
        $this->applicableUndividedPercent = 100;

        // 4. Valor del Terreno Propiedad
        $this->terrainValue = $this->totalTerrainAmount;


        // ==========================================
        // === CÁLCULO DE EXCEDENTES (SWITCH MAESTRO) ===
        // ==========================================

        // A. Consultar el "Switch" desde LandDetails para ver si el usuario activó el cálculo
        $landDetail = LandDetailsModel::where('valuation_id', $this->valuationId)->first();
        $useExcessCalculation = $landDetail ? (bool)$landDetail->use_excess_calculation : false;

        // B. Condición:
        // 1. El usuario activó el checkbox en LandDetails ($useExcessCalculation)
        // 2. Existe superficie privativa capturada en ApplicableSurface (> 0)
        if ($useExcessCalculation && $this->applicableSurface && $this->applicableSurface->private_lot > 0) {

            $this->showExcessSection = true;

            $privateLot = (float)$this->applicableSurface->private_lot; // Superficie real
            $privateLotType = (float)$this->applicableSurface->private_lot_type; // Superficie tipo

            // C.1 Valor Lote Privativo (Sup. Privativa * Valor Mercado)
            $this->valLotePrivativo = $privateLot * $this->marketUnitValue;

            // C.2 Valor Lote Tipo (Sup. Tipo * Valor Mercado)
            $this->valLoteTipo = $privateLotType * $this->marketUnitValue;

            // C.3 Diferencia (Privativo - Tipo)
            $this->valDiferenciaExcedente = $this->valLotePrivativo - $this->valLoteTipo;

            // C.4 Valor Terreno Excedente (Diferencia * % Seleccionado)
            $factor = $this->surplusPercentage / 100;
            $this->valTerrenoExcedente = $this->valDiferenciaExcedente * $factor;
        } else {
            // Si el checkbox está desmarcado O no hay datos, ocultamos y reseteamos a cero
            $this->showExcessSection = false;
            $this->valTerrenoExcedente = 0.00;

            // Opcional: Resetear variables visuales para limpieza
            $this->valLotePrivativo = 0.00;
            $this->valLoteTipo = 0.00;
            $this->valDiferenciaExcedente = 0.00;
        }


        // ==========================================
        // === TABLA 3: VALOR CONSTRUCCIONES ===
        // ==========================================
        $this->constructionMarketUnitValue = $this->buildingProbableValue;

        // 1. Cálculo base de construcción (Sup. Vendible * Valor Unitario)
        $baseConstructionValue = $this->saleableBuiltArea * $this->constructionMarketUnitValue;

        // 2. SUMAMOS EL EXCEDENTE AL FINAL
        // (Si el switch estaba apagado, valTerrenoExcedente será 0, así que no afecta)
        $this->marketValue = $baseConstructionValue + $this->valTerrenoExcedente;
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
