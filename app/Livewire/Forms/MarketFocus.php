<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;

class MarketFocus extends Component
{


    /* public function openForms(array $IdValuation) */
    public function openComparablesLand()
    {

        /* dd('si llega');
        return; */

        //Session::put('valuation_id', $this->id);

        Session::put('comparables-active-session', true);

        return redirect()->route('form.comparables.index');
    }


    public function openComparablesConstSale() {
      /*   dd('si llega');
        return; */

        //Session::put('valuation_id', $this->id);

        Session::put('comparables-active-session', true);

        return redirect()->route('form.comparables.index');
    }

    public function comparativeMarketLand(){
        Toaster::success('Aquí se ejecutará la función para cambiar variables para nuevo menú y enviar directamente al componente de comparativas de mercado');
    }


    public function comparativeMarketBuilding(){
        Toaster::success('Aquí se ejecutará la función para cambiar variables para nuevo menú y enviar directamente al componente de comparativas de mercado');
    }

    public function render()
    {
        return view('livewire.forms.market-focus');
    }
}
