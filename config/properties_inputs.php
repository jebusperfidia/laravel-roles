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
    ],
    'zone_classification' => [
        '0' => '1. Habitacional de lujo',
        '1' => '2. Habitacional de primer orden',
        '2' => '3. Habitacional de segundo orden',
        '3' => '4. Habitacional de tercer orden',
        '4' => '5. Habitacional de interés social',
        '5' => '6. Habitacional de popular',
        '6' => '7. Habitacional de campestre',
        '7' => '8. Comercial de lujo',
        '8' => '9. Comercial de primer orden',
        '9' => '11. Comercial de segundo orden',
        '10' => '11. Comercial de tercer orden',
        '11' => '12. Industrial',
        '12' => '13. Mixta habitacional y comercial',
        '13' => '14. Mixta industrial y comercial',
        '14' => '15. Mixta habitacional e industrial vecina',
        '15' => '16. Mixta habitacional y servicios',
        '16' => '17. Mixta industrial y servicios',
        '17' => '18. Agricola',
        '18' => '19. Ganadera',
        '19' => '20. Agricola y ganadera'
    ],
    'zone_saturation_index' => [
        '0' => 100,
        '1' => 95,
        '2' => 90,
        '3' => 85,
        '4' => 80,
        '5' => 75,
        '6' => 70,
        '7' => 65,
        '8' => 60,
        '9' => 55,
        '10' => 50,
        '11' => 45,
        '12' => 40,
        '13' => 35,
        '14' => 30,
        '15' => 25,
        '16' => 20,
        '17' => 15,
        '18' => 10,
    ],
    'proximity_urban_reference' => [
        ['clave' => '1', 'nombre' => 'Centrica', 'descripcion' => 'Zonas limitadas generalmente por vía primarias, definidas por la autoridad como zona centro'],
        ['clave' => '2', 'nombre' => 'Intermedia',   'descripcion' => 'Se trata de una proximidad definida a partir de vias primarias limitadas generalmente por vialidades de velocidad intermedia'],
        ['clave' => '3', 'nombre' => 'Periférica',    'descripcion' => 'Se encuentra su acceso y límite mediante vías rápidas, en la mayoria de los casos reconocida como zona urbana de crecimiento inmediato, forma parte de la ciudad'],
        ['clave' => '4', 'nombre' => 'De expansión',  'descripcion' => 'Zona reconocida por la autoridad como de crecimiento potencial, en muchos casos no se encuentra definido su uso de suelo y se encuentra en proceso de reconomcimiento, en función de su crecimiento, próxima a ser parte de la ciudad'],
        ['clave' => '5', 'nombre' => 'Rural',         'descripcion' => 'Reconocido por la autoridad como de uso agrícola o sin dotación de servicios'],
    ]
];
