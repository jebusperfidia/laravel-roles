<?php

// config/homologation.php

/**
 * Define la lista maestra de factores que se deben crear
 * por defecto para el AVALÚO SUJETO (Tabla 1).
 *
 * NOTA: Se incluye 'homologation_type' para satisfacer la migración de la DB.
 */


//archivo homologation_valuation.php
return [

    'valuation_subject_factors' => [

        // --- FACTORES LAND (7 factores) ---
        [
            'factor_name' => 'F. Zona',
            'acronym' => 'FZO',
            'is_editable' => false,
            'homologation_type' => 'land', // ¡Campo CLAVE para el error SQL!
        ],
        [
            'factor_name' => 'F. Ubicación',
            'acronym' => 'FUB',
            'is_editable' => false,
            'homologation_type' => 'land',
        ],
        [
            'factor_name' => 'F. Forma',
            'acronym' => 'FFO',
            'is_editable' => false,
            'homologation_type' => 'land',
        ],
        [
            'factor_name' => 'F. Superficie',
            'acronym' => 'FSU',
            'is_editable' => false,
            'homologation_type' => 'land',
        ],
        [
            'factor_name' => 'F. Uso de Suelo',
            'acronym' => 'FCUS',
            'is_editable' => false,
            'homologation_type' => 'land',
        ],
        [
            'factor_name' => 'F. Localización',
            'acronym' => 'FLOC',
            'is_editable' => true,
            'homologation_type' => 'land',
        ],
        [
            'factor_name' => 'Otro',
            'acronym' => 'OTRO',
            'is_editable' => true,
            'homologation_type' => 'land',
        ],

        // --- FACTORES BUILDING (6 factores) ---
        [
            'factor_name' => 'Sup. Vendible',
            'acronym' => 'FSU',
            'is_editable' => false,
            'homologation_type' => 'building', // ¡Campo CLAVE para el error SQL!
        ],
        [
            'factor_name' => 'F. Intensidad de const.',
            'acronym' => 'FIC',
            'is_editable' => false,
            'homologation_type' => 'building',
        ],
        [
            'factor_name' => 'Equipamiento',
            'acronym' => 'FEQ',
            'is_editable' => true,
            'homologation_type' => 'building',
        ],
        [
            'factor_name' => 'Edad y conservación',
            'acronym' => 'FEDAD',
            'is_editable' => false,
            'homologation_type' => 'building',
        ],
        [
            'factor_name' => 'F.Localización',
            'acronym' => 'FLOC',
            'is_editable' => true,
            'homologation_type' => 'building',
        ],
        [
            'factor_name' => 'Avance obra',
            'acronym' => 'AVANC',
            'is_editable' => false,
            'homologation_type' => 'building',
        ],
        [
            'factor_name' => 'Conservación',
            'acronym' => 'FCON',
            'is_editable' => false, // No se edita a mano, se lee de la construcción
            'homologation_type' => 'building',
        ],
    ],

];
