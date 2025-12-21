<?php

// database/migrations/xxxx_xx_xx_create_valuation_photos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valuation_photos', function (Blueprint $table) {
            $table->id();
            // Relación con tu tabla principal
            $table->foreignId('valuation_id')->constrained()->cascadeOnDelete();

            $table->string('file_path');
            $table->string('file_name')->nullable();

            // Metadatos editables
            $table->string('category')->nullable(); // Fachada, Interior, etc.
            $table->text('description')->nullable();
            $table->boolean('is_printable')->default(true);

            // Lógica visual
            $table->integer('rotation_angle')->default(0); // 0, 90, 180, 270
            $table->integer('sort_order')->default(0); // Para el drag & drop

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valuation_photos');
    }
};
