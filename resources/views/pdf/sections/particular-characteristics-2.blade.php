{{-- ======================================================================= --}}
{{-- SECCIÓN: DESCRIPCIÓN GENERAL DEL INMUEBLE --}}
{{-- ======================================================================= --}}
<div style="margin-top: 10px; margin-bottom: 15px;">

    {{-- TÍTULO --}}
    <div
        style="font-weight:bold; font-size:12px; color:#000; margin-bottom:8px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
        DESCRIPCIÓN GENERAL DEL INMUEBLE
    </div>

    {{-- USO ACTUAL --}}
    <table style="width: 100%; border-collapse: collapse; font-size: 9px; margin-bottom: 5px;">
        <tr>
            <td style="width: 15%; text-align: right; vertical-align: top; padding-right: 5px; color: #444;">Uso actual:
            </td>
            <td style="width: 85%; text-align: justify; text-transform: uppercase; line-height: 1.2;">
                {{ $gralInfo->uso_actual ?: '-' }}
            </td>
        </tr>
    </table>

    {{-- ESPACIO DE USO MÚLTIPLE Y PISO --}}
    <table style="width: 100%; border-collapse: collapse; font-size: 9px; margin-bottom: 15px;">
        <tr>
            <td style="width: 20%; text-align: right; padding-right: 5px; color: #444;">Espacio de uso múltiple:</td>
            <td style="width: 30%; background-color: #e5e7eb; padding: 2px 4px; color: #000;">
                {{ $gralInfo->uso_multiple ?: '-' }}
            </td>
            <td style="width: 25%; text-align: right; padding-right: 5px; color: #444;">Piso o nivel de ubicación:</td>
            <td style="width: 25%; background-color: #e5e7eb; padding: 2px 4px; color: #000;">
                {{ $gralInfo->nivel_ubicacion ?: '-' }}
            </td>
        </tr>
    </table>

    {{-- TABLA: CONSTRUCCIONES PRIVATIVAS --}}
    <div style="font-weight: bold; font-size: 11px; margin-bottom: 2px; color: #000;">
        Clasificación de las construcciones privativas
    </div>
    <table style="width: 100%; border-collapse: collapse; font-size: 8.5px; margin-bottom: 10px; text-align: center;">
        <thead>
            <tr style="background-color: #8b8b8b; color: white;">
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal; width: 25%;">Descripción</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Clase SHF</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Uso</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Clase</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Superficie</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Fuente</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal; font-size: 7.5px;">Niv.<br>Cpo.
                </th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal; font-size: 7.5px;">Niv.<br>Tipo
                </th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Edad</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Av. Ob.</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">VMR</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">VUR</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Edo Conservación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($privateConstructions as $item)
            <tr style="background-color: #e5e7eb; color: #000;">
                <td style="padding: 2px; border: 1px solid #fff; text-align: left; text-transform: uppercase;">{{
                    $item->description ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->clase_shf ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->uso ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->clase ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ number_format($item->surface, 2) }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->fuente ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->niv_cpo ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->niv_tipo ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->age ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->progress ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->vmr ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->vur ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff; text-transform: uppercase;">{{ $item->edo_cons ?: '-'
                    }}</td>
            </tr>
            @empty
            <tr style="background-color: #e5e7eb; color: #000;">
                <td colspan="13" style="padding: 4px; border: 1px solid #fff; text-align: center;">Sin construcciones
                    privativas registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TABLA: CONSTRUCCIONES COMUNES --}}
    <div style="font-weight: bold; font-size: 11px; margin-bottom: 2px; color: #000;">
        Clasificación de las construcciones comunes
    </div>
    <table style="width: 100%; border-collapse: collapse; font-size: 8.5px; margin-bottom: 15px; text-align: center;">
        <thead>
            <tr style="background-color: #8b8b8b; color: white;">
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal; width: 25%;">Descripción</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Clase SHF</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Uso</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Clase</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Superficie</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Fuente</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal; font-size: 7.5px;">Niv.<br>Cpo.
                </th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal; font-size: 7.5px;">Niv.<br>Tipo
                </th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Edad</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Av. Ob.</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">VMR</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">VUR</th>
                <th style="padding: 3px; border: 1px solid #fff; font-weight: normal;">Edo Conservación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($commonConstructions as $item)
            <tr style="background-color: #e5e7eb; color: #000;">
                <td style="padding: 2px; border: 1px solid #fff; text-align: left; text-transform: uppercase;">{{
                    $item->description ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->clase_shf ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->uso ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->clase ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ number_format($item->surface, 2) }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->fuente ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->niv_cpo ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->niv_tipo ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->age ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->progress ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->vmr ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff;">{{ $item->vur ?: '-' }}</td>
                <td style="padding: 2px; border: 1px solid #fff; text-transform: uppercase;">{{ $item->edo_cons ?: '-'
                    }}</td>
            </tr>
            @empty
            <tr style="background-color: #e5e7eb; color: #000;">
                <td colspan="13" style="padding: 4px; border: 1px solid #fff; text-align: center;">Sin construcciones
                    comunes registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- LISTA DE ATRIBUTOS --}}
    <table
        style="width: 100%; border-collapse: separate; border-spacing: 2px 4px; font-size: 9px; margin-bottom: 25px;">
        <tr>
            <td style="text-align: right; width: 25%; color: #444; vertical-align: middle;">Unidades rentables:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; width: 22%; color: #000;">{{
                $atributos->unidades_rentables ?: '-' }}</td>
            <td style="text-align: right; width: 31%; color: #444; vertical-align: middle;">Avance de obra general (%):
            </td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; width: 22%; color: #000;">{{
                $atributos->avance_gral ?: '-' }}</td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444; vertical-align: middle;">Unidades rentables en el<br>núcleo de
                construcción:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $atributos->unidades_nucleo ?: '-' }}</td>
            <td style="text-align: right; color: #444; vertical-align: middle;">Avance de obra en áreas<br>comunes en
                condominios: (%)</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $atributos->avance_comunes ?: '-' }}</td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444; vertical-align: middle;">Unidades rentables del<br>conjunto
                (condominios):</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $atributos->unidades_conjunto ?: '-' }}</td>
            <td style="text-align: right; color: #444; vertical-align: middle;">Clase general del inmueble:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $atributos->clase_gral ?: '-' }}</td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444; vertical-align: middle;">Calidad de proyecto:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000; text-transform: uppercase;">
                {{ $atributos->calidad_proyecto ?: '-' }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444; vertical-align: middle;">Edad aproximada (ponderada<br>en años):
            </td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $atributos->edad_ponderada ?: '-' }}</td>
            <td style="text-align: right; color: #444; vertical-align: middle;">Vida útil remanente<br>(ponderada) en
                años:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $atributos->vida_remanente ?: '-' }}</td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444; vertical-align: middle;">Estado de conservación:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000; text-transform: uppercase;">
                {{ $atributos->estado_conservacion ?: '-' }}</td>
            <td style="text-align: right; color: #444; vertical-align: middle;">Sup. Último nivel (%):</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $atributos->sup_ultimo_nivel ?: '-' }}</td>
        </tr>
    </table>

    {{-- ======================================================================= --}}
    {{-- SECCIÓN: SUPERFICIES --}}
    {{-- ======================================================================= --}}

    {{-- TÍTULO SUPERFICIES --}}
    <div
        style="font-weight:bold; font-size:12px; color:#000; margin-bottom:8px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
        SUPERFICIES
    </div>

    {{-- ESCRITURAS --}}
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #000; margin-bottom: 8px;">
        Superficie(s) inscrita(s) o asentada(s) en ESCRITURAS:
    </div>
    <table
        style="width: 100%; border-collapse: separate; border-spacing: 2px 4px; font-size: 9px; margin-bottom: 15px;">
        <tr>
            <td style="text-align: right; width: 15%; color: #444;">Escritura #:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; width: 35%; color: #000;">{{
                $escrituras->num ?: '-' }}</td>
            <td style="text-align: right; width: 15%; color: #444;">Notaria:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; width: 35%; color: #000;">{{
                $escrituras->notaria ?: '-' }}</td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444;">Fecha:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $escrituras->fecha ?: '-' }}</td>
            <td style="text-align: right; color: #444;">Notario:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000; text-transform: uppercase;">
                {{ $escrituras->notario ?: '-' }}</td>
        </tr>
    </table>

    {{-- TERRENO --}}
   <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #000; margin-bottom: 8px;">
       Terreno
    </div>
    <table
        style="width: 100%; border-collapse: separate; border-spacing: 2px 4px; font-size: 9px; margin-bottom: 15px;">
        <tr>
            <td style="text-align: right; width: 25%; color: #444;">Total del terreno:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; width: 25%; color: #000;">{{
                $terreno->total ?: '-' }}</td>
            <td style="text-align: right; width: 25%; color: #444;">Lote Privativo:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; width: 25%; color: #000;">{{
                $terreno->lote_privativo ?: '-' }}</td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444;">Indiviso (%):</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $terreno->indiviso ?: '-' }}</td>
            <td style="text-align: right; color: #444;">Lote Privativo Tipo:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $terreno->lote_priv_tipo ?: '-' }}</td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444;">Lote Proporcional:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $terreno->lote_proporcional ?: '-' }}</td>
            <td colspan="2"></td>
        </tr>
    </table>


    {{-- TOTAL DE SUPERFICIES --}}
   <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #000; margin-bottom: 8px;">
       Total de superficies:
    </div>
    <table style="width: 100%; border-collapse: separate; border-spacing: 2px 4px; font-size: 9px;">
        <tr>
            <td style="text-align: right; width: 25%; color: #444;">Terreno Total:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; width: 25%; color: #000;">{{
                $superficies->terreno_total ?: '-' }}</td>
            <td style="text-align: right; width: 25%; color: #444;">Superficie construida:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; width: 25%; color: #000;">{{
                $superficies->sup_construida ?: '-' }}</td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444;">Indiviso (%):</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $superficies->indiviso ?: '-' }}</td>
            <td style="text-align: right; color: #444;">Superficie accesoria:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $superficies->sup_accesoria ?: '-' }}</td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444;">Lote Privativo:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $superficies->lote_privativo ?: '-' }}</td>
            <td style="text-align: right; color: #444;">Superficie vendible:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $superficies->sup_vendible ?: '-' }}</td>
        </tr>
        <tr>
            <td style="text-align: right; color: #444;">Terreno Proporcional:</td>
            <td style="background-color: #e5e7eb; padding: 2px 4px; color: #000;">{{
                $superficies->terreno_proporcional ?: '-' }}</td>
            <td colspan="2"></td>
        </tr>
    </table>

</div>


{{-- Salto de página para que empiece limpio --}}
<div style="page-break-before: always;"></div>

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
