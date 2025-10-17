<?php

namespace App\Models\Forms\ConstructionElements;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finishing2Model extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'finishings_2';

    protected $fillable = [
        'construction_elements_id',

        /* 'cement_plaster',
        'ceilings', */
        'furred_walls',
      /*   'stairs',
        'flats', */
        'plinths',
        'paint',
        'special_coating',
    ];



    public function constructionElement()
    {
        return $this->belongsTo(ConstructionElementModel::class, 'construction_elements_id');
    }
}
