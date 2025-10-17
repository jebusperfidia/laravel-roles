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
        Schema::create('finishings_2', function (Blueprint $table) {
            $table->id();

            $table->foreignId('construction_elements_id')
                ->constrained('construction_elements')
                ->cascadeOnDelete();

            // Campos de Acabados 2 (Todos Requeridos, tipo TEXT)
            /* $table->text('cement_plaster');
            $table->text('ceilings'); */
            $table->text('furred_walls');
            /* $table->text('stairs'); */
            /* $table->text('flats'); */
            $table->text('plinths');
            $table->text('paint');
            $table->text('special_coating');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finishings_2');
    }
};
