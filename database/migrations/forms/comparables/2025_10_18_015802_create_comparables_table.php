<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comparables', function (Blueprint $table) {
            $table->id();

            //Asignamos el campo tipo para identificar el tipo de comparable
            $table->enum('comparable_type', ['land', 'building']);

            // Clave foránea al avalúo (Valuation)
            $table->foreignId('valuation_id')
                ->nullable()
                ->constrained('valuations')
                ->nullOnDelete();

            // Asignamos al usuario que genera el comparable
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // --- Datos de Asignación y Control (Comunes) ---
            $table->string('comparable_key', 50);
            $table->string('comparable_folio', 50);
            $table->string('comparable_discharged_by', 100);

            // --- Datos del Inmueble (Ubicación/Dirección) (Comunes) ---
            $table->string('comparable_property', 100); // Tipo de inmueble
            $table->string('comparable_cp', 5)->nullable();
            $table->string('comparable_entity', 100)->nullable();
            $table->string('comparable_entity_name', 100)->nullable();
            $table->string('comparable_locality', 100)->nullable();
            $table->string('comparable_locality_name', 100)->nullable();
            $table->string('comparable_colony', 100)->nullable();
            $table->string('comparable_other_colony', 100)->nullable();
            $table->string('comparable_street', 255);
            $table->string('comparable_abroad_number', 50);
            $table->string('comparable_inside_number', 50)->nullable();
            $table->string('comparable_between_street', 100);
            $table->string('comparable_and_street', 100);

            // --- Datos del Informante / Fuente (Comunes) ---
            $table->string('comparable_name', 100);
            $table->string('comparable_last_name', 100);
            $table->string('comparable_phone', 15);
            $table->string('comparable_url', 500);

            // --- Datos Generales (Características y Oferta) (Comunes) ---
            $table->decimal('comparable_offers', 20, 10); // Oferta (Valor)
            $table->decimal('comparable_land_area', 20, 10); // Superficie del terreno (M2)
            $table->string('comparable_land_use', 100)->nullable();
            $table->decimal('comparable_free_area_required', 20, 10)->nullable(); // Área libre requerida (%)
            $table->decimal('comparable_built_area', 20, 10); // Superficie construida (M2)
            $table->decimal('comparable_bargaining_factor', 20, 10); // Factor de negociación
            $table->string('comparable_location_block', 100);
            $table->string('comparable_street_location', 100);
            $table->string('comparable_general_prop_area', 100);
            $table->string('comparable_urban_proximity_reference', 100);
            $table->string('comparable_source_inf_images', 255);
            $table->string('comparable_photos', 255);
            $table->string('comparable_characteristics', 255);
            $table->string('comparable_characteristics_general', 255)->nullable();
            $table->decimal('comparable_unit_value', 20, 10); // Valor unitario
            $table->integer('comparable_number_fronts')->nullable();
            $table->boolean('is_active')->nullable();





            // === Valores para el tipo de comparable_lands (TIPO 1) ===
            $table->integer('comparable_allowed_levels')->nullable();
            $table->string('comparable_services_infraestructure', 50)->nullable();
            $table->string('comparable_desc_services_infraestructure', 255)->nullable();
            $table->string('comparable_shape', 50)->nullable();
            $table->decimal('comparable_slope', 20, 10)->nullable();
            $table->string('comparable_density', 50)->nullable();
            $table->decimal('comparable_front', 20, 10)->nullable();
            $table->string('comparable_front_type', 50)->nullable();
            $table->string('comparable_description_form', 255)->nullable();
            $table->string('comparable_topography', 50)->nullable();






            // === Valores para el tipo de comparable_buildings (TIPO 2) ===
            $table->integer('comparable_number_bedrooms')->nullable();
            $table->integer('comparable_number_toilets')->nullable();
            $table->integer('comparable_number_halfbaths')->nullable();
            $table->integer('comparable_number_parkings')->nullable();
            $table->boolean('comparable_elevator')->nullable();
            $table->boolean('comparable_store')->nullable();
            $table->boolean('comparable_roof_garden')->nullable();
            $table->string('comparable_features_amenities', 255)->nullable();
            $table->string('comparable_floor_level', 100)->nullable();
            $table->string('comparable_quality', 100)->nullable();
            $table->string('comparable_conservation', 100)->nullable();
            $table->integer('comparable_levels')->nullable();
            $table->decimal('comparable_seleable_area', 20, 10)->nullable();
            $table->string('comparable_clasification')->nullable();
            $table->integer('comparable_age')->nullable();
            $table->integer('comparable_vut')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comparables');
    }
};
