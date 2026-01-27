<?php

namespace App\Models\Forms\Conclusions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Valuations\Valuation;

class ConclusionModel extends Model
{

    protected $table = 'conclusions';

    use HasFactory;

    protected $fillable = [
        'valuation_id',
        'land_value',
        'market_value',
        'hypothetical_value',
        'physical_value',
        'other_value',
        'selected_value_type',
        'difference',
        'range',
        'rounding',
        'concluded_value',
    ];

    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }
}
