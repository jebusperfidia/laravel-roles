<?php

namespace App\Livewire\Valuations;

use App\Models\Valuations\Valuation; // Asegúrate de importar el Modelo
use Livewire\Component;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toaster;

class StatusModal extends Component
{
    public $showModalStatus = false;

    // Variables para recibir datos de las tablas
    public $valuationId;
    public $currentStatus;

    // Variable para el form (el nuevo estatus seleccionado)
    public $statusChange;

    // Opciones disponibles según la regla de oro
    public $availableOptions = [];

    // Escuchamos el evento. Nota: Livewire 3 usa atributos, el array $listeners es legacy pero funciona.
    // Lo ideal es usar #[On] encima del método, como abajo.


    #[On('openStatusModal')]
    public function openStatusModal($valuationId, $currentStatus)
    {
        $this->valuationId = $valuationId;
        $this->currentStatus = (int) $currentStatus; // Forzamos a entero por seguridad
        $this->statusChange = ""; // Reset del select

        // REGLA DE ORO (Lógica corregida y simplificada)
        $this->availableOptions = match ($this->currentStatus) {
            1 => [ // De Captura (1) -> Baja a Sin Asignar (0)
                ['id' => 0, 'name' => 'Regresar a: Sin Asignar']
            ],
            2 => [ // De Revisión (2) -> Baja a Captura (1) o Sin Asignar (0)
                ['id' => 1, 'name' => 'Regresar a: Captura'],
                ['id' => 0, 'name' => 'Regresar a: Sin Asignar'],
            ],
            3 => [ // De Completado (3) -> Revive a cualquiera
                ['id' => 2, 'name' => 'Reactivar en: Revisión'],
                ['id' => 1, 'name' => 'Reactivar en: Captura'],
            ],
            default => [] // Si es 0, no hay opciones (está virgen)
        };

        $this->showModalStatus = true;
    }

    public function closeModalStatus()
    {
        $this->showModalStatus = false;
        $this->reset(['valuationId', 'currentStatus', 'statusChange', 'availableOptions']);
    }

    public function saveAssign()
    {
        // 1. Validar
        $this->validate([
            "statusChange" => 'required|integer',
        ], [
            'statusChange.required' => 'Debes seleccionar un estatus para continuar.'
        ]);

        // 2. Buscar y Actualizar
        $valuation = Valuation::find($this->valuationId);

        if ($valuation) {
            $valuation->update([
                'status' => $this->statusChange
            ]);

            Toaster::success('Estatus actualizado correctamente');
        } else {
            Toaster::error('Error: No se encontró el avalúo.');
        }

        // 3. Cerrar y Refrescar
        $this->closeModalStatus();

        // TRUCO: En lugar de redirigir a una vista fija (que te sacaría de donde estás),
        // recargamos el índice principal. Livewire mantendrá la vista actual si no la cambiamos explícitamente,
        // o si prefieres forzar la redirección, avísame.
        // Por ahora, esto refresca los contadores y las tablas:
        $this->dispatch('refreshValuationsIndex');
    }

    public function render()
    {
        return view('livewire.valuations.status-modal');
    }
}
