<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Avalúo {{ $valuation->folio ?? 'S/N' }}</title>
    @include('pdf.partials.styles')
</head>

<body>

    {{-- FOOTER GLOBAL --}}
    @include('pdf.partials.footer')

    {{-- 1. PORTADA --}}
    @include('pdf.sections.front-page')

    {{-- 2. HOMOLOGACIÓN TERRENOS (Ahora va después de portada) --}}
    @if(($config['sections']['comparables'] ?? false) && isset($landPivots) && $landPivots->count() >= 4)
    <div style="page-break-before: always;"></div>
    @include('pdf.sections.homologation-lands')
    @endif

    {{-- 3. FOTOS (Ahora va al final) --}}
    @if($photos->count() > 0)
    <div style="page-break-before: always;"></div>
    @include('pdf.sections.photos')
    @endif

</body>

</html>
