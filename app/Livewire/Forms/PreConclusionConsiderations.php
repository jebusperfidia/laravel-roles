<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Forms\PreConclusionConsideration\PreConclusionConsiderationModel;
use Masmerise\Toaster\Toaster;
use App\Traits\ValuationLockTrait;


class PreConclusionConsiderations extends Component
{
    use ValuationLockTrait;

    public $valuation; // Objeto completo del avalúo
    public $additionalConsiderations = '';

    public function mount($valuation)
    {
        $this->valuation = $valuation;

        if (!$valuation) return;

        $this->checkReadOnlyStatus($valuation);


        // Validamos que el objeto exista y tenga ID para evitar errores
        if ($this->valuation && $this->valuation->id) {

            // CORRECCIÓN 1: Usamos $this->valuation->id (el entero) no el objeto completo
            // CORRECCIÓN 2: Agregamos ->first() para ejecutar la query y traer el registro
            $record = PreConclusionConsiderationModel::where('valuation_id', $this->valuation->id)->first();

            if ($record) {
                $this->additionalConsiderations = $record->additional_considerations;
            }
        }
    }

    public function save()
    {
        $this->ensureNotReadOnly();
        // Validación defensiva
      /*   if (!$this->valuation || !$this->valuation->id) {
             Toaster::error('Error: No se identificó el avalúo.');
             return;
        } */

        PreConclusionConsiderationModel::updateOrCreate(
            ['valuation_id' => $this->valuation->id],
            ['additional_considerations' => $this->additionalConsiderations]
        );

        Toaster::success('Consideraciones guardadas con éxito');

        // Redirección
        return redirect()->route('form.index', ['section' => 'applicable-surfaces']);
    }

    public function render()
    {
        return view('livewire.forms.pre-conclusion-considerations');
    }
}
