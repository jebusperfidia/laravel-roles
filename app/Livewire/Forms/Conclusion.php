<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Session;
use App\Models\Valuations\Valuation;
use App\Models\Forms\Conclusions\ConclusionModel;
use App\Traits\ValuationLockTrait;
use App\Services\ValuationCalculatorService; // <--- IMPORTANTE

class Conclusion extends Component
{
    use ValuationLockTrait;
    public $valuationId;

    // --- VARIABLES PÚBLICAS ---
    public $landValue = 0;
    public $marketValue = 0;
    public $hypotheticalValue = 0;
    public $physicalValue = 0;
    public $otherValueAmount = 0;

    // --- VARIABLES VISUALES ---
    public $surfaceLand = 0;
    public $surfaceConst = 0;
    public $unitLand = 0;
    public $unitMarket = 0;
    public $unitHypothetical = 0;
    public $unitPhysical = 0;

    // --- CONFIGURACIÓN DE FORMULARIO ---
    public string $selectedValueType = 'physical';
    public string $rounding = 'Sin redondeo';
    public $concludedValue = '';
    public $difference = 0;
    public $range = '';

    // Inyección de dependencia en el mount
    public function mount(ValuationCalculatorService $calculator)
    {
        $this->valuationId = Session::get('valuation_id');
        $valuation = Valuation::find($this->valuationId);

        if (!$valuation) return;

        // 1. LLAMAMOS AL SERVICIO PARA OBTENER LOS CÁLCULOS FRESCOS 🧊
        $calculatedData = $calculator->calculateValues($this->valuationId);

        if ($calculatedData) {
            // Asignamos Valores Monetarios
            $this->landValue = $calculatedData['landValue'];
            $this->marketValue = $calculatedData['marketValue'];
            $this->hypotheticalValue = $calculatedData['hypotheticalValue'];
            $this->physicalValue = $calculatedData['physicalValue'];

            // Asignamos Datos Informativos (Superficies/Unitarios)
            $this->surfaceLand = $calculatedData['surfaceLand'];
            $this->unitLand = $calculatedData['unitLand'];
            $this->surfaceConst = $calculatedData['surfaceConst'];
            $this->unitMarket = $calculatedData['unitMarket'];
            $this->unitHypothetical = $calculatedData['unitHypothetical'];
            $this->unitPhysical = $calculatedData['unitPhysical'];
        }

        // 2. CARGA DE CONFIGURACIÓN GUARDADA (Usuario)
        // Esto solo recupera "Qué elegiste", "Qué redondeo", "Valor manual"
        $conclusion = ConclusionModel::where('valuation_id', $this->valuationId)->first();

        if ($conclusion) {
            $this->otherValueAmount = $conclusion->other_value;
            $this->selectedValueType = $conclusion->selected_value_type;
            $this->rounding = $conclusion->rounding;
            // OJO: El concluded_value se recalcula abajo con refreshMetrics,
            // así aseguramos que si cambiaron los costos, el total se actualice aunque no hayas guardado.
        } else {
            $this->selectedValueType = 'physical';
            $this->rounding = 'Sin redondeo';
        }

        // Recalcular métricas (Diferencia, Rango y Valor Concluido final)
        $this->refreshMetrics();

        $this->checkReadOnlyStatus($valuation);
    }

    public function refreshMetrics()
    {
        $diff = (float)$this->physicalValue - (float)$this->marketValue;
        $this->difference = number_format($diff, 2);

        $avg = ((float)$this->physicalValue + (float)$this->marketValue) / 2;

        if ($avg != 0) {
            $rangePct = ($diff / $avg) * 100;
            $this->range = number_format(abs($rangePct), 2) . ' %';
        } else {
            $this->range = '0.00 %';
        }

        $this->calculateConcludedValue();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedValueType', 'rounding', 'otherValueAmount'])) {
            $this->calculateConcludedValue();
        }
    }

    public function calculateConcludedValue()
    {
        $baseValue = 0;
        // Limpiamos comas por si acaso
        $getValue = fn($val) => (float) str_replace(',', '', (string)$val);

        switch ($this->selectedValueType) {
            case 'land':
                $baseValue = $getValue($this->landValue);
                break;
            case 'market':
                $baseValue = $getValue($this->marketValue);
                break;
            case 'hypothetical':
                $baseValue = $getValue($this->hypotheticalValue);
                break;
            case 'physical':
                $baseValue = $getValue($this->physicalValue);
                break;
            case 'other':
                $baseValue = $getValue($this->otherValueAmount);
                break;
        }

        if ($this->rounding === 'Personalizado') return;

        switch ($this->rounding) {
            case 'A decimales':
                $this->concludedValue = number_format(round($baseValue, 2), 2, '.', '');
                break;
            case 'A decenas':
                $this->concludedValue = number_format(round($baseValue / 10) * 10, 2, '.', '');
                break;
            case 'A centenas':
                $this->concludedValue = number_format(round($baseValue / 100) * 100, 2, '.', '');
                break;
            case 'A miles':
                $this->concludedValue = number_format(round($baseValue / 1000) * 1000, 2, '.', '');
                break;
            case 'Sin redondeo':
            default:
                $this->concludedValue = number_format($baseValue, 2, '.', '');
                break;
        }
    }

    public function save()
    {
        $this->ensureNotReadOnly();
        $cleanValue = fn($val) => (float) str_replace(',', '', (string)$val);

        ConclusionModel::updateOrCreate(
            ['valuation_id' => $this->valuationId],
            [
                'land_value' => $cleanValue($this->landValue),
                'market_value' => $cleanValue($this->marketValue),
                'hypothetical_value' => $cleanValue($this->hypotheticalValue),
                'physical_value' => $cleanValue($this->physicalValue),
                'other_value' => $cleanValue($this->otherValueAmount),

                'selected_value_type' => $this->selectedValueType,
                'difference' => $cleanValue($this->difference),
                'range' => $this->range,
                'rounding' => $this->rounding,
                'concluded_value' => $cleanValue($this->concludedValue),
            ]
        );

        Toaster::success('Conclusión guardada con éxito');
        return redirect()->route('form.index', ['section' => 'finish-capture']);
    }

    public function render()
    {
        return view('livewire.forms.conclusion');
    }
}
