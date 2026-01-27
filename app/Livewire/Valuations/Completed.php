<?php

namespace App\Livewire\Valuations;

use App\Models\Valuations\Valuation;
use App\Services\DipomexService;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Completed extends Component
{
    public $statesList = [];

    public function mount(DipomexService $dipomex)
    {
        // 1. OBTENER IDs DE LA BD
        $dbStateIds = Valuation::where('status', 3)
            ->distinct()
            ->pluck('property_entity')
            ->filter()
            ->toArray();

        // 2. OBTENER CATÁLOGO (¡IMPORTANTE! Cambié la llave a '_v2' para limpiar caché viejo)
        $catalog = Cache::remember('dipomex_states_catalog_v2', 60 * 60 * 24, function () use ($dipomex) {
            return $dipomex->getEstados();
        });

        // 3. CRUZAR DATOS
        foreach ($dbStateIds as $dbId) {

            // Intento 1: Directo como en tu PDF (por si el ID es igual)
            $stateName = $catalog[$dbId] ?? null;

            // Intento 2: Si falló, probamos con padding (ej. 17 -> "017" o 1 -> "01")
            if (!$stateName) {
                $paddedId = str_pad($dbId, 2, '0', STR_PAD_LEFT);
                $stateName = $catalog[$paddedId] ?? null;
            }

            // Fallback final: Si de plano no existe, mostramos el ID
            if (!$stateName) {
                // Último intento: recorrer por si las llaves son enteros y el dbId string o viceversa
                // Solo lo hacemos si los métodos directos fallaron
                foreach ($catalog as $key => $val) {
                    if ((int)$key == (int)$dbId) {
                        $stateName = $val;
                        break;
                    }
                }
            }

            $this->statesList[] = [
                'id' => $dbId,
                'name' => $stateName ?? 'ESTADO ' . $dbId
            ];
        }

        // Ordenar alfabéticamente
        usort($this->statesList, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
    }

    public function render()
    {
        return view('livewire.valuations.completed');
    }
}
