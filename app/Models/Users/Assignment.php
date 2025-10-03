<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'valuation_id',
        'appraiser_id',
        'operator_id',
    ];
}
