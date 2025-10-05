<?php

namespace App\Models\Forms\ConstructionElements;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishingOtherModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'finishings_others';

    protected $fillable = [
        'construction_elements_id',

        'space',
        'amount',
        'floors',
        'walls',
        'ceilings'

    ];



    public function constructionElement()
    {
        return $this->belongsTo(ConstructionElementModel::class, 'construction_elements_id');
    }
}
