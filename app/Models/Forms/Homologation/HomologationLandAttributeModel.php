<?php

namespace App\Models\Forms\Homologation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomologationLandAttributeModel extends Model
{
    use HasFactory;

    protected $table = 'homologation_land_attributes';

    protected $fillable = [
        'valuation_id',
        'subject_surface_option_id',
        'subject_surface_value',
        //'surface_applicable_area',

        'cus',
        'cos',
        'mode_lot',
        'unit_value_mode_lot',
        'conclusion_type_rounding',
        'average_arithmetic',  // <--- NUEVO
        'average_homologated', // <--- NUEVO
    ];


}
