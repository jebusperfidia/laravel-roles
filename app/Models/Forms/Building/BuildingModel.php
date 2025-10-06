<?php

namespace App\Models\Forms\Building;

use App\Models\Valuations\Valuation;
 // Usamos el nombre corregido

use Illuminate\Database\Eloquent\Model;

class BuildingModel extends Model
{
    protected $table = 'buildings';

    protected $fillable = [
        'valuation_id',

        // Agregar todos los campos de la migración para guardado masivo
        'source_replacement_obtained',
        'conservation_status',
        'observations_state_conservation',
        'general_type_properties_zone',
        'general_class_property',
        'year_completed_work',
        'profitable_units_subject',
        'profitable_units_general',
        'profitable_units_condominiums',
        'number_subject_levels',
        'progress_general_works',
        'degree_progress_common_areas',
    ];





    /*
    |--------------------------------------------------------------------------
    | RELACIÓN DE UNO A MUCHOS (HAS MANY)
    |--------------------------------------------------------------------------
    | Un elemento de construcción puede tener MÚLTIPLES elementos genéricos.
    */

    // Relación 1:N con Otros Elementos
    public function buildingConstructions()
    {
        return $this->hasMany(BuildingConstructionModel::class, 'building_id');
    }


    //Generamos una función para obtener los valores por diferentes tipos
    public function privates()
    {
        return $this->buildingConstructions()->where('type', 'private');
    }

    public function commons()
    {
        return $this->buildingConstructions()->where('type', 'common');
    }




    /*
    |--------------------------------------------------------------------------
    | RELACIÓN BELONGS TO (PERTENECE A)
    |--------------------------------------------------------------------------
    */

    /**
     * Define la relación con el avalúo (Valuation).
     */
    public function valuation()
    {
        // Un elemento de construcción pertenece a un avalúo (Relación 1:1 o 1:N vista desde aquí)
        return $this->belongsTo(Valuation::class);
    }
}
