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
use App\Models\Forms\Comparable\ComparableModel;
use App\Models\Forms\Comparable\ValuationLandComparableModel;
use App\Models\Forms\ApplicableSurface\ApplicableSurfaceModel;
use App\Models\Forms\LandDetails\LandDetailsModel;

// Modelos de Homologación
use App\Models\Forms\Homologation\HomologationComparableFactorModel;
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationLandAttributeModel;

class HomologationLands extends Component
{
    // --- PROPIEDADES ---
    public $idValuation;
    public $valuation;
    public $comparables;
    public $comparablesCount;

    public $assignedElements;

    // --- ATRIBUTOS DE TIERRA ---
    public $subject_surface_type = 'total';
    public $subject_cus = '1.00 vsp';
    public $subject_cos = '50.00 %';
    public $subject_lote_moda = '100.00';

    // --- ESTRUCTURAS DE DATOS ---
    public array $comparableFactors = [];
    public array $subject_factors_ordered = [];
    public ?array $fneg_factor_meta = null;

    // Opciones para Selects (FZO, FUB) - Claves como string simple para evitar bugs de livewire
    public array $selectFactorOptions = [
        'FZO' => ['1.2' => '1.2000', '1.0' => '1.0000', '0.8' => '0.8000'],
        'FUB' => ['1.2' => '1.2000', '1.0' => '1.0000', '0.8' => '0.8000'],
    ];

    // --- PAGINACIÓN Y ESTADO ---
    public $currentPage = 1;
    public $selectedComparableId;
    public $selectedComparable;

    // --- CONCLUSIONES Y ESTADÍSTICAS ---
    public array $selectedForStats = [];

    // Propiedades de UI para conclusiones
    public string $conclusion_promedio_oferta = '0.00';
    public string $conclusion_valor_unitario_homologado_promedio = '0.00';
    public string $conclusion_factor_promedio = '0.0000';

    // Placeholders
    public string $conclusion_promedio_factor2_placeholder = '0.0000';
    public string $conclusion_promedio_ajuste_pct_placeholder = '0.00%';
    public string $conclusion_promedio_valor_final_placeholder = '0.00';

    // Estadísticas detalladas
    public string $conclusion_media_aritmetica_oferta = '0.00';
    public string $conclusion_media_aritmetica_homologado = '0.00';
    public string $conclusion_desviacion_estandar_oferta = '0.00';
    public string $conclusion_coeficiente_variacion_oferta = '0.00';
    public string $conclusion_coeficiente_variacion_homologado = '0.00';

    // Dispersión (Mantenidas por compatibilidad con la vista)
    public string $conclusion_dispersion_oferta = '0.00';
    public string $conclusion_dispersion_homologado = '0.00';

    public string $conclusion_maximo_oferta = '0.00';
    public string $conclusion_minimo_oferta = '0.00';
    public string $conclusion_diferencia_oferta = '0.00';
    public string $conclusion_desviacion_estandar_homologado = '0.00';
    public string $conclusion_maximo_homologado = '0.00';
    public string $conclusion_minimo_homologado = '0.00';
    public string $conclusion_diferencia_homologado = '0.00';

    // Resultado Final
    public string $conclusion_valor_unitario_lote_tipo = '$0.00';
    public string $conclusion_tipo_redondeo = 'DECENAS';

    // --- UI HELPERS ---
    public $landDetail;
    public $propertyType;
    public $useExcessCalculation;

    public $selectedSurfaceOptionId = 1;
    public $selectedSurfaceDescription = 'Terreno Total (2,000.00 m2)';

    // ==========================================================
    // == COMPUTED PROPERTIES
    // ==========================================================
    #[Computed]
    public function orderedComparableFactorsForView(): array
    {
        $ordered = $this->subject_factors_ordered;
        if ($this->fneg_factor_meta) {
            array_unshift($ordered, $this->fneg_factor_meta);
        }
        return $ordered;
    }

    #[Computed]
    public function chartData(): array
    {
        return $this->getEmptyChartData();
    }

