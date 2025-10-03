<?php

namespace App\Models\Forms\UrbanEquipment;

use App\Models\Valuations\Valuation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UrbanEquipmentModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'urban_equipment';

    protected $fillable = [
        'valuation_id',

        'church',

        'market',
        'super_market',
        'commercial_spaces',
        'number_commercial_spaces',

        'public_square',
        'parks',
        'gardens',
        'sports_courts',
        'sports_center',

        'primary_school',
        'middle_school',
        'high_school',
        'university',
        'other_nearby_schools',

        'first_level',
        'second_level',
        'third_level',

        'bank',

        'community_center',

        'urban_distance',
        'urban_frequency',
        'suburban_distance',
        'suburban_frequency'

    ];



    /**
     * Define la relación con el avalúo (Valuation).
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }
}
