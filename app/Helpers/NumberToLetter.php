<?php

namespace App\Helpers;

use NumberFormatter;

class NumberToLetter
{
    public static function convert($amount)
    {
        // Asegurarnos que es float
        $amount = (float) $amount;

        // Separar enteros y decimales
        $enteros = floor($amount);
        $centavos = round(($amount - $enteros) * 100);

        $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $textoEnteros = strtoupper($formatter->format($enteros));

        // --- MAGIA ANTI-DOMPDF: QUITAR ACENTOS ---
        $vocalesConAcento = ['Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú'];
        $vocalesSinAcento = ['A', 'E', 'I', 'O', 'U', 'A', 'E', 'I', 'O', 'U'];
        $textoEnteros = str_replace($vocalesConAcento, $vocalesSinAcento, $textoEnteros);

        // Ajustes gramaticales típicos de México
        // "UN MILLON" -> "UN MILLON DE" si termina en millón exacto
        if (substr($textoEnteros, -6) == "MILLON") {
            $textoEnteros .= " DE";
        }
        if (substr($textoEnteros, -8) == "MILLONES") {
            $textoEnteros .= " DE";
        }

        // Formatear centavos siempre a 2 dígitos (ej. 00, 50, 05)
        $centavosStr = str_pad($centavos, 2, "0", STR_PAD_LEFT);

        return $textoEnteros . " PESOS " . $centavosStr . "/100 M.N.";
    }
}
