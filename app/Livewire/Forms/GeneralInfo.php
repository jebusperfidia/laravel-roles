<?php

namespace App\Livewire\Forms;

use App\Models\Valuation;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class GeneralInfo extends Component
{

    public $valuation, $users;

    //Variables para apartado configuración y fecha del avalúo
    public $gi_folio, $gi_date, $gi_type, $gi_valuator;

    //Variables para apartado datos del propietario
    public $gi_typePerson = 'Fisica';

    public function mount() {
    //Obtenemos los valores de la valuación a partir de la variable de sesión del ID
    $valuation = Valuation::find(Session::get('valuation_id'));

    //Traemos el modelo users para poder mostrar en el select de valuadores
    $this->users = User::all();

    //Obtenemos el

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
