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
        Schema::create('land_surfaces', function (Blueprint $table) {
            $table->id();


            $table->foreignId('land_detail_id')
                ->constrained('land_details')
                ->cascadeOnDelete();

            $table->decimal('surface', 9,4);
           /*  $table->string('value_area'); */


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_surfaces');
    }
};
