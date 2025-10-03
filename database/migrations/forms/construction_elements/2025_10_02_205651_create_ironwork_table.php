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
        Schema::create('ironwork', function (Blueprint $table) {
            $table->id();

            $table->foreignId('construction_elements_id')
                ->constrained('construction_elements')
                ->cascadeOnDelete();

            // Campos de Herrería (Todos Requeridos, tipo TEXT)
            $table->text('service_door');
            $table->text('windows');
            $table->text('others');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ironwork');
    }
};
