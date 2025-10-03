<?php

namespace App\Models\Forms\LandDetails;

use Illuminate\Database\Eloquent\Model;
//use App\Models\LandDetailsModel;
/* use App\Models\Forms\LandDetails\GroupNeighborDetailsModel; */


class GroupsNeighborsModel extends Model
{

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'groups_neighbors';

    protected $fillable = [
        'land_detail_id',
        'name',
    ];

    /**
     * Un grupo pertenece a un LandDetail.
     */
    public function landDetail()
    {
        /* return $this->belongsTo(LandDetailsModel::class); */
        return $this->belongsTo(LandDetailsModel::class, 'land_detail_id');
    }

    /**
     * Un grupo tiene muchos detalles.
     */
    public function neighbors()
{
    return $this->hasMany(GroupNeighborDetailsModel::class, 'group_neighbor_id');
}

}
