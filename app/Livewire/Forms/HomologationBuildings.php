<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Models\Forms\Comparable\ComparableModel;
use App\Models\Forms\Comparable\ValuationBuildingComparableModel;
use Illuminate\Support\Facades\Session;
use App\Models\Valuations\Valuation;
use Flux\Flux;

class HomologationBuildings extends Component
{
    // --- PROPIEDADES INICIALES ---
    public $idValuation;
    public $valuation;
    public $comparables;
    public $comparablesCount = 0;

    // --- PROPIEDADES DEL SUJETO ---
    public string $subject_factor_fsu = '1.0000';
    public string $subject_factor_fic = '1.0000';
    public string $subject_factor_feq = '1.0000';
    public string $subject_factor_fedac = '0.8700';
    public string $subject_factor_floc = '1.0000';
    public string $subject_factor_avanc = '0.9700';
    public string $subject_factor_negociacion_placeholder = '1.0000';

    // Nueva propiedad para controlar qué factor se está editando (o null si ninguno)
    public $editing_factor_sujeto = null;

    // Propiedad para nuevos inputs manuales (después de AVANCE OBRA)
    public $new_factor_name;
    public $new_factor_value;

    // --- PAGINACIÓN Y ESTADO DE COMPARABLES ---
    public $currentPage = 1;
    public $selectedComparableId;
    public $selectedComparable;
    public array $masterFactors = [];
    public array $comparableFactors = [];

    // --- JUSTIFICACIONES ---
    public $justificationSupVendible;

    // --- CONCLUSIONES ---
    public array $selectedForStats = [];
    public string $conclusion_promedio_oferta = '0.00';
    public string $conclusion_valor_unitario_homologado_promedio = '0.00';
    public string $conclusion_factor_promedio = '0.0000';
    public string $conclusion_promedio_factor2_placeholder = '0.0000';
    public string $conclusion_promedio_ajuste_pct_placeholder = '0.00%';
    public string $conclusion_promedio_valor_final_placeholder = '0.00';
    public string $conclusion_media_aritmetica_oferta = '0.00';
    public string $conclusion_media_aritmetica_homologado = '0.00';
    public string $conclusion_desviacion_estandar_oferta = '0.00';
    public string $conclusion_coeficiente_variacion_oferta = '0.00';
    public string $conclusion_coeficiente_variacion_homologado = '0.00';
    public string $conclusion_dispersion_oferta = '0.00';
    public string $conclusion_dispersion_homologado = '0.00';
    public string $conclusion_maximo_oferta = '0.00';
    public string $conclusion_maximo_homologado = '0.00';
    public string $conclusion_minimo_oferta = '0.00';
    public string $conclusion_minimo_homologado = '0.00';
    public string $conclusion_diferencia_oferta = '0.00';
    public string $conclusion_diferencia_homologado = '0.00';
    public string $conclusion_valor_unitario_de_venta = '$0.00';
    public string $conclusion_tipo_redondeo = 'DECENAS';
    public string $conclusion_desviacion_estandar_homologado = '0.00';



