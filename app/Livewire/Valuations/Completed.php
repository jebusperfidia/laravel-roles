<?php

namespace App\Livewire\Valuations;

use App\Models\Valuations\Valuation;
use Livewire\Component;

class Completed extends Component
{
    public $statesList = [];

    public function mount()
    {
        // Con COPOMEX, property_entity ya guarda el nombre del estado directamente en la BD.
        // No necesitamos llamar a la API para resolver nombres; los usamos tal cual.
        $this->statesList = Valuation::where('status', 3)
            ->distinct()
            ->get(['property_entity'])
            ->filter(fn($v) => ! empty($v->property_entity))
            ->map(fn($v) => [
                'id'   => $v->property_entity,   // el "id" para filtrar sigue siendo el valor guardado
                'name' => $v->property_entity,    // el nombre ES el valor guardado
            ])
            ->sortBy('name')
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.valuations.completed');
    }
}
