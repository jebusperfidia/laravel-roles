<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Avalúo {{ $valuation->folio ?? 'S/N' }}</title>
    @include('pdf.partials.styles')
</head>

<body>

    {{-- HEADER GLOBAL (Se repite en todas las páginas gracias a position: fixed) --}}
    @include('pdf.partials.header')

    {{-- FOOTER GLOBAL --}}
    @include('pdf.partials.footer')

    {{-- CONTENIDO PRINCIPAL --}}
    <main>
        {{-- 1. PORTADA (Nota: Ya le quitamos el header interno) --}}
        @include('pdf.sections.front-page')

        {{-- 2. HOMOLOGACIÓN TERRENOS --}}
        @if(($config['sections']['comparables'] ?? false) && isset($landPivots) && $landPivots->count() >= 4)
        <div class="page-break"></div>
        @include('pdf.sections.homologation-lands')
        @endif

        {{-- 3. FOTOS --}}
        @if($photos->count() > 0)
        <div class="page-break"></div>
        @include('pdf.sections.photos')
        @endif
    </main>

</body>

</html>
