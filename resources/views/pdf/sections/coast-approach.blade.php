{{-- ======================================================================= --}}
{{-- SECCIÓN: ENFOQUE DE MERCADO (DINÁMICO) --}}
{{-- ======================================================================= --}}

<div style="font-family: Arial, Helvetica, sans-serif; font-size: 9px;">

    {{-- 1. HEADER --}}
    <div
        style="font-weight:bold; font-size:12px; color:#000; margin-top:15px; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
        RESUMEN DEL ENFOQUE DE MERCADO
    </div>

    {{-- 2. VALOR DEL TERRENO POR COMPARACIÓN --}}
    <div style="margin-bottom: 8px;">
        <div style="font-weight: bold; font-size: 9px; border-bottom: 1px solid #adadad; margin-bottom: 3px;">
            Valor del terreno por comparación
        </div>
        <table class="form-table">
            <tr>
                <td class="label-cell" style="width: 20%;">Superficie de terreno:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">
                    {{ number_format($terrainSurface, 2) }} m²
                </td>
                <td class="label-cell" style="width: 20%;">Valor unitario de mercado:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">
                    $ {{ number_format($marketUnitValue, 2) }}
                </td>
            </tr>
            <tr>
                <td class="label-cell">Valor del terreno prop:</td>
                <td class="value-cell" style="text-align: right;">
                    $ {{ number_format($terrainValue, 2) }}
                </td>
                <td class="label-cell">Indiviso aplicable en %:</td>
                <td class="value-cell" style="text-align: right;">
                    {{ number_format($applicableUndividedPercent, 2) }} %
                </td>
            </tr>
            <tr>
                <td class="label-cell"></td>
                <td class="value-cell" style="background: transparent;"></td>
                <td class="label-cell">Importe total terreno:</td>
                <td class="value-cell" style="text-align: right; font-weight: bold;">
                    $ {{ number_format($totalTerrainAmount, 2) }}
                </td>
            </tr>
        </table>
    </div>

    {{-- 3. VALOR DEL EXCEDENTE DEL TERRENO (CONDICIONAL) --}}
    @if($showExcessSection)
    <div style="margin-bottom: 8px;">
        <div style="font-weight: bold; font-size: 9px; border-bottom: 1px solid #adadad; margin-bottom: 3px;">
            Valor del excedente del terreno
        </div>
        <table class="form-table">
            <tr>
                <td class="label-cell" style="width: 20%;">Valor Lote Privativo:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">
                    $ {{ number_format($valLotePrivativo, 2) }}
                </td>
                <td class="label-cell" style="width: 20%;">Valor Lote Tipo:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">
                    $ {{ number_format($valLoteTipo, 2) }}
                </td>
            </tr>
            <tr>
                <td class="label-cell">% Aplicable:</td>
                <td class="value-cell" style="text-align: right;">
                    {{ $surplusPercentage }} %
                </td>
                <td class="label-cell">Valor Terreno Excedente:</td>
                <td class="value-cell" style="text-align: right; font-weight: bold;">
                    $ {{ number_format($valTerrenoExcedente, 2) }}
                </td>
            </tr>
        </table>
    </div>
    @endif

    {{-- 4. VALOR DE LAS CONSTRUCCIONES POR COMPARACIÓN --}}
    <div style="margin-bottom: 15px;">
        <div style="font-weight: bold; font-size: 9px; border-bottom: 1px solid #adadad; margin-bottom: 3px;">
            Valor de las construcciones por comparación
        </div>
        <table class="form-table">
            <tr>
                <td class="label-cell" style="width: 20%;">Superficie construida vendible:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">
                    {{ number_format($saleableBuiltArea, 2) }} m²
                </td>
                <td class="label-cell" style="width: 20%;">Valor unitario de mercado:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">
                    $ {{ number_format($constructionMarketUnitValue, 2) }}
                </td>
            </tr>
            <tr>
                {{-- Si hay excedente, lo mostramos como parte del desglose o nota --}}
                <td colspan="2"></td>
                <td class="label-cell">Valor de las construcciones:</td>
                <td class="value-cell" style="text-align: right; font-weight: bold;">
                    {{-- Aquí solemos poner el valor base (sin excedente) o el total directo --}}
                    $ {{ number_format($baseConstructionValue, 2) }}
                </td>
            </tr>
        </table>

        {{-- Totales y Texto en Letra --}}
        <div style="text-align: right; margin-top: 5px;">
            <div style="font-weight: bold;">
                Valor del mercado de construcciones (Total):
                <span style="margin-left: 10px;">
                    $ {{ number_format($marketValueTotal, 2) }}
                </span>
            </div>
            <div style="font-size: 8px; text-transform: uppercase; margin-top: 2px;">
                {{ $amountInLetters ?? '(* CANTIDAD EN LETRA PENDIENTE *)' }}
            </div>
        </div>
    </div>

