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
        Schema::create('land_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('valuation_id')
                ->constrained('valuations')
                ->cascadeOnDelete();

            //FUENTE DE INFORMACIÓN LEGAL

            $table->string('source_legal_information', 35)->nullable();


            $table->string('notary_office_deed',100)->nullable();
            $table->string('deed_deed',100)->nullable();
            $table->string('volume_deed',100)->nullable();
            $table->date('date_deed')->nullable();
            $table->string('notary_deed',100)->nullable();
            $table->string('judicial_distric_deed',100)->nullable();


            $table->string('file_judgment',100)->nullable();
            $table->date('date_judgment')->nullable();
            $table->string('court_judgment',100)->nullable();
            $table->string('municipality_judgment',100)->nullable();


            $table->date('date_priv_cont')->nullable();
            $table->string('name_priv_cont_acq',100)->nullable();
            $table->string('first_name_priv_cont_acq',100)->nullable();
            $table->string('second_name_priv_cont_acq',100)->nullable();
            $table->string('name_priv_cont_alt',100)->nullable();
            $table->string('first_name_priv_cont_alt',100)->nullable();
            $table->string('second_name_priv_cont_alt',100)->nullable();


            $table->string('folio_aon',100)->nullable();
            $table->date('date_aon')->nullable();
            $table->string('municipality_aon',100)->nullable();


            $table->string('record_prop_reg',100)->nullable();
            $table->date('date_prop_reg')->nullable();
            $table->string('instrument_prop_reg',100)->nullable();
            $table->string('place_prop_reg',100)->nullable();


            $table->string('especify_asli',100)->nullable();
            $table->date('date_asli')->nullable();
            $table->string('emitted_by_asli',100)->nullable();
            $table->string('folio_asli',100)->nullable();



            //CALLES TRANSVERSALES, LIMÍTROFES Y ORIENTACIÓN
            $table->string('street_with_front',100)->nullable();
            $table->string('cross_street_1',100)->nullable();
            $table->string('cross_street_orientation_1',100)->nullable();
            $table->string('cross_street_2',100)->nullable();
            $table->string('cross_street_orientation_2',100)->nullable();
            $table->string('border_street_1',100)->nullable();
            $table->string('border_street_orientation_1',100)->nullable();
            $table->string('border_street_2',100)->nullable();
            $table->string('border_street_orientation_2',100)->nullable();

            /*
            1. Cabecera de manzana
            2. Lote con dos frentes no contiguos
            3. Lote en esquina
            4. Lote interior
            5. Lote intermedio
            6. Manzana completa */
            $table->integer('location')->nullable();

            $table->string('configuration',15)->nullable();
            $table->string('topography',30)->nullable();


            /*
            1. Calle inferior a la moda
            2. Calle moda
            3. Calle superior a la moda
            4. Calle con frente a parque, plaza o jardin
            */
            $table->integer('type_of_road')->nullable();

            $table->text('panoramic_features')->nullable();
            $table->string('easement_restrictions',200)->nullable();
            $table->string('easement_restrictions_others',200)->nullable();




            //SUPERFICIE DEL TERRENO

            $table->boolean('use_excess_calculation')->default(false);
            $table->decimal('surface_private_lot', 10, 2)->default((0));
            $table->decimal('surface_private_lot_type', 10, 2)->default((0));
            $table->decimal('undivided_only_condominium', 10, 2)->default((0));
            $table->decimal('undivided_surface_land', 10, 2)->default((0));
            $table->decimal('surplus_land_area', 10, 2)->default((0));




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_details');
    }
};
