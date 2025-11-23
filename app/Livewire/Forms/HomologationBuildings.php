<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Flux\Flux;
use Masmerise\Toaster\Toaster;

// Modelos Generales
use App\Models\Valuations\Valuation;

// Modelos de Homologación (Asegúrate de que existan)
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationComparableFactorModel;
use App\Models\Forms\Comparable\ValuationBuildingComparableModel;

class HomologationBuildings extends Component
{
    // --- PROPIEDADES INICIALES ---
    public $idValuation;
    public $valuation;
    public $comparables;
    public $comparablesCount = 0;

    // --- ESTRUCTURAS DE DATOS (DINÁMICAS) ---
    public array $subject_factors_ordered = []; // Para la tabla del sujeto
    public array $masterFactors = []; // Para la tabla de comparables (Blueprint)
    public array $comparableFactors = []; // Valores de los comparables

    // --- ESTADO DE EDICIÓN (TOGGLE) ---
    public $editing_factor_sujeto = null; // Acrónimo en edición
    public $edit_factor_name;
    public $edit_factor_acronym;
    public $edit_factor_rating;

    // --- INPUTS PARA NUEVO FACTOR ---
    public $new_factor_name = '';
    public $new_factor_acronym = '';
    public $new_factor_rating = '';

    // --- PAGINACIÓN Y ESTADO DE COMPARABLES ---
    public $currentPage = 1;
    public $selectedComparableId;
    public $selectedComparable;

    // --- CONCLUSIONES Y CHART (Mantenidas de tu código original) ---
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

    // ==========================================================
    // == INIT & MOUNT
    // ==========================================================
    public function mount()
    {
        $this->idValuation = Session::get('valuation_id');
        $this->valuation = Valuation::find($this->idValuation);

        if (!$this->valuation) {
            $this->comparables = collect();
            return;
        }

        // 1. CARGAR COMPARABLES
        // Usamos try-catch por si la relación no está definida, para evitar crash
        try {
            $this->comparables = $this->valuation->buildingComparables()->orderByPivot('position')->get();
        } catch (\Throwable $e) {
            $this->comparables = collect();
        }
        $this->comparablesCount = $this->comparables->count();

        // 2. CARGAR FACTORES (Lógica DB + Sándwich)
        // Esto llenará $this->subject_factors_ordered y $this->masterFactors
        $this->prepareSubjectFactorsForView();

        // 3. INICIALIZAR COMPARABLES (Paginación y Factores)
        if ($this->comparablesCount > 0) {
            $this->currentPage = 1;
            // Inicializar matriz de factores para cada comparable
            foreach ($this->comparables as $comparable) {
                $this->initializeComparableFactors($comparable);
            }
            // Seleccionar el primero
            $this->updateComparableSelection();
        }

        $this->selectedForStats = $this->comparables->pluck('id')->toArray();
        $this->recalculateConclusions();
    }

    // ==========================================================
    // == LÓGICA DE ORDENAMIENTO (SÁNDWICH)
    // ==========================================================
    private function prepareSubjectFactorsForView(): void
    {
        $allFactors = HomologationValuationFactorModel::where('valuation_id', $this->idValuation)
            ->where('homologation_type', 'building')
            ->get();

        // Definimos el orden estricto de los Factores de Sistema
        $systemOrder = ['FSU', 'FIC', 'FEQ', 'FEDAC', 'FLOC', 'AVANC'];
        // Definimos cuáles de estos son editables
        $systemEditable = ['FEQ', 'FLOC'];

        $orderedList = [];

        // Helper para formatear
        $formatFactor = function ($factor) use ($systemEditable) {
            $canEdit = $factor->is_custom || in_array($factor->acronym, $systemEditable);

            $subjectModelString = 'subject_factor_' . strtolower($factor->acronym);

            return [
                'id' => $factor->id,
                'factor_name' => $factor->factor_name,
                'label' => $factor->factor_name,
                'acronym' => $factor->acronym,
                'code' => $factor->acronym, // Alias para compatibilidad con tu código original
                'rating' => number_format((float)$factor->rating, 4, '.', ''),
                'is_custom' => (bool)$factor->is_custom,
                'subject_model' => $subjectModelString,
                'can_edit' => $canEdit,
                'type' => 'number' // Default type
            ];
        };

        // A. Insertar Factores del Sistema
        foreach ($systemOrder as $acronym) {
            $f = $allFactors->firstWhere('acronym', $acronym);
            if ($f) {
                $orderedList[] = $formatFactor($f);
            }
        }

        // B. Insertar Factores Custom
        foreach ($allFactors as $factor) {
            if (!in_array($factor->acronym, $systemOrder)) {
                $orderedList[] = $formatFactor($factor);
            }
        }

        // Asignamos a las propiedades de la clase
        $this->subject_factors_ordered = $orderedList;

        // ¡ESTA ES LA LÍNEA QUE FALTABA!
        // Asignamos masterFactors igual que ordered para que la tabla de comparables sepa qué renderizar
        $this->masterFactors = $orderedList;
    }

