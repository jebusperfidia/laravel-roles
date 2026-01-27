<?php

namespace App\Services;

use App\Models\Valuations\Valuation;
use App\Models\Forms\PhotoReport\PhotoReportModel;
use App\Models\Forms\Homologation\ValuationFactorModel;
use App\Models\Forms\Homologation\ComparableFactorModel;
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationComparableFactorModel;
use App\Models\Forms\DeclarationWarning\DeclarationsWarningsModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
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

        // ... (Lógica de Dipomex, Estados, Municipios igual) ...
        $estados = $this->dipomexService->getEstados();
        $getNombreMunicipio = function ($estadoId, $municipioId) use ($estados) {
            if (!$estadoId || !$municipioId) return 'N/A';
            $municipios = $this->dipomexService->getRawMunicipiosPorEstado($estadoId);
            foreach ($municipios as $mun) {
                if ($mun['MUNICIPIO_ID'] == $municipioId) return $mun['MUNICIPIO'];
            }
            return 'N/A';
        };

        $estadoInmueble = $estados[$valuation->property_entity] ?? 'N/A';
        $municipioInmueble = $getNombreMunicipio($valuation->property_entity, $valuation->property_locality);
        $estadoSolicitante = $estados[$valuation->applic_entity] ?? 'N/A';
        $municipioSolicitante = $getNombreMunicipio($valuation->applic_entity, $valuation->applic_locality);
        $estadoPropietario = $estados[$valuation->owner_entity] ?? 'N/A';
        $municipioPropietario = $getNombreMunicipio($valuation->owner_entity, $valuation->owner_locality);

        $valuation->load(['homologationLandAttributes']);
        $declarationsWarnings = DeclarationsWarningsModel::where('valuation_id', $id)->first();
        $addiontalLimits = $declarationsWarnings->additional_limits ?? '';

        // ... (Lógica de Comparables y Factores igual) ...
        $landPivots = $valuation->landComparablePivots()->with('comparable')->get();
        $pivotIds = $landPivots->pluck('id');
        $allFactors = HomologationComparableFactorModel::whereIn('valuation_land_comparable_id', $pivotIds)->where('homologation_type', 'land')->get();
        foreach ($landPivots as $pivot) {
            $pivot->setRelation('factors', $allFactors->where('valuation_land_comparable_id', $pivot->id));
        }
        $rawSubjectFactors = HomologationValuationFactorModel::where('valuation_id', $id)->where('homologation_type', 'land')->get();
        $orderedHeaders = collect();
        $top = ['FZO', 'FUB'];
        $bottom = ['FFO', 'FSU', 'FCUS'];
        foreach ($top as $acr) if ($f = $rawSubjectFactors->firstWhere('acronym', $acr)) $orderedHeaders->push($f);
        $excluded = array_merge($top, $bottom, ['FNEG']);
        foreach ($rawSubjectFactors as $f) {
            if (!in_array($f->acronym, $excluded)) $orderedHeaders->push($f);
        }
        $orderedHeaders->push((object)['acronym' => 'FNEG', 'factor_name' => 'Negociación', 'rating' => 1.0]);
        foreach ($bottom as $acr) if ($f = $rawSubjectFactors->firstWhere('acronym', $acr)) $orderedHeaders->push($f);

        $homologatedValues = collect();
        foreach ($landPivots as $pivot) {
            $fre = 1.0;
            $factorsMap = $pivot->factors->keyBy('acronym');
            foreach ($orderedHeaders as $header) {
                $val = $factorsMap[$header->acronym]->applicable ?? 1.0;
                $fre *= (float)$val;
            }
            $valHom = ($pivot->comparable->comparable_unit_value ?? 0) * $fre;
            $homologatedValues->push($valHom);
        }
        $stats = [
            'avg' => $homologatedValues->avg() ?? 0,
            'min' => $homologatedValues->min() ?? 0,
            'max' => $homologatedValues->max() ?? 0,
            'std_dev' => $this->calculateStdDev($homologatedValues),
            'count' => $homologatedValues->count(),
            'coef_var' => ($homologatedValues->avg() > 0) ? ($this->calculateStdDev($homologatedValues) / $homologatedValues->avg()) * 100 : 0
        ];

        // --- CORRECCIÓN CATEGORÍAS ---
        $annexCategories = ['Documento anexo / evidencia', 'Proyecto arquitectonico / croquis'];

        $allMedia = PhotoReportModel::where('valuation_id', $id)->where('is_printable', true)->orderBy('sort_order', 'asc')->get();

        $photos = $allMedia->filter(function ($item) use ($annexCategories) {
            return !in_array($item->category, $annexCategories);
        });

        $annexes = $allMedia->filter(function ($item) use ($annexCategories) {
            return in_array($item->category, $annexCategories);
        });

        $config = ['header' => $this->headerType, 'sections' => $this->sections];
        $chartPath = storage_path("app/public/homologation/lands/chart_{$id}_chart1.jpg");
        $chartImageBase64 = file_exists($chartPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($chartPath)) : null;
        $microPath = storage_path("app/public/location_maps/map_{$id}_micro.png");
        $macroPath = storage_path("app/public/location_maps/map_{$id}_macro.png");
        $mapMicroBase64 = file_exists($microPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($microPath)) : null;
        $mapMacroBase64 = file_exists($macroPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($macroPath)) : null;

        // --- PASO 1: REPORTE BASE ---
        $pdfDom = Pdf::loadView('pdf.master-report', compact(
            'id',
            'valuation',
            'photos',
            'config',
            'orderedHeaders',
            'landPivots',
            'stats',
            'chartImageBase64',
            'mapMicroBase64',
            'mapMacroBase64',
            'estadoInmueble',
            'municipioInmueble',
            'estadoSolicitante',
            'municipioSolicitante',
            'estadoPropietario',
            'municipioPropietario',
            'addiontalLimits'
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

            // --- VARIABLES DE ZONA SEGURA (En milímetros) ---
            $maxW = 185;    // Ancho máximo
            $maxH = 200;    // Alto máximo (Para no chocar con el footer)
            $startY = 45;   // Dónde empieza (Debajo del título)
            $startX = 15;   // Margen izquierdo

            if ($ext === 'pdf') {
                try {
                    $pageCountDoc = $fpdi->setSourceFile($fullPath);
                    for ($k = 1; $k <= $pageCountDoc; $k++) {
                        $fpdi->AddPage('P', 'Letter');

                        // 1. Fondo (Header/Footer)
                        $fpdi->setSourceFile($templatePath);
                        $tplBg = $fpdi->importPage(1);
                        $fpdi->useTemplate($tplBg, 0, 0, 216, 279);

                        // 2. Título
                        $fpdi->SetFont('Arial', 'B', 10);
                        $fpdi->SetXY(10, 32);
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
                $fpdi->AddPage('P', 'Letter');

                // Fondo y Título igual
                $fpdi->setSourceFile($templatePath);
                $tplBg = $fpdi->importPage(1);
                $fpdi->useTemplate($tplBg, 0, 0, 216, 279);
                $fpdi->SetFont('Arial', 'B', 10);
                $fpdi->SetXY(10, 32);
                $fpdi->Cell(0, 10, $titleText, 0, 1, 'C');

                // 3. Imagen con ajuste proporcional (FPDI lo hace auto si pasas W y H)
                // Usamos la misma lógica de "ajustar al hueco"
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
}
