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
        Schema::create('declarations_warnings', function (Blueprint $table) {
            $table->id();

            // Clave foránea a la tabla 'valuations'
            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->cascadeOnDelete();

            //Valores de declaraciones

            // 1. Sí coincide / 0. No coincide
            $table->boolean('id_doc');

            // 1. Sí coincide / 0. No coincide
            $table->boolean('area_doc');

            // 1. Validado
            $table->boolean('const_state');

            // 1. Validado
            $table->boolean('occupancy');

            // 1. Coincide / 0. No coincide
            $table->boolean('urban_plan');

            // 1=Si, 2=No, 0=No verificado
            $table->unsignedTinyInteger('inah_monument');

            // 1=Si, 2=No, 0=No verificado
            $table->unsignedTinyInteger('inba_heritage');


            // Valores de advertencias
            // Checkboxes true/false

            $table->boolean('no_relevant_doc');

            $table->boolean('insufficient_comparable');

            $table->boolean('uncertain_usage');

            $table->boolean('service_impact');

            $table->text('other_notes')->nullable();


            // Valores de cibergestión
            // Valores 1 o 2

            // 1=Si, 2=No
            $table->unsignedTinyInteger('conclusion_value');

            // 1=Si, 2=No
            $table->unsignedTinyInteger('inmediate_typology');

            // 1=Si, 2=No
            $table->unsignedTinyInteger('immediate_marketing');

            // 1=Si, 2=No
            $table->unsignedTinyInteger('surface_includes_extras');


            //valor de límites adicionales

            $table->text('additional_limits')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declarations_warnings');
    }
};