    private function initializeComparableFactors($comparable)
    {
        $valorHomologadoInicial = $comparable->comparable_unit_value ?? 1.00;

        // Inicializar factores dinámicos
        foreach ($this->masterFactors as $factor) {
            $code = $factor['acronym'];
            if (!isset($this->comparableFactors[$comparable->id][$code])) {
                $this->comparableFactors[$comparable->id][$code] = [
                    'calificacion' => '1.0000',
                    'aplicable' => '1.0000',
                    'factor_ajuste' => '1.0000',
                    'diferencia' => '0.0000',
                ];
            }
        }

        // Inicializar factores fijos (Selects y URL)
        $defaults = [
            'clase' => 'Clase B',
            'clase_factor' => '1.0000',
            'conservacion' => 'Buena',
            'conservacion_factor' => '1.0000',
            'localizacion' => 'Lote intermedio',
            'localizacion_factor' => '1.0000',
            'url' => $comparable->comparable_source ?? 'http://valua.me/...'
        ];

        foreach ($defaults as $key => $val) {
            if (!isset($this->comparableFactors[$comparable->id][$key])) {
                $this->comparableFactors[$comparable->id][$key] = $val;
            }
        }

        // Inicializar FRE
        if (!isset($this->comparableFactors[$comparable->id]['FRE'])) {
            $this->comparableFactors[$comparable->id]['FRE'] = [
                'factor_ajuste' => 1.0,
                'valor_homologado' => $valorHomologadoInicial,
                'valor_unitario_vendible' => '0.00',
            ];
        }
    }

    // ==========================================================
    // == LÓGICA DE EDICIÓN (TOGGLE / SAVE)
    // ==========================================================
    public function toggleEditFactor($acronym, $index)
    {
        // CASO 1: Si ya estamos editando ESTE factor -> GUARDAR
        if ($this->editing_factor_sujeto === $acronym) {
            $this->saveEditedFactor($index);
            // El saveEditedFactor maneja la limpieza del estado
        }
        // CASO 2: Si no estamos editando nada o editamos otro -> ACTIVAR EDICIÓN
        else {
            $factorData = $this->subject_factors_ordered[$index];

            // Cargar valores actuales a inputs temporales (se usa defer/lazy en la vista)
            $this->edit_factor_name = $factorData['factor_name'];
            $this->edit_factor_acronym = $factorData['acronym'];
            $this->edit_factor_rating = $factorData['rating'];

            // 🔥 FIX: Actualizamos el estado para que la vista renderice el ícono de Guardar
            $this->editing_factor_sujeto = $acronym;
        }
    }


    private function saveEditedFactor($index)
    {
        $factorData = $this->subject_factors_ordered[$index];
        $factorModel = HomologationValuationFactorModel::find($factorData['id']);

        if (!$factorModel) return;

        // --- VALIDACIONES MÍNIMAS (Rating y No Vacío) ---

        // 1. Campos vacíos (Validación de strings, debe ser solo para Custom/Editables)
        // Usamos la validación del hook updatedSubjectFactorsOrdered en Lands para evitar vacío.
        if (empty(trim($this->edit_factor_name)) || empty(trim($this->edit_factor_acronym))) {
            Toaster::error('Los campos de nombre y siglas no pueden estar vacíos.');
            // No resetear aquí para que el usuario pueda corregir, pero salir del save
            return;
        }

        // 2. Validación de Rango (0.8000 - 1.2000)
        $numericRating = (float)$this->edit_factor_rating;
        if ($numericRating < 0.8 || $numericRating > 1.2) {
            Toaster::error('La calificación debe estar entre 0.8000 y 1.2000.');
            return;
        }

        // --- GUARDADO (Solo persistencia básica) ---
        $oldAcronym = $factorModel->acronym;

        $factorModel->update([
            'factor_name' => $this->edit_factor_name,
            'acronym' => strtoupper($this->edit_factor_acronym),
            'rating' => $numericRating
        ]);

        // Sincronización (para actualizar UI y comparables)
        if ($oldAcronym !== strtoupper($this->edit_factor_acronym) || $factorData['factor_name'] !== $this->edit_factor_name) {
            // Aquí iría tu método syncComparableFactorNames
            $this->syncComparableFactorNames($oldAcronym, $this->edit_factor_name, strtoupper($this->edit_factor_acronym));
        }

        Toaster::success('Factor guardado (lazy mode).');

        // Finalizar edición y actualizar vista
        $this->editing_factor_sujeto = null;
        $this->prepareSubjectFactorsForView();
        $this->recalculateConclusions(); // Por si el rating cambió
    }

