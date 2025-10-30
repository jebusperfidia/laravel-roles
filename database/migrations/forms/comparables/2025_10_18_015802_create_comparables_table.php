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

            // --- Datos de Asignación y Control ---
            $table->string('comparable_key', 50);
            $table->string('comparable_folio', 50);
            $table->string('comparable_discharged_by', 100);

            // --- Datos del Inmueble (Ubicación/Dirección) ---
            $table->string('comparable_property', 100); // Tipo de inmueble
            $table->string('comparable_cp', 5)->nullable();
            $table->string('comparable_entity', 100)->nullable();
            $table->string('comparable_entity_name', 100)->nullable();
            $table->string('comparable_locality', 100)->nullable();
            $table->string('comparable_locality_name', 100)->nullable();
            $table->string('comparable_colony', 100)->nullable();
            $table->string('comparable_other_colony', 100)->nullable();
            $table->string('comparable_street', 255);
            $table->string('comparable_abroad_number', 50); // CORREGIDO a string
            $table->string('comparable_inside_number', 50)->nullable(); // CORREGIDO a string
            $table->string('comparable_between_street', 100);
            $table->string('comparable_and_street', 100);

            // --- Geolocalización ---
            //$table->decimal('comparable_latitude', 10, 8)->nullable();
            //$table->decimal('comparable_longitude', 11, 8)->nullable();

            // --- Datos del Informante / Fuente ---
            $table->string('comparable_name', 100);
            $table->string('comparable_last_name', 100);
            $table->string('comparable_phone', 15);
            $table->string('comparable_url', 500);
            $table->string('comparable_source_inf_images', 255);
            $table->string('comparable_photos', 255); // Campo para la URL o ruta del archivo de la foto

            // --- Datos Generales (Características del Terreno/Oferta) ---
            $table->string('comparable_land_use', 100);
            $table->decimal('comparable_free_area_required', 20, 10); // Área libre requerida (%)
            // CAMBIO: antes era float, ahora decimal(20,10) para mayor precisión en porcentajes hasta 10 decimales.

            $table->integer('comparable_allowed_levels');

            $table->string('comparable_services_infraestructure', 50)->nullable();
            $table->string('comparable_desc_services_infraestructure', 255);
            $table->string('comparable_shape', 50); // Forma

            $table->decimal('comparable_slope', 20, 10); // Pendiente (%)
            // CAMBIO: antes era float, reemplazado por decimal(20,10) para mantener precisión en valores porcentuales.

            $table->string('comparable_density', 50);

            $table->decimal('comparable_front', 20, 10); // Frente (ML)
            // CAMBIO: antes era float, se usa decimal(20,10) por precisión en medidas lineales.

            $table->string('comparable_front_type', 50)->nullable();
            $table->string('comparable_description_form', 255)->nullable();
            $table->string('comparable_topography', 50);
            $table->string('comparable_characteristics', 255);
            $table->string('comparable_characteristics_general', 255)->nullable();

            $table->decimal('comparable_offers', 20, 10); // Oferta (Valor)
            // CAMBIO: antes era float, se usa decimal(20,10) por precisión monetaria y evitar errores de redondeo binario.

            $table->decimal('comparable_land_area', 20, 10); // Superficie del terreno (M2)
            // CAMBIO: antes era float, ahora decimal(20,10) para permitir hasta 10 decimales exactos.

            $table->decimal('comparable_built_area', 20, 10); // Superficie construida (M2)
            // CAMBIO: antes era float, mismo criterio de precisión en medidas.

            $table->decimal('comparable_unit_value', 20, 10); // Valor unitario
            // CAMBIO: antes era float, ahora decimal(20,10) por tratarse de valores monetarios.

            $table->decimal('comparable_bargaining_factor', 20, 10); // Factor de negociación (0.8 a 1)
            // CAMBIO: antes era float, ahora decimal(20,10) para mayor precisión en factores.

            $table->integer('comparable_number_fronts')->nullable();
            // CAMBIO: se mantiene integer, ya que no requiere precisión decimal.

            // --- Ubicación y Referencias (Clase de zona) ---
            $table->string('comparable_location_block', 100); // Ubicación en la manzana
            $table->string('comparable_street_location', 100); // Ubicación en la calle
            $table->string('comparable_general_prop_area', 100); // Clase general de los inmuebles en la zona
            $table->string('comparable_urban_proximity_reference', 100); // Referencia de proximidad urbana

            // --- Estado y Tiempos ---
            $table->boolean('is_active')->nullable(); // Mapeo de comparableActive
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
