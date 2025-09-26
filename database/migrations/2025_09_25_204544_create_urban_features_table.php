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
        Schema::create('urban_features', function (Blueprint $table) {
            $table->id();
            // Clave foránea a la tabla 'valuations'
            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->cascadeOnDelete();


            // Características urbanas
            $table->string('zone_classification');
            $table->text('predominant_buildings');
            $table->string('zone_building_levels');
            $table->string('building_usage');
            $table->string('zone_saturation_index');
            $table->string('population_density');
            $table->string('housing_density');
            $table->string('zone_socioeconomic_level');
            $table->text('access_routes_importance');
            $table->string('environmental_pollution');

            // Infraestructura
            //$table->boolean('allServices')->default(false);
            $table->tinyInteger('water_distribution')->nullable();
            $table->tinyInteger('wastewater_collection')->nullable();
            $table->tinyInteger('street_storm_drainage')->nullable();
            $table->tinyInteger('zone_storm_drainage')->nullable();
            $table->tinyInteger('mixed_drainage_system')->nullable();
            $table->tinyInteger('other_water_disposal')->nullable();


            // Servicios
            $table->tinyInteger('electric_supply');
            $table->tinyInteger('electrical_connection'); // 1=Sí, 2=No
            $table->tinyInteger('public_lighting'); // 1=Sin, 2=Aéreo, 3=Subterráneo
            $table->tinyInteger('natural_gas'); // 1=Con acometida, 2=Zona, 3=No existe
            $table->tinyInteger('security'); // 1=Municipal, 2=Privada, 3=No existe
            $table->tinyInteger('garbage_collection'); // 1=Sí, 2=No
            $table->string('garbage_collection_frecuency')->nullable(); // Solo si garbage_collection = 1
            $table->tinyInteger('telephone_service'); // 1=Aéreo, 2=Subterráneo, 3=No existe
            $table->tinyInteger('telephone_connection'); // 1=Sí, 2=No
            $table->tinyInteger('road_signage'); // 1=Sí, 2=No
            $table->tinyInteger('street_naming'); // 1=Sí, 2=No

            // Vialidades
            $table->string('roadways'); // Ej: "1. Terracería"
            $table->string('roadways_others')->nullable(); // Si roadways = 6
            $table->decimal('roadways_mts', 6, 2)->nullable();

            // Banquetas
            $table->string('sidewalks'); // Ej: "1. Concreto"
            $table->string('sidewalks_others')->nullable(); // Si sidewalks = 4
            $table->decimal('sidewalks_mts', 6, 2)->nullable();

            // Guarniciones
            $table->string('curbs'); // Ej: "1. Concreto"
            $table->string('curbs_others')->nullable(); // Si curbs = 2
            $table->decimal('curbs_mts', 6, 2)->nullable();

            // Uso del suelo
            $table->string('land_use');
            $table->text('description_source_land');
            $table->integer('mandatory_free_area');
            $table->integer('allowed_levels');
            $table->decimal('land_coefficient_area', 5, 2)->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urban_features');
    }
};
