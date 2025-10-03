<?php

namespace App\Models\Forms\LandDetails;

use Illuminate\Database\Eloquent\Model;
/* use App\Models\Forms\LandDetails\LandDetailsModel; */

class LandSurfaceModel extends Model
{
    protected $table = 'land_surfaces';

    protected $fillable = [
        'land_detail_id',
        'surface'
    ];

    /**
     * Cada superficie pertenece a un detalle de terreno.
     */
    public function landDetail()
    {
        return $this->belongsTo(LandDetailsModel::class, 'land_detail_id');
    }
}
