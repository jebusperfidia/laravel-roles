{{-- TÍTULO PRINCIPAL DE LA SECCIÓN --}}
<div
    style="font-weight: bold; font-size: 14px; color: #000; margin-bottom: 5px; text-transform: uppercase;">
    II. CARACTERÍSTICAS PARTICULARES
</div>
<div
    style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
    Terreno
</div>
{{-- BLOQUE 1: VIALIDADES DE UBICACIÓN Y COLINDANCIAS --}}
<div style="margin-bottom: 15px;">


    {{-- TABLA DE MAPAS --}}
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td style="width: 50%; text-align: center; font-size: 9px; font-weight: bold; padding-bottom: 2px;">
                Microlocalización</td>
            <td style="width: 50%; text-align: center; font-size: 9px; font-weight: bold; padding-bottom: 2px;">
                Macrolocalización</td>
        </tr>
        <tr>
            @php $id = session('valuation_id'); @endphp
            <td style="width: 50%; padding: 2px; text-align: center;">
                {{-- CAMBIO: Barras normales / --}}
                <img src="{{ storage_path('app/public/location_maps/map_' . $id . '_micro.png') }}"
                    style="width: 98%; height: 160px; object-fit: cover; border: 1px solid #ccc;">
            </td>
            <td style="width: 50%; padding: 2px; text-align: center;">
                {{-- CAMBIO: Barras normales / --}}
                <img src="{{ storage_path('app/public/location_maps/map_' . $id . '_macro.png') }}"
                    style="width: 98%; height: 160px; object-fit: cover; border: 1px solid #ccc;">
            </td>
        </tr>
    </table>



    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px;">Calles
        transversales, limítrofes y orientación:</div>
    {{-- TABLA DE DATOS DE VIALIDADES --}}
    <table class="form-table">
        {{-- Fila 1: Full Width --}}
        <tr>
            <td class="label-cell" style="width: 20%;">Calle con frente(s):</td>
            <td class="value-cell" colspan="3">CALLE INDEPENDENCIA AL NORORIENTE</td>
        </tr>

        {{-- Fila 2: Dos Columnas --}}
        <tr>
            <td class="label-cell" style="width: 20%;">Calle transversal:</td>
            <td class="value-cell" style="width: 30%;">INDEPENDENCIA / IXTLAHUACA</td>
            <td class="label-cell" style="width: 20%;">Orientación:</td>
            <td class="value-cell" style="width: 30%;">NOR-ORIENTE</td>
        </tr>

        {{-- Fila 3: Dos Columnas --}}
        <tr>
            <td class="label-cell">Calles limítrofes:</td>
            <td class="value-cell">ALEMANIA / CUMBRES DE MALTRATA</td>
            <td class="label-cell">Orientación:</td>
            <td class="value-cell">NOR-ORIENTE</td>
        </tr>

        {{-- Fila 4: Full Width (Carac. Panorámicas) --}}
        <tr>
            <td class="label-cell">Carac. Panorámicas:</td>
            <td class="value-cell">SIN RELEVANCIA</td>
            <td class="label-cell">Orientación:</td>
            <td class="value-cell">NOR-ORIENTE</td>
        </tr>

        {{-- Fila 5: Full Width (Restricciones) --}}
        <tr>
            <td class="label-cell">Restricciones:</td>
            <td class="value-cell">LAS PROPIAS DEL REGLAMENTO</td>
            <td class="label-cell">Orientación:</td>
            <td class="value-cell">NOR-ORIENTE</td>
        </tr>

        {{-- Fila 6: Full Width (Según tu código repetía este campo con otro valor) --}}
        <tr>
            <td class="label-cell">Características panorámicas:</td>
            <td class="value-cell" colspan="3">CALLE INDEPENDENCIA AL NORORIENTE</td>
        </tr>

        {{-- Fila 7: Full Width (Servidumbre) --}}
        <tr>
            <td class="label-cell">Servidumbre y/o restricciones:</td>
            <td class="value-cell" colspan="3">CALLE INDEPENDENCIA AL NORORIENTE</td>
        </tr>

        {{-- Fila 8: Dos Columnas (Ubicación / Configuración) --}}
        <tr>
            <td class="label-cell">Ubicación:</td>
            <td class="value-cell">LAS PROPIAS</td>
            <td class="label-cell">Configuración:</td>
            <td class="value-cell">NOR-ORIENTE</td>
        </tr>

        {{-- Fila 9: Dos Columnas (Topografía / Tipo de vialidad) --}}
        <tr>
            <td class="label-cell">Topografía:</td>
            <td class="value-cell">LAS PROPIAS</td>
            <td class="label-cell">Tipo de vialidad:</td>
            <td class="value-cell">NOR-ORIENTE</td>
        </tr>
    </table>
</div>

{{-- BLOQUE 2: INFORMACIÓN LEGAL (ESCRITURAS) --}}
<div style="margin-bottom: 15px;">
 <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px;">Información legal
    (Escrituras):</div>

    <table class="form-table">
        {{-- Fila 1 --}}
        <tr>
            <td class="label-cell" style="width: 20%;">Notaría:</td>
            <td class="value-cell value-half">PLANO / IRREGULAR</td>
            <td class="label-cell" style="width: 20%;">Fecha:</td>
            <td class="value-cell value-half">INTERMEDIO</td>
        </tr>
        {{-- Fila 2 --}}
        <tr>
            <td class="label-cell">Escritura:</td>
            <td class="value-cell value-half">484.62 m²</td>
            <td class="label-cell">Notario:</td>
            <td class="value-cell value-half">3.9100%</td>
        </tr>
        {{-- Fila 3 --}}
        <tr>
            <td class="label-cell">Volumen:</td>
            <td class="value-cell value-half">18.95 m²</td>
            <td class="label-cell">Distrito judicial:</td>
            <td class="value-cell value-half">CALLE SUPERIOR A LA MODA</td>
        </tr>
    </table>
</div>





{{-- BLOQUE 3: MEDIDAS Y COLINDANCIAS (AREA PRIVATIVA) --}}
<div style="margin-bottom: 10px;">
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px;">Medidas y colindancias (Area privativa):</div>

    {{-- Tabla con bordes y encabezados --}}
    <table style="width:100%; border-collapse:collapse; border:1px solid #ccc;">
        {{-- Encabezados --}}
        <tr style="background-color:#eee;">
            <td
                style="font-size:9px; font-weight:bold; border:1px solid #ccc; text-align:center; padding:3px; width:15%;">
                ORIENTACIÓN</td>
            <td
                style="font-size:9px; font-weight:bold; border:1px solid #ccc; text-align:center; padding:3px; width:15%;">
                ORIENTACIÓN</td>
            <td
                style="font-size:9px; font-weight:bold; border:1px solid #ccc; text-align:center; padding:3px; width:70%;">
                MEDIDAS Y COLINDANCIAS</td>
        </tr>

        {{-- Fila 1: Norte / Sur --}}
        <tr>
          <td style="font-size:9px; font-weight:bold; border:1px solid #ccc; padding:3px; text-align: center;">Norte:</td>
        <td style="font-size:9px; font-weight:bold; border:1px solid #ccc; padding:3px; text-align: center;">Sur:</td>
            <td style="font-size:9px; border:1px solid #ccc; padding:3px; text-transform:uppercase;"></td>
        </tr>

    </table>
</div>