    #[Computed]
    public function statsData(): array
    {
        return $this->getEmptyChartData();
    }

    // ==========================================================
    // == INIT & MOUNT
    // ==========================================================
    public function mount()
    {
        $this->idValuation = Session::get('valuation_id');
        $this->valuation = Valuation::find($this->idValuation);

        if (!$this->valuation) {
            $this->abortComponent();
            return;
        }

        $this->propertyType = $this->valuation->property_type;
        $this->loadAssignedElements();
        $this->loadLandAttributes();
        $this->loadComparables();

        if ($this->comparablesCount > 0) {
            $this->prepareSubjectFactorsForView();
            $this->loadAllComparableFactors();
            $this->selectedForStats = $this->comparables->pluck('id')->toArray();
            $this->currentPage = 1;
            $this->updateComparableSelection();
            // Llama a recalculateConclusions para inicializar los promedios al cargar.
            $this->recalculateConclusions();
        }
    }

    private function abortComponent()
    {
        $this->comparables = collect();
        $this->comparablesCount = 0;
        $this->resetConclusionProperties();
    }

    private function loadAssignedElements()
    {
        $this->assignedElements = ApplicableSurfaceModel::where('valuation_id', $this->idValuation)->get();
        if ($this->assignedElements->isEmpty()) {
            $this->useExcessCalculation = 0;
            $this->landDetail = null;
        } else {
            $this->landDetail = LandDetailsModel::find($this->idValuation);
            $this->useExcessCalculation = $this->landDetail->use_excess_calculation ?? 0;
        }
    }

    private function loadLandAttributes()
    {
        $attributes = HomologationLandAttributeModel::firstOrCreate(
            ['valuation_id' => $this->idValuation]
        );
        $this->subject_lote_moda = $attributes->mode_lot ?? '100.00';
        $this->conclusion_tipo_redondeo = $attributes->conclusion_type_rounding ?? 'DECENAS';
    }

    private function loadComparables()
    {
        try {
            $this->comparables = $this->valuation->landComparables()->orderByPivot('position')->get();
        } catch (\Throwable $e) {
            $this->comparables = $this->valuation->landComparables()->orderBy('position')->get();
        }
        $this->comparablesCount = $this->comparables->count();
    }

    // ==========================================================
    // == LÓGICA DE FACTORES SUJETO (ESTRATEGIA SÁNDWICH)
    // ==========================================================
    private function prepareSubjectFactorsForView(): void
    {
        $allFactors = HomologationValuationFactorModel::where('valuation_id', $this->idValuation)
            ->where('homologation_type', 'land')
            ->get();

        $topAcronyms = ['FZO', 'FUB'];
        $bottomAcronyms = ['FFO', 'FSU', 'FCUS'];

        $topList = [];
        $middleList = [];
        $bottomList = [];

        $formatFactor = function ($factor) {
            return [
                'id' => $factor->id,
                'factor_name' => $factor->factor_name,
                'acronym' => $factor->acronym,
                'rating' => number_format((float)$factor->rating, 4, '.', ''),
                'is_editable' => (bool)$factor->is_editable,
                'input_type' => $this->getFactorInputType($factor->acronym),
            ];
        };

        $this->fneg_factor_meta = [
            'acronym' => 'FNEG',
            'factor_name' => 'Factor Negociacion',
            'rating' => '1.0000',
            'input_type' => $this->getFactorInputType('FNEG'),
            'id' => null
        ];

        foreach ($topAcronyms as $acronym) {
            $f = $allFactors->firstWhere('acronym', $acronym);
            if ($f) $topList[] = $formatFactor($f);
        }

        foreach ($bottomAcronyms as $acronym) {
            $f = $allFactors->firstWhere('acronym', $acronym);
            if ($f) $bottomList[] = $formatFactor($f);
        }

        $excludedAcronyms = array_merge($topAcronyms, $bottomAcronyms, ['FNEG']);
        foreach ($allFactors as $factor) {
            if (!in_array($factor->acronym, $excludedAcronyms)) {
                $middleList[] = $formatFactor($factor);
            }
        }

        $this->subject_factors_ordered = array_merge($topList, $middleList, $bottomList);
    }


