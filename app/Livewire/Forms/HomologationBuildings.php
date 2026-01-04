<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Flux\Flux;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Storage;

use App\Models\Valuations\Valuation;

// Modelos
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationComparableFactorModel;
use App\Models\Forms\Homologation\HomologationValuationEquipmentModel;
use App\Models\Forms\Homologation\HomologationComparableEquipmentModel;
use App\Models\Forms\Homologation\HomologationComparableSelectionModel;
use App\Models\Forms\Building\BuildingModel;
use App\Models\Forms\ApplicableSurface\ApplicableSurfaceModel;
use App\Models\Forms\Homologation\HomologationBuildingAttributeModel;
use App\Models\Forms\Homologation\HomologationLandAttributeModel;
use App\Models\Forms\PropertyDescription\PropertyDescriptionModel;


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
    public $new_eq_quantity = 0.00;
    public $new_eq_total_value = 0.00;
    public $new_eq_other_description = '';
    public $editing_eq_id = null;
    public $edit_eq_quantity = 0.00;
    public $edit_eq_total_value = 0.00;
    public $edit_eq_other_description = '';

    //Variables para valores de construcciones
    public $building;
    public $subject_surface_construction = 0;
    public $subject_surface_land = 0;
    public $subject_age_weighted = 0;
    public $subject_vut_weighted = 0;
    public $subject_vur_weighted = 0;
    public $subject_rel_tc = 0;
    public $subject_progress_work = 0;

    // En tus propiedades públicas (al inicio de la clase)
    public $subject_vus = 0; // Valor Unitario de Suelo (VUS)

    //Propiedad para obtener la descripción/caracteristicas del inmueble
    public $property_description;

    // Nueva propiedad para avance de obra en porcentaje
    public $subject_progress_porcent = 0;


    // Nueva propiedad para estado de conservación
    public $subject_conservation_description = '';

    // Reemplaza la antigua const EQUIPMENT_MAP por esto:
    protected const EQUIPMENT_VALUES_BY_CLASS = [
        'Minima' => [
            'Baño completo' => ['unit' => 'PZA', 'value' => 10000.00],
            'Medio baño' => ['unit' => 'PZA', 'value' => 0.00],
            'Cocina integral' => ['unit' => 'PZA', 'value' => 0.00],
            'Estacionamiento cubierto para dpto.' => ['unit' => 'Cajón', 'value' => 0.00],
            'Estacionamiento desubierto para dpto.' => ['unit' => 'Cajón', 'value' => 0.00],
            'Terraza' => ['unit' => 'M2', 'value' => 0.00],
            'Balcon' => ['unit' => 'M2', 'value' => 0.00],
            'Acabados' => ['unit' => 'M2', 'value' => 0.00],
            'Elevador' => ['unit' => '%', 'value' => 0.00],
            'Roof garden' => ['unit' => 'M2', 'value' => 1980.00],
            'Otro' => ['unit' => 'PZA', 'value' => 0.00],
        ],
        'Economica' => [
            'Baño completo' => ['unit' => 'PZA', 'value' => 12528.00],
            'Medio baño' => ['unit' => 'PZA', 'value' => 7000.00],
            'Cocina integral' => ['unit' => 'PZA', 'value' => 17700.00],
            'Estacionamiento cubierto para dpto.' => ['unit' => 'Cajón', 'value' => 45000.00],
            'Estacionamiento desubierto para dpto.' => ['unit' => 'Cajón', 'value' => 22500.00],
            'Terraza' => ['unit' => 'M2', 'value' => 1980.00],
            'Balcon' => ['unit' => 'M2', 'value' => 990.00],
            'Acabados' => ['unit' => 'M2', 'value' => 301.00],
            'Elevador' => ['unit' => '%', 'value' => 0.01],
            'Roof garden' => ['unit' => 'M2', 'value' => 3375.00],
            'Otro' => ['unit' => 'PZA', 'value' => 0.00],
        ],
        'Interes social' => [ // Igual a Económica
            'Baño completo' => ['unit' => 'PZA', 'value' => 12528.00],
            'Medio baño' => ['unit' => 'PZA', 'value' => 7000.00],
            'Cocina integral' => ['unit' => 'PZA', 'value' => 17700.00],
            'Estacionamiento cubierto para dpto.' => ['unit' => 'Cajón', 'value' => 45000.00],
            'Estacionamiento desubierto para dpto.' => ['unit' => 'Cajón', 'value' => 22500.00],
            'Terraza' => ['unit' => 'M2', 'value' => 1980.00],
            'Balcon' => ['unit' => 'M2', 'value' => 990.00],
            'Acabados' => ['unit' => 'M2', 'value' => 301.00],
            'Elevador' => ['unit' => '%', 'value' => 0.01],
            'Roof garden' => ['unit' => 'M2', 'value' => 3375.00],
            'Otro' => ['unit' => 'PZA', 'value' => 0.00],
        ],
        'Media' => [
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
        ],
        'Semilujo' => [
            'Baño completo' => ['unit' => 'PZA', 'value' => 31446.00],
            'Medio baño' => ['unit' => 'PZA', 'value' => 20421.00],
            'Cocina integral' => ['unit' => 'PZA', 'value' => 141663.00],
            'Estacionamiento cubierto para dpto.' => ['unit' => 'Cajón', 'value' => 120000.00],
            'Estacionamiento desubierto para dpto.' => ['unit' => 'Cajón', 'value' => 60000.00],
            'Terraza' => ['unit' => 'M2', 'value' => 4121.00],
            'Balcon' => ['unit' => 'M2', 'value' => 2060.00],
            'Acabados' => ['unit' => 'M2', 'value' => 2150.00],
            'Elevador' => ['unit' => '%', 'value' => 0.01],
            'Roof garden' => ['unit' => 'M2', 'value' => 6000.00],
            'Otro' => ['unit' => 'PZA', 'value' => 0.00],
        ],
        'Residencial' => [
            'Baño completo' => ['unit' => 'PZA', 'value' => 38587.00],
            'Medio baño' => ['unit' => 'PZA', 'value' => 31446.00],
            'Cocina integral' => ['unit' => 'PZA', 'value' => 350000.00],
            'Estacionamiento cubierto para dpto.' => ['unit' => 'Cajón', 'value' => 150000.00],
            'Estacionamiento desubierto para dpto.' => ['unit' => 'Cajón', 'value' => 75000.00],
            'Terraza' => ['unit' => 'M2', 'value' => 6000.00],
            'Balcon' => ['unit' => 'M2', 'value' => 3000.00],
            'Acabados' => ['unit' => 'M2', 'value' => 2351.00],
            'Elevador' => ['unit' => '%', 'value' => 0.00], // Ojo: en tu lista decía 0.00
            'Roof garden' => ['unit' => 'M2', 'value' => 6000.00],
            'Otro' => ['unit' => 'PZA', 'value' => 0.00],
        ],
        'Residencial plus' => [ // Igual a Residencial
            'Baño completo' => ['unit' => 'PZA', 'value' => 38587.00],
            'Medio baño' => ['unit' => 'PZA', 'value' => 31446.00],
            'Cocina integral' => ['unit' => 'PZA', 'value' => 350000.00],
            'Estacionamiento cubierto para dpto.' => ['unit' => 'Cajón', 'value' => 150000.00],
            'Estacionamiento desubierto para dpto.' => ['unit' => 'Cajón', 'value' => 75000.00],
            'Terraza' => ['unit' => 'M2', 'value' => 6000.00],
            'Balcon' => ['unit' => 'M2', 'value' => 3000.00],
            'Acabados' => ['unit' => 'M2', 'value' => 2351.00],
            'Elevador' => ['unit' => '%', 'value' => 0.00],
            'Roof garden' => ['unit' => 'M2', 'value' => 6000.00],
            'Otro' => ['unit' => 'PZA', 'value' => 0.00],
        ],
        'Residencial plus +' => [ // Igual a Residencial
            'Baño completo' => ['unit' => 'PZA', 'value' => 38587.00],
            'Medio baño' => ['unit' => 'PZA', 'value' => 31446.00],
            'Cocina integral' => ['unit' => 'PZA', 'value' => 350000.00],
            'Estacionamiento cubierto para dpto.' => ['unit' => 'Cajón', 'value' => 150000.00],
            'Estacionamiento desubierto para dpto.' => ['unit' => 'Cajón', 'value' => 75000.00],
            'Terraza' => ['unit' => 'M2', 'value' => 6000.00],
            'Balcon' => ['unit' => 'M2', 'value' => 3000.00],
            'Acabados' => ['unit' => 'M2', 'value' => 2351.00],
            'Elevador' => ['unit' => '%', 'value' => 0.00],
            'Roof garden' => ['unit' => 'M2', 'value' => 6000.00],
            'Otro' => ['unit' => 'PZA', 'value' => 0.00],
        ],
        'Unica' => [ // Todos ceros
            'Baño completo' => ['unit' => 'PZA', 'value' => 0.00],
            'Medio baño' => ['unit' => 'PZA', 'value' => 0.00],
            'Cocina integral' => ['unit' => 'PZA', 'value' => 0.00],
            'Estacionamiento cubierto para dpto.' => ['unit' => 'Cajón', 'value' => 0.00],
            'Estacionamiento desubierto para dpto.' => ['unit' => 'Cajón', 'value' => 0.00],
            'Terraza' => ['unit' => 'M2', 'value' => 0.00],
            'Balcon' => ['unit' => 'M2', 'value' => 0.00],
            'Acabados' => ['unit' => 'M2', 'value' => 0.00],
            'Elevador' => ['unit' => '%', 'value' => 0.00],
            'Roof garden' => ['unit' => 'M2', 'value' => 0.00],
            'Otro' => ['unit' => 'PZA', 'value' => 0.00],
        ],
        'Default' => [ // FALLBACK: Todos ceros si no hay building
            'Baño completo' => ['unit' => 'PZA', 'value' => 0.00],
            'Medio baño' => ['unit' => 'PZA', 'value' => 0.00],
            'Cocina integral' => ['unit' => 'PZA', 'value' => 0.00],
            'Estacionamiento cubierto para dpto.' => ['unit' => 'Cajón', 'value' => 0.00],
            'Estacionamiento desubierto para dpto.' => ['unit' => 'Cajón', 'value' => 0.00],
            'Terraza' => ['unit' => 'M2', 'value' => 0.00],
            'Balcon' => ['unit' => 'M2', 'value' => 0.00],
            'Acabados' => ['unit' => 'M2', 'value' => 0.00],
            'Elevador' => ['unit' => '%', 'value' => 0.00],
            'Roof garden' => ['unit' => 'M2', 'value' => 0.00],
            'Otro' => ['unit' => 'PZA', 'value' => 0.00],
        ]
    ];


    protected const VUT_MAP = [
        'Superior a moda'    => 60, // Mínima
        'Economica'          => 60,
        'Interes social'     => 60,
        'Media'              => 70,
        'Semilujo'           => 80,
        'Residencial'        => 90,
        'Residencial plus'   => 90,
        'Residencial plus +' => 90,
        'Unica'              => 90,
    ];


    // En HomologationBuildings.php
    protected const CONSERVACION_VALORES = [
        '0.8' => 0.80, // Malo
        '1'   => 1.00, // Bueno, Normal, Nuevo
        '1.1' => 1.10, // Muy bueno, Recientemente remodelado
        '0'   => 0.00, // Ruinoso
    ];


    /*
    Detalle de categorías

    mínima
    'Baño completo' => 10000.00
    'Medio baño' => 0.00
    'Cocina integral' => 0.00
     'Estacionamiento cubierto para dpto.' => 0.00
    'Estacionamiento desubierto para dpto.' => 0.00
    'Terraza' => 0.00
    'Balcon' => 0.00
    'Acabados' => 0.00
    'Elevador' => 0.00
    'Roof garden' => 1980.00
    'Otro' => 0.00

    económica
    'Baño completo' => 12528.00
    'Medio baño' => 7000.00
    'Cocina integral' => 17700.00
     'Estacionamiento cubierto para dpto.' => 45000.00
    'Estacionamiento desubierto para dpto.' => 22500.00
    'Terraza' => 1980.00
    'Balcon' => 990.00
    'Acabados' => 301.00
    'Elevador' => 0.01
    'Roof garden' => 3375.00
    'Otro' => 0.00

     interés social
    'Baño completo' => 12528.00
    'Medio baño' => 7000.00
    'Cocina integral' => 17700.00
     'Estacionamiento cubierto para dpto.' => 45000.00
    'Estacionamiento desubierto para dpto.' => 22500.00
    'Terraza' => 1980.00
    'Balcon' => 990.00
    'Acabados' => 301.00
    'Elevador' => 0.01
    'Roof garden' => 3375.00
    'Otro' => 0.00

    media
    ''Baño completo' =>  16768.00,
    'Medio baño' =>  9396.00,
    'Cocina integral' =>  => 38000.00,
    'Estacionamiento cubierto para dpto.' => 80000.00,
    'Estacionamiento desubierto para dpto.' =>  40000.00,
    'Terraza' =>  3375.00,
    'Balcon' =>  1687.00,
    'Acabados' =>  1360.00,
    'Elevador' =>  0.01,
    'Roof garden' =>  4121.00,
    'Otro' =>  0.00,

    semilujo
    'Baño completo' => 31446.00
    'Medio baño' => 20421.00
    'Cocina integral' => 141663.00
    'Estacionamiento cubierto para dpto.' => 120000.00
    'Estacionamiento desubierto para dpto.' => 60000.00
    'Terraza' => 4121.00
    'Balcon' => 2060.00
    'Acabados' => 2150.00
    'Elevador' => 0.01
    'Roof garden' => 6000.00
    'Otro' => 0.00

    residencial
    'Baño completo' => 38587.00
    'Medio baño' => 31446.00
    'Cocina integral' => 350000.00
     'Estacionamiento cubierto para dpto.' => 150000.00
    'Estacionamiento desubierto para dpto.' => 75000.00
    'Terraza' => 6000.00
    'Balcon' => 3000.00
    'Acabados' => 2351.00
    'Elevador' => 0.00
    'Roof garden' => 6000.00
    'Otro' => 0.00

    residencial plus
    'Baño completo' => 38587.00
    'Medio baño' => 31446.00
    'Cocina integral' => 350000.00
     'Estacionamiento cubierto para dpto.' => 150000.00
    'Estacionamiento desubierto para dpto.' => 75000.00
    'Terraza' => 6000.00
    'Balcon' => 3000.00
    'Acabados' => 2351.00
    'Elevador' => 0.00
    'Roof garden' => 6000.00
    'Otro' => 0.00

    residencial plus +
    'Baño completo' => 38587.00
    'Medio baño' => 31446.00
    'Cocina integral' => 350000.00
     'Estacionamiento cubierto para dpto.' => 150000.00
    'Estacionamiento desubierto para dpto.' => 75000.00
    'Terraza' => 6000.00
    'Balcon' => 3000.00
    'Acabados' => 2351.00
    'Elevador' => 0.00
    'Roof garden' => 6000.00
    'Otro' => 0.00

     única
    'Baño completo' => 0.00
    'Medio baño' => 0.00
    'Cocina integral' => 0.00
     'Estacionamiento cubierto para dpto.' => 0.00
    'Estacionamiento desubierto para dpto.' => 0.00
    'Terraza' => 0.00
    'Balcon' => 0.00
    'Acabados' => 0.00
    'Elevador' => 0.00
    'Roof garden' => 0.00
    'Otro' => 0.00




    */

    // [NUEVO] Mapa de valores para Conservación
    const CONSERVACION_MAP = [
        'Bueno' => 1.00,
        'Normal' => 1.00,
        'Nuevo' => 1.00,
        'Malo' => 0.80,
        'Malo' => 0.80,
        'Muy bueno' => 1.10,
        'Recientemente remodelado' => 1.10,
        'Ruinoso' => 0.00
    ];


    #[Computed]
    public function equipmentOptions(): array
    {
        // Devuelve solo los nombres (Baño, Cocina, etc) para el Select
        return array_keys(self::EQUIPMENT_VALUES_BY_CLASS['Media']);
    }

    #[Computed]
    public function selectedEquipmentUnitPrice(): float
    {
        // Calcula el precio unitario según la Clase del edificio y la opción seleccionada
        $map = $this->getCurrentPriceMap();
        return $map[$this->new_eq_description]['value'] ?? 0.00;
    }

    #[Computed]
    public function orderedComparableFactorsForView(): array
    {
        // 1. Ya trae FSU, FIC, FEDAD... ¡y ahora también FCON!
        $ordered = $this->subject_factors_ordered;

        // 2. Solo agregamos el FNEG al principio como siempre
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

    public function mount()
    {
        $this->idValuation = Session::get('valuation_id');
        $this->valuation = Valuation::find($this->idValuation);

        if (!$this->valuation) {
            $this->comparables = collect();
            return;
        }

        //Obtenemos la descripción del inmueble
        $property_description = PropertyDescriptionModel::where('valuation_id', $this->idValuation)->first();

        if ($property_description) {
            $this->property_description = $property_description->actual_use;
        }

        $attributes = HomologationBuildingAttributeModel::where('valuation_id', $this->idValuation)->first();

        if ($attributes) {
            // Recuperamos la preferencia de redondeo
            $this->conclusion_tipo_redondeo = $attributes->conclusion_type_rounding ?? 'Unidades';
        }

        try {
            $this->comparables = $this->valuation->buildingComparables()->orderByPivot('position')->get();
        } catch (\Throwable $e) {
            $this->comparables = collect();
        }

        $this->building = BuildingModel::where('valuation_id', $this->idValuation)->first();
        $this->calculateSubjectValues();
        $this->refreshSubjectEquipmentValues();
        $this->comparablesCount = $this->comparables->count();
        $this->prepareSubjectFactorsForView();

        if ($this->comparablesCount > 0) {
            $this->currentPage = 1;
            // 1. Cargar Factores Numéricos
            $this->loadAllComparableFactors();
            // 2. Cargar Selecciones (Clase, Conservación, Localización)
            $this->loadComparableSelections();

            $this->updateComparableSelection();
        }

        $this->selectedForStats = $this->comparables->pluck('id')->toArray();
        $this->recalculateConclusions();
    }

    // Detecta la clase del primer edificio y devuelve el mapa de precios correspondiente
    private function getCurrentPriceMap(): array
    {
        $claseSujeto = 'Default'; // Si no hay building, usamos Default (ceros)

        if ($this->building) {
            $firstConstruction = $this->building->privates()->first();
            if ($firstConstruction && !empty($firstConstruction->clasification)) {
                $claseSujeto = $firstConstruction->clasification;
            }
        }

        // Si la clase que viene de la BD no está en nuestro mapa, usamos Default o Media?
        // Según tu instrucción, si no encuentra, usa Default (ceros).
        return self::EQUIPMENT_VALUES_BY_CLASS[$claseSujeto]
            ?? self::EQUIPMENT_VALUES_BY_CLASS['Default'];
    }



    public function refreshSubjectEquipmentValues()
    {
        $priceMap = $this->getCurrentPriceMap();

        // 1. Obtener equipos guardados
        $equipments = HomologationValuationEquipmentModel::where('valuation_id', $this->idValuation)->get();

        if ($equipments->isEmpty()) return;

        $hasChanges = false;
        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');

        foreach ($equipments as $eq) {
            // Ignoramos 'Otro' o los que tengan descripción personalizada ya que esos tienen valor manual
            if (!empty($eq->custom_description) || $eq->description === 'Otro') {
                continue;
            }

            // Verificamos si existe en el mapa actual
            if (isset($priceMap[$eq->description])) {
                $newUnitValue = (float)$priceMap[$eq->description]['value'];
                $currentTotal = (float)$eq->total_value;
                $quantity = (float)$eq->quantity;

                // Calculamos el nuevo total esperado
                $newTotal = $quantity * $newUnitValue;

                // Si hay diferencia (tolerancia de centavos), actualizamos
                if (abs($currentTotal - $newTotal) > 0.01) {
                    // Actualizar Sujeto
                    $eq->update(['total_value' => $newTotal]);
                    $hasChanges = true;

                    // --- REPERCUSIÓN EN COMPARABLES ---
                    // Como cambió el valor unitario del sujeto, cambia la diferencia en dinero
                    // $unitPrice = $newTotal / $quantity (que es $newUnitValue)

                    if ($quantity > 0) {
                        $unitPrice = $newUnitValue;

                        // Buscamos los registros hijos en los comparables
                        $compEquipments = HomologationComparableEquipmentModel::where('valuation_equipment_id', $eq->id)->get();

                        foreach ($compEquipments as $compEq) {
                            $pivot = $this->valuation->buildingComparablePivots->firstWhere('id', $compEq->valuation_building_comparable_id);
                            if (!$pivot) continue;

                            $comparable = $this->comparables->firstWhere('id', $pivot->comparable_id);
                            $valorOferta = (float)($comparable->comparable_offers ?? 0);

                            $qtyComparable = (float)$compEq->quantity; // La cantidad del comparable se respeta
                            $diffQty = $quantity - $qtyComparable; // (Sujeto - Comparable)

                            $newDifferenceMoney = $diffQty * $unitPrice;
                            $newPct = ($valorOferta > 0) ? ($newDifferenceMoney / $valorOferta) * 100 : 0;

                            $compEq->update([
                                'difference' => $newDifferenceMoney,
                                'percentage' => $newPct
                            ]);
                        }
                    }
                }
            }
        }

        // Si hubo cambios, recalculamos los factores FEQ de todos los comparables
        if ($hasChanges) {
            foreach ($pivotIds as $pid) {
                $this->calculateEquipmentFactor($pid);
            }
            // Recargamos la data en memoria para la vista
            $this->loadEquipmentData();
        }
    }



    public function calculateSubjectValues()
    {
        // 1. Obtener Avance de Obra y Conservación
        if ($this->building) {
            // --- AVANCE DE OBRA ---
            $rawProgress = $this->building->progress_general_works ?? 0;
            $this->subject_progress_porcent = $rawProgress;
            $this->subject_progress_work = round($rawProgress / 100, 4);

            // Persistencia de AVANC
            HomologationValuationFactorModel::updateOrCreate(
                ['valuation_id' => $this->idValuation, 'acronym' => 'AVANC', 'homologation_type' => 'building'],
                ['rating' => $this->subject_progress_work, 'factor_name' => 'Avance de Obra', 'is_editable' => false, 'is_custom' => false]
            );

            // --- CONSERVACIÓN DEL SUJETO (NUEVO) ---
            $firstConstruction = $this->building->privates()->first();
            if ($firstConstruction) {
                // Guardamos el texto (ej: "0.8 Malo" o "1. Bueno")
                $rawState = $firstConstruction->conservation_state;
                $this->subject_conservation_description = $rawState;

                // Extraemos el valor numérico alv con floatval()
                $ratingSujeto = floatval($rawState);

                // Persistencia de FCON (Calificación del Sujeto)
                HomologationValuationFactorModel::updateOrCreate(
                    ['valuation_id' => $this->idValuation, 'acronym' => 'FCON', 'homologation_type' => 'building'],
                    [
                        'rating' => $ratingSujeto,
                        'factor_name' => 'Conservación',
                        'is_editable' => false,
                        'is_custom' => false
                    ]
                );
            }
        }

        // 2. Obtener Superficies
        $applicableSurface = ApplicableSurfaceModel::where('valuation_id', $this->idValuation)->first();
        if ($applicableSurface) {
            $this->subject_surface_construction = $applicableSurface->built_area ?? 0;
        }

        $landAttributes = HomologationLandAttributeModel::where('valuation_id', $this->idValuation)->first();
        if ($landAttributes) {
            $this->subject_surface_land = $landAttributes->subject_surface_value ?? 0;
            $this->subject_vus = $landAttributes->unit_value_mode_lot ?? 0;
        }

        // 3. Relación T/C
        if ($this->subject_surface_construction > 0) {
            $this->subject_rel_tc = $this->subject_surface_land / $this->subject_surface_construction;
        } else {
            $this->subject_rel_tc = 0;
        }

        // 4. Calcular Ponderados (Ross-Heidecke y VUT)
        if (!$this->building) return;
        $constructions = $this->building->privates()->get();

        if ($constructions->isNotEmpty()) {
            $totalSurfaceForWeighting = 0;
            $weightedAgeAccumulator = 0;
            $weightedVUTAccumulator = 0;
            $lifeValuesConfig = config('properties_inputs.construction_life_values', []);

            foreach ($constructions as $item) {
                $surface = $item->surface;
                $claveCombinacion = $item->clasification . '_' . $item->use;
                $vutItem = $lifeValuesConfig[$claveCombinacion] ?? 0;

                $totalSurfaceForWeighting += $surface;
                $weightedAgeAccumulator += ($item->age * $surface);
                $weightedVUTAccumulator += ($vutItem * $surface);
            }

            if ($totalSurfaceForWeighting > 0) {
                $this->subject_age_weighted = $weightedAgeAccumulator / $totalSurfaceForWeighting;
                $this->subject_vut_weighted = $weightedVUTAccumulator / $totalSurfaceForWeighting;
                $this->subject_vur_weighted = max($this->subject_vut_weighted - $this->subject_age_weighted, 0);
            }
        }

        // 5. Calcular FEDAD (Factor Edad)
        $this->calculateSubjectFedad();
    }
    private function prepareSubjectFactorsForView(): void
    {
        // 1. Traemos todo de la BD
        $allFactors = HomologationValuationFactorModel::where('valuation_id', $this->idValuation)
            ->where('homologation_type', 'building')
            ->get();

        // 2. Definimos FNEG (Meta)
        $this->fneg_factor_meta = [
            'id' => null,
            'factor_name' => 'Factor Negociación',
            'acronym' => 'FNEG',
            'code' => 'FNEG',
            'rating' => '1.0000',
            'is_custom' => false,
            'can_edit' => false,
        ];

        $orderedList = [];
        $processedIds = [];

        // =========================================================
        // CONSTRUCCIÓN DEL ORDEN ESTRICTO (POR LÓGICA, NO POR NOMBRE)
        // =========================================================

        // 1. FSU (Superficie) - Estricto por sigla
        $fsu = $allFactors->firstWhere('acronym', 'FSU');
        if ($fsu) {
            $orderedList[] = $this->formatFactorForView($fsu);
            $processedIds[] = $fsu->id;
        }

        // 2. FIC (Intensidad) - Estricto por sigla
        $fic = $allFactors->firstWhere('acronym', 'FIC');
        if ($fic) {
            $orderedList[] = $this->formatFactorForView($fic);
            $processedIds[] = $fic->id;
        }

        // 3. FEQ (Equipamiento) - Por Bandera
        $feq = $allFactors->first(fn($i) => $i->is_feq || $i->acronym === 'FEQ');
        if ($feq) {
            $orderedList[] = $this->formatFactorForView($feq);
            $processedIds[] = $feq->id;
        }

        // 4. FEDAD (Edad) - Estricto por sigla
        $fedad = $allFactors->firstWhere('acronym', 'FEDAD');
        if ($fedad) {
            $orderedList[] = $this->formatFactorForView($fedad);
            $processedIds[] = $fedad->id;
        }


        // 5. EL FACTOR EDITABLE DE SISTEMA (Antes FLOC)
        // Aquí está la magia: Buscamos al factor que sea editable, NO sea custom y NO sea equipo.
        // Se llame "FLOC", "UBIC", "ZONA" o "PATITO", siempre caerá aquí.
        $editableSystem = $allFactors->first(
            fn($i) =>
            $i->is_editable &&
                !$i->is_custom &&
                !$i->is_feq &&
            !in_array($i->id, $processedIds)
        );

        if ($editableSystem) {
            $orderedList[] = $this->formatFactorForView($editableSystem);
            $processedIds[] = $editableSystem->id;
        }

        // 6. AVANC (Avance) - Estricto por sigla
        $avanc = $allFactors->firstWhere('acronym', 'AVANC');
        if ($avanc) {
            $orderedList[] = $this->formatFactorForView($avanc);
            $processedIds[] = $avanc->id;
        }



        // =========================================================
        // RESTO DE FACTORES (Customs o Nuevos)
        // =========================================================
        foreach ($allFactors as $factor) {
            if (!in_array($factor->id, $processedIds)) {
                // NO lo saltes si es FCON. Solo agrégalo a la lista.
                $formatted = $this->formatFactorForView($factor);

                // Le ponemos una marca para ocultarlo en la tabla de arriba si quieres
                $formatted['hide_in_subject'] = ($factor->acronym === 'FCON');

                $orderedList[] = $formatted;
            }
        }

      /*   $fcon = $allFactors->firstWhere('acronym', 'FCON');
        if ($fcon) {
            $orderedList[] = $this->formatFactorForView($fcon);
            //$processedIds[] = $fcon->id;
        }
 */

        $this->subject_factors_ordered = $orderedList;
    }





    private function formatFactorForView($factor)
    {
        // ...
        $isFeq = (bool)$factor->is_feq;
        $isCustom = (bool)$factor->is_custom;
        $isEditableDb = (bool)$factor->is_editable;

        // Si la lógica de edición del SUJETO depende solo de flags puros:
        $canEditSubject = $isFeq || $isCustom || $isEditableDb;

        // Lógica pura de edición (la que no depende de la sigla FLOC)
        $isEditableComparable = $isCustom || $isEditableDb;

        return [
            'id' => $factor->id,
            'factor_name' => $factor->factor_name,
            'acronym' => $factor->acronym,
            'rating' => number_format((float)$factor->rating, 4, '.', ''),
            'is_custom' => $isCustom,
            'is_feq' => $isFeq,

            // 🔥 1. RESTAURAMOS can_edit para la tabla Sujeto (ARRIBA)
            'can_edit' => $canEditSubject,

            // 🔥 2. Usamos esta clave para la tabla Comparables (ABAJO)
            'is_editable' => $isEditableComparable,
        ];
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
            $this->comparableFactors[$compId][$factor->acronym]['aplicable'] = number_format((float)($factor->applicable ?? 1.0), 4, '.', '');
        }

        $allFactors = $this->orderedComparableFactorsForView;
        foreach ($this->comparables as $comparable) {
            foreach ($allFactors as $mf) {
                $this->initializeComparableFactorStructure($comparable->id, $mf['acronym']);
            }
            // Aquí ya no llamamos a initializeExtraDefaults, se hace en loadComparableSelections
            $this->recalculateSingleComparable($comparable->id);
        }
    }

    // [NUEVO] Carga y Sincroniza Selecciones (Clase, Conservación, Localización)
    private function loadComparableSelections()
    {
        $pivots = $this->valuation->buildingComparablePivots;

        foreach ($pivots as $pivot) {
            $comparableId = $pivot->comparable_id;
            $comparableModel = $this->comparables->where('id', $comparableId)->first();

            if (!$comparableModel) continue;

            $selections = HomologationComparableSelectionModel::where('valuation_building_comparable_id', $pivot->id)->get();

            // 1. LÓGICA DE CLASE
            $dbClase = $selections->where('variable', 'clase')->first();
            $realClass = $comparableModel->comparable_clasification ?? '';
            $vutAnios = self::VUT_MAP[$realClass] ?? 60; // Traducción inmediata

            if (!$dbClase) {
                HomologationComparableSelectionModel::create([
                    'valuation_building_comparable_id' => $pivot->id,
                    'variable' => 'clase',
                    'value' => $realClass,
                ]);
            } elseif ($dbClase->value !== $realClass) {
                $dbClase->update(['value' => $realClass]);
            }

            // ASIGNACIÓN SIEMPRE (Para que la vista lo vea)
            $this->comparableFactors[$comparableId]['clase'] = $realClass;
            $this->comparableFactors[$comparableId]['vut_tabla'] = $vutAnios;

            // 2. LÓGICA CONSERVACIÓN
            $dbConserv = $selections->where('variable', 'conservacion')->first();
            if ($dbConserv) {
                $this->comparableFactors[$comparableId]['conservacion'] = $dbConserv->value;
            } else {
                HomologationComparableSelectionModel::create([
                    'valuation_building_comparable_id' => $pivot->id,
                    'variable' => 'conservacion',
                    'value' => null,
                ]);
                $this->comparableFactors[$comparableId]['conservacion'] = null;
            }

            // 3. LÓGICA LOCALIZACIÓN
            $dbLocal = $selections->where('variable', 'localizacion')->first();
            if ($dbLocal) {
                $this->comparableFactors[$comparableId]['localizacion'] = $dbLocal->value;
            } else {
                HomologationComparableSelectionModel::create([
                    'valuation_building_comparable_id' => $pivot->id,
                    'variable' => 'localizacion',
                    'value' => null,
                ]);
                $this->comparableFactors[$comparableId]['localizacion'] = null;
            }

            $this->comparableFactors[$comparableId]['url'] = $comparableModel->comparable_source ?? '';
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

    // [MODIFICADO] "El Agente de Tránsito"
    public function updatedComparableFactors($value, $key)
    {
        $parts = explode('.', $key);
        // Estructura esperada Factor: ID.ACRONIMO.PROPIEDAD (3 partes)
        // Estructura esperada Selección: ID.VARIABLE (2 partes)

        $comparableId = array_shift($parts);

        // Si solo quedan 1 parte, es una Selección (ej. 'clase', 'conservacion')
        if (count($parts) === 1) {
            $variable = array_shift($parts);
            $this->updateSelection($comparableId, $variable, $value);
            return;
        }

        // Si quedan 2 partes, es un Factor Numérico (ej. 'FNEG', 'aplicable')
        if (count($parts) >= 2) {
            $property = array_pop($parts);
            $acronym = implode('.', $parts);

            $this->updateNumericFactor($comparableId, $acronym, $property, $value);
        }
    }

    // [NUEVO] Método separado para guardar Selecciones (Clase, Conservación, Localización)
    private function updateSelection($comparableId, $variable, $value)
    {
        $pivotId = $this->valuation->buildingComparablePivots()->where('comparable_id', $comparableId)->value('id');
        if (!$pivotId) return;

        // Buscar registro
        $selection = HomologationComparableSelectionModel::where('valuation_building_comparable_id', $pivotId)
            ->where('variable', $variable)
            ->first();

        if ($selection) {
            $dataToUpdate = ['value' => $value];

            // Si es conservación, calculamos y guardamos el factor también
            if ($variable === 'conservacion') {
                $factorValue = self::CONSERVACION_MAP[$value] ?? 1.00;
                $dataToUpdate['factor'] = $factorValue;
            }

            $selection->update($dataToUpdate);

            if ($variable === 'clase') {
                $vutAnios = self::VUT_MAP[$value] ?? 60;
                $this->comparableFactors[$comparableId]['vut_tabla'] = $vutAnios;
            }

            // Actualizar memoria
            $this->comparableFactors[$comparableId][$variable] = $value;

            // Recalcular
            $this->recalculateSingleComparable($comparableId);
            $this->recalculateConclusions();

            Toaster::success(ucfirst($variable) . ' actualizado correctamente');
        }
    }

    // [REFACTOR] Método separado para guardar Factores Numéricos (Copia de tu lógica original)
    private function updateNumericFactor($comparableId, $acronym, $property, $value)
    {
        $pivotId = $this->valuation->buildingComparablePivots()->where('comparable_id', $comparableId)->value('id');

        if ($value === '' || $value === null) {
            Toaster::error('El valor no puede estar vacío.');
            $this->revertToOldValue($comparableId, $acronym, $property, $pivotId);
            return;
        }

        $numericValue = (float)$value;
        $valid = true;
        $errorMessage = '';

        // Detectamos si es AVANC
        $isAvanc = ($acronym === 'AVANC');

        /*         if ($property === 'calificacion') {
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
        } */

        if ($property === 'calificacion') {
            if ($isAvanc) {
                // AHORA SÍ: Permitimos de 0 a 100
                if ($numericValue < 0 || $numericValue > 100) {
                    $valid = false;
                    $errorMessage = 'El avance debe ser un valor entre 0 y 100.';
                }
            } else {
                // RESTO (FLOC, FSU, etc): Siguen siendo factores pequeños (0.01 a 2.0)
                if ($numericValue < 0.01 || $numericValue > 2.0) {
                    $valid = false;
                    $errorMessage = 'La calificación debe estar entre 0.0100 y 2.0000.';
                }
            }
        } elseif ($property === 'aplicable' && $acronym === 'FNEG') {
            // ... (Validación FNEG igual) ...
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
        Toaster::success('Factor editado correctamente');
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

    // ... (MÉTODOS DE EDICIÓN DE NOMBRES DE FACTORES - IGUALES) ...
    public function toggleEditFactor($acronym, $index)
    {
        if ($this->editing_factor_index === $index) {
            $this->saveEditedFactor($index);
        } else {

            $this->reset(['edit_factor_name', 'edit_factor_acronym', 'edit_factor_rating']);
            $factorData = $this->subject_factors_ordered[$index];
            $this->edit_factor_name = $factorData['factor_name'];
            $this->edit_factor_acronym = $factorData['acronym'];
            $this->edit_factor_rating = $factorData['rating'];
            $this->editing_factor_index = $index;
        }
    }

    public function saveEditedFactor()
    {
        // 1. Validaciones
        $this->validate([
            'edit_factor_name' => 'required|string|max:255',
            'edit_factor_acronym' => 'required|string|max:10',
            'edit_factor_rating' => 'required|numeric|min:0.1',
        ]);

        if ($this->editing_factor_index === null) return;

        $currentIndex = $this->editing_factor_index;
        $factorId = $this->subject_factors_ordered[$currentIndex]['id'];
        $oldAcronym = $this->subject_factors_ordered[$currentIndex]['acronym'];

        $newAcronym = strtoupper(trim($this->edit_factor_acronym));
        $newName = trim($this->edit_factor_name);
        $newRating = (float)$this->edit_factor_rating;

        // 2. Update BD Sujeto
        HomologationValuationFactorModel::where('id', $factorId)->update([
            'factor_name' => $newName,
            'acronym' => $newAcronym,
            'rating' => $newRating,
        ]);

        // 3. Propagación a Comparables (Limpieza de duplicados)
        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');

        if ($pivotIds->isNotEmpty()) {
            if ($oldAcronym !== $newAcronym) {
                HomologationComparableFactorModel::whereIn('valuation_building_comparable_id', $pivotIds)
                    ->where('acronym', $newAcronym)
                    ->where('homologation_type', 'building')
                    ->delete();
            }

            HomologationComparableFactorModel::whereIn('valuation_building_comparable_id', $pivotIds)
                ->where('acronym', $oldAcronym)
                ->where('homologation_type', 'building')
                ->update([
                    'acronym' => $newAcronym,
                    'factor_name' => $newName,
                ]);
        }

        // 4. Actualizar Memoria
        $this->subject_factors_ordered[$currentIndex]['factor_name'] = $newName;
        $this->subject_factors_ordered[$currentIndex]['acronym'] = $newAcronym;
        $this->subject_factors_ordered[$currentIndex]['rating'] = number_format($newRating, 4, '.', '');

        // 5. ORDENAMIENTO TIPO "SÁNDWICH" (Strict Mode) 🥪
        // Esto evita que FLOC se mueva aunque le cambies el nombre a "ZZZ".
        $this->subject_factors_ordered = collect($this->subject_factors_ordered)
            ->sortBy(function ($factor) {
                $acronym = strtoupper($factor['acronym'] ?? '');
                $isCustom = $factor['is_custom'] ?? false;
                $id = $factor['id'];

                // --- CAPA 1: SÓTANO (FNEG) ---
                // FNEG siempre va al final de todo, pase lo que pase.
                if ($acronym === 'FNEG') {
                    return 300000;
                }

                // --- CAPA 2: RELLENO (Customs) ---
                // Los factores creados por el usuario van después de los estándares.
                // Usamos el ID para mantener su orden de creación.
                if ($isCustom) {
                    return 200000 + $id;
                }

                // --- CAPA 3: TECHO (Estándares: FSU, FLOC, FIC, etc.) ---
                // Estos van primero. Usamos el ID original.
                // Así, FLOC (id 5) siempre irá antes que AVANC (id 8), sin importar el nombre.
                return 100000 + $id;
            })
            ->values()
            ->toArray();

        // 6. Recalcular
        $this->recalculateConclusions();

        // 7. Cerrar y Notificar
        $this->cancelEdit();

        // El Toaster limpio de Flux
        Toaster::success('Cantidad actualizada');
    }

    public function cancelEdit()
    {
        $this->editing_factor_index = null;
    }






    // [NUEVO] Calcular FACTOR EDAD (FEDAD) del Sujeto
    // Regla: Primer registro de construcciones privativas + Truncado a 2 decimales
    public function calculateSubjectFedad()
    {
        // 1. Valor por defecto = 1.0 (Neutro)
        $factorFinal = 1.0;

        if ($this->building) {
            // Buscamos la PRIMERA construcción privativa
            $firstConstruction = $this->building->privates()->first();

            if ($firstConstruction) {
                // Datos para la fórmula
                $clasification = $firstConstruction->clasification;
                $use = $firstConstruction->use;
                $age = $firstConstruction->age;

                // Configuración de Vida Útil
                $lifeValuesConfig = config('properties_inputs.construction_life_values', []);
                $claveCombinacion = $clasification . '_' . $use;
                $vidaUtilTotal = $lifeValuesConfig[$claveCombinacion] ?? 0;

                // Aplicar Fórmula Ross-Heidecke Ponderada
                if ($vidaUtilTotal > 0) {
                    // Cálculo puro
                    $factorCalculado = (0.100 * $vidaUtilTotal + 0.900 * ($vidaUtilTotal - $age)) / $vidaUtilTotal;

                    // CORRECCIÓN: Quitamos el "floor" (machetazo) de 2 decimales.
                    // Usamos round a 4 decimales para mantener precisión estándar de factores.
                    $factorFinal = round($factorCalculado, 4);
                }
            }
        }

        // 2. GUARDAR EN BD (Rating)
        HomologationValuationFactorModel::updateOrCreate(
            [
                'valuation_id' => $this->idValuation,
                'acronym' => 'FEDAD',
                'homologation_type' => 'building'
            ],
            [
                'rating' => $factorFinal,       // Guardamos el valor completo (0.9754 en lugar de 0.97)
                'factor_name' => 'Factor Edad',
                'is_editable' => false,
                'is_custom' => false
            ]
        );

        // 3. ACTUALIZAR EN MEMORIA (Para que se vea el cambio sin F5)
        foreach ($this->subject_factors_ordered as $key => $factor) {
            if (($factor['acronym'] ?? '') === 'FEDAD') {
                $this->subject_factors_ordered[$key]['rating'] = number_format($factorFinal, 4, '.', '');
                break;
            }
        }
    }




    // ==========================================================
    // == LÓGICA DE CÁLCULO
    // ==========================================================
    public function recalculateSingleComparable($comparableId)
    {
        // 1. MAPA MAESTRO DEL SUJETO
        $subjectMasterMap = collect($this->subject_factors_ordered)->keyBy('acronym');

        if (!$subjectMasterMap->has('FNEG')) {
            $subjectMasterMap->put('FNEG', ['rating' => 1.0, 'is_editable' => false, 'is_feq' => false]);
        }

        // 2. Detectar FEQ dinámico
        $feqDef = collect($this->subject_factors_ordered)->firstWhere('is_feq', true);
        $currentFeqAcronym = $feqDef ? $feqDef['acronym'] : 'FEQ';
        $currentFsuAcronym = 'FSU';

        if (!isset($this->comparableFactors[$comparableId])) return;

        // 3. Datos del Comparable
        $pivotId = $this->valuation->buildingComparablePivots()->where('comparable_id', $comparableId)->value('id');
        $comparableModel = $this->comparables->find($comparableId);

        if (!$comparableModel) return;

        // =========================================================================
        // [PASO A] CÁLCULO DINÁMICO DE VUT Y VUR (El VUT ya no es fijo)
        // =========================================================================

        // 1. Obtener la Clase del Comparable (Prioridad: Dropdown > BD > Default)
        $claseComparable = $this->comparableFactors[$comparableId]['clase']
            ?? $comparableModel->comparable_clasification
            ?? 'Media';

        // 2. Obtener el Uso del SUJETO (El truco: Asumimos homogeneidad)
        // Si el sujeto es "Comercial", buscamos el VUT "Comercial" para el comparable.
        $usoSujeto = 'Habitacional'; // Default
        if ($this->building) {
            $firstConstruction = $this->building->privates()->first();
            if ($firstConstruction && !empty($firstConstruction->use)) {
                $usoSujeto = $firstConstruction->use;
            }
        }

        // 3. Buscar VUT en Configuración
        // Genera llave tipo: "Media_Habitacional" o "Economica_Comercial"
        $configVida = config('properties_inputs.construction_life_values', []);
        $keyConfig = $claseComparable . '_' . $usoSujeto;

        // Si no encuentra la llave, usamos 60 años por seguridad (fallback)
        $VUT_Real = isset($configVida[$keyConfig]) ? (int)$configVida[$keyConfig] : 60;

        // 4. Calcular VUR (Vida Útil Remanente)
        $edadComparable = (int)$comparableModel->comparable_age;
        $VUR_Real = max($VUT_Real - $edadComparable, 0);

        // 5. ACTUALIZAR MODELO (Persistencia para que la ficha se vea bonita)
        if ((int)$comparableModel->comparable_vut !== $VUT_Real) {
            $comparableModel->comparable_vut = $VUT_Real;
            $comparableModel->save();
            // Actualizar memoria
            if ($this->selectedComparable && $this->selectedComparable->id == $comparableId) {
                $this->selectedComparable->comparable_vut = $VUT_Real;
            }
        }
        // =========================================================================


        // 4. Calcular Selects (FIC, Conservación)
        $conservacionTxt = $this->comparableFactors[$comparableId]['conservacion'] ?? '';
        $conservacion_factor = self::CONSERVACION_MAP[$conservacionTxt] ?? 1.0000;
        $this->comparableFactors[$comparableId]['conservacion_factor'] = number_format($conservacion_factor, 4);

        $clase_factor = $this->mapSelectValue($this->comparableFactors[$comparableId]['clase'] ?? 'Clase B', 'clase');
        $localizacion_factor = $this->mapSelectValue($this->comparableFactors[$comparableId]['localizacion'] ?? 'Lote intermedio', 'localizacion');

        $this->comparableFactors[$comparableId]['clase_factor'] = number_format($clase_factor, 4);
        $this->comparableFactors[$comparableId]['localizacion_factor'] = number_format($localizacion_factor, 4);

        // 5. OBTENER VALOR REAL DE FEQ
        $feqFactorAplicable = 1.0;
        if ($pivotId) {
            $dbFeq = HomologationComparableFactorModel::where('valuation_building_comparable_id', $pivotId)
                ->where('acronym', $currentFeqAcronym)
                ->where('homologation_type', 'building')
                ->first();

            if ($dbFeq) {
                $feqFactorAplicable = (float)$dbFeq->applicable;
            }
        }

        // 6. BUCLE DE CÁLCULO
        $factorResultante = 1.0;
        $allFactorsView = $this->orderedComparableFactorsForView;

        foreach ($allFactorsView as $factorView) {
            $sigla = $factorView['acronym'];

            $compRating = 1.0;
            $aplicable = 1.0;
            $diferencia_math = 0.0;
            $rating_to_save = 1.0;

            $masterDef = $subjectMasterMap->get($sigla);
            $sujetoRating = isset($masterDef['rating']) ? (float)$masterDef['rating'] : 1.0;

            $isFeq = $masterDef['is_feq'] ?? false;
            $isCustom = $masterDef['is_custom'] ?? false;
            $isEditable = $masterDef['is_editable'] ?? false;
            $isAVANC = ($sigla === 'AVANC');

            $factorData = $this->comparableFactors[$comparableId][$sigla] ?? [];

            $masterDef = $subjectMasterMap->get($sigla);

            // --- LÓGICA DE NEGOCIO ---

            if ($sigla === 'FNEG') {
                $aplicable = (float)($factorData['aplicable'] ?? 1.0);
                $diferencia_math = $aplicable - 1.0;
                $compRating = 1.0;
                $rating_to_save = 1.0;
            } elseif ($sigla === 'FEDAD') {
                // =========================================================
                // [PASO B] FEDAD: LÓGICA ROSS-HEIDECKE (Sujeto vs Comparable)
                // =========================================================

                // 1. Sujeto (Ya calculado en calculateSubjectFedad y guardado en $sujetoRating)
                // Usualmente viene como 0.95, 0.88, etc.

                // 2. Comparable (Calculamos al vuelo con VUT_Real)
                if ($VUT_Real > 0) {
                    // Fórmula: ((0.1 * VUT) + 0.9 * (VUT - Edad)) / VUT
                    $rawCompRating = (0.10 * $VUT_Real + 0.90 * ($VUT_Real - $edadComparable)) / $VUT_Real;

                    // Truncamos a 4 decimales para consistencia
                    $compRating = floor($rawCompRating * 10000) / 10000;
                } else {
                    $compRating = 1.0; // Evitar div by zero
                }

                // 3. Diferencia y Aplicable
                $diferencia_math = $sujetoRating - $compRating;
                $aplicable = 1.0 + $diferencia_math;
                $rating_to_save = $compRating;
            } elseif ($isFeq) {
                $aplicable = $feqFactorAplicable;
                $compRating = $feqFactorAplicable;
                $diferencia_math = $aplicable - 1.0;
                $rating_to_save = $feqFactorAplicable;
            } elseif ($sigla === $currentFsuAcronym) {
                $subjectLand = (float)$this->subject_surface_construction ?? 0;
                $compLand = (float)($comparableModel->comparable_built_area  ?? 0);

                if ($subjectLand > 0 && $compLand > 0) {
                    $coeficiente = $compLand / $subjectLand;
                    $compRating = pow($coeficiente, (1 / 12));
                    //dd($subjectLand,$compLand, $coeficiente, $compRating);
                }
                $diferencia_math = $sujetoRating - $compRating;
                $aplicable = 1.0 + $diferencia_math;
                $rating_to_save = $compRating;
            } elseif ($sigla === 'FIC') {
                // ... (Tu lógica FIC original se mantiene intacta) ...
                $VUS = (float)$this->subject_vus;
                $SCiv = (float)$this->subject_surface_construction;
                $STiv = (float)$this->subject_surface_land;
                $sujetoRating = 1.00;
                $Pp  = (float)$comparableModel->comparable_offers;
                $SCc = (float)($comparableModel->comparable_built_area ?? 0);
                $STc = (float)($comparableModel->comparable_land_area ?? 0);

                if ($SCiv > 0 && $STiv > 0 && $SCc > 0 && $Pp > 0) {
                    $intensidadSujeto = $SCiv / $STiv;
                    $terrenoTeorico = $SCc / $intensidadSujeto;
                    $diferenciaTerreno = $terrenoTeorico - $STc;
                    $ajustePesos = $diferenciaTerreno * $VUS;
                    $VUa = ($Pp + $ajustePesos) / $SCc;
                    $VU = $Pp / $SCc;
                    $FIC_Raw = $VUa / $VU;
                } else {
                    $FIC_Raw = 1.0;
                }

                if ($FIC_Raw != 0) {
                    $diferencia_raw = 1.0 - ($sujetoRating / $FIC_Raw);
                } else {
                    $diferencia_raw = 0.0;
                }

                $diferencia_math = floor($diferencia_raw * 10000) / 10000;
                $aplicable = 1.0 + $diferencia_math;
                $compRating = floor($FIC_Raw * 10000) / 10000;
                $rating_to_save = $compRating;
            }







            elseif ($isEditable || $isCustom || $isAVANC) {
                $userInput = (float)($factorData['calificacion'] ?? 1.0);

                if ($isAVANC) {
                    // El Sujeto ya es 0.8273 (gracias al paso 1)
                    // El Comparable lo dividimos entre 100 para que sean peras con peras
                    $compRating = $userInput; // Guardamos el "80" para que el usuario lo vea
                    $factorComparable = $userInput / 100; // Usamos "0.8000" para la matemática

                    $diferencia_math = $sujetoRating - $factorComparable;
                    $rating_to_save = $userInput;
                } else {
                    $compRating = $userInput ?: 1.0;
                    $diferencia_math = $sujetoRating - $compRating;
                    $rating_to_save = $compRating;
                }
                $aplicable = 1.0 + $diferencia_math;
            } elseif ($sigla === 'FCON') {
                // 1. Sujeto: Como lo ocultamos de la lista principal, lo traemos directo de la BD
                // para que no pinte 1.0000 por error.
                $sujetoFconModel = HomologationValuationFactorModel::where('valuation_id', $this->idValuation)
                    ->where('acronym', 'FCON')
                    ->first();

                // Aquí es donde recuperamos el 1.1 real del sujeto
                $sujetoRating = $sujetoFconModel ? (float)$sujetoFconModel->rating : 1.0;

                // 2. Comparable: Usamos el valor del Select (el que eliges en el dropdown)
                $compRating = (float)($this->comparableFactors[$comparableId]['conservacion_factor'] ?? 1.0);

                // 3. Diferencia: Sujeto - Comparable (Ej: 1.1 - 1.0 = 0.1)
                $diferencia_math = $sujetoRating - $compRating;

                // 4. Aplicable: 1 + Diferencia (Ej: 1 + 0.1 = 1.1)
                $aplicable = 1.0 + $diferencia_math;

                // El rating que guardamos es el del comparable para la base de datos
                $rating_to_save = $compRating;
            }


            else {
                // Default
                $diferencia_math = $sujetoRating - $compRating;
                $aplicable = 1.0 + $diferencia_math;
                $rating_to_save = $compRating;
            }

            // 7. ACTUALIZAR ARRAY VISUAL
            $this->comparableFactors[$comparableId][$sigla]['calificacion'] = number_format($compRating, 4, '.', '');
            $this->comparableFactors[$comparableId][$sigla]['diferencia'] = number_format($diferencia_math, 4, '.', '');
            $this->comparableFactors[$comparableId][$sigla]['aplicable'] = number_format($aplicable, 4, '.', '');

            $factorResultante *= $aplicable;

            // 8. GUARDAR EN BD
            if ($pivotId) {
                HomologationComparableFactorModel::updateOrCreate(
                    [
                        'valuation_building_comparable_id' => $pivotId,
                        'acronym' => $sigla,
                        'homologation_type' => 'building'
                    ],
                    [
                        'rating' => $rating_to_save,
                        'applicable' => $aplicable,
                    ]
                );
            }
        }

        // Finales
        //$factorResultante *= $conservacion_factor;
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

        $valoresOferta = $selectedComparables->pluck('comparable_unit_value')->map(fn($v) => (float)$v);
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





        // ==========================================================
        // == LÓGICA DE CIERRE Y PERSISTENCIA (AQUÍ ESTÁ EL CAMBIO) ==
        // ==========================================================

        // 1. Aplicar Redondeo al Promedio Homologado (Segunda columna)
        // Esto cumple tu requisito: "El total asignado sea el promedio de los valores homologados"
        $valorRedondeado = $this->redondearValor($avgHomologado, $this->conclusion_tipo_redondeo);

        // 2. Actualizar Vista
        $this->conclusion_valor_unitario_de_venta = $this->format_currency($valorRedondeado, true);

        // 3. GUARDAR EN BD AUTOMÁTICAMENTE
        // Usamos updateOrCreate para que si ya existe, solo actualice el valor y el tipo de redondeo
        HomologationBuildingAttributeModel::updateOrCreate(
            ['valuation_id' => $this->idValuation],
            [
                // Guardamos el valor YA calculado y redondeado
                'unit_value_mode_lot' => $valorRedondeado,

                // Guardamos la configuración del select
                'conclusion_type_rounding' => $this->conclusion_tipo_redondeo,
                'average_arithmetic' => $avgOferta ?? 0,
                'average_homologated' => $avgHomologado ?? 0
            ]
        );






        // GRAFICAS
        $labels = $selectedComparables->pluck('id')->map(fn($id) => "C-$id")->values()->toArray();
        $dataOfertaChart = $valoresOferta->values()->toArray();
        $dataHomologadoChart = $valoresHomologados->values()->toArray();

        $chartData1 = [
            'labels' => $labels,
            'datasets' => [
                [
                    'type' => 'line',
                    'label' => 'Valor Homologado',
                    'data' => $dataHomologadoChart,
                    'borderColor' => '#DC2626',
                    'backgroundColor' => '#DC2626',
                    'borderWidth' => 2,
                    'pointRadius' => 4,
                    'pointBackgroundColor' => '#DC2626',
                    'fill' => false,
                    'tension' => 0.1,
                    'order' => 0,
                ],
                [
                    'type' => 'bar',
                    'label' => 'Valor Unitario',
                    'data' => $dataOfertaChart,
                    'backgroundColor' => '#14B8A6',
                    'borderColor' => '#14B8A6',
                    'borderWidth' => 1,
                    'order' => 1,
                ]
            ]
        ];

        $chartData2 = [
            'labels' => $labels,
            'datasets' => [
                [
                    'type' => 'bar',
                    'label' => 'Valor Homologado',
                    'data' => $dataHomologadoChart,
                    'backgroundColor' => '#DC2626',
                    'borderRadius' => 4,
                    'barPercentage' => 0.6,
                ]
            ]
        ];

        $this->dispatch('updateBuildingChart1', data: $chartData1);
        $this->dispatch('updateBuildingChart2', data: $chartData2);
    }

   /*  private function syncComparableFactorNames($oldAcronym, $newName, $newAcronym)
    {
        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');
        if ($pivotIds->isEmpty()) return;
        HomologationComparableFactorModel::whereIn('valuation_building_comparable_id', $pivotIds)
            ->where('acronym', $oldAcronym)->where('homologation_type', 'building')
            ->update(['factor_name' => $newName, 'acronym' => $newAcronym]);
    } */

    private function mapSelectValue(string $key, string $optionType): float
    {
        $options = [
            'clase' => ['Precario' => 1.7500, 'Clase B' => 1.0000, 'Clase C' => 0.8000],
            'conservacion' => ['Buena' => 1.0000, 'Regular' => 0.9000, 'Mala' => 0.8000],
            'localizacion' => ['Lote intermedio' => 1.0000, 'Esquina' => 1.0500]
        ];
        return $options[$optionType][$key] ?? 1.0000;
    }

    private function getEmptyChartData(): array
    {
        return ['labels' => [], 'datasets' => []];
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
            'default' => round($v, 0)
        };
    }
    private function resetConclusionProperties()
    {
        $this->conclusion_promedio_oferta = '0.00';
        $this->conclusion_valor_unitario_homologado_promedio = '0.00';
    }

    // --- MÉTODOS PÚBLICOS DE INTERFAZ ---
    // En public function saveNewFactor()

    public function saveNewFactor()
    {
        // 1. Validaciones (Aseguramos que la sigla sea única para que el loop no truene)
        $this->validate([
            'new_factor_name' => 'required|string|max:100',
            'new_factor_acronym' => [
                'required',
                'string',
                'max:10',
                'alpha_num',
                function ($attribute, $value, $fail) {
                    // Validación para evitar duplicados en la tabla de Sujetos
                    if (HomologationValuationFactorModel::where('valuation_id', $this->idValuation)
                        ->where('acronym', strtoupper($value))
                        ->where('homologation_type', 'building')->exists()
                    ) {
                        $fail('Ya existe esta sigla.');
                    }
                },
            ],
            'new_factor_rating' => 'required|numeric|min:0.8|max:1.2'
        ]);

        // 2. CREACIÓN DEL FACTOR EN EL SUJETO (¡OK!)
        $newSubjectFactor = HomologationValuationFactorModel::create([
            'valuation_id' => $this->idValuation,
            'factor_name' => $this->new_factor_name,
            'acronym' => strtoupper($this->new_factor_acronym),
            'rating' => $this->new_factor_rating,
            'homologation_type' => 'building',
            'is_editable' => true,
            'is_custom' => true,
        ]);

        // 3. RECUPERAR IDS DE COMPARABLES (Se obtienen los 3 IDs)
        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');

        // 4. 🔥 SINCRONIZACIÓN CORREGIDA EN TODOS LOS COMPARABLES (ANTI-1364) 🔥
        foreach ($pivotIds as $pivotId) {

            // El firstOrCreate intenta la inserción para CADA PIVOT ID.
            HomologationComparableFactorModel::firstOrCreate(
                [
                    'valuation_building_comparable_id' => $pivotId,
                    'acronym' => $newSubjectFactor->acronym,
                    'homologation_type' => 'building'
                ],
                [
                    // ATRIBUTOS PARA LA INSERCIÓN: Aquí estaban faltando los campos obligatorios
                    'factor_name' => $newSubjectFactor->factor_name,  // <-- CRÍTICO
                    'rating' => 1.0000,
                    'applicable' => 1.0000,
                    'is_custom' => true,
                    'is_editable' => true,
                ]
            );
        }

        // 5. Limpieza y Recarga
        $this->reset(['new_factor_name', 'new_factor_acronym', 'new_factor_rating']);
        $this->prepareSubjectFactorsForView();
        $this->loadAllComparableFactors();
        $this->loadComparableSelections();
        $this->recalculateConclusions();
        Toaster::success('Factor agregado correctamente');
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
        $this->loadComparableSelections();
        $this->recalculateConclusions();
        Toaster::success('Factor eliminado correctamente');
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
            Toaster::success('Ya existe este equipamiento');
            //$this->emit('dummy');
            //$this->success('Ya existe este equipamiento');
            //dd('Ya existe este equipamiento');
            return;
        }

        //$equipmentData = self::EQUIPMENT_MAP[$sourceKey] ?? ['unit' => 'PZA', 'value' => 0.00];

        $currentMap = $this->getCurrentPriceMap();
        $equipmentData = $currentMap[$sourceKey] ?? ['unit' => 'PZA', 'value' => 0.00];

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

        $unitPrice = ($qtySujeto > 0) ? ($totalVal / $qtySujeto) : 0;
        $differenceMoneyInitial = $totalVal;
        $pivotIds = $this->valuation->buildingComparablePivots()->pluck('id');

        foreach ($pivotIds as $pivotId) {
            $comparable = $this->comparables->where('id', $this->valuation->buildingComparablePivots->where('id', $pivotId)->first()->comparable_id)->first();
            $valorOfertaComparable = (float)($comparable->comparable_offers ?? 0);
            $pctInitial = ($valorOfertaComparable > 0) ? ($differenceMoneyInitial / $valorOfertaComparable) * 100 : 0;

            HomologationComparableEquipmentModel::create([
                'valuation_equipment_id' => $subjectEq->id,
                'valuation_building_comparable_id' => $pivotId,
                'description' => $subjectEq->description,
                'unit' => $subjectEq->unit,
                'quantity' => 0.00,
                'difference' => $differenceMoneyInitial,
                'percentage' => $pctInitial,
            ]);

            $this->calculateEquipmentFactor($pivotId);
        }

        $this->reset(['new_eq_description', 'new_eq_quantity', 'new_eq_total_value', 'new_eq_other_description']);
        $this->loadEquipmentData();
        $this->recalculateConclusions();
        Toaster::success('Equipamiento agregado.');
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

        // 1. Determinar si es Custom o Estándar
        // Agregamos chequeo de 'Otro' por seguridad
        $isOther = !empty($eq->custom_description) || $eq->description === 'Otro';

        // 2. Obtener el Mapa de Precios Dinámico (El cambio clave)
        $currentMap = $this->getCurrentPriceMap();

        // Precio unitario base (si es estándar)
        $refValue = $currentMap[$eq->description]['value'] ?? 0;

        // 3. Calcular Total
        if ($isOther) {
            // Si es custom, respetamos el valor total manual
            $totalVal = (float)$this->edit_eq_total_value;
            // Calculamos el precio unitario implícito para usarlo en las diferencias
            $unitPriceCalc = ($this->edit_eq_quantity > 0) ? ($totalVal / $this->edit_eq_quantity) : 0;
        } else {
            // Si es estándar, multiplicamos cantidad nueva * precio de la clase actual
            $totalVal = $this->edit_eq_quantity * $refValue;
            $unitPriceCalc = $refValue;
        }

        $newDescription = $isOther ? $this->edit_eq_other_description : $eq->description;

        // 4. Actualizar Sujeto
        $eq->update([
            'quantity' => $this->edit_eq_quantity,
            'total_value' => $totalVal,
            'custom_description' => $isOther ? $this->edit_eq_other_description : null,
            'description' => $newDescription
        ]);

        // 5. Actualizar Nombres en Comparables
        HomologationComparableEquipmentModel::where('valuation_equipment_id', $eq->id)
            ->update(['description' => $newDescription]);

        // 6.  CRÍTICO: Recalcular Matemáticas de los Comparables
        // Al cambiar la cantidad del sujeto, cambia la "Diferencia" ($) y el "Porcentaje" en los comparables
        $compEquipments = HomologationComparableEquipmentModel::where('valuation_equipment_id', $eq->id)->get();

        foreach ($compEquipments as $compEq) {
            $pivot = $this->valuation->buildingComparablePivots->firstWhere('id', $compEq->valuation_building_comparable_id);
            if (!$pivot) continue;

            $comparable = $this->comparables->firstWhere('id', $pivot->comparable_id);
            if (!$comparable) continue;

            $valorOferta = (float)($comparable->comparable_offers ?? 0);

            // Diferencia de Cantidades (Sujeto - Comparable)
            $qtyComparable = (float)$compEq->quantity;
            $diffQty = $this->edit_eq_quantity - $qtyComparable;

            // Diferencia en Dinero (Diferencia Cantidad * Precio Unitario)
            $newDifferenceMoney = $diffQty * $unitPriceCalc;

            // Nuevo Porcentaje de Ajuste
            $newPct = ($valorOferta > 0) ? ($newDifferenceMoney / $valorOferta) * 100 : 0;

            $compEq->update([
                'difference' => $newDifferenceMoney,
                'percentage' => $newPct
            ]);

            // Recalculamos el Factor FEQ de este comparable específico
            $this->calculateEquipmentFactor($pivot->id);
        }

        $this->loadEquipmentData();
        $this->cancelEditEquipment();
        $this->recalculateConclusions();
        Toaster::success('Editado correctamente');
    }

    public function deleteEquipment($subjectEqId)
    {
        $eq = HomologationValuationEquipmentModel::find($subjectEqId);
        if ($eq) {
            HomologationComparableEquipmentModel::where('valuation_equipment_id', $subjectEqId)->delete();
            $eq->delete();
            $this->loadEquipmentData();
            $this->recalculateConclusions();
            Toaster::error('Eliminado.');
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

        $unitPrice = ($subjectEq->quantity > 0) ? ($subjectEq->total_value / $subjectEq->quantity) : 0;
        $qtySujeto = (float)$subjectEq->quantity;
        $qtyComparable = (float)$newQty;

        $diffQty = $qtySujeto - $qtyComparable;
        $differenceMoney = $diffQty * $unitPrice;
        $pct = ($valorOfertaComparable > 0) ? ($differenceMoney / $valorOfertaComparable) * 100 : 0;

        $compEq->update([
            'quantity' => $newQty,
            'difference' => $differenceMoney,
            'percentage' => $pct
        ]);

        $this->calculateEquipmentFactor($pivot->id);
        $this->loadEquipmentData();
        $this->recalculateConclusions();

        Toaster::success('Cantidad actualizada');
    }

    public function calculateEquipmentFactor($pivotId)
    {
        $equipments = HomologationComparableEquipmentModel::where('valuation_building_comparable_id', $pivotId)->get();
        $sumPercentages = $equipments->sum('percentage');
        $decimalSum = $sumPercentages / 100;

        $feq = 1 + $decimalSum;

        HomologationComparableFactorModel::updateOrCreate(
            ['valuation_building_comparable_id' => $pivotId, 'acronym' => 'FEQ', 'homologation_type' => 'building'],
            [
                'rating' => 1.0000,
                'applicable' => $feq,
                'factor_name' => 'Factor Equipamiento'
            ]
        );

        $comparableId = $this->valuation->buildingComparablePivots()->find($pivotId)->comparable_id;

        if (!isset($this->comparableFactors[$comparableId]['FEQ'])) {
            $this->initializeComparableFactorStructure($comparableId, 'FEQ');
        }

        $this->comparableFactors[$comparableId]['FEQ']['aplicable'] = number_format($feq, 4, '.', '');
        $this->comparableFactors[$comparableId]['FEQ']['diferencia'] = number_format($decimalSum, 4, '.', '');

        $this->recalculateSingleComparable($comparableId);
    }

    // --- GUARDADO DE GRÁFICAS (Igual que en Lands) ---
    public function saveChartImage($base64Image, $chartName)
    {
        try {
            // 1. Limpiar la cadena base64
            // Viene como "data:image/jpeg;base64,/9j/4AAQSw..."
            if (strpos($base64Image, ',') !== false) {
                $image_parts = explode(";base64,", $base64Image);
                $image_base64 = base64_decode($image_parts[1]);
            } else {
                $image_base64 = base64_decode($base64Image);
            }

            // 2. Definir nombre y ruta
            // Guardamos en: storage/app/public/homologation/buildings/
            // Nombre: chart_{valuation_id}_{chartName}.jpg
            $fileName = "chart_{$this->idValuation}_{$chartName}.jpg";
            $path = "homologation/buildings/{$fileName}";

            // 3. Guardar en disco público
            Storage::disk('public')->put($path, $image_base64);

            // Opcional: Log para verificar (quítalo después)
            // \Log::info("Imagen guardada: $path");

        } catch (\Exception $e) {
            // Si falla, no rompemos el flujo, solo lo registramos
            Log::error("Error guardando gráfica building: " . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.forms.homologation-buildings');
    }
}
