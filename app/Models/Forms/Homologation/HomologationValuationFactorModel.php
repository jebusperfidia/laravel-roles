<?php

namespace App\Models\Forms\Homologation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Valuations\Valuation;

class HomologationValuationFactorModel extends Model
{
    use HasFactory;

    protected $table = 'homologation_valuation_factors';

    protected $fillable = [
        'valuation_id',
        'factor_name',
        'acronym',
        'is_editable',
        'rating',
        'homologation_type',
    ];

    protected $casts = [
        'is_editable' => 'boolean',
        'rating' => 'float',
    ];

    /**
     * Un factor pertenece a un Avalúo.
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }
}
