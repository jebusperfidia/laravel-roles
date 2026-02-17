<?php

namespace App\Models\Valuations;

use App\Models\Forms\SpecialInstallation\SpecialInstallationModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Forms\Comparable\ComparableModel;

use App\Models\Forms\Comparable\ValuationLandComparableModel;
use App\Models\Forms\Comparable\ValuationBuildingComparableModel;
use App\Models\Forms\Homologation\HomologationValuationFactorModel;
use App\Models\Forms\Homologation\HomologationLandAttributeModel;
use App\Models\Forms\Homologation\HomologationBuildingAttributeModel;
use App\Models\Forms\ConstructionElements\ConstructionElementModel;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Valuation extends Model
{
    protected $fillable = [
        'date',
        'type',
        'folio',
        'property_type',
        'status',

        // Datos del propietario
        'calculation_type',
        'pre_valuation',
        'owner_type_person',
        'owner_rfc',
        'owner_curp',
        'owner_name',
        'owner_first_name',
        'owner_second_name',
        'owner_company_name',
        'owner_cp',
        'owner_entity',
        'owner_locality',
        'owner_colony',
        'owner_other_colony',
        'owner_street',
        'owner_abroad_number',
        'owner_inside_number',

        // Datos del solicitante
        'applic_type_person',
        'applic_rfc',
        'applic_curp',
        'applic_name',
        'applic_first_name',
        'applic_second_name',
        'applic_nss',
        'applic_cp',
        'applic_entity',
        'applic_locality',
        'applic_colony',
        'applic_other_colony',
        'applic_street',
        'applic_abroad_number',
        'applic_inside_number',
        'applic_phone',

        // Datos del inmueble
        'property_cp',
        'property_entity',
        'property_locality',
        'property_city',
        'property_colony',
        'property_other_colony',
        'property_street',
        'property_abroad_number',
        'property_inside_number',
        'property_block',
        'property_super_block',
        'property_lot',
        'property_building',
        'property_departament',
        'property_access',
        'property_level',
        'property_condominium',
        'property_street_between',
        'property_and_street',
        'property_housing_complex',
        'property_tax',
        'property_water_account',
        'property_type_sigapred',
        'property_land_use',
        'property_type_housing',
        'property_constructor',
        'property_rfc_constructor',
        'property_additional_data',

        // Datos importantes
        'purpose',
        'purpose_other',
        'purpose_sigapred',
        'objective',
        'owner_ship_regime',
    ];

    //protected $casts = [
    // Convierte automáticamente el campo 'date' en una instancia de Carbon (fecha manejable en PHP)
    // Esto permite usar métodos como ->format(), ->diff(), etc.
    // Opcional, pero muy recomendable si trabajas con fechas
    //'date' => 'date',

    // Convierte el campo booleano 'pre_valuation' en true/false en PHP
    // Laravel lo interpreta como booleano aunque en la base de datos sea TINYINT(1)
    // Opcional, pero útil para evitar que se trate como entero
    //'pre_valuation' => 'boolean',

    // Convierte el campo 'status' en entero
    // Útil si necesitas hacer comparaciones numéricas (ej. status === 2)
    // Opcional si ya lo tratas como número, pero recomendable para consistencia
    //'status' => 'integer',
    //];


    protected $casts = [
        'pre_valuation' => 'boolean', // <--- AÑADE ESTA LÍNEA
    ];


    protected $appends = ['full_address'];


    public function specialInstallations()
    {
        // Retorna todos los elementos ligados a este avalúo
        return $this->hasMany(SpecialInstallationModel::class);
    }


    //Tablas privativas
    public function privateInstallations()
    {
        return $this->specialInstallations()
            ->where('classification_type', 'private')
            ->where('element_type', 'installations');
    }


    public function privateAccessories()
    {
        return $this->specialInstallations()
            ->where('classification_type', 'private')
            ->where('element_type', 'accessories');
    }


    public function privateWorks()
    {
        return $this->specialInstallations()
            ->where('classification_type', 'private')
            ->where('element_type', 'works');
    }

    //Tablas comunes
    public function commonInstallations()
    {
        return $this->specialInstallations()
            ->where('classification_type', 'common')
            ->where('element_type', 'installations');
    }


    public function commonAccessories()
    {
        return $this->specialInstallations()
            ->where('classification_type', 'common')
            ->where('element_type', 'accessories');
    }


    public function commonWorks()
    {
        return $this->specialInstallations()
            ->where('classification_type', 'common')
            ->where('element_type', 'works');
    }

    /*     public function location()
    {
        // Ahora apunta al nuevo nombre de la clase
        return $this->hasOne(PropertyLocationModel::class);
    } */

    public function homologationValuationFactors()
    {
        // ¡Apunta a tu nuevo modelo!
        return $this->hasMany(HomologationValuationFactorModel::class, 'valuation_id');
    }

    /**
     * Relación 1:N con la tabla pivote (valuation_comparables).
     *
     * Devuelve los registros de la tabla intermedia "valuation_comparables"
     * que vinculan este avalúo con sus comparables asignados.
     *
     * Ejemplo:
     * $valuation->assignedComparables → colección de registros pivote
     */

    /**
     * NUEVA RELACIÓN: Comparables de Terreno (LAND)
     * Apunta a la nueva tabla pivote 'valuation_land_comparables'.
     */
    public function landComparables()
    {
        return $this->belongsToMany(
            ComparableModel::class,
            'valuation_land_comparables', // <-- Nueva tabla
            'valuation_id',
            'comparable_id'
        )
            ->withPivot(['position', 'is_active', 'created_by'])
            ->withTimestamps()
            ->orderBy('pivot_position');
    }

    /**
     * NUEVA RELACIÓN: Comparables de Construcción (BUILDING)
     * Apunta a la nueva tabla pivote 'valuation_building_comparables'.
     */
    public function buildingComparables()
    {
        return $this->belongsToMany(
            ComparableModel::class,
            'valuation_building_comparables', // <-- Nueva tabla
            'valuation_id',
            'comparable_id'
        )
            ->withPivot(['id','position', 'is_active', 'created_by'])
            //->withPivot(['position', 'is_active', 'created_by'])
            ->withTimestamps()
            ->orderBy('pivot_position');
    }

    /**
     * Relación N:M con los comparables.
     *
     * Devuelve directamente los modelos de comparables asociados al avalúo
     * usando la tabla pivote "valuation_comparables".
     *
     * Se agregan los campos del pivote (position, is_active, created_by)
     * y se ordena por el campo "position" para respetar el orden asignado.
     *
     * Ejemplo:
     * $valuation->comparables → colección de modelos ComparableModel
     */

    /**
     * Relación DIRECTA a las "HojasDeConexion" de Land
     */
    public function landComparablePivots()
    {
        return $this->hasMany(ValuationLandComparableModel::class, 'valuation_id');
    }

    /**
     * Relación DIRECTA a las "HojasDeConexion" de Building
     */
    public function buildingComparablePivots()
    {
        return $this->hasMany(ValuationBuildingComparableModel::class, 'valuation_id');
    }


    public function homologationLandAttributes()
    {
        return $this->hasOne(HomologationLandAttributeModel::class, 'valuation_id');
    }

    public function homologationBuildingAttributes()
    {
        // Asegúrate de que este modelo exista en esta ruta
        return $this->hasOne(HomologationBuildingAttributeModel::class, 'valuation_id');
    }



    /**
     * Accessor para obtener la dirección completa unificada.
     */
    protected function fullAddress(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Si no hay calle, asumimos que no han capturado la dirección
                if (empty($this->property_street)) {
                    return null;
                }

                $address = $this->property_street;

                if ($this->property_abroad_number) {
                    $address .= " EXT: " . $this->property_abroad_number;
                }

                if ($this->property_inside_number) {
                    $address .= " INT: " . $this->property_inside_number;
                }

                if ($this->property_block) {
                    $address .= " MZ: " . $this->property_block;
                }

                if ($this->property_lot) {
                    $address .= " LTE: " . $this->property_lot;
                }

                if ($this->property_condominium) {
                    $address .= " COND: " . $this->property_condominium;
                }

                // --- LÓGICA DE COLONIA (FIX) ---
                $colony = ($this->property_colony === 'no-listada')
                    ? $this->property_other_colony
                    : $this->property_colony;

                if ($colony) {
                    $address .= " COL: " . $colony;
                }

                if ($this->property_cp) {
                    $address .= " CP: " . $this->property_cp;
                }

                // OJO: property_locality y property_entity suelen ser IDs en tu BD.
                // Si quieres que aquí salgan los nombres (ej. BENITO JUÁREZ),
                // necesitarías la lógica del DipomexService, pero para el modelo
                // lo dejamos así para no romper nada.
                if ($this->property_locality) {
                    $address .= " MUN: " . $this->property_locality;
                }

                if ($this->property_entity) {
                    $address .= ", " . $this->property_entity . ".";
                }

                // Devolvemos todo en mayúsculas y limpio de espacios dobles
                return mb_strtoupper(preg_replace('/\s+/', ' ', trim($address)));
            }
        );
    }


    /**
     * Relación con los elementos de construcción
     */
    public function constructionElement()
    {
        // Usamos hasOne porque un avalúo tiene un conjunto de elementos
        // El segundo parámetro 'valuation_id' es la FK en la tabla construction_elements
        return $this->hasOne(ConstructionElementModel::class, 'valuation_id');
    }

}
