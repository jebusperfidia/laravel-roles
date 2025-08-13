<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use Livewire\Attributes\On;

class Captured extends Component
{

    public $IdValuation = [];

    /* protected $listeners = ['openForms']; */


    #[On('openForms')]
    /* public function openForms(array $IdValuation) */
    public function openForms()
    {
       /*  $this->IdValuation = $IdValuation['id']; */
        /* dd('método recibido correctamente', $this->IdValuation); */
        // Redirigimos a la ruta 'ruta.destino' y pasamos el parámetro
        /* return redirect()->route('ruta.destino', ['IdValuation' => $IdValuation]); */

        //dd('El método llega con éxito');
        return redirect()->route('form.index');
    }

    public function render()
    {
        return view('livewire.valuations.captured');
    }
}
