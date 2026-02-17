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
        <div class="page-break"></div>

        {{-- 2. ASPECTOS GENERALES --}}
        @include('pdf.sections.general-aspects-1')
        <div class="page-break"></div>

        @include('pdf.sections.general-aspects-2')
        <div class="page-break"></div>

        {{-- 3. CARACTERÍSTICAS PARTICULARES --}}
        @include('pdf.sections.particular-characteristics-1')
         <div class="page-break"></div>


        @include('pdf.sections.particular-characteristics-2')
        <div class="page-break"></div>

        @include('pdf.sections.particular-characteristics-3')
        <div class="page-break"></div>

        {{-- 4. ENFOQUE COMPARATIVO DEL MERCADO --}}
        @if(($config['sections']['comparables'] ?? false) && isset($landPivots) && $landPivots->count() >= 4)
        @include('pdf.sections.homologation-lands')
        @endif



        {{-- 4. ENFOQUE COMPARATIVO DEL MERCADO --}}
        @if(($config['sections']['comparables'] ?? false) && isset($landPivots) && $landPivots->count() >= 4)
        @include('pdf.sections.homologation-buildings')
        @endif

{{--         <div class="page-break"></div> --}}

        @include('pdf.sections.coast-approach')
        <div class="page-break"></div>



        {{-- 5. CONCLUSIONES --}}
        @include('pdf.sections.conclusions')
        <div class="page-break"></div>

        {{-- 6. FOTOS --}}
        @if($photos->count() > 0)
        @include('pdf.sections.photos')
        @endif

        @include('pdf.sections.documents')

    </main>

</body>

</html>
