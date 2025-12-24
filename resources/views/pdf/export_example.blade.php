<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Avalúo {{ $valuation->folio ?? 'S/N' }}</title>
    <style>
        @page {
            margin: 0.5cm 1cm 1.5cm 1cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            color: #333;
        }

        /* --- COLORES DEL CLIENTE --- */
        .text-brand {
            color: #25998b;
        }

        .bg-brand {
            background-color: #25998b;
            color: white;
        }

        .border-brand {
            border-color: #25998b;
        }

        /* TABLAS MAESTRAS */
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        td {
            vertical-align: top;
            padding: 3px;
        }

        /* CLASES DE TEXTO */
        .font-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .text-xl {
            font-size: 18px;
        }

        .text-lg {
            font-size: 14px;
        }

        .text-xs {
            font-size: 8px;
        }

        /* HEADER Y FOOTER */
        footer {
            position: fixed;
            bottom: -40px;
            left: 0px;
            right: 0px;
            height: 30px;
            border-top: 2px solid #25998b;
            padding-top: 5px;
            color: #555;
        }

        /* ESTILOS DE PORTADA */
        .header-container {
            margin-bottom: 20px;
            border-bottom: 3px solid #25998b;
            padding-bottom: 10px;
        }

        .cover-photo-container {
            width: 100%;
            height: 350px;
            /* Altura fija para la imagen principal */
            margin: 20px 0;
            border: 1px solid #ddd;
            text-align: center;
            overflow: hidden;
            background-color: #f9f9f9;
        }

        .cover-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Intenta llenar, DomPDF a veces lo ignora y usa aspect ratio */
            object-position: center;
        }

        .box-control {
            border: 1px solid #333;
            padding: 8px;
            background-color: #fff;
        }

        .section-header {
            color: #25998b;
            font-size: 11px;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            margin-top: 15px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .data-label {
            width: 130px;
            font-weight: bold;
            color: #555;
        }

        .data-value {
            border-bottom: 1px solid #eee;
            color: #000;
        }

        /* ESTILOS FOTOS INTERIORES */
        .page-break {
            page-break-after: always;
        }

        .photo-cell {
            width: 50%;
            padding: 5px 10px;
            text-align: center;
        }

        .photo-frame {
            border: 1px solid #ccc;
            height: 200px;
            padding: 2px;
        }

        .photo-img-inner {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .photo-caption {
            background: #eee;
            padding: 3px;
            font-weight: bold;
            font-size: 9px;
            margin-top: 2px;
        }

        /* CAJA DE VALOR CONCLUIDO */
        .value-box {
            margin-top: 30px;
            border: 2px solid #25998b;
            padding: 15px;
            text-align: center;
            background-color: #f0fdfc;
            /* Fondo muy tenue teal */
        }
    </style>
</head>

<body>

    {{-- FOOTER GLOBAL --}}
    <footer>
        <table style="width: 100%;">
            <tr>
                <td style="width: 33%;">Avalúo <strong>{{ $valuation->folio ?? '--------' }}</strong></td>
                <td style="width: 33%;" class="text-center">55 2904 0078 | 777 404 6156</td>
                <td style="width: 33%;" class="text-right">Página <span class="page-number"></span></td>
            </tr>
        </table>
    </footer>

    {{-- ================================================================= --}}
    {{-- PÁGINA 1: PORTADA DE IMPACTO --}}
    {{-- ================================================================= --}}

    {{-- 1. ENCABEZADO: LOGO Y NOMBRE --}}
    <table class="header-container">
        <tr>
            <td style="width: 10%; vertical-align: middle;">
                {{-- LOGO SVG --}}
                @php
                // Intentamos cargar el SVG, si falla, texto fallback
                $logoPath = public_path('logo.svg');
                @endphp
                @if(file_exists($logoPath))
                <img src="{{ $logoPath }}" style="width: 60px; height: auto;">
                @else
                <div style="width: 60px; height: 60px; background: #eee; text-align: center; line-height: 60px;">LOGO
                </div>
                @endif
            </td>
            <td style="width: 50%; vertical-align: middle;">
                {{-- NOMBRE EMPRESA --}}
                <div style="font-size: 18px; font-weight: bold; color: #333;">ESTUDIO ÁLAMO</div>
                <div class="text-brand" style="font-size: 12px; font-weight: bold; letter-spacing: 1px;">ARQUITECTURA +
                    VALUACIÓN</div>
            </td>
            <td style="width: 40%; vertical-align: middle;">
                {{-- CAJA DE CONTROL (Datos clave) --}}
                <div class="box-control text-xs">
                    <table>
                        <tr>
                            <td class="font-bold">No. Interno:</td>
                            <td class="text-right">{{ $valuation->folio ?? 'PENDIENTE' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Fecha Avalúo:</td>
                            <td class="text-right">{{ date('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Caducidad:</td>
                            <td class="text-right text-brand font-bold">{{ date('d/m/Y', strtotime('+6 months')) }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    {{-- 2. IMAGEN PRINCIPAL (LA #1) --}}
    @php
    // Obtenemos la primera foto (sort_order 1)
    $coverPhoto = $photos->first();
    $coverPath = $coverPhoto ? public_path('storage/' . $coverPhoto->file_path) : null;
    @endphp

    <div class="cover-photo-container">
        @if($coverPath && file_exists($coverPath))
        <img src="{{ $coverPath }}" class="cover-img">
        @else
        <div style="padding-top: 150px; color: #999;">SIN FOTOGRAFÍA DE PORTADA</div>
        @endif
    </div>

    {{-- 3. DATOS DEL AVALÚO (RESUMEN) --}}
    <table style="margin-top: 10px;">
        <tr>
            {{-- COLUMNA IZQUIERDA: UBICACIÓN Y SOLICITANTE --}}
            <td style="width: 50%; padding-right: 15px;">
                <div class="section-header">Ubicación del Inmueble</div>
                <table>
                    <tr>
                        <td class="data-label">Calle:</td>
                        <td class="data-value">{{ $valuation->street ?? '' }} {{ $valuation->outdoor_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="data-label">Colonia:</td>
                        <td class="data-value">{{ $valuation->colony ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="data-label">Municipio:</td>
                        <td class="data-value">{{ $valuation->municipality ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="data-label">Estado:</td>
                        <td class="data-value">{{ $valuation->state ?? '' }}</td>
                    </tr>
                </table>

                <div class="section-header">Solicitante</div>
                <table>
                    <tr>
                        <td class="data-value" style="font-size: 11px;">
                            {{ $valuation->solicitante ?? 'NOMBRE DEL SOLICITANTE' }}
                        </td>
                    </tr>
                </table>
            </td>

            {{-- COLUMNA DERECHA: PROPIETARIO Y VALUADOR --}}
            <td style="width: 50%; padding-left: 15px;">
                <div class="section-header">Propietario</div>
                <table>
                    <tr>
                        <td class="data-value" style="font-size: 11px;">
                            {{ $valuation->owner_name ?? $valuation->propietario ?? 'NOMBRE DEL PROPIETARIO' }}
                        </td>
                    </tr>
                </table>

                <div class="section-header">Valuador</div>
                <table>
                    <tr>
                        <td class="data-label">Nombre:</td>
                        <td class="data-value">ARQ. FRANCISCO J. GUTIÉRREZ</td>
                    </tr>
                    <tr>
                        <td class="data-label">Cédula:</td>
                        <td class="data-value">6753437</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- 4. VALOR CONCLUIDO --}}
    <div class="value-box">
        <div style="color: #555; font-size: 10px; letter-spacing: 2px;">VALOR CONCLUIDO</div>
        <div class="text-brand" style="font-size: 26px; font-weight: bold; margin: 5px 0;">
            $ {{ number_format($valuation->valor_concluido ?? 0, 2) }}
        </div>
        <div style="font-size: 9px; font-style: italic;">
            ({{ $valuation->valor_concluido_texto ?? 'CANTIDAD EN LETRA PENDIENTE' }})
        </div>
    </div>

    <div class="page-break"></div>

    {{-- ================================================================= --}}
    {{-- PÁGINA 2+: REPORTE FOTOGRÁFICO --}}
    {{-- ================================================================= --}}

    <div style="text-align: center; margin-bottom: 20px;">
        <h2 class="section-header" style="border: none; text-align: center; font-size: 14px;">REPORTE FOTOGRÁFICO</h2>
        <span style="font-size: 10px; color: #666;">Folio: {{ $valuation->folio ?? '--------' }}</span>
    </div>

    <table style="width: 100%;">
        @foreach($photos as $index => $photo)
        @if($index % 2 == 0) <tr> @endif

            <td class="photo-cell">
                <div class="photo-frame">
                    @php $path = public_path('storage/' . $photo->file_path); @endphp
                    @if(file_exists($path))
                    <img src="{{ $path }}" class="photo-img-inner">
                    @else
                    <div style="padding-top: 80px; color: red; font-size: 10px;">IMG NO DISPONIBLE</div>
                    @endif
                </div>
                <div class="photo-caption uppercase">
                    {{ $photo->description ?: $photo->category }}
                </div>
            </td>

            @if($index % 2 == 1)
        </tr> @endif
        @endforeach

        @if(count($photos) % 2 != 0) <td></td>
        </tr> @endif
    </table>

</body>

</html>
