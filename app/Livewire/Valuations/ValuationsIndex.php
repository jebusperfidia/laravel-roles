<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use App\Models\Valuations\Valuation;
use App\Models\Users\Assignment;
use Livewire\Attributes\On;

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
       /*  $this->dispatchBrowserEvent('clear-powergrid'); */
    }



    #[on('refreshValuationsIndex')]
    public function refreshComponent(): void
    {
        $this->dispatch('$refresh');
    }

    public function render()
    {
        // 0. UNASSIGNED: Este se queda igual (contamos Avalúos sueltos)
        // Usamos count() directo sin get() para optimizar
        $this->unassigned = Valuation::where('status', 0)->count();

        // 1. CAPTURING (En Proceso)
        // Contamos Asignaciones donde el avalúo tenga status 1
        $this->capturing = Assignment::join('valuations', 'assignments.valuation_id', '=', 'valuations.id')
            ->where('valuations.status', 1)
            ->count();

        // 2. REVIEWING (Revisión)
        // Contamos Asignaciones donde el avalúo tenga status 2
        $this->reviewing = Assignment::join('valuations', 'assignments.valuation_id', '=', 'valuations.id')
            ->where('valuations.status', 2)
            ->count();

        // 3. COMPLETED (Completados)
        // Contamos Asignaciones donde el avalúo tenga status 3
        $this->completed = Assignment::join('valuations', 'assignments.valuation_id', '=', 'valuations.id')
            ->where('valuations.status', 3)
            ->count();

        return view('livewire.valuations.valuations-index');
    }
}