    public function mount()
    {
        $this->idValuation = Session::get('valuation_id');
        $this->valuation = Valuation::find($this->idValuation);

        if (!$this->valuation) {
            $this->comparables = collect();
            $this->resetConclusionProperties();
            return;
        }

        $this->comparables = $this->valuation->buildingComparables()->orderByPivot('position')->get();
        $this->comparablesCount = $this->comparables->count();

        if ($this->comparablesCount < 2) {
            $this->resetConclusionProperties();
            return;
        }

        $this->currentPage = 1;

        // Factores para Buildings (Punto 5)
        $this->masterFactors = [
            ['code' => 'FNEG', 'label' => 'FNEG', 'subject_model' => 'subject_factor_negociacion_placeholder', 'type' => 'number_aplicable'],
            ['code' => 'FSU', 'label' => 'FSU', 'subject_model' => 'subject_factor_fsu', 'type' => 'number'],
            ['code' => 'FIC', 'label' => 'FIC', 'subject_model' => 'subject_factor_fic', 'type' => 'number'],
            ['code' => 'FEQ', 'label' => 'FEQ', 'subject_model' => 'subject_factor_feq', 'type' => 'modal_button'],
            ['code' => 'FEDAC', 'label' => 'FEDAC', 'subject_model' => 'subject_factor_fedac', 'type' => 'modal_button'],
            ['code' => 'FLOC', 'label' => 'FLOC', 'subject_model' => 'subject_factor_floc', 'type' => 'modal_button'],
            ['code' => 'AVANC', 'label' => 'AVANC', 'subject_model' => 'subject_factor_avanc', 'type' => 'modal_button'],
        ];

        foreach ($this->comparables as $comparable) {
            $valorHomologadoInicial = $comparable->comparable_unit_value ?? 1.00;
            $factorResultanteInicial = 1.0;

            foreach ($this->masterFactors as $factor) {
                $this->comparableFactors[$comparable->id][$factor['code']]['calificacion'] = '1.0000';
                $aplicable = ($factor['code'] === 'FNEG') ? '0.9000' : '1.0000';
                $this->comparableFactors[$comparable->id][$factor['code']]['aplicable'] = $aplicable;
            }

            // Inicialización de la ficha (Punto 4)
            $this->comparableFactors[$comparable->id]['clase_factor'] = '1.7500';
            $this->comparableFactors[$comparable->id]['conserv_factor'] = '0.0000';
            $this->comparableFactors[$comparable->id]['localiz_factor'] = '1.0000';

            $this->comparableFactors[$comparable->id]['FRE'] = [
                'factor_ajuste' => $factorResultanteInicial,
                'valor_homologado' => $valorHomologadoInicial,
                'valor_unitario_vendible' => '186.54', // Placeholder (Punto 5)
            ];

            // Placeholders
            $this->comparableFactors[$comparable->id]['COL_FACTOR_2_PLACEHOLDER'] = '0.7300';
            $this->comparableFactors[$comparable->id]['COL_AJUSTE_PCT_PLACEHOLDER'] = '51.84%';
            $this->comparableFactors[$comparable->id]['COL_VALOR_FINAL_PLACEHOLDER'] = '9.61';
        }

        $this->selectedForStats = $this->comparables->pluck('id')->toArray();
        $this->gotoPage(1); // Carga el comparable 1 (Punto 6)
        $this->recalculateConclusions();
    }

    // --- HOOKS DE REACTIVIDAD (Punto 7) ---
    public function updatedSelectedForStats()
    {
        $this->recalculateConclusions();
    }

    public function updatedConclusionTipoRedondeo()
    {
        $this->recalculateConclusions();
    }

    // Hook para recalcular factores internos al cambiar cualquier input
    public function updated($property, $value)
    {
        if (str_starts_with($property, 'comparableFactors.')) {
            $this->recalculateComparableFactors($this->selectedComparableId);
        }
    }

    // --- LÓGICA DE NAVEGACIÓN (Punto 6) ---
    public function gotoPage($page)
    {
        if ($page >= 1 && $page <= $this->comparablesCount) {
            $this->currentPage = $page;
            $index = $page - 1;

            $comparable = $this->comparables->get($index);

            if ($comparable) {
                $this->selectedComparable = $comparable;
                $this->selectedComparableId = $comparable->id;
            }

            $this->recalculateConclusions();
        }
    }

    // --- MÉTODOS DE BOTONES ---

    // Toglea el estado de edición del factor del sujeto (Punto 2)
    public function toggleEditFactor(string $code)
    {
        if ($this->editing_factor_sujeto === $code) {
            // Acción de Guardar: Simulación de persistencia
            // if ($code === 'FEQ') { $this->subject_factor_feq = $this->subject_factor_feq; }
            $this->editing_factor_sujeto = null;
        } else {
            // Acción de Editar
            $this->editing_factor_sujeto = $code;
        }
    }

