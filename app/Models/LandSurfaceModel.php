<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandSurfaceModel extends Model
{
    protected $table = 'land_surfaces';

    protected $fillable = [
        'land_detail_id',
        'surface',
        'value_area',
    ];

    /**
     * Cada superficie pertenece a un detalle de terreno.
     */
    public function landDetail()
    {
        return $this->belongsTo(LandDetailsModel::class, 'land_detail_id');
    }
}
