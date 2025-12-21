<?php

namespace App\Livewire\Forms;

use App\Models\Forms\Building\BuildingModel;
use App\Models\Forms\SpecialInstallation\SpecialInstallationModel;
use App\Models\Forms\ApplicableSurface\ApplicableSurfaceModel; // Nuevo
use App\Models\Forms\Homologation\HomologationLandAttributeModel; // Nuevo
use App\Models\Valuations\Valuation;
use Livewire\Component;

class CostApproach extends Component
{
    public $valuation;
    public $building;

    // --- VARIABLES DEL TERRENO ---
    public $landSurface = 0.0;
    public $landIndiviso = 0.0;
    public $landUnitValue = 0.0; // VUT
    public $landFractionValue = 0.0;
    public $landProportionalValue = 0.0;
    public $totalLandValue = 0.0; // El valor final a usar en el resumen

    // --- COLECCIONES CONSTRUCCIONES ---
    public $privateConstructions = [];
    public $commonConstructions = [];

    // --- COLECCIONES INSTALACIONES ESPECIALES ---
    public $privateSpecialInstallations = [];
    public $commonSpecialInstallations = [];

    // --- TOTALES CONSTRUCCIONES ---
    public $totalSurfacePrivate = 0.0;
    public $totalValuePrivate = 0.0;

    public $totalSurfaceCommon = 0.0;
    public $totalValueCommon = 0.0;

    // --- TOTALES INSTALACIONES ESPECIALES ---
    public $totalValueInstPrivate = 0.0;
    public $totalValueInstCommonPhysical = 0.0;
    public $totalValueInstCommonProportional = 0.0;

    // Configuración para cálculos de vida útil
    protected $lifeValuesConfig;

    public function mount()
    {
        // 1. Cargar Valuación y Modelo de Construcción
        $this->valuation = Valuation::find(session('valuation_id'));
        $this->building = BuildingModel::where('valuation_id', $this->valuation->id)->first();

        // 2. Cargar configuraciones necesarias
        $this->lifeValuesConfig = config('properties_inputs.construction_life_values', []);

        // -----------------------------------------------------------------
        // A. PROCESAMIENTO DEL TERRENO
        // -----------------------------------------------------------------
        $surfaceModel = ApplicableSurfaceModel::where('valuation_id', $this->valuation->id)->first();
        $homologationModel = HomologationLandAttributeModel::where('valuation_id', $this->valuation->id)->first();

        // Asignación de valores base (con fallback a 0)
        $this->landSurface = $surfaceModel->surface_area ?? 0.0;
        $this->landIndiviso = $surfaceModel->applicable_undivided ?? 0.0;
        $this->landUnitValue = $homologationModel->unit_value_mode_lot ?? 0.0;

        // Cálculos del Terreno
        // 1. Valor de la Fracción = Superficie * VUT
        $this->landFractionValue = $this->landSurface * $this->landUnitValue;

        // 2. Valor Proporcional = Valor Fracción * (Indiviso / 100)
        $indivisoDecimal = ($this->landIndiviso > 0) ? ($this->landIndiviso / 100) : 0;
        $this->landProportionalValue = $this->landFractionValue * $indivisoDecimal;

        // 3. Determinar Valor Total del Terreno para el Resumen
        // Si es condominio, tomamos el Proporcional. Si no, tomamos el valor de la Fracción (o Proporcional si indiviso es 100)
        // Generalmente en Cost Approach, si es condominio se suma el valor proporcional del terreno.
        if (stripos($this->valuation->property_type, 'condominio') !== false) {
            $this->totalLandValue = $this->landProportionalValue;
        } else {
            // Si no es condominio, asumimos que es el valor total de la fracción (o indiviso 100%)
            $this->totalLandValue = $this->landFractionValue;
        }


        // -----------------------------------------------------------------
        // B. PROCESAMIENTO DE CONSTRUCCIONES
        // -----------------------------------------------------------------
        if ($this->building) {
            $rawPrivates = $this->building->privates()->get();
            $this->privateConstructions = $this->calculateConstructionValues($rawPrivates);

            $this->totalSurfacePrivate = collect($this->privateConstructions)->sum('surface');
            $this->totalValuePrivate = collect($this->privateConstructions)->sum('total_value');

            // Construcciones Comunes (Solo si es condominio)
            if (stripos($this->valuation->property_type, 'condominio') !== false) {
                $rawCommons = $this->building->commons()->get();
                $this->commonConstructions = $this->calculateConstructionValues($rawCommons);

                $this->totalSurfaceCommon = collect($this->commonConstructions)->sum('surface');
                $this->totalValueCommon = collect($this->commonConstructions)->sum('total_value');
            }
        }

        // -----------------------------------------------------------------
        // C. PROCESAMIENTO DE INSTALACIONES ESPECIALES
        // -----------------------------------------------------------------
        $allSpecialItems = SpecialInstallationModel::where('valuation_id', $this->valuation->id)
            ->orderBy('key')
            ->get();

        // C.1 Filtrar Privativas
        $this->privateSpecialInstallations = $allSpecialItems->where('classification_type', 'private')->values();
        $this->totalValueInstPrivate = collect($this->privateSpecialInstallations)->sum('amount');

        // C.2 Filtrar Comunes (Solo si es condominio)
        if (stripos($this->valuation->property_type, 'condominio') !== false) {
            $this->commonSpecialInstallations = $allSpecialItems->where('classification_type', 'common')->values();

            foreach ($this->commonSpecialInstallations as $item) {
                // Total Físico
                $this->totalValueInstCommonPhysical += $item->amount;

                // Valor Proporcional
                $indivisoDecimal = ($item->undivided ?? 0) / 100;
                $proportionalValue = $item->amount * $indivisoDecimal;

                $item->calculated_proportional_value = $proportionalValue;
                $this->totalValueInstCommonProportional += $proportionalValue;
            }
        }
    }

