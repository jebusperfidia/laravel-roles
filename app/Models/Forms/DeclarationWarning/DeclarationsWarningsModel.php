<?php

namespace App\Models\Forms\DeclarationWarning;

use App\Models\Valuations\Valuation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclarationsWarningsModel extends Model
{
    /* use HasFactory; */

    // Define la tabla si no sigue la convención de pluralización (Laravel lo infiere bien en este caso)
    protected $table = 'declarations_warnings';

    /**
     * Los atributos que se pueden asignar masivamente.
     * Es recomendable listar solo las columnas que el usuario puede llenar.
     * Opcionalmente, puedes usar $guarded = [] para permitir la asignación masiva de todos los campos.
     * * NOTA: Debes llenar esta sección con los nombres de las columnas.
     */
    protected $fillable = [
        'valuation_id',

        // Declaraciones
        'id_doc',
        'area_doc',
        'const_state',
        'occupancy',
        'urban_plan',
        'inah_monument',
        'inba_heritage',

        // Advertencias
        'no_relevant_doc',
        'insufficient_comparable',
        'uncertain_usage',
        'service_impact',
        'other_notes',

        // Cibergestión
        'conclusion_value',
        'inmediate_typology',
        'immediate_marketing',
        'surface_includes_extras',

        // Limitaciones
        'additional_limits',
    ];

    /**
     * Los atributos que deberían ser casteados a tipos nativos.
     * Esto asegura que los 1/0 de la DB se recuperen como true/false o int en PHP.
     *
     * @var array
     */
    protected $casts = [
        /*
        // Declaraciones (mayormente booleanos)
        'id_doc' => 'boolean',           // 1 o 0 -> true o false
        'area_doc' => 'boolean',         // 1 o 0 -> true o false
        'const_state' => 'boolean',      // 1 o 0 -> true o false
        'occupancy' => 'boolean',        // 1 o 0 -> true o false
        'urban_plan' => 'boolean',       // 1 o 0 -> true o false
*/
        // Estos tienen 3 valores (0, 1, 2)
        'inah_monument' => 'integer',
        'inba_heritage' => 'integer',

        // Advertencias (checkboxes)
        'no_relevant_doc' => 'boolean',
        'insufficient_comparable' => 'boolean',
        'uncertain_usage' => 'boolean',
        'service_impact' => 'boolean',

        // Cibergestión (valores 1 o 2)
       /*  'conclusion_value' => 'integer',
        'inmediate_typology' => 'integer',
        'immediate_marketing' => 'integer',
        'surface_includes_extras' => 'integer', */
    ];

    /**
     * Define la relación con el avalúo (Valuation).
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }
}
