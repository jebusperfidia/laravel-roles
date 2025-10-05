<?php

namespace App\Models\Forms\Building;

// Usamos el nombre corregido

use Illuminate\Database\Eloquent\Model;

class BuildingConstructionModel extends Model
{
    protected $table = 'building_constructions';

    protected $fillable = [
        'building_id',

        'description',
        'clasification',
        'use',
        'building_levels',
        'levels_construction_type',
        'age',
        'surface',
        'source_information',
        'unit_cost_replacement',
        'progress_work',
        'conservation_state',
        'range_based_height',
        'surface_vad',
        'type',
    ];



    protected $casts = [
        'range_based_height' => 'boolean', // <--- AÑADE ESTA LÍNEA
    ];




    /*
    |--------------------------------------------------------------------------
    | RELACIÓN BELONGS TO (PERTENECE A)
    |--------------------------------------------------------------------------
    */

    /**
     * Define la relación con el avalúo (Valuation).
     */
    public function building()
    {
        // Un elemento de construcción pertenece a un avalúo (Relación 1:1 o 1:N vista desde aquí)
        return $this->belongsTo(BuildingModel::class, 'building_id');
    }
}
