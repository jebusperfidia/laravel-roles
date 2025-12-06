<?php

namespace App\Services;

use App\Models\Valuations\Valuation;
// ¡Asegúrate que la ruta a tu modelo de factores sea correcta!
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use Illuminate\Support\Facades\Config;

class HomologationValuationService
{
    /**
     * Crea los 7 factores de homologación por defecto para un nuevo Avalúo (Sujeto).
     * Se llama inmediatamente después de crear la Valuation.
     *
     * @param Valuation $valuation El modelo de Avalúo recién creado.
     * @return void
     */
    public function createValuationFactors(Valuation $valuation): void
    {
        //Obtenemos los factores por defecto desde un archivo de configuración
        $defaultFactors = Config::get('homologation_valuation.valuation_subject_factors');

        $factorsToInsert = [];
        $now = now(); // Para los timestamps

        foreach ($defaultFactors as $factorData) {


            $isFeq = ($factorData['homologation_type'] === 'building' && $factorData['acronym'] === 'FEQ');


            $factorsToInsert[] = [
                'valuation_id' => $valuation->id,
                'factor_name' => $factorData['factor_name'],
                'acronym' => $factorData['acronym'],
                'is_editable' => $factorData['is_editable'],
                'homologation_type' => $factorData['homologation_type'],
                'is_custom' => false,
                'is_feq' => $isFeq,
                'rating' => 1.0000,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 2. Inserta todos los 7 factores en la base de datos de un solo golpe
        if (!empty($factorsToInsert)) {
            HomologationValuationFactorModel::insert($factorsToInsert);
        }
    }
}
