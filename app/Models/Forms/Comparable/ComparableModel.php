<?php

namespace App\Models\Forms\Comparable;

use App\Models\Valuations\Valuation;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Importamos los modelos de pivote específicos
use App\Models\Forms\Comparable\ValuationLandComparable;
use App\Models\Forms\Comparable\ValuationBuildingComparable;
use Illuminate\Support\Carbon; // *** 1. AÑADIDO PARA MANEJAR FECHAS ***

class ComparableModel extends Model
{
    protected $table = 'comparables';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Incluye todos los campos de la migración.
     */
    protected $fillable = [
        'valuation_id',
        'comparable_type', // AÑADIDO: Tipo 'land' o 'building'
        'comparable_key',
        'comparable_folio',
        'comparable_discharged_by',
        'comparable_property',
        'comparable_entity',
        'comparable_entity_name',
        'comparable_locality',
        'comparable_locality_name',
        'comparable_colony',
        'comparable_other_colony',
        'comparable_street',
        'comparable_between_street',
        'comparable_and_street',
        'comparable_cp',
        'comparable_name',
        'comparable_last_name',
        'comparable_phone',
        'comparable_url',
        'comparable_land_use',
        'comparable_desc_services_infraestructure',
        'comparable_services_infraestructure',
        'comparable_shape',
        'comparable_density',
        'comparable_front',
        'comparable_front_type',
        'comparable_description_form',
        'comparable_topography',
        'comparable_characteristics',
        'comparable_characteristics_general',
        'comparable_location_block',
        'comparable_street_location',
        'comparable_general_prop_area',
        'comparable_urban_proximity_reference',
        'comparable_source_inf_images',
        'comparable_photos',
        'comparable_abroad_number',
        'comparable_inside_number',
        'comparable_allowed_levels',
        'comparable_number_fronts',
        'comparable_free_area_required',
        'comparable_slope',
        'comparable_offers',
        'comparable_land_area',
        'comparable_built_area',
        'comparable_unit_value',
        'comparable_bargaining_factor',
        'is_active',
        'created_by',

        // --- CAMPOS DE BUILDINGS ---
        'comparable_number_bedrooms',
        'comparable_number_toilets',
        'comparable_number_halfbaths',
        'comparable_number_parkings',
        'comparable_elevator',
        'comparable_store',
        'comparable_roof_garden',
        'comparable_features_amenities',
        'comparable_floor_level',
        'comparable_quality',
        'comparable_conservation',
        'comparable_levels',
        'comparable_seleable_area',
        'comparable_clasification',
        'comparable_age',
        'comparable_vut',
    ];

    /**
     * The attributes that should be cast.
     * CRÍTICO: Se usan 'decimal:10' para coincidir con la precisión de la migración.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'comparable_type' => 'string',

        // Valores decimales/flotantes (todos a decimal:10)
        'comparable_free_area_required' => 'decimal:10',
        'comparable_slope' => 'decimal:10',
        'comparable_offers' => 'decimal:10',
        'comparable_land_area' => 'decimal:10',
        'comparable_built_area' => 'decimal:10',
        'comparable_unit_value' => 'decimal:10',
        'comparable_bargaining_factor' => 'decimal:10',
        'comparable_front' => 'decimal:10',
        'comparable_seleable_area' => 'decimal:10',

        // Valores enteros
        'comparable_allowed_levels' => 'integer',
        'comparable_number_fronts' => 'integer',
        'comparable_number_bedrooms' => 'integer',
        'comparable_number_toilets' => 'integer',
        'comparable_number_halfbaths' => 'integer',
        'comparable_number_parkings' => 'integer',
        'comparable_levels' => 'integer',
        'comparable_age' => 'integer',
        'comparable_vut' => 'integer',

        // Valores booleanos
        'comparable_elevator' => 'boolean',
        'comparable_store' => 'boolean',
        'comparable_roof_garden' => 'boolean',
    ];



    /**
     * *** 2. AÑADIDO: ATRIBUTOS VIRTUALES ***
     * Lista de atributos virtuales (accessors) que se añadirán
     * automáticamente al modelo (ej. para Livewire).
     */
    protected $appends = ['is_expired', 'vigencia_hasta', 'dias_para_vencer'];



    /**
     * Obtiene el avalúo al que pertenece este comparable.
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class);
    }

    /**
     * Obtiene el usuario que creó este comparable.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // --- RELACIONES PIVOTE N:M PARA CADA TIPO ---

    /**
     * Relación N:M con los avalúos (Tipo LAND, tabla valuation_land_comparables).
     */
    public function landValuations()
    {
        return $this->belongsToMany(
            Valuation::class,
            'valuation_land_comparables', // Tabla pivote para terrenos
            'comparable_id',
            'valuation_id'
        )
            ->withPivot(['position', 'is_active', 'created_by'])
            ->withTimestamps();
    }

    /**
     * Relación N:M con los avalúos (Tipo BUILDING, tabla valuation_building_comparables).
     */
    public function buildingValuations()
    {
        return $this->belongsToMany(
            Valuation::class,
            'valuation_building_comparables', // Tabla pivote para construcciones
            'comparable_id',
            'valuation_id'
        )
            ->withPivot(['position', 'is_active', 'created_by'])
            ->withTimestamps();
    }


    // --- *** 3. AÑADIDO: ACCESSORS DE VIGENCIA *** ---

    /**
     * Accessor para [is_expired]
     * Campo virtual que calcula si el comparable tiene más de 6 meses.
     *
     * @return bool
     */
    public function getIsExpiredAttribute(): bool
    {
        // lt() = "Less Than" (menor que)
        // Si la fecha de creación es anterior a "hoy - 6 meses", está expirado.
        return $this->created_at->lt(Carbon::now()->subMonths(6));
    }

    /**
     * Accessor para [vigencia_hasta]
     * Campo virtual que calcula la fecha exacta de expiración (6 meses).
     *
     * @return string
     */
    public function getVigenciaHastaAttribute(): string
    {
        // Devuelve la fecha de creación + 6 meses, formateada.
        return $this->created_at->addMonths(6)->format('d/m/Y');
    }

    public function getDiasParaVencerAttribute()
    {
        // Tu lógica exacta:
        $fechaBase = $this->comparable_date
            ? \Carbon\Carbon::parse($this->comparable_date)
            : $this->created_at;

        if (!$fechaBase) return 0;

        $diasTranscurridos = (int) $fechaBase->diffInDays(now());

        // Retorna positivo si falta tiempo, negativo si ya se pasó
        return 180 - $diasTranscurridos;
    }
}
