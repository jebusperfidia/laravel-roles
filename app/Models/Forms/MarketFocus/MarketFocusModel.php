<?php

namespace App\Models\Forms\MarketFocus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketFocusModel extends Model
{
    use HasFactory;

    protected $table = 'market_focus';

    protected $fillable = [
        'valuation_id',
        'surplus_percentage',
    ];
}
