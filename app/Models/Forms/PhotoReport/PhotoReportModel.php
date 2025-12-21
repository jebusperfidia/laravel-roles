<?php

namespace App\Models\Forms\PhotoReport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoReportModel extends Model
{
    use HasFactory;

    protected $table = 'valuation_photos';

    protected $fillable = [
        'valuation_id',
        'file_path',
        'file_name',
        'category',
        'description',
        'is_printable',
        'rotation_angle',
        'sort_order',
    ];

    protected $casts = [
        'is_printable' => 'boolean',
        'rotation_angle' => 'integer',
        'sort_order' => 'integer',
    ];
}
