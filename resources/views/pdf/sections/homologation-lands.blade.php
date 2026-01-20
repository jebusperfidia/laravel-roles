{{-- TÍTULO DE SECCIÓN --}}
<div style="border-bottom: 2px solid #25998b; padding-bottom: 4px; margin-bottom: 10px;">
    <span style="font-size: 11px; font-weight: bold; color: #25998b;">Homologación de terrenos</span>
    <span style="float: right; font-size: 8px; color: #666; font-weight: bold; margin-top: 3px;">INVESTIGACIÓN DE
        MERCADO TERRENOS DIRECTOS</span>
    <div style="clear: both;"></div>
</div>

{{-- BLOQUE SUJETO --}}
<div style="border: 1px solid #d1d5db; border-top: 3px solid #25998b; margin-bottom: 15px; background-color: #fdfdfd;">
    <div
        style="background: #f3f4f6; font-weight: bold; font-size: 8px; padding: 4px; border-bottom: 1px solid #d1d5db; color: #374151;">
        Características del bien a valuar (Sujeto)
    </div>
    <table style="width: 100%; font-size: 7.5px; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px; width: 55%; vertical-align: top; line-height: 1.4;">
                <strong style="color: #25998b;">Calle:</strong> {{ $valuation->property_street }} {{
                $valuation->property_abroad_number }}<br>
                <strong style="color: #25998b;">Colonia:</strong> {{ $valuation->property_colony }} |
                <strong>Estado:</strong> {{ $valuation->property_entity_name }}<br>
                <strong style="color: #25998b;">Superficie de Análisis:</strong> {{
                number_format($valuation->homologationLandAttributes->subject_surface_value ?? 0, 2) }} m²
            </td>
            <td style="width: 45%; vertical-align: top;">
                <table style="width: 100%; border-left: 1px solid #d1d5db; border-collapse: collapse;">
                    <tr style="background: #25998b; color: white;">
                        <th style="padding: 3px; border-bottom: 1px solid #d1d5db; font-size: 7px;">Descripción</th>
                        <th style="padding: 3px; border-bottom: 1px solid #d1d5db; font-size: 7px;">Siglas</th>
                        <th style="padding: 3px; border-bottom: 1px solid #d1d5db; font-size: 7px;">Calificación</th>
                    </tr>
                    @foreach($orderedHeaders as $header)
                    @if($header->acronym != 'FNEG')
                    <tr>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 2px 5px; color: #4b5563;">{{
                            $header->factor_name }}</td>
                        <td
                            style="border-bottom: 1px solid #e5e7eb; text-align: center; font-weight: bold; color: #374151;">
                            {{ $header->acronym }}</td>
                        <td
                            style="border-bottom: 1px solid #e5e7eb; text-align: center; font-weight: bold; color: #25998b;">
                            {{ number_format($header->rating, 2) }}</td>
                    </tr>
                    @endif
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
</div>

{{-- LA "SÚPER TABLA" DE COMPARABLES --}}
<div
    style="font-size: 8.5px; font-weight: bold; margin-bottom: 4px; color: #374151; border-left: 3px solid #25998b; padding-left: 5px;">
    Inmuebles comparables (Terrenos baldíos ofertados)
</div>

