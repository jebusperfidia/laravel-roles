<?php

namespace App\Models\Forms\LandDetails;

use Illuminate\Database\Eloquent\Model;

class GroupNeighborDetailsModel extends Model
{

    protected $table = 'group_neighbor_details';

    protected $fillable = [
        'group_neighbor_id',
        'orientation',
        'extent',
        'adjacent',
    ];

    /**
     * Cada detalle pertenece a un grupo vecino.
     */
    public function groupNeighbor()
    {
        return $this->belongsTo(GroupsNeighborsModel::class, 'group_neighbor_id');
    }
}
