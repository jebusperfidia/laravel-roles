<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use App\Models\User;

class Assigned extends Component
{

    public $users;

    public function mount()
    {
        $this->users = User::all();
    }

    public function save() {
        return redirect()->route('dashboard', ['currentView' => 'reviewed'])
            ->with('success', 'Asignación generada con éxito');
    }

    public function render()
    {

        return view('livewire.valuations.assigned');
    }
}
