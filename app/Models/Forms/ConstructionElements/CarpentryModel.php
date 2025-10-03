<?php

namespace App\Models\Forms\ConstructionElements;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarpentryModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'carpentry';

    protected $fillable = [
        'construction_elements_id',

        'doors_access',
        'inside_doors',
        'fixed_furniture_bedrooms',
        'fixed_furniture_inside_bedrooms',

    ];



    public function constructionElement() // <-- Nombre corregido
    {
        // El método belongsTo infiere la clave foránea 'construction_element_id'
        return $this->belongsTo(ConstructionElementModel::class, 'construction_elements_id');
    }
}
