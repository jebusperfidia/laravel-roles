{{-- ======================================================================= --}}
{{-- SECCIÓN: ENFOQUE DE MERCADO - CONSTRUCCIONES (BUILDINGS) --}}
{{-- ======================================================================= --}}

{{-- Salto de página para que empiece limpio --}}
<div style="page-break-before: always;"></div>


{{-- TÍTULO DE SECCIÓN --}}
<div style="border-bottom: 2px solid #25998b; padding-bottom: 4px; margin-bottom: 10px;">
    <span style="font-size: 13px; color: #000; text-transform: uppercase;">III. Enfoque Comparativo de Mercado</span>
    <span style="float: right; font-size: 9.5px; color: #000; margin-top: 3px;">INVESTIGACIÓN DE MERCADO CONSTRUCCIONES
        EN VENTA</span>
    <div style="clear: both;"></div>
</div>

{{-- BLOQUE SUJETO (DATOS DEL INMUEBLE A VALUAR) --}}
<div style="border: 1px solid #d1d5db; border-top: 3px solid #25998b; margin-bottom: 15px; background-color: #fff;">
    <div
        style="background: #f3f4f6; font-size: 9.5px; padding: 4px; border-bottom: 1px solid #d1d5db; color: #000; font-weight: bold;">
        Características del bien a valuar (Sujeto)
    </div>
    <table style="width: 100%; font-size: 8.5px; border-collapse: collapse;">
        <tr>
            {{-- LADO IZQUIERDO: DATOS GENERALES (Replicando estructura exacta de imagen_529f9d) --}}
           <td style="width: 65%; vertical-align: top; padding: 0;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">

                {{-- FILA 1: CALLE --}}
                <tr>
                    <td style="padding: 2px 4px; text-align: right; width: 18%; color: #444;">Calle:</td>
                    <td style="padding: 2px 4px; font-weight: bold; background-color: #e5e7eb; color: #000;" colspan="3">
                        {{ strtoupper($valuation->property_street) }}
                        No Ext.: {{ $valuation->property_abroad_number ?: 'SIN NÚMERO' }}
                        No Int.: {{ $valuation->property_inside_number ?: '-' }}
                    </td>
                </tr>

                {{-- FILA 2: COLONIA Y ESTADO --}}
                <tr>
                    <td style="padding: 2px 4px; text-align: right; color: #444;">Colonia:</td>
                    <td style="padding: 2px 4px; font-weight: bold; background-color: #e5e7eb; color: #000; width: 45%;">
                        {{ strtoupper(($valuation->property_colony === 'no-listada' || $valuation->property_colony ===
                        'NO-LISTADA')
                        ? $valuation->property_other_colony
                        : $valuation->property_colony) }}
                    </td>
                    <td style="padding: 2px 4px; text-align: right; width: 12%; color: #444;">Estado:</td>
                    <td style="padding: 2px 4px; font-weight: bold; background-color: #fff; color: #000;">
                        {{ strtoupper($estadoInmueble ?? 'N/A') }}
                    </td>
                </tr>

                {{-- FILA 3: DELEG/MUN Y EDAD --}}
                <tr>
                    <td style="padding: 2px 4px; text-align: right; color: #444;">Deleg / Mun:</td>
                    <td style="padding: 2px 4px; font-weight: bold; background-color: #e5e7eb; color: #000;">
                        {{ strtoupper($municipioInmueble ?? '') }}
                    </td>
                    <td style="padding: 2px 4px; text-align: right; color: #444;">Edad:</td>
                    <td style="padding: 2px 4px; font-weight: bold; background-color: #e5e7eb; color: #000;">
                        {{ $valuation->property_age ? $valuation->property_age . ' años' : '-' }}
                    </td>
                </tr>

                {{-- FILA 4: CONJUNTO Y LOTE MODA --}}
                <tr>
                    <td style="padding: 2px 4px; text-align: right; color: #444;">Conjunto:</td>
                    <td style="padding: 2px 4px; font-weight: bold; background-color: #e5e7eb; color: #000;">
                        {{ $valuation->property_housing_complex ?: '-' }}
                    </td>
                    <td style="padding: 2px 4px; text-align: right; color: #444;">Lote moda:</td>
                    <td style="padding: 2px 4px; font-weight: bold; background-color: #e5e7eb; color: #000;">
                       {{ number_format($subjectBuildingInfo->lote_moda, 2) }} m2
                    </td>
                </tr>

                {{-- FILA 5: SUPERFICIES Y RELACIÓN T/C --}}
                <tr>
                    <td style="padding: 2px 4px; text-align: right; color: #444;">Superficie:</td>
                    <td colspan="3" style="padding: 0;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                {{-- Sup Terreno --}}
                                <td style="padding: 2px 4px; font-weight: bold; background-color: #e5e7eb; width: 30%;">
                                    {{ number_format($subjectBuildingInfo->superficie_terreno, 2) }} m2.
                                </td>

                                {{-- Sup Construida --}}
                                <td style="padding: 2px 4px; text-align: right; width: 25%; color: #444;">Sup. Construida:</td>
                                <td style="padding: 2px 4px; font-weight: bold; background-color: #e5e7eb; width: 20%;">
                                    {{ number_format($subjectBuildingInfo->superficie_const, 2) }} m2.
                                </td>

                                {{-- Relación T/C (Ya viene del objeto subjectBuildingInfo) --}}
                                <td style="padding: 2px 4px; text-align: right; width: 15%; color: #444;">Relación. T/C</td>
                                <td style="padding: 2px 4px; font-weight: bold; background-color: #e5e7eb; width: 10%;">
                                    {{ number_format($subjectBuildingInfo->relacion_tc, 3) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>

            {{-- LADO DERECHO: FACTORES DEL SUJETO (HEADERS) --}}
            <td style="width: 35%; vertical-align: top;">
                <table style="width: 100%; border-left: 1px solid #d1d5db; border-collapse: collapse;">
                    <tr style="background: #9ca3af; color: white;">
                        <th
                            style="padding: 3px; border-bottom: 1px solid #d1d5db; font-size: 8px; font-weight: normal; text-align: left;">
                            Descripción</th>
                        <th
                            style="padding: 3px; border-bottom: 1px solid #d1d5db; font-size: 8px; font-weight: normal;">
                            Iniciales</th>
                        <th
                            style="padding: 3px; border-bottom: 1px solid #d1d5db; font-size: 8px; font-weight: normal;">
                            Calificación</th>
                    </tr>
                  @foreach($orderedBuildingHeaders as $header)
                {{-- Filtramos: FNEG (porque no se califica al sujeto) y FCON/FC (Conservación) --}}
                @if(!in_array(strtoupper(trim($header->acronym)), ['FNEG', 'FCON', 'FC']))
                <tr>
                    <td style="border-bottom: 1px solid #fff; background: #e5e7eb; padding: 2px 5px; color: #000; font-weight: bold;">
                        {{ strtoupper($header->factor_name) }}
                    </td>
                    <td style="border-bottom: 1px solid #fff; background: #e5e7eb; text-align: center; color: #000;">
                        {{ $header->acronym }}
                    </td>
                    <td style="border-bottom: 1px solid #fff; background: #e5e7eb; text-align: center; font-weight: bold; color: #000;">
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

{{-- TÍTULO TABLA COMPARABLES --}}
<div style="font-size: 10px; margin-bottom: 4px; color: #000; border-left: 3px solid #25998b; padding-left: 5px;">
    Inmuebles comparables (Oferta de Mercado)
</div>

{{-- TABLA MAESTRA DE COMPARABLES DE CONSTRUCCIÓN --}}
<table style="width: 100%; border-collapse: collapse; font-size: 7px; table-layout: fixed; border: 1px solid #25998b;">
    <thead>
        <tr style="background: #9ca3af; color: white;">
            <th style="width: 18%; border: 1px solid #6b7280; padding: 4px; font-weight: normal;">CONCEPTO</th>
            @foreach($buildingPivots as $index => $pivot)
            <th style="border: 1px solid #6b7280; padding: 4px; font-weight: normal;">Comparable {{ $index + 1 }}</th>
            @endforeach
        </tr>
        <tr style="background: #e5e7eb; color: #000;">
            <th style="border: 1px solid #d1d5db; padding: 2px;">ID / CLAVE</th>
            @foreach($buildingPivots as $pivot)
            <th style="border: 1px solid #d1d5db; padding: 2px; font-weight: bold;">{{ $pivot->comparable->id ?? '-' }}
            </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
        // Estilos estándar para reutilizar
        $rowStyle1 = 'border: 1px solid #e5e7eb; padding: 2px; font-size: 7px; color: #000;';
        $rowStyleBg = 'border: 1px solid #e5e7eb; background: #f9fafb; padding: 2px; font-size: 7px; color: #000;';
        // Estilo para la primera columna (etiquetas)
        $labelStyle = 'border: 1px solid #e5e7eb; background: #f3f4f6; padding: 2px 4px; color: #000; font-weight:
        bold;';
        @endphp

        {{-- 1. FOTO --}}
        <tr>
            <td style="border: 1px solid #e5e7eb; background: #f9fafb; padding: 4px; color: #000;">FOTO</td>
            @foreach($buildingPivots as $pivot)
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
                    SIN FOTO
                </div>
                @endif
            </td>
            @endforeach
        </tr>

        {{-- 2. CARACTERÍSTICAS --}}
        <tr>
            <td style="{{ $labelStyle }}">CARACTERÍSTICAS</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyle1 }} text-transform: uppercase; font-weight: bold;">
                {{ Str::limit($pivot->comparable->comparable_features, 35) }}
            </td>
            @endforeach
        </tr>

        {{-- 3. CALLE Y NÚMERO --}}
        <tr>
            <td style="{{ $labelStyle }}">CALLE Y NÚMERO</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyleBg }} font-weight: bold;">{{ Str::limit($pivot->comparable->comparable_street, 35) }}
            </td>
            @endforeach
        </tr>

        {{-- 4. COLONIA Y C.P. --}}
        <tr>
            <td style="{{ $labelStyle }}">COLONIA Y C.P.</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyle1 }}">{{ $pivot->comparable->comparable_colony }} {{
                $pivot->comparable->comparable_cp }}</td>
            @endforeach
        </tr>

        {{-- 5. MUNICIPIO --}}
        <tr>
            <td style="{{ $labelStyle }}">MUNICIPIO</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyleBg }} font-weight: bold; text-transform: uppercase;">
                {{ $pivot->comparable->resolved_municipality ?? ($pivot->comparable->comparable_locality ?: '-') }}
            </td>
            @endforeach
        </tr>

        {{-- 6. ENTIDAD --}}
        <tr>
            <td style="{{ $labelStyle }}">ENTIDAD</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyle1 }} font-weight: bold; text-transform: uppercase;">
                {{ $pivot->comparable->resolved_state ?? ($pivot->comparable->comparable_entity ?: '-') }}
            </td>
            @endforeach
        </tr>

        {{-- 7. FUENTE / URL --}}
        <tr>
            <td style="{{ $labelStyle }}">FUENTE / URL</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyleBg }} font-size: 6px;">{{ Str::limit($pivot->comparable->comparable_url ?? 'N/A',
                25) }}</td>
            @endforeach
        </tr>

        {{-- 8. TELÉFONO --}}
        <tr>
            <td style="{{ $labelStyle }}">TELÉFONO</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyle1 }}">{{ $pivot->comparable->comparable_phone ?? '-' }}</td>
            @endforeach
        </tr>

        {{-- 9. OFERTA --}}
        <tr>
            <td style="{{ $labelStyle }}">OFERTA ($)</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyleBg }} font-weight: bold;">${{ number_format($pivot->comparable->comparable_offers, 2)
                }}</td>
            @endforeach
        </tr>

        {{-- 10. CLASE --}}
        <tr>
            <td style="{{ $labelStyle }}">CLASE</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyle1 }}">{{ $pivot->comparable->comparable_class ?? 'Media' }}</td>
            @endforeach
        </tr>

        {{-- 11. CONSERVACION --}}
        <tr>
            <td style="{{ $labelStyle }}">CONSERVACIÓN</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyleBg }}">{{ $pivot->comparable->comparable_conservation ?? 'Bueno' }}</td>
            @endforeach
        </tr>

        {{-- 12. NIVELES --}}
        <tr>
            <td style="{{ $labelStyle }}">NIVELES</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyle1 }}">{{ $pivot->comparable->levels ?? $pivot->comparable->comparable_levels ?? 1 }}
            </td>
            @endforeach
        </tr>

        {{-- 13. EDAD --}}
        <tr>
            <td style="{{ $labelStyle }}">EDAD</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyleBg }}">{{ $pivot->comparable->comparable_age ?? 0 }} años</td>
            @endforeach
        </tr>

        {{-- 14. VUR --}}
        <tr>
            <td style="{{ $labelStyle }}">VUR</td>
            @foreach($buildingPivots as $pivot)
            @php
            $vidaTotal = $pivot->comparable->life_span ?? 60;
            $edad = $pivot->comparable->comparable_age ?? 0;
            $vur = max($vidaTotal - $edad, 0);
            @endphp
            <td style="{{ $rowStyle1 }} font-weight: bold;">{{ $vur }} años</td>
            @endforeach
        </tr>

        {{-- 15. SUP CONSTRUIDA M2 --}}
        <tr>
            <td style="{{ $labelStyle }}">SUP. CONSTRUIDA M2</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyleBg }} font-weight: bold;">{{
                number_format($pivot->comparable->comparable_construction_area, 2) }}</td>
            @endforeach
        </tr>

        {{-- 16. SUP TERRENO M2 --}}
        <tr>
            <td style="{{ $labelStyle }}">SUP. TERRENO M2</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyle1 }} font-weight: bold;">{{ number_format($pivot->comparable->comparable_land_area,
                2) }}</td>
            @endforeach
        </tr>

        {{-- 17. RELACIÓN T/C --}}
        <tr>
            <td style="{{ $labelStyle }}">RELACIÓN T/C</td>
            @foreach($buildingPivots as $pivot)
            @php
            $st = $pivot->comparable->comparable_land_area ?? 0;
            $sc = $pivot->comparable->comparable_construction_area ?? 0;
            $relTC = ($sc > 0) ? ($st / $sc) : 0;
            @endphp
            <td style="{{ $rowStyleBg }}">{{ number_format($relTC, 2) }}</td>
            @endforeach
        </tr>

        {{-- 18. V. UNITARIO --}}
        <tr style="border-top: 1px solid #ccc;">
            <td style="{{ $labelStyle }}">V. UNITARIO</td>
            @foreach($buildingPivots as $pivot)
            {{-- Mantenemos el azulito claro aquí para que resalte el valor de oferta --}}
            <td style="{{ $rowStyle1 }} font-weight: bold;">
                ${{ number_format($pivot->comparable->comparable_unit_value ?? 0, 2) }}
            </td>
            @endforeach
        </tr>

        <tr style="border-bottom: 1px solid #ccc;">
            <td style="{{ $labelStyle }}">V. UNIT. HOMOLOGADO</td>
            @foreach($buildingPivots as $pivot)
            <td style="{{ $rowStyleBg }} font-weight: bold;">
                ${{ number_format($pivot->calculated_vuh, 2) }}
            </td>
            @endforeach
        </tr>


        {{-- 20. FNEG (Factor Negociación) --}}
 <tr>
    <td style="{{ $labelStyle }}">FNEG</td>
    @foreach($buildingPivots as $pivot)
    @php
    $fnegObj = $pivot->factors_mapped['FNEG'] ?? null;
    // USAMOS EL APLICABLE (0.99)
    $fnegVal = $fnegObj ? $fnegObj->applicable : 1.00;
    @endphp
    <td style="{{ $rowStyle1 }} font-weight: bold;">{{ number_format($fnegVal, 2) }}</td>
    @endforeach
