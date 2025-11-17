<?php

namespace App\Services;

// --- BLOQUE DE 'USE' CORREGIDO ---
use Illuminate\Database\Eloquent\Model as EloquentModel; // <-- ¡AQUÍ ESTÁ EL ARREGLO! Se renombra el alias
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationComparableFactorModel;
use Illuminate\Support\Facades\Log;

/**
 * Servicio encargado de CLONAR los factores del Sujeto (Tabla 1)
 * en la tabla de factores del Comparable (Tabla 2)
 * cuando un comparable es asignado o desasignado.
 */
class HomologationComparableService
{
    /**
     * Crea los factores para un Comparable (Tabla 2) basándose
     * en la lista de factores del Sujeto (Tabla 1).
     */
    // --- SE USA EL NUEVO ALIAS AQUÍ ---
    public function createComparableFactors(int $valuationId, EloquentModel $comparablePivot, string $type): void
    {
        // --- TRAMPA 1: (Ver en storage/logs/laravel.log) ---
      /*   Log::debug("HomologationComparableService INICIADO", [
            'valuationId' => $valuationId,
            'pivot_id' => $comparablePivot->id,
            'pivot_class' => get_class($comparablePivot),
            'type' => $type
        ]);
 */
        // --- TRAMPA 2: ¿Encontramos factores del Sujeto? ---
        $subjectFactors = HomologationValuationFactorModel::where('valuation_id', $valuationId)
            ->where('homologation_type', $type)
            ->get();

       /*  if ($subjectFactors->isEmpty()) {
            dd(
                '¡ERROR DE DEPURACIÓN! (Paso 1)',
                'El servicio SÍ se ejecutó, pero NO encontró factores "subject" (Tabla 1) para clonar.',
                'valuationId:' . $valuationId,
                'type:' . $type
            );
        } */

        // --- TRAMPA 3: ¿El ID del Pivote es NULO? ---
    /*     if (is_null($comparablePivot->id)) {
            dd(
                '¡ERROR DE DEPURACIÓN! (Paso 2)',
                '¡¡EL ID DEL PIVOTE ES NULO!!',
                'El modelo del pivote (ValuationBuildingComparableModel) no está devolviendo un ID después de crearse.',
                $comparablePivot
            );
        }
 */
        $factorsToInsert = [];
        $now = now();

        if ($type === 'land') {
            foreach ($subjectFactors as $subjectFactor) {
                $factorsToInsert[] = [
                    'valuation_land_comparable_id' => $comparablePivot->id,
                    'homologation_type' => $subjectFactor->homologation_type,
                    'factor_name' => $subjectFactor->factor_name,
                    'acronym' => $subjectFactor->acronym,
                    'is_editable' => $subjectFactor->is_editable,
                    'rating' => 1.0000,
                    'applicable' => 1.0000,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        } else { // 'building'
            foreach ($subjectFactors as $subjectFactor) {
                $factorsToInsert[] = [
                    'valuation_building_comparable_id' => $comparablePivot->id,
                    'homologation_type' => $subjectFactor->homologation_type,
                    'factor_name' => $subjectFactor->factor_name,
                    'acronym' => $subjectFactor->acronym,
                    'is_editable' => $subjectFactor->is_editable,
                    'rating' => 1.0000,
                    'applicable' => 1.0000,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // --- TRAMPA 4: ¿Cómo se ve el array? ---
    /*     if ($type === 'building') {
            dd(
                '¡OK! DEPURACIÓN (Paso 3)',
                'El array final que se intentará insertar es:',
                $factorsToInsert
            );
        }
 */
        if (!empty($factorsToInsert)) {
            HomologationComparableFactorModel::insert($factorsToInsert);
        }

        Log::debug("HomologationComparableService FINALIZADO CON ÉXITO");
    }

    /**
     * Elimina todos los factores de homologación (Tabla 2) asociados a un PIVOTE.
     */
    public function deleteComparableFactors(int $pivotId, string $type): void
    {
        $fkColumn = $type === 'land'
            ? 'valuation_land_comparable_id'
            : 'valuation_building_comparable_id';

        HomologationComparableFactorModel::where($fkColumn, $pivotId)->delete();
    }
}
