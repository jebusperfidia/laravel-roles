<?php

namespace App\Livewire\Forms\Comparables;

use Livewire\Component;
use Flux\Flux;
use App\Models\Forms\Comparable\ComparableModel;
use App\Models\Forms\Comparable\ValuationLandComparableModel;
use App\Models\Forms\Comparable\ValuationBuildingComparableModel;
use App\Models\Valuations\Valuation;
use Illuminate\Support\Facades\Session;

class ComparableSummary extends Component
{

    protected $listeners = ['openSummary'];

    // Variable donde obtendremos la información del comparable
    public $comparable;

    public array $ValuationComparables;


    public $comparableType;

    public $notCopy;

    public function mount(){



    }


    public function openSummary($id, $comparableType = null){

        if ($comparableType) {
            $this->comparableType = $comparableType;
            $this->notCopy = false; // Si viene el tipo (desde Homologación), NO mostrar el botón.
        } else {
            $this->comparableType = Session::get('comparable-type');
            $this->notCopy = true; // Si NO viene el tipo (usa Sesión), SÍ mostrar el botón.
        }

        //dd($comparableType);
        // 1. OBTENER EL COMPARABLE PRINCIPAL (con su creador)
        $comparableData = ComparableModel::with('createdBy')->find($id);

        if (!$comparableData) {
            // Manejar si no se encuentra el comparable
            return;
        }

        //dd($comparableData);

        if($this->comparableType === 'land') $pivotTable = ValuationLandComparableModel::class;
        if($this->comparableType === 'building') $pivotTable = ValuationBuildingComparableModel::class;

        // 2. OBTENER LA COLECCIÓN DE REGISTROS DE ASIGNACIÓN DIRECTAMENTE
        //    Cargamos el modelo de Valuación (Avalúo) y el Usuario (createdBy)
        //    a través del modelo de la tabla intermedia (ValuationComparableModel).
        $assignmentRecords = $pivotTable::where('comparable_id', $id) // <- NOMBRE DE VARIABLE CORREGIDO
            ->with(['valuation', 'createdBy']) // 'valuation' y 'createdBy' son relaciones BelongsTo en el modelo de la tabla intermedia
            ->get();

        // 3. ASIGNAR LA DATA:
        //    $this->ValuationRecords ahora contiene la lista de registros de asignación,
        //    y cada registro ya tiene cargado el Avalúo y el Usuario que lo asignó.
        $this->ValuationComparables = $assignmentRecords->toArray(); // <- NOMBRE DE VARIABLE CORREGIDO
        $this->comparable = $comparableData;



        //dd($this->ValuationComparables, $this->comparable);


        Flux::modal('comparable-summary')->show();
    }

    public function render()
    {
        return view('livewire.forms.comparables.comparable-summary');
    }
}
