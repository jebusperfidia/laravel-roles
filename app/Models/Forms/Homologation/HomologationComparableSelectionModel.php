<?php

namespace App\Models\Forms\Homologation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Forms\Comparable\ValuationBuildingComparableModel;

class HomologationComparableSelectionModel extends Model
{
    use HasFactory;

    // Nombre de la tabla que acabamos de crear en la migración
    protected $table = 'homologation_comparable_selections';

    protected $fillable = [
        'valuation_building_comparable_id',
        'variable',        // 'clase', 'conservacion', 'localizacion'
        'value',           // Valor seleccionado (texto)
        'factor',          // Valor numérico (opcional)
        'homologation_type'
    ];

    /**
     * Relación inversa: Una selección pertenece a un Pivote de Building
     */
    public function buildingComparablePivot()
    {
        return $this->belongsTo(ValuationBuildingComparableModel::class, 'valuation_building_comparable_id');
    }
}
