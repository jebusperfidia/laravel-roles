<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Flux\Flux;
use Masmerise\Toaster\Toaster;
use App\Models\Valuations\Valuation;

// Modelos
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationComparableFactorModel;
use App\Models\Forms\Homologation\HomologationValuationEquipmentModel;
use App\Models\Forms\Homologation\HomologationComparableEquipmentModel;
use App\Models\Forms\Building\BuildingModel;

class HomologationBuildings extends Component
{
    // --- PROPIEDADES INICIALES ---
    public $idValuation;
    public $valuation;
    public $comparables;
    public $comparablesCount = 0;

    // --- ARRAYS DE DATOS ---
    public array $subject_factors_ordered = [];
    public ?array $fneg_factor_meta = null;
    public array $comparableFactors = [];

    // --- EDICIÓN SUJETO (FACTORES) ---
    public $editing_factor_index = null;
    public $edit_factor_name;
    public $edit_factor_acronym;
    public $edit_factor_rating;

    // --- INPUTS NUEVO FACTOR CUSTOM ---
    public $new_factor_name = '';
    public $new_factor_acronym = '';
    public $new_factor_rating = '';

    // --- PAGINACIÓN ---
    public $currentPage = 1;
    public $selectedComparableId;
    public $selectedComparable;

    // --- CONCLUSIONES ---
    public array $selectedForStats = [];
    public string $conclusion_promedio_oferta = '0.00';
    public string $conclusion_valor_unitario_homologado_promedio = '0.00';
    public string $conclusion_factor_promedio = '0.0000';

    // Placeholders UI
    public string $conclusion_promedio_factor2_placeholder = '0.0000';
    public string $conclusion_promedio_ajuste_pct_placeholder = '0.00%';
    public string $conclusion_promedio_valor_final_placeholder = '0.00';

    // Estadísticas
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

    // --- EQUIPAMIENTO ---
    public $subjectEquipments = [];
    public $currentComparableEquipments = [];

    // Variables Equipamiento CRUD
    public $new_eq_description = '';
    public $new_eq_quantity = 1.00;
    public $new_eq_total_value = 0.00;
    public $new_eq_other_description = '';
    public $editing_eq_id = null;
    public $edit_eq_quantity = 0.00;
    public $edit_eq_total_value = 0.00;
    public $edit_eq_other_description = '';


    //Variables para valores de construcciones
    public $building;
    public $subject_surface_construction = 0; // Superficie total construida
    public $subject_surface_land = 0;         // Superficie terreno (para Rel T/C)
    public $subject_age_weighted = 0;         // Edad Ponderada
    public $subject_vut_weighted = 0;         // Vida Útil Total Ponderada
    public $subject_vur_weighted = 0;         // Vida Útil Remanente Ponderada
    public $subject_rel_tc = 0;               // Relación Terreno / Construcción
    public $subject_progress_work = 0;        // Avance de obra (Directo de BD)


    public const EQUIPMENT_MAP = [
        'Baño completo' => ['unit' => 'PZA', 'value' => 16768.00],
        'Medio baño' => ['unit' => 'PZA', 'value' => 9396.00],
        'Cocina integral' => ['unit' => 'PZA', 'value' => 38000.00],
        'Estacionamiento cubierto para dpto.' => ['unit' => 'Cajón', 'value' => 80000.00],
        'Estacionamiento desubierto para dpto.' => ['unit' => 'Cajón', 'value' => 40000.00],
        'Terraza' => ['unit' => 'M2', 'value' => 3375.00],
        'Balcon' => ['unit' => 'M2', 'value' => 1687.00],
        'Acabados' => ['unit' => 'M2', 'value' => 1360.00],
        'Elevador' => ['unit' => '%', 'value' => 0.01],
        'Roof garden' => ['unit' => 'M2', 'value' => 4121.00],
        'Otro' => ['unit' => 'PZA', 'value' => 0.00],
    ];

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
        if (!$this->comparables) return $this->getEmptyChartData();
        $selected = $this->comparables->whereIn('id', $this->selectedForStats)->values();
        if ($selected->isEmpty()) return $this->getEmptyChartData();

