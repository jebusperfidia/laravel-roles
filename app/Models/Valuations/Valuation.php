<?php

namespace App\Models\Valuations;

use App\Models\Forms\SpecialInstallation\SpecialInstallationModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyLocationModel;

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
}
