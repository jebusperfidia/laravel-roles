<?php
// link.php

// 1. Apuntamos a la carpeta donde están las fotos reales (fuera de public)
$target = __DIR__ . '/../storage/app/public'; 

// 2. Definimos dónde queremos el acceso directo (en la carpeta pública actual)
$shortcut = __DIR__ . '/storage';

echo "<h1>Generador de Symlink</h1>";
echo "<strong>Origen (Donde están las fotos):</strong> " . $target . "<br>";
echo "<strong>Destino (El acceso directo):</strong> " . $shortcut . "<br><br>";

// CHEQUEO DE SEGURIDAD
if (file_exists($shortcut)) {
    echo "<h3 style='color:red'>❌ ERROR: Ya existe algo llamado 'storage' aquí.</h3>";
    echo "NO se creó el link porque ya hay una carpeta con ese nombre.<br>";
    echo "👉 <strong>SOLUCIÓN:</strong> Ve a tu Administrador de Archivos, entra a <code>public_html</code> y BORRA la carpeta llamada <code>storage</code> (asegúrate que sea la que está dentro de public, la que suele estar vacía o dar error). Luego recarga esta página.";
} else {
    // INTENTO DE CREACIÓN
    if (symlink($target, $shortcut)) {
        echo "<h3 style='color:green'>✅ ¡ÉXITO! Symlink creado correctamente.</h3>";
        echo "Ya puedes borrar este archivo y probar tus imágenes.";
    } else {
        echo "<h3 style='color:red'>❌ ERROR CRÍTICO</h3>";
        echo "El servidor no permitió crear el enlace. Puede ser un tema de permisos o que la función <code>symlink</code> esté desactivada.";
    }
}
?>