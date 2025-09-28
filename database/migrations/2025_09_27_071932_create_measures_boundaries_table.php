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
        Schema::create('measures_boundaries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('land_detail_id')
                ->constrained('land_details')
                ->cascadeOnDelete();

            // Archivo relacionado
            $table->string('file_path');          // Ruta del archivo en storage (obligatoria)
            $table->string('original_name');      // Nombre original del archivo subido
            $table->string('file_type')->nullable();  // Ej: image, pdf, etc.
            //$table->string('title')->nullable();  // Nombre descriptivo o título
            //$table->text('description')->nullable(); // Descripción opcional


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measures_boundaries');
    }
};
