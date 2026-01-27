<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Session;
use App\Models\Valuations\Valuation;
use App\Models\Forms\Conclusions\ConclusionModel;

// --- MODELOS DE DATOS ---
use App\Models\Forms\ApplicableSurface\ApplicableSurfaceModel;
use App\Models\Forms\Homologation\HomologationLandAttributeModel;
use App\Models\Forms\Homologation\HomologationBuildingAttributeModel;
use App\Models\Forms\MarketFocus\MarketFocusModel;
use App\Models\Forms\LandDetails\LandDetailsModel;
use App\Models\Forms\Building\BuildingModel;
use App\Models\Forms\SpecialInstallation\SpecialInstallationModel;

class Conclusion extends Component
{
    public $valuationId;

    // --- VARIABLES PÚBLICAS (TOTALES) ---
    public $landValue = 0;
    public $marketValue = 0;
    public $hypotheticalValue = 0;
    public $physicalValue = 0; // <--- AQUÍ CAERÁ EL TOTAL DE COSTOS
    public $otherValueAmount = 0;

    // --- VARIABLES VISUALES Y DE SUPERFICIE ---
    public $surfaceLand = 0;
    public $surfaceConst = 0;
    public $unitLand = 0;
    public $unitMarket = 0;
    public $unitHypothetical = 0;
    public $unitPhysical = 0;

    // --- CONFIGURACIÓN DE FORMULARIO ---
    public string $selectedValueType = 'physical';
    public string $rounding = 'Sin redondeo';
    public $concludedValue = '';
    public $difference = 0;
    public $range = '';

    // Configuración para Ross-Heidecke (Cargada igual que en CostApproach)
    protected $lifeValuesConfig;

