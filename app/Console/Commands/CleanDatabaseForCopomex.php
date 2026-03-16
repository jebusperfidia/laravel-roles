<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CleanDatabaseForCopomex extends Command
{
    // El nombre del comando que escribirás en la terminal
    protected $signature = 'db:clean-copomex';

    protected $description = 'Borra las columnas redundantes con sufijo _name de la tabla comparables';

    public function handle()
    {
        $this->info('Iniciando limpieza de columnas _name en la base de datos...');

        // Limpieza en la tabla comparables
        if (Schema::hasTable('comparables')) {
            Schema::table('comparables', function (Blueprint $table) {
                if (Schema::hasColumn('comparables', 'comparable_entity_name')) {
                    $table->dropColumn('comparable_entity_name');
                    $this->warn('Columna comparable_entity_name eliminada.');
                }

                if (Schema::hasColumn('comparables', 'comparable_locality_name')) {
                    $table->dropColumn('comparable_locality_name');
                    $this->warn('Columna comparable_locality_name eliminada.');
                }
            });
            $this->info('Tabla comparables homologada con la estructura de valuations.');
        } else {
            $this->error('La tabla comparables no existe en esta base de datos.');
        }

        $this->info('¡Proceso terminado! Ya puedes generar tu respaldo de datos en DBeaver.');
    }
}
