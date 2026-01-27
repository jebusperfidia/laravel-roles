<?php

namespace App\Livewire\Forms;

use App\Services\DipomexService;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Services\ValuationReportService;
use Illuminate\Support\Facades\URL;

class PdfExport extends Component
{
    public $valuationId;

    public function mount()
    {
        $this->valuationId = Session::get('valuation_id');
    }

    public function generatePdf(ValuationReportService $reportService)
    {
        if (!$this->valuationId) {
            // Error handle
            return;
        }

        // 1. Obtenemos el contenido binario del PDF (El string que manda FPDI)
        $pdfContent = $reportService->makePdf($this->valuationId);

        // Definimos el nombre del archivo
        $fileName = 'Avaluo_' . $this->valuationId . '.pdf';

        // 2. streamDownload: Simplemente hacemos echo del contenido
        return response()->streamDownload(function () use ($pdfContent) {
            // Eliminamos el ->output() porque $pdfContent YA ES el PDF crudo
            echo $pdfContent;
        }, $fileName);
    }
}
