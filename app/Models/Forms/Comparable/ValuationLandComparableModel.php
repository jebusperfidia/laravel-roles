<?php

namespace App\Models\Forms\Comparable;

use App\Models\Valuations\Valuation;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ValuationLandComparableModel extends Model
{
    protected $table = 'valuation_land_comparables';

    protected $fillable = [
        'valuation_id',
        'comparable_id',
        'position',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'position' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relación al avaluo
    public function valuation(): BelongsTo
    {
        return $this->belongsTo(Valuation::class);
    }

    // Relación al comparable
    public function comparable(): BelongsTo
    {
        return $this->belongsTo(ComparableModel::class, 'comparable_id');
    }

    // (Opcional) relación al usuario que asignó
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
