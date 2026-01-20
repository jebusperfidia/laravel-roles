<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Masmerise\Toaster\Toaster;

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
        // AQUÍ IRÁ TU LÓGICA PARA CAMBIAR EL ESTATUS DEL AVALÚO
        // Por ejemplo: Valuation::find($this->valuationId)->update(['status' => 'revision']);

        Toaster::success('El avalúo ha sido finalizado y enviado a revisión correctamente.');

        // Opcional: Redirigir al dashboard
        // return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.forms.finish-capture');
    }
}