    public function cancelEdit()
    {
        $this->editing_factor_sujeto = null;
    }

    // ==========================================================
    // == CRUD: AGREGAR Y ELIMINAR
    // ==========================================================
    public function saveNewFactor()
    {
        $this->validate([
            'new_factor_name' => 'required|string|max:100',
            'new_factor_acronym' => 'required|string|max:10|alpha_num',
            'new_factor_rating' => 'required|numeric|min:0.8|max:1.2',
        ]);

        // Crear en DB
        $newFactor = HomologationValuationFactorModel::create([
            'valuation_id' => $this->idValuation,
            'factor_name' => $this->new_factor_name,
            'acronym' => strtoupper($this->new_factor_acronym),
            'rating' => $this->new_factor_rating,
            'homologation_type' => 'building',
            'is_editable' => true,
            'is_custom' => true,
        ]);

        // Inyectar en comparables existentes
        $this->createNewFactorInComparables($newFactor);

        $this->reset(['new_factor_name', 'new_factor_acronym', 'new_factor_rating']);
        $this->prepareSubjectFactorsForView();

        // Inicializar array local para evitar errores antes del refresh
        foreach ($this->comparables->pluck('id') as $compId) {
            $this->initializeComparableFactors($this->comparables->find($compId));
        }

        Toaster::success('Factor agregado.');
    }

    public function deleteCustomFactor($factorId)
    {
        $factor = HomologationValuationFactorModel::find($factorId);
        if (!$factor || !$factor->is_custom) return;

        // Eliminar de comparables
        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');
        HomologationComparableFactorModel::whereIn('valuation_building_comparable_id', $pivotIds)
            ->where('acronym', $factor->acronym)
            ->where('homologation_type', 'building')
            ->delete();

        $factor->delete();
        $this->prepareSubjectFactorsForView();
        Toaster::success('Factor eliminado.');
    }

    // ==========================================================
    // == NAVEGACIÓN Y SELECCIÓN
    // ==========================================================
    public function gotoPage($page)
    {
        if ($page >= 1 && $page <= $this->comparablesCount) {
            $this->currentPage = $page;
            $this->updateComparableSelection();
        }
    }

    public function updateComparableSelection()
    {
        if ($this->comparablesCount == 0) return;
        $index = $this->currentPage - 1;
        $this->selectedComparable = $this->comparables->get($index);
        $this->selectedComparableId = $this->selectedComparable->id ?? null;

        if ($this->selectedComparableId) {
            $this->recalculateComparableFactors($this->selectedComparableId);
        }
    }

    // ==========================================================
    // == LÓGICA DE CÁLCULO
    // ==========================================================
    public function updated($property, $value)
    {
        // Si editamos un factor en la tabla de comparables
        if (str_starts_with($property, 'comparableFactors.')) {
            $parts = explode('.', $property);
            if (isset($parts[1])) {
                $this->recalculateComparableFactors($parts[1]); // parts[1] es el ID del comparable
            }
        }
    }

