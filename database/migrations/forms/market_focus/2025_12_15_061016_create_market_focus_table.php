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
        Schema::create('market_focus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('valuation_id')->constrained('valuations')->onDelete('cascade');
            $table->decimal('surplus_percentage', 5, 2)->default(100.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_focus_models');
    }
};
