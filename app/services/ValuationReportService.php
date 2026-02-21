<?php

namespace App\Services;

use App\Helpers\NumberToLetter;
use App\Models\Forms\ApplicableSurface\ApplicableSurfaceModel;
use App\Models\Forms\Building\BuildingModel;
use App\Models\Forms\Comparable\ValuationBuildingComparableModel;
use App\Models\Forms\Conclusions\ConclusionModel;
use App\Models\Forms\DeclarationWarning\DeclarationsWarningsModel;
use App\Models\Forms\Homologation\HomologationBuildingAttributeModel;
use App\Models\Forms\Homologation\HomologationComparableFactorModel;
use App\Models\Forms\Homologation\HomologationLandAttributeModel;
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\LandDetails\LandDetailsModel;
use App\Models\Forms\MarketFocus\MarketFocusModel;
use App\Models\Forms\PhotoReport\PhotoReportModel;

use App\Models\Forms\PropertyDescription\PropertyDescriptionModel;
use App\Models\Forms\PropertyLocation\PropertyLocationModel;
use App\Models\Forms\UrbanEquipment\UrbanEquipmentModel;
use App\Models\Forms\UrbanFeatures\UrbanFeaturesModel;
use App\Models\Valuations\Valuation;
use App\Services\ValuationCalculatorService;
use Barryvdh\DomPDF\Facade\Pdf;
use setasign\Fpdi\Fpdi; // Requiere: composer require setasign/fpdf setasign/fpdi

class ValuationReportService
{
    protected $dipomexService;
    protected $headerType = 'ESTUDIO ÁLAMO: ARQUITECTURA + VALUACIÓN';
    protected $sections = ['cover' => true, 'photos' => true, 'comparables' => true, 'map' => false, 'annexes' => false];

    public function __construct(DipomexService $dipomexService)
    {
        $this->dipomexService = $dipomexService;
    }


