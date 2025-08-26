<?php

// config/properties_inputs.php

// Genera automáticamente el array de niveles
$levels = [
    '-3' => 'Sotano 3',
    '-2' => 'Sotano 2',
    '-1' => 'Sotano 1',
    '0'  => 'Planta baja',
];

for ($i = 1; $i <= 99; $i++) {
    $levels[(string) $i] = "Nivel {$i}";
}

return [
    // Múltiples listas de inputs en un solo archivo
    'levels' => $levels,
    'property_types' => [
        '0' => 'Casa habitacion',
        '1'  => 'Casa habitacion en condominio',
        '2'  => 'Casas múltiples',
        '3'  => 'Departamento en condominio',
        '4'  => 'Edificio de productos',
        '5'  => 'Local comercial (aislado)',
        '6'  => 'Nave industrial',
        '7'  => 'Oficina',
        '8'  => 'Oficina en condominio',
        '9'  => 'Otro en construccion',
        '10'  => 'Terreno',
        '11'  => 'Terreno en condominio',
        '12'  => 'Vivienda recuperada'
    ],
    'property_types_sigapred' => [
        '0' => 'Bodega',
        '1' => 'Cajón de estacionamiento',
        '2' => 'Casa habitacion',
        '3' => 'Casa habitacion condominio',
        '4' => 'Centro comercial',
        '5' => 'Departamento en condominio',
        '6' => 'Edificio de departamentos',
        '7' => 'Edificio de estacionamiento',
        '8' => 'Edificio de productos',
        '9' => 'Escuela',
        '10' => 'Hospital',
        '11' => 'Hotel',
        '12' => 'Local comercial',
        '13' => 'Nave industrial',
        '14' => 'Oficina aislada',
        '15' => 'Oficina en condominio',
        '16' => 'Terreno con uso comercial',
        '17' => 'Terreno habitacional',
        '18' => 'Otro',
    ],
    'land_use' => [
        '0' => 'Bodega o cuarto de servicio',
        '1' => 'Comercio',
        '2' => 'Cultura',
        '3' => 'Deporte',
        '4' => 'Educación',
        '5' => 'Estacionamiento',
        '6' => 'Habitacional',
        '7' => 'Hotel',
        '8' => 'Industria',
        '9' => 'Oficina',
        '10' => 'Salud',
    ]
];