</tr>

      {{-- SEPARADOR FACTORES --}}
        <tr style="background: #9ca3af; color: white;">
            <td style="text-align: center; padding: 2px;">FACTORES</td>
            @foreach($buildingPivots as $pivot)
            <td style="padding: 0;">
                <table style="width: 100%; border-collapse: collapse; color: white; font-size: 6px;">
                    <tr>
                        <td style="width: 50%; text-align: center; border-right: 1px solid #d1d5db;">Factor</td>
                        <td style="width: 50%; text-align: center;">Aplicable</td>
                    </tr>
                </table>
            </td>
            @endforeach
        </tr>


        @foreach($orderedBuildingHeaders as $header)
        @if(strtoupper($header->acronym) != 'FNEG')
        <tr>
            <td style="{{ $labelStyle }}">{{ strtoupper($header->factor_name) }}</td>
            @foreach($buildingPivots as $pivot)
            @php
            $acr = strtoupper($header->acronym);
            $fact = $pivot->factors_map[$acr] ?? null;
            @endphp
            <td style="border: 1px solid #e5e7eb; padding: 0;">
                <table style="width: 100%; border-collapse: collapse; font-size: 7px;">
                    <tr>
                        <td style="width: 50%; text-align: center; border-right: 1px solid #e5e7eb; padding: 2px;">
                            {{ $fact ? number_format($fact->rating, 2) : '1.00' }}
                        </td>
                        <td style="width: 50%; text-align: center; font-weight: bold; padding: 2px;">
                            {{ $fact ? number_format($fact->applicable, 2) : '1.00' }}
                        </td>
                    </tr>
                </table>
            </td>
            @endforeach
        </tr>
        @endif
        @endforeach

        {{-- FRE TOTAL --}}
        <tr style="background: #f3f4f6; border-top: 1.5px solid #25998b;">
            <td style="{{ $labelStyle }}">FRE TOTAL</td>
            @foreach($buildingPivots as $pivot)
            <td
                style="border: 1px solid #d1d5db; text-align: center; font-weight: bold; color: #000; font-size: 8.5px; padding: 2px;">
                {{ number_format($pivot->calculated_fre, 2) }}
            </td>
            @endforeach
        </tr>
    </tbody>
