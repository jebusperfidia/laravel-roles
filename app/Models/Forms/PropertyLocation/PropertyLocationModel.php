<?php

namespace App\Models\Forms\PropertyLocation;

use App\Models\Valuations\Valuation;
use Illuminate\Database\Eloquent\Model;

class PropertyLocationModel extends Model
{
    //Indicamos el nobmre de la tabla correcta
    protected $table = 'property_locations';

    // Asignación masiva permitida
    protected $fillable = [
        'valuation_id',
        'latitude',
        'longitude',
        'altitude',
    ];

    /**
     * Relación inversa a Valuation
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }
}
