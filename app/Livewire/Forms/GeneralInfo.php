<?php

namespace App\Livewire\Forms;

use App\Models\Valuation;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class GeneralInfo extends Component
{

    public $valuation;

    //Variables para apartado configuración y fecha del avalúo
    public $gi_folio, $gi_date, $gi_type;

    public function mount() {
    //Obtenemos los valores de la valuación a partir de la variable de sesión del ID
    $valuation = Valuation::find(Session::get('valuation_id'));

    //Igualamos a las variables públicas para mostrar la información en la vista
    $this->gi_folio = $valuation->folio;
    $this->gi_date = $valuation->date;
    $this->gi_type = $valuation->type;

    }

    public function render()
    {
        return view('livewire.forms.general-info');
    }
}
