<?php

namespace App\Models\Forms\ConstructionElements;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherElementModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'other_elements';

    protected $fillable = [
        'construction_elements_id',

        'structure',
        'locksmith',
        'facades',
        'elevator',


    ];



    public function constructionElement()
    {
        return $this->belongsTo(ConstructionElementModel::class, 'construction_elements_id');
    }
}