    /**
     * Función para cálculos de Ross-Heidecke en Construcciones
     */
    private function calculateConstructionValues($constructions)
    {
        return $constructions->map(function ($item) {
            $claveCombinacion = $item->clasification . '_' . $item->use;
            $vidaUtilTotal = $this->lifeValuesConfig[$claveCombinacion] ?? 0;
            $edad = $item->age;
            $vidaUtilRemanente = $vidaUtilTotal > 0 ? max($vidaUtilTotal - $edad, 0) : 0;

            $factorEdad = 0.0;
            if ($vidaUtilTotal > 0) {
                $factorEdad = (0.100 * $vidaUtilTotal + 0.900 * ($vidaUtilTotal - $edad)) / $vidaUtilTotal;
            }

            $factorConservacion = match ($item->conservation_state) {
                '0. Ruidoso' => 0.0,
                '0.8 Malo' => 0.8,
                '1. Normal', '1. Bueno', '1. Nuevo' => 1.0,
                '1.1 Muy bueno', '1.1 Recientemente remodelado' => 1.1,
                default => 1.0,
            };

            $factorResultante = $factorEdad * $factorConservacion * ($item->progress_work / 100);
            $factorResultante = max($factorResultante, 0.600);

            $costoUnitarioNeto = $item->unit_cost_replacement * $factorResultante;
            $valorTotal = $item->surface * $costoUnitarioNeto;

            $item->calculated_life_total = $vidaUtilTotal;
            $item->calculated_life_remaining = $vidaUtilRemanente;
            $item->calculated_factor_age = $factorEdad;
            $item->calculated_factor_conservation = $factorConservacion;
            $item->calculated_factor_result = $factorResultante;
            $item->calculated_net_cost = $costoUnitarioNeto;
            $item->total_value = $valorTotal;

            return $item;
        });
    }



    public function nextComponent()
    {
        /* Toaster::success('Formulario guardado con éxito'); */
        return redirect()->route('form.index', ['section' => 'photo-report']);
    }



    public function render()
    {
        return view('livewire.forms.cost-approach');
    }
}
