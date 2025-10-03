<?php

namespace App\Models\Forms\ConstructionElements;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finishing1Model extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'finishings_1';

    protected $fillable = [
        'construction_elements_id',

        // Campos Numéricos
        'bedrooms_number',
        'bathrooms_number',
        'half_bathrooms_number',
        'copa_number',
        'unpa_number',

        // Acabados
        'hall_flats',
        'hall_walls',
        'hall_ceilings',

        'stdr_flats',
        'stdr_walls',
        'stdr_ceilings',

        'kitchen_flats',
        'kitchen_walls',
        'kitchen_ceilings',

        'bedrooms_flats',
        'bedrooms_walls',
        'bedrooms_ceilings',

        'bathrooms_flats',
        'bathrooms_walls',
        'bathrooms_ceilings',

        'half_bathrooms_flats',
        'half_bathrooms_walls',
        'half_bathrooms_ceilings',

        'utyr_flats',
        'utyr_walls',
        'utyr_ceilings',

        'stairs_flats',
        'stairs_walls',
        'stairs_ceilings',

        'copa_flats',
        'copa_walls',
        'copa_ceilings',

        'unpa_flats',
        'unpa_walls',
        'unpa_ceilings',


    ];


    public function constructionElement() // <-- Nombre corregido
    {
        // El método belongsTo infiere la clave foránea 'construction_element_id'
        return $this->belongsTo(ConstructionElementModel::class, 'construction_elements_id');
    }
}
