<?php
// Define la ruta a la carpeta de almacenamiento de Laravel
$storagePath = __DIR__ . '/../storage/framework/views';

function cleanDirectory($dir) {
    if (!is_dir($dir)) return;
    $files = glob($dir . '/*'); 
    foreach($files as $file) {
        if(is_file($file)) unlink($file); 
    }
}

// Limpiar vistas compiladas
cleanDirectory(__DIR__ . '/../storage/framework/views');
// Limpiar cache de datos
cleanDirectory(__DIR__ . '/../storage/framework/cache/data');

echo "Caché de archivos y vistas eliminada con éxito.";