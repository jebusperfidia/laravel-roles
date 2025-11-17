<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Models\Forms\Comparable\ComparableModel;
use App\Models\Forms\Comparable\ValuationLandComparableModel;
use Illuminate\Support\Facades\Session;
use App\Models\Valuations\Valuation;
use Flux\Flux;

class HomologationLands extends Component
{
    public $idValuation;
    public $valuation;
    public $comparables;
    public $comparablesCount;

    // --- SUJETO ---
    public $subject_surface_type = 'total';
    public $subject_cus = '1.00 vsp';
    public $subject_cos = '50.00 %';
    public $subject_lote_moda = '100.00';
    public $subject_factor_zona = '1.0000';
    public $subject_factor_ubicacion = '1.0000';
    public $subject_factor_forma = '1.0000';
    public $subject_factor_topografia_valor = '1.0000';
    public $subject_factor_topografia_desc = 'F. Topografia';
    public $subject_factor_topografia_siglas = 'FTOP';
    public $subject_factor_superficie = '1.0000';
    public $subject_factor_uso_suelo = '0.0000';

    // --- PAGINACIÓN Y ESTADO DE COMPARABLES ---
    public $currentPage = 1;
    public $selectedComparableId;
    public $selectedComparable;
    public array $masterFactors = [];
    public array $comparableFactors = [];

    // --- JUSTIFICACIONES ---
    /* public $justificationZone, $justificactionLandUse, $justificationNegotiation, $justificationResulting; */

    // --- CONCLUSIONES (Parte 4) ---
    public array $selectedForStats = [];

    // Propiedades para la tabla 1 (Promedio)
    public string $conclusion_promedio_oferta = '0.00';
    public string $conclusion_valor_unitario_homologado_promedio = '0.00';
    public string $conclusion_factor_promedio = '0.0000';
    public string $conclusion_promedio_factor2_placeholder = '0.0000';
    public string $conclusion_promedio_ajuste_pct_placeholder = '0.00%';
    public string $conclusion_promedio_valor_final_placeholder = '0.00';

    // Propiedades para la tabla 2 (Estadísticas)
    public string $conclusion_media_aritmetica_oferta = '0.00';
    public string $conclusion_media_aritmetica_homologado = '0.00';
    public string $conclusion_desviacion_estandar_oferta = '0.00';
    public string $conclusion_coeficiente_variacion_oferta = '0.00';
    public string $conclusion_dispersion_oferta = '0.00';
    public string $conclusion_maximo_oferta = '0.00';
    public string $conclusion_minimo_oferta = '0.00';
    public string $conclusion_diferencia_oferta = '0.00';

    public string $conclusion_desviacion_estandar_homologado = '0.00';
    public string $conclusion_coeficiente_variacion_homologado = '0.00';
    public string $conclusion_dispersion_homologado = '0.00';
    public string $conclusion_maximo_homologado = '0.00';
    public string $conclusion_minimo_homologado = '0.00';
    public string $conclusion_diferencia_homologado = '0.00';

    public string $conclusion_valor_unitario_lote_tipo = '$0.00';
    public string $conclusion_tipo_redondeo = 'DECENAS';

    public function mount()
    {
        $this->idValuation = Session::get('valuation_id');
        $this->valuation = Valuation::find($this->idValuation);

        if (!$this->valuation) {
            $this->comparables = collect();
            $this->comparablesCount = 0;
            $this->resetConclusionProperties();
            return;
        }

        $this->comparables = $this->valuation->landComparables()->orderByPivot('position')->get();
        $this->comparablesCount = $this->comparables->count();

        if ($this->comparablesCount == 0) {
            $this->resetConclusionProperties();
            return;
        }

        $this->currentPage = 1;
        $this->masterFactors = [
            ['code' => 'FNEG', 'label' => 'FNEG', 'subject_model' => 'subject_factor_negociacion', 'type' => 'number_aplicable'],
            ['code' => 'FZO',  'label' => 'FZO',  'subject_model' => 'subject_factor_zona',        'type' => 'select'],
            ['code' => 'FUB',  'label' => 'FUB',  'subject_model' => 'subject_factor_ubicacion',   'type' => 'select'],
            ['code' => 'FTOP', 'label' => 'FTOP', 'subject_model' => 'subject_factor_topografia_valor', 'type' => 'number'],
            ['code' => 'FFO',  'label' => 'FFO',  'subject_model' => 'subject_factor_forma',       'type' => 'number'],
            ['code' => 'FSU',  'label' => 'FSU',  'subject_model' => 'subject_factor_superficie',  'type' => 'text_readonly'],
            ['code' => 'FCUS', 'label' => 'FCUS', 'subject_model' => 'subject_factor_uso_suelo',   'type' => 'text_readonly'],
        ];

        foreach ($this->comparables as $comparable) {
            $valorHomologadoInicial = $comparable->comparable_unit_value;
            $factorResultanteInicial = 1.0;

            foreach ($this->masterFactors as $factor) {
                $this->comparableFactors[$comparable->id][$factor['code']]['calificacion'] = '1.0000';
                if ($factor['code'] === 'FNEG') {
                    $this->comparableFactors[$comparable->id][$factor['code']]['aplicable'] = '0.9000';
                }
                $this->comparableFactors[$comparable->id][$factor['code']]['factor_ajuste'] = '1.0000';
            }

            $this->comparableFactors[$comparable->id]['FRE'] = [
                'factor_ajuste' => $factorResultanteInicial,
                'valor_homologado' => $valorHomologadoInicial
            ];

            $this->comparableFactors[$comparable->id]['COL_FACTOR_2_PLACEHOLDER'] = '0.4400';
            $this->comparableFactors[$comparable->id]['COL_AJUSTE_PCT_PLACEHOLDER'] = '26.89%';
            $this->comparableFactors[$comparable->id]['COL_VALOR_FINAL_PLACEHOLDER'] = '680.84';
        }

        $this->selectedForStats = $this->comparables->pluck('id')->toArray();
        $this->updateComparableSelection(); // Carga el comparable 1
        $this->recalculateConclusions();
    }