        $labels = $selected->pluck('id')->map(fn($id) => "Comp. " . $id)->toArray();
        $homologated = $selected->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['valor_homologado'] ?? 0))->toArray();
        $oferta = $selected->pluck('comparable_offers')->map(fn($v) => (float)$v)->toArray();

        return [
            'labels' => $labels,
            'homologated' => $homologated,
            'oferta' => $oferta,
            'coeficiente_variacion_oferta' => (float)str_replace(['%', ','], ['', '.'], $this->conclusion_coeficiente_variacion_oferta),
            'coeficiente_variacion_homologado' => (float)str_replace(['%', ','], ['', '.'], $this->conclusion_coeficiente_variacion_homologado)
        ];
    }

    public function mount()
    {
        $this->idValuation = Session::get('valuation_id');
        $this->valuation = Valuation::find($this->idValuation);

        if (!$this->valuation) {
            $this->comparables = collect();
            return;
        }

        try {
            $this->comparables = $this->valuation->buildingComparables()->orderByPivot('position')->get();
        } catch (\Throwable $e) {
            $this->comparables = collect();
        }


        $this->building = BuildingModel::where('valuation_id', $this->idValuation)->first();

        //dd($this->building);

        $this->calculateSubjectValues();



        $this->comparablesCount = $this->comparables->count();

        $this->prepareSubjectFactorsForView();

        if ($this->comparablesCount > 0) {
            $this->currentPage = 1;
            $this->loadAllComparableFactors();
            $this->updateComparableSelection();
        }

        $this->selectedForStats = $this->comparables->pluck('id')->toArray();
        $this->recalculateConclusions();
    }




    public function calculateSubjectValues()
    {
        // A. Obtener el modelo Building con sus construcciones privadas
        // Asegúrate de tener cargada la relación 'privates'
        // $this->building ya debería estar definido en tu mount()



        $building = $this->building;

        if (!$building) return;

        // B. Obtener valor directo de BD (Avance de obra)
        $this->subject_progress_work = $building->progress_general_works ?? 0;

        // C. Cargar construcciones privadas
        $constructions = $building->privates()->get();

        if ($constructions->isEmpty()) {
            return; // Si no hay construcciones, todo se queda en 0
        }

        // D. Inicializar acumuladores para ponderación
        $totalSurface = 0;
        $weightedAgeAccumulator = 0;
        $weightedVUTAccumulator = 0;

        // E. Obtener catálogo de vidas útiles (igual que en Buildings.php)
        $lifeValuesConfig = config('properties_inputs.construction_life_values', []);

        // F. Iterar y calcular (Lógica calcada de Buildings.php -> loadPrivateConstructions)
        foreach ($constructions as $item) {
            $surface = $item->surface;

            // 1. Vida Útil Total (VUT) basada en Clasificación y Uso
            $claveCombinacion = $item->clasification . '_' . $item->use;
            $vutItem = $lifeValuesConfig[$claveCombinacion] ?? 0;

            // 2. Acumular Ponderados
            $totalSurface += $surface;
            $weightedAgeAccumulator += ($item->age * $surface);
            $weightedVUTAccumulator += ($vutItem * $surface);
        }

        // G. Calcular Promedios Finales
        if ($totalSurface > 0) {
            $this->subject_surface_construction = $totalSurface;
            $this->subject_age_weighted = $weightedAgeAccumulator / $totalSurface;
            $this->subject_vut_weighted = $weightedVUTAccumulator / $totalSurface;

            // VUR = VUT - Edad
            $this->subject_vur_weighted = max($this->subject_vut_weighted - $this->subject_age_weighted, 0);
        }

        // H. Calcular Relación Terreno / Construcción (Rel. T/C)
        // Necesitamos la superficie del terreno. Asumo que tienes el modelo $valuation cargado.
        // Ajusta 'land_surface' al nombre real de tu campo en la tabla de Terrenos (LandModel)

        // OPCION 1: Si tienes relación directa valuation->land
        $landSurface = $this->valuation->land->surface ?? 0;
        // OPCION 2: Si necesitas buscarlo manual
        // $land = \App\Models\Forms\Land\LandModel::where('valuation_id', $this->valuation->id)->first();
        // $landSurface = $land->surface ?? 0;

        $this->subject_surface_land = $landSurface;

        if ($this->subject_surface_construction > 0) {
            // Relación = Terreno / Construcción (A veces es al revés Const/Terr, valida tu criterio)
            // Usualmente en avalúos es: Cuántas veces cabe el terreno en la construcción o viceversa.
            // Fórmula estándar CUV: Superficie Construida / Superficie Terreno (CUS)
            // Fórmula Relación T/C (Market Approach): Superficie Terreno / Superficie Construida

            // Voy a usar: Terreno / Construcción (ajusta si tu criterio es inverso)
            $this->subject_rel_tc = $this->subject_surface_land / $this->subject_surface_construction;
        }
    }


    private function prepareSubjectFactorsForView(): void
    {
        $allFactors = HomologationValuationFactorModel::where('valuation_id', $this->idValuation)
            ->where('homologation_type', 'building')
            ->get();

        $this->fneg_factor_meta = [
            'id' => null,
            'factor_name' => 'Factor Negociación',
            'acronym' => 'FNEG',
            'code' => 'FNEG',
            'rating' => '1.0000',
            'is_custom' => false,
            'can_edit' => false,
        ];

        $systemOrder = ['FSU', 'FIC', 'FEQ', 'FEDAC', 'FLOC', 'AVANC'];
        $systemEditableInSubject = ['FEQ', 'FLOC'];

        $orderedList = [];

        $formatFactor = function ($factor) use ($systemEditableInSubject) {
            $canEditSubject = $factor->is_custom || in_array($factor->acronym, $systemEditableInSubject);
            return [
                'id' => $factor->id,
                'factor_name' => $factor->factor_name,
                'label' => $factor->factor_name,
                'acronym' => $factor->acronym,
                'code' => $factor->acronym,
                'rating' => number_format((float)$factor->rating, 4, '.', ''),
                'is_custom' => (bool)$factor->is_custom,
                'can_edit' => $canEditSubject,
            ];
        };

        foreach ($systemOrder as $acronym) {
            $f = $allFactors->firstWhere('acronym', $acronym);
            if ($f) {
                $orderedList[] = $formatFactor($f);
            }
        }

        foreach ($allFactors as $factor) {
            if (!in_array($factor->acronym, $systemOrder) && $factor->acronym !== 'FNEG') {
                $orderedList[] = $formatFactor($factor);
            }
        }

        $this->subject_factors_ordered = $orderedList;
    }

    private function loadAllComparableFactors()
    {
        $this->comparableFactors = [];
        if ($this->comparables->isEmpty()) return;

        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');
        $factors = HomologationComparableFactorModel::whereIn('valuation_building_comparable_id', $pivotIds)
            ->where('homologation_type', 'building')
            ->get();

        $pivotMap = $this->valuation->buildingComparablePivots->pluck('comparable_id', 'id')->toArray();

        foreach ($factors as $factor) {
            $compId = $pivotMap[$factor->valuation_building_comparable_id] ?? null;
            if (!$compId) continue;

            $this->initializeComparableFactorStructure($compId, $factor->acronym);

            $this->comparableFactors[$compId][$factor->acronym]['calificacion'] = number_format((float)($factor->rating ?? 1.0), 4, '.', '');
            // AQUÍ ESTABA EL ERROR: El FEQ guardado no se leía correctamente si venía de equipamiento
            $this->comparableFactors[$compId][$factor->acronym]['aplicable'] = number_format((float)($factor->applicable ?? 1.0), 4, '.', '');
        }

        $allFactors = $this->orderedComparableFactorsForView;
        foreach ($this->comparables as $comparable) {
            foreach ($allFactors as $mf) {
                $this->initializeComparableFactorStructure($comparable->id, $mf['acronym']);
            }
            $this->initializeExtraDefaults($comparable->id, $comparable);
            $this->recalculateSingleComparable($comparable->id);
        }
    }

    private function initializeComparableFactorStructure($comparableId, $acronym)
    {
        if (!isset($this->comparableFactors[$comparableId])) {
            $this->comparableFactors[$comparableId] = [];
        }
        if (!isset($this->comparableFactors[$comparableId]['FRE'])) {
            $this->comparableFactors[$comparableId]['FRE'] = [
                'factor_ajuste' => '1.0000',
                'valor_homologado' => '0.00',
                'valor_unitario_vendible' => '0.00'
            ];
        }

        if (!isset($this->comparableFactors[$comparableId][$acronym])) {
            $this->comparableFactors[$comparableId][$acronym] = [
                'calificacion' => '1.0000',
                'aplicable' => ($acronym === 'FNEG') ? '0.9000' : '1.0000',
                'factor_ajuste' => '1.0000',
                'diferencia' => '0.0000',
            ];
        }
    }

    private function initializeExtraDefaults($comparableId, $comparableModel)
    {
        $defaults = [
            'clase' => 'Clase B',
            'clase_factor' => '1.0000',
            'conservacion' => 'Buena',
            'conservacion_factor' => '1.0000',
            'localizacion' => 'Lote intermedio',
            'localizacion_factor' => '1.0000',
            'url' => $comparableModel->comparable_source ?? 'http://valua.me/...'
        ];
        foreach ($defaults as $key => $val) {
            if (!isset($this->comparableFactors[$comparableId][$key])) {
                $this->comparableFactors[$comparableId][$key] = $val;
            }
        }
    }

    public function updatedComparableFactors($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) < 3) return;

        $comparableId = array_shift($parts);
        $property = array_pop($parts);
        $acronym = implode('.', $parts);

        $pivotId = $this->valuation->buildingComparablePivots()->where('comparable_id', $comparableId)->value('id');

        if ($value === '' || $value === null) {
            Toaster::error('El valor no puede estar vacío.');
            $this->revertToOldValue($comparableId, $acronym, $property, $pivotId);
            return;
        }

        $numericValue = (float)$value;
        $valid = true;
        $errorMessage = '';

        if ($property === 'calificacion') {
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
            $this->revertToOldValue($comparableId, $acronym, $property, $pivotId);
            return;
        }

        $formattedValue = number_format($numericValue, 4, '.', '');
        if (isset($this->comparableFactors[$comparableId][$acronym])) {
            $this->comparableFactors[$comparableId][$acronym][$property] = $formattedValue;
        }

        if ($pivotId) {
            $dbColumn = match ($property) {
                'calificacion' => 'rating',
                'aplicable' => 'applicable',
                default => null
            };
            if ($dbColumn) {
                $subjectFactor = collect($this->subject_factors_ordered)->firstWhere('acronym', $acronym);
                $factorName = ($acronym === 'FNEG') ? 'Factor Negociación' : ($subjectFactor['factor_name'] ?? $acronym);

                HomologationComparableFactorModel::updateOrCreate(
                    ['valuation_building_comparable_id' => $pivotId, 'acronym' => $acronym, 'homologation_type' => 'building'],
                    [$dbColumn => $numericValue, 'factor_name' => $factorName]
                );
            }
        }

        $this->recalculateSingleComparable($comparableId);
        $this->recalculateConclusions();
        Toaster::success('Factor guardado.');
    }

    private function revertToOldValue($comparableId, $acronym, $property, $pivotId)
    {
        if (!$pivotId) return;

        $existingFactor = HomologationComparableFactorModel::where('valuation_building_comparable_id', $pivotId)
            ->where('acronym', $acronym)
            ->where('homologation_type', 'building')
            ->first();

        $oldValue = $existingFactor ? ($property === 'calificacion' ? $existingFactor->rating : $existingFactor->applicable) : 1.0;

        if (isset($this->comparableFactors[$comparableId][$acronym])) {
            $this->comparableFactors[$comparableId][$acronym][$property] = number_format((float)$oldValue, 4, '.', '');
        }
    }

    public function toggleEditFactor($acronym, $index)
    {
        if ($this->editing_factor_index === $index) {
            $this->saveEditedFactor($index);
        } else {
            $factorData = $this->subject_factors_ordered[$index];
            $this->edit_factor_name = $factorData['factor_name'];
            $this->edit_factor_acronym = $factorData['acronym'];
            $this->edit_factor_rating = $factorData['rating'];
            $this->editing_factor_index = $index;
        }
    }

    private function saveEditedFactor($index)
    {
        $factorData = $this->subject_factors_ordered[$index];
        $factorModel = HomologationValuationFactorModel::find($factorData['id']);
        if (!$factorModel) return;

        if (empty(trim($this->edit_factor_name)) || empty(trim($this->edit_factor_acronym))) {
            Toaster::error('Campos vacíos.');
            return;
        }
        $numericRating = (float)$this->edit_factor_rating;
        if ($numericRating < 0.8 || $numericRating > 1.2) {
            Toaster::error('Rango inválido (0.8 - 1.2).');
            return;
        }

        $oldAcronym = $factorModel->acronym;
        $newAcronym = strtoupper($this->edit_factor_acronym);
        $newName = $this->edit_factor_name;

        $factorModel->update(['factor_name' => $newName, 'acronym' => $newAcronym, 'rating' => $numericRating]);

        $this->syncComparableFactorNames($oldAcronym, $newName, $newAcronym);
        $this->prepareSubjectFactorsForView();
        $this->loadAllComparableFactors();

        Toaster::success('Factor guardado.');
        $this->editing_factor_index = null;

        $this->recalculateConclusions();
    }

    public function cancelEdit()
    {
        $this->editing_factor_index = null;
    }

    // ==========================================================
    // == LÓGICA DE CÁLCULO
    // ==========================================================
    public function recalculateSingleComparable($comparableId)
    {
        $allFactors = $this->orderedComparableFactorsForView;

        $subjectRatings = collect($this->subject_factors_ordered)->keyBy('acronym')->map(fn($f) => (float)$f['rating']);
        $subjectRatings->put('FNEG', 1.0);

        if (!isset($this->comparableFactors[$comparableId])) return;

        $pivotId = $this->valuation->buildingComparablePivots()->where('comparable_id', $comparableId)->value('id');
        $comparableModel = $this->comparables->find($comparableId);
        $factorResultante = 1.0;

        // Factores Select (Clase, Conservación, Localización)
        $clase_factor = $this->mapSelectValue($this->comparableFactors[$comparableId]['clase'] ?? 'Clase B', 'clase');
        $conservacion_factor = $this->mapSelectValue($this->comparableFactors[$comparableId]['conservacion'] ?? 'Buena', 'conservacion');
        $localizacion_factor = $this->mapSelectValue($this->comparableFactors[$comparableId]['localizacion'] ?? 'Lote intermedio', 'localizacion');

        $this->comparableFactors[$comparableId]['clase_factor'] = number_format($clase_factor, 4);
        $this->comparableFactors[$comparableId]['conservacion_factor'] = number_format($conservacion_factor, 4);
        $this->comparableFactors[$comparableId]['localizacion_factor'] = number_format($localizacion_factor, 4);

        // --- LECTURA DEL FEQ DESDE BD ---
        $feqFactorAplicable = 1.0;
        if ($pivotId) {
            $dbFeq = HomologationComparableFactorModel::where('valuation_building_comparable_id', $pivotId)
                ->where('acronym', 'FEQ')
                ->where('homologation_type', 'building')
                ->first();

            if ($dbFeq) {
                $feqFactorAplicable = (float)$dbFeq->applicable;
                $this->comparableFactors[$comparableId]['FEQ']['aplicable'] = number_format($feqFactorAplicable, 4, '.', '');
            }
        }

        foreach ($allFactors as $factor) {
            $sigla = $factor['acronym'];
            if (!isset($this->comparableFactors[$comparableId][$sigla])) continue;

            $factorData = $this->comparableFactors[$comparableId][$sigla];
            $sujetoRating = $subjectRatings->get($sigla, 1.0) ?: 1.0;
            $compRating = (float)($factorData['calificacion'] ?? 1.0) ?: 1.0;

            if ($sigla === 'FIC') $compRating = $clase_factor;
            if ($sigla === 'FLOC') $compRating = $localizacion_factor;

            $aplicable = 1.0;
            $diferencia_math = 0.0;
            $rating_to_save = $compRating; // Default: usamos el rating actual

            if ($sigla === 'FNEG') {
                $aplicable = (float)($factorData['aplicable'] ?? 1.0);
                $diferencia_math = 0.0;
            } elseif ($sigla === 'FEQ') {
                // USAMOS EL VALOR REAL CALCULADO DEL EQUIPAMIENTO
                $aplicable = $feqFactorAplicable;
                $diferencia_math = $aplicable - 1.0;

                // 🔥 ASIGNAMOS EL VALOR A LA CALIFICACIÓN PARA LA VISTA Y GUARDADO
                $compRating = $feqFactorAplicable;
                $rating_to_save = $feqFactorAplicable; // <--- ¡ASIGNACIÓN PARA GUARDAR!

            } else {
                $diferencia_math = $sujetoRating - $compRating;
                $aplicable = 1.0 + $diferencia_math;
            }

            // 1. Actualizamos el array visual
            $this->comparableFactors[$comparableId][$sigla]['diferencia'] = number_format($diferencia_math, 4, '.', '');
            $this->comparableFactors[$comparableId][$sigla]['aplicable'] = number_format($aplicable, 4, '.', '');

            // 2. Si es FEQ, actualizamos la calificación en el array visual
            if ($sigla === 'FEQ') {
                $this->comparableFactors[$comparableId][$sigla]['calificacion'] = number_format($compRating, 4, '.', '');
            }

            $factorResultante *= $aplicable;

            // 3. 🔥 GUARDADO DE PERSISTENCIA PARA FEQ Y OTROS
            if ($pivotId) {
                $rating_value = ($sigla === 'FNEG') ? 1.0 : $rating_to_save;

                HomologationComparableFactorModel::updateOrCreate(
                    ['valuation_building_comparable_id' => $pivotId, 'acronym' => $sigla, 'homologation_type' => 'building'],
                    ['rating' => $rating_value, 'applicable' => $aplicable, 'factor_name' => $factor['factor_name']]
                );
            }
        }

        $factorResultante *= $conservacion_factor;

        $unitValue = (float)($comparableModel->comparable_unit_value ?? 0);
        $this->comparableFactors[$comparableId]['FRE']['factor_ajuste'] = number_format($factorResultante, 4, '.', '');
        $this->comparableFactors[$comparableId]['FRE']['valor_homologado'] = $unitValue * $factorResultante;
        $this->comparableFactors[$comparableId]['FRE']['valor_unitario_vendible'] = number_format($unitValue * $factorResultante, 2, '.', '');
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

        foreach ($selectedComparables->pluck('id') as $compId) {
            $this->recalculateSingleComparable($compId);
        }

        $valoresOferta = $selectedComparables->pluck('comparable_offers')->map('floatval');
        $valoresHomologados = $selectedComparables->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['valor_homologado'] ?? 0));
        $factoresFRE = $selectedComparables->map(fn($c) => (float)($this->comparableFactors[$c->id]['FRE']['factor_ajuste'] ?? 0));

        $avgOferta = $valoresOferta->avg();
        $avgHomologado = $valoresHomologados->avg();
        $stdDevOferta = $this->std_deviation($valoresOferta);
        $stdDevHomologado = $this->std_deviation($valoresHomologados);

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

        $valorRedondeado = $this->redondearValor($avgHomologado, $this->conclusion_tipo_redondeo);
        $this->conclusion_valor_unitario_de_venta = $this->format_currency($valorRedondeado, true);

        $this->dispatch('updateChart', data: $this->chartData);
    }

    private function syncComparableFactorNames($oldAcronym, $newName, $newAcronym)
    {
        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');
        if ($pivotIds->isEmpty()) return;
        HomologationComparableFactorModel::whereIn('valuation_building_comparable_id', $pivotIds)
            ->where('acronym', $oldAcronym)->where('homologation_type', 'building')
            ->update(['factor_name' => $newName, 'acronym' => $newAcronym]);
    }
    private function mapSelectValue(string $key, string $optionType): float
    {
        $options = ['clase' => ['Precario' => 1.7500, 'Clase B' => 1.0000, 'Clase C' => 0.8000], 'conservacion' => ['Buena' => 1.0000, 'Regular' => 0.9000, 'Mala' => 0.8000], 'localizacion' => ['Lote intermedio' => 1.0000, 'Esquina' => 1.0500]];
        return $options[$optionType][$key] ?? 1.0000;
    }
    private function getEmptyChartData(): array
    {
        return ['labels' => [], 'homologated' => [], 'oferta' => [], 'coeficiente_variacion_oferta' => 0, 'coeficiente_variacion_homologado' => 0];
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
    {
        $this->conclusion_promedio_oferta = '0.00';
        $this->conclusion_valor_unitario_homologado_promedio = '0.00';
    }

    // --- MÉTODOS PÚBLICOS DE INTERFAZ ---
    public function saveNewFactor()
    {
        $this->validate(['new_factor_name' => 'required|string|max:100', 'new_factor_acronym' => 'required|string|max:10|alpha_num', 'new_factor_rating' => 'required|numeric|min:0.8|max:1.2']);
        HomologationValuationFactorModel::create([
            'valuation_id' => $this->idValuation,
            'factor_name' => $this->new_factor_name,
            'acronym' => strtoupper($this->new_factor_acronym),
            'rating' => $this->new_factor_rating,
            'homologation_type' => 'building',
            'is_editable' => true,
            'is_custom' => true,
        ]);
        $this->reset(['new_factor_name', 'new_factor_acronym', 'new_factor_rating']);
        $this->prepareSubjectFactorsForView();
        $this->loadAllComparableFactors();
        Toaster::success('Factor agregado.');
    }
    public function deleteCustomFactor($factorId)
    {
        $factor = HomologationValuationFactorModel::find($factorId);
        if (!$factor || !$factor->is_custom) return;
        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');
        HomologationComparableFactorModel::whereIn('valuation_building_comparable_id', $pivotIds)
            ->where('acronym', $factor->acronym)->where('homologation_type', 'building')->delete();
        $factor->delete();
        $this->prepareSubjectFactorsForView();
        $this->loadAllComparableFactors();
        $this->recalculateConclusions();
        Toaster::success('Factor eliminado.');
    }
    public function gotoPage($page)
    {
        if ($page >= 1 && $page <= $this->comparablesCount) {
            $this->currentPage = $page;
            $this->updateComparableSelection();
        }
    }
    public function updateComparableSelection()
    {
        $this->comparables = $this->valuation->buildingComparables()->orderByPivot('position')->get();
        $this->comparablesCount = $this->comparables->count();
        if ($this->comparablesCount == 0) return;
        $index = $this->currentPage - 1;
        if (!$this->comparables->has($index)) {
            $this->currentPage = 1;
            $index = 0;
        }
        $this->selectedComparable = $this->comparables->get($index);
        $this->selectedComparableId = $this->selectedComparable->id;
        if ($this->selectedComparableId) {
            $this->loadEquipmentData();
            $this->recalculateSingleComparable($this->selectedComparableId);
        }
    }
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
        Session::put('comparable-type', 'building');
        return redirect()->route('form.comparables.index');
    }

    // --- LÓGICA EQUIPAMIENTO ---
    public function loadEquipmentData()
    {
        $this->subjectEquipments = HomologationValuationEquipmentModel::where('valuation_id', $this->idValuation)->get();
        if ($this->selectedComparableId) {
            $pivotId = $this->valuation->buildingComparablePivots()->where('comparable_id', $this->selectedComparableId)->value('id');
            if ($pivotId) {
                $this->currentComparableEquipments = HomologationComparableEquipmentModel::where('valuation_building_comparable_id', $pivotId)
                    ->orderBy('description')->with('subjectEquipment')->get();
                $this->calculateEquipmentFactor($pivotId);
            }
        }
    }

    public function saveNewEquipment()
    {
        $sourceKey = $this->new_eq_description;
        $isOther = ($sourceKey === 'Otro');
        $rules = ['new_eq_description' => 'required|string', 'new_eq_quantity' => 'required|numeric|min:0'];
        if ($isOther) {
            $rules['new_eq_other_description'] = 'required|string|max:100';
            $rules['new_eq_total_value'] = 'required|numeric|min:100';
        }
        $this->validate($rules);

        $finalDescription = $isOther ? $this->new_eq_other_description : $sourceKey;
        $existing = HomologationValuationEquipmentModel::where('valuation_id', $this->idValuation)->where('description', $finalDescription)->first();
        if ($existing) {
            Toaster::error('Ya existe este equipamiento.');
            return;
        }

        $equipmentData = self::EQUIPMENT_MAP[$sourceKey] ?? ['unit' => 'PZA', 'value' => 0.00];

        // 1. Crear el equipamiento SUJETO
        $qtySujeto = (float)$this->new_eq_quantity;
        $totalVal = $isOther ? (float)$this->new_eq_total_value : ($qtySujeto * $equipmentData['value']);

        $subjectEq = HomologationValuationEquipmentModel::create([
            'valuation_id' => $this->idValuation,
            'description' => $finalDescription,
            'unit' => $equipmentData['unit'],
            'custom_description' => $isOther ? $this->new_eq_other_description : null,
            'quantity' => $qtySujeto,
            'total_value' => $totalVal,
        ]);

        // 2. Calcular valores iniciales para comparables (Qty = 0)
        $unitPrice = ($qtySujeto > 0) ? ($totalVal / $qtySujeto) : 0;

        // La diferencia es el valor total del sujeto, porque el comparable tiene 0
        $differenceMoneyInitial = $totalVal;

        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');

        foreach ($pivotIds as $pivotId) {
            $comparable = $this->comparables->where('id', $this->valuation->buildingComparablePivots->where('id', $pivotId)->first()->comparable_id)->first();
            $valorOfertaComparable = (float)($comparable->comparable_offers ?? 0);

            // Porcentaje inicial (Calculado con la diferencia total de dinero)
            $pctInitial = ($valorOfertaComparable > 0) ? ($differenceMoneyInitial / $valorOfertaComparable) * 100 : 0;

            // Crear registro en COMPARABLE
            HomologationComparableEquipmentModel::create([
                'valuation_equipment_id' => $subjectEq->id,
                'valuation_building_comparable_id' => $pivotId,
                'description' => $subjectEq->description,
                'unit' => $subjectEq->unit,
                'quantity' => 0.00, // <--- INICIALIZADO EN CERO CORRECTAMENTE
                'difference' => $differenceMoneyInitial,
                'percentage' => $pctInitial,
            ]);

            // Recalcular FEQ para incluir el nuevo ítem
            $this->calculateEquipmentFactor($pivotId);
        }

        $this->reset(['new_eq_description', 'new_eq_quantity', 'new_eq_total_value', 'new_eq_other_description']);
        $this->loadEquipmentData();
        $this->recalculateConclusions();
        Toaster::success('Equipamiento agregado y factores actualizados.');
    }

    public function toggleEditEquipment($eqId)
    {
        $eq = HomologationValuationEquipmentModel::find($eqId);
        if (!$eq) return;
        $this->reset(['editing_eq_id', 'edit_eq_quantity', 'edit_eq_total_value', 'edit_eq_other_description']);
        $this->editing_eq_id = $eqId;
        $this->edit_eq_quantity = (float)$eq->quantity;
        $this->edit_eq_total_value = (float)$eq->total_value;
        if (!empty($eq->custom_description)) {
            $this->edit_eq_other_description = $eq->custom_description;
        }
    }
    public function cancelEditEquipment()
    {
        $this->reset(['editing_eq_id', 'edit_eq_quantity', 'edit_eq_total_value', 'edit_eq_other_description']);
        $this->loadEquipmentData();
    }
    public function saveEditedEquipment()
    {
        $eq = HomologationValuationEquipmentModel::find($this->editing_eq_id);
        if (!$eq) {
            $this->cancelEditEquipment();
            return;
        }

        $this->validate([
            'edit_eq_quantity' => 'required|numeric|min:0',
            'edit_eq_total_value' => 'nullable|numeric|min:0',
        ]);

        $isOther = !empty($eq->custom_description);
        $totalVal = $isOther ? $this->edit_eq_total_value : ($this->edit_eq_quantity * (self::EQUIPMENT_MAP[$eq->description]['value'] ?? 0));

        $newDescription = $isOther ? $this->edit_eq_other_description : $eq->description;

        $eq->update([
            'quantity' => $this->edit_eq_quantity,
            'total_value' => $totalVal,
            'custom_description' => $isOther ? $this->edit_eq_other_description : null,
            'description' => $newDescription
        ]);

        HomologationComparableEquipmentModel::where('valuation_equipment_id', $eq->id)->update(['description' => $newDescription]);
        $this->loadEquipmentData();
        $this->cancelEditEquipment();
        $this->recalculateConclusions();
        Toaster::success('Editado correctamente.');
    }
    public function deleteEquipment($subjectEqId)
    {
        $eq = HomologationValuationEquipmentModel::find($subjectEqId);
        if ($eq) {
            HomologationComparableEquipmentModel::where('valuation_equipment_id', $subjectEqId)->delete();
            $eq->delete();
            $this->loadEquipmentData();
            $this->recalculateConclusions();
            Toaster::success('Eliminado.');
        }
    }

    public function updateComparableEquipmentQty($compEqId, $newQty)
    {
        if ((float)$newQty < 0) {
            Toaster::error('No se permiten cantidades negativas.');
            $this->loadEquipmentData();
            return;
        }

        $compEq = HomologationComparableEquipmentModel::find($compEqId);
        if (!$compEq) return;

        $subjectEq = $compEq->subjectEquipment;
        $pivot = $this->valuation->buildingComparablePivots()->find($compEq->valuation_building_comparable_id);

        $comparable = $this->comparables->where('id', $pivot->comparable_id)->first();
        $valorOfertaComparable = (float)($comparable->comparable_offers ?? 0);

        // 1. Costo Unitario del Sujeto
        $unitPrice = ($subjectEq->quantity > 0) ? ($subjectEq->total_value / $subjectEq->quantity) : 0;

        // 2. Diferencia en Cantidad (Sujeto - Comparable)
        // Si Sujeto tiene 3 y Comparable 0: (3 - 0) = 3 (Positivo, ganancia para el sujeto)
        $qtySujeto = (float)$subjectEq->quantity;
        $qtyComparable = (float)$newQty;

        $diffQty = $qtySujeto - $qtyComparable;

        // 3. Diferencia en Dinero
        $differenceMoney = $diffQty * $unitPrice;

        // 4. Porcentaje
        $pct = ($valorOfertaComparable > 0) ? ($differenceMoney / $valorOfertaComparable) * 100 : 0;

        $compEq->update([
            'quantity' => $newQty,
            'difference' => $differenceMoney,
            'percentage' => $pct
        ]);

        // 5. Disparar recálculo de Factores
        $this->calculateEquipmentFactor($pivot->id);

        // 6. Recargar vistas
        $this->loadEquipmentData();
        $this->recalculateConclusions();
    }

    public function calculateEquipmentFactor($pivotId)
    {
        $equipments = HomologationComparableEquipmentModel::where('valuation_building_comparable_id', $pivotId)->get();
        $sumPercentages = $equipments->sum('percentage');
        $decimalSum = $sumPercentages / 100;

        // FÓRMULA FINAL: 1 + Suma
        // Si la suma es positiva (Sujeto mejor), FEQ > 1.
        $feq = 1 + $decimalSum;

        // 1. Guardar en Base de Datos (Factor FEQ)
        HomologationComparableFactorModel::updateOrCreate(
            ['valuation_building_comparable_id' => $pivotId, 'acronym' => 'FEQ', 'homologation_type' => 'building'],
            [
                'rating' => 1.0000,
                'applicable' => $feq, // Este es el valor clave
                'factor_name' => 'Factor Equipamiento'
            ]
        );

        // 2. IMPORTANTE: Actualizar el array en MEMORIA ($this->comparableFactors)
        // Esto hace que la tabla "Factores de Ajuste Aplicados" se actualice al instante sin F5
        $comparableId = $this->valuation->buildingComparablePivots()->find($pivotId)->comparable_id;

        if (!isset($this->comparableFactors[$comparableId]['FEQ'])) {
            $this->initializeComparableFactorStructure($comparableId, 'FEQ');
        }

        $this->comparableFactors[$comparableId]['FEQ']['aplicable'] = number_format($feq, 4, '.', '');
        $this->comparableFactors[$comparableId]['FEQ']['diferencia'] = number_format($decimalSum, 4, '.', '');

        // 3. Recalcular el FRE completo del comparable con el nuevo FEQ
        $this->recalculateSingleComparable($comparableId);
    }

    public function render()
    {
        return view('livewire.forms.homologation-buildings');
    }
}
