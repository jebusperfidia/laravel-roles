<?php

namespace App\Models\Forms\Homologation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Valuations\Valuation;

class HomologationBuildingAttributeModel extends Model
{
    use HasFactory;

    protected $table = 'homologation_building_attributes';

    protected $fillable = [
        'valuation_id',
        'unit_value_mode_lot',
        'conclusion_type_rounding',
    ];

    public function valuation()
    {
        return $this->belongsTo(Valuation::class, 'valuation_id');
    }
}