    public function openComparablesLand()
    {
        Session::put('comparables-active-session', true);
        Session::put('comparable-type', 'land');
        return redirect()->route('form.comparables.index');
    }



    // --- HOOKS DE REACTIVIDAD ---
    public function updatedSelectedForStats()
    {
        $this->recalculateConclusions();
    }

    public function updatedConclusionTipoRedondeo()
    {
        $this->recalculateConclusions();
    }

    // --- CÁLCULOS PRINCIPALES ---
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

        // Estadísticas Oferta
        $avgOferta = $valoresOferta->avg();
        $stdDevOferta = $this->std_deviation($valoresOferta);
        $this->conclusion_promedio_oferta = $this->format_currency($avgOferta, false);
        $this->conclusion_media_aritmetica_oferta = $this->format_currency($avgOferta, false);
        $this->conclusion_maximo_oferta = $this->format_currency($valoresOferta->max());
        $this->conclusion_minimo_oferta = $this->format_currency($valoresOferta->min());
        $this->conclusion_diferencia_oferta = $this->format_currency($valoresOferta->max() - $valoresOferta->min());
        $this->conclusion_desviacion_estandar_oferta = number_format($stdDevOferta, 2);
        $this->conclusion_coeficiente_variacion_oferta = ($avgOferta > 0) ? number_format(($stdDevOferta / $avgOferta) * 100, 2) : '0.00';
        $this->conclusion_dispersion_oferta = $this->conclusion_coeficiente_variacion_oferta;

        // Estadísticas Homologado
        $avgHomologado = $valoresHomologados->avg();
        $stdDevHomologado = $this->std_deviation($valoresHomologados);
        $this->conclusion_valor_unitario_homologado_promedio = $this->format_currency($avgHomologado, false);
        $this->conclusion_media_aritmetica_homologado = $this->format_currency($avgHomologado, false);
        $this->conclusion_maximo_homologado = $this->format_currency($valoresHomologados->max());
        $this->conclusion_minimo_homologado = $this->format_currency($valoresHomologados->min());
        $this->conclusion_diferencia_homologado = $this->format_currency($valoresHomologados->max() - $valoresHomologados->min());
        $this->conclusion_desviacion_estandar_homologado = number_format($stdDevHomologado, 2);
        $this->conclusion_coeficiente_variacion_homologado = ($avgHomologado > 0) ? number_format(($stdDevHomologado / $avgHomologado) * 100, 2) : '0.00';
        $this->conclusion_dispersion_homologado = $this->conclusion_coeficiente_variacion_homologado;

        // Promedios
        $this->conclusion_factor_promedio = number_format($factoresFRE->avg(), 4);
        $this->conclusion_promedio_factor2_placeholder = '0.1600';
        $this->conclusion_promedio_ajuste_pct_placeholder = '100.00%';
        $this->conclusion_promedio_valor_final_placeholder = '1,325.48';

        // Valor Lote Tipo
        $valorRedondeado = $this->redondearValor($avgHomologado, $this->conclusion_tipo_redondeo);
        $this->conclusion_valor_unitario_lote_tipo = $this->format_currency($valorRedondeado, true);
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

        return [
            'labels' => $selected->pluck('id'),
            'factors' => $selected->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['factor_ajuste'] ?? 0)),
            'homologated' => $selected->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['valor_homologado'] ?? 0)),
            'coeficiente_variacion_oferta' => (float)$this->conclusion_coeficiente_variacion_oferta,
            'coeficiente_variacion_homologado' => (float)$this->conclusion_coeficiente_variacion_homologado,
        ];
    }

    // --- MANEJO DE PÁGINAS ---
    public function updateComparableSelection()
    {
        if ($this->comparablesCount == 0) return;
        $index = $this->currentPage - 1;
        $this->selectedComparable = $this->comparables->get($index) ?? $this->comparables->first();
        $this->selectedComparableId = $this->selectedComparable->id ?? null;
    }

    public function updatedCurrentPage()
    {
        $this->updateComparableSelection();
    }

    public function gotoPage($page)
    {
        if ($page >= 1 && $page <= $this->comparablesCount) {
            $this->currentPage = $page;

            // --- ¡AQUÍ ESTÁ LA CORRECCIÓN! ---
            // Forzamos la actualización del comparable seleccionado
            // en lugar de solo confiar en el hook.
            $this->updateComparableSelection();
        }
    }

    // --- HELPERS ---
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
        $this->conclusion_valor_unitario_lote_tipo = '$0.00';
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
        return view('livewire.forms.homologation-lands');
    }
}
