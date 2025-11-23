<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationComparableFactorModel;
use Illuminate\Support\Facades\Log;

class HomologationComparableService
{
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
        | Aseguramos que todas las filas tengan EXACTAMENTE las mismas claves,
        | en el mismo orden. Esto elimina errores de "column count doesn't match".
        |--------------------------------------------------------------------------
        */
        if (!empty($factorsToInsert)) {
            // Definimos el set completo de columnas que queremos insertar (mismo orden).
            $columns = [
                'valuation_land_comparable_id',
                'valuation_building_comparable_id',
                'homologation_type',
                'factor_name',
                'acronym',
                'is_editable',
                'rating',
                'applicable',
                'created_at',
                'updated_at',
            ];

            // Normalizamos cada fila: rellenamos keys faltantes con null y preservamos el orden.
            $normalized = array_map(function ($row) use ($columns) {
                // Rellena con null las claves que falten
                $base = array_fill_keys($columns, null);
                // Sobrescribe con los valores reales
                foreach ($row as $k => $v) {
                    $base[$k] = $v;
                }
                // Asegura el orden según $columns
                $ordered = [];
                foreach ($columns as $col) {
                    $ordered[$col] = $base[$col];
                }
                return $ordered;
            }, $factorsToInsert);

            // Inserción masiva con arrays normalizados
            HomologationComparableFactorModel::insert($normalized);
        }

        Log::debug("HomologationComparableService FINALIZADO CON ÉXITO");
    }


    public function deleteComparableFactors(int $pivotId, string $type): void
    {
        $fkColumn = $type === 'land'
            ? 'valuation_land_comparable_id'
            : 'valuation_building_comparable_id';

        HomologationComparableFactorModel::where($fkColumn, $pivotId)->delete();
    }
}
