<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // ... (Métodos register y register)

    public function boot(): void
    {
        $migrationsPath = database_path('migrations');

        // 1. Obtiene TODOS los subdirectorios (incluyendo sub-subcarpetas)
        $subdirectories = $this->getAllSubdirectoriesOptimized($migrationsPath);

        // 2. Combina la ruta raíz con todos los subdirectorios
        $allPaths = array_merge([$migrationsPath], $subdirectories);

        // 3. Carga TODAS las rutas combinadas
        $this->loadMigrationsFrom($allPaths);
    }

    /**
     * Función recursiva que obtiene todos los subdirectorios.
     */
    function getAllSubdirectoriesOptimized($dir)
    {
        $subdirectories = [];
        $items = scandir($dir);

        foreach ($items as $item) {
            if ($item !== '.' && $item !== '..') {
                $path = $dir . DIRECTORY_SEPARATOR . $item;
                if (is_dir($path)) {
                    $subdirectories[] = $path;

                    // Llama recursivamente para buscar en sub-subcarpetas
                    $subdirectoriesToAdd = $this->getAllSubdirectoriesOptimized($path);
                    foreach ($subdirectoriesToAdd as $subdirToAdd) {
                        $subdirectories[] = $subdirToAdd;
                    }
                }
            }
        }

        return $subdirectories;
    }
}
