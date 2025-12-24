{{-- HEADER: LOGO Y DATOS --}}
<table style="margin-bottom: 10px;">
    <tr>
        {{-- COLUMNA IZQUIERDA: LOGO + TEXTO --}}
        <td style="width: 60%; vertical-align: middle;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 65px; padding: 0;">
                        {{-- Tu logo --}}
                        @if(file_exists(public_path('logo.svg')))
                        <img src="{{ public_path('logo.svg') }}" style="width: 60px;">
                        @endif
                    </td>
                    <td style="vertical-align: middle; padding-left: 10px;">
                        <div class="header-logo-text">ESTUDIO ÁLAMO</div>
                        <div class="flex justify-center text-md-center">ARQUITECTURA + VALUACIÓN</div>
                    </td>
                </tr>
            </table>
        </td>

        {{-- COLUMNA DERECHA: DATOS CON FONDO GRIS --}}
        <td style="width: 40%; vertical-align: top; padding-top: 5px;">
            <table class="info-table">
                <tr>
                    <td class="info-label">Número Interno:</td>
                    <td class="info-value">{{ $valuation->folio ?? 'PENDIENTE' }}</td>
                </tr>
                {{-- Espacio blanco simulado con padding --}}
                <tr>
                    <td colspan="2" style="height: 2px;"></td>
                </tr>
                <tr>
                    <td class="info-label">Fecha del Avalúo:</td>
                    <td class="info-value">{{ date('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 2px;"></td>
                </tr>
            {{--     <tr>
                    <td class="info-label">Fecha de Caducidad:</td>
                    <td class="info-value">{{ date('d/m/Y', strtotime('+6 months')) }}</td>
                </tr> --}}
            </table>
        </td>
    </tr>
</table>

{{-- FOTO PORTADA (LIMPIA) --}}
@php
$coverPhoto = $photos->first();
$coverPath = $coverPhoto ? public_path('storage/' . $coverPhoto->file_path) : null;
@endphp
<div class="cover-photo-container">
    @if($coverPath && file_exists($coverPath))
    <img src="{{ $coverPath }}" class="cover-img">
    @else
    <div style="padding-top: 150px; color: #ccc;">FOTOGRAFÍA DE PORTADA</div>
    @endif
</div>

{{-- RESTO DE DATOS (TÍTULOS EN NEGRO) --}}
<table style="margin-top: 10px;">
    <tr>
        <td style="width: 50%; padding-right: 15px;">
            <div class="section-header">Ubicación del Inmueble</div>
            <table>
                <tr>
                    <td class="font-bold" style="width: 50px;">Calle:</td>
                    <td style="border-bottom: 1px solid #eee;">{{ $valuation->street ?? '' }} {{
                        $valuation->outdoor_number ?? '' }}</td>
                </tr>
                <tr>
                    <td class="font-bold">Colonia:</td>
                    <td style="border-bottom: 1px solid #eee;">{{ $valuation->colony ?? '' }}</td>
                </tr>
                <tr>
                    <td class="font-bold">Municipio:</td>
                    <td style="border-bottom: 1px solid #eee;">{{ $valuation->municipality ?? '' }}</td>
                </tr>
                <tr>
                    <td class="font-bold">Estado:</td>
                    <td style="border-bottom: 1px solid #eee;">{{ $valuation->state ?? '' }}</td>
                </tr>
            </table>

            <div class="section-header">Solicitante</div>
            <div>{{ $valuation->solicitante ?? 'NOMBRE DEL SOLICITANTE' }}</div>
        </td>

        <td style="width: 50%; padding-left: 15px;">
            <div class="section-header">Propietario</div>
            <div>{{ $valuation->owner_name ?? $valuation->propietario ?? 'NOMBRE DEL PROPIETARIO' }}</div>

            <div class="section-header">Valuador</div>
            <table>
                <tr>
                    <td class="font-bold">Nombre:</td>
                    <td>ARQ. FRANCISCO J. GUTIÉRREZ</td>
                </tr>
                <tr>
                    <td class="font-bold">Cédula:</td>
                    <td>6753437</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- VALOR CONCLUIDO --}}
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
