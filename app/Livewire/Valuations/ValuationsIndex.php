<?php

namespace App\Livewire\Valuations;

use Livewire\Component;

class ValuationsIndex extends Component
{
    /* public string $currentView = '';

    public function mount($currentView = null)
    {
        $this->currentView = $currentView ?? 'captured';
    } */


    public string $currentView = 'captured';

    /*  protected $queryString = ['currentView']; */

    protected $queryString = [
        'currentView' => ['except' => [ 'captured','assigned','reviewed','completed']],
    ];

    public function setView($view)
    {
        $this->currentView = $view;
    }

    public function render()
    {
        return view('livewire.valuations.valuations-index');
    }
}
