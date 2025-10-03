<?php

namespace App\Livewire\Valuations;

use Livewire\Component;
use App\Models\Users\User;
use App\Models\Valuations\Valuation;
use App\Models\Users\Assignment;
use Masmerise\Toaster\Toaster;

class AssignedModal extends Component
{
    public $users, $assign, $appraiser, $operator, $type;

    public array $valuationsId = [];

    public $showModalAssign = false;

    protected $listeners = ['openAssignModal'];

    public function mount()
    {
        $this->users = User::all();
    }

    public function openAssignModal(array $ids, ?string $type = null)
    {
        /* $this->folioId = $id; */
        $this->valuationsId = $ids;
        $this->type = $type;
        /*  dd($this->type); */
        $this->reset(['appraiser', 'operator']); // Limpiamos valores anteriores
        $this->resetValidation();
        $this->showModalAssign = true;
        $this->assign = null;
    }

    public function closeModalAssign()
    {
        $this->showModalAssign = false;
        $this->reset('valuationsId'); // Limpiamos los IDs al cerrar
        $this->reset('type'); // Limpiamos el tipo al cerrar
    }

    public function saveAssign()
    {

        $this->validate([
            /* 'valuationIds' => 'required|array|min:1', */
            "appraiser" => 'required',
            "operator" => 'required',
        ]);


        /*  Assignment::create([
            "valuation_id" => $this->Id,
            "appraiser_id" => $this->appraiser,
            "operator_id" => $this->operator
        ]);
        */

        // Iteramos sobre el array de IDs para crear las asignaciones
        foreach ($this->valuationsId as $id) {
            Assignment::create([
                'valuation_id' => $id, // Usamos el ID de la iteración
                'appraiser_id' => $this->appraiser,
                'operator_id' => $this->operator,
            ]);

            Valuation::where('id', $id)
                ->update(['status' => 1]); // Actualizamos el estado de la valoración
        }

        /*  Toaster::success('Asignación generada con éxito'); */
        if ($this->type === 'massive') {
            Toaster::success('Asignación masiva generada con éxito');
        } else {
            Toaster::success('Asignación individual generada con éxito');
        }
        $this->closeModalAssign();
        return redirect()->route('dashboard', ['currentView' => 'captured']);
        /* $this->dispatchBrowserEvent('alerta', ['message' => 'Estatus actualizado']); */
    }


    public function render()
    {
        return view('livewire.valuations.assigned-modal');
    }
}
