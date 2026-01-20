<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Conclusion extends Component
{
    public $con_landValue = 0;
    public $con_marketValue = 0;
    public $con_hypotheticalValue = 0;
    public $con_physicalValue = 0;
    public $con_otherValueAmount = 0;

    public string $con_selectedValueType = 'land'; // 1. SELECCIÓN POR DEFECTO AQUÍ
    public string $con_rounding = 'Sin redondeo';
    public $con_concludedValue = '';

    public $con_difference = 0;
    public $con_range = '';

    public function mount()
    {
        // Datos de ejemplo
        $this->con_landValue = 6582352.00;
        $this->con_marketValue = 13517986.10;
        $this->con_hypotheticalValue = 13517986.10;
        $this->con_physicalValue = 13227707.65;

        /* $this->con_difference = number_format($this->con_physicalValue - $this->con_marketValue, 2); */
        $this->con_difference = '0.98';
        $this->con_range = '2.19 %';

        // 2. EJECUTAR CÁLCULO INICIAL
        $this->calculateConcludedValue();
    }

    public function updatedConSelectedValueType()
    {
        $this->calculateConcludedValue();
    }

    public function updatedConOtherValueAmount()
    {
        if ($this->con_selectedValueType === 'other') {
            $this->calculateConcludedValue();
        }
    }

    public function updatedConRounding()
    {
        $this->calculateConcludedValue();
    }

    public function calculateConcludedValue()
    {
        $baseValue = 0;

        // Limpiamos el valor de entrada de posibles comas de formato
        $getValue = function ($val) {
            return (float) str_replace(',', '', $val);
        };

        switch ($this->con_selectedValueType) {
            case 'land':
                $baseValue = $getValue($this->con_landValue);
                break;
            case 'market':
                $baseValue = $getValue($this->con_marketValue);
                break;
            case 'hypothetical':
                $baseValue = $getValue($this->con_hypotheticalValue);
                break;
            case 'physical':
                $baseValue = $getValue($this->con_physicalValue);
                break;
            case 'other':
                $baseValue = $getValue($this->con_otherValueAmount);
                break;
            default:
                $this->con_concludedValue = '';
                return;
        }

        if ($this->con_rounding === 'Personalizado') {
            return; // No tocamos nada si el usuario quiere escribir
        }

        // 3. LÓGICA DE REDONDEO REVISADA
        switch ($this->con_rounding) {
            case 'A decimales':
                $this->con_concludedValue = number_format(round($baseValue, 2), 2, '.', '');
                break;
            case 'A decenas':
                $this->con_concludedValue = number_format(round($baseValue / 10) * 10, 2, '.', '');
                break;
            case 'A centenas':
                $this->con_concludedValue = number_format(round($baseValue / 100) * 100, 2, '.', '');
                break;
            case 'A miles':
                $this->con_concludedValue = number_format(round($baseValue / 1000) * 1000, 2, '.', '');
                break;
            default:
                $this->con_concludedValue = number_format($baseValue, 2, '.', '');
                break;
        }
    }

    public function save()
    { /* ... */

        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'finish-capture']);
    }

    public function render()
    {
        return view('livewire.forms.conclusion');
    }
}
