<?php

namespace App\Models\Forms\ConstructionElements;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HydraulicModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'hydraulics';

    protected $fillable = [
        'construction_elements_id',


        'bathroom_furniture',

        'hidden_apparent_hydraulic_branches',
        'hydraulic_branches',

        'hidden_apparent_sanitary_branches',
        'sanitary_branches',

        'hidden_apparent_electrics',
        'electrics',
    ];



    public function constructionElement()
    {
        return $this->belongsTo(ConstructionElementModel::class, 'construction_elements_id');
    }
}
