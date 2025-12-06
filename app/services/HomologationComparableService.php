<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\Log;

// Modelos de Factores
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationComparableFactorModel;

// Modelos de Equipamiento
use App\Models\Forms\Homologation\HomologationValuationEquipmentModel;
use App\Models\Forms\Homologation\HomologationComparableEquipmentModel;

class HomologationComparableService
{
    // =========================================================================
    // FACTORES: CREACIÓN Y COPIA (Ejecutado en assignedElement)
    // =========================================================================

   public function createComparableFactors(int $valuationId, EloquentModel $comparablePivot, string $type): void
    {
        $subjectFactors = HomologationValuationFactorModel::where('valuation_id', $valuationId)
            ->where('homologation_type', $type)
            ->get();

        $factorsToInsert = [];
        $now = now();

        $landId = $type === 'land' ? $comparablePivot->id : null;
        $buildingId = $type === 'building' ? $comparablePivot->id : null;

        /*
        |--------------------------------------------------------------------------
        | BLOQUE LAND
        |--------------------------------------------------------------------------
        */
        if ($type === 'land') {

            foreach ($subjectFactors as $subjectFactor) {
                $factorsToInsert[] = [
                    'valuation_land_comparable_id'     => $landId,
                    'valuation_building_comparable_id' => null,
                    'homologation_type'                => $subjectFactor->homologation_type,
                    'factor_name'                      => $subjectFactor->factor_name,
                    'acronym'                          => $subjectFactor->acronym,
                    'is_editable'                      => $subjectFactor->is_editable,
                    // [CORRECCIÓN 1] Agregar estas líneas:
                    'is_custom'                        => $subjectFactor->is_custom,
                    'is_feq'                           => $subjectFactor->is_feq,
                    'rating'                           => 1.0000,
                    'applicable'                       => 1.0000,
                    'created_at'                       => $now,
                    'updated_at'                       => $now,
                ];
            }

            // FNEG para LAND
            $factorsToInsert[] = [
                'valuation_land_comparable_id'     => $landId,
                'valuation_building_comparable_id' => null,
                'homologation_type'                => 'land',
                'factor_name'                      => 'F. Negociación',
                'acronym'                          => 'FNEG',
                'is_editable'                      => false,
                // [CORRECCIÓN 1b] FNEG defaults:
                'is_custom'                        => false,
                'is_feq'                           => false,
                'rating'                           => 1.0000,
                'applicable'                       => 1.0000,
                'created_at'                       => $now,
                'updated_at'                       => $now,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | BLOQUE BUILDING
        |--------------------------------------------------------------------------
        */ else {

            foreach ($subjectFactors as $subjectFactor) {
                $factorsToInsert[] = [
                    'valuation_land_comparable_id'     => null,
                    'valuation_building_comparable_id' => $buildingId,
                    'homologation_type'                => $subjectFactor->homologation_type,
                    'factor_name'                      => $subjectFactor->factor_name,
                    'acronym'                          => $subjectFactor->acronym,
                    'is_editable'                      => $subjectFactor->is_editable,
                    // [CORRECCIÓN 2] Copiar el ADN del padre:
                    'is_custom'                        => $subjectFactor->is_custom,
                    'is_feq'                           => $subjectFactor->is_feq,
                    'rating'                           => 1.0000,
                    'applicable'                       => 1.0000,
                    'created_at'                       => $now,
                    'updated_at'                       => $now,
                ];
            }

            // FNEG para BUILDING
            $factorsToInsert[] = [
                'valuation_land_comparable_id'     => null,
                'valuation_building_comparable_id' => $buildingId,
                'homologation_type'                => 'building',
                'factor_name'                      => 'F. Negociación',
                'acronym'                          => 'FNEG',
                'is_editable'                      => false,
                // [CORRECCIÓN 2b] FNEG defaults:
                'is_custom'                        => false,
                'is_feq'                           => false,
                'rating'                           => 1.0000,
                'applicable'                       => 1.0000,
                'created_at'                       => $now,
                'updated_at'                       => $now,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | NORMALIZAR FILAS ANTES DEL INSERT
        |--------------------------------------------------------------------------
        */
        if (!empty($factorsToInsert)) {
            // [CORRECCIÓN 3] Agregar is_custom e is_feq al array permitido
            $columns = [
                'valuation_land_comparable_id',
                'valuation_building_comparable_id',
                'homologation_type',
                'factor_name',
                'acronym',
                'is_editable',
                'is_custom', // <--- ¡AQUÍ!
                'is_feq',    // <--- ¡Y AQUÍ!
                'rating',
                'applicable',
                'created_at',
                'updated_at',
            ];

            // Normalizamos cada fila: rellena keys faltantes con null y preservamos el orden.
            $normalized = array_map(function ($row) use ($columns) {
                $base = array_fill_keys($columns, null);
                foreach ($row as $k => $v) {
                    $base[$k] = $v;
                }
                $ordered = [];
                foreach ($columns as $col) {
                    $ordered[$col] = $base[$col];
                }
                return $ordered;
            }, $factorsToInsert);

            // Inserción masiva
            HomologationComparableFactorModel::insert($normalized);
        }

        Log::debug("Factores sincronizados con éxito.");
    }

    // =========================================================================
    // EQUIPAMIENTO: CREACIÓN Y COPIA (NUEVA LÓGICA FEQ)
    // =========================================================================

    /**
     * Copia el equipamiento del Avalúo (Sujeto) al Comparable recién asignado (solo Buildings).
     */
    public function createComparableEquipment(int $valuationId, int $pivotId, string $type): void
    {
        // 1. Solo ejecutamos si es tipo 'building'
        if ($type !== 'building') {
            return;
        }

        // 2. Obtenemos el equipamiento base del Avalúo (Sujeto)
        $subjectEquipments = HomologationValuationEquipmentModel::where('valuation_id', $valuationId)->get();

        if ($subjectEquipments->isEmpty()) {
            return;
        }

        $equipmentsToInsert = [];
        $now = now();

        // 3. Preparamos el array para inserción masiva
        foreach ($subjectEquipments as $subjectEq) {
            $equipmentsToInsert[] = [
                'valuation_equipment_id'           => $subjectEq->id,
                'valuation_building_comparable_id' => $pivotId, // ID de la tabla PIVOTE (Construcción)
                'description'                      => $subjectEq->description,
                'unit'                             => $subjectEq->unit,
                'quantity'                         => $subjectEq->quantity, // Copiamos cantidad inicial del sujeto
                'difference'                       => 0.00,
                'percentage'                       => 0.00,
                'created_at'                       => $now,
                'updated_at'                       => $now,
            ];
        }

        // 4. Insertar
        if (!empty($equipmentsToInsert)) {
            HomologationComparableEquipmentModel::insert($equipmentsToInsert);
        }

        Log::debug("Equipamiento (FEQ) sincronizado para Comparable Pivot ID: $pivotId");
    }

    // =========================================================================
    // DATOS: ELIMINACIÓN (Ejecutado en deallocatedElement)
    // =========================================================================

    /**
     * Elimina los factores de homologación asociados a un comparable desasignado.
     */
    public function deleteComparableFactors(int $pivotId, string $type): void
    {
        $fkColumn = $type === 'land'
            ? 'valuation_land_comparable_id'
            : 'valuation_building_comparable_id';

        HomologationComparableFactorModel::where($fkColumn, $pivotId)->delete();
        Log::debug("Factores eliminados para Comparable Pivot ID: $pivotId");
    }

    /**
     * Elimina el equipamiento asociado a un comparable desasignado (solo Buildings).
     */
    public function deleteComparableEquipment(int $pivotId, string $type): void
    {
        if ($type !== 'building') {
            return;
        }

        // Borramos usando el ID de la tabla pivot de building
        HomologationComparableEquipmentModel::where('valuation_building_comparable_id', $pivotId)->delete();

        Log::debug("Equipamiento (FEQ) eliminado para Comparable Pivot ID: $pivotId");
    }
}
