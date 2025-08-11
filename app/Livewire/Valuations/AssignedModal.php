<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use App\Models\User;
use Masmerise\Toaster\Toaster;

class AssignedModal extends Component
{
    public $users, $assign, $appraiser, $operator;

    public $showModalAssign = false;

    protected $listeners = ['openAssignModal'];

    public function mount()
    {
        $this->users = User::all();
    }


    public function openAssignModal()
    {
        /* $this->folioId = $id; */
        $this->showModalAssign = true;
        $this->assign = null;
    }

    public function closeModalAssign()
    {
        $this->showModalAssign = false;
    }

    public function saveAssign()
    {
        // Validación y lógica de guardado aquí
        // ...
        $this->validate([
            "appraiser" => 'required',
            "operator" => 'required',
        ]);

        Toaster::success('Asignación generada con éxito');
        $this->closeModalAssign();
        return redirect()->route('dashboard', ['currentView' => 'completed']);
        /* $this->dispatchBrowserEvent('alerta', ['message' => 'Estatus actualizado']); */
    }


    public function render()
    {
        return view('livewire.valuations.assigned-modal');
    }
}