    public function recalculateComparableFactors($comparableId)
    {
        if (!$comparableId || !isset($this->comparableFactors[$comparableId])) return;

        $currentFactors = &$this->comparableFactors[$comparableId];
        $factorResultante = 1.0;

        // Mapear los ratings del sujeto desde la DB (masterFactors)
        $subjectRatings = [];
        foreach ($this->masterFactors as $mf) {
            $subjectRatings[$mf['acronym']] = (float)$mf['rating'];
        }

        // Obtener valores de selects
        $clase_factor = $this->mapSelectValue($currentFactors['clase'] ?? 'Clase B', 'clase');
        $conservacion_factor = $this->mapSelectValue($currentFactors['conservacion'] ?? 'Buena', 'conservacion');
        $localizacion_factor = $this->mapSelectValue($currentFactors['localizacion'] ?? 'Lote intermedio', 'localizacion');

        // Calcular Factores
        foreach ($this->masterFactors as $factor) {
            $code = $factor['acronym'];
            if (!isset($currentFactors[$code])) continue;

            $sujetoRating = $subjectRatings[$code] ?? 1.0;
            $compRating = (float)($currentFactors[$code]['calificacion'] ?? 1.0);

            // Lógica específica por tipo de factor
            if ($code === 'FIC') {
                $compRating = $clase_factor;
                $diferencia = ($sujetoRating != 0) ? ($compRating / $sujetoRating) - 1 : 0.0;
                $factor_ajuste = 1.0 - $diferencia;
            } elseif ($code === 'FLOC') {
                $compRating = $localizacion_factor;
                $diferencia = ($sujetoRating != 0) ? ($compRating / $sujetoRating) - 1 : 0.0;
                $factor_ajuste = 1.0 - $diferencia;
            } elseif ($code === 'FNEG') {
                // FNEG usa 'aplicable' directo
                $factor_ajuste = (float)($currentFactors[$code]['aplicable'] ?? 1.0);
                $diferencia = 0;
            } else {
                // Default logic
                $diferencia = ($sujetoRating != 0) ? ($compRating / $sujetoRating) - 1 : 0.0;
                $factor_ajuste = 1.0 - $diferencia;
            }

            // Guardar resultados
            $currentFactors[$code]['diferencia'] = number_format($diferencia, 4, '.', '');
            $currentFactors[$code]['factor_ajuste'] = number_format($factor_ajuste, 4, '.', '');

            // Acumular (FEQ no multiplica aquí, lleva su propia lógica o se incluye)
            // Asumo que FEQ sí multiplica según tu lógica anterior, si no, pon el if ($code !== 'FEQ')
            $factorResultante *= $factor_ajuste;
        }

        // Multiplicar por conservación (factor independiente)
        $factorResultante *= $conservacion_factor;

        // Guardar FRE y VUH
        $currentFactors['FRE']['factor_ajuste'] = number_format($factorResultante, 4, '.', '');

        $comparableModel = $this->comparables->find($comparableId);
        $unitValue = (float)($comparableModel->comparable_unit_value ?? 0);
        $valorHomologado = $unitValue * $factorResultante;

        $currentFactors['FRE']['valor_homologado'] = $valorHomologado;
        $currentFactors['FRE']['valor_unitario_vendible'] = number_format($valorHomologado, 2, '.', '');

        $this->recalculateConclusions();
    }

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

        $avgOferta = $valoresOferta->avg();
        $avgHomologado = $valoresHomologados->avg();
        $stdDevOferta = $this->std_deviation($valoresOferta);
        $stdDevHomologado = $this->std_deviation($valoresHomologados);

        // Asignaciones de Stats (Mismas de tu código)
        $this->conclusion_promedio_oferta = $this->format_currency($avgOferta, false);
        $this->conclusion_valor_unitario_homologado_promedio = $this->format_currency($avgHomologado, false);
        $this->conclusion_factor_promedio = number_format($factoresFRE->avg(), 4);

        $this->conclusion_media_aritmetica_oferta = $this->format_currency($avgOferta, false);
        $this->conclusion_media_aritmetica_homologado = $this->format_currency($avgHomologado, false);

        $this->conclusion_maximo_oferta = $this->format_currency($valoresOferta->max());
        $this->conclusion_minimo_oferta = $this->format_currency($valoresOferta->min());
        $this->conclusion_diferencia_oferta = $this->format_currency($valoresOferta->max() - $valoresOferta->min());

        $this->conclusion_maximo_homologado = $this->format_currency($valoresHomologados->max());
        $this->conclusion_minimo_homologado = $this->format_currency($valoresHomologados->min());
        $this->conclusion_diferencia_homologado = $this->format_currency($valoresHomologados->max() - $valoresHomologados->min());

        $this->conclusion_desviacion_estandar_oferta = number_format($stdDevOferta, 2);
        $this->conclusion_coeficiente_variacion_oferta = ($avgOferta > 0) ? number_format(($stdDevOferta / $avgOferta) * 100, 2) : '0.00';

