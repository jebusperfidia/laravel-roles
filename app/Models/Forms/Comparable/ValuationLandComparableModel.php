<?php

namespace App\Models\Forms\Comparable;

use App\Models\Forms\Comparable\ComparableModel;
use App\Models\Users\User;
use App\Models\Valuations\Valuation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ValuationLandComparableModel extends Pivot
{
    public $incrementing = true;

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