    public function makePdf($id)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300);

        $valuation = Valuation::findOrFail($id);

        $valuation->loadMissing('homologationLandAttributes');

        // 2. CÁLCULO DE T/C MANUAL (Para asegurar que no llegue en 0)
        if ($valuation->homologationLandAttributes) {
            $supTerreno = (float)($valuation->homologationLandAttributes->subject_surface_value ?? 0);
            $supConst   = (float)($valuation->property_construction_area ?? 0);

            // Forzamos el valor en el atributo para que el Blade lo vea
            $valuation->homologationLandAttributes->tc_relation = ($supConst > 0) ? ($supTerreno / $supConst) : 0;
        }

        $calculator = new ValuationCalculatorService(); // <--- Instanciamos la calculadora

        // 1. OBTENER VALORES FRESCOS (Recalculados al momento)
        $freshValues = $calculator->calculateValues($id);

        // 2. OBTENER PREFERENCIAS DEL USUARIO (Redondeo y Selección)
        $conclusionConfig = ConclusionModel::where('valuation_id', $id)->first();

        // Defaults por si no ha entrado a la sección de conclusión
        $selectedType = $conclusionConfig->selected_value_type ?? 'physical';
        $roundingType = $conclusionConfig->rounding ?? 'Sin redondeo';
        $manualValue  = $conclusionConfig->other_value ?? 0;

        // 3. SELECCIONAR EL VALOR BASE SEGÚN LA PREFERENCIA
        $baseValue = 0;
        // Nota: Asegúrate que las llaves del array coincidan con lo que retorna tu CalculatorService
        if ($freshValues) {
            switch ($selectedType) {
                case 'land':
                    $baseValue = $freshValues['landValue'];
                    break;
                case 'market':
                    $baseValue = $freshValues['marketValue'];
                    break;
                case 'hypothetical':
                    $baseValue = $freshValues['hypotheticalValue'];
                    break;
                case 'physical':
                    $baseValue = $freshValues['physicalValue'];
                    break;
                case 'other':
                    $baseValue = $manualValue;
                    break;
            }
        }
        $valorConcluidoFinal = $this->applyRounding($baseValue, $roundingType);

        // 5. GENERAMOS EL TEXTO
        if ($valorConcluidoFinal > 0) {
            $valorConcluidoTexto = NumberToLetter::convert($valorConcluidoFinal);
        } else {
            $valorConcluidoTexto = 'VALOR NO ASIGNADO';
        }

        // =========================================================================
        // --- LÓGICA DE NOMBRES (DIPOMEX) ---
        // =========================================================================

        // 1. Obtener estados una sola vez
        $estados = $this->dipomexService->getEstados();

        // 2. Cache local para no repetir peticiones si el estado es el mismo
        $municipiosCache = [];

        $getNombreMunicipio = function ($estadoId, $municipioId) use (&$municipiosCache) {
            if (!$estadoId || !$municipioId) return 'N/A';

            // Si no hemos cargado los municipios de este estado, los traemos
            if (!isset($municipiosCache[$estadoId])) {
                $municipiosCache[$estadoId] = $this->dipomexService->getRawMunicipiosPorEstado($estadoId);
            }

            // Buscamos el nombre del municipio en el array del estado
            foreach ($municipiosCache[$estadoId] as $mun) {
                if ($mun['MUNICIPIO_ID'] == $municipioId) {
                    return $mun['MUNICIPIO'];
                }
            }
            return 'N/A';
        };

        // 3. Asignación de nombres para la vista
        $estadoInmueble = $estados[$valuation->property_entity] ?? 'N/A';
        $municipioInmueble = $getNombreMunicipio($valuation->property_entity, $valuation->property_locality);

        $estadoSolicitante = $estados[$valuation->applic_entity] ?? 'N/A';
        $municipioSolicitante = $getNombreMunicipio($valuation->applic_entity, $valuation->applic_locality);

        $estadoPropietario = $estados[$valuation->owner_entity] ?? 'N/A';
        $municipioPropietario = $getNombreMunicipio($valuation->owner_entity, $valuation->owner_locality);
        // =========================================================================
        // --- LÓGICA DE COORDENADAS ---
        // =========================================================================
        // Buscamos en la tabla correcta
        $propLocation = PropertyLocationModel::where('valuation_id', $id)->first();

        // Preparamos las variables individuales (si no existe, asignamos guion)
        $latitude  = $propLocation->latitude ?? '-';
        $longitude = $propLocation->longitude ?? '-';
        $altitude  = $propLocation->altitude ?? '-';



        // =========================================================================
        // --- LÓGICA DE CONCLUSIÓN DE VALOR  ---
        // =========================================================================
        $conclusionModel = ConclusionModel::where('valuation_id', $id)->first();

        // 1. Valores Individuales para la tabla "Resumen de Valores"
        $finalLandValue = $freshValues['landValue'] ?? 0;
        $finalMarketValue = $freshValues['marketValue'] ?? 0;
        $finalHypotheticalValue = $freshValues['hypotheticalValue'] ?? 0;
        $finalPhysicalValue = $freshValues['physicalValue'] ?? 0;
        // El de rentas creo que no lo calculamos, pero lo dejamos en 0 o lo sacas si lo tienes
        $finalIncomeValue = 0;

        // Obtenemos el valor numérico (o 0 si no existe)
       // $valorConcluido = $conclusionModel ? (float)$conclusionModel->concluded_value : 0;

        // Convertimos a texto usando el Helper
        //$valorConcluidoTexto = NumberToLetter::convert($valorConcluido);





        // =========================================================================
        // --- LÓGICA DE DECLARACIONES ---
        // =========================================================================
        $declarationsWarnings = DeclarationsWarningsModel::where('valuation_id', $id)->first();

        // AQUÍ ESTABA EL ERROR: Usabas $declarations en lugar de $declarationsWarnings
        $dec_idDoc       = ($declarationsWarnings->id_doc ?? 0) == 1 ? 'SI COINCIDE' : 'NO COINCIDE';
        $dec_areaDoc     = ($declarationsWarnings->area_doc ?? 0) == 1 ? 'SI COINCIDE' : 'NO COINCIDE';
        $dec_constState  = ($declarationsWarnings->const_state ?? 0) == 1 ? 'VALIDADO' : 'NO VALIDADO';
        $dec_occupancy   = ($declarationsWarnings->occupancy ?? 0) == 1 ? 'VALIDADO' : 'NO VALIDADO';
        $dec_urbanPlan   = ($declarationsWarnings->urban_plan ?? 0) == 1 ? 'SI COINCIDE' : 'NO COINCIDE';

        // INAH / INBA (1=Si, 2=No, 0=No verificado)
        $dec_inahMonument = match ((int)($declarationsWarnings->inah_monument ?? 0)) {
            1 => 'SI CONSIDERADO',
            2 => 'NO ES CONSIDERADO',
            default => 'NO SE VERIFICÓ',
        };

        $dec_inbaHeritage = match ((int)($declarationsWarnings->inba_heritage ?? 0)) {
            1 => 'SI CONSIDERADO',
            2 => 'NO ES CONSIDERADO',
            default => 'NO SE VERIFICÓ',
        };

        // Advertencias y Limitaciones
        $otherNotes       = $declarationsWarnings->other_notes ?? '';
        $additionalLimits = $declarationsWarnings->additional_limits ?? '';







        // =========================================================================
        // --- CARACTERÍSTICAS URBANAS (ENTORNO) ---
        // =========================================================================
        $urbanFeatures = UrbanFeaturesModel::where('valuation_id', $id)->first();

        // Helper rápido para limpiar los prefijos tipo "1. ", "2. " de los selects
        $clean = function ($val) {
            return $val ? preg_replace('/^\d+\.\s*/', '', $val) : '';
        };

        // Mapeo de variables
        $urb_zoneClass   = $clean($urbanFeatures->zone_classification ?? '');
        $urb_popDensity  = $clean($urbanFeatures->population_density ?? '');

        $urb_landUse     = $urbanFeatures->land_use ?? '';
        $urb_housingDen  = $clean($urbanFeatures->housing_density ?? '');

        $urb_source      = $urbanFeatures->description_source_land ?? '';
        $urb_freeArea    = $urbanFeatures->mandatory_free_area ?? 0;

        $urb_levels      = $urbanFeatures->allowed_levels ?? 0;
        // Nota: "Reporte de densidad" no vi input en tu form, dejo el default o vacío
        $urb_densityRep  = 'Reglamentación vigente';

        $urb_constUsage  = $clean($urbanFeatures->building_usage ?? '');
        $urb_socioLevel  = $clean($urbanFeatures->zone_socioeconomic_level ?? '');

        $urb_saturation  = $clean($urbanFeatures->zone_saturation_index ?? ''); // Asumo que viene el número o texto

        $urb_access      = $urbanFeatures->access_routes_importance ?? '';
        $urb_constDomin  = $urbanFeatures->predominant_buildings ?? '';
        $urb_pollution   = $clean($urbanFeatures->environmental_pollution ?? '');



        // =========================================================================
        // --- EQUIPAMIENTO URBANO ---
        // =========================================================================
        $urbanEq = UrbanEquipmentModel::where('valuation_id', $id)->first();

        // Helper para Cantidades (Ej: 1, 5, -)
        $qty = function ($val) {
            return ($val && $val > 0) ? $val : '-';
        };

        // Helper para Distancias/Tiempo (Ej: 500 Mts, 10 Min, -)
        $measure = function ($val, $unit) {
            return ($val && $val > 0) ? $val . ' ' . $unit : '-';
        };

        // --- FILA 1 ---
        $eq_church      = $qty($urbanEq->church ?? 0);
        $eq_commCenter  = $qty($urbanEq->community_center ?? 0); // Lo mapeo a "Centro Com"
        $eq_bank        = $qty($urbanEq->bank ?? 0);

        // --- FILA 2 (Parques, Escuelas, Mercado) ---
        // Parques
        $eq_gardens     = $qty($urbanEq->gardens ?? 0);
        $eq_parks       = $qty($urbanEq->parks ?? 0);
        $eq_courts      = $qty($urbanEq->sports_courts ?? 0);
        $eq_sportsCenter = $qty($urbanEq->sports_center ?? 0);

        // Escuelas
        $eq_primary     = $qty($urbanEq->primary_school ?? 0);
        $eq_middle      = $qty($urbanEq->middle_school ?? 0);
        $eq_high        = $qty($urbanEq->high_school ?? 0);
        $eq_univ        = $qty($urbanEq->university ?? 0);
        $eq_otherSch    = $qty($urbanEq->other_nearby_schools ?? 0);

        // Mercados
        $eq_market      = $qty($urbanEq->market ?? 0);
        $eq_super       = $qty($urbanEq->super_market ?? 0);
        $eq_commSpaces  = $qty($urbanEq->commercial_spaces ?? 0);       // Locales
        $eq_numComm     = $qty($urbanEq->number_commercial_spaces ?? 0); // Comerciales (Cantidad)

        // --- FILA 3 (Hospitales, Transporte, Plaza) ---
        // Hospitales
        $eq_hosp1       = $qty($urbanEq->first_level ?? 0);
        $eq_hosp2       = $qty($urbanEq->second_level ?? 0);
        $eq_hosp3       = $qty($urbanEq->third_level ?? 0);

        // Transporte (Aquí SÍ usamos el helper de medida porque capturaste distancia/tiempo)
        $eq_transUrb    = $measure($urbanEq->urban_distance ?? 0, 'Mts.');
        $eq_transFreq   = $measure($urbanEq->urban_frequency ?? 0, 'Min.');

        // Plaza Pública
        $eq_plaza       = $qty($urbanEq->public_square ?? 0);
        // Nota: "Ref. urbana" no viene en tu modelo, lo dejo como guión o estático si prefieres
        $eq_refUrbana   = '-';

        // =========================================================================
        // --- INFRAESTRUCTURA Y SERVICIOS ---
        // =========================================================================

        // Buscamos el registro. Nota: Es el mismo modelo que $urbanFeatures
        $infra = UrbanFeaturesModel::where('valuation_id', $id)->first();

        // 1. FLAG MAESTRO: Buscamos la columna en snake_case.
        // Si no se llama 'all_services', intenta 'inf_all_services' o quita esta línea.
        $hasAllServices = (bool) ($infra->all_services ?? $infra->inf_all_services ?? false);

        // --- HELPERS ---

        $clean = function ($val) {
            if (!$val) return '-';
            return preg_replace('/^\d+\.\s*/', '', $val);
        };

        $material = function ($main, $other) use ($clean) {
            if (!$main) return '-';
            $lower = strtolower($main);
            if (str_contains($lower, 'otro')) return $other ? $other : 'Otro';
            if (str_contains($lower, 'no presenta') || str_contains($lower, 'no existe')) return 'No existe';
            return $clean($main);
        };

        // Lógica binaria: Si tiene "todos los servicios" O el valor es 1 -> Existe
        $binary = function ($val) use ($hasAllServices) {
            if ($hasAllServices) return 'Existe';
            return ((int)$val === 1) ? 'Existe' : 'No existe';
        };

        // --- ASIGNACIÓN CON NOMBRES DE COLUMNA SNAKE_CASE ---
        // Aquí está la magia: cambiamos inf_roadways -> roadways (o inf_roadways en minúscula)

        // 1. VIALIDADES (Probamos roadways o inf_roadways)
        $inf_vialidades = $material($infra->roadways ?? $infra->inf_roadways ?? null, $infra->roadways_others ?? $infra->inf_roadways_others ?? null);

        // 2. GUARNICIONES
        $inf_guarniciones = $material($infra->curbs ?? $infra->inf_curbs ?? null, $infra->curbs_others ?? $infra->inf_curbs_others ?? null);

        // 3. ALUMBRADO
        $valAlumbrado = (int)($infra->public_lighting ?? $infra->inf_public_lighting ?? 0);
        $inf_alumbrado = match ($valAlumbrado) {
            2 => 'Aéreo',
            3 => 'Subterráneo',
            default => ($hasAllServices && $valAlumbrado === 0) ? 'Aéreo' : 'No existe',
        };

        // 4. AGUA POTABLE
        $valAgua = (int)($infra->water_distribution ?? $infra->inf_water_distribution ?? 0);
        $inf_agua = ($hasAllServices || $valAgua === 1) ? 'Con suministro' : 'Sin suministro';

        // 5. DRENAJE (AGUAS RESIDUALES)
        $valDrenaje = (int)($infra->wastewater_collection ?? $infra->inf_wastewater_collection ?? 0);
        $inf_drenaje = match ($valDrenaje) {
            1 => 'Con conexión',
            2 => 'Sin conexión',
            default => ($hasAllServices) ? 'Con conexión' : 'No existe',
        };

        // 6. DRENAJE PLUVIAL (ZONA)
        $inf_drenaje_pluvial = $binary($infra->zone_storm_drainage ?? $infra->inf_zone_storm_drainage ?? 0);

        // 7. OTRO DESALOJO (Sin hasAllServices)
        $valOtro = (int)($infra->other_water_disposal ?? $infra->inf_other_water_disposal ?? 0);
        $inf_otro_desalojo = ($valOtro === 1) ? 'Existe' : 'No existe';

        // 8. BANQUETAS
        $inf_banquetas = $material($infra->sidewalks ?? $infra->inf_sidewalks ?? null, $infra->sidewalks_others ?? $infra->inf_sidewalks_others ?? null);

        // 9. GAS NATURAL
        $valGas = (int)($infra->natural_gas ?? $infra->inf_natural_gas ?? 0);
        $inf_gas = match ($valGas) {
            1 => 'Con acometida',
            2 => 'En la zona',
            default => 'No existe',
        };

        // 10. VIGILANCIA
        $valVigilancia = (int)($infra->security ?? $infra->inf_security ?? 0);
        $inf_vigilancia = match ($valVigilancia) {
            1 => 'Municipal',
            2 => 'Privada',
            default => 'No existe',
        };

        // 11. ACOMETIDA ELÉCTRICA
        $valAcomElec = (int)($infra->electrical_connection ?? $infra->inf_electrical_connection ?? 0);
        $inf_acometida_elec = ($hasAllServices || $valAcomElec === 1) ? 'Existe' : 'No existe';

        // 12. DRENAJE CALLE
        $inf_drenaje_calle = $binary($infra->street_storm_drainage ?? $infra->inf_street_storm_drainage ?? 0);

        // 13. SISTEMA MIXTO
        $inf_sistema_mixto = $binary($infra->mixed_drainage_system ?? $infra->inf_mixed_drainage_system ?? 0);

        // 14. SUMINISTRO ELÉCTRICO
        $valSumElec = (int)($infra->electric_supply ?? $infra->inf_electric_supply ?? 0);
        $inf_suministro_elec = match ($valSumElec) {
            1 => 'Red aérea',
            2 => 'Red subterránea',
            3 => 'Red mixta',
            default => ($hasAllServices) ? 'Red aérea' : 'No existe',
        };

        // --- TABLA 2 (OTROS SERVICIOS) ---

        // Teléfonos Suministro
        $valTelSum = (int)($infra->telephone_service ?? $infra->inf_telephone_service ?? 0);
        $inf_telefonos_sum = match ($valTelSum) {
            1 => 'Red aérea',
            2 => 'Red subterránea',
            default => ($hasAllServices && $valTelSum === 0) ? 'Red aérea' : 'No existe',
        };

        $inf_senyalizacion = $binary($infra->road_signage ?? $infra->inf_road_signage ?? 0);
        $inf_recoleccion   = $binary($infra->garbage_collection ?? $infra->inf_garbage_collection ?? 0);
        $inf_acometida_tel = $binary($infra->telephone_connection ?? $infra->inf_telephone_connection ?? 0);
        $inf_nomenclatura  = $binary($infra->street_naming ?? $infra->inf_street_naming ?? 0);

        // Porcentaje Infraestructura
        $inf_porcentaje = $hasAllServices ? '100%' : '-';





        // =========================================================================
        // --- CARACTERÍSTICAS PARTICULARES DEL TERRENO ---
        // =========================================================================

        // 1. Cargar modelo con relaciones (Grupos de colindancias y vecinos)
        $land = LandDetailsModel::where('valuation_id', $id)
            ->with(['groupsNeighbors.neighbors'])
            ->first();

        // --- A) MAPEO DE ENUMS (Selects 1, 2, 3...) ---

        // Helper para mapear Ubicación
        $locMap = [
            '1' => 'Cabecera de manzana',
            '2' => 'Lote con dos frentes no contiguos',
            '3' => 'Lote en esquina',
            '4' => 'Lote interior',
            '5' => 'Lote intermedio',
            '6' => 'Manzana completa',
        ];
        $land_location = $locMap[$land->location ?? ''] ?? 'N/A';

        // Helper para Topografía
        $topoMap = [
            '1' => 'Plano',
            '2' => 'Accidentado',
            '3' => 'Con pendiente ascendente',
            '4' => 'Con pendiente descendente',
        ];
        $land_topography = $topoMap[$land->topography ?? ''] ?? 'N/A';

        // Helper para Configuración
        // Nota: En tu livewire guardas "1. Regular", así que limpiamos el número
        $cleanConf = function ($val) {
            return preg_replace('/^\d+\.\s*/', '', $val ?? '');
        };
        $land_configuration = $cleanConf($land->configuration);

        // Helper para Tipo de Vialidad
        $roadMap = [
            '1' => 'Calle inferior a la moda',
            '2' => 'Calle moda',
            '3' => 'Calle superior a la moda',
            '4' => 'Calle con frente a parque/plaza',
        ];
        $land_roadType = $roadMap[$land->type_of_road ?? ''] ?? 'N/A';


        // --- B) VIALIDADES Y COLINDANCIAS (Datos fijos) ---
        $land_streetFront = $land->street_with_front ?? '';

        // Transversales
        $land_crossStreet1 = $land->cross_street_1 ?? '';
        $land_crossOrient1 = $land->cross_street_orientation_1 ?? '';
        // Combinamos si hay segunda calle transversal, o solo mostramos la primera
        $land_crossStreets = $land_crossStreet1;
        if (!empty($land->cross_street_2)) {
            $land_crossStreets .= ' / ' . $land->cross_street_2;
        }

        // Limítrofes
        $land_borderStreet1 = $land->border_street_1 ?? '';
        $land_borderOrient1 = $land->border_street_orientation_1 ?? '';
        $land_borderStreets = $land_borderStreet1;
        if (!empty($land->border_street_2)) {
            $land_borderStreets .= ' / ' . $land->border_street_2;
        }

        $land_panoramic   = $land->panoramic_features ?? 'Sin relevancia';

        // Restricciones: Si es "Otras", mostramos el texto especificado
        $land_restrictions = $land->easement_restrictions ?? '';
        if (str_contains(strtolower($land_restrictions), 'otras') || $land_restrictions == 'Otras') {
            $land_restrictions = $land->easement_restrictions_others ?? 'Otras';
        }


        // --- C) INFORMACIÓN LEGAL (Dinámica según el tipo) ---
        // Preparamos un array de "etiqueta" => "valor" para llenar la tabla de 3 filas x 2 cols

        // --- C) INFORMACIÓN LEGAL (Corregido sin guiones) ---
        $source = $land->source_legal_information ?? '';
        $legalData = [];

        switch ($source) {
            case 'Escritura':
                $legalData = [
                    ['Notaría:',   $land->notary_office_deed],
                    ['Fecha:',     $land->date_deed],
                    ['Escritura:', $land->deed_deed],
                    ['Notario:',   $land->notary_deed],
                    ['Volumen:',   $land->volume_deed],
                    ['Distrito:',  $land->judicial_distric_deed],
                ];
                break;

            case 'Sentencia':
                $legalData = [
                    ['Juzgado:',    $land->court_judgment],
                    ['Fecha:',      $land->date_judgment],
                    ['Expediente:', $land->file_judgment],
                    ['Municipio:',  $land->municipality_judgment],
                    ['Tipo:',       'Sentencia Definitiva'],
                    ['',            ''], // Relleno vacío
                ];
                break;

            case 'Contrato privado':
                $legalData = [
                    ['Tipo:',        'Contrato Privado'],
                    ['Fecha:',       $land->date_priv_cont],
                    ['Adquirente:',  $land->name_priv_cont_acq . ' ' . $land->first_name_priv_cont_acq],
                    ['Enajenante:',  $land->name_priv_cont_alt . ' ' . $land->first_name_priv_cont_alt],
                    ['', ''], // Relleno vacío
                    ['', ''], // Relleno vacío
                ];
                break;

            case 'Titulo de propiedad':
                $legalData = [
                    ['Registro:',    $land->record_prop_reg],
                    ['Fecha:',       $land->date_prop_reg],
                    ['Instrumento:', $land->instrument_prop_reg],
                    ['Lugar:',       $land->place_prop_reg],
                    ['', ''], // Relleno vacío
                    ['', ''], // Relleno vacío
                ];
                break;

            default:
                // Para "Otra fuente", "Alineamiento", etc.
                $legalData = [
                    ['Fuente:',      $source],
                    // Usamos Null Coalescing para buscar en ambos tipos de campos posibles
                    ['Folio:',       $land->folio_aon ?? $land->folio_asli ?? ''],
                    ['Fecha:',       $land->date_aon ?? $land->date_asli ?? ''],
                    ['Municipio:',   $land->municipality_aon ?? $land->emitted_by_asli ?? ''],
                    ['', ''], // Relleno vacío para que no salga el guion
                    ['', ''], // Relleno vacío para que no salga el guion
                ];
                break;
        }

        // --- D) MEDIDAS Y COLINDANCIAS (Grupos) ---
        // Pasamos directamente la colección $land->groupsNeighbors a la vista
        $neighborGroups = $land->groupsNeighbors ?? collect();





        // =========================================================================
        // --- LÓGICA DE CONSTRUCCIÓN (BLOQUE FALTANTE) ---
        // =========================================================================

        // 1. Cargamos las relaciones necesarias al vuelo
        $valuation->load([
            'constructionElement.structuralWork',
            'constructionElement.finishing1',
            'constructionElement.finishing2',
            'constructionElement.carpentry',
            'constructionElement.hydraulic',
            'constructionElement.ironWork',
            'constructionElement.otherElements',
            'constructionElement.finishingOtherElements'
        ]);

        $ce = $valuation->constructionElement;

        // Helpers locales para formateo
        $fmt = fn($val) => !empty($val) ? strtoupper($val) : 'NO PRESENTA';
        $fmtInst = fn($type, $text) => (!empty($type) || !empty($text))
            ? strtoupper(($type ?? '') . ' - ' . ($text ?? ''))
            : 'NO PRESENTA';

        if ($ce) {
            $st = $ce->structuralWork;
            $f1 = $ce->finishing1;
            $f2 = $ce->finishing2; // Revestimientos (Acabados 2)
            $cp = $ce->carpentry;
            $hs = $ce->hydraulic;
            $iw = $ce->ironWork;
            $oe = $ce->otherElements;

            $construction = [
                // 1. OBRA NEGRA (Mapeo con corrección de typos de BD)
                'structure'   => $fmt($st->structure ?? ''),
                'foundation'  => $fmt($st->shallow_fundation ?? ''), // Typo en BD
                'mezzanines'  => $fmt($st->intermeediate_floor ?? ''), // Typo en BD
                'roofs'       => $fmt($st->ceiling ?? ''),
                'walls'       => $fmt($st->walls ?? ''),
                'beams'       => $fmt($st->beams_columns ?? ''),
                'rooftops'    => $fmt($st->roof ?? ''),
                'fences'      => $fmt($st->fences ?? ''),

                // 2. REVESTIMIENTOS (Acabados 2 - Los 8 campos específicos)
                'revestimientos' => [
                    'plaster'  => $fmt($f2->cement_plaster ?? ''),
                    'ceilings' => $fmt($f2->ceilings ?? ''),
                    'wainscot' => $fmt($f2->furred_walls ?? ''),
                    'stairs'   => $fmt($f2->stairs ?? ''),
                    'floors'   => $fmt($f2->flats ?? ''),
                    'skirting' => $fmt($f2->plinths ?? ''),
                    'paint'    => $fmt($f2->paint ?? ''),
                    'special'  => $fmt($f2->special_coating ?? ''),
                ],

                // 3. MATRIZ DE ACABADOS (Acabados 1)
                'matrix' => [
                    'living'    => ['floors' => $fmt($f1->stdr_flats ?? ''), 'walls' => $fmt($f1->stdr_walls ?? ''), 'ceilings' => $fmt($f1->stdr_ceilings ?? '')],
                    'kitchen'   => ['floors' => $fmt($f1->kitchen_flats ?? ''), 'walls' => $fmt($f1->kitchen_walls ?? ''), 'ceilings' => $fmt($f1->kitchen_ceilings ?? '')],
                    'bedrooms'  => ['qty' => $f1->bedrooms_number ?? 0, 'floors' => $fmt($f1->bedrooms_flats ?? ''), 'walls' => $fmt($f1->bedrooms_walls ?? ''), 'ceilings' => $fmt($f1->bedrooms_ceilings ?? '')],
                    'bathrooms' => ['qty' => $f1->bathrooms_number ?? 0, 'floors' => $fmt($f1->bathrooms_flats ?? ''), 'walls' => $fmt($f1->bathrooms_walls ?? ''), 'ceilings' => $fmt($f1->bathrooms_ceilings ?? '')],

                    // AQUI ESTÁ EL SERVICIO QUE FALTABA (UTYR)
                    'service'   => ['floors' => $fmt($f1->utyr_flats ?? ''), 'walls' => $fmt($f1->utyr_walls ?? ''), 'ceilings' => $fmt($f1->utyr_ceilings ?? '')],

                    'stairs'    => ['floors' => $fmt($f1->stairs_flats ?? ''), 'walls' => $fmt($f1->stairs_walls ?? ''), 'ceilings' => $fmt($f1->stairs_ceilings ?? '')],
                    'parking_cov' => ['qty' => $f1->copa_number ?? 0, 'floors' => $fmt($f1->copa_flats ?? ''), 'walls' => $fmt($f1->copa_walls ?? ''), 'ceilings' => $fmt($f1->copa_ceilings ?? '')],
                    'balcony'   => ['floors' => $fmt($f1->hall_flats ?? ''), 'walls' => $fmt($f1->hall_walls ?? ''), 'ceilings' => $fmt($f1->hall_ceilings ?? '')], // Usando hall como balcón si aplica

                    'half_baths_qty' => $f1->half_bathrooms_number ?? 0,
                    'half_baths' => ['qty' => $f1->half_bathrooms_number ?? 0, 'floors' => $fmt($f1->half_bathrooms_flats ?? ''), 'walls' => $fmt($f1->half_bathrooms_walls ?? ''), 'ceilings' => $fmt($f1->half_bathrooms_ceilings ?? '')],
                ],

                // 4. CARPINTERÍA
                'carpentry' => [
                    'doors_access' => $fmt($cp->doors_access ?? ''),
                    'doors_inside' => $fmt($cp->inside_doors ?? ''),
                    'closets'      => $fmt($cp->fixed_furniture_inside_bedrooms ?? ''),
                    'furniture'    => $fmt($cp->fixed_furniture_bedrooms ?? ''),
                ],

                // 5. HERRERÍA
                'smithy' => [
                    'windows'      => $fmt($iw->windows ?? ''),
                    'service_door' => $fmt($iw->service_door ?? ''),
                    'others'       => $fmt($iw->others ?? ''),
                ],

                // 6. INSTALACIONES
                'installations' => [
                    'bath_furniture' => $fmt($hs->bathroom_furniture ?? ''),
                    'hydraulic'      => $fmtInst($hs->hidden_apparent_hydraulic_branches ?? '', $hs->hydraulic_branches ?? ''),
                    'sanitary'       => $fmtInst($hs->hidden_apparent_sanitary_branches ?? '', $hs->sanitary_branches ?? ''),
                    'electric'       => $fmtInst($hs->hidden_apparent_electrics ?? '', $hs->electrics ?? ''),
                ],

                // 7. OTROS (Vidriería, etc)
                'others' => [
                    'glass'     => $fmt($oe->structure ?? ''),
                    'locksmith' => $fmt($oe->locksmith ?? ''),
                    'facades'   => $fmt($oe->facades ?? ''),
                    'elevator'  => $fmt($oe->elevator ?? ''),
                ]
            ];

            $finishingOthers = $ce->finishingOtherElements ?? collect([]);
        } else {
            // Fallback por si no hay datos
            $construction = [];
            $finishingOthers = collect([]);
        }






        // =========================================================================
        // --- LÓGICA DE INSTALACIONES ESPECIALES (MODELO UNIFICADO) ---
        // =========================================================================

        // 1. Cargamos las 6 relaciones que definiste en tu modelo Valuation.
        //    Al usar load, traemos los datos listos para usar.
        $valuation->load([
            'privateInstallations',
            'privateAccessories',
            'privateWorks',
            'commonInstallations',
            'commonAccessories',
            'commonWorks'
        ]);

        // 2. Unificamos las PRIVATIVAS en una sola colección para el reporte
        //    Ordenamos por 'key' (Clave) para que se vean ordenadas (IE01, IE02...)
        $specialElementsPrivate = collect()
            ->merge($valuation->privateInstallations)
            ->merge($valuation->privateAccessories)
            ->merge($valuation->privateWorks)
            ->sortBy('key')
            ->values();

        // 3. Unificamos las COMUNES (si aplica)
        $specialElementsCommon = collect();

        // Verificamos si es condominio para procesar comunes
        if (stripos($valuation->property_type, 'condominio') !== false) {
            $specialElementsCommon = collect()
                ->merge($valuation->commonInstallations)
                ->merge($valuation->commonAccessories)
                ->merge($valuation->commonWorks)
                ->sortBy('key')
                ->values();
        }



        // =========================================================================
        // --- CÁLCULOS DEL ENFOQUE DE MERCADO  ---
        // =========================================================================

        // 1. Cargar modelos necesarios
        $landAttributes = HomologationLandAttributeModel::where('valuation_id', $id)->first();
        $buildingAttributes = HomologationBuildingAttributeModel::where('valuation_id', $id)->first();
        $applicableSurface = ApplicableSurfaceModel::where('valuation_id', $id)->first();
        $marketFocus = MarketFocusModel::where('valuation_id', $id)->first();
        $landDetail = LandDetailsModel::where('valuation_id', $id)->first();

        // 2. Variables Base (con validación de nulos)
        $landProbableValue = $landAttributes->unit_value_mode_lot ?? 0;
        $terrainSurface = $landAttributes->subject_surface_value ?? 0;
        $buildingProbableValue = $buildingAttributes->unit_value_mode_lot ?? 0;
        $saleableBuiltArea = $applicableSurface->built_area ?? 0;
        $surplusPercentage = $marketFocus->surplus_percentage ?? 100;

        // --- CÁLCULO TABLA 2: VALOR DEL TERRENO ---
        $marketUnitValue = $landProbableValue;
        $totalTerrainAmount = $terrainSurface * $marketUnitValue;
        $applicableUndividedPercent = 100; // Valor fijo según tu lógica actual
        $terrainValue = $totalTerrainAmount; // Valor del Terreno Propiedad

        // --- CÁLCULO DE EXCEDENTES ---
        // Verificamos el switch en LandDetails y si hay superficie privativa
        $useExcessCalculation = $landDetail ? (bool)$landDetail->use_excess_calculation : false;

        // Inicializamos variables de excedente en 0
        $valTerrenoExcedente = 0;
        $valLotePrivativo = 0;
        $valLoteTipo = 0;
        $showExcessSection = false;

        if ($useExcessCalculation && $applicableSurface && $applicableSurface->private_lot > 0) {
            $showExcessSection = true;
            $privateLot = (float)$applicableSurface->private_lot;
            $privateLotType = (float)$applicableSurface->private_lot_type;

            // Cálculos intermedios
            $valLotePrivativo = $privateLot * $marketUnitValue;
            $valLoteTipo = $privateLotType * $marketUnitValue;
            $valDiferenciaExcedente = $valLotePrivativo - $valLoteTipo;

            // Aplicar porcentaje
            $factor = $surplusPercentage / 100;
            $valTerrenoExcedente = $valDiferenciaExcedente * $factor;
        }

        // --- CÁLCULO TABLA 3: VALOR CONSTRUCCIONES ---
        $constructionMarketUnitValue = $buildingProbableValue;

        // Valor base (Sup. Vendible * Valor Unitario)
        $baseConstructionValue = $saleableBuiltArea * $constructionMarketUnitValue;

        // --- CORRECCIÓN AQUÍ ---
        // Antes sumaba el excedente, ahora NO. Son el mismo valor.
        $marketValueTotal = $baseConstructionValue;

        // --- CONVERSIÓN A LETRAS USANDO TU HELPER ---
        // Usamos tu clase NumberToLetter
        $amountInLetters = NumberToLetter::convert($marketValueTotal);






        // =========================================================================
        // --- IV. ENFOQUE DE COSTOS (Ross-Heidecke & Proporcionales) ---
        // =========================================================================
        // 1. Cargar Datos Base
        $surfaceModel = ApplicableSurfaceModel::where('valuation_id', $id)->first();
        $homologationModel = HomologationLandAttributeModel::where('valuation_id', $id)->first();
        $buildingModel = BuildingModel::where('valuation_id', $id)->first();
        $lifeValuesConfig = config('properties_inputs.construction_life_values', []);

        // 2. PROCESAMIENTO DEL TERRENO
        $landSurface = $surfaceModel->surface_area ?? 0.0;
        $landIndiviso = $surfaceModel->applicable_undivided ?? 0.0;
        $landUnitValue = $homologationModel->unit_value_mode_lot ?? 0.0;

        // Cálculos
        $landFractionValue = $landSurface * $landUnitValue;

        $isCondominio = (stripos($valuation->property_type, 'condominio') !== false);
        $indivisoDecimal = ($landIndiviso > 0) ? ($landIndiviso / 100) : 0;
        $landProportionalValue = $landFractionValue * $indivisoDecimal;

        // Valor Final Terreno para Resumen (Si es condominio usa proporcional, si no, fracción)
        $totalLandValueForSummary = $isCondominio ? $landProportionalValue : $landFractionValue;

        // 3. PROCESAMIENTO DE CONSTRUCCIONES (Ross-Heidecke)
        $processConstructions = function ($items) use ($lifeValuesConfig) {
            return collect($items)->map(function ($item) use ($lifeValuesConfig) {
                // Generar clave para buscar vida útil
                $claveCombinacion = $item->clasification . '_' . $item->use;
                $vidaTotal = $lifeValuesConfig[$claveCombinacion] ?? 0;
                $edad = $item->age;

                // Factor Edad
                $fEdad = ($vidaTotal > 0)
                    ? (0.100 * $vidaTotal + 0.900 * ($vidaTotal - $edad)) / $vidaTotal
                    : 0;

                // Factor Conservación
                $fCons = match ($item->conservation_state) {
                    '0. Ruinoso' => 0.0,
                    '0.8 Malo'   => 0.8,
                    '1. Normal', '1. Bueno', '1. Nuevo' => 1.0,
                    '1.1 Muy bueno', '1.1 Recientemente remodelado' => 1.1,
                    default => 1.0,
                };

                // Factor Resultante
                $fRes = max($fEdad * $fCons * ($item->progress_work / 100), 0.0);
                $costoNeto = $item->unit_cost_replacement * $fRes;

                // Traducimos el texto a la clase numérica SHF
                $claseNumero = match ($item->clasification) {
                    'Minima'                               => '1',
                    'Economica'                            => '2',
                    'Interes social'                       => '3',
                    'Media'                                => '4',
                    'Semilujo'                             => '5',
                    'Residencial'                          => '6',
                    'Residencial plus', 'Residencial plus +' => '7',
                    'Unica'                                => '0',
                    default                                => '-',
                };

                return (object)[
                    'description'   => $item->description,
                    'clasification' => $item->clasification,
                    'use'           => $item->use,
                    'levels'        => $item->building_levels,
                    'surface'       => $item->surface,
                    'unit_cost'     => $item->unit_cost_replacement,
                    'f_edad'        => $fEdad,
                    'f_cons'        => $fCons,
                    'f_res'         => $fRes,
                    'progress'      => $item->progress_work,
                    'net_cost'      => $costoNeto,
                    'total_value'   => $item->surface * $costoNeto,
                    'age'           => $edad,

                    'clase_shf'     => $item->clasification ?? '-',
                    'uso'           => $item->use ?? '-',
                    'clase'         => $claseNumero,
                    'fuente'        => $item->source_information ?? 'Escrituras',
                    'niv_cpo'       => $item->building_levels ?? '-',
                    'niv_tipo'      => $item->levels_construction_type ?? 1,

                    'vmr'           => $vidaTotal,
                    'vur'           => max($vidaTotal - $edad, 0),
                    'edo_cons'      => preg_replace('/^[\d\.\s]+/', '', $item->conservation_state ?? '-'),
                ];
            });
        };


        // Ejecutar procesamiento
        $privateConstructions = $buildingModel ? $processConstructions($buildingModel->privates()->get()) : collect();
        $commonConstructions = ($buildingModel && $isCondominio) ? $processConstructions($buildingModel->commons()->get()) : collect();

        // Sumatorias Construcciones
        $totalValueConstPrivate = $privateConstructions->sum('total_value');
        $totalValueConstCommon = $commonConstructions->sum('total_value');

        // Suma de Construcciones (Privada + Común) para mostrar en resumen intermedio
        $subtotalConstrucciones = $totalValueConstPrivate + $totalValueConstCommon;


        // 4. INSTALACIONES ESPECIALES
        $allSpecialItems = \App\Models\Forms\SpecialInstallation\SpecialInstallationModel::where('valuation_id', $id)
            ->orderBy('key') // Ordenar por clave (EA01, etc)
            ->get();

        // 4.1 Privativas
        $privateSpecialInst = $allSpecialItems->where('classification_type', 'private');
        $totalValueInstPrivate = $privateSpecialInst->sum('amount');

        // 4.2 Comunes (Calculamos proporcional e imprimimos físico)
        $commonSpecialInst = collect();
        $totalValueInstCommonPhysical = 0; // Total físico de lo común
        $totalValueInstCommonProp = 0;     // Lo que le toca al avalúo

        if ($isCondominio) {
            $commonSpecialInst = $allSpecialItems->where('classification_type', 'common')->map(function ($item) {
                // Calculamos el valor proporcional al vuelo
                $item->prop_value = $item->amount * (($item->undivided ?? 0) / 100);
                return $item;
            });

            $totalValueInstCommonPhysical = $commonSpecialInst->sum('amount');
            $totalValueInstCommonProp = $commonSpecialInst->sum('prop_value');
        }

        // Suma total Instalaciones (Privadas + Comunes Proporcionales)
        $totalInstalacionesFinal = $totalValueInstPrivate + $totalValueInstCommonProp;

        // 5. GRAN TOTAL ENFOQUE DE COSTOS
        $totalCostApproach = $totalLandValueForSummary
            + $subtotalConstrucciones // (Priv + Común)
            + $totalInstalacionesFinal;






        // =========================================================================
        // --- PREPARACIÓN DE NOMBRES GEOGRÁFICOS (DIPOMEX) ---
        // =========================================================================
        $estados = $this->dipomexService->getEstados();
        $municipiosCache = [];

        $getNombreMunicipio = function ($estadoId, $municipioId) use (&$municipiosCache) {
            if (!$estadoId || !$municipioId) return null;

            if (!isset($municipiosCache[$estadoId])) {
                $municipiosCache[$estadoId] = $this->dipomexService->getRawMunicipiosPorEstado($estadoId);
            }

            // Buscamos el nombre usando data_get por si vienen como objetos o arrays
            foreach ($municipiosCache[$estadoId] as $mun) {
                if (data_get($mun, 'MUNICIPIO_ID') == $municipioId) {
                    return data_get($mun, 'MUNICIPIO');
                }
            }
            return null;
        };

        // =========================================================================
        // --- LÓGICA DE HOMOLOGACIÓN TERRENOS (LANDS) ---
        // =========================================================================

        // 1. HEADERS Y FACTORES DEL SUJETO
        $dbSubjectFactors = HomologationValuationFactorModel::where('valuation_id', $id)
            ->where('homologation_type', 'land')
            ->get();

        $topAcronyms = ['FZO', 'FUB'];
        $bottomAcronyms = ['FFO', 'FSU', 'FCUS'];

        $topList = $dbSubjectFactors->whereIn('acronym', $topAcronyms);
        $bottomList = $dbSubjectFactors->whereIn('acronym', $bottomAcronyms);
        $middleList = $dbSubjectFactors->whereNotIn('acronym', array_merge($topAcronyms, $bottomAcronyms, ['FNEG']));

        $orderedHeaders = collect();
        $orderedHeaders->push((object)[
            'acronym' => 'FNEG',
            'factor_name' => 'Factor Negociación',
            'rating' => 1.00
        ]);

        foreach ($topList as $f) $orderedHeaders->push($f);
        foreach ($middleList as $f) $orderedHeaders->push($f);
        foreach ($bottomList as $f) $orderedHeaders->push($f);

        // 2. COMPARABLES Y PIVOTES
        $landPivots = $valuation->landComparablePivots()->with('comparable')->get();
        $pivotIds = $landPivots->pluck('id');

        $comparableFactors = HomologationComparableFactorModel::whereIn('valuation_land_comparable_id', $pivotIds)
            ->where('homologation_type', 'land')
            ->get();

        $homologatedValues = collect();
        $offerValues = collect();

        foreach ($landPivots as $pivot) {
            if ($pivot->comparable) {
                // --- AQUÍ ESTÁ EL FIX PARA ESTADO Y MUNICIPIO ---
                $eId = $pivot->comparable->comparable_entity;
                $mId = $pivot->comparable->comparable_locality;

                // Si Dipomex tiene el nombre, lo usamos; si no, dejamos el ID para debuggear
                $pivot->comparable->resolved_state = $estados[$eId] ?? $eId;
                $pivot->comparable->resolved_municipality = $getNombreMunicipio($eId, $mId) ?? $mId;

                // --- NUEVO: CÁLCULO FCUS (CUS Calculado) DIRECTO EN PHP ---
                $niveles = (float)($pivot->comparable->comparable_allowed_levels ?? $pivot->comparable->comparable_max_levels ?? 0);
                $areaLibre = (float)($pivot->comparable->comparable_free_area_required ?? $pivot->comparable->comparable_free_area ?? 0);
                $areaLibreDec = ($areaLibre > 1) ? ($areaLibre / 100) : $areaLibre;

                // Guardamos el CUS y las variables limpias en propiedades dinámicas para la vista
                $pivot->comparable->calculated_cus = $niveles * (1 - $areaLibreDec);
                $pivot->comparable->clean_area_libre = $areaLibre;
                $pivot->comparable->clean_niveles = $niveles;
            }

            $fre = 1.0;
            $factorsMap = $comparableFactors->where('valuation_land_comparable_id', $pivot->id)
                ->keyBy(fn($f) => trim(strtoupper($f->acronym)));

            $pivot->setRelation('factors_mapped', $factorsMap);

            foreach ($orderedHeaders as $header) {
                $acr = trim(strtoupper($header->acronym));
                if (isset($factorsMap[$acr])) {
                    $val = (float)$factorsMap[$acr]->applicable;
                    $fre *= ($val > 0 ? $val : 1.0);
                }
            }

            $unitValue = (float)($pivot->comparable->comparable_unit_value ?? 0);
            $valHom = $unitValue * $fre;

            $homologatedValues->push($valHom);
            $offerValues->push($unitValue);

            $pivot->calculated_fre = $fre;
            $pivot->calculated_val_hom = $valHom;
        }

        // 3. ESTADÍSTICAS Y PONDERACIÓN
        $avgHomologated = $homologatedValues->avg() ?? 0;
        $count = $landPivots->count();
        $weight = $count > 0 ? (1 / $count) : 0;

        $statsRows = collect();
        foreach ($landPivots as $pivot) {
            $valHom = $pivot->calculated_val_hom;
            $deviation = ($avgHomologated > 0) ? ($valHom / $avgHomologated) : 0;

            $statsRows->push((object)[
                'id' => $pivot->comparable->id ?? '-',
                'offer' => $pivot->comparable->comparable_unit_value ?? 0,
                'val_hom' => $valHom,
                'fre' => $pivot->calculated_fre,
                'deviation' => $deviation,
                'weight' => $weight,
                'weighted_val' => $valHom * $weight
            ]);
        }

        $stats = [
            'offers' => [
                'min' => $offerValues->min() ?? 0,
                'max' => $offerValues->max() ?? 0,
                'avg' => $offerValues->avg() ?? 0,
                'diff' => ($offerValues->max() ?? 0) - ($offerValues->min() ?? 0)
            ],
            'homologated' => [
                'min' => $homologatedValues->min() ?? 0,
                'max' => $homologatedValues->max() ?? 0,
                'avg' => $avgHomologated,
                'diff' => ($homologatedValues->max() ?? 0) - ($homologatedValues->min() ?? 0)
            ],
            'avg_fre' => $landPivots->avg('calculated_fre') ?? 0,
        ];

        // 4. INFO DEL SUJETO (Superficies y Lote Moda)
        $landAttrs = HomologationLandAttributeModel::where('valuation_id', $id)->first();
        $appSurface = ApplicableSurfaceModel::where('valuation_id', $id)->first();

        $supTerreno = (float)($landAttrs->subject_surface_value ?? 0);
        $supConst   = (float)($appSurface->built_area ?? 0);
        $loteModa   = (float)($landAttrs->mode_lot ?? 0);

        $subjectInfo = (object)[
            'superficie_terreno' => $supTerreno,
            'superficie_const'   => $supConst,
            'relacion_tc'        => ($supConst > 0) ? ($supTerreno / $supConst) : 0,
            'lote_moda'          => $loteModa,
        ];


        // =========================================================================
        // --- LÓGICA HOMOLOGACIÓN: CONSTRUCCIONES (BUILDINGS) ---
        // =========================================================================

        // 1. Headers del Sujeto
        $orderedBuildingHeaders = HomologationValuationFactorModel::where('valuation_id', $id)
            ->where('homologation_type', 'building')
            ->get()
            ->sortBy(function ($f) {
                $acr = strtoupper(trim($f->acronym));
                if ($acr === 'FNEG') return 300000;
                $order = ['FSU' => 1, 'FIC' => 2, 'FEQ' => 3, 'FEDAD' => 4, 'FLOC' => 5, 'AVANC' => 6];
                return 100000 + ($order[$acr] ?? 99);
            })->values();

        // 2. Cargamos los Pivots
        $buildingPivots = ValuationBuildingComparableModel::where('valuation_id', $id)
            ->with('comparable')
            ->orderBy('position', 'asc')
            ->get();

        // 3. Traemos los factores
        $allFactors = HomologationComparableFactorModel::whereIn(
            'valuation_building_comparable_id',
            $buildingPivots->pluck('id')
        )->get();

        // 4. Cálculos de FRE y VUH (USANDO APPLICABLE PARA TODO)
        foreach ($buildingPivots as $pivot) {

            if ($pivot->comparable) {
                // USAMOS LOS CAMPOS QUE SÍ TRAEN DATA (entity y locality)
                $eId = $pivot->comparable->comparable_entity;
                $mId = $pivot->comparable->comparable_locality;

                // Resolvemos nombres
                $pivot->comparable->resolved_state = $estados[$eId] ?? ($eId ?: 'N/A');
                $pivot->comparable->resolved_municipality = $getNombreMunicipio($eId, $mId) ?? ($mId ?: 'N/A');

                $c_sup_terreno = (float)($pivot->comparable->comparable_land_area ?? 0);
                $c_sup_const   = (float)($pivot->comparable->comparable_built_area ?? 0);

               // dd($c_sup_const, $c_sup_terreno);

                $pivot->comparable->piso_nivel_val = $pivot->comparable->comparable_floor_level ?? 'N/A';

                $pivot->comparable->c_sup_terreno_val = $c_sup_terreno;
                $pivot->comparable->c_sup_const_val   = $c_sup_const;
                $pivot->comparable->relacion_tc_val   = ($c_sup_const > 0) ? ($c_sup_terreno / $c_sup_const) : 0;

                //dd($pivot->comparable->relacion_tc_val);
            }

            $myFactors = $allFactors->where('valuation_building_comparable_id', $pivot->id);

            // Mapeo seguro para el Blade y el cálculo
            $map = [];
            foreach ($myFactors as $f) {
                $map[strtoupper(trim($f->acronym))] = $f;
            }
            $pivot->factors_mapped = $map;

            $currentFRE = 1.0;
            foreach ($orderedBuildingHeaders as $header) {
                $acr = strtoupper(trim($header->acronym));
                $fComp = $pivot->factors_mapped[$acr] ?? null;

                // AQUÍ ESTÁ EL CAMBIO: USAMOS EL 'APPLICABLE' SIEMPRE (0.99 en tu dd)
                $currentFRE *= ($fComp ? (float)$fComp->applicable : 1.0);
            }

            $pivot->calculated_fre = $currentFRE;
            $unitVal = (float)($pivot->comparable->comparable_unit_value ?? 0);
            $pivot->calculated_vuh = $unitVal * $currentFRE;
        }

        // 5. Estadísticas finales para el compact()
        $avgHom = $buildingPivots->avg('calculated_vuh') ?: 0;
        $count = $buildingPivots->count();

        foreach ($buildingPivots as $pivot) {
            $pivot->calculated_dev = ($avgHom > 0) ? ($pivot->calculated_vuh / $avgHom) : 0;
            $pivot->calculated_cred = ($count > 0) ? (100 / $count) : 0;
        }

        $buildingStats = [
            'avg' => $avgHom,
            'count' => $count,
            'sum_dev' => $buildingPivots->sum('calculated_dev'),
            'max_vuh' => $buildingPivots->max('calculated_vuh') ?? 0,
            'min_vuh' => $buildingPivots->min('calculated_vuh') ?? 0,
            'max_offer' => $buildingPivots->max(fn($p) => $p->comparable->comparable_offers ?? 0),
            'min_offer' => $buildingPivots->min(fn($p) => $p->comparable->comparable_offers ?? 0),
        ];


        $supTerrenoBuilding = (float)($landAttributes->subject_surface_value ?? 0);
        $supConstBuilding   = (float)($applicableSurface->built_area ?? 0);

        // Priorizamos el lote moda de terrenos que es el que ya confirmaste que sí trae data
        $loteModaSeguro = (float)($landAttributes->mode_lot ?? $buildingAttributes->mode_lot ?? 0);

        $subjectBuildingInfo = (object)[
            'superficie_terreno' => $supTerrenoBuilding,
            'superficie_const'   => $supConstBuilding,
            'relacion_tc'        => ($supConstBuilding > 0) ? ($supTerrenoBuilding / $supConstBuilding) : 0,
            'lote_moda'          => $loteModaSeguro,

        ];





        // 7. Preparar Gráfica Construcciones
        $chartBuildingPath = storage_path("app/public/homologation/buildings/chart_{$id}_chart1.jpg");
        $chartBuildingImageBase64 = file_exists($chartBuildingPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($chartBuildingPath))
            : null;

        // =========================================================================
        // --- DEFINICIÓN DE FOTOS Y ANEXOS (ESTO ES LO QUE TE FALTABA) ---
        // =========================================================================

        $annexCategories = ['Documento anexo / evidencia', 'Proyecto arquitectonico / croquis'];

        // Cargar todo el media
        $allMedia = PhotoReportModel::where('valuation_id', $id)
            ->where('is_printable', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // Separar Fotos (Para la galería del reporte)
        $photos = $allMedia->filter(function ($item) use ($annexCategories) {
            return !in_array($item->category, $annexCategories);
        });

        // Separar Anexos (Para el bucle final del PDF y para evitar el error)
        $annexes = $allMedia->filter(function ($item) use ($annexCategories) {
            return in_array($item->category, $annexCategories);
        });

        // Configuración de rutas de mapas (Ya las tenías, las dejo para que no falten)
        $config = ['header' => $this->headerType, 'sections' => $this->sections];
        $chartPath = storage_path("app/public/homologation/lands/chart_{$id}_chart1.jpg");
        $chartImageBase64 = file_exists($chartPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($chartPath)) : null;
        $microPath = storage_path("app/public/location_maps/map_{$id}_micro.png");
        $macroPath = storage_path("app/public/location_maps/map_{$id}_macro.png");
        $mapMicroBase64 = file_exists($microPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($microPath)) : null;
        $mapMacroBase64 = file_exists($macroPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($macroPath)) : null;

        /*     dd($buildingPivots->map(function ($p) {
            return [
                'id' => $p->comparable->id,
                'fneg_obj' => $p->factors_map['FNEG'] ?? 'NO ENCONTRADO',
                'fre_calculado' => $p->calculated_fre,
                'vuh_calculado' => $p->calculated_vuh
            ];
        })->toArray()); */







        // =========================================================================
        // --- SECCIÓN: DESCRIPCIÓN GENERAL, ATRIBUTOS Y SUPERFICIES ---
        // =========================================================================

        $propertyDesc = PropertyDescriptionModel::where('valuation_id', $id)->first();

        // 1. INFO GENERAL
        $gralInfo = (object)[
            // Ahora sí los sacamos de $propertyDesc
            'uso_actual'      => strtoupper($propertyDesc->actual_use ?? '-'),
            'uso_multiple'    => preg_replace('/^\d+\.\s*/', '', $propertyDesc->multiple_use_space ?? '-'),
            'nivel_ubicacion' => $propertyDesc->level_building ?? '-',
        ];
        // ---------------------------------------------------------
        // CÁLCULO DE EDAD Y VIDA PONDERADA (Igual que en Livewire)
        // ---------------------------------------------------------
        $totalSupPrivada = 0;
        $sumaEdad = 0;
        $sumaVida = 0;

        // Usamos $privateConstructions que ya se calculó en la línea 540
        foreach ($privateConstructions as $item) {
            $sup  = (float)$item->surface;
            $edad = (int)$item->age;
            $vida = (int)$item->vmr; // La vida total ya viene en 'vmr'

            $totalSupPrivada += $sup;
            $sumaEdad += ($edad * $sup);
            $sumaVida += ($vida * $sup);
        }

        if ($totalSupPrivada > 0) {
            $edadPonderadaCalc = round($sumaEdad / $totalSupPrivada);
            $vidaPonderadaCalc = round($sumaVida / $totalSupPrivada);
            $vidaRemanenteCalc = max($vidaPonderadaCalc - $edadPonderadaCalc, 0);
        } else {
            $edadPonderadaCalc = '-';
            $vidaRemanenteCalc = '-';
        }


        $subjectInfo = (object)[
            'superficie_terreno' => $supTerreno,
            'superficie_const'   => $supConst,
            'relacion_tc'        => ($supConst > 0) ? ($supTerreno / $supConst) : 0,
            'lote_moda'          => $loteModa,
            'edad'               => $edadPonderadaCalc, // <--- Ahora sí lleva valor
        ];

        $subjectBuildingInfo = (object)[
            'superficie_terreno' => $supTerrenoBuilding,
            'superficie_const'   => $supConstBuilding,
            'relacion_tc'        => ($supConstBuilding > 0) ? ($supTerrenoBuilding / $supConstBuilding) : 0,
            'lote_moda'          => $loteModaSeguro,
            'edad'               => $edadPonderadaCalc, // <--- Y aquí también
            'conjunto'           => $buildingModel->profitable_units_condominiums ?? '-',
        ];


        // 2. ATRIBUTOS (¡NOMBRES CORREGIDOS CON TU MODELO!)
        $atributos = (object)[
            'unidades_rentables' => $buildingModel->profitable_units_general ?? '-',
            'avance_gral'        => $buildingModel->progress_general_works ?? '-',
            'unidades_nucleo'    => $buildingModel->profitable_units_subject ?? '-',
            'avance_comunes'     => $buildingModel->degree_progress_common_areas ?? '-',
            'unidades_conjunto'  => $buildingModel->profitable_units_condominiums ?? '-',
            'clase_gral'         => $buildingModel->general_class_property ?? '-',
            'calidad_proyecto'   => strtoupper($propertyDesc->project_quality ?? '-'),

            // Asignamos las variables ponderadas que acabamos de calcular:
            'edad_ponderada'     => $edadPonderadaCalc,
            'vida_remanente'     => $vidaRemanenteCalc,
            'sup_ultimo_nivel'   => '-', // No existe en BD

            'estado_conservacion' => strtoupper(preg_replace('/^[\d\.\s]+/', '', $buildingModel->conservation_status ?? '-')),
        ];

        // 3. ESCRITURAS (Usamos $land que ya tienes cargado arriba)
        $escrituras = (object)[
            'num'     => $land->deed_deed ?? '-',
            'notaria' => $land->notary_office_deed ?? '-',
            'fecha'   => $land->date_deed ?? '-',
            'notario' => $land->notary_deed ?? '-',
        ];

        // 4. SUPERFICIES Y TERRENOS (Usamos $surfaceModel que ya tienes cargado)
        $surfArea = (float)($surfaceModel->surface_area ?? 0);
        $indiviso = (float)($surfaceModel->applicable_undivided ?? 0);
        $loteProp = $surfArea * ($indiviso / 100);

        $terreno = (object)[
            'total'             => number_format($surfArea, 4),
            'lote_privativo'    => number_format((float)($surfaceModel->private_lot ?? 0), 4),
            'indiviso'          => number_format($indiviso, 4),
            'lote_priv_tipo'    => number_format((float)($surfaceModel->private_lot_type ?? 0), 4),
            'lote_proporcional' => number_format($loteProp, 2),
        ];

        $superficies = (object)[
            'terreno_total'        => number_format($surfArea, 4),
            'sup_construida'       => number_format((float)($surfaceModel->built_area ?? 0), 4),
            'indiviso'             => number_format($indiviso, 4),
            'sup_accesoria'        => number_format((float)($surfaceModel->accessory_area ?? 0), 4),
            'lote_privativo'       => number_format((float)($surfaceModel->private_lot ?? 0), 4),
            'sup_vendible'         => number_format((float)($surfaceModel->saleable_area ?? $surfaceModel->built_area ?? 0), 4),
            'terreno_proporcional' => number_format($loteProp, 4),
        ];









        // --- PASO 1: REPORTE BASE ---
        $pdfDom = Pdf::loadView('pdf.master-report', compact(
            'id',
            'valuation',
            'photos',
            'config',

            //DATOS DE TERRENOS
            'orderedHeaders',
            'landPivots',
            'stats',
            'statsRows',
            'chartImageBase64',
            'subjectInfo',
            'subjectBuildingInfo',

            // VARIABLES DE CONSTRUCCIONES (BUILDINGS)
            'orderedBuildingHeaders',
            'buildingPivots',
            'buildingStats',
            'chartBuildingImageBase64',

            'mapMicroBase64',
            'mapMacroBase64',
            'estadoInmueble',
            'municipioInmueble',
            'estadoSolicitante',
            'municipioSolicitante',
            'estadoPropietario',
            'municipioPropietario',
            'additionalLimits',

            // Localización del inmueble
            'latitude',
            'longitude',
            'altitude',

            //Declaraciones y justificaciones
            'dec_idDoc',
            'dec_areaDoc',
            'dec_constState',
            'dec_occupancy',
            'dec_urbanPlan',
            'dec_inahMonument',
            'dec_inbaHeritage',
            'otherNotes',
            'additionalLimits',

            //Características urbanas
            'urb_zoneClass',
            'urb_popDensity',
            'urb_landUse',
            'urb_housingDen',
            'urb_source',
            'urb_freeArea',
            'urb_levels',
            'urb_densityRep',
            'urb_constUsage',
            'urb_socioLevel',
            'urb_saturation',
            'urb_access',
            'urb_constDomin',
            'urb_pollution',

            'inf_vialidades',
            'inf_guarniciones',
            'inf_alumbrado',
            'inf_agua',
            'inf_drenaje',
            'inf_drenaje_pluvial',
            'inf_otro_desalojo',
            'inf_banquetas',
            'inf_gas',
            'inf_vigilancia',
            'inf_acometida_elec',
            'inf_drenaje_calle',
            'inf_sistema_mixto',
            'inf_suministro_elec',
            'inf_telefonos_sum',
            'inf_senyalizacion',
            'inf_recoleccion',
            'inf_acometida_tel',
            'inf_nomenclatura',
            'inf_porcentaje',

            //Equipamiento urbano
            'eq_church',
            'eq_commCenter',
            'eq_bank',
            'eq_gardens',
            'eq_parks',
            'eq_courts',
            'eq_sportsCenter',
            'eq_primary',
            'eq_middle',
            'eq_high',
            'eq_univ',
            'eq_otherSch',
            'eq_market',
            'eq_super',
            'eq_commSpaces',
            'eq_numComm',
            'eq_hosp1',
            'eq_hosp2',
            'eq_hosp3',
            'eq_transUrb',
            'eq_transFreq',
            'eq_plaza',
            'eq_refUrbana',

            //LandDetails
            'land_location',
            'land_topography',
            'land_configuration',
            'land_roadType',
            'land_streetFront',
            'land_crossStreets',
            'land_crossOrient1',
            'land_borderStreets',
            'land_borderOrient1',
            'land_panoramic',
            'land_restrictions',

            // Datos Legales (Array estructurado)
            'legalData',

            // Datos Colindancias (Colección)
            'neighborGroups',

            //Elementos de construcción
            'construction',
            'finishingOthers',

            //Instalaciones especiales
            'specialElementsPrivate',
            'specialElementsCommon',

            //Enfoque de mercado
            'terrainSurface',
            'marketUnitValue',
            'terrainValue',
            'applicableUndividedPercent',
            'totalTerrainAmount',

            'showExcessSection',
            'valLotePrivativo',
            'valLoteTipo',
            'valTerrenoExcedente',
            'surplusPercentage',

            'saleableBuiltArea',
            'constructionMarketUnitValue',
            'baseConstructionValue',
            'marketValueTotal',
            'amountInLetters',

            //Enfoque de costos
            'landSurface',
            'landUnitValue',
            'landFractionValue',
            'landIndiviso',
            'landProportionalValue',
            'totalLandValueForSummary',

            'privateConstructions',
            'commonConstructions',
            'totalValueConstPrivate',
            'totalValueConstCommon',
            'subtotalConstrucciones',

            'privateSpecialInst',
            'commonSpecialInst',
            'totalValueInstPrivate',
            'totalValueInstCommonPhysical',
            'totalValueInstCommonProp',
            'totalInstalacionesFinal',

            'totalCostApproach',

            //Descripción General y Superficies
            'gralInfo',
            'atributos',
            'escrituras',
            'terreno',
            'superficies',

            //Conclusion
            'valorConcluidoFinal',
            'valorConcluidoTexto',
            'finalLandValue',
            'finalMarketValue',
            'finalHypotheticalValue',
            'finalPhysicalValue',
            'finalIncomeValue'

        ) + ['annexes' => collect()])
            ->setPaper('letter', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        $basePdfPath = sys_get_temp_dir() . '/base_' . uniqid() . '.pdf';
        file_put_contents($basePdfPath, $pdfDom->output());

        // --- PASO 2: PLANTILLA DE FONDO (CORREGIDO PARA QUE NO SE SALTE EL HEADER) ---
        // Pasamos una variable 'isTemplate' para que la vista sepa que debe renderizar el esqueleto
        $templateDom = Pdf::loadView('pdf.sections.documents', compact('config', 'valuation') + ['isTemplate' => true])
            ->setPaper('letter', 'portrait');

        $templatePath = sys_get_temp_dir() . '/tpl_' . uniqid() . '.pdf';
        file_put_contents($templatePath, $templateDom->output());

        // --- PASO 3: FUSIÓN ---
        $fpdi = new Fpdi();

        $pageCount = $fpdi->setSourceFile($basePdfPath);
        for ($i = 1; $i <= $pageCount; $i++) {
            $tplIdx = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($tplIdx);
            $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $fpdi->useTemplate($tplIdx);
        }

        // B) Procesamos los Anexos (Incrustamos PDFs o Imágenes)
        foreach ($annexes as $doc) {
            $fullPath = storage_path('app/public/' . $doc->file_path);
            if (!file_exists($fullPath)) continue;

            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            $titleText = mb_convert_encoding('ANEXO: ' . ($doc->description ?: $doc->category), 'ISO-8859-1', 'UTF-8');

            // --- VARIABLES DE ZONA SEGURA (AJUSTADAS) ---
            $maxW = 205;    // Ancho máximo (se queda igual)
            $maxH = 225;    // ¡AQUÍ ESTÁ LA MAGIA! Bajamos de 225 a 210 para liberar 1.5cm del footer
            $startY = 28;   // Dónde empieza la imagen
            $startX = 5.5;   // Margen izquierdo

            if ($ext === 'pdf') {
                try {
                    $pageCountDoc = $fpdi->setSourceFile($fullPath);
                    for ($k = 1; $k <= $pageCountDoc; $k++) {
                        $fpdi->AddPage('P', 'Letter');

                        // 1. Fondo (Header/Footer)
                        $fpdi->setSourceFile($templatePath);
                        $tplBg = $fpdi->importPage(1);
                        $fpdi->useTemplate($tplBg, 0, 0, 216, 279);

                        // 2. Título (Lo subimos un poco cambiando el 32 por un 28)
                        $fpdi->SetFont('Arial', 'B', 10);
                        $fpdi->SetXY(10, 21);
                        $fpdi->Cell(0, 10, $titleText, 0, 1, 'C');

                        // 3. CÁLCULO DE ESCALA PARA EL PDF
                        $fpdi->setSourceFile($fullPath);
                        $tplPage = $fpdi->importPage($k);
                        $size = $fpdi->getTemplateSize($tplPage);

                        $w = $maxW;
                        $h = $w / ($size['width'] / $size['height']); // Calculamos alto proporcional

                        // Si el alto es mayor a nuestra zona segura, ajustamos por altura
                        if ($h > $maxH) {
                            $h = $maxH;
                            $w = $h * ($size['width'] / $size['height']);
                        }

                        // Centramos horizontalmente dentro del espacio de 185mm
                        $xPos = $startX + (($maxW - $w) / 2);

                        $fpdi->useTemplate($tplPage, $xPos, $startY, $w, $h);
                    }
                } catch (\Exception $e) {
                    continue;
                }
            } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                // --- ZONA SEGURA PARA IMÁGENES (MÁS GRANDE) ---
                $maxW = 180;    // Le subimos bastante al ancho (antes 140)
                $maxH = 210;    // Le damos mucho más alto (antes 160)
                $startY = 41;   // Subimos la foto un poco más hacia el título (antes 45)
                $startX = 18;   // Recalculamos el centro: (216 - 180) / 2 = 18

                $fpdi->AddPage('P', 'Letter');

                // Fondo y Título
                $fpdi->setSourceFile($templatePath);
                $tplBg = $fpdi->importPage(1);
                $fpdi->useTemplate($tplBg, 0, 0, 216, 279);

                $fpdi->SetFont('Arial', 'B', 10);
                $fpdi->SetXY(10, 28);
                $fpdi->Cell(0, 10, $titleText, 0, 1, 'C');

                // 3. Imagen con ajuste proporcional
                $fpdi->Image($fullPath, $startX, $startY, $maxW, $maxH, '', '', '', false, 300, '', false, false, 0, 'CM');
            }
        }

        @unlink($basePdfPath);
        @unlink($templatePath);
        return $fpdi->Output('S');
    }

    private function calculateStdDev($collection)
    {
        $count = $collection->count();
        if ($count < 2) return 0;
        $mean = $collection->avg();
        $sum = $collection->sum(fn($val) => pow($val - $mean, 2));
        return sqrt($sum / ($count - 1));
    }

    private function applyRounding($value, $type)
    {
        $value = (float) $value;
        switch ($type) {
            case 'A decimales':
                return round($value, 2);
            case 'A decenas':
                return round($value / 10) * 10;
            case 'A centenas':
                return round($value / 100) * 100;
            case 'A miles':
                return round($value / 1000) * 1000;
            case 'Sin redondeo':
            default:
                return $value;
        }
    }
}
