@if(isset($isTemplate) && $isTemplate)
{{-- MODO PLANTILLA: Para el fondo de FPDI --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    @include('pdf.partials.styles')
</head>

<body>
    @include('pdf.partials.header')
    @include('pdf.partials.footer')
    <main>
        {{-- Un espacio en blanco para forzar a DomPDF a crear la página --}}
        <div style="height: 1px;">&nbsp;</div>
    </main>
</body>

</html>
@else
{{-- MODO SECCIÓN: Para el flujo normal del master-report (DomPDF) --}}
{{-- Este bloque solo se ejecutará si DomPDF llega a pintar anexos (que ahora los filtramos) --}}
@if(isset($annexes) && $annexes->count() > 0)
@foreach($annexes as $doc)
<div class="page-break"></div>
<div style="text-align: center;">
    <h2 style="font-size: 14px;">ANEXO: {{ $doc->description ?: $doc->category }}</h2>
    {{-- Aquí no pintamos la imagen/pdf porque eso lo hace FPDI después --}}
    {{-- Pero dejamos el espacio por si acaso --}}
</div>
@endforeach
@endif
@endif
