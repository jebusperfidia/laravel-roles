<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf; // <--- IMPORTANTE

class PdfExport extends Component
{
    // Método que llama el botón
    public function generatePdf()
    {
        // 1. Datos de prueba (Aquí luego meterás tus consultas de BD)
        $data = [
            'titulo' => 'Avalúo Inmobiliario',
            'folio' => 'AV-2025-001',
            'fecha' => now()->format('d/m/Y'),
            'cliente' => 'Juan Pérez',
            'contenido' => 'Este es un documento de prueba generado desde Livewire.'
        ];

        // 2. Cargar la vista del PDF (crearemos este archivo en el paso 3)
        $pdf = Pdf::loadView('pdf.export_example', $data)
            ->setPaper('letter', 'portrait'); // Carta, Vertical

        // 3. Descargar directamente al navegador
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Avaluo_' . $data['folio'] . '.pdf');
    }

    public function render()
    {
        return view('livewire.forms.pdf-export');
    }
}
