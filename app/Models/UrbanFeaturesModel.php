<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrbanFeaturesModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'urban_features';

    protected $fillable = [
        'valuation_id',

        // Características urbanas
        'zone_classification',
        'predominant_buildings',
        'zone_building_levels',
        'building_usage',
        'zone_saturation_index',
        'population_density',
        'housing_density',
        'zone_socioeconomic_level',
        'access_routes_importance',
        'environmental_pollution',

        // Infraestructura
        'water_distribution',
        'wastewater_collection',
        'street_storm_drainage',
        'zone_storm_drainage',
        'mixed_drainage_system',
        'other_water_disposal',

        // Servicios
        'electric_supply',
        'electrical_connection',
        'public_lighting',
        'natural_gas',
        'security',
        'garbage_collection',
        'garbage_collection_frecuency',
        'telephone_service',
        'telephone_connection',
        'road_signage',
        'street_naming',

        // Vialidades
        'roadways',
        'roadways_others',
        'roadways_mts',

        // Banquetas
        'sidewalks',
        'sidewalks_others',
        'sidewalks_mts',

        // Guarniciones
        'curbs',
        'curbs_others',
        'curbs_mts',

        // Uso del suelo
        'land_use',
        'description_source_land',
        'mandatory_free_area',
        'allowed_levels',
        'land_coefficient_area',
    ];

    /**
     * Casts para convertir tipos nativos.
     */
    protected $casts = [
        'valuation_id' => 'integer',

        // Infraestructura y servicios como enteros (para tinyInteger)
  /*       'waterDistribution' => 'integer',
        'wastewaterCollection' => 'integer',
        'streetStormDrainage' => 'integer',
        'zoneStormDrainage' => 'integer',
        'mixedDrainageSystem' => 'integer',
        'otherWaterDisposal' => 'integer',

        'electricSupply' => 'integer',
        'electrical_connection' => 'integer',
        'public_lighting' => 'integer',
        'natural_gas' => 'integer',
        'security' => 'integer',
        'garbage_collection' => 'integer',
        'telephone_service' => 'integer',
        'telephone_connection' => 'integer',
        'road_signage' => 'integer',
        'street_naming' => 'integer',
 */
        // Vialidades, Banquetas, Guarniciones mts son decimales
        'roadways_mts' => 'decimal:2',
        'sidewalks_mts' => 'decimal:2',
        'curbs_mts' => 'decimal:2',

        // Uso del suelo
/*         'mandatory_free_area' => 'integer',
        'allowed_levels' => 'integer', */
        'land_coefficient_area' => 'decimal:2',
    ];

    /**
     * Define la relación con el avalúo (Valuation).
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }
}
