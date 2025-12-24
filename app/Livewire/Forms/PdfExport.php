<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Masmerise\Toaster\Toaster;
use App\Models\Valuations\Valuation;
use App\Models\Forms\PhotoReport\PhotoReportModel;
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationComparableFactorModel;



class PdfExport extends Component
{
    public $headerType = 'ESTUDIO ÁLAMO: ARQUITECTURA + VALUACIÓN';
    public $sections = ['cover' => true, 'photos' => true, 'comparables' => true, 'map' => false, 'annexes' => false];
    public $valuationId;

    // 1. PROPIEDAD PARA RECIBIR LA CAPTURA DE LA GRÁFICA
    public $chartImageBase64;

    public function mount()
    {
        $this->valuationId = Session::get('valuation_id');
    }

    public function generatePdf()
    {
        if (!$this->valuationId) {
            Toaster::error('No hay avalúo seleccionado.');
            return;
        }

        // 1. CARGA BASE
        $valuation = Valuation::with([
            'homologationLandAttributes',
        ])->find($this->valuationId);

        // 2. CARGA DE COMPARABLES Y FACTORES
        $landPivots = $valuation->landComparablePivots()->with('comparable')->get();

        $pivotIds = $landPivots->pluck('id');
        $allFactors = HomologationComparableFactorModel::whereIn('valuation_land_comparable_id', $pivotIds)
            ->where('homologation_type', 'land')
            ->get();

        foreach ($landPivots as $pivot) {
            $pivot->setRelation('factors', $allFactors->where('valuation_land_comparable_id', $pivot->id));
        }

        // 3. OBTENER FACTORES DEL SUJETO
        $rawSubjectFactors = HomologationValuationFactorModel::where('valuation_id', $this->valuationId)
            ->where('homologation_type', 'land')->get();

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

        // 4. CÁLCULO DE ESTADÍSTICAS
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
            'coef_var' => 0
        ];

        if ($stats['avg'] > 0) {
            $stats['coef_var'] = ($stats['std_dev'] / $stats['avg']) * 100;
        }

        // 5. REPORTE FOTOGRÁFICO
        $photos = PhotoReportModel::where('valuation_id', $this->valuationId)
            ->where('is_printable', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $config = ['header' => $this->headerType, 'sections' => $this->sections];

        // 6. RENDERIZADO (PASANDO LA GRÁFICA)
        // Agregamos 'chartImageBase64' al compact
        $pdf = Pdf::loadView('pdf.master-report', compact(
            'valuation',
            'photos',
            'config',
            'orderedHeaders',
            'landPivots',
            'stats'
        ) + ['chartImageBase64' => $this->chartImageBase64])
            ->setPaper('letter', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        // 7. DESCARGA
        $fileName = 'Avaluo_' . ($valuation->folio ?? 'Borrador') . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $fileName);
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
