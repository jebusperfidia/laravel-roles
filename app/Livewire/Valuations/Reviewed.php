<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;

class Reviewed extends Component
{

    public $id;

    protected $listeners = ['openForms'];


    #[On('openForms')]
    /* public function openForms(array $IdValuation) */
    public function openForms($id)
    {

        $this->id = $id;
        //dd($this->id);

        Session::put('valuation_id', $this->id);

        Session::put('valuation-active-form', true);
        /* dd('ID de valoración recibida:', $this->id, gettype($this->id)); */
        /*  $this->IdValuation = $IdValuation['id']; */
        /*  dd('método recibido correctamente', $this->id); */
        // Redirigimos a la ruta 'ruta.destino' y pasamos el parámetro
        /* return redirect()->route('ruta.destino', ['IdValuation' => $IdValuation]); */

        //dd('El método llega con éxito');
        return redirect()->route('form.index');
    }

    public function render()
    {
        return view('livewire.valuations.reviewed');
    }
}
