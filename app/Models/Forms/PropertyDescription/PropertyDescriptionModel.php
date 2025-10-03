<?php

namespace App\Models\Forms\PropertyDescription;

use App\Models\Valuations\Valuation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyDescriptionModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'property_description';

    protected $fillable = [
        'valuation_id',

        'urban_proximity',
        'actual_use',
        'multiple_use_space',
        'level_building',
        'project_quality'




    ];

    /**
     * Casts para convertir tipos nativos.
     */
   /*  protected $casts = [
        'valuation_id' => 'integer',

    ]; */

    /**
     * Define la relación con el avalúo (Valuation).
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }

}
