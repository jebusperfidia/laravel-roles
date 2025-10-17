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
        Schema::create('finishings_1', function (Blueprint $table) {
            $table->id();

            $table->foreignId('construction_elements_id')
                ->constrained('construction_elements')
                ->cascadeOnDelete();

            // Campos Numéricos (Requeridos)
            $table->tinyInteger('bedrooms_number');
            $table->tinyInteger('bathrooms_number');
            $table->tinyInteger('half_bathrooms_number');
            $table->tinyInteger('copa_number');
            $table->tinyInteger('unpa_number');

            // Acabados (Textos Descriptivos - Requeridos)
            $table->text('hall_flats');
            $table->text('hall_walls');
            $table->text('hall_ceilings');

            $table->text('stdr_flats');
            $table->text('stdr_walls');
            $table->text('stdr_ceilings');

            $table->text('kitchen_flats');
            $table->text('kitchen_walls');
            $table->text('kitchen_ceilings');

            $table->text('bedrooms_flats')->nullable();
            $table->text('bedrooms_walls')->nullable();
            $table->text('bedrooms_ceilings')->nullable();

            $table->text('bathrooms_flats')->nullable();
            $table->text('bathrooms_walls')->nullable();
            $table->text('bathrooms_ceilings')->nullable();

            $table->text('half_bathrooms_flats')->nullable();
            $table->text('half_bathrooms_walls')->nullable();
            $table->text('half_bathrooms_ceilings')->nullable();

            $table->text('utyr_flats')->nullable();
            $table->text('utyr_walls')->nullable();
            $table->text('utyr_ceilings')->nullable();

            $table->text('stairs_flats')->nullable();
            $table->text('stairs_walls')->nullable();
            $table->text('stairs_ceilings')->nullable();

            $table->text('copa_flats')->nullable();
            $table->text('copa_walls')->nullable();
            $table->text('copa_ceilings')->nullable();

            $table->text('unpa_flats')->nullable();
            $table->text('unpa_walls')->nullable();
            $table->text('unpa_ceilings')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finishings_1');
    }
};
