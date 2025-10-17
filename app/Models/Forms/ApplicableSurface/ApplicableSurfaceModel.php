<?php

namespace App\Models\Forms\ApplicableSurface;

use App\Models\Valuations\Valuation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicableSurfaceModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'applicable_surfaces';

    protected $fillable = [
        'valuation_id',

        // Campos de Superficies y Booleano
        'saleable_area',
        'calculation_built_area',
        'built_area',
        'surface_area',

        // Campos Condicionales (nullable)
        'private_lot',
        'private_lot_type',
        'surplus_land_area',

        // Campos de Indiviso y Terreno Proporcional
        'applicable_undivided',
        'proporcional_land',

        // Campos de Fuentes de Información
        'source_surface_area',
        'source_private_lot',
        'source_private_lot_type',
        'source_applicable_undivided',
        'source_proporcional_land',


    ];

    /* protected $casts = [
        'calculation_built_area' => 'boolean',
    ]; */

    /**
     * Define la relación con el avalúo (Valuation).
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }
}