    public function mount()
    {
        $this->valuationId = Session::get('valuation_id');
        $valuation = Valuation::find($this->valuationId);

        if (!$valuation) return;

        // Cargar config de vida útil
        $this->lifeValuesConfig = config('properties_inputs.construction_life_values', []);

        // =========================================================
        // 1. VALOR DEL TERRENO (Lógica CostApproach)
        // =========================================================
        $surfaceModel = ApplicableSurfaceModel::where('valuation_id', $this->valuationId)->first();
        $homologationLandModel = HomologationLandAttributeModel::where('valuation_id', $this->valuationId)->first();

        $landSurface = $surfaceModel->surface_area ?? 0.0;
        $landIndiviso = $surfaceModel->applicable_undivided ?? 0.0;
        $landUnitValue = $homologationLandModel->unit_value_mode_lot ?? 0.0;

        // Asignar a variables visuales
        $this->surfaceLand = $landSurface;
        $this->unitLand = $landUnitValue;

        $landFractionValue = $landSurface * $landUnitValue;
        $isCondo = stripos($valuation->property_type, 'condominio') !== false;

        if ($isCondo) {
            $indivisoDecimal = ($landIndiviso > 0) ? ($landIndiviso / 100) : 0;
            $calculatedLandValue = $landFractionValue * $indivisoDecimal;
        } else {
            $calculatedLandValue = $landFractionValue;
        }

        $this->landValue = round($calculatedLandValue, 2);


        // =========================================================
        // 2. VALOR DE MERCADO (Lógica MarketFocus)
        // =========================================================
        $homologationBuildModel = HomologationBuildingAttributeModel::where('valuation_id', $this->valuationId)->first();
        $marketFocusModel = MarketFocusModel::where('valuation_id', $this->valuationId)->first();
        $landDetailsModel = LandDetailsModel::where('valuation_id', $this->valuationId)->first();

        $saleableBuiltArea = $surfaceModel->built_area ?? 0.0;
        $constructionUnitValue = $homologationBuildModel->unit_value_mode_lot ?? 0.0;

        $this->surfaceConst = $saleableBuiltArea;
        $this->unitMarket = $constructionUnitValue;

        $baseConstructionValue = $saleableBuiltArea * $constructionUnitValue;

        // Excedentes
        $valTerrenoExcedente = 0.0;
        $useExcess = $landDetailsModel ? (bool)$landDetailsModel->use_excess_calculation : false;

        if ($useExcess && $surfaceModel && $surfaceModel->private_lot > 0) {
            $privateLot = (float)$surfaceModel->private_lot;
            $privateLotType = (float)$surfaceModel->private_lot_type;
            // Usamos unitario de tierra para excedente
            $diferencia = ($privateLot * $landUnitValue) - ($privateLotType * $landUnitValue);
            $surplusPct = $marketFocusModel ? (float)$marketFocusModel->surplus_percentage : 100;
            $valTerrenoExcedente = $diferencia * ($surplusPct / 100);
        }

        $this->marketValue = round($baseConstructionValue + $valTerrenoExcedente, 2);


        // =========================================================
        // 3. COMPARATIVO HIPOTÉTICO (Avance de Obra)
        // =========================================================
        $buildingModel = BuildingModel::where('valuation_id', $this->valuationId)->first();
        $progress = $buildingModel ? ($buildingModel->progress_general_works ?? 0) : 0;

        $this->hypotheticalValue = round($this->marketValue * ($progress / 100), 2);
        $this->unitHypothetical = $this->surfaceConst > 0 ? ($this->hypotheticalValue / $this->surfaceConst) : 0;


        // =========================================================
        // 4. VALOR FÍSICO / ENFOQUE DE COSTOS (Recálculo Total)
        // =========================================================
        // Fórmula: Terreno + Construcciones (Neto) + Instalaciones (Neto)

        $totalConstructionsValue = 0;
        $totalInstallationsValue = 0;

        // A. CONSTRUCCIONES (Ross-Heidecke)
        if ($buildingModel) {
            // Privativas
            $rawPrivates = $buildingModel->privates()->get();
            $processedPrivates = $this->calculateConstructionValues($rawPrivates);
            $totalConstructionsValue += $processedPrivates->sum('total_value');

            // Comunes (Solo si es condominio)
            if ($isCondo) {
                $rawCommons = $buildingModel->commons()->get();
                $processedCommons = $this->calculateConstructionValues($rawCommons);
                $totalConstructionsValue += $processedCommons->sum('total_value');
            }
        }

        // B. INSTALACIONES ESPECIALES
        $allSpecialItems = SpecialInstallationModel::where('valuation_id', $this->valuationId)->get();

        // Privativas
        $privInst = $allSpecialItems->where('classification_type', 'private');
        $totalInstallationsValue += $privInst->sum('amount'); // 'amount' ya trae el neto guardado en CostApproach

        // Comunes (Solo si es condominio)
        if ($isCondo) {
            $commInst = $allSpecialItems->where('classification_type', 'common');
            foreach ($commInst as $item) {
                // Aplicamos indiviso a cada partida común
                $indivisoDecimal = ($item->undivided ?? 0) / 100;
                $totalInstallationsValue += ($item->amount * $indivisoDecimal);
            }
        }

        // C. SUMA FINAL FÍSICO
        $calculatedPhysical = $calculatedLandValue + $totalConstructionsValue + $totalInstallationsValue;

        $this->physicalValue = round($calculatedPhysical, 2);
        $this->unitPhysical = $this->surfaceConst > 0 ? ($this->physicalValue / $this->surfaceConst) : 0;


        // =========================================================
        // 5. CARGA DE DATOS GUARDADOS (Si existen)
        // =========================================================
        $conclusion = ConclusionModel::where('valuation_id', $this->valuationId)->first();

        if ($conclusion) {
            $this->otherValueAmount = $conclusion->other_value;
            $this->selectedValueType = $conclusion->selected_value_type;
            $this->rounding = $conclusion->rounding;
            $this->concludedValue = $conclusion->concluded_value;
        } else {
            // Defaults iniciales
            $this->selectedValueType = 'physical';
            $this->rounding = 'Sin redondeo';
        }

        $this->refreshMetrics();
    }

