<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use App\Models\Users\User;

class Assigned extends Component
{

    public $users, $appraiser, $operator;

    public function mount()
    {
        $this->users = User::all();
    }

    public function save() {
        $this->validate([
            "appraiser" => 'required',
            "operator" => 'required'
        ]);

        return redirect()->route('dashboard', ['currentView' => 'captured'])
            ->with('success', 'Asignación generada con éxito');
    }

    public function render()
    {

        return view('livewire.valuations.assigned');
    }
}
