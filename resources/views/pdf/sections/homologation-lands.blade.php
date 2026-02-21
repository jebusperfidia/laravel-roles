
<div style="font-weight: bold; font-size: 14px; color: #000; margin-bottom: 5px; text-transform: uppercase;">
    II. ENFOQUE COMPARATIVO DE MERCADO
</div>
<div
    style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b; padding-bottom: 4px;">
    INVESTIGACIÓN DE MERCADO TERRENOS DIRECTOS
</div>

{{-- BLOQUE SUJETO --}}
<div style="border: 1px solid #d1d5db; background-color: #fdfdfd;">
    <div style="background: #f3f4f6; font-size: 9.5px; padding: 4px; border-bottom: 1px solid #d1d5db; color: #000;">
        Características del bien a valuar
    </div>
    <table style="width: 100%; font-size: 9px; border-collapse: collapse;">
        <tr>
            {{-- LADO IZQUIERDO: DATOS DEL SUJETO --}}
            <td style="width: 60%; vertical-align: top; padding: 2px;">
                {{-- Se añadió border-spacing para separar las cajas grises y que no se vea amontonado --}}
                <table style="width: 100%; border-collapse: separate; border-spacing: 3px; text-align: left;">
                    <tr>
                        <td style="padding: 3px 5px; color: #000; width: 15%; text-align: right;">Calle:</td>
                        <td style="padding: 3px 5px; font-weight: bold; color: #000; background-color: #e5e7eb;"
                            colspan="3">
                            {{ $valuation->property_street }} No Ext.: {{ $valuation->property_abroad_number }} No Int.:
                            {{ $valuation->property_inside_number ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 5px; color: #000; text-align: right; width: 15%;">Colonia:</td>
                        <td
                            style="padding: 3px 5px; font-weight: bold; color: #000; background-color: #e5e7eb; width: 35%;">
                            {{ $valuation->property_colony === 'no-listada' ? $valuation->property_other_colony :
                            $valuation->property_colony }}
                        </td>
                        <td style="padding: 3px 5px; color: #000; text-align: right; width: 15%;">Estado:</td>
                        <td
                            style="padding: 3px 5px; font-weight: bold; color: #000; background-color: #e5e7eb; width: 35%;">
                            {{ $estadoInmueble }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 5px; color: #000; text-align: right;">Deleg / Mun:</td>
                        <td style="padding: 3px 5px; font-weight: bold; color: #000; background-color: #e5e7eb;">
                            {{ $municipioInmueble }}
                        </td>
                        <td style="padding: 3px 5px; color: #000; text-align: right;">Edad:</td>
                        <td style="padding: 3px 5px; font-weight: bold; color: #000; background-color: #e5e7eb;">
                            {{ $subjectInfo->edad ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 5px; color: #000; text-align: right;">Conjunto:</td>
                        <td style="padding: 3px 5px; font-weight: bold; color: #000; background-color: #e5e7eb;">
                            {{ $subjectBuildingInfo->conjunto ?? '-' }}
                        </td>
                        <td style="padding: 3px 5px; color: #000; text-align: right;">Lote moda:</td>
                        <td style="padding: 3px 5px; font-weight: bold; color: #000; background-color: #e5e7eb;">
                            {{ number_format($subjectInfo->lote_moda, 2) }} M2
                        </td>
                    </tr>
                </table>

                {{-- Separador sutil para la info de superficies --}}
                <div style="border-top: 1px solid #d1d5db; margin: 2px 5px;"></div>

                <table style="width: 100%; border-collapse: separate; border-spacing: 3px; text-align: left;">
                    <tr>
                        <td style="padding: 3px 5px; color: #000; text-align: right; width: 15%;">Superficie:</td>
                        <td style="padding: 3px 5px; font-weight: bold; color: #000; background-color: #e5e7eb;">
                            {{ number_format($subjectInfo->superficie_terreno, 2) }} M2
                        </td>
                        <td style="padding: 3px 5px; color: #000; text-align: right; width: 22%;">Sup. Construida:</td>
                        <td style="padding: 3px 5px; font-weight: bold; color: #000; background-color: #e5e7eb;">
                            {{ number_format($subjectInfo->superficie_const, 2) }} M2
                        </td>
                        <td style="padding: 3px 5px; color: #000; text-align: right; width: 18%;">Relación. T/C:</td>
                        <td style="padding: 3px 5px; font-weight: bold; color: #000; background-color: #e5e7eb;">
                            {{ number_format($subjectInfo->relacion_tc, 2) }}
                        </td>
                    </tr>
                </table>
            </td>

            {{-- LADO DERECHO: FACTORES DEL SUJETO (INTACTO COMO PEDISTE) --}}
            <td style="width: 40%; vertical-align: top;">
                <table style="width: 100%; border-left: 1px solid #d1d5db; border-collapse: collapse;">
                    <tr style="background: #9ca3af; color: white;">
                        <th
                            style="padding: 3px; border-bottom: 1px solid #d1d5db; font-size: 8.5px; font-weight: normal;">
                            Descripción
                        </th>
                        <th
                            style="padding: 3px; border-bottom: 1px solid #d1d5db; font-size: 8.5px; font-weight: normal;">
                            Iniciales
                        </th>
                        <th
                            style="padding: 3px; border-bottom: 1px solid #d1d5db; font-size: 8.5px; font-weight: normal;">
                            Calificación
                        </th>
                    </tr>
                    @foreach($orderedHeaders as $header)
                    @if($header->acronym != 'FNEG')
                    <tr>
                        <td
                            style="border-bottom: 1px solid #e5e7eb; background: #f3f4f6; padding: 2px 5px; color: #000; text-align: center;">
                            {{ $header->factor_name }}
                        </td>
                        <td style="border-bottom: 1px solid #e5e7eb; text-align: center; color: #000;">
                            {{ $header->acronym }}
                        </td>
                        <td
                            style="border-bottom: 1px solid #e5e7eb; text-align: center; font-weight: bold; color: #000;">
                            {{ number_format($header->rating, 2) }}
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
</div>

{{-- LA "SÚPER TABLA" DE COMPARABLES --}}
<div style="font-size: 12px; font-weight: bold; margin-top: 4px; margin-bottom: 4px; color: #000; padding-left: 5px;">
    Inmuebles comparables (Terrenos baldíos ofertados)
</div>

<table
    style="width: 100%; border-collapse: collapse; font-size: 7.5px; table-layout: fixed; border: 1px solid #25998b;">
    <thead>
        <tr style="background: #9ca3af; color: white;">
            <th style="width: 16%; border: 1px solid #6b7280; padding: 4px; font-weight: normal;">CONCEPTO</th>
            @foreach($landPivots as $index => $pivot)
            <th style="border: 1px solid #6b7280; padding: 4px; font-weight: normal;">Comparable {{ $index + 1 }}</th>
            @endforeach
        </tr>
        <tr style="background: #e5e7eb; color: #000;">
            <th style="border: 1px solid #d1d5db; padding: 2px;"></th>
            @foreach($landPivots as $pivot)
            <th style="border: 1px solid #d1d5db; padding: 2px; font-weight: bold;">{{ $pivot->comparable->id ?? '-' }}
            </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{-- FOTOS --}}
        <tr>
            <td style="border: 1px solid #e5e7eb; background: #f9fafb; padding: 4px; color: #000; font-weight: bold;">FOTO</td>
            @foreach($landPivots as $pivot)
            <td style="border: 1px solid #e5e7eb; text-align: center; padding: 2px;">
                @php
                $base64 = null;
                if($pivot->comparable->comparable_photos) {
                $cleanName = str_replace(['[', ']', '"'], '', $pivot->comparable->comparable_photos);
                $pathInPublic = public_path('comparables/' . $cleanName);
                if(file_exists($pathInPublic)) {
                $type = pathinfo($pathInPublic, PATHINFO_EXTENSION);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($pathInPublic));
                }
                }
                @endphp
                @if($base64)
                <img src="{{ $base64 }}"
                    style="width: 100%; max-height: 45px; object-fit: cover; border: 1px solid #eee;">
                @else
                <div
                    style="height: 45px; background: #f3f4f6; color: #000; line-height: 45px; font-size: 6.5px; border: 1px dashed #ccc;">
                    SIN IMAGEN</div>
                @endif
            </td>
            @endforeach
        </tr>

        {{-- DATOS TÉCNICOS SEGÚN SISTEMA VIEJO --}}
        @php
        $rowStyle1 = 'border: 1px solid #e5e7eb; padding: 2px; font-size: 7.5px; color: #000;';
        $rowStyleBg = 'border: 1px solid #e5e7eb; background: #f9fafb; padding: 2px; font-size: 7.5px; color: #000;';
        $labelStyle = 'border: 1px solid #e5e7eb; background: #f3f4f6; padding: 2px 4px; color: #000;';
        @endphp

        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">CARACTERÍSTICAS</td>
            @foreach($landPivots as $pivot)
            <td style="{{ $rowStyle1 }} text-transform: uppercase; font-weight: bold;">
                {{ $pivot->comparable->comparable_characteristics ?? '-' }}
              </td>
            @endforeach
        </tr>
        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">CALLE Y NÚMERO</td>
            @foreach($landPivots as $pivot)
            <td style="{{ $rowStyleBg }} font-weight: bold;">{{ Str::limit($pivot->comparable->comparable_street, 35) }}
            </td>
            @endforeach
        </tr>
        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">COLONIA Y C.P.</td>
            @foreach($landPivots as $pivot)
            <td style="{{ $rowStyle1 }} font-weight: bold;">{{ $pivot->comparable->comparable_colony }} {{
                $pivot->comparable->comparable_cp }}</td>
            @endforeach
        </tr>
        {{-- MUNICIPIO --}}
        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">MUNICIPIO</td>
            @foreach($landPivots as $pivot)
            <td style="{{ $rowStyleBg }} font-weight: bold;">
                {{-- Antes: $pivot->comparable->comparable_municipality --}}
                {{ $pivot->comparable->resolved_municipality ?? $pivot->comparable->comparable_municipality }}
            </td>
            @endforeach
        </tr>

        {{-- ENTIDAD / ESTADO --}}
        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">ENTIDAD</td>
            @foreach($landPivots as $pivot)
            <td style="{{ $rowStyle1 }} font-weight: bold;">
                {{-- Antes: $pivot->comparable->comparable_state --}}
                {{ $pivot->comparable->resolved_state ?? $pivot->comparable->comparable_state }}
            </td>
            @endforeach
        </tr>
        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">FUENTE/URL</td>
            @foreach($landPivots as $pivot)
            <td style="{{ $rowStyleBg }} word-wrap: break-word; font-weight: bold;">{{
                $pivot->comparable->comparable_url }}</td>
            @endforeach
        </tr>
        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">TELÉFONO</td>
            @foreach($landPivots as $pivot)
            <td style="{{ $rowStyle1 }} font-weight: bold;">{{ $pivot->comparable->comparable_phone ?? '-' }}</td>
            @endforeach
        </tr>
        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">OFERTA</td>
            @foreach($landPivots as $pivot)
            <td style="{{ $rowStyleBg }} font-weight: bold;">${{ number_format($pivot->comparable->comparable_offers, 2)
                }}</td>
            @endforeach
        </tr>
       <tr>
        <td style="{{ $labelStyle }} font-weight: bold;">ÁREA LIBRE</td>
        @foreach($landPivots as $pivot)
        <td style="{{ $rowStyle1 }} font-weight: bold;">
            {{ number_format($pivot->comparable->clean_area_libre ?? 0, 0) }}%
        </td>
        @endforeach
    </tr>
    <tr>
        <td style="{{ $labelStyle }} font-weight: bold;">NIVELES</td>
        @foreach($landPivots as $pivot)
        <td style="{{ $rowStyleBg }} font-weight: bold;">
            {{ number_format($pivot->comparable->clean_niveles ?? 0, 1) }}
        </td>
        @endforeach
    </tr>
    <tr>
        <td style="{{ $labelStyle }} font-weight: bold;">USO SUELO</td>
        @foreach($landPivots as $pivot)
        <td style="{{ $rowStyle1 }} font-weight: bold;">{{ $pivot->comparable->comparable_land_use ?? '-' }}</td>
        @endforeach
    </tr>
    <tr>
        <td style="{{ $labelStyle }} font-weight: bold;">CUS</td>
        @foreach($landPivots as $pivot)
        <td style="{{ $rowStyleBg }} font-weight: bold;">
            {{ number_format($pivot->comparable->calculated_cus ?? 0, 2) }}
        </td>
        @endforeach
    </tr>
        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">SUP.TERRENO M2</td>
            @foreach($landPivots as $pivot)
            <td style="{{ $rowStyle1 }} font-weight: bold;">{{ number_format($pivot->comparable->comparable_land_area,
                2) }}</td>
            @endforeach
        </tr>
        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">V.UNITARIO</td>
            @foreach($landPivots as $pivot)
            <td style="{{ $rowStyleBg }} font-weight: bold;">${{
                number_format($pivot->comparable->comparable_unit_value, 2) }}</td>
            @endforeach
        </tr>

        {{-- CALCULO RÁPIDO PARA VALOR HOMOLOGADO --}}
       <tr style="background: #f0fdfa;">
        <td style="border: 1px solid #e5e7eb; padding: 2px 4px; color: #000; font-weight: bold;">VALOR.UNIT.HOMOLOGADO</td>
        @foreach($landPivots as $pivot)
        <td style="border: 1px solid #e5e7eb; padding: 2px; font-weight: bold; color: #000; text-align: left;">
            ${{ number_format($pivot->calculated_val_hom, 2) }}
        </td>
        @endforeach
    </tr>

        {{-- FACTOR NEGOCIACIÓN --}}
        <tr>
            <td style="{{ $labelStyle }} font-weight: bold;">FNEG</td>
            @foreach($landPivots as $pivot)
            @php
            // Extraemos del mapa, si no hay, asignamos guion directamente
            $fMap = $pivot->factors_mapped ?? [];
            $fnegValue = $fMap['FNEG']->applicable ?? '-';
            @endphp
            <td style="{{ $rowStyle1 }} font-weight: bold;">
                {{-- Solo formateamos si es numérico --}}
                {{ is_numeric($fnegValue) ? number_format($fnegValue, 2) : $fnegValue }}
            </td>
            @endforeach
        </tr>

        {{-- ENCABEZADO DE FACTORES DE AJUSTE --}}
        <tr style="background: #9ca3af; color: white;">
            <td style="border: 1px solid #6b7280; padding: 2px 4px; text-align: center;">Factores</td>
            @foreach($landPivots as $pivot)
            <td style="border: 1px solid #6b7280; padding: 0;">
                <table style="width: 100%; border-collapse: collapse; color: white; font-size: 6.5px;">
                    <tr>
                        <td style="width: 50%; text-align: center; border-right: 1px solid #d1d5db; padding: 2px;">
                            Factor</td>
                        <td style="width: 50%; text-align: center; padding: 2px;">Aplicable</td>
                    </tr>
                </table>
            </td>
            @endforeach
        </tr>

    {{-- DESGLOSE DINÁMICO DE TODOS LOS FACTORES (Incluye editables) --}}
    @foreach($orderedHeaders as $header)
    <tr>
        <td style="border: 1px solid #e5e7eb; background: #f3f4f6; padding: 2px 4px; color: #000; font-weight: bold;">
            {{ $header->factor_name }} ({{ $header->acronym }})
        </td>
        @foreach($landPivots as $pivot)
        @php
        $fMap = $pivot->factors_mapped ?? [];
        $fact = $fMap[$header->acronym] ?? null;
        @endphp
        <td style="border: 1px solid #e5e7eb; padding: 0;">
            <table style="width: 100%; border-collapse: collapse; font-size: 7px;">
                <tr>
                    <td style="width: 50%; text-align: center; border-right: 1px solid #eee; padding: 2px; font-weight: bold;">
                        {{ $fact ? number_format($fact->rating, 2) : '1.00' }}
                    </td>
                    <td style="width: 50%; text-align: center; font-weight: bold; padding: 2px; color: #000;">
                        {{ $fact ? number_format($fact->applicable, 2) : '1.00' }}
                    </td>
                </tr>
            </table>
        </td>
        @endforeach
    </tr>
    @endforeach

  {{-- FACTOR RESULTANTE FINAL --}}
<tr style="background: #f3f4f6; border-top: 1.5px solid #25998b;">
    <td style="border: 1px solid #d1d5db; padding: 2px 4px; color: #000; font-weight: bold;">FRE TOTAL</td>
    @foreach($landPivots as $pivot)
    <td
        style="border: 1px solid #d1d5db; text-align: center; font-weight: bold; color: #000; font-size: 8.5px; padding: 2px;">
        {{ number_format($pivot->calculated_fre, 2) }}
    </td>
    @endforeach
</tr>
</tbody>
</table>

{{-- TABLA ESTADÍSTICA DE PONDERACIÓN Y GRÁFICA --}}
<div style="margin-top: 10px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            {{-- TABLA INTEGRADA (IZQUIERDA) - ANCHO 60% --}}
            <td style="width: 60%; vertical-align: top;">
                <table
                    style="width: 100%; border-collapse: collapse; font-size: 8px; border: 1px solid #ccc; text-align: center;">
                    <thead>
                        <tr style="background: #9ca3af; color: white;">
                            <th style="padding: 3px; border: 1px solid #d1d5db; font-weight: normal;">Comparable</th>
                            <th style="padding: 3px; border: 1px solid #d1d5db; font-weight: normal;">Valor de Oferta
                            </th>
                            <th style="padding: 3px; border: 1px solid #d1d5db; font-weight: normal;">Valor Unit Hom
                            </th>
                            <th style="padding: 3px; border: 1px solid #d1d5db; font-weight: normal;">Factor de Ajuste
                            </th>
                            <th style="padding: 3px; border: 1px solid #d1d5db; font-weight: normal;">Desviación</th>
                            <th style="padding: 3px; border: 1px solid #d1d5db; font-weight: normal;">Credibilidad</th>
                            <th style="padding: 3px; border: 1px solid #d1d5db; font-weight: normal;">Ponderación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statsRows as $row)
                        <tr style="background: {{ $loop->iteration % 2 == 0 ? '#f9fafb' : '#ffffff' }}; color: #000;">
                            <td style="padding: 3px; border: 1px solid #e5e7eb;">{{ $row->id }}</td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb;">${{ number_format($row->offer, 2) }}
                            </td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb; font-weight: bold;">${{
                                number_format($row->val_hom, 2) }}</td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb;">{{ number_format($row->fre, 2) }}</td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb; background: #e5e7eb;">{{
                                number_format($row->deviation, 2) }}</td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb; background: #e5e7eb;">{{
                                number_format(($row->weight ?? 0) * 100, 2) }}%</td>
                            <td
                                style="padding: 3px; border: 1px solid #e5e7eb; background: #d1d5db; font-weight: bold;">
                                ${{ number_format($row->weighted_val ?? 0, 2) }}</td>
                        </tr>
                        @endforeach

                        {{-- FILA DE PROMEDIOS --}}
                        <tr style="background: #6b7280; color: white; font-weight: bold;">
                            <td style="padding: 3px; border: 1px solid #d1d5db; text-align: right;">Promedios:</td>
                            <td style="padding: 3px; border: 1px solid #d1d5db;">${{
                                number_format($stats['offers']['avg'], 2) }}</td>
                            <td style="padding: 3px; border: 1px solid #d1d5db;">${{
                                number_format($stats['homologated']['avg'], 2) }}</td>
                            <td style="padding: 3px; border: 1px solid #d1d5db;">{{ number_format($stats['avg_fre'], 2)
                                }}</td>
                            <td style="padding: 3px; border: 1px solid #d1d5db;">-</td>
                            <td style="padding: 3px; border: 1px solid #d1d5db;">100.00%</td>
                            <td style="padding: 3px; border: 1px solid #d1d5db;">${{
                                number_format($stats['homologated']['avg'], 2) }}</td>
                        </tr>

                        <tr style="color: #000;">
                            <td style="padding: 2px; text-align: right; font-weight: bold;">Máximo:</td>
                            <td style="padding: 2px; font-weight: bold;">${{ number_format($stats['offers']['max'], 2)
                                }}</td>
                            <td style="padding: 2px; font-weight: bold;">${{ number_format($stats['homologated']['max'],
                                2) }}</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr style="color: #000;">
                            <td style="padding: 2px; text-align: right; font-weight: bold;">Mínimo:</td>
                            <td style="padding: 2px; font-weight: bold;">${{ number_format($stats['offers']['min'], 2)
                                }}</td>
                            <td style="padding: 2px; font-weight: bold;">${{ number_format($stats['homologated']['min'],
                                2) }}</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr style="color: #000;">
                            <td style="padding: 2px; text-align: right; font-weight: bold;">Diferencia:</td>
                            <td style="padding: 2px; font-weight: bold;">${{ number_format($stats['offers']['diff'], 2)
                                }}</td>
                            <td style="padding: 2px; font-weight: bold;">${{
                                number_format($stats['homologated']['diff'], 2) }}</td>
                            <td colspan="4"></td>
                        </tr>
                    </tbody>
                </table>
            </td>

            {{-- GRÁFICA Y RESULTADOS (DERECHA) - ANCHO 40% --}}
            <td style="width: 40%; text-align: center; padding-left: 10px; vertical-align: top;">
                {{-- CONTENEDOR DE GRÁFICA --}}
                <div style="margin-bottom: 5px;">
                    @if(isset($chartImageBase64) && $chartImageBase64)
                    {{-- CAMBIO AQUÍ: max-height bajó de 140px a 110px --}}
                    <img src="{{ $chartImageBase64 }}"
                        style="width: 100%; max-height: 80px; object-fit: contain; border: 1px solid #ccc;">
                    @else
                    {{-- CAMBIO AQUÍ TAMBIÉN: height bajó de 140px a 110px y el line-height igual --}}
                    <div
                        style="height: 80px; border: 1px dashed #ccc; background: #f9fafb; color: #ccc; line-height: 110px; font-size: 9px;">
                        Gráfica</div>
                    @endif
                </div>

                {{-- MEDIA ARITMÉTICA --}}
                <div
                    style="background: #6b7280; color: white; padding: 3px; text-align: right; font-size: 9px; font-weight: bold;">
                    Media aritmética: <span style="margin-left: 5px;">${{ number_format($stats['homologated']['avg'], 2) }}</span>
                </div>

                {{-- CONCLUSIÓN --}}
                <div
                    style="margin-top: 4px; text-align: right; font-size: 10px; font-weight: bold; color: #000; border-top: 2px solid #000;">
                    CONCLUSIÓN SOBRE LA INVESTIGACIÓN DE MERCADO:
                    <div style="font-size: 12px; margin-top: 2px; text-align: right; padding-right: 4px;">
                        ${{ number_format($valuation->homologationLandAttributes?->unit_value_mode_lot ??
                        $stats['homologated']['avg'], 2) }}
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- CONCLUSIONES FINALES --}}
{{-- <div style="margin-top: 10px;">
    <table
        style="width: 100%; border-collapse: collapse; border-top: 2px solid #6b7280; border-bottom: 2px solid #6b7280;">
        <tr>
            <td
                style="width: 60%; padding: 4px; text-align: right; font-size: 10px; color: white; background-color: #9ca3af;">
                Media aritmética:
            </td>
            <td
                style="width: 40%; padding: 4px; text-align: center; font-size: 10px; font-weight: bold; color: white; background-color: #9ca3af;">
                ${{ number_format($stats['homologated']['avg'] ?? 0, 2) }}
            </td>
        </tr>
        <tr>
            <td style="padding: 4px; text-align: right; font-size: 12px; color: #000;">
                CONCLUSIÓN SOBRE LA INVESTIGACIÓN DE MERCADO:
            </td>
            <td style="padding: 4px; text-align: center; font-size: 12px; font-weight: bold; color: #000;">
                ${{ number_format($valuation->homologationLandAttributes?->unit_value_mode_lot ??
                $stats['homologated']['avg'], 2) }}
            </td>
        </tr>
    </table>
</div>

 --}}