    /**
     * Lógica de Ross-Heidecke replicada de CostApproach para recalcular valores netos
     */
    private function calculateConstructionValues($constructions)
    {
        return $constructions->map(function ($item) {
            $claveCombinacion = $item->clasification . '_' . $item->use;
            $vidaUtilTotal = $this->lifeValuesConfig[$claveCombinacion] ?? 0;
            $edad = $item->age;

            // Factor Edad
            $factorEdad = 0.0;
            if ($vidaUtilTotal > 0) {
                $factorEdad = (0.100 * $vidaUtilTotal + 0.900 * ($vidaUtilTotal - $edad)) / $vidaUtilTotal;
            }

            // Factor Conservación
            $factorConservacion = match ($item->conservation_state) {
                '0. Ruinoso' => 0.0,
                '0.8 Malo' => 0.8,
                '1. Normal', '1. Bueno', '1. Nuevo' => 1.0,
                '1.1 Muy bueno', '1.1 Recientemente remodelado' => 1.1,
                default => 1.0,
            };

            // Factor Resultante
            $factorResultante = $factorEdad * $factorConservacion * ($item->progress_work / 100);
            $factorResultante = max($factorResultante, 0.600); // Mínimo 0.600 según tu lógica original

            // Costo Neto y Total
            $costoUnitarioNeto = $item->unit_cost_replacement * $factorResultante;
            $valorTotal = $item->surface * $costoUnitarioNeto;

            // Inyectamos el valor total calculado al objeto
            $item->total_value = $valorTotal;

            return $item;
        });
    }

    public function refreshMetrics()
    {
        $diff = (float)$this->physicalValue - (float)$this->marketValue;
        $this->difference = number_format($diff, 2);

        $avg = ((float)$this->physicalValue + (float)$this->marketValue) / 2;

        if ($avg != 0) {
            $rangePct = ($diff / $avg) * 100;
            $this->range = number_format(abs($rangePct), 2) . ' %';
        } else {
            $this->range = '0.00 %';
        }

        $this->calculateConcludedValue();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedValueType', 'rounding', 'otherValueAmount'])) {
            $this->calculateConcludedValue();
        }
    }

    public function calculateConcludedValue()
    {
        $baseValue = 0;
        $getValue = fn($val) => (float) str_replace(',', '', (string)$val);

        switch ($this->selectedValueType) {
            case 'land':
                $baseValue = $getValue($this->landValue);
                break;
            case 'market':
                $baseValue = $getValue($this->marketValue);
                break;
            case 'hypothetical':
                $baseValue = $getValue($this->hypotheticalValue);
                break;
            case 'physical':
                $baseValue = $getValue($this->physicalValue);
                break;
            case 'other':
                $baseValue = $getValue($this->otherValueAmount);
                break;
        }

        if ($this->rounding === 'Personalizado') return;

        switch ($this->rounding) {
            case 'A decimales':
                $this->concludedValue = number_format(round($baseValue, 2), 2, '.', '');
                break;
            case 'A decenas':
                $this->concludedValue = number_format(round($baseValue / 10) * 10, 2, '.', '');
                break;
            case 'A centenas':
                $this->concludedValue = number_format(round($baseValue / 100) * 100, 2, '.', '');
                break;
            case 'A miles':
                $this->concludedValue = number_format(round($baseValue / 1000) * 1000, 2, '.', '');
                break;
            default:
                $this->concludedValue = number_format($baseValue, 2, '.', '');
                break;
        }
    }

    public function save()
    {
        $cleanValue = fn($val) => (float) str_replace(',', '', (string)$val);

        ConclusionModel::updateOrCreate(
            ['valuation_id' => $this->valuationId],
            [
                'land_value' => $cleanValue($this->landValue),
                'market_value' => $cleanValue($this->marketValue),
                'hypothetical_value' => $cleanValue($this->hypotheticalValue),
                'physical_value' => $cleanValue($this->physicalValue),
                'other_value' => $cleanValue($this->otherValueAmount),
                'selected_value_type' => $this->selectedValueType,
                'difference' => $cleanValue($this->difference),
                'range' => $this->range,
                'rounding' => $this->rounding,
                'concluded_value' => $cleanValue($this->concludedValue),
            ]
        );

        Toaster::success('Conclusión guardada con éxito');
        return redirect()->route('form.index', ['section' => 'finish-capture']);
    }

    public function render()
    {
        return view('livewire.forms.conclusion');
    }
}
