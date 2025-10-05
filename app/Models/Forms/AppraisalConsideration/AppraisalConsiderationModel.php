<?php

namespace App\Models\Forms\AppraisalConsideration;

use App\Models\Valuations\Valuation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalConsiderationModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'appraisal_considerations';

    protected $fillable = [
        'valuation_id',

            'additional_considerations',
            'technical_memory',
            'technical_report_breakdown_information',
            'technical_report_other_support',
            'technical_report_description_calculations',
            'land_calculation',
            'cost_approach',
            'income_approach',
            'due_to_1',
            'due_to_2',
            'comparative_approach_land',
            'comparative_sales_approach',
            'apply_fic'

    ];


    /**
     * Define la relación con el avalúo (Valuation).
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }


}
