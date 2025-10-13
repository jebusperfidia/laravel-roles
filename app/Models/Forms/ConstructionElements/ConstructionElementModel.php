<?php

namespace App\Models\Forms\ConstructionElements;

use App\Models\Valuations\Valuation;
use App\Models\Forms\ConstructionElements\StructuralWorkModel;
use App\Models\Forms\ConstructionElements\Finishing1Model;
use App\Models\Forms\ConstructionElements\Finishing2Model;
use App\Models\Forms\ConstructionElements\FinishingOtherModel;
use App\Models\Forms\ConstructionElements\CarpentryModel;
use App\Models\Forms\ConstructionElements\IronWorkModel;
use App\Models\Forms\ConstructionElements\HydraulicModel;
use App\Models\Forms\ConstructionElements\OtherElementModel; // Usamos el nombre corregido

use Illuminate\Database\Eloquent\Model;

class ConstructionElementModel extends Model
{
    protected $table = 'construction_elements';

    protected $fillable = [
        'valuation_id',
    ];


/*
    protected $casts = [
        'valuation_id' => 'integer',
    ]; */

    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE UNO A UNO (HAS ONE)
    |--------------------------------------------------------------------------
    | Un elemento de construcción tiene UN solo registro de Obra Negra, Acabados, etc.
    */

    // Relación 1:1 con Obra Negra
    public function structuralWork()
    {
        return $this->hasOne(StructuralWorkModel::class, 'construction_elements_id');
    }

    // Relación 1:1 con Acabados 1
    public function finishing1()
    {
        return $this->hasOne(Finishing1Model::class, 'construction_elements_id');
    }

    // Relación 1:1 con Acabados 2
    public function finishing2()
    {
        return $this->hasOne(Finishing2Model::class, 'construction_elements_id');
    }

    // Relación 1:1 con Carpintería
    public function carpentry()
    {
        return $this->hasOne(CarpentryModel::class, 'construction_elements_id');
    }

    // Relación 1:1 con Herrería
    public function ironWork()
    {
        return $this->hasOne(IronWorkModel::class, 'construction_elements_id');
    }


    // Relación 1:1 con Herrería
    public function hydraulic()
    {
        return $this->hasOne(HydraulicModel::class, 'construction_elements_id');
    }


    // Relación 1:1 con Otros Elementos
    public function otherElements()
    {
        return $this->hasOne(OtherElementModel::class, 'construction_elements_id');
    }


    /*
    |--------------------------------------------------------------------------
    | RELACIÓN DE UNO A MUCHOS (HAS MANY)
    |--------------------------------------------------------------------------
    | Un elemento de construcción puede tener MÚLTIPLES elementos genéricos.
    */

    // Relación 1:N con Otros Elementos
    public function finishingOtherElements()
    {
        return $this->hasMany(FinishingOtherModel::class, 'construction_elements_id');
    }


    /*
    |--------------------------------------------------------------------------
    | RELACIÓN BELONGS TO (PERTENECE A)
    |--------------------------------------------------------------------------
    */

    /**
     * Define la relación con el avalúo (Valuation).
     */
    public function valuation()
    {
        // Un elemento de construcción pertenece a un avalúo (Relación 1:1 o 1:N vista desde aquí)
        return $this->belongsTo(Valuation::class);
    }
}
