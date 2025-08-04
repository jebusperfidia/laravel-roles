<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use Livewire\Attribute\On;

class StatusModal extends Component
{

    /* public $folioId = null; */
    public $estatus;
    public $mostrarModal = false;

    protected $listeners = ['openStatusModal'];


    public function openStatusModal()
    {
        /* $this->folioId = $id; */
        $this->mostrarModal = true;
        $this->estatus = null;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function guardar()
    {
        // Validación y lógica de guardado aquí
        // ...

        $this->cerrarModal();
        $this->dispatchBrowserEvent('alerta', ['message' => 'Estatus actualizado']);
    }
    public function render()
    {
        return view('livewire.valuations.status-modal');
    }
}
