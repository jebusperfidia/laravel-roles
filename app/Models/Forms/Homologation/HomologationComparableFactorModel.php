<?php

namespace App\Models\Forms\Homologation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Forms\Comparable\ValuationLandComparableModel;
use App\Models\Forms\Comparable\ValuationBuildingComparableModel;

class HomologationComparableFactorModel extends Model
{
    use HasFactory;

    protected $table = 'homologation_comparable_factors';

    protected $fillable = [
        'valuation_land_comparable_id',
        'valuation_building_comparable_id',
        'factor_name',
        'acronym',
        'is_editable',
        'is_custom',
        'rating',
        'applicable',
        'homologation_type',
    ];

    protected $casts = [
        'is_editable' => 'boolean',
        'is_custom' => 'boolean',
        'rating' => 'float',
        'applicable' => 'float',
    ];

    /**
     * Un factor pertenece a una "HojaDeConexion" de Land.
     */
    public function landComparablePivot()
    {
        return $this->belongsTo(ValuationLandComparableModel::class, 'valuation_land_comparable_id');
    }

    /**
     * Un factor pertenece a una "HojaDeConexion" de Building.
     */
    public function buildingComparablePivot()
    {
        return $this->belongsTo(ValuationBuildingComparableModel::class, 'valuation_building_comparable_id');
    }
}