</table>


<div style="margin-top: 15px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 60%; vertical-align: top;">
                <table
                    style="width: 100%; border-collapse: collapse; font-size: 8px; border: 1px solid #ccc; text-align: center;">
                    <thead>
                        <tr style="background: #9ca3af; color: white;">
                            <th style="padding: 3px; border: 1px solid #d1d5db;">Comparable</th>
                            <th style="padding: 3px; border: 1px solid #d1d5db;">Valor de Oferta</th>
                            <th style="padding: 3px; border: 1px solid #d1d5db;">Valor Unit Hom</th>
                            <th style="padding: 3px; border: 1px solid #d1d5db;">Factor de Ajuste</th>
                            <th style="padding: 3px; border: 1px solid #d1d5db;">Desviación</th>
                            <th style="padding: 3px; border: 1px solid #d1d5db;">Credibilidad</th>
                            <th style="padding: 3px; border: 1px solid #d1d5db;">Ponderación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buildingPivots as $pivot)
                        <tr style="background: {{ $loop->iteration % 2 == 0 ? '#f9fafb' : '#ffffff' }}; color: #000;">
                            <td style="padding: 3px; border: 1px solid #e5e7eb;">{{ $pivot->comparable->id ?? '-' }}
                            </td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb;">${{
                                number_format($pivot->comparable->comparable_offers ?? 0, 2) }}</td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb; font-weight: bold;">${{
                                number_format($pivot->calculated_vuh, 2) }}</td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb;">{{
                                number_format($pivot->calculated_fre, 2) }}</td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb;">{{
                                number_format($pivot->calculated_dev, 2) }}</td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb;">{{
                                number_format($pivot->calculated_cred, 2) }}%</td>
                            <td style="padding: 3px; border: 1px solid #e5e7eb;">${{
                                number_format($pivot->calculated_pond, 2) }}</td>
                        </tr>
                        @endforeach

                        {{-- FILA PROMEDIOS --}}
                        <tr style="background: #6b7280; color: white; font-weight: bold;">
                            <td style="padding: 3px; text-align: right;">Promedios:</td>
                            <td>${{ number_format($buildingPivots->avg(fn($p) => $p->comparable->comparable_offers ??
                                0), 2) }}</td>
                            <td>${{ number_format($buildingStats['avg'], 2) }}</td>
                            <td>{{ number_format($buildingPivots->avg('calculated_fre'), 2) }}</td>
                            <td>{{ number_format($buildingStats['sum_dev'], 2) }}</td>
                            <td>100.00%</td>
                            <td>${{ number_format($buildingStats['avg'], 2) }}</td>
                        </tr>

                        {{-- MÁXIMO, MÍNIMO Y DIFERENCIA (RECUPERADOS) --}}
                        <tr style="color: #000;">
                            <td style="padding: 3px; text-align: right; font-weight: bold;">Máximo:</td>
                            <td>${{ number_format($buildingStats['max_offer'], 2) }}</td>
                            <td style="font-weight: bold;">${{ number_format($buildingStats['max_vuh'], 2) }}</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr style="color: #000;">
                            <td style="padding: 3px; text-align: right; font-weight: bold;">Mínimo:</td>
                            <td>${{ number_format($buildingStats['min_offer'], 2) }}</td>
                            <td style="font-weight: bold;">${{ number_format($buildingStats['min_vuh'], 2) }}</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr style="color: #000; border-bottom: 1px solid #000;">
                            <td style="padding: 3px; text-align: right; font-weight: bold;">Diferencia:</td>
                            <td>${{ number_format($buildingStats['max_offer'] - $buildingStats['min_offer'], 2) }}</td>
                            <td style="font-weight: bold;">${{ number_format($buildingStats['max_vuh'] -
                                $buildingStats['min_vuh'], 2) }}</td>
                            <td colspan="4"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 40%; text-align: center; vertical-align: top; padding-left: 10px;">
                @if($chartBuildingImageBase64)
                <img src="{{ $chartBuildingImageBase64 }}"
                    style="width: 100%; max-height: 160px; border: 1px solid #ccc;">
                @endif
            </td>
        </tr>
    </table>
</div>

{{-- PIE DE TABLA (MEDIA ARITMÉTICA Y CONCLUSIÓN) --}}
<div style="margin-top: 10px; border-top: 2px solid #000;">
    <div style="background: #6b7280; color: white; padding: 4px; text-align: right; font-size: 10px;">
        Media aritmética: <span style="margin-left: 20px;">${{ number_format($buildingStats['avg'], 2) }}</span>
    </div>
    <div style="padding: 8px; text-align: right; font-size: 12px; font-weight: bold;">
        CONCLUSIÓN: <span style="margin-left: 20px;">${{
            number_format($valuation->homologationBuildingAttributes->unit_value_mode_lot ?? $buildingStats['avg'], 2)
            }}</span>
    </div>
</div>


<div class="page-break"></div>
