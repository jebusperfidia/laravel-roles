<?php

namespace App\Models\Forms\PreConclusionConsideration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreConclusionConsiderationModel extends Model
{
    use HasFactory;

    protected $table = 'pre_conclusion_considerations';

    protected $fillable = [
        'valuation_id',
        'additional_considerations',
    ];
}
