<?php

namespace App\Models\Forms\LandDetails;

use Illuminate\Database\Eloquent\Model;
//use App\Models\LandDetailsModel;

class MeasureBoundaryModel extends Model
{

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'measures_boundaries';


    protected $fillable = [
        'land_detail_id',
        'file_path',
        'original_name',
        'file_type',
    ];

    /**
     * Cada archivo pertenece a un LandDetail.
     */
    public function landDetail()
    {
        return $this->belongsTo(LandDetailsModel::class, 'land_detail_id');
    }
}
