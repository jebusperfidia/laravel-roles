<?php

namespace App\Models\Forms\Homologation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Forms\Comparable\ValuationBuildingComparableModel;

class HomologationComparableEquipmentModel extends Model
{
    use HasFactory;

    protected $table = 'homologation_comparable_equipments';

    protected $fillable = [
        'valuation_equipment_id', // Nombre de la columna
        'valuation_building_comparable_id',
        'description',
        'unit',
        'quantity',
        'difference',
        'percentage',
    ];

    protected $casts = [
        'quantity' => 'float',
        'difference' => 'float',
        'percentage' => 'float',
    ];

    /**
     * Apunta al ítem Maestro (Sujeto) del que fue clonado.
     * FK CORREGIDA.
     */
    public function subjectEquipment()
    {
        return $this->belongsTo(HomologationValuationEquipmentModel::class, 'valuation_equipment_id');
    }

    public function comparablePivot()
    {
        return $this->belongsTo(ValuationBuildingComparableModel::class, 'valuation_building_comparable_id');
    }
}
