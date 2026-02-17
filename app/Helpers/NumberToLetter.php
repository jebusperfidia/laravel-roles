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

        // Usamos la clase nativa de PHP 'NumberFormatter' si está disponible (es lo ideal)
        // Si tu servidor no tiene 'intl' activado, avísame y te paso la versión manual de 500 líneas.
        // Pero el 99% de los hostings modernos la tienen.

        $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $textoEnteros = strtoupper($formatter->format($enteros));

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
