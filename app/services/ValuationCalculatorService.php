<?php

namespace App\Services;

use App\Models\Valuations\Valuation;
use App\Models\Forms\ApplicableSurface\ApplicableSurfaceModel;
use App\Models\Forms\Homologation\HomologationLandAttributeModel;
use App\Models\Forms\Homologation\HomologationBuildingAttributeModel;
use App\Models\Forms\MarketFocus\MarketFocusModel;
use App\Models\Forms\LandDetails\LandDetailsModel;
use App\Models\Forms\Building\BuildingModel;
use App\Models\Forms\SpecialInstallation\SpecialInstallationModel;

class ValuationCalculatorService
{
    protected $lifeValuesConfig;

    public function __construct()
    {
        // Cargamos la config aquí para tenerla disponible en toda la clase
        $this->lifeValuesConfig = config('properties_inputs.construction_life_values', []);
    }

    /**
     * Calcula todos los valores base del avalúo.
     */
    public function calculateValues($valuationId)
    {
        $valuation = Valuation::find($valuationId);
        if (!$valuation) return null;

        // --- 1. VALOR DEL TERRENO ---
        $surfaceModel = ApplicableSurfaceModel::where('valuation_id', $valuationId)->first();
        $homologationLandModel = HomologationLandAttributeModel::where('valuation_id', $valuationId)->first();

        $landValue = 0;
        $landSurface = $surfaceModel->surface_area ?? 0.0;
        $landUnitValue = $homologationLandModel->unit_value_mode_lot ?? 0.0;

        // Datos extra para el front (si los necesitas mostrar)
        $surfaceLand = $landSurface;
        $unitLand = $landUnitValue;

        if ($surfaceModel) {
            $landFractionValue = $landSurface * $landUnitValue;
            $isCondo = stripos($valuation->property_type, 'condominio') !== false;

            if ($isCondo) {
                $indivisoDecimal = ($surfaceModel->applicable_undivided ?? 0) > 0
                    ? ($surfaceModel->applicable_undivided / 100)
                    : 0;
                $landValue = $landFractionValue * $indivisoDecimal;
            } else {
                $landValue = $landFractionValue;
            }
        }

        // --- 2. VALOR DE MERCADO ---
        $homologationBuildModel = HomologationBuildingAttributeModel::where('valuation_id', $valuationId)->first();
        $marketFocusModel = MarketFocusModel::where('valuation_id', $valuationId)->first();
        $landDetailsModel = LandDetailsModel::where('valuation_id', $valuationId)->first();

        $saleableBuiltArea = $surfaceModel->built_area ?? 0.0;
        $constructionUnitValue = $homologationBuildModel->unit_value_mode_lot ?? 0.0;

        // Datos extra
        $surfaceConst = $saleableBuiltArea;
        $unitMarket = $constructionUnitValue;

        $baseConstructionValue = $saleableBuiltArea * $constructionUnitValue;

        // Excedentes
        $valTerrenoExcedente = 0.0;
        $useExcess = $landDetailsModel ? (bool)$landDetailsModel->use_excess_calculation : false;

        if ($useExcess && $surfaceModel && $surfaceModel->private_lot > 0) {
            $privateLot = (float)$surfaceModel->private_lot;
            $privateLotType = (float)$surfaceModel->private_lot_type;
            $diferencia = ($privateLot * $landUnitValue) - ($privateLotType * $landUnitValue);
            $surplusPct = $marketFocusModel ? (float)$marketFocusModel->surplus_percentage : 100;
            $valTerrenoExcedente = $diferencia * ($surplusPct / 100);
        }

        $marketValue = $baseConstructionValue + $valTerrenoExcedente;

        // --- 3. VALOR HIPOTÉTICO ---
        $buildingModel = BuildingModel::where('valuation_id', $valuationId)->first();
        $progress = $buildingModel ? ($buildingModel->progress_general_works ?? 0) : 0;

        $hypotheticalValue = $marketValue * ($progress / 100);
        $unitHypothetical = $surfaceConst > 0 ? ($hypotheticalValue / $surfaceConst) : 0;

        // --- 4. VALOR FÍSICO (Ross-Heidecke) ---
        $totalConstructionsValue = 0;

        if ($buildingModel) {
            // Privativas
            $rawPrivates = $buildingModel->privates()->get();
            $totalConstructionsValue += $this->calculateNetConstruction($rawPrivates);

            // Comunes (Condominio)
            if (stripos($valuation->property_type, 'condominio') !== false) {
                $rawCommons = $buildingModel->commons()->get();
                $totalConstructionsValue += $this->calculateNetConstruction($rawCommons);
            }
        }

        // Instalaciones
        $totalInstallationsValue = 0;
        $allSpecialItems = SpecialInstallationModel::where('valuation_id', $valuationId)->get();

        $totalInstallationsValue += $allSpecialItems->where('classification_type', 'private')->sum('amount');

        if (stripos($valuation->property_type, 'condominio') !== false) {
            $commInst = $allSpecialItems->where('classification_type', 'common');
            foreach ($commInst as $item) {
                $indivisoDecimal = ($item->undivided ?? 0) / 100;
                $totalInstallationsValue += ($item->amount * $indivisoDecimal);
            }
        }

        $physicalValue = $landValue + $totalConstructionsValue + $totalInstallationsValue;
        $unitPhysical = $surfaceConst > 0 ? ($physicalValue / $surfaceConst) : 0;

        // Retornamos un array con TODO lo necesario
        return [
            'landValue' => round($landValue, 2),
            'surfaceLand' => $surfaceLand,
            'unitLand' => $unitLand,

            'marketValue' => round($marketValue, 2),
            'surfaceConst' => $surfaceConst,
            'unitMarket' => $unitMarket,

            'hypotheticalValue' => round($hypotheticalValue, 2),
            'unitHypothetical' => $unitHypothetical,

            'physicalValue' => round($physicalValue, 2),
            'unitPhysical' => $unitPhysical,
        ];
    }

    /**
     * Lógica privada de Ross-Heidecke (Movida desde el Livewire)
     */
    private function calculateNetConstruction($items)
    {
        $totalGroup = 0;

        foreach ($items as $item) {
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
            $factorResultante = max($factorResultante, 0.600);

            // Costo Neto
            $costoUnitarioNeto = $item->unit_cost_replacement * $factorResultante;
            $valorTotal = $item->surface * $costoUnitarioNeto;

            $totalGroup += $valorTotal;
        }

        return $totalGroup;
    }
}
