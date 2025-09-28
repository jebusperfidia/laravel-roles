<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandDetailsModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'land_details';

    protected $fillable = [
        'valuation_id',


        'source_legal_information',


        'notary_office_deed',
        'deed_deed',
        'volume_deed',
        'date_deed',
        'notary_deed',
        'judicial_distric_deed',


        'file_judgment',
        'date_judgment',
        'court_judgment',
        'municipality_judgment',


        'date_priv_cont',
        'name_priv_cont_acq',
        'first_name_priv_cont_acq',
        'second_name_priv_cont_acq',
        'name_priv_cont_alt',
        'first_name_priv_cont_alt',
        'second_name_priv_cont_alt',


        'folio_aon',
        'date_aon',
        'municipality_aon',


        'record_prop_reg',
        'date_prop_reg',
        'instrument_prop_reg',
        'place_prop_reg',


        'especify_asli',
        'date_asli',
        'emitted_by_asli',
        'folio_asli',



        //CALLES TRANSVERSALES, LIMÍTROFES Y ORIENTACIÓN
        'street_with_front',
        'cross_street_1',
        'cross_street_orientation_1',
        'cross_street_2',
        'cross_street_orientation_2',
        'border_street_1',
        'border_street_orientation_1',
        'border_street_2',
        'border_street_orientation_2',


        'location',

        'configuration',
        'topography',



        'type_of_road',
        'panoramic_features',
        'easement_restrictions',




        //SUPERFICIE DEL TERRENO

        'use_excess_calculation',
        'surface_private_lot',
        'surface_private_lot_type',
        'undivided_only_condominium',
        'undivided_surface_land',
        'surplus_land_area'






    ];

    /**
     * Casts para convertir tipos nativos.
     */
    protected $casts = [
        'valuation_id' => 'integer',

    ];

    /**
     * Define la relación con el avalúo (Valuation).
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }


    /**
     * Un LandDetail tiene muchos grupos vecinos.
     */
    public function groupsNeighbors()
    {
        return $this->hasMany(GroupNeighborModel::class);
    }

    /**
     * Un LandDetail tiene muchos archivos de límites (measures_boundaries).
     */
    public function measureBoundaries()
    {
        return $this->hasMany(MeasureBoundaryModel::class);
    }
}
