<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use Livewire\Attribute\On;
use Masmerise\Toaster\Toaster;

class StatusModal extends Component
{

    /* public $folioId = null; */
    public $status, $statusChange;
    public $showModalStatus = false;

    protected $listeners = ['openStatusModal'];


    public function openStatusModal()
    {
        /* $this->folioId = $id; */
        $this->showModalStatus = true;
        $this->status = null;
    }

    public function closeModalStatus()
    {
        $this->showModalStatus = false;
    }

    public function saveAssign()
    {
        // Validación y lógica de guardado aquí
        // ...
        $this->validate([
            "statusChange" => 'required',
        ]);



        Toaster::success('Estatus cambiado con éxito');
        $this->closeModalStatus();
        return redirect()->route('dashboard', ['currentView' => 'reviewed']);
        /* $this->dispatchBrowserEvent('alerta', ['message' => 'Estatus actualizado']); */

    }
    public function render()
    {
        return view('livewire.valuations.status-modal');
    }
}
