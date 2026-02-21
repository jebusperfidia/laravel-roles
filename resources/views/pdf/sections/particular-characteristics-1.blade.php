{{-- TÍTULO PRINCIPAL DE LA SECCIÓN --}}
<div style="font-weight: bold; font-size: 14px; color: #000; margin-bottom: 5px; text-transform: uppercase;">
    II. CARACTERÍSTICAS PARTICULARES
</div>
<div
    style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
    Terreno
</div>

{{-- BLOQUE 1: MAPAS Y VIALIDADES --}}
<div style="margin-bottom: 15px;">

    {{-- TABLA DE MAPAS (Ya tenías esta lógica, la mantengo igual) --}}
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td style="width: 50%; text-align: center; font-size: 9px; font-weight: bold; padding-bottom: 2px;">
                Microlocalización
            </td>
            <td style="width: 50%; text-align: center; font-size: 9px; font-weight: bold; padding-bottom: 2px;">
                Macrolocalización
            </td>
        </tr>
        <tr>
            <td style="width: 50%; padding: 2px; text-align: center;">
                @if($mapMicroBase64)
                <img src="{{ $mapMicroBase64 }}"
                    style="width: 98%; height: 160px; object-fit: cover; border: 1px solid #ccc;">
                @else
                <div
                    style="width: 98%; height: 160px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; color: #999; font-size: 10px;">
                    Sin Mapa Micro
                </div>
                @endif
            </td>
            <td style="width: 50%; padding: 2px; text-align: center;">
                @if($mapMacroBase64)
                <img src="{{ $mapMacroBase64 }}"
                    style="width: 98%; height: 160px; object-fit: cover; border: 1px solid #ccc;">
                @else
                <div
                    style="width: 98%; height: 160px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; color: #999; font-size: 10px;">
                    Sin Mapa Macro
                </div>
                @endif
            </td>
        </tr>
    </table>

    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px;">
        Calles transversales, limítrofes y orientación:
    </div>


 {{-- TABLA DE DATOS DE VIALIDADES --}}
<table class="form-table">
    {{-- Fila 1: Calle con frente --}}
    <tr>
        <td class="label-cell" style="width: 20%;">Calle con frente(s):</td>
        <td class="value-cell" colspan="3">{{ strtoupper($land_streetFront) }}</td>
    </tr>

    {{-- Fila 2: Transversal --}}
    <tr>
        <td class="label-cell" style="width: 20%;">Calle transversal:</td>
        <td class="value-cell" style="width: 30%;">{{ strtoupper($land_crossStreets) }}</td>
        <td class="label-cell" style="width: 20%;">Orientación:</td>
        <td class="value-cell" style="width: 30%;">{{ strtoupper($land_crossOrient1) }}</td>
    </tr>

    {{-- Fila 3: Limítrofes --}}
    <tr>
        <td class="label-cell">Calles limítrofes:</td>
        <td class="value-cell">{{ strtoupper($land_borderStreets) }}</td>
        <td class="label-cell">Orientación:</td>
        <td class="value-cell">{{ strtoupper($land_borderOrient1) }}</td>
    </tr>

    {{-- Fila 4: Panorámicas (Con celda de orientación vacía o fija para mantener estructura) --}}
    <tr>
        <td class="label-cell">Carac. Panorámicas:</td>
        <td class="value-cell">SIN RELEVANCIA</td> {{-- O usa la variable $land_panoramic si aplica aquí --}}
        <td class="label-cell">Orientación:</td>
        <td class="value-cell">-</td> {{-- Campo de relleno para estructura --}}
    </tr>

    {{-- Fila 5: Restricciones (Con celda de orientación vacía o fija) --}}
    <tr>
        <td class="label-cell">Restricciones:</td>
        <td class="value-cell">LAS PROPIAS DEL REGLAMENTO</td>
        <td class="label-cell">Orientación:</td>
        <td class="value-cell">-</td> {{-- Campo de relleno para estructura --}}
    </tr>

    {{-- Fila 6: Características panorámicas (Full Width) --}}
    <tr>
        <td class="label-cell">Características panorámicas:</td>
        <td class="value-cell" colspan="3">{{ strtoupper($land_panoramic) }}</td>
    </tr>

    {{-- Fila 7: Servidumbre (Full Width) --}}
    <tr>
        <td class="label-cell">Servidumbre y/o restricciones:</td>
        <td class="value-cell" colspan="3">{{ strtoupper($land_restrictions) }}</td>
    </tr>

    {{-- Fila 8: Ubicación / Configuración --}}
    <tr>
        <td class="label-cell">Ubicación:</td>
        <td class="value-cell">{{ strtoupper($land_location) }}</td>
        <td class="label-cell">Configuración:</td>
        <td class="value-cell">{{ strtoupper($land_configuration) }}</td>
    </tr>

    {{-- Fila 9: Topografía / Tipo Vialidad --}}
    <tr>
        <td class="label-cell">Topografía:</td>
        <td class="value-cell">{{ strtoupper($land_topography) }}</td>
        <td class="label-cell">Tipo de vialidad:</td>
        <td class="value-cell">{{ strtoupper($land_roadType) }}</td>
    </tr>
