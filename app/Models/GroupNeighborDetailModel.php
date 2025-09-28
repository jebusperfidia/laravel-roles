<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupNeighborDetailModel extends Model
{

    protected $table = 'group_neighbor_detail';

    protected $fillable = [
        'group_neighbor_id',
        'orientation',
        'extent',
        'Adjacent',
    ];

    /**
     * Cada detalle pertenece a un grupo vecino.
     */
    public function groupNeighbor()
    {
        return $this->belongsTo(GroupNeighborModel::class);
    }
}