    private function getFactorInputType(string $acronym): string
    {
        return match ($acronym) {
            'FZO', 'FUB' => 'select_calificacion',
            'FSU', 'FCUS' => 'read_only',
            default => 'number',
        };
    }

    // ==========================================================
    // == LÓGICA DE FACTORES COMPARABLES
    // ==========================================================
    private function loadAllComparableFactors(): void
    {
        $this->comparableFactors = [];
        if ($this->comparables->isEmpty()) return;

        $pivotIds = $this->valuation->landComparablePivots()->pluck('id');
        $factors = HomologationComparableFactorModel::whereIn('valuation_land_comparable_id', $pivotIds)
            ->where('homologation_type', 'land')
            ->get();

        $pivotMap = $this->valuation->landComparablePivots->pluck('comparable_id', 'id')->toArray();

        foreach ($factors as $factor) {
            $compId = $pivotMap[$factor->valuation_land_comparable_id] ?? null;
            if (!$compId) continue;

            $this->initializeComparableFactor($compId, $factor->acronym);

            // TRUCO: Si es FZO/FUB, usamos el valor tal cual (ej "1.2") para que coincida con el Select
            $calif = in_array($factor->acronym, ['FZO', 'FUB'])
                ? (string)($factor->rating + 0) // +0 remueve ceros extra visualmente si es necesario, o usa raw
                : number_format((float)($factor->rating ?? 1.0), 4, '.', '');

            // Ajuste fino para que coincida con las keys del array $selectFactorOptions ('1.2', '1.0', etc)
            if (in_array($factor->acronym, ['FZO', 'FUB'])) {
                $calif = number_format((float)$factor->rating, 1, '.', ''); // Forza "1.2" o "1.0"
            }

            $this->comparableFactors[$compId][$factor->acronym] = [
                'factor_id' => $factor->id,
                'calificacion' => $calif,
                'aplicable' => number_format((float)($factor->applicable ?? 1.0), 4, '.', ''),
                'factor_ajuste' => '1.0000',
                'diferencia' => '0.0000',
            ];
        }

        $allFactors = $this->orderedComparableFactorsForView;
        foreach ($this->comparables->pluck('id') as $compId) {
            foreach ($allFactors as $sf) {
                $sigla = $sf['acronym'];
                if (!isset($this->comparableFactors[$compId][$sigla])) {
                    $this->initializeComparableFactor($compId, $sigla);
                }
            }
            $this->recalculateSingleComparable($compId);
        }
    }

    private function initializeComparableFactor($comparableId, $sigla)
    {
        if (!isset($this->comparableFactors[$comparableId])) {
            $this->comparableFactors[$comparableId] = [];
        }
        if (!isset($this->comparableFactors[$comparableId]['FRE'])) {
            $this->comparableFactors[$comparableId]['FRE'] = [
                'factor_ajuste' => '1.0000',
                'valor_homologado' => '0.00'
            ];
        }
        if (!isset($this->comparableFactors[$comparableId][$sigla])) {
            // Valor inicial '1.0' para selects, '1.0000' para inputs
            $initialRating = in_array($sigla, ['FZO', 'FUB']) ? '1.0' : '1.0000';

            $this->comparableFactors[$comparableId][$sigla] = [
                'factor_id' => null,
                'calificacion' => $initialRating,
                'aplicable' => ($sigla === 'FNEG') ? '0.9000' : '1.0000',
                'factor_ajuste' => '1.0000',
                'diferencia' => '0.0000',
            ];
        }
    }

    // ==========================================================
    // == HOOKS DE ACTUALIZACIÓN (UPDATED)
    // ==========================================================