</table>
</div>


{{-- BLOQUE 2: INFORMACIÓN LEGAL --}}
<div style="margin-bottom: 15px;">
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px;">
        Información legal:
    </div>

    <table class="form-table">
        {{-- Fila 1 --}}
        <tr>
            {{-- Solo mostramos si hay etiqueta --}}
            <td class="label-cell" style="width: 20%;">{{ !empty($legalData[0][0]) ? $legalData[0][0] : '' }}</td>
            <td class="value-cell value-half">{{ strtoupper($legalData[0][1] ?? '') }}</td>

            <td class="label-cell" style="width: 20%;">{{ !empty($legalData[1][0]) ? $legalData[1][0] : '' }}</td>
            <td class="value-cell value-half">{{ strtoupper($legalData[1][1] ?? '') }}</td>
        </tr>
        {{-- Fila 2 --}}
        <tr>
            <td class="label-cell">{{ !empty($legalData[2][0]) ? $legalData[2][0] : '' }}</td>
            <td class="value-cell value-half">{{ strtoupper($legalData[2][1] ?? '') }}</td>

            <td class="label-cell">{{ !empty($legalData[3][0]) ? $legalData[3][0] : '' }}</td>
            <td class="value-cell value-half">{{ strtoupper($legalData[3][1] ?? '') }}</td>
        </tr>
        {{-- Fila 3 --}}
        <tr>
            <td class="label-cell">{{ !empty($legalData[4][0]) ? $legalData[4][0] : '' }}</td>
            <td class="value-cell value-half">{{ strtoupper($legalData[4][1] ?? '') }}</td>

            <td class="label-cell">{{ !empty($legalData[5][0]) ? $legalData[5][0] : '' }}</td>
            <td class="value-cell value-half">{{ strtoupper($legalData[5][1] ?? '') }}</td>
        </tr>
    </table>
</div>
{{-- BLOQUE 3: MEDIDAS Y COLINDANCIAS (Iterativo por Grupos) --}}
<div style="margin-bottom: 20px;">
    <div
        style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #000; margin-bottom: 8px;">
        Medidas y colindancias:
    </div>
    <div
        style="font-weight: bold; font-size: 10px; margin-bottom: 8px;">
        COLINDANCIAS ÁREA PRIVATIVA:
    </div>

    @forelse($neighborGroups as $group)
    {{-- Contenedor de cada grupo para dar espacio entre ellos --}}
    <div style="margin-bottom: 15px;">

        {{-- Título del Grupo --}}
        <div
            style="background-color: #f0f0f0; border: 1px solid #ccc; padding: 4px 8px; font-weight: bold; font-size: 10px;">
            {{ strtoupper($group->name) }}
        </div>

        <table style="width:100%; border-collapse:collapse; border:1px solid #ccc; table-layout: fixed;">
            {{-- Encabezados repetidos por cada tabla para claridad --}}
            <tr style="background-color:#f9f9f9;">
                <td
                    style="font-size:8px; font-weight:bold; border:1px solid #ccc; text-align:center; padding:4px; width:25%;">
                    ORIENTACIÓN
                </td>
                <td
                    style="font-size:8px; font-weight:bold; border:1px solid #ccc; text-align:center; padding:4px; width:20%;">
                    MEDIDA
                </td>
                <td
                    style="font-size:8px; font-weight:bold; border:1px solid #ccc; text-align:center; padding:4px; width:55%;">
                    COLINDANCIA
                </td>
            </tr>

            {{-- Vecinos del grupo actual --}}
         @foreach($group->neighbors as $neighbor)
        <tr>
            <td style="font-size:9px; border:1px solid #ccc; padding:4px; text-align: center; background-color: #fff;">
                {{ strtoupper($neighbor->orientation) }}
            </td>
            <td style="font-size:9px; border:1px solid #ccc; padding:4px; text-align: center; background-color: #fff;">
                {{ number_format($neighbor->extent, 2) }} m
            </td>
            {{-- Celda de Colindancia: Agregado text-align: center; --}}
            <td
                style="font-size:9px; border:1px solid #ccc; padding:4px; text-transform:uppercase; background-color: #fff; text-align: center;">
                {{ strtoupper($neighbor->adjacent) }}
            </td>
        </tr>
        @endforeach
        </table>
    </div>
    @empty
    {{-- Caso de que no haya grupos --}}
    <table style="width:100%; border-collapse:collapse; border:1px solid #ccc;">
        <tr>
            <td style="text-align: center; font-size: 9px; padding: 10px; color: #999; font-style: italic;">
                No se registraron medidas ni colindancias en el sistema.
            </td>
        </tr>
    </table>
    @endforelse
</div>
