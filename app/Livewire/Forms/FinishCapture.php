<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Masmerise\Toaster\Toaster;

// Importamos el Modelo del Avalúo
use App\Models\Valuations\Valuation;

// Importamos los modelos necesarios para los conteos
use App\Models\Forms\Comparable\ValuationLandComparableModel;
use App\Models\Forms\Comparable\ValuationBuildingComparableModel;

class FinishCapture extends Component
{
    public $valuationId;

    // Contadores para la alerta
    public $landExpiredCount = 0;
    public $buildingExpiredCount = 0;

    public function mount()
    {
        $this->valuationId = Session::get('valuation_id');
        $this->checkExpiredComparables();
    }

    public function checkExpiredComparables()
    {
        // Lógica de 6 meses de vigencia
        $sixMonthsAgo = now()->subMonths(6);

        if ($this->valuationId) {
            // Contar Terrenos Vencidos
            $this->landExpiredCount = ValuationLandComparableModel::where('valuation_id', $this->valuationId)
                ->whereHas('comparable', function ($query) use ($sixMonthsAgo) {
                    $query->where('created_at', '<', $sixMonthsAgo);
                })->count();

            // Contar Construcciones Vencidas
            $this->buildingExpiredCount = ValuationBuildingComparableModel::where('valuation_id', $this->valuationId)
                ->whereHas('comparable', function ($query) use ($sixMonthsAgo) {
                    $query->where('created_at', '<', $sixMonthsAgo);
                })->count();
        }
    }

    public function finalizeValuation()
    {
        // 1. Validamos que tengamos ID
        if (!$this->valuationId) {
            Toaster::error('Error: No se ha identificado el avalúo.');
            return;
        }

        // 2. Buscamos el avalúo
        $valuation = Valuation::find($this->valuationId);

        if ($valuation) {
            // 3. CAMBIAMOS EL ESTATUS A 2 (REVISIÓN)
            $valuation->update(['status' => 2]);

            // 4. Limpiamos la sesión para "cerrar" el flujo de edición
            Session::forget('valuation_id');

            Toaster::success('El avalúo ha sido finalizado y enviado a revisión correctamente.');

            // 5. Redirigimos al Dashboard
            // Truco Pro: Lo mandamos directo a la pestaña de "En Revisión" para que vea que ya cayó ahí
            return redirect()->route('dashboard', ['currentView' => 'reviewing']);
        } else {
            Toaster::error('Error: El avalúo no existe en la base de datos.');
        }
    }

    public function render()
    {
        return view('livewire.forms.finish-capture');
    }
}
