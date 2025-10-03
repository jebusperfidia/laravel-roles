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
        Schema::create('hydraulics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('construction_elements_id')
                ->constrained('construction_elements')
                ->cascadeOnDelete();


            // Campos Hidráulicos y Sanitarios (Todos Requeridos, tipo TEXT)
            $table->text('bathroom_furniture');

            $table->string('hidden_apparent_hydraulic_branches', 15);
            $table->text('hydraulic_branches');

            $table->string('hidden_apparent_sanitary_branches', 15);
            $table->text('sanitary_branches');

            $table->string('hidden_apparent_electrics', 15);
            $table->text('electrics');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hydraulics');
    }
};
