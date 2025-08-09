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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            //LLave foranea de la tabla avaluos
            $table->foreignId('valuation_id')
                //Tabla de referencia
                ->constrained('valuations')
                //Si se elimina el avaluo, se eliminan las asignaciones
                ->cacscadeOnDelete();
            //Llave forenea de la tabla usuarios, para asignar al perito o appraiser
            $table->foreignId('appraiser_id')
                //Tabla de referencia
                ->constrained('users')
                //Si se elimina el usuario perito, se eliminan sus asignaciones
                ->cacscadeOnDelete();
            //Llave foranea de la tabla usuarios, para asignar al operador o operator
            $table->foreignId('operator_id')
                //Tabla de referencia
                ->constrained('users')
                //Si se elimina el usuario operador, se eliminan sus asignaciones
                ->cacscadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
