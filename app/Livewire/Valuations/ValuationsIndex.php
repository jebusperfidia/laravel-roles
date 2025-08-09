<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use App\Models\Valuation;

class ValuationsIndex extends Component
{
    //Tendremos 4 diferentes estados
    //0 unassigned
    //1 capturing
    //2 reviewing
    //3 completed
    public $unassigned, $capturing, $reviewing, $completed;

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

        $this->unassigned = Valuation::where('status', 0)->get()->count();

        return view('livewire.valuations.valuations-index');
    }
}