    public function updatedSubjectLoteModa($value)
    {
        if ($value === '' || $value === null || (float)$value <= 0) {
            Toaster::error('El Lote Moda es obligatorio y debe ser mayor a cero.');
            return;
        }
        HomologationLandAttributeModel::updateOrCreate(
            ['valuation_id' => $this->idValuation],
            ['mode_lot' => $value]
        );
        Toaster::success('Lote Moda guardado.');
    }

    public function updatedConclusionTipoRedondeo($value)
    {
        HomologationLandAttributeModel::updateOrCreate(
            ['valuation_id' => $this->idValuation],
            ['conclusion_type_rounding' => $value]
        );
        $this->recalculateConclusions();
        Toaster::success('Tipo de redondeo guardado.');
    }

    public function gotoPage(int $page)
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
        $this->selectedComparable = $this->comparables->get($index) ?? $this->comparables->first();
        $this->selectedComparableId = $this->selectedComparable->id ?? null;

        if ($this->selectedComparableId) {
            $this->recalculateSingleComparable($this->selectedComparableId);
        }
    }

    public function updatedSubjectFactorsOrdered($value, $key)
    {
        list($index, $property) = explode('.', $key, 2);
        $factorData = $this->subject_factors_ordered[$index] ?? null;
        if (!$factorData || !isset($factorData['id'])) return;

        $factorId = $factorData['id'];
        $factorModel = HomologationValuationFactorModel::find($factorId);
        if (!$factorModel) return;

        // --- VALIDACIONES ---
        if (($property === 'factor_name' || $property === 'acronym') && empty(trim($value))) {
            Toaster::error('El campo de texto no puede quedar vacío.');
            $this->subject_factors_ordered[$index][$property] = $factorModel->$property;
            return;
        }

        if ($property === 'rating') {
            if ($value === '' || $value === null) {
                Toaster::error('La calificación es obligatoria.');
                $this->subject_factors_ordered[$index][$property] = number_format($factorModel->rating, 4, '.', '');
                return;
            }
            $numericValue = (float)$value;
            if ($numericValue < 0.8 || $numericValue > 1.2) {
                Toaster::error('El valor del factor debe estar entre 0.8000 y 1.2000.');
                $this->subject_factors_ordered[$index][$property] = number_format($factorModel->rating, 4, '.', '');
                return;
            }
        }

        $originalAcronym = $factorModel->acronym;
        $valueToSave = $value;

        $factorModel->update([$property => $valueToSave]);

        // Actualizar localmente con formato
        if ($property === 'rating') {
            $this->subject_factors_ordered[$index]['rating'] = number_format((float)$valueToSave, 4, '.', '');
        }

        if ($property === 'factor_name' || $property === 'acronym') {
            // LLAMADA FALTANTE: Sincroniza nombres/siglas en los comparables
            $this->syncComparableFactorNames($originalAcronym, $property, $valueToSave);
            $this->prepareSubjectFactorsForView();
            $this->loadAllComparableFactors();
        }

        if ($property === 'rating') {
            foreach ($this->comparables->pluck('id') as $compId) {
                $this->recalculateSingleComparable($compId);
            }
        }

        if ($property !== 'factor_name' && $property !== 'acronym') {
            $this->prepareSubjectFactorsForView();
        }

        $this->recalculateConclusions();
        Toaster::success('Factor Sujeto actualizado.');
    }

    public function updatedComparableFactors($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) < 3) return;

        $comparableId = array_shift($parts);
        $property = array_pop($parts);
        $acronym = implode('.', $parts);

        // LLAMADA FALTANTE: Obtiene el ID del pivote
        $pivotId = $this->getPivotIdForComparable($comparableId);
        if (!$pivotId) return;

        // --- VALIDACIONES ---
        if ($value === '' || $value === null) {
            Toaster::error('El valor no puede estar vacío.');
            $existingFactor = HomologationComparableFactorModel::where('valuation_land_comparable_id', $pivotId)
                ->where('acronym', $acronym)->where('homologation_type', 'land')->first();
            $oldValue = $existingFactor ? ($property === 'calificacion' ? $existingFactor->rating : $existingFactor->applicable) : 1.0;
            if (isset($this->comparableFactors[$comparableId][$acronym])) {
                $this->comparableFactors[$comparableId][$acronym][$property] = number_format($oldValue, 4, '.', '');
            }
            return;
        }

        $numericValue = (float)$value;
        $errorMessage = '';
        $valid = true;

        if ($property === 'calificacion') {
            if ($acronym !== 'FZO' && $acronym !== 'FUB') {
                if ($numericValue < 0.01 || $numericValue > 2.0) {
                    $valid = false;
                    $errorMessage = 'La calificación debe estar entre 0.0100 y 2.0000.';
                }
            }
        } elseif ($property === 'aplicable' && $acronym === 'FNEG') {
            if ($numericValue < 0.8 || $numericValue > 1.0) {
                $valid = false;
                $errorMessage = 'El factor de negociación (FNEG) debe estar entre 0.8000 y 1.0000.';
            }
        }

        if (!$valid) {
            Toaster::error($errorMessage);
            $existingFactor = HomologationComparableFactorModel::where('valuation_land_comparable_id', $pivotId)
                ->where('acronym', $acronym)->where('homologation_type', 'land')->first();
            $oldValue = $existingFactor ? ($property === 'calificacion' ? $existingFactor->rating : $existingFactor->applicable) : 1.0;
            if (isset($this->comparableFactors[$comparableId][$acronym])) {
                $this->comparableFactors[$comparableId][$acronym][$property] = number_format($oldValue, 4, '.', '');
            }
            return;
        }

        // --- LOGICA PARA SELECTS PEGAJOSOS ---
        if ($acronym === 'FZO' || $acronym === 'FUB') {
            // Mantenemos el valor simple "1.2" para que el select no se rompa
            $formattedValue = $value;
        } else {
            $formattedValue = number_format($numericValue, 4, '.', '');
        }

        if (isset($this->comparableFactors[$comparableId][$acronym])) {
            $this->comparableFactors[$comparableId][$acronym][$property] = $formattedValue;
        }

        // Persistencia
        $factorModel = HomologationComparableFactorModel::where('valuation_land_comparable_id', $pivotId)
            ->where('acronym', $acronym)
            ->where('homologation_type', 'land')
            ->first();

        $dbColumn = match ($property) {
            'calificacion' => 'rating',
            'aplicable' => 'applicable',
            default => null
        };

        if ($dbColumn) {
            if ($factorModel) {
                $factorModel->update([$dbColumn => $numericValue]);
            } else {
                $subjectFactor = collect($this->subject_factors_ordered)->firstWhere('acronym', $acronym);
                $factorName = $acronym === 'FNEG' ? 'Factor Negociacion' : ($subjectFactor['factor_name'] ?? $acronym);

                $factorModel = HomologationComparableFactorModel::create([
                    'valuation_land_comparable_id' => $pivotId,
                    'acronym' => $acronym,
                    'factor_name' => $factorName,
                    'homologation_type' => 'land',
                    'rating' => ($property === 'calificacion') ? $numericValue : 1.0,
                    'applicable' => ($property === 'aplicable') ? $numericValue : 1.0,
                ]);
            }
            $this->comparableFactors[$comparableId][$acronym]['factor_id'] = $factorModel->id;
        }

        $this->recalculateSingleComparable($comparableId);
        $this->recalculateConclusions();
        Toaster::success('Factor guardado.');
    }







    public function updatedSelectedForStats()
    {
        // Se llama automáticamente cada vez que el array $selectedForStats cambia (al marcar/desmarcar)
        $this->recalculateConclusions();
        // Si el array queda vacío, recalculateConclusions llama a resetConclusionProperties() y pone todo en '0.00'.
        //Toaster::info('Estadísticas actualizadas por selección.');
    }










    // ==========================================================
    // == CÁLCULOS MATEMÁTICOS (CORE)
    // ==========================================================

    public function recalculateSingleComparable($comparableId)
    {
        $allFactors = $this->orderedComparableFactorsForView;
        $subjectRatings = collect($this->subject_factors_ordered)
            ->keyBy('acronym')
            ->map(fn($f) => (float)$f['rating']);
        $subjectRatings->put('FNEG', 1.0);

        if (!isset($this->comparableFactors[$comparableId])) return;

        $factorResultante = 1.0;

        foreach ($allFactors as $factor) {
            $sigla = $factor['acronym'];
            if (!isset($this->comparableFactors[$comparableId][$sigla])) continue;

            $factorData = &$this->comparableFactors[$comparableId][$sigla];
            $sujetoRating = $subjectRatings->get($sigla, 1.0);
            if ($sujetoRating == 0) $sujetoRating = 1.0;

            $compRating = (float)($factorData['calificacion'] ?? 1.0);

            $diferencia = ($compRating / $sujetoRating) - 1;

            if ($sigla === 'FNEG') {
                $factor_ajuste = (float)($factorData['aplicable'] ?? 1.0);
            } else {
                $factor_ajuste = 1.0 - $diferencia;
            }

            $factorData['diferencia'] = number_format($diferencia, 4, '.', '');
            $factorData['factor_ajuste'] = number_format($factor_ajuste, 4, '.', '');

            if ($sigla !== 'FSU' && $sigla !== 'FCUS') {
                $factorResultante *= $factor_ajuste;
            }
        }
        unset($factorData);

        $comparableModel = $this->comparables->find($comparableId);
        $unitValue = (float)($comparableModel->comparable_unit_value ?? 0);
        $valorHomologado = $unitValue * $factorResultante;

        $this->comparableFactors[$comparableId]['FRE']['factor_ajuste'] = number_format($factorResultante, 4, '.', '');
        $this->comparableFactors[$comparableId]['FRE']['valor_homologado'] = $valorHomologado;
    }

    public function recalculateConclusions()
    {
        if (!$this->comparables || $this->comparables->isEmpty()) {
            $this->resetConclusionProperties();
            return;
        }

        $selectedComparables = empty($this->selectedForStats)
            ? $this->comparables
            : $this->comparables->whereIn('id', $this->selectedForStats);

        if ($selectedComparables->isEmpty()) {
            $this->resetConclusionProperties();
            return;
        }

        // 🔥 FIX CRÍTICO: Forzar el cálculo del VUH para todos los comparables seleccionados
        // Esto garantiza que los promedios y las gráficas no sean cero.
        foreach ($selectedComparables->pluck('id') as $compId) {
            $this->recalculateSingleComparable($compId);
        }

        // Lógica de cálculo STATS (usa 'comparable_offers' para los valores grandes de la tabla)
        $valoresOferta = $selectedComparables->pluck('comparable_offers')->map(fn($v) => (float)$v);
        $valoresHomologados = $selectedComparables->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['valor_homologado'] ?? 0));
        $factoresFRE = $selectedComparables->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['factor_ajuste'] ?? 0));

        // --- CÁLCULOS ESTADÍSTICOS ---
        $avgOferta = $valoresOferta->avg();
        $stdDevOferta = $this->std_deviation($valoresOferta);
        $avgHomologado = $valoresHomologados->avg();
        $stdDevHomologado = $this->std_deviation($valoresHomologados);
        $avgFRE = $factoresFRE->avg();

        // Asignación de resultados a propiedades públicas...
        $this->conclusion_promedio_oferta = $this->format_currency($avgOferta, false);
        $this->conclusion_valor_unitario_homologado_promedio = $this->format_currency($avgHomologado, false);
        $this->conclusion_factor_promedio = number_format($avgFRE, 4);

        $this->conclusion_media_aritmetica_oferta = $this->format_currency($avgOferta, false);
        $this->conclusion_media_aritmetica_homologado = $this->format_currency($avgHomologado, false);

        $this->conclusion_maximo_oferta = $this->format_currency($valoresOferta->max());
        $this->conclusion_minimo_oferta = $this->format_currency($valoresOferta->min());
        $this->conclusion_diferencia_oferta = $this->format_currency($valoresOferta->max() - $valoresOferta->min());
        $this->conclusion_desviacion_estandar_oferta = number_format($stdDevOferta, 2);
        $this->conclusion_coeficiente_variacion_oferta = ($avgOferta > 0) ? number_format(($stdDevOferta / $avgOferta) * 100, 2) : '0.00';

        $this->conclusion_maximo_homologado = $this->format_currency($valoresHomologados->max());
        $this->conclusion_minimo_homologado = $this->format_currency($valoresHomologados->min());
        $this->conclusion_diferencia_homologado = $this->format_currency($valoresHomologados->max() - $valoresHomologados->min());
        $this->conclusion_desviacion_estandar_homologado = number_format($stdDevHomologado, 2);
        $this->conclusion_coeficiente_variacion_homologado = ($avgHomologado > 0) ? number_format(($stdDevHomologado / $avgHomologado) * 100, 2) : '0.00';

        // Placeholders y redondeo final
        $this->conclusion_promedio_factor2_placeholder = '0.0000';
        $this->conclusion_promedio_ajuste_pct_placeholder = '100.00%';
        $this->conclusion_promedio_valor_final_placeholder = $this->conclusion_valor_unitario_homologado_promedio;

        $valorBase = $avgHomologado;
        $valorRedondeado = $this->redondearValor($valorBase, $this->conclusion_tipo_redondeo);
        $this->conclusion_valor_unitario_lote_tipo = $this->format_currency($valorRedondeado, true);

        HomologationLandAttributeModel::updateOrCreate(
            ['valuation_id' => $this->idValuation],
            ['unit_value_mode_lot' => $valorRedondeado]
        );

        // ============================================================
        // == PREPARACIÓN DE DATOS PARA GRÁFICAS (USANDO UNIT VALUE PARA ESCALA)
        // ============================================================

        // 🔥 CRÍTICO: Creamos un set de datos de Oferta basado en Unit Value SÓLO para la gráfica.
        // Esto es necesario porque el Valor Oferta (stats) es el valor TOTAL, y la gráfica necesita el UNITARIO.
        $valoresOfertaUnit = $selectedComparables->pluck('comparable_unit_value')->map(fn($v) => (float)$v);

        $labels = $selectedComparables->pluck('id')->map(fn($id) => "$id")->values()->toArray();

        // Usamos los valores Unitarios para que la escala funcione
        $dataOfertaChart = $valoresOfertaUnit->values()->toArray();
        $dataHomologadoChart = $valoresHomologados->values()->toArray();

        // --- GRÁFICA 1: MIXTA (Barras Teal + Línea Roja Curva) ---
        $chartData1 = [
            'labels' => $labels,
            'datasets' => [
                [
                    'type' => 'line',
                    'label' => 'Valor Homologado',
                    'data' => $dataHomologadoChart,
                    'borderColor' => '#DC2626',
                    'backgroundColor' => '#DC2626',
                    'borderWidth' => 5,
                    'tension' => 0.4,
                    'pointRadius' => 4,
                    'fill' => false,
                    'order' => 1,
                    'yAxisID' => 'y',
                ],
                [
                    'type' => 'bar',
                    'label' => 'Valor Oferta',
                    'data' => $dataOfertaChart, // Unit Value (para que la escala coincida)
                    'backgroundColor' => '#14B8A6',
                    'borderColor' => '#14B8A6',
                    'borderWidth' => 1,
                    'order' => 2,
                    'yAxisID' => 'y',
                ]
            ]
        ];

        // --- GRÁFICA 2: SOLO BARRAS ROJAS (Valor Homologado) ---
        $chartData2 = [
            'labels' => $labels,
            'datasets' => [
                [
                    'type' => 'bar',
                    'label' => 'Valor Unit. Hom.',
                    'data' => $dataHomologadoChart,
                    'backgroundColor' => '#DC2626',
                    'borderRadius' => 2,
                ]
            ]
        ];

        // Enviamos eventos separados para cada gráfica (Asegúrate que tu JS escuche 'updateLandChart1' y 'updateLandChart2')
        $this->dispatch('updateLandChart1', [['data' => $chartData1]]);
        $this->dispatch('updateLandChart2', [['data' => $chartData2]]);
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
            'Unidades', 'Sin decimales' => round($valor, 0), // Redondear a la unidad más cercana (0 decimales)
            'Decenas' => round($valor / 10) * 10,
            'Centenas' => round($valor / 100) * 100,
            'Miles' => round($valor / 1000) * 1000,
            'Sin redondeo' => $valor, // Dejar el valor tal cual (sin redondear)
            default => round($valor / 10) * 10,
        };
    }

    private function resetConclusionProperties()
    {
        $this->conclusion_promedio_oferta = '0.00';
        $this->conclusion_valor_unitario_homologado_promedio = '0.00';
        $this->conclusion_factor_promedio = '0.0000';
        // Reset de las demás propiedades para asegurar limpieza
        $this->conclusion_maximo_oferta = '0.00';
        $this->conclusion_minimo_oferta = '0.00';
        $this->conclusion_diferencia_oferta = '0.00';
        $this->conclusion_maximo_homologado = '0.00';
        $this->conclusion_minimo_homologado = '0.00';
        $this->conclusion_diferencia_homologado = '0.00';
        $this->conclusion_desviacion_estandar_oferta = '0.00';
        $this->conclusion_coeficiente_variacion_oferta = '0.00';
        $this->conclusion_desviacion_estandar_homologado = '0.00';
        $this->conclusion_coeficiente_variacion_homologado = '0.00';
        $this->conclusion_valor_unitario_lote_tipo = '$0.00';
    }

    private function getEmptyChartData(): array
    {
        return ['labels' => [], 'datasets' => []];
    }

    private function getStatsChartData(): array
    {
        // Enviar datos dinámicos de la conclusión (ej. promedios) si se requiere la gráfica de stats
        $valoresOferta = $this->comparables->pluck('comparable_offers')->map(fn($v) => (float)$v);
        $valoresHomologados = $this->comparables->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['valor_homologado'] ?? 0));

        return [
            'labels' => $this->comparables->pluck('id')->map(fn($id) => "C$id")->values()->toArray(),
            'datasets' => [
                [
                    'label' => 'Oferta',
                    'data' => $valoresOferta->values()->toArray(),
                    'borderColor' => '#3b82f6', // blue-500
                ],
                [
                    'label' => 'Homologado',
                    'data' => $valoresHomologados->values()->toArray(),
                    'borderColor' => '#10b981', // emerald-500
                ]
            ]
        ];
    }

    // ==========================================================
    // == MÉTODOS AUXILIARES FALTANTES (AGREGADOS)
    // ==========================================================

    /**
     * Obtiene el ID primario de la tabla pivote de terreno.
     */
    private function getPivotIdForComparable($comparableId)
    {
        return ValuationLandComparableModel::where('valuation_id', $this->idValuation)
            ->where('comparable_id', $comparableId)
            ->value('id');
    }

    /**
     * Sincroniza los cambios de nombre o sigla de un factor Sujeto.
     */
    private function syncComparableFactorNames($originalAcronym, $field, $newValue)
    {
        $pivotIds = $this->valuation->landComparablePivots()->pluck('id');
        if ($pivotIds->isEmpty()) return;

        $dbCol = ($field === 'factor_name') ? 'factor_name' : 'acronym';

        HomologationComparableFactorModel::whereIn('valuation_land_comparable_id', $pivotIds)
            ->where('acronym', $originalAcronym)
            ->where('homologation_type', 'land')
            ->update([$dbCol => $newValue]);
    }


    public function render()
    {
        return view('livewire.forms.homologation-lands');
    }
}