    public function saveNewFactor()
    {
        // Lógica para guardar el nuevo factor (Punto 4)
        session()->flash('success_new_factor', 'Nuevo factor añadido: ' . $this->new_factor_name);
        $this->new_factor_name = null;
        $this->new_factor_value = null;
    }

    public function openEquipmentModal()
    {
        // ...
    }

    public function openComparablesBuilding()
    {
        Session::put('comparables-active-session', true);
        Session::put('comparable-type', 'building');
        return redirect()->route('form.comparables.index');
    }

    // --- CÁLCULOS DE CONCLUSIONES (Punto 7 y 8) ---
    public function recalculateConclusions()
    {
        if (!$this->comparables) {
            $this->resetConclusionProperties();
            return;
        }

        $selectedComparables = $this->comparables->whereIn('id', $this->selectedForStats);

        if ($selectedComparables->isEmpty()) {
            $this->resetConclusionProperties();
            return;
        }

        $valoresOferta = $selectedComparables->pluck('comparable_offers')->map('floatval');
        $valoresHomologados = $selectedComparables->map(
            fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['valor_homologado'] ?? 0)
        );
        $factoresFRE = $selectedComparables->map(
            fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['factor_ajuste'] ?? 0)
        );

        // --- CÁLCULOS ESTADÍSTICOS ---
        $avgOferta = $valoresOferta->avg();
        $stdDevOferta = $this->std_deviation($valoresOferta);
        $avgHomologado = $valoresHomologados->avg();
        $stdDevHomologado = $this->std_deviation($valoresHomologados);

        // Asignación de resultados a propiedades públicas...
        $this->conclusion_promedio_oferta = $this->format_currency($avgOferta, false);
        $this->conclusion_valor_unitario_homologado_promedio = $this->format_currency($avgHomologado, false);
        $this->conclusion_factor_promedio = number_format($factoresFRE->avg(), 4);

        $this->conclusion_media_aritmetica_oferta = $this->format_currency($avgOferta, false);
        $this->conclusion_media_aritmetica_homologado = $this->format_currency($avgHomologado, false);
        $this->conclusion_maximo_oferta = $this->format_currency($valoresOferta->max());
        $this->conclusion_minimo_oferta = $this->format_currency($valoresOferta->min());
        $this->conclusion_diferencia_oferta = $this->format_currency($valoresOferta->max() - $valoresOferta->min());
        $this->conclusion_desviacion_estandar_oferta = number_format($stdDevOferta, 2);
        $this->conclusion_coeficiente_variacion_oferta = ($avgOferta > 0) ? number_format(($stdDevOferta / $avgOferta) * 100, 2) : '0.00';
        $this->conclusion_dispersion_oferta = $this->conclusion_coeficiente_variacion_oferta;

        $this->conclusion_maximo_homologado = $this->format_currency($valoresHomologados->max());
        $this->conclusion_minimo_homologado = $this->format_currency($valoresHomologados->min());
        $this->conclusion_diferencia_homologado = $this->format_currency($valoresHomologados->max() - $valoresHomologados->min());
        $this->conclusion_desviacion_estandar_homologado = number_format($stdDevHomologado, 2);
        $this->conclusion_coeficiente_variacion_homologado = ($avgHomologado > 0) ? number_format(($stdDevHomologado / $avgHomologado) * 100, 2) : '0.00';
        $this->conclusion_dispersion_homologado = $this->conclusion_coeficiente_variacion_homologado;

        $this->conclusion_promedio_factor2_placeholder = '0.7300';
        $this->conclusion_promedio_ajuste_pct_placeholder = '100.00%';
        $this->conclusion_promedio_valor_final_placeholder = '3,583.83';

        // VALOR UNITARIO DE VENTA (Punto 8)
        $valorRedondeado = $this->redondearValor($avgHomologado, $this->conclusion_tipo_redondeo);
        $this->conclusion_valor_unitario_de_venta = $this->format_currency($valorRedondeado, true);

        // Re-renderización de gráficos (Simulación)
        $this->dispatch('updateChart', data: $this->chartData);
    }

    // --- PROPIEDAD COMPUTADA PARA GRÁFICOS ---
    #[Computed]
    public function chartData(): array
    {
        if (!$this->comparables) {
            return $this->getEmptyChartData();
        }

        $selected = $this->comparables->whereIn('id', $this->selectedForStats)->values();
        if ($selected->isEmpty()) {
            return $this->getEmptyChartData();
        }

        // Generar datos mock para que la gráfica cargue
        $labels = $selected->pluck('id')->map(fn($id, $index) => "Comp. " . ($index + 1));
        $factors = $selected->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['factor_ajuste'] ?? 1.0));
        $homologated = $selected->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['valor_homologado'] ?? 0));


        return [
            'labels' => $labels->toArray(),
            'factors' => $factors->toArray(),
            'homologated' => $homologated->toArray(),
            'coeficiente_variacion_oferta' => (float)$this->conclusion_coeficiente_variacion_oferta,
            'coeficiente_variacion_homologado' => (float)$this->conclusion_coeficiente_variacion_homologado,
        ];
    }

    // --- HELPERS (Funciones auxiliares) ---
    private function resetConclusionProperties()
    {
        $this->conclusion_promedio_oferta = '0.00';
        $this->conclusion_valor_unitario_homologado_promedio = '0.00';
        $this->conclusion_factor_promedio = '0.0000';
        $this->conclusion_promedio_factor2_placeholder = '0.0000';
        $this->conclusion_promedio_ajuste_pct_placeholder = '0.00%';
        $this->conclusion_promedio_valor_final_placeholder = '0.00';
        $this->conclusion_media_aritmetica_oferta = '0.00';
        $this->conclusion_media_aritmetica_homologado = '0.00';
        $this->conclusion_desviacion_estandar_oferta = '0.00';
        $this->conclusion_coeficiente_variacion_oferta = '0.00';
        $this->conclusion_dispersion_oferta = '0.00';
        $this->conclusion_maximo_oferta = '0.00';
        $this->conclusion_minimo_oferta = '0.00';
        $this->conclusion_diferencia_oferta = '0.00';
        $this->conclusion_desviacion_estandar_homologado = '0.00';
        $this->conclusion_coeficiente_variacion_homologado = '0.00';
        $this->conclusion_dispersion_homologado = '0.00';
        $this->conclusion_maximo_homologado = '0.00';
        $this->conclusion_minimo_homologado = '0.00';
        $this->conclusion_diferencia_homologado = '0.00';
        $this->conclusion_valor_unitario_de_venta = '$0.00';
    }

    private function getEmptyChartData(): array
    {
        return [
            'labels' => [],
            'factors' => [],
            'homologated' => [],
            'coeficiente_variacion_oferta' => 0.0,
            'coeficiente_variacion_homologado' => 0.0,
        ];
    }

    private function std_deviation(Collection $values): float
    {
        $count = $values->count();
        if ($count < 2) return 0.0;
        $mean = $values->avg() ?? 0;
        $sumOfSquares = $values->map(fn($v) => pow(($v ?? 0) - $mean, 2))->sum();
        return sqrt($sumOfSquares / ($count - 1));
    }

    private function format_currency($value, $showSymbol = true): string
    {
        $symbol = $showSymbol ? '$' : '';
        return $symbol . number_format($value ?? 0, 2, '.', ',');
    }

    private function redondearValor($valor, $tipo)
    {
        $valor = $valor ?? 0;
        return match ($tipo) {
            'DECENAS' => round($valor, -1),
            'CENTENAS' => round($valor, -2),
            'MILLARES' => round($valor, -3),
            default => round($valor, 0),
        };
    }

    public function render()
    {
        return view('livewire.forms.homologation-buildings');
    }
}
