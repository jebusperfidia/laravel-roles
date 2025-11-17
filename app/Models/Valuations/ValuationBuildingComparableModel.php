<?php

// Ruta: App\Models\Forms\Comparable\ValuationBuildingComparableModel.php
namespace App\Models\Forms\Comparable;

// ¡¡¡EL CAMBIO CRÍTICO!!! ¡Extiende de Model, NO de Pivot!
use Illuminate\Database\Eloquent\Model;
use App\Models\Forms\Homologation\HomologationComparableFactorModel; // ¡Tu modelo!
use App\Models\Valuations\Valuation; // ¡Necesitamos esta!
use App\Models\Forms\Comparable\ComparableModel; // ¡Y esta!

/**
 * Modelo para la "HojaDeConexion" (tabla pivote) 'valuation_building_comparables'.
 * ¡¡ESTE ES UN MODELO COMPLETO!!
 */
class ValuationBuildingComparableModel extends Model // <-- ¡NO ES PIVOT!
{
    protected $table = 'valuation_building_comparables';

    // ¡Campos basados 100% en tu migración!
    protected $fillable = [
        'valuation_id',
        'comparable_id',
        'position',
        'is_active',
        'created_by', // ¡Tu controlador lo usa en create!
    ];

    /**
     * Relación: Una "HojaDeConexion" TIENE MUCHOS factores de homologación.
     * ¡ESTA ES NUESTRA NUEVA LÓGICA!
     */
    public function factors()
    {
        // ¡Apunta a tu modelo con tu FK!
        return $this->hasMany(HomologationComparableFactorModel::class, 'valuation_building_comparable_id');
    }

    // --- ¡Relaciones que tu controlador necesita! ---

    /**
     * Pertenece a un Avalúo
     */
    public function valuation()
    {
        return $this->belongsTo(Valuation::class, 'valuation_id');
    }

    /**
     * Pertenece a un Comparable
     */
    public function comparable()
    {
        return $this->belongsTo(ComparableModel::class, 'comparable_id');
    }
}
