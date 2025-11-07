<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Forms\Comparable\ComparableModel;
use App\Models\Forms\Comparable\ValuationLandComparableModel;
use Illuminate\Support\Facades\Session;
use App\Models\Valuations\Valuation;
use Flux\Flux;

class HomologationLands extends Component
{
    public $idValuation;
    public $valuation;
    public $comparables;


    public function mount()
    {
        $this->idValuation = Session::get('valuation_id');
        $this->valuation = Valuation::find($this->idValuation);

        // *** CORRECCIÓN: Ordenamos los comparables según la posición de la tabla pivote. ***
        // Esto asegura que se muestren en el orden que el usuario definió en la vista anterior.
        $this->comparables = $this->valuation->landComparables()->orderByPivot('position')->get();
    }

    // Ya no necesitas la función render() si usas la vista por convención (livewire.forms.homologation-lands)
    // Pero la mantendremos si es la convención que usas
    public function render()
    {
        return view('livewire.forms.homologation-lands');
    }
}