</div>



    {{-- ======================================================================= --}}
    {{-- SECCIÓN IV.A. ENFOQUE DE COSTOS (GRID TABLES) --}}
    {{-- ======================================================================= --}}


    {{-- ======================================================================= --}}
    {{-- SECCIÓN IV. ENFOQUE DE COSTOS --}}
    {{-- ======================================================================= --}}

    <div style="font-family: Arial, Helvetica, sans-serif; font-size: 9px; margin-top: 10px;">

        {{-- HEADER --}}
        <div style="font-weight: bold; font-size: 14px; color: #000; margin-bottom: 5px; text-transform: uppercase;">
            IV. ENFOQUE DE COSTOS
        </div>

        <div
            style="font-weight:bold; font-size:12px; color:#000; margin-top:15px; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
            APLICACIÓN DEL ENFOQUE DE COSTOS
        </div>

        {{-- A) DEL TERRENO --}}
        <div style="font-weight: bold; font-size: 9px; margin-bottom: 2px;">A) Del terreno</div>

        {{-- Tabla Grid Terreno --}}
        <table style="width: 100%; border-collapse: collapse; font-size: 8px; margin-bottom: 5px;">
            <thead>
                <tr style="background-color: #777; color: #fff; text-align: center;">
                    <td style="border: 1px solid #fff; padding: 2px;">Fracción</td>
                    <td style="border: 1px solid #fff; padding: 2px;">Superficie</td>
                    <td style="border: 1px solid #fff; padding: 2px;">Fzo</td>
                    <td style="border: 1px solid #fff; padding: 2px;">Fub</td>
                    <td style="border: 1px solid #fff; padding: 2px;">Ffr</td>
                    <td style="border: 1px solid #fff; padding: 2px;">Ffo</td>
                    <td style="border: 1px solid #fff; padding: 2px;">Fsu</td>
                    <td style="border: 1px solid #fff; padding: 2px;">Fre</td>
                    <td style="border: 1px solid #fff; padding: 2px;">Área de Valor</td>
                    <td style="border: 1px solid #fff; padding: 2px;">Val. Unit. Tierra</td>
                    <td style="border: 1px solid #fff; padding: 2px;">Valor de la Fracción</td>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: #eee; text-align: center;">
                    <td style="padding: 2px;">1</td>
                    {{-- Variable corregida: $landSurface --}}
                    <td style="padding: 2px;">{{ number_format($landSurface, 2) }}</td>
                    {{-- Factores estáticos (según tu ejemplo) --}}
                    <td style="padding: 2px;">1.00</td>
                    <td style="padding: 2px;">1.00</td>
                    <td style="padding: 2px;">1.00</td>
                    <td style="padding: 2px;">1.00</td>
                    <td style="padding: 2px;">1.00</td>
                    <td style="padding: 2px;">1.00</td>
                    <td style="padding: 2px;">A030323</td>
                    {{-- Variable corregida: $landUnitValue --}}
                    <td style="padding: 2px;">$ {{ number_format($landUnitValue, 2) }}</td>
                    {{-- Variable corregida: $landFractionValue --}}
                    <td style="padding: 2px; text-align: right;">$ {{ number_format($landFractionValue, 2) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Indiviso y Total Terreno --}}
        <table style="width: 100%; font-size: 8px; margin-bottom: 10px; border-collapse: separate; border-spacing: 0;">
            <tr>
                <td style="width: 18%; font-weight: bold; vertical-align: middle;">
                    % Indiviso (condominios):
                </td>
                <td
                    style="width: 20%; background-color: #e0e0e0; text-align: center; vertical-align: middle; padding: 2px;">
                    {{-- Variable corregida: $landIndiviso --}}
                    {{ number_format($landIndiviso, 4) }} %
                </td>
                <td style="width: 10%;"></td>
                <td style="text-align: right; vertical-align: top; color: #333;">
                    Se señalará indiviso sólo si se utiliza en el cálculo correspondiente
                </td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="text-align: right; font-weight: bold; font-size: 9px; padding-top: 5px;">
                    {{-- Variable corregida: $totalLandValueForSummary --}}
                    Valor del terreno: <span style="margin-left: 10px;">$ {{ number_format($totalLandValueForSummary, 2)
                        }}</span>
                </td>
            </tr>
        </table>

        {{-- B) DE LAS CONSTRUCCIONES --}}
        <div style="font-weight: bold; font-size: 9px; margin-bottom: 2px;">B) De las construcciones</div>

        <table style="width: 100%; border-collapse: collapse; font-size: 8px; margin-bottom: 5px;">
            <tr>
                <td style="width: 1%; white-space: nowrap; padding-right: 5px;">
                    Fuente de donde se obtuvo el valor de reposición nuevo:
                </td>
                <td style="background-color: #e0e0e0; padding-left: 5px; font-weight: bold;">
                    {{ $valuation->replacement_value_source ?? 'Varela M2 Costos Julio 2025' }}
                </td>
            </tr>
        </table>

        {{-- Construcciones Privativas --}}
        <div style="font-weight: bold; font-size: 8px; margin-bottom: 2px;">Privativas</div>
        <table style="width: 100%; border-collapse: collapse; font-size: 7px;">
            <thead>
                <tr style="background-color: #777; color: #fff; text-align: center;">
                    <td style="padding: 2px; width: 25%;">Descripción</td>
                    <td style="padding: 2px;">Clase SHF</td>
                    <td style="padding: 2px;">Uso</td>
                    <td style="padding: 2px;">Nivel</td>
                    <td style="padding: 2px;">Sup.</td>
                    <td style="padding: 2px;">CURN</td>
                    <td style="padding: 2px;">Fedad</td>
                    <td style="padding: 2px;">Fcons</td>
                    <td style="padding: 2px;">Avance</td>
                    <td style="padding: 2px;">Fres</td>
                    <td style="padding: 2px;">Costo U Neto</td>
                    <td style="padding: 2px;">Valor Parcial</td>
                </tr>
            </thead>
            <tbody>
                @forelse($privateConstructions as $item)
                <tr style="text-align: center; background-color: {{ $loop->odd ? '#ddd' : '#eee' }}">
                    <td style="text-align: left; padding: 2px;">{{ strtoupper($item->description) }}</td>
                    <td>{{ $item->clasification }}</td>
                    <td>{{ $item->use }}</td>
                    <td>{{ $item->levels }}</td>
                    <td>{{ number_format($item->surface, 2) }}</td>
                    <td>$ {{ number_format($item->unit_cost, 2) }}</td>
                    <td>{{ number_format($item->f_edad, 4) }}</td>
                    <td>{{ number_format($item->f_cons, 2) }}</td>
                    <td>{{ number_format($item->progress, 0) }}%</td>
                    <td>{{ number_format($item->f_res, 4) }}</td>
                    <td>$ {{ number_format($item->net_cost, 2) }}</td>
                    <td style="text-align: right;">$ {{ number_format($item->total_value, 2) }}</td>
                </tr>
                @empty
                <tr style="background-color: #eee;">
                    <td colspan="12" style="text-align:center;">Sin construcciones privativas</td>
                </tr>
                @endforelse

                {{-- Subtotal Row --}}
                <tr style="background-color: #888; color: #fff; font-weight: bold;">
                    <td colspan="4"></td>
                    <td style="text-align: center;">{{ number_format($privateConstructions->sum('surface'), 2) }}</td>
                    <td colspan="6"></td>
                    {{-- Variable corregida: $totalValueConstPrivate --}}
                    <td style="text-align: right; padding: 2px;">$ {{ number_format($totalValueConstPrivate, 2) }}</td>
                </tr>
            </tbody>
        </table>
        <div style="text-align: right; font-weight: bold; font-size: 8px; margin-top: 2px; margin-bottom: 5px;">
            Valor de las Construcciones Privativas: <span style="margin-left: 10px;">$ {{
                number_format($totalValueConstPrivate, 2) }}</span>
        </div>

        {{-- Construcciones Comunes (Solo si existen) --}}
        @if($commonConstructions->isNotEmpty())
        <div style="font-weight: bold; font-size: 8px; margin-bottom: 2px;">Comunes</div>
        <table style="width: 100%; border-collapse: collapse; font-size: 7px;">
            <thead>
                <tr style="background-color: #777; color: #fff; text-align: center;">
                    <td style="padding: 2px; width: 25%;">Descripción</td>
                    <td style="padding: 2px;">Clase SHF</td>
                    <td style="padding: 2px;">Uso</td>
                    <td style="padding: 2px;">Nivel</td>
                    <td style="padding: 2px;">Sup.</td>
                    <td style="padding: 2px;">CURN</td>
                    <td style="padding: 2px;">Fedad</td>
                    <td style="padding: 2px;">Indiviso</td>
                    <td style="padding: 2px;">Fcons</td>
                    <td style="padding: 2px;">Avance</td>
                    <td style="padding: 2px;">Fres</td>
                    <td style="padding: 2px;">Costo U Neto</td>
                    <td style="padding: 2px;">Valor Parcial</td>
                </tr>
            </thead>
            <tbody>
                @foreach($commonConstructions as $item)
                <tr style="text-align: center; background-color: {{ $loop->odd ? '#ddd' : '#eee' }}">
                    <td style="text-align: left; padding: 2px;">{{ strtoupper($item->description) }}</td>
                    <td>{{ $item->clasification }}</td>
                    <td>{{ $item->use }}</td>
                    <td>{{ $item->levels }}</td>
                    <td>{{ number_format($item->surface, 2) }}</td>
                    <td>$ {{ number_format($item->unit_cost, 2) }}</td>
                    <td>{{ number_format($item->f_edad, 4) }}</td>
                    <td>{{ number_format($landIndiviso, 4) }}</td> {{-- Usamos el indiviso general del terreno para
                    construcciones comunes --}}
                    <td>{{ number_format($item->f_cons, 2) }}</td>
                    <td>{{ number_format($item->progress, 0) }}%</td>
                    <td>{{ number_format($item->f_res, 4) }}</td>
                    <td>$ {{ number_format($item->net_cost, 2) }}</td>
                    <td style="text-align: right;">$ {{ number_format($item->total_value, 2) }}</td>
                </tr>
                @endforeach
                <tr style="background-color: #888; color: #fff; font-weight: bold;">
                    <td colspan="4"></td>
                    <td style="text-align: center;">{{ number_format($commonConstructions->sum('surface'), 2) }}</td>
                    <td colspan="7"></td>
                    <td style="text-align: right; padding: 2px;">$ {{ number_format($totalValueConstCommon, 2) }}</td>
                </tr>
            </tbody>
        </table>
        @endif

        {{-- Totales Construcciones --}}
        <table style="width: 100%; margin-top: 5px; font-size: 8px;">
            @if($commonConstructions->isNotEmpty())
            <tr>
                <td style="text-align: right;">% Indiviso en caso de condominio:</td>
                <td style="text-align: right; width: 20%; font-weight: bold;">% {{ number_format($landIndiviso, 4) }}</td>
            </tr>
            <tr>
                <td style="text-align: right;">Valor de las Construcciones Comunes:</td>
                <td style="text-align: right; width: 20%; font-weight: bold;">$ {{ number_format($totalValueConstCommon, 2)
                    }}</td>
            </tr>
            @endif
            <tr>
                <td style="text-align: right; font-weight: bold;">Suma (Privativas {{ $commonConstructions->isNotEmpty() ?
                    '+ Comunes' : '' }}):</td>
                {{-- Variable corregida: $subtotalConstrucciones --}}
                <td style="text-align: right; width: 20%; font-weight: bold;">$ {{ number_format($subtotalConstrucciones, 2)
                    }}</td>
            </tr>
        </table>

        {{-- C) INSTALACIONES ESPECIALES --}}
        <div style="font-weight: bold; font-size: 9px; margin-top: 10px; margin-bottom: 2px;">
            C) De las instalaciones especiales, elementos accesorios y obras complementarias
        </div>

        {{-- Privativas --}}
        <div style="font-weight: bold; font-size: 8px; margin-bottom: 2px;">Privativas:</div>
        <table style="width: 100%; border-collapse: collapse; font-size: 7px;">
            <thead>
                <tr style="background-color: #777; color: #fff; text-align: center;">
                    <td style="padding: 2px;">Clave</td>
                    <td style="padding: 2px; width: 30%;">Descripción</td>
                    <td style="padding: 2px;">Unidad</td>
                    <td style="padding: 2px;">Cant</td>
                    <td style="padding: 2px;">CURN</td>
                    <td style="padding: 2px;">F. Edad</td>
                    <td style="padding: 2px;">F. Cons.</td>
                    <td style="padding: 2px;">CUNR</td>
                    <td style="padding: 2px;">Valor Parcial</td>
                </tr>
            </thead>
            <tbody>
                @forelse($privateSpecialInst as $item)
                <tr style="text-align: center; background-color: {{ $loop->odd ? '#ddd' : '#eee' }}">
                    <td>{{ $item->key }}</td>
                    <td style="text-align: left;">{{ $item->description ?: $item->description_other }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ number_format($item->quantity, 2) }}</td>
                    <td>$ {{ number_format($item->new_rep_unit_cost, 2) }}</td>
                    <td>{{ number_format($item->age_factor, 4) }}</td>
                    <td>{{ number_format($item->conservation_factor, 2) }}</td>
                    <td>$ {{ number_format($item->net_rep_unit_cost, 2) }}</td>
                    <td style="text-align: right;">$ {{ number_format($item->amount, 2) }}</td>
                </tr>
                @empty
                <tr style="background-color: #eee;">
                    <td colspan="9" style="text-align:center;">Sin instalaciones privativas</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Comunes --}}
        @if($commonSpecialInst->isNotEmpty())
        <div style="font-weight: bold; font-size: 8px; margin-top: 5px; margin-bottom: 2px;">Comunes:</div>
        <table style="width: 100%; border-collapse: collapse; font-size: 7px;">
            <thead>
                <tr style="background-color: #777; color: #fff; text-align: center;">
                    <td style="padding: 2px;">Clave</td>
                    <td style="padding: 2px; width: 30%;">Descripción</td>
                    <td style="padding: 2px;">Cant</td>
                    <td style="padding: 2px;">CUNR</td>
                    <td style="padding: 2px;">% Ind</td>
                    <td style="padding: 2px;">Valor Físico</td>
                    <td style="padding: 2px;">Valor Prop.</td>
                </tr>
            </thead>
            <tbody>
                @foreach($commonSpecialInst as $item)
                <tr style="text-align: center; background-color: {{ $loop->odd ? '#ddd' : '#eee' }}">
                    <td>{{ $item->key }}</td>
                    <td style="text-align: left;">{{ $item->description ?: $item->description_other }}</td>
                    <td>{{ number_format($item->quantity, 2) }}</td>
                    <td>$ {{ number_format($item->net_rep_unit_cost, 2) }}</td>
                    <td>{{ number_format($item->undivided, 4) }}%</td>
                    <td>$ {{ number_format($item->amount, 2) }}</td>
                    <td style="text-align: right;">$ {{ number_format($item->prop_value, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif


        {{-- Footer Totales --}}
        <table style="width: 100%; margin-top: 5px; font-size: 8px; font-weight: bold;">
            <tr>
                <td style="text-align: right;">Valor de las Instalaciones Especiales Privativas:</td>
                <td style="text-align: right; width: 20%;">$ {{ number_format($totalValueInstPrivate, 2) }}</td>
            </tr>
            @if($totalValueInstCommonProp > 0)
            <tr>
                <td style="text-align: right;">Valor de las Instalaciones Comunes (Proporcional):</td>
                <td style="text-align: right; width: 20%;">$ {{ number_format($totalValueInstCommonProp, 2) }}</td>
            </tr>
            @endif
            <tr>
                <td style="text-align: right;">Valor total de las inst. especiales, obras comp. y elementos accesorios:</td>
                {{-- Variable corregida: $totalInstalacionesFinal --}}
                <td style="text-align: right; width: 20%;">$ {{ number_format($totalInstalacionesFinal, 2) }}</td>
            </tr>
            <tr>
                <td style="padding-top: 5px; text-align: right;">IMPORTE TOTAL DEL ENFOQUE DE COSTOS:</td>
                {{-- Variable corregida: $totalCostApproach --}}
                <td style="padding-top: 5px; text-align: right; font-size: 10px;">$ {{ number_format($totalCostApproach, 2)
                    }}</td>
            </tr>
        </table>

    </div>