        $this->conclusion_desviacion_estandar_homologado = number_format($stdDevHomologado, 2);
        $this->conclusion_coeficiente_variacion_homologado = ($avgHomologado > 0) ? number_format(($stdDevHomologado / $avgHomologado) * 100, 2) : '0.00';

        // Valor de Venta Final
        $valorRedondeado = $this->redondearValor($avgHomologado, $this->conclusion_tipo_redondeo);
        $this->conclusion_valor_unitario_de_venta = $this->format_currency($valorRedondeado, true);

        // Chart Update
        $this->dispatch('updateChart', data: $this->chartData)->self();
    }

    // --- HELPERS DE SYNC Y UTILS ---
    private function syncComparableFactorNames($oldAcronym, $newName, $newAcronym)
    {
        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');
        if ($pivotIds->isEmpty()) return;
        HomologationComparableFactorModel::whereIn('valuation_building_comparable_id', $pivotIds)
            ->where('acronym', $oldAcronym)->where('homologation_type', 'building')
            ->update(['factor_name' => $newName, 'acronym' => $newAcronym]);
    }

    private function createNewFactorInComparables($subjectFactor)
    {
        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');
        foreach ($pivotIds as $pivotId) {
            HomologationComparableFactorModel::create([
                'valuation_building_comparable_id' => $pivotId,
                'factor_name' => $subjectFactor->factor_name,
                'acronym' => $subjectFactor->acronym,
                'homologation_type' => 'building',
                'is_editable' => true,
                'is_custom' => true,
                'rating' => 1.0000,
                'applicable' => 1.0000
            ]);
        }
    }

    private function mapSelectValue(string $key, string $optionType): float
    {
        $options = [
            'clase' => ['Precario' => 1.7500, 'Clase B' => 1.0000, 'Clase C' => 0.8000],
            'conservacion' => ['Buena' => 1.0000, 'Regular' => 0.9000, 'Mala' => 0.8000],
            'localizacion' => ['Lote intermedio' => 1.0000, 'Esquina' => 1.0500],
        ];
        return $options[$optionType][$key] ?? 1.0000;
    }

    // --- COMPUTED Y CHARTS ---
    #[Computed]
    public function chartData(): array
    {
        if (!$this->comparables) return $this->getEmptyChartData();
        $selected = $this->comparables->whereIn('id', $this->selectedForStats)->values();
        if ($selected->isEmpty()) return $this->getEmptyChartData();

        $labels = $selected->pluck('id')->map(fn($id, $index) => "Comp. " . ($index + 1))->toArray();
        $factors = $selected->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['factor_ajuste'] ?? 1.0))->toArray();
        $homologated = $selected->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['valor_homologado'] ?? 0))->toArray();

        return [
            'labels' => $labels,
            'factors' => $factors,
            'homologated' => $homologated,
            'coeficiente_variacion_oferta' => (float)str_replace(['%', ','], ['', '.'], $this->conclusion_coeficiente_variacion_oferta),
            'coeficiente_variacion_homologado' => (float)str_replace(['%', ','], ['', '.'], $this->conclusion_coeficiente_variacion_homologado),
        ];
    }

    private function getEmptyChartData(): array
    {
        return ['labels' => [], 'factors' => [], 'homologated' => [], 'coeficiente_variacion_oferta' => 0, 'coeficiente_variacion_homologado' => 0];
    }
    private function std_deviation(Collection $values): float
    {
        $c = $values->count();
        if ($c < 2) return 0.0;
        $m = $values->avg();
        return sqrt($values->map(fn($v) => pow($v - $m, 2))->sum() / ($c - 1));
    }
    private function format_currency($v, $s = true): string
    {
        return ($s ? '$' : '') . number_format($v ?? 0, 2, '.', ',');
    }
    private function redondearValor($v, $t)
    {
        return match ($t) {
            'DECENAS' => round($v, -1),
            'CENTENAS' => round($v, -2),
            'MILLARES' => round($v, -3),
            default => round($v, 0)
        };
    }
    private function resetConclusionProperties()
    { /* ... Resets básicos a 0 ... */
    }

    // Hooks
    public function updatedSelectedForStats()
    {
        $this->recalculateConclusions();
    }
    public function updatedConclusionTipoRedondeo()
    {
        $this->recalculateConclusions();
    }
    public function openComparablesBuilding()
    {
        Session::put('comparables-active-session', true);
        return redirect()->route('form.comparables.index');
    }

    public function render()
    {
        return view('livewire.forms.homologation-buildings');
    }
}