<table
    style="width: 100%; border-collapse: collapse; font-size: 6.5px; table-layout: fixed; border: 1px solid #25998b;">
    <thead>
        <tr style="background: #25998b; color: white;">
            <th style="width: 16%; border: 1px solid #1f7a6f; padding: 5px;">CONCEPTO</th>
            @foreach($landPivots as $index => $pivot)
            <th style="border: 1px solid #1f7a6f; padding: 5px;">Comparable {{ $index + 1 }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{-- FOTOS --}}
        <tr>
            <td
                style="border: 1px solid #e5e7eb; background: #f9fafb; font-weight: bold; padding: 4px; color: #25998b;">
                FOTO</td>
            @foreach($landPivots as $pivot)
            <td style="border: 1px solid #e5e7eb; text-align: center; padding: 4px;">
                @php
                $finalPath = null; $base64 = null;
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
                <img src="{{ $base64 }}" style="width: 85px; height: 55px; object-fit: cover; border: 1px solid #eee;">
                @else
                <div
                    style="height: 55px; background: #f3f4f6; color: #9ca3af; line-height: 55px; font-size: 6px; border: 1px dashed #ccc;">
                    SIN IMAGEN</div>
                @endif
            </td>
            @endforeach
        </tr>

        {{-- DATOS TÉCNICOS INTEGRALES --}}
        <tr>
            <td style="border: 1px solid #e5e7eb; background: #f9fafb; font-weight: bold; padding: 3px 5px;">MUNICIPIO
            </td>
            @foreach($landPivots as $pivot)
            <td style="border: 1px solid #e5e7eb; padding: 3px;">{{ $pivot->comparable->comparable_municipality }}</td>
            @endforeach
        </tr>
        <tr>
            <td style="border: 1px solid #e5e7eb; background: #f9fafb; font-weight: bold; padding: 3px 5px;">UBICACIÓN
            </td>
            @foreach($landPivots as $pivot)
            <td style="border: 1px solid #e5e7eb; padding: 3px; font-size: 5.5px;">{{
                Str::limit($pivot->comparable->comparable_street, 40) }}</td>
            @endforeach
        </tr>
        <tr>
            <td style="border: 1px solid #e5e7eb; background: #f9fafb; font-weight: bold; padding: 3px 5px;">FUENTE /
                TEL</td>
            @foreach($landPivots as $pivot)
            <td style="border: 1px solid #e5e7eb; padding: 2px; font-size: 5px;">
                {{ Str::limit($pivot->comparable->comparable_source, 20) }}<br>
                <strong>Tel:</strong> {{ $pivot->comparable->comparable_phone }}
            </td>
            @endforeach
        </tr>
        <tr>
            <td style="border: 1px solid #e5e7eb; background: #f9fafb; font-weight: bold; padding: 3px 5px;">OFERTA</td>
            @foreach($landPivots as $pivot)
            <td style="border: 1px solid #e5e7eb; padding: 3px; font-weight: bold; text-align: center;">${{
                number_format($pivot->comparable->comparable_offers, 2) }}</td>
            @endforeach
        </tr>
        <tr>
            <td style="border: 1px solid #e5e7eb; background: #f9fafb; font-weight: bold; padding: 3px 5px;">SUP.
                TERRENO M2</td>
            @foreach($landPivots as $pivot)
            <td style="border: 1px solid #e5e7eb; padding: 3px; text-align: center;">{{
                number_format($pivot->comparable->comparable_land_area, 2) }}</td>
            @endforeach
        </tr>
        <tr style="background: #f0fdfa;">
            <td style="border: 1px solid #e5e7eb; font-weight: bold; padding: 3px 5px; color: #0d9488;">V. UNITARIO</td>
            @foreach($landPivots as $pivot)
            <td style="border: 1px solid #e5e7eb; padding: 3px; text-align: center; font-weight: bold; color: #0d9488;">
                ${{ number_format($pivot->comparable->comparable_unit_value, 2) }}</td>
            @endforeach
        </tr>

        {{-- FILA DE ENCABEZADO DE FACTORES --}}
        <tr style="background: #4b5563; color: white;">
            <td style="border: 1px solid #374151; padding: 3px 5px; font-weight: bold;">FACTORES DE AJUSTE</td>
            @foreach($landPivots as $pivot)
            <td style="border: 1px solid #374151; padding: 0;">
                <table style="width: 100%; border-collapse: collapse; color: white; font-size: 5px;">
                    <tr>
                        <td style="width: 50%; text-align: center; border-right: 1px solid #6b7280; padding: 2px;">F.
                            Comp</td>
                        <td style="width: 50%; text-align: center; padding: 2px;">Aplicable</td>
                    </tr>
                </table>
            </td>
            @endforeach
        </tr>

        {{-- DESGLOSE DE CADA FACTOR --}}
        @foreach($orderedHeaders as $header)
        <tr>
            <td
                style="border: 1px solid #e5e7eb; background: #f9fafb; padding: 2px 5px; font-weight: bold; color: #4b5563;">
                {{ $header->acronym }}</td>
            @foreach($landPivots as $pivot)
            @php
            $fMap = $pivot->factors->keyBy('acronym');
            $fact = $fMap[$header->acronym] ?? null;
            @endphp
            <td style="border: 1px solid #e5e7eb; padding: 0;">
                <table style="width: 100%; border-collapse: collapse; font-size: 6px;">
                    <tr>
                        <td
                            style="width: 50%; text-align: center; border-right: 1px solid #f3f4f6; padding: 2px; color: #6b7280;">
                            {{ $fact ? number_format($fact->rating, 2) : '1.00' }}</td>
                        <td style="width: 50%; text-align: center; font-weight: bold; padding: 2px; color: #25998b;">{{
                            $fact ? number_format($fact->applicable, 2) : '1.00' }}</td>
                    </tr>
                </table>
            </td>
            @endforeach
        </tr>
        @endforeach

        {{-- RESULTANTE --}}
        <tr style="background: #f3f4f6; border-top: 2px solid #25998b;">
            <td style="border: 1px solid #d1d5db; padding: 4px 5px; font-weight: bold; color: #111;">FACTOR RESULTANTE
                (FRE)</td>
            @foreach($landPivots as $pivot)
            @php
            $fre = 1.0; $fMap = $pivot->factors->keyBy('acronym');
            foreach($orderedHeaders as $h) { $val = $fMap[$h->acronym]->applicable ?? 1.0; $fre *= $val; }
            @endphp
            <td
                style="border: 1px solid #d1d5db; text-align: center; font-weight: 800; color: #0d9488; font-size: 8px;">
                {{ number_format($fre, 4) }}</td>
            @endforeach
        </tr>
    </tbody>
