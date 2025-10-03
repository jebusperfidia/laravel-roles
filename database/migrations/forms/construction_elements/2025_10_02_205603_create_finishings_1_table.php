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
            $table->tinyInteger('bedrooms_number')->default(0);
            $table->tinyInteger('bathrooms_number')->default(0);
            $table->tinyInteger('half_bathrooms_number')->default(0);
            $table->tinyInteger('copa_number')->default(0);
            $table->tinyInteger('unpa_number')->default(0);

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

            $table->text('bedrooms_flats');
            $table->text('bedrooms_walls');
            $table->text('bedrooms_ceilings');

            $table->text('bathrooms_flats');
            $table->text('bathrooms_walls');
            $table->text('bathrooms_ceilings');

            $table->text('half_bathrooms_flats');
            $table->text('half_bathrooms_walls');
            $table->text('half_bathrooms_ceilings');

            $table->text('utyr_flats');
            $table->text('utyr_walls');
            $table->text('utyr_ceilings');

            $table->text('stairs_flats');
            $table->text('stairs_walls');
            $table->text('stairs_ceilings');

            $table->text('copa_flats');
            $table->text('copa_walls');
            $table->text('copa_ceilings');

            $table->text('unpa_flats');
            $table->text('unpa_walls');
            $table->text('unpa_ceilings');

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
