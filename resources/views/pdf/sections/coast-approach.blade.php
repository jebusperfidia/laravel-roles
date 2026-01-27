{{-- ======================================================================= --}}
{{-- SECCIÓN: ENFOQUE DE COSTOS (NUEVO ARCHIVO) --}}
{{-- ======================================================================= --}}

<div style="font-family: Arial, Helvetica, sans-serif; font-size: 9px; margin-top: 10px;">

    {{-- 1. HEADER: RESUMEN DEL ENFOQUE DE MERCADO --}}
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
                <td class="value-cell" style="width: 30%; text-align: right;">{{ $valuation->land_surface ?? '484.62' }}
                </td>
                <td class="label-cell" style="width: 20%;">Valor unitario de mercado:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">{{ $valuation->market_land_unit_value ??
                    '$ 38,130.00' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Valor del terreno prop:</td>
                <td class="value-cell" style="text-align: right;">{{ $valuation->prop_land_value ?? '$ 0.00' }}</td>
                <td class="label-cell">Indiviso aplicable en %:</td>
                <td class="value-cell" style="text-align: right;">{{ $valuation->undivided_percentage ?? '3.9100' }}
                </td>
            </tr>
            <tr>
                <td class="label-cell"></td>
                <td class="value-cell" style="background: transparent;"></td> {{-- Espacio vacío --}}
                <td class="label-cell">Importe total terreno:</td>
                <td class="value-cell" style="text-align: right; font-weight: bold;">{{ $valuation->total_land_amount ??
                    '$ 18,478,560.60' }}</td>
            </tr>
        </table>
    </div>

    {{-- 3. VALOR DEL EXCEDENTE DEL TERRENO --}}
    <div style="margin-bottom: 8px;">
        <div style="font-weight: bold; font-size: 9px; border-bottom: 1px solid #adadad; margin-bottom: 3px;">
            Valor del excedente del terreno
        </div>
        <table class="form-table">
            <tr>
                <td class="label-cell" style="width: 20%;">Sup. lote privativo tipo:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">{{ $valuation->private_lot_area ?? '0.00'
                    }}</td>
                <td class="label-cell" style="width: 20%;">Valor del lote privativo:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">{{ $valuation->private_lot_value ?? '$
                    0.00' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Sup.lote privativo:</td>
                <td class="value-cell" style="text-align: right;">{{ $valuation->lot_area ?? '0.00' }}</td>
                <td class="label-cell">Valor del lote privativo:</td>
                <td class="value-cell" style="text-align: right;">{{ $valuation->lot_value ?? '$ 0.00' }}</td>
            </tr>
            <tr>
                <td class="label-cell">% valor terreno excedente:</td>
                <td class="value-cell" style="text-align: right;">{{ $valuation->excess_land_pct ?? '100.00%' }}</td>
                <td class="label-cell">Excedente de terreno:</td>
                <td class="value-cell" style="text-align: right;">{{ $valuation->excess_land ?? '0.00' }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="label-cell">Valor Terreno Excedente:</td>
                <td class="value-cell" style="text-align: right;">{{ $valuation->excess_land_value ?? '$ 0.00' }}</td>
            </tr>
        </table>
    </div>

    {{-- 4. VALOR DE LAS CONSTRUCCIONES POR COMPARACIÓN --}}
    <div style="margin-bottom: 15px;">
        <div style="font-weight: bold; font-size: 9px; border-bottom: 1px solid #adadad; margin-bottom: 3px;">
            Valor de las construcciones por comparación
        </div>
        <table class="form-table">
            <tr>
                <td class="label-cell" style="width: 20%;">Superficie construida vendible:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">{{
                    $valuation->sellable_construction_surface ?? '81.99' }}</td>
                <td class="label-cell" style="width: 20%;">Valor unitario de mercado:</td>
                <td class="value-cell" style="width: 30%; text-align: right;">{{
                    $valuation->construction_market_unit_value ?? '$ 48,300.00' }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="label-cell">Valor de las construcciones:</td>
                <td class="value-cell" style="text-align: right; font-weight: bold;">{{ $valuation->constructions_value
                    ?? '$ 3,960,117.00' }}</td>
            </tr>
        </table>

        {{-- Totales y Texto en Letra --}}
        <div style="text-align: right; margin-top: 5px;">
            <div style="font-weight: bold;">Valor del mercado de construcciones: <span style="margin-left: 10px;">{{
                    $valuation->constructions_market_value_total ?? '$ 3,960,117.00' }}</span></div>
            <div style="font-size: 8px; text-transform: uppercase; margin-top: 2px;">{{ $valuation->amount_in_letters ??
                'TRES MILLONES NOVECIENTOS SESENTA MIL CIENTO DIECISIETE PESOS 00/100 M.N.' }}</div>
        </div>
    </div>


    {{-- ======================================================================= --}}
    {{-- SECCIÓN IV.A. ENFOQUE DE COSTOS (GRID TABLES) --}}
    {{-- ======================================================================= --}}

    {{-- Título de Sección con Borde Rojo/Naranja --}}
 {{--   <table style="width: 100%; margin-bottom: 5px; border-collapse: collapse;">
    <tr> --}}
        <div style="font-weight: bold; font-size: 14px; color: #000; margin-bottom: 5px; text-transform: uppercase;">
            IV. ENFOQUE DE COSTOS
        </div>

        <div
            style="font-weight:bold; font-size:12px; color:#000; margin-top:15px; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
            APLICACIÓN DEL ENFOQUE DE COSTOS
        </div>
    {{-- </tr> --}}
{{-- </table> --}}

    {{-- A) Del terreno --}}
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
                <td style="padding: 2px;">{{ $valuation->land_grid_surface ?? '484.62' }}</td>
                <td style="padding: 2px;">1.00</td>
                <td style="padding: 2px;">1.00</td>
                <td style="padding: 2px;">1.00</td>
                <td style="padding: 2px;">1.00</td>
                <td style="padding: 2px;">1.00</td>
                <td style="padding: 2px;">1.00</td>
                <td style="padding: 2px;">A030323</td>
                <td style="padding: 2px;">{{ $valuation->land_grid_unit_value ?? '$38,130.00' }}</td>
                <td style="padding: 2px; text-align: right;">{{ $valuation->land_grid_total_value ?? '$18,478,560.60' }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Indiviso y Total Terreno (AJUSTADO: INDIVISO COMO BLOQUE CERRADO) --}}
    <table style="width: 100%; font-size: 8px; margin-bottom: 10px; border-collapse: separate; border-spacing: 0;">
        <tr>
            {{-- Celda Label Indiviso --}}
            <td style="width: 18%; font-weight: bold; vertical-align: middle;">
                % Indiviso (condominios):
            </td>
            {{-- Celda Valor Indiviso (CAJA GRIS CERRADA) --}}
            <td style="width: 20%; background-color: #e0e0e0; text-align: center; vertical-align: middle; padding: 2px;">
                {{ $valuation->land_indiviso ?? '3.9100' }}
            </td>
            {{-- Espaciador --}}
            <td style="width: 10%;"></td>
            {{-- Nota a la derecha --}}
            <td style="text-align: right; vertical-align: top; color: #333;">
                Se señalará indiviso sólo si se utiliza en el cálculo correspondiente
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td style="text-align: right; font-weight: bold; font-size: 9px; padding-top: 5px;">
                Valor del terreno: <span style="margin-left: 10px;">{{ $valuation->final_land_value ?? '$ 722,511.72'
                    }}</span>
            </td>
        </tr>
    </table>

    {{-- B) De las construcciones --}}
    <div style="font-weight: bold; font-size: 9px; margin-bottom: 2px;">B) De las construcciones</div>
   {{-- Fuente (AJUSTADO: TABLA AL 100% PARA LLENAR EL RENGLÓN) --}}
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

    {{-- Privativas --}}
    <div style="font-weight: bold; font-size: 8px; margin-bottom: 2px;">Privativas</div>
    <table style="width: 100%; border-collapse: collapse; font-size: 7px;">
        <thead>
            <tr style="background-color: #777; color: #fff; text-align: center;">
                <td style="padding: 2px; width: 25%;">Descripción</td>
                <td style="padding: 2px;">Clase SHF</td>
                <td style="padding: 2px;">Uso</td>
                <td style="padding: 2px;">Rango nivel</td>
                <td style="padding: 2px;">Sup.</td>
                <td style="padding: 2px;">CURN</td>
                <td style="padding: 2px;">Fedad</td>
                <td style="padding: 2px;">Ind.cost. rem.</td>
                <td style="padding: 2px;">Fcons</td>
                <td style="padding: 2px;">Avance obra</td>
                <td style="padding: 2px;">Fres</td>
                <td style="padding: 2px;">Costo U Neto</td>
                <td style="padding: 2px;">Valor Parcial</td>
            </tr>
        </thead>
        <tbody>
            {{-- Loop through private constructions --}}
            <tr style="background-color: #ddd; text-align: center;">
                <td style="text-align: left; padding: 2px;">DEPARTAMENTO</td>
                <td>Media</td>
                <td>H</td>
                <td>10</td>
                <td>74.01</td>
                <td>$ 12,900.00</td>
                <td>0.8586</td>
                <td>0.89</td>
                <td>0.00</td>
                <td>100</td>
                <td>0.860</td>
                <td>$ 11,094.00</td>
                <td style="text-align: right;">$ 821,066.94</td>
            </tr>
            <tr style="background-color: #eee; text-align: center;">
                <td style="text-align: left; padding: 2px;">BALCÓN CUBIERTO</td>
                <td>Media</td>
                <td>H</td>
                <td>10</td>
                <td>7.98</td>
                <td>$ 12,900.00</td>
                <td>0.8586</td>
                <td>0.89</td>
                <td>0.00</td>
                <td>100</td>
                <td>0.860</td>
                <td>$ 11,094.00</td>
                <td style="text-align: right;">$ 88,530.12</td>
            </tr>
            {{-- Subtotal Row --}}
            <tr style="background-color: #888; color: #fff; font-weight: bold;">
                <td colspan="4"></td>
                <td style="text-align: center;">81.99</td>
                <td colspan="7"></td>
                <td style="text-align: right; padding: 2px;">$ 909,597.06</td>
            </tr>
        </tbody>
    </table>
    <div style="text-align: right; font-weight: bold; font-size: 8px; margin-top: 2px; margin-bottom: 5px;">
        Valor de las Construcciones Privativas: <span style="margin-left: 10px;">$ 909,597.06</span>
    </div>

    {{-- Comunes --}}
    <div style="font-weight: bold; font-size: 8px; margin-bottom: 2px;">Comunes</div>
    <table style="width: 100%; border-collapse: collapse; font-size: 7px;">
        <thead>
            <tr style="background-color: #777; color: #fff; text-align: center;">
                <td style="padding: 2px; width: 25%;">Descripcion</td>
                <td style="padding: 2px;">Clase SHF</td>
                <td style="padding: 2px;">Uso</td>
                <td style="padding: 2px;">Rango nivel</td>
                <td style="padding: 2px;">Sup.</td>
                <td style="padding: 2px;">CURN</td>
                <td style="padding: 2px;">Fedad</td>
                <td style="padding: 2px;">ind.cost. rem.</td>
                <td style="padding: 2px;">Indiviso</td>
                <td style="padding: 2px;">Fcons</td>
                <td style="padding: 2px;">Avance obra</td>
                <td style="padding: 2px;">Fres</td>
                <td style="padding: 2px;">Costo U Neto</td>
                <td style="padding: 2px;">Valor Parcial</td>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #ddd; text-align: center;">
                <td style="text-align: left; padding: 2px;">CIRCULACIONES VERTICALES Y ESTACIONAMIENTO</td>
                <td>Media</td>
                <td>H</td>
                <td>10</td>
                <td>1,064.28</td>
                <td>$ 12,900.00</td>
                <td>0.8586</td>
                <td>0.9</td>
                <td>3.9100</td>
                <td>0.00</td>
                <td>100</td>
                <td>0.860</td>
                <td>$ 11,094.00</td>
                <td style="text-align: right;">$ 11,807,122.32</td>
            </tr>
            <tr style="background-color: #888; color: #fff; font-weight: bold;">
                <td colspan="4"></td>
                <td style="text-align: center;">1,064.28</td>
                <td colspan="8"></td>
                <td style="text-align: right; padding: 2px;">$ 11,807,122.32</td>
            </tr>
        </tbody>
    </table>

    {{-- Totales Construcciones --}}
    <table style="width: 100%; margin-top: 5px; font-size: 8px;">
        <tr>
            <td style="text-align: right;">% Indiviso en caso de condominio:</td>
            <td style="text-align: right; width: 20%; font-weight: bold;">% 3.9100</td>
        </tr>
        <tr>
            <td style="text-align: right;">Valor de las Construcciones Comunes:</td>
            <td style="text-align: right; width: 20%; font-weight: bold;">$ 461,658.48</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold;">Suma (Privativas + Comunes Proporcional):</td>
            <td style="text-align: right; width: 20%; font-weight: bold;">$ 1,371,255.54</td>
        </tr>
    </table>

    {{-- C) Instalaciones Especiales --}}
    <div style="font-weight: bold; font-size: 9px; margin-top: 10px; margin-bottom: 2px;">
        C) De las instalaciones especiales, elementos accesorios y obras complementarias
    </div>

    <div style="font-weight: bold; font-size: 8px; margin-bottom: 2px;">Privativas:</div>
    <table style="width: 100%; border-collapse: collapse; font-size: 7px;">
        <thead>
            <tr style="background-color: #777; color: #fff; text-align: center;">
                <td style="padding: 2px;">Clave</td>
                <td style="padding: 2px; width: 30%;">Descripción</td>
                <td style="padding: 2px;">Unidad</td>
                <td style="padding: 2px;">Cantidad</td>
                <td style="padding: 2px;">CURN</td>
                <td style="padding: 2px;">Fact. Edad</td>
                <td style="padding: 2px;">Fact. Cons.</td>
                <td style="padding: 2px;">CUNR</td>
                <td style="padding: 2px;">Valor Parcial</td>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #ddd; text-align: center;">
                <td>EA09</td>
                <td style="text-align: left;">Cocinas integrales movibles</td>
                <td>PIEZA</td>
                <td>1.00</td>
                <td>$ 60,000.00</td>
                <td>0.6000</td>
                <td>1.00</td>
                <td>$ 36,000.00</td>
                <td style="text-align: right;">$ 36,000.00</td>
            </tr>
            <tr style="background-color: #eee; text-align: center;">
                <td>OC17</td>
                <td style="text-align: left;">Bodega privativa</td>
                <td>PIEZA</td>
                <td>1.00</td>
                <td>$ 65,000.00</td>
                <td>0.8586</td>
                <td>1.00</td>
                <td>$ 55,807.12</td>
                <td style="text-align: right;">$ 55,807.12</td>
            </tr>
        </tbody>
    </table>

    {{-- Footer Totales --}}
    <table style="width: 100%; margin-top: 5px; font-size: 8px; font-weight: bold;">
        <tr>
            <td style="text-align: right;">Valor de las Instalaciones Especiales, Obras Comp. y Elem. Acc. Privativas:
            </td>
            <td style="text-align: right; width: 20%;">$ 91,807.12</td>
        </tr>
        <tr>
            <td style="text-align: right;">Valor total de las inst. especiales, obras comp. y elementos accesorios
                (privativas + comunes):</td>
            <td style="text-align: right; width: 20%;">$ 91,807.12</td>
        </tr>
        <tr>
            <td style="padding-top: 5px; text-align: right;">IMPORTE TOTAL DEL ENFOQUE DE COSTOS:</td>
            <td style="padding-top: 5px; text-align: right; font-size: 10px;">$ 2,185,574.37</td>
        </tr>
    </table>

</div>
