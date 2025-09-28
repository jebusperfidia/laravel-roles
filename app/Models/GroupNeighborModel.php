<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Models\LandDetailsModel;

class GroupNeighborModel extends Model
{

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'group_neighbor';

    protected $fillable = [
        'land_detail_id',
        'name',
    ];

    /**
     * Un grupo pertenece a un LandDetail.
     */
    public function landDetail()
    {
        return $this->belongsTo(LandDetailsModel::class);
    }

    /**
     * Un grupo tiene muchos detalles.
     */
    public function details()
    {
        return $this->hasMany(GroupNeighborDetailModel::class);
    }
}
