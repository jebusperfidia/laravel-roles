{{-- ======================================================================= --}}
{{-- SECCIÓN V: CONCLUSIONES --}}
{{-- ======================================================================= --}}

<div style="font-family: Arial, Helvetica, sans-serif; font-size: 9px; margin-top: 10px; page-break-inside: avoid;">

    {{-- HEADER DE LA SECCIÓN --}}
    <div style="font-weight: bold; font-size: 14px; color: #000; margin-bottom: 5px; text-transform: uppercase;">
        V. CONCLUSIONES
    </div>

    <div
        style="font-weight:bold; font-size:12px; color:#000; margin-top:15px; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
        RESUMEN DE VALORES
    </div>

    {{-- 1. RESUMEN DE VALORES (Lista limpia alineada a la derecha) --}}
    <table style="width: 100%; font-size: 9px; margin-bottom: 20px;">
        <tr>
            <td style="text-align: right; font-weight: bold; width: 70%;">Valor del Terreno:</td>
            <td style="text-align: right; font-weight: bold; width: 30%;">
                $ {{ number_format($finalLandValue, 2) }}
            </td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold;">Comparativo de Mercado (Valor de Mercado en el Estado
                Actual):</td>
            <td style="text-align: right; font-weight: bold;">
                $ {{ number_format($finalMarketValue, 2) }}
            </td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold;">Comparativo de Mercado Hipotetico (Valor de Mercado
                Suponiendo su Total Terminación):</td>
            <td style="text-align: right; font-weight: bold;">
                $ {{ number_format($finalHypotheticalValue, 2) }}
            </td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold;">Costos (Valor Fisico o Directo):</td>
            <td style="text-align: right; font-weight: bold;">
                $ {{ number_format($finalPhysicalValue, 2) }}
            </td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold;">Ingresos (Valor por Capitalización de Rentas):</td>
            <td style="text-align: right; font-weight: bold;">
                $ {{ number_format($finalIncomeValue, 2) }}
            </td>
        </tr>
    </table>

    {{-- 2. CONSIDERACIONES PREVIAS --}}
    <div
        style="font-weight:bold; font-size:12px; color:#000; margin-top:15px; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
        CONSIDERACIONES PREVIAS A LA CONCLUSIÓN
    </div>
    <div style="text-align: justify; font-size: 8px; line-height: 1.3; margin-bottom: 15px;">
        El valuador declara que no tiene interés presente o futuro en la propiedad valuada, el presente avalúo se ha
        hecho de conformidad y sujeto a todos los lineamientos aplicables, todas las conclusiones y opiniones sobre la
        propiedad del avalúo han sido preparadas por el valuador que firma el avalúo y c/u de sus hojas. El valuador no
        asume ninguna responsabilidad por las condiciones legales que guarda el inmueble de estudio, ya que el presente
        reporte supone que el propietario mantiene la propiedad en condiciones óptimas. El valuador no está obligado a
        dar testimonio o acudir a Tribunales por haber realizado el presente reporte, a menos que haya acordado
        previamente con el solicitante. La información, los estimados y valores asentados en el reporte se obtuvieron de
        fuentes consideradas confiables y correctas. Se analizaron los valores obtenidos en el presente avalúo y en
        función de los factores de comercialización y a las condiciones que actualmente prevalecen en el mercado
        inmobiliario de esta zona, se llega a las siguientes conclusiones:
    </div>

    {{-- 3. CONCLUSIÓN FINAL --}}
    <div
        style="font-weight:bold; font-size:12px; color:#000; margin-top:15px; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
        CONCLUSIÓN
    </div>
    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 10px; width: 70%;">VALOR CONCLUIDO:</td>
            <td style="text-align: right; font-weight: bold; font-size: 10px; width: 30%;">
                $ {{ number_format($valorConcluidoFinal, 2) }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-size: 9px; padding-top: 2px;">
                {{ $valorConcluidoTexto }} 00/100 M.N.
            </td>
        </tr>
    </table>

    {{-- 4. DATOS DEL VALUADOR --}}
    <div style="font-weight: bold; font-size: 9px; border-bottom: 1px solid #adadad; margin-bottom: 5px;">
        Valuador
    </div>

    <table class="form-table" style="margin-bottom: 30px;">
        {{-- Fila 1: Nombre y Registro Fiscal --}}
        <tr>
            <td class="label-cell" style="width: 15%;">Nombre:</td>
            <td class="value-cell" style="width: 35%;">
                {{ $valuation->valuator_name ?? 'FRANCISCO JESÚS GUTIÉRREZ AGÜERO' }}
            </td>
            <td class="label-cell" style="width: 20%;">Registro Fiscal:</td>
            <td class="value-cell" style="width: 30%;">
                {{ $valuation->valuator_rfc ?? '' }}
            </td>
        </tr>
        {{-- Fila 2: Profesión y Cédula --}}
        <tr>
            <td class="label-cell">Profesión:</td>
            <td class="value-cell">
                {{ $valuation->valuator_profession ?? 'ARQUITECTO' }}
            </td>
            <td class="label-cell">Cédula Profesional:</td>
            <td class="value-cell">
                {{ $valuation->valuator_license ?? '6753437' }}
            </td>
        </tr>
        {{-- Fila 3: Posgrado y Cédula Posgrado --}}
        <tr>
            <td class="label-cell">Posgrado (en su caso):</td>
            <td class="value-cell">
                {{ $valuation->valuator_postgrad ?? 'ESPECIALISTA EN VALUACIÓN INMOBILIARIA' }}
            </td>
            <td class="label-cell">Cédula Profesional:</td>
            <td class="value-cell">
                {{ $valuation->valuator_postgrad_license ?? '8693462' }}
            </td>
        </tr>
    </table>

    {{-- 5. FIRMA (Centrada y con espacio) --}}
    <div style="width: 100%; text-align: center; margin-top: 50px;">
        {{-- Espacio para la imagen de la firma si la tienes --}}
        @if(!empty($valuation->signature_path) && file_exists(storage_path('app/public/'.$valuation->signature_path)))
        <img src="{{ storage_path('app/public/'.$valuation->signature_path) }}"
            style="height: 60px; margin-bottom: -10px;" alt="Firma">
        @else
        <div style="height: 60px;"></div> {{-- Espacio vacío si no hay imagen --}}
        @endif

        <div style="width: 40%; margin: 0 auto; border-top: 1px solid #000; padding-top: 5px;">
            <div style="font-weight: bold; font-size: 10px;">FIRMA</div>
            <div style="font-size: 9px;">{{ $valuation->valuator_name ?? 'FRANCISCO JESÚS GUTIÉRREZ AGÜERO' }}</div>
            <div style="font-size: 8px; color: #555;">Perito Valuador</div>
        </div>
    </div>
</div>
