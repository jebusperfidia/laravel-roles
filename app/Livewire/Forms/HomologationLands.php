<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Flux\Flux;
use Masmerise\Toaster\Toaster;
use App\Models\Valuations\Valuation;
use App\Models\Forms\Comparable\ComparableModel;
use App\Models\Forms\UrbanFeatures\UrbanFeaturesModel;
use App\Models\Forms\Comparable\ValuationLandComparableModel;
use App\Models\Forms\ApplicableSurface\ApplicableSurfaceModel;
use App\Models\Forms\LandDetails\LandDetailsModel;
use App\Models\Forms\Homologation\HomologationComparableFactorModel;
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationLandAttributeModel;
use Masmerise\Toaster\Toast;

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
    public $subject_cus = '0.00';
    public $subject_cos = '0.00';
    public $subject_lote_moda = '0.00';

    // --- ESTRUCTURAS DE DATOS ---
    public array $comparableFactors = [];
    public array $subject_factors_ordered = [];
    public ?array $fneg_factor_meta = null;

    // Opciones para Selects (YA NO SE USAN, PERO SE DEJAN POR SI ACASO)
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

    // Dispersión
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

    public $selectedSurfaceDescription = 'Seleccione superficie...';

    // --- VARIABLES PARA SELECT DINÁMICO DE SUPERFICIE ---
    public $applicableSurface;
    public string $selectedSurfaceOptionId = '';
    public float $subject_actual_surface = 1.0;

    // --- VARIABLES PARA CÁLCULO FCUS (Nuevas) ---
    public float $subject_max_levels = 1.0;
    public float $subject_free_area = 0.0;

    // --- Obtener valores de caracteristicas urbanas ----
    public $urbanFeatures;

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

    #[Computed]
    public function surfaceOptions(): array
    {
        $options = [];
        $appSurf = $this->applicableSurface;

        if (!$appSurf) return $options;

        // 1. Total del terreno
        $area = (float) $appSurf->surface_area;
        $options['surface_area'] = [
            'area' => $area,
            'description' => 'Total del terreno',
            'formatted' => number_format($area, 2, '.', ',') . ' m²'
        ];

        // 2. Lote Privativo y Tipo
        if ($this->useExcessCalculation) {
            $area = (float) $appSurf->private_lot;
            $options['private_lot'] = [
                'area' => $area,
                'description' => 'Lote privativo',
                'formatted' => number_format($area, 2, '.', ',') . ' m²'
            ];

            $area = (float) $appSurf->private_lot_type;
            $options['private_lot_type'] = [
                'area' => $area,
                'description' => 'Lote privativo tipo',
                'formatted' => number_format($area, 2, '.', ',') . ' m²'
            ];

            $area = (float) $appSurf->surplus_land_area;
            $options['surplus_land_area'] = [
                'area' => $area,
                'description' => 'Sup. terreno excedente',
                'formatted' => number_format($area, 2, '.', ',') . ' m²'
            ];
        }

        // 3. Terreno Proporcional
        if (stripos($this->propertyType, 'condominio') !== false) {
            $area = (float) $appSurf->proporcional_land;
            $options['proporcional_land'] = [
                'area' => $area,
                'description' => 'Terreno proporcional',
                'formatted' => number_format($area, 2, '.', ',') . ' m²'
            ];
        }

        return $options;
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

        // 1. Carga de datos base (LandDetails y ApplicableSurface)
        $this->landDetail = LandDetailsModel::find($this->idValuation);
        $this->useExcessCalculation = (bool)($this->landDetail->use_excess_calculation ?? false);
        $this->applicableSurface = ApplicableSurfaceModel::where('valuation_id', $this->idValuation)->first();

        // 2. SINCRONIZACIÓN Y CARGA DE ATRIBUTOS
        $this->loadLandAttributes();

        // 3. Cargar Comparables y Factores
        $this->loadComparables();

        if ($this->comparablesCount > 0) {
            $this->prepareSubjectFactorsForView();
            $this->loadAllComparableFactors();
            $this->selectedForStats = $this->comparables->pluck('id')->toArray();
            $this->currentPage = 1;
            $this->updateComparableSelection();
            $this->recalculateConclusions();
        }
    }

    private function abortComponent()
    {
        $this->comparables = collect();
        $this->comparablesCount = 0;
        $this->resetConclusionProperties();
    }

    // ==========================================================
    // == CARGA Y SINCRONIZACIÓN DE ATRIBUTOS
    // ==========================================================
    private function loadLandAttributes()
    {
        $this->urbanFeatures = UrbanFeaturesModel::where('valuation_id', $this->idValuation)->first();

        $newCus = 0.0;
        $newCos = 0.0;
        $freeAreaPercent = 0.0;

        if ($this->urbanFeatures) {
            $newCus = (float)($this->urbanFeatures->land_coefficient_area ?? 0);
            $mandatoryFreeArea = (float)($this->urbanFeatures->mandatory_free_area ?? 0);
            $newCos = 100.0 - $mandatoryFreeArea;
            $freeAreaPercent = $mandatoryFreeArea;
        }

        $attributes = HomologationLandAttributeModel::updateOrCreate(
            ['valuation_id' => $this->idValuation],
            [
                'cus' => $newCus,
                'cos' => $newCos,
            ]
        );

        $this->subject_cus = number_format($newCus, 2) . ' vsp';
        $this->subject_cos = number_format($newCos, 2) . ' %';

        $this->subject_free_area = $freeAreaPercent / 100.0;
        $this->subject_lote_moda = $attributes->mode_lot ?? '100.00';
        $this->conclusion_tipo_redondeo = $attributes->conclusion_type_rounding ?? 'DECENAS';
        $this->subject_max_levels = (float)($this->landDetail->levels ?? $this->landDetail->allowed_levels ?? 1.0);

        // FCUS Sujeto
        $fcusRating = ($newCus > 0) ? sqrt($newCus) : 1.0;

        HomologationValuationFactorModel::where('valuation_id', $this->idValuation)
            ->where('homologation_type', 'land')
            ->where('acronym', 'FCUS')
            ->update(['rating' => $fcusRating]);

        // Select de Superficie
        $savedKey = $attributes->subject_surface_option_id ?? null;
        $savedValue = (float)($attributes->subject_surface_value ?? 0);

        if ($savedKey && $savedValue > 0) {
            $this->selectedSurfaceOptionId = $savedKey;
            $this->subject_actual_surface = $savedValue;
            $options = $this->surfaceOptions();
            if (isset($options[$savedKey])) {
                $this->selectedSurfaceDescription = $options[$savedKey]['description'] . " (" . $options[$savedKey]['formatted'] . ")";
            } else {
                $this->selectedSurfaceDescription = "Valor guardado (" . number_format($savedValue, 2) . " m²)";
            }
        } elseif ($this->applicableSurface) {
            $this->selectSurfaceOption('surface_area');
        }
    }

    public function selectSurfaceOption(string $key)
    {
        $options = $this->surfaceOptions();
        $selectedOption = $options[$key] ?? null;

        if (!$selectedOption) {
            if ($key !== 'surface_area') {
                Toaster::error('Opción no válida.');
            }
            return;
        }

        $newSurfaceArea = $selectedOption['area'];

        $this->selectedSurfaceOptionId = $key;
        $this->subject_actual_surface = $newSurfaceArea;
        $this->selectedSurfaceDescription = $selectedOption['description'] . " (" . $selectedOption['formatted'] . ")";

        HomologationLandAttributeModel::updateOrCreate(
            ['valuation_id' => $this->idValuation],
            [
                'subject_surface_option_id' => $key,
                'subject_surface_value' => $newSurfaceArea
            ]
        );

        //  LOGICA DE RECARGA FORZADA
        if ($this->comparables) {
            foreach ($this->comparables->pluck('id') as $compId) {
                $this->recalculateSingleComparable($compId);
            }

            //  RECARGAR DESDE DB: Esto asegura que la vista tenga el dato nuevo
            $this->loadAllComparableFactors();

            $this->recalculateConclusions();
        }
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
    // == LÓGICA DE FACTORES
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
            // FIX: FZO y FUB ahora son 'number' igual que el resto
            'FSU', 'FCUS' => 'read_only',
            default => 'number',
        };
    }

    // ==========================================================
    // == CARGA DE FACTORES (CORREGIDA PARA SINCRONIZAR APLICABLE)
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

            //  LEEMOS EL VALOR REAL DE LA BD
            $dbApplicable = (float)($factor->applicable ?? 1.0);

            // FIX: Formateo consistente a 4 decimales para todos los factores numéricos
            $calif = number_format((float)($factor->rating ?? 1.0), 4, '.', '');

            $this->comparableFactors[$compId][$factor->acronym] = [
                'factor_id' => $factor->id,
                'calificacion' => $calif,
                'aplicable' => number_format($dbApplicable, 4, '.', ''), // Input de FNEG
                'factor_ajuste' => number_format($dbApplicable, 4, '.', ''), // 🚨 AQUÍ EL SECRETO: Inicializamos con el valor de la BD
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
            // Recalculamos para refrescar diferencias y FRE
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
            // FIX: Inicialización consistente en 1.0000
            $initialRating = '1.0000';

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
    // == UPDATED HOOKS
    // ==========================================================

    public function updatedSubjectLoteModa($value)
    {
        if ($value === '' || $value === null || !is_numeric($value) || (float)$value <= 0) {
            Toaster::error('El Lote Moda debe ser mayor a cero.');
            $old = HomologationLandAttributeModel::where('valuation_id', $this->idValuation)->value('mode_lot');
            $this->subject_lote_moda = $old ?? '100.00';
            return;
        }

        $numericValue = (float)$value;
        HomologationLandAttributeModel::updateOrCreate(
            ['valuation_id' => $this->idValuation],
            ['mode_lot' => $numericValue]
        );
        $this->subject_lote_moda = number_format($numericValue, 2, '.', '');
        Toaster::success('Lote Moda guardado.');

        // 🔄 LOGICA DE RECARGA FORZADA
        if ($this->comparables) {
            foreach ($this->comparables->pluck('id') as $compId) {
                $this->recalculateSingleComparable($compId);
            }

            // 🚨 RECARGAR DESDE DB (Borra la memoria temporal y trae la verdad absoluta)
            $this->loadAllComparableFactors();

            $this->recalculateConclusions();
        }
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

        if ($property === 'rating') {
            $this->subject_factors_ordered[$index]['rating'] = number_format((float)$valueToSave, 4, '.', '');
        }

        if ($property === 'factor_name' || $property === 'acronym') {
            $this->syncComparableFactorNames($originalAcronym, $property, $valueToSave);
            $this->prepareSubjectFactorsForView();
            $this->loadAllComparableFactors(); // Recarga aquí también
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

        $pivotId = $this->getPivotIdForComparable($comparableId);
        if (!$pivotId) return;

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
        $valid = true;
        $errorMessage = '';

        if ($property === 'calificacion') {
            // FIX: Eliminada la excepción de FZO/FUB. Ahora se valida todo.
            if ($numericValue < 0.01 || $numericValue > 2.0) {
                $valid = false;
                $errorMessage = 'La calificación debe estar entre 0.0100 y 2.0000.';
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

        // FIX: Ahora SIEMPRE formatea a 4 decimales
        $formattedValue = number_format($numericValue, 4, '.', '');

        if (isset($this->comparableFactors[$comparableId][$acronym])) {
            $this->comparableFactors[$comparableId][$acronym][$property] = $formattedValue;
        }

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
        $this->recalculateConclusions();
    }

    // ==========================================================
    // == CÁLCULOS MATEMÁTICOS (NUCLEAR + CARGA SEGURA)
    // ==========================================================

    private function persistAutomaticFactor($comparableId, $acronym, $rating, $applicable)
    {
        $pivotId = $this->getPivotIdForComparable($comparableId);
        if (!$pivotId) return null;

        $subjectFactor = collect($this->subject_factors_ordered)->firstWhere('acronym', $acronym);
        $factorName = $subjectFactor['factor_name'] ?? $acronym;

        return HomologationComparableFactorModel::updateOrCreate(
            [
                'valuation_land_comparable_id' => $pivotId,
                'acronym' => $acronym,
                'homologation_type' => 'land'
            ],
            [
                'factor_name' => $factorName,
                'rating' => $rating,
                'applicable' => $applicable
            ]
        );
    }

    public function recalculateSingleComparable($comparableId)
    {
        // 1. PREPARACIÓN DE DATOS
        // Esto YA trae los factores del sujeto ordenados y con su rating (incluyendo FNEG)
        $allFactors = $this->orderedComparableFactorsForView;

        // Limpieza del lote moda (para FSU)
        $subjectLoteModa = (float) str_replace(',', '', (string)$this->subject_lote_moda);

        // --- ELIMINAMOS EL MAPEO REDUNDANTE DE $subjectRatings ---
        // No es necesario crear un map auxiliar, ya tienes el rating en $allFactors.

        if (!isset($this->comparableFactors[$comparableId])) return;

        // BÚSQUEDA DEL PIVOTE (Se mantiene igual)
        $pivotId = ValuationLandComparableModel::where('valuation_id', (int)$this->idValuation)
            ->where('comparable_id', (int)$comparableId)
            ->value('id');

        if (!$pivotId) return;

        $comparableModel = $this->comparables->find($comparableId);
        $factorResultante = 1.0;

        foreach ($allFactors as $factor) {
            $sigla = $factor['acronym'];

            // Inicializar si no existe en el array del comparable
            if (!isset($this->comparableFactors[$comparableId][$sigla])) {
                $this->initializeComparableFactor($comparableId, $sigla);
            }

            $factorData = $this->comparableFactors[$comparableId][$sigla];

            // =========================================================
            // 🔥 AQUÍ ESTÁ EL FIX: OBTENER RATING DIRECTO DEL LOOP 🔥
            // =========================================================
            // Ya no buscamos en $subjectRatings. El $factor actual YA es el factor del sujeto.
            $sujetoRating = (float)($factor['rating'] ?? 1.0);

            // Aseguramos que FNEG sea siempre 1.0 base
            if ($sigla === 'FNEG') {
                $sujetoRating = 1.0;
            }

            $compRating = (float)($factorData['calificacion'] ?? 1.0) ?: 1.0;
            $factor_ajuste = 1.0;
            $diferencia_math = 0.0;
            $ratingCalculatedAutomatically = null;

            // =========================================================
            // === LÓGICA ESPECÍFICA POR FACTOR (Se mantiene igual) ===
            // =========================================================

            if ($sigla === 'FSU') {
                // ... (Tu lógica FSU intacta)
                $rawSurface = $comparableModel->comparable_land_area ?? 0;
                $compSurface = (float) str_replace(',', '', (string)$rawSurface);

                if ($subjectLoteModa > 0 && $compSurface > 0) {
                    $coeficiente = $compSurface / $subjectLoteModa;
                    $compRating = pow($coeficiente, (1 / 12));
                } else {
                    $compRating = 1.0;
                }
                $ratingCalculatedAutomatically = $compRating;
                $diferencia_math = $sujetoRating - $compRating;
                $factor_ajuste = $diferencia_math + 1.0;
            } elseif ($sigla === 'FCUS') {
                // ... (Tu lógica FCUS intacta)
                $niveles = (float)($comparableModel->comparable_allowed_levels ?? $comparableModel->comparable_max_levels ?? 0);
                $areaLibre = (float)($comparableModel->comparable_free_area_required ?? $comparableModel->comparable_free_area ?? 0);
                $areaLibreDec = ($areaLibre > 1) ? ($areaLibre / 100) : $areaLibre;

                $cusCalculado = $niveles * (1 - $areaLibreDec);
                $compRating = ($cusCalculado > 0) ? sqrt($cusCalculado) : 1.0;
                $ratingCalculatedAutomatically = $compRating;
                $diferencia_math = $sujetoRating - $compRating;
                $factor_ajuste = $diferencia_math + 1.0;
            } elseif ($sigla === 'FNEG') {
                // FNEG usa directo el aplicable
                $factor_ajuste = (float)($factorData['aplicable'] ?? 1.0);
                $diferencia_math = $factor_ajuste - 1.0;
            } else {
                // GENÉRICOS
                $diferencia_math = $sujetoRating - $compRating;
                $factor_ajuste = $diferencia_math + 1.0;
            }

            // =========================================================
            // === ACTUALIZACIÓN MEMORIA Y BD ===
            // =========================================================

            $factorData['diferencia'] = number_format($diferencia_math, 4, '.', '');
            $factorData['factor_ajuste'] = number_format($factor_ajuste, 4, '.', '');
            $factorData['aplicable'] = number_format($factor_ajuste, 4, '.', '');

            if ($ratingCalculatedAutomatically !== null) {
                $factorData['calificacion'] = number_format($ratingCalculatedAutomatically, 4, '.', '');
            }

            $this->comparableFactors[$comparableId][$sigla] = $factorData;
            $factorResultante *= $factor_ajuste;

            // ... (Tu lógica de guardado en DB se mantiene igual)
            $dataToSave = [
                'applicable' => $factor_ajuste,
                'factor_name' => $factor['factor_name'] ?? $sigla
            ];

            if ($ratingCalculatedAutomatically !== null) {
                $dataToSave['rating'] = $ratingCalculatedAutomatically;
            }

            // Guardado silencioso
            try {
                HomologationComparableFactorModel::updateOrCreate(
                    [
                        'valuation_land_comparable_id' => $pivotId,
                        'acronym' => $sigla,
                        'homologation_type' => 'land'
                    ],
                    $dataToSave
                );
            } catch (\Exception $e) {
            }
        }

        // FRE FINAL
        $unitValue = (float)($comparableModel->comparable_unit_value ?? 0);
        $this->comparableFactors[$comparableId]['FRE']['factor_ajuste'] = number_format($factorResultante, 4, '.', '');
        $this->comparableFactors[$comparableId]['FRE']['valor_homologado'] = $unitValue * $factorResultante;
    }

    public function recalculateConclusions()
    {
        // 1. VALIDACIONES DE SEGURIDAD
        if (!$this->comparables || $this->comparables->isEmpty()) {
            $this->resetConclusionProperties();
            return;
        }

        // 2. FILTRADO (Si hay selección específica para estadísticas)
        $selectedComparables = empty($this->selectedForStats)
            ? $this->comparables
            : $this->comparables->whereIn('id', $this->selectedForStats);

        if ($selectedComparables->isEmpty()) {
            $this->resetConclusionProperties();
            return;
        }

        // --------------------------------------------------------
        // 3. EXTRACCIÓN DE DATOS Y MATEMÁTICA (RESTITUIDO)
        // --------------------------------------------------------

        // Recalcular individualmente para asegurar frescura de datos
        foreach ($selectedComparables->pluck('id') as $compId) {
            $this->recalculateSingleComparable($compId);
        }

        // Extraer colecciones para cálculos
        $valoresOferta = $selectedComparables->pluck('comparable_unit_value')->map(fn($v) => (float)$v);
        $valoresHomologados = $selectedComparables->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['valor_homologado'] ?? 0));
        $factoresFRE = $selectedComparables->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['factor_ajuste'] ?? 0));

        // Calcular Promedios y Desviaciones (Helpers)
        $avgOferta = $valoresOferta->avg();
        $stdDevOferta = $this->std_deviation($valoresOferta);

        $avgHomologado = $valoresHomologados->avg();
        $stdDevHomologado = $this->std_deviation($valoresHomologados);

        $avgFRE = $factoresFRE->avg();

        // --------------------------------------------------------
        // 4. ASIGNACIÓN A VARIABLES DE LA VISTA (RESTITUIDO)
        // --------------------------------------------------------

        // Resumen Principal
        $this->conclusion_promedio_oferta = $this->format_currency($avgOferta, false);
        $this->conclusion_valor_unitario_homologado_promedio = $this->format_currency($avgHomologado, false);
        $this->conclusion_factor_promedio = number_format($avgFRE, 4);

        // Estadísticas Oferta
        $this->conclusion_media_aritmetica_oferta = $this->format_currency($avgOferta, false);
        $this->conclusion_maximo_oferta = $this->format_currency($valoresOferta->max());
        $this->conclusion_minimo_oferta = $this->format_currency($valoresOferta->min());
        $this->conclusion_diferencia_oferta = $this->format_currency($valoresOferta->max() - $valoresOferta->min());
        $this->conclusion_desviacion_estandar_oferta = number_format($stdDevOferta, 2);
        $this->conclusion_coeficiente_variacion_oferta = ($avgOferta > 0) ? number_format(($stdDevOferta / $avgOferta) * 100, 2) : '0.00';

        // Estadísticas Homologado
        $this->conclusion_media_aritmetica_homologado = $this->format_currency($avgHomologado, false);
        $this->conclusion_maximo_homologado = $this->format_currency($valoresHomologados->max());
        $this->conclusion_minimo_homologado = $this->format_currency($valoresHomologados->min());
        $this->conclusion_diferencia_homologado = $this->format_currency($valoresHomologados->max() - $valoresHomologados->min());
        $this->conclusion_desviacion_estandar_homologado = number_format($stdDevHomologado, 2);
        $this->conclusion_coeficiente_variacion_homologado = ($avgHomologado > 0) ? number_format(($stdDevHomologado / $avgHomologado) * 100, 2) : '0.00';

        // Placeholders de UI
        $this->conclusion_promedio_factor2_placeholder = '0.0000';
        $this->conclusion_promedio_ajuste_pct_placeholder = '100.00%';
        $this->conclusion_promedio_valor_final_placeholder = $this->conclusion_valor_unitario_homologado_promedio;

        // Cálculo Final con Redondeo
        $valorBase = $avgHomologado;
        $valorRedondeado = $this->redondearValor($valorBase, $this->conclusion_tipo_redondeo);
        $this->conclusion_valor_unitario_lote_tipo = $this->format_currency($valorRedondeado, true);

        // Guardar valor final en BD
        HomologationLandAttributeModel::updateOrCreate(
            ['valuation_id' => $this->idValuation],
            ['unit_value_mode_lot' => $valorRedondeado]
        );

        // --------------------------------------------------------
        // 5. PREPARACIÓN DE GRÁFICAS (Versión "Bonita" con línea y barras)
        // --------------------------------------------------------

        // Datos para gráficas
        $labels = $selectedComparables->pluck('id')->map(fn($id) => "C-$id")->values()->toArray();
        $dataOfertaChart = $valoresOferta->values()->toArray();
        $dataHomologadoChart = $valoresHomologados->values()->toArray();

        // GRÁFICA 1: MIXTA (Arriba)
        $chartData1 = [
            'labels' => $labels,
            'datasets' => [
                [
                    'type' => 'line',
                    'label' => 'Valor Homologado', // Línea Roja
                    'data' => $dataHomologadoChart,
                    'borderColor' => '#DC2626', // Rojo
                    'backgroundColor' => '#DC2626',
                    'borderWidth' => 2,
                    'pointRadius' => 4, // Puntos visibles
                    'pointBackgroundColor' => '#DC2626',
                    'fill' => false,
                    'tension' => 0.1,
                    'order' => 0, // Dibuja la línea ENCIMA de las barras
                ],
                [
                    'type' => 'bar',
                    'label' => 'Valor Oferta', // Barras Azules/Verdes
                    'data' => $dataOfertaChart,
                    'backgroundColor' => '#14B8A6', // Teal
                    'borderColor' => '#14B8A6',
                    'borderWidth' => 1,
                    'order' => 1,
                ]
            ]
        ];

        // GRÁFICA 2: SOLO BARRAS ROJAS (Abajo)
        $chartData2 = [
            'labels' => $labels,
            'datasets' => [
                [
                    'type' => 'bar',
                    'label' => 'Valor Unit. Hom.',
                    'data' => $dataHomologadoChart,
                    'backgroundColor' => '#DC2626', // Rojo
                    'borderRadius' => 4,
                    'barPercentage' => 0.6,
                ]
            ]
        ];

        // Disparo de eventos (Usando sintaxis PHP 8 named arguments que tenías en la versión A)
        $this->dispatch('updateLandChart1', data: $chartData1);
        $this->dispatch('updateLandChart2', data: $chartData2);
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
            'Unidades', 'Sin decimales' => round($valor, 0),
            'Decenas' => round($valor / 10) * 10,
            'Centenas' => round($valor / 100) * 100,
            'Miles' => round($valor / 1000) * 1000,
            'Sin redondeo' => $valor,
            default => round($valor / 10) * 10,
        };
    }

    private function resetConclusionProperties()
    {
        $this->conclusion_promedio_oferta = '0.00';
        $this->conclusion_valor_unitario_homologado_promedio = '0.00';
        $this->conclusion_factor_promedio = '0.0000';
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
        return $this->getEmptyChartData();
    }

    private function getPivotIdForComparable($comparableId)
    {
        return ValuationLandComparableModel::where('valuation_id', $this->idValuation)
            ->where('comparable_id', $comparableId)
            ->value('id');
    }

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

    private function calculateFCUSRating($levels, $freeArea)
    {
        $levels = (float)$levels;
        $freeArea = (float)$freeArea;

        if ($freeArea > 1) {
            $freeArea = $freeArea / 100;
        }

        if ($levels <= 0) return 1.0;

        $term = $levels * (1 - $freeArea);

        if ($term <= 0) return 0.0;

        return sqrt($term);
    }

    public function openComparablesLand()
    {
        Session::put('comparables-active-session', true);
        Session::put('comparable-type', 'land');
        return redirect()->route('form.comparables.index');
    }


    public function render()
    {
        return view('livewire.forms.homologation-lands');
    }
}
