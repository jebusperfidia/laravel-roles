{{-- ======================================================================= --}}
{{-- SECCIÓN: ELEMENTOS DE LA CONSTRUCCIÓN --}}
{{-- ======================================================================= --}}

<div style="margin-top: 10px; margin-bottom: 10px;">

    {{-- TÍTULO DE LA SECCIÓN --}}
    <div
        style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
        ELEMENTOS DE LA CONSTRUCCIÓN
    </div>

    {{-- 1. OBRA NEGRA --}}
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px;">
        Obra negra
    </div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Estructura:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['structure'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Cimentación:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['foundation'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Entrepisos:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['mezzanines'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Techos:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['roofs'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Muros:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['walls'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Trabes y Col.:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['beams'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Azoteas:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['rooftops'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Bardas:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['fences'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
    </table>

    {{-- 2. REVESTIMIENTOS Y ACABADOS INTERIORES --}}
    <div
        style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px; margin-top:5px;">
        Revestimientos y Acabados Interiores
    </div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Aplanados:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['revestimientos']['plaster'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Plafones:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['revestimientos']['ceilings'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Lambrines:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['revestimientos']['wainscot'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Escaleras:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['revestimientos']['stairs'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Pisos:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['revestimientos']['floors'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Zoclos:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['revestimientos']['skirting'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Pintura:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['revestimientos']['paint'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Recubrimientos:</td>
            <td class="value-cell" colspan="3" style="border-bottom: 1px dotted #333;">
                {{ $construction['revestimientos']['special'] ?? 'NO PRESENTA' }}
            </td>
        </tr>
    </table>

    {{-- 3. MATRIZ DE ACABADOS --}}
    <div style="margin-top: 15px;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 5px 3px;">
            <thead>
                <tr>
                    <td style="width: 20%;"></td>
                    <td class="sub-header" style="width: 26%; font-weight:bold; font-size:10px;">Pisos</td>
                    <td class="sub-header" style="width: 27%; font-weight:bold; font-size:10px;">Muros</td>
                    <td class="sub-header" style="width: 27%; font-weight:bold; font-size:10px;">Plafones</td>
                </tr>
            </thead>
            <tbody>
                {{-- Estancia Comedor --}}
                <tr>
                    <td class="label-cell">Estancia Comedor:</td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['living']['floors'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['living']['walls'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['living']['ceilings'] ?? '-' }}
                    </td>
                </tr>

                {{-- Cocina --}}
                <tr>
                    <td class="label-cell">Cocina:</td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['kitchen']['floors'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['kitchen']['walls'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['kitchen']['ceilings'] ?? '-' }}
                    </td>
                </tr>

                {{-- Recámara --}}
                <tr>
                    <td class="label-cell">
                        Recámara <span style="font-size: 8px;">(Cnt: {{ $construction['matrix']['bedrooms']['qty'] ?? 0
                            }})</span>:
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['bedrooms']['floors'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['bedrooms']['walls'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['bedrooms']['ceilings'] ?? '-' }}
                    </td>
                </tr>

                {{-- Baños --}}
                <tr>
                    <td class="label-cell">
                        Baños <span style="font-size: 8px;">(Cnt: {{ $construction['matrix']['bathrooms']['qty'] ?? 0
                            }})</span>:
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['bathrooms']['floors'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['bathrooms']['walls'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['bathrooms']['ceilings'] ?? '-' }}
                    </td>
                </tr>

                {{-- Patio Servicio (UTYR) --}}
                <tr>
                    <td class="label-cell">Patio Servicio:</td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['service']['floors'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['service']['walls'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['service']['ceilings'] ?? '-' }}
                    </td>
                </tr>

                {{-- Escaleras --}}
                <tr>
                    <td class="label-cell">Escaleras:</td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['stairs']['floors'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['stairs']['walls'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['stairs']['ceilings'] ?? '-' }}
                    </td>
                </tr>

                {{-- Estacionamiento --}}
                <tr>
                    <td class="label-cell">
                        Estacionamiento <span style="font-size: 8px;">(Cnt: {{
                            $construction['matrix']['parking_cov']['qty'] ?? 0 }})</span>:
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['parking_cov']['floors'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['parking_cov']['walls'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['parking_cov']['ceilings'] ?? '-' }}
                    </td>
                </tr>

                {{-- Balcón --}}
                <tr>
                    <td class="label-cell">BALCÓN:</td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['balcony']['floors'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['balcony']['walls'] ?? '-' }}
                    </td>
                    <td class="value-cell" style="border-bottom: 1px dotted #333;">
                        {{ $construction['matrix']['balcony']['ceilings'] ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- MEDIOS BAÑOS (AL FINAL DE LA MATRIZ) --}}
    <table class="form-table" style="margin-top: 5px;">
        <tr>
            <td class="label-cell">Medios Baños:</td>
            <td class="value-cell" style="border-bottom: 1px dotted #333;">
                {{ $construction['matrix']['half_baths_qty'] ?? 0 }}
            </td>
        </tr>
    </table>
