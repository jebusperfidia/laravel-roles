{{-- FOTO PORTADA --}}
@php
$coverPhoto = $photos->first(function($photo) {
return strcasecmp($photo->category, 'Fachada') === 0;
});

if (!$coverPhoto) {
$coverPhoto = $photos->first();
}

$base64Cover = null;
if ($coverPhoto) {
$tempPath = storage_path('app/public/' . $coverPhoto->file_path);
if (file_exists($tempPath)) {
$type = pathinfo($tempPath, PATHINFO_EXTENSION);
$data = file_get_contents($tempPath);
$base64Cover = 'data:image/' . $type . ';base64,' . base64_encode($data);
}
}
@endphp

{{-- Contenedor principal de 350px de alto.
Quitamos borde y fondo si hay imagen para que se vea limpia. --}}
<div class="cover-photo-container"
    style="height: 350px; margin-bottom: 20px; {{ !$base64Cover ? 'background-color: #f4f4f4; border: 1px solid #ccc;' : '' }}">
    @if($base64Cover)
    {{-- Tabla al 100% de alto y ancho para centrar con métodos antiguos pero fiables en DomPDF --}}
    <table
        style="width: 100%; height: 100%; border-collapse: collapse; border: none; mso-table-lspace:0pt; mso-table-rspace:0pt;">
        <tr>
            {{-- Alineación vertical y horizontal de la celda --}}
            <td style="vertical-align: middle; text-align: center; padding: 0; border: none;">
                {{--
                EL FIX DEFINITIVO PARA DOMPDF (ESTILO "CONTAIN"):
                - max-height: 350px y max-width: 100%: Le dice que crezca hasta topar con el borde (alto o ancho).
                - width: auto y height: auto: Mantiene la proporción exacta (no estira).
                - display: inline-block: Ayuda al centrado horizontal.
                --}}
                <img src="{{ $base64Cover }}"
                    style="max-height: 350px; max-width: 100%; width: auto; height: auto; display: inline-block; border: none; outline: none;">
            </td>
        </tr>
    </table>
    @else
    {{-- Mensaje centrado si no hay foto --}}
    <table style="width: 100%; height: 100%; border-collapse: collapse;">
        <tr>
            <td style="vertical-align: middle; text-align: center; color: #ccc; font-weight: bold; font-size: 12px;">
                FOTOGRAFÍA DE PORTADA NO DISPONIBLE
            </td>
        </tr>
    </table>
    @endif
</div>

{{-- BLOQUE 1: SOLICITANTE Y PROPIETARIO --}}
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        {{-- LADO IZQUIERDO: SOLICITANTE --}}
        <td style="width: 50%; padding-right: 10px; vertical-align: top;">
            <div class="section-header" style="border-bottom: 1.5px solid #000; margin-bottom: 5px;">Solicitante</div>
            <table class="form-table">
                <tr>
                    <td class="label-top" style="width: 30%;">Nombre:</td>
                    <td class="value-top">
                        {{ $valuation->applic_name }} {{ $valuation->applic_first_name }} {{
                        $valuation->applic_second_name ?? '' }}
                    </td>
                </tr>
            </table>
        </td>

        {{-- LADO DERECHO: PROPIETARIO --}}
        <td style="width: 50%; padding-left: 10px; vertical-align: top;">
            <div class="section-header" style="border-bottom: 1.5px solid #000; margin-bottom: 5px;">Propietario</div>
            <table class="form-table">
                <tr>
                    <td class="label-top" style="width: 30%;">Nombre:</td>
                    <td class="value-top">
                        {{ $valuation->owner_name }} {{ $valuation->owner_first_name }} {{ $valuation->owner_second_name
                        ?? '' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- BLOQUE 2: UBICACIÓN --}}
<div style="margin-top: 15px;">
    <div class="section-header" style="border-bottom: 1.5px solid #000; margin-bottom: 5px;">Ubicación del inmueble
    </div>
    <table class="form-table">
        <tr>
            <td class="label-cell">Calle:</td>
            <td class="value-cell" colspan="3">
                {{ $valuation->property_street ?? 'INDEPENDENCIA EXT: 34 DEPTO: 302' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Estado:</td>
            <td class="value-cell value-half">{{ $estadoNombre ?? 'CIUDAD DE MÉXICO' }}</td>
            <td class="label-cell">Alcaldía:</td>
            <td class="value-cell value-half">{{ $municipioNombre ?? 'BENITO JUÁREZ' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Colonia:</td>
            <td class="value-cell value-half">
                {{ $valuation->property_colony == 'no-listada' ? ($valuation->property_other_colony ?? 'N/A') :
                ($valuation->property_colony ?? 'SAN SIMÓN TICUMAC') }}
            </td>
            <td colspan="2"></td>
        </tr>
    </table>
</div>

{{-- BLOQUE 3: VALUADOR --}}
<div style="margin-top: 15px;">
    <div class="section-header" style="border-bottom: 1.5px solid #000; margin-bottom: 5px;">Valuador</div>
    <table class="form-table">
        <tr>
            <td class="label-cell">Nombre:</td>
            <td class="value-cell value-half">FRANCISCO JESÚS GUTIÉRREZ AGÜERO</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td class="label-cell">Profesión:</td>
            <td class="value-cell value-half">ARQUITECTO</td>
            <td class="label-cell">Cédula Prof.:</td>
            <td class="value-cell value-half">6753437</td>
        </tr>
        <tr>
            <td class="label-cell">Posgrado:</td>
            <td class="value-cell value-half">ESP. VALUACIÓN INM.</td>
            <td class="label-cell">Cédula Prof.:</td>
            <td class="value-cell value-half">8693462</td>
        </tr>
    </table>
</div>

{{-- VALOR CONCLUIDO --}}
<div style="margin-top: 35px; text-align: right;">
    <div style="display: inline-block; text-align: right;">
        <span style="font-weight: bold; font-size: 11px; margin-right: 15px; vertical-align: middle;">Valor
            Concluido</span>
<span class="text-brand" style="font-size: 20px; font-weight: bold;">
    @if($valorConcluidoFinal > 0)
    $ {{ number_format($valorConcluidoFinal, 2) }}
    @else
    $ -
    @endif
</span>
<div style="font-size: 10px; font-weight: bold; text-transform: uppercase;">
    {{ $valorConcluidoTexto }}
</div>
    </div>
</div>
