<?php

namespace App\Models\Forms\Homologation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Valuations\Valuation;

class HomologationValuationEquipmentModel extends Model
{
    use HasFactory;

    protected $table = 'homologation_valuation_equipments';

    protected $fillable = [
        'valuation_id',
        'description',
        'unit',
        'quantity',
        'total_value',
    ];

    protected $casts = [
        'quantity' => 'float',
        'total_value' => 'float',
    ];

    public function valuation()
    {
        return $this->belongsTo(Valuation::class, 'valuation_id');
    }

    /**
     * Un ítem del Sujeto tiene muchos clones en los Comparables.
     * FK CORREGIDA.
     */
    public function comparableEquipments()
    {
        return $this->hasMany(HomologationComparableEquipmentModel::class, 'valuation_equipment_id');
    }
}