</table>

{{-- GRÁFICA Y CONCLUSIONES --}}
<div style="margin-top: 15px; page-break-inside: avoid;">
    <table style="width: 100%;">
        <tr>
            {{-- TABLA ESTADÍSTICA --}}
            <td style="width: 45%; vertical-align: top;">
                <table style="width: 100%; border-collapse: collapse; font-size: 7px; border: 1px solid #ccc;">
                    <tr style="background: #25998b; color: white;">
                        <th style="padding: 4px; text-align: left;">Indicadores sobre V. Unitario Hom.</th>
                        <th style="padding: 4px; text-align: right;">Valor</th>
                    </tr>
                    <tr>
                        <td style="padding: 3px; border-bottom: 1px solid #eee;">Promedio Homologado:</td>
                        <td style="text-align: right; font-weight: bold;">${{ number_format($stats['avg'], 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px; border-bottom: 1px solid #eee;">Valor Máximo:</td>
                        <td style="text-align: right;">${{ number_format($stats['max'], 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px; border-bottom: 1px solid #eee;">Valor Mínimo:</td>
                        <td style="text-align: right;">${{ number_format($stats['min'], 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px; border-bottom: 1px solid #eee;">Desviación Estándar:</td>
                        <td style="text-align: right;">{{ number_format($stats['std_dev'], 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;">Coeficiente de Variación:</td>
                        <td style="text-align: right;">{{ number_format($stats['coef_var'], 2) }}%</td>
                    </tr>
                </table>
            </td>

            {{-- GRÁFICA --}}
            {{-- GRÁFICA --}}
            <td style="width: 55%; text-align: center; padding-left: 10px;">
                {{-- Si el controlador encontró la imagen, la pone --}}
                @if(isset($chartImageBase64) && $chartImageBase64)
                <img src="{{ $chartImageBase64 }}" style="width: 100%; height: auto; border: 1px solid #eee;">
                @else
                {{-- Si no existe el archivo chart_12_chart1.jpg, muestra esto --}}
                <div style="height: 120px; border: 1px dashed #ccc; color: #999; line-height: 120px; font-size: 7px;">
                    Gráfica no disponible
                </div>
                @endif
            </td>
        </tr>
    </table>
</div>

{{-- CONCLUSIÓN FINAL --}}
<div style="margin-top: 10px; border: 1px solid #25998b; border-radius: 4px; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="background: #f0fdfa; padding: 8px; width: 60%; font-size: 7.5px; color: #4b5563;">
                <strong>CONCLUSIÓN:</strong> Se determinó el valor unitario aplicando homologación de mercado conforme a
                las características del sujeto frente a los comparables analizados.
            </td>
            <td style="background: #25998b; color: white; padding: 8px; text-align: center; width: 40%;">
                <div style="font-size: 7px; text-transform: uppercase;">Valor Unitario Concluido</div>
                <div style="font-size: 14px; font-weight: 900;">${{
                    number_format($valuation->homologationLandAttributes->unit_value_mode_lot ?? 0, 2) }}</div>
            </td>
        </tr>
    </table>
</div>
