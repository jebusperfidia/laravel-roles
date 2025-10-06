<?php

namespace App\Models\Forms\Specialnstallation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Valuations\Valuation;

class SpecialInstallationModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'special_installations';

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'valuation_id',
        'classification_type',
        'element_type',
        'key',
        'description',
        'unit',
        'quantity',
        'age',
        'useful_life',
        'new_rep_unit_cost',
        'age_factor',
        'conservation_factor',
        'net_rep_unit_cost',
        'undivided',
        'amount',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array<string, string>
     */
/*     protected $casts = [
        'quantity' => 'integer',
        'age' => 'integer',
        'useful_life' => 'integer',

        'new_rep_unit_cost' => 'decimal:2',
        'age_factor' => 'decimal:2',
        'conservation_factor' => 'decimal:2',
        'net_rep_unit_cost' => 'decimal:2',
        'undivided' => 'decimal:2',
        'amount' => 'decimal:2',
    ];
 */
    /**
     * Get the valuation that owns the special installation.
     */
    public function valuation()
    {
        // Relación con tu tabla principal 'valuations'
        return $this->belongsTo(Valuation::class);
    }
}
