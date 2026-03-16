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
{{-- Los anexos se omiten de pintar aquí porque ValuationReportService los inyecta posteriormente
con Fpdi fusionado directamente después del DomPDF --}}
@endif