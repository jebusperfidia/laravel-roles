<?php

namespace App\Models\Forms\Comparable;

use App\Models\Valuations\Valuation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComparableModel extends Model
{
    protected $table = 'comparables';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Mapea todas las propiedades del Livewire (camelCase) a las columnas de la DB (snake_case).
     */
    protected $fillable = [
        'valuation_id',
        'comparable_key',
        'comparable_folio',
        'comparable_discharged_by',
        'comparable_property',
        'comparable_entity',
        'comparable_entity_name',
        'comparable_locality',
        'comparable_locality_name',
        'comparable_colony',
        'comparable_other_colony',
        'comparable_street',
        'comparable_between_street',
        'comparable_and_street',
        'comparable_cp',
        'comparable_name',
        'comparable_last_name',
        'comparable_phone',
        'comparable_url',
        'comparable_land_use',
        'comparable_desc_services_infraestructure',
        'comparable_services_infraestructure',
        'comparable_shape',
        'comparable_density',
        'comparable_front',
        'comparable_front_type',
        'comparable_description_form',
        'comparable_topography',
        'comparable_characteristics',
        'comparable_characteristics_general',
        'comparable_location_block',
        'comparable_street_location',
        'comparable_general_prop_area',
        'comparable_urban_proximity_reference',
        'comparable_source_inf_images',
        'comparable_photos',
        'comparable_abroad_number',
        'comparable_inside_number',
        'comparable_allowed_levels',
        'comparable_number_fronts',
        'comparable_free_area_required',
        'comparable_slope',
        'comparable_offers',
        'comparable_land_area',
        'comparable_built_area',
        'comparable_unit_value',
        'comparable_bargaining_factor',
        'comparable_latitude',
        'comparable_longitude',
        'is_active', // Mapeo de comparableActive
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        // Valores flotantes
        'comparable_free_area_required' => 'float',
        'comparable_slope' => 'float',
        'comparable_offers' => 'float',
        'comparable_land_area' => 'float',
        'comparable_built_area' => 'float',
        'comparable_unit_value' => 'float',
        'comparable_bargaining_factor' => 'float',
        'comparable_latitude' => 'float',
        'comparable_longitude' => 'float',
        // Valores enteros
        'comparable_allowed_levels' => 'integer',
        'comparable_number_fronts' => 'integer',
        // Los números de calle se dejaron como string en la migración.
    ];

    /**
     * Obtiene el avalúo al que pertenece este comparable.
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }


    /**
     * Relación 1:N con la tabla pivote (valuation_comparables).
     *
     * Devuelve los registros pivote donde este comparable
     * ha sido asignado a distintos avalúos.
     *
     * Ejemplo:
     * $comparable->assignedValuations → registros pivote donde aparece este comparable
     */

    public function assignedValuations()
    {
        return $this->hasMany(ValuationComparableModel::class, 'comparable_id');
    }


    /**
     * Relación N:M con los avalúos.
     *
     * Devuelve los modelos de avalúos a los que está vinculado este comparable
     * a través de la tabla "valuation_comparables".
     *
     * Incluye los campos extra del pivote (position, is_active, created_by)
     * y timestamps.
     *
     * Ejemplo:
     * $comparable->valuations → colección de modelos Valuation
     */

    public function valuations()
    {
        return $this->belongsToMany(
            Valuation::class,
            'valuation_comparables',
            'comparable_id',
            'valuation_id'
        )
            ->withPivot(['position', 'is_active', 'created_by'])
            ->withTimestamps();
    }
}
