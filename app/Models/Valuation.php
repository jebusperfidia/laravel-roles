<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valuation extends Model
{
    protected $fillable = [
        'date',
        'type',
        'folio',
        'property_type',
    ];
}
