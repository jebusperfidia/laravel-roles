{{-- III. DESCRIPCIÓN GENERAL DEL INMUEBLE --}}
<div
    style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
    Descripción General del Inmueble
</div>

{{-- BLOQUE 1: USO Y NIVEL --}}
<div style="margin-bottom: 10px;">
    <table class="form-table">
        <tr>
            <td class="label-cell" style="font-size: 8px;">Uso actual:</td>
            <td class="value-cell" colspan="3" style="text-align: justify; line-height: 1.2; font-size: 8px;">
                {{ $valuation->property_use_description ?? 'LOTE DE TERRENO PLANO, DE FORMA IRREGULAR, DONDE SE
                DESPLANTA UN EDIFICIO MARCADO CON EL NÚMERO 34 DE LA CALLE INDEPENDENCIA...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell" style="font-size: 8px;">Espacio uso múltiple:</td>
            <td class="value-cell value-half" style="font-size: 8px;">NO EXISTE</td>
            <td class="label-cell" style="font-size: 8px;">Piso o nivel ubicación:</td>
            <td class="value-cell value-half" style="font-size: 8px;">{{ $valuation->property_level ?? '3' }}</td>
        </tr>
    </table>
</div>

{{-- BLOQUE 2: CONSTRUCCIONES PRIVATIVAS --}}
<div style="margin-bottom: 10px;">
    <div style="font-weight: bold; font-size: 10px; border-bottom: 1px solid #adadad; margin-bottom: 3px;">
        Clasificación de las construcciones privativas
    </div>
    <table style="width: 100%; border-collapse: collapse; font-size: 7.5px;">
        <tr style="background-color: #444; color: #fff; font-weight: bold; text-align: center;">
            <td style="border: 1px solid #000; padding: 2px;">DESCRIPCIÓN</td>
            <td style="border: 1px solid #000; padding: 2px;">CLASE SHF</td>
            <td style="border: 1px solid #000; padding: 2px;">USO</td>
            <td style="border: 1px solid #000; padding: 2px;">CLASE</td>
            <td style="border: 1px solid #000; padding: 2px;">SUPERFICIE</td>
            <td style="border: 1px solid #000; padding: 2px;">FUENTE</td>
            <td style="border: 1px solid #000; padding: 2px;">NIV. CPO.</td>
            <td style="border: 1px solid #000; padding: 2px;">NIV. TIPO</td>
            <td style="border: 1px solid #000; padding: 2px;">EDAD</td>
            <td style="border: 1px solid #000; padding: 2px;">AV. OB.</td>
            <td style="border: 1px solid #000; padding: 2px;">VMR</td>
            <td style="border: 1px solid #000; padding: 2px;">VUR</td>
            <td style="border: 1px solid #000; padding: 2px;">EDO CONSERVACIÓN</td>
        </tr>
        <tr style="text-transform: uppercase; text-align: center;">
            <td style="border: 1px solid #ccc; padding: 2px; text-align: left;">DEPARTAMENTO</td>
            <td style="border: 1px solid #ccc; padding: 2px;">MEDIA</td>
            <td style="border: 1px solid #ccc; padding: 2px;">H</td>
            <td style="border: 1px solid #ccc; padding: 2px;">3</td>
            <td style="border: 1px solid #ccc; padding: 2px;">74.01</td>
            <td style="border: 1px solid #ccc; padding: 2px;">ESCRITURAS</td>
            <td style="border: 1px solid #ccc; padding: 2px;">8</td>
            <td style="border: 1px solid #ccc; padding: 2px;">1</td>
            <td style="border: 1px solid #ccc; padding: 2px;">11</td>
            <td style="border: 1px solid #ccc; padding: 2px;">100</td>
            <td style="border: 1px solid #ccc; padding: 2px;">45</td>
            <td style="border: 1px solid #ccc; padding: 2px;">59</td>
            <td style="border: 1px solid #ccc; padding: 2px;">EFICIENTE O FUNCIONAL</td>
        </tr>
    </table>
</div>

{{-- BLOQUE 2.1: CONSTRUCCIONES COMUNES --}}
<div style="margin-bottom: 10px;">
    <div style="font-weight: bold; font-size: 10px; border-bottom: 1px solid #adadad; margin-bottom: 3px;">
        Clasificación de las construcciones comunes
    </div>
    <table style="width: 100%; border-collapse: collapse; font-size: 7.5px;">
        <tr style="background-color: #444; color: #fff; font-weight: bold; text-align: center;">
            <td style="border: 1px solid #000; padding: 2px;">DESCRIPCIÓN</td>
            <td style="border: 1px solid #000; padding: 2px;">CLASE SHF</td>
            <td style="border: 1px solid #000; padding: 2px;">USO</td>
            <td style="border: 1px solid #000; padding: 2px;">CLASE</td>
            <td style="border: 1px solid #000; padding: 2px;">SUPERFICIE</td>
            <td style="border: 1px solid #000; padding: 2px;">FUENTE</td>
            <td style="border: 1px solid #000; padding: 2px;">NIV. CPO.</td>
            <td style="border: 1px solid #000; padding: 2px;">NIV. TIPO</td>
            <td style="border: 1px solid #000; padding: 2px;">EDAD</td>
            <td style="border: 1px solid #000; padding: 2px;">AV. OB.</td>
            <td style="border: 1px solid #000; padding: 2px;">VMR</td>
            <td style="border: 1px solid #000; padding: 2px;">VUR</td>
            <td style="border: 1px solid #000; padding: 2px;">EDO CONSERVACIÓN</td>
        </tr>
        <tr style="text-transform: uppercase; text-align: center;">
            <td style="border: 1px solid #ccc; padding: 2px; text-align: left;">CIRCULACIONES VERTICALES Y
                ESTACIONAMIENTO</td>
            <td style="border: 1px solid #ccc; padding: 2px;">MEDIA</td>
            <td style="border: 1px solid #ccc; padding: 2px;">H</td>
            <td style="border: 1px solid #ccc; padding: 2px;">3</td>
            <td style="border: 1px solid #ccc; padding: 2px;">1,064.28</td>
            <td style="border: 1px solid #ccc; padding: 2px;">CÁLCULOS DEL PERITO</td>
            <td style="border: 1px solid #ccc; padding: 2px;">8</td>
            <td style="border: 1px solid #ccc; padding: 2px;">8</td>
            <td style="border: 1px solid #ccc; padding: 2px;">11</td>
            <td style="border: 1px solid #ccc; padding: 2px;">100</td>
            <td style="border: 1px solid #ccc; padding: 2px;">45</td>
            <td style="border: 1px solid #ccc; padding: 2px;">59</td>
            <td style="border: 1px solid #ccc; padding: 2px;">EFICIENTE O FUNCIONAL</td>
        </tr>
    </table>
</div>

{{-- BLOQUE 3: RESUMEN TÉCNICO ALINEADO (UNA SOLA TABLA DE 4 COLUMNAS) --}}
<div style="margin-bottom: 10px;">
    {{-- AQUÍ ESTÁ EL TRUCO: Una sola tabla para que las filas compartan altura --}}
    <table class="form-table" style="font-size: 8px;">
        {{-- Fila 1 --}}
        <tr>
            <td class="label-cell">Unidades rentables:</td>
            <td class="value-cell value-half">29</td>
            <td class="label-cell">Avance de obra general (%):</td>
            <td class="value-cell value-half">100.00</td>
        </tr>
        {{-- Fila 2 --}}
        <tr>
            <td class="label-cell">Unidades rentables en el núcleo de construcción:</td>
            <td class="value-cell value-half">1</td>
            <td class="label-cell">Avance de obra en áreas comunes en condiminio: (%)</td>
            <td class="value-cell value-half">100.00</td>
        </tr>
        {{-- Fila 3 --}}
        <tr>
            <td class="label-cell">Unidades rentables del conjunto(condominios):</td>
            <td class="value-cell value-half">29</td>
            <td class="label-cell">Clase general del inmueble:</td>
            <td class="value-cell value-half">MEDIA</td>
        </tr>
        {{-- Fila 4 (La de la derecha vacía para "brincar" espacio) --}}
        <tr>
            <td class="label-cell">Calidad de proyecto:</td>
            <td class="value-cell value-half">FUNCIONAL</td>
            {{-- Celdas vacías a la derecha para mantener estructura --}}
            <td class="label-cell"></td>
            <td class="value-cell value-half" style="background: transparent;"></td>
        </tr>
        {{-- Fila 5 --}}
        <tr>
            <td class="label-cell">Edad aproximada (ponderada en años):</td>
            <td class="value-cell value-half">11</td>
            <td class="label-cell">Vida útil remanente (ponderada) en años:</td>
            <td class="value-cell value-half">59</td>
        </tr>
        {{-- Fila 6 --}}
        <tr>
            <td class="label-cell">Estado de conservación:</td>
            <td class="value-cell value-half">BUENO</td>
            <td class="label-cell">Sup. Último nivel (%):</td>
            <td class="value-cell value-half">1.00</td>
        </tr>
    </table>
</div>

{{-- BLOQUE 4: SUPERFICIES (CAMBIADO TÍTULO Y ALINEADO IGUAL) --}}
<div style="margin-bottom: 10px;">
  <div
    style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
    Superficies
</div>
<div style="font-weight: bold; font-size: 10px; border-bottom: 1px solid #adadad; margin-bottom: 3px;">
   Superficie(s) inscrita(s) o asentada(s) en ESCRITURAS
</div>
    <table class="form-table" style="font-size: 8px;">
        <tr>
            <td class="label-cell">Cimentación:</td>
            <td class="value-cell value-half">LOSA DE CIMENTACIÓN DE CONCRETO ARMADO</td>
            <td class="label-cell">Estructura:</td>
            <td class="value-cell value-half">MIXTA MARCOS RÍGIDOS Y MUROS CARGA</td>
        </tr>
        <tr>
            <td class="label-cell">Muros:</td>
            <td class="value-cell value-half">BLOCK Y TABLAROCA</td>
            <td class="label-cell">Entrepisos:</td>
            <td class="value-cell value-half">VIGUETA Y BOVEDILLA</td>
        </tr>
    </table>
</div>

<div style="font-weight: bold; font-size: 10px; border-bottom: 1px solid #000; margin-bottom: 3px;">
    Terreno
</div>
<table class="form-table" style="font-size: 8px;">
    <tr>
        <td class="label-cell">Total del terreno:</td>
        <td class="value-cell value-half">LOSA DE CIMENTACIÓN DE CONCRETO ARMADO</td>
        <td class="label-cell">Lote privativo:</td>
        <td class="value-cell value-half">MIXTA MARCOS RÍGIDOS Y MUROS CARGA</td>
    </tr>
    <tr>
        <td class="label-cell">Indiviso (%):</td>
        <td class="value-cell value-half">BLOCK Y TABLAROCA</td>
        <td class="label-cell">Lote privativo tipo:</td>
        <td class="value-cell value-half">VIGUETA Y BOVEDILLA</td>
    </tr>
    <tr>
        <td class="label-cell">Lote proporcional:</td>
        <td class="value-cell value-half">BLOCK Y TABLAROCA</td>
    </tr>
</table>
</div>


<div style="font-weight: bold; font-size: 10px; border-bottom: 1px solid #adadad; margin-bottom: 3px;">
    Total de superficies
</div>
<table class="form-table" style="font-size: 8px;">
    <tr>
        <td class="label-cell">Terreno total:</td>
        <td class="value-cell value-half">LOSA DE CIMENTACIÓN DE CONCRETO ARMADO</td>
        <td class="label-cell">Superficie construida:</td>
        <td class="value-cell value-half">MIXTA MARCOS RÍGIDOS Y MUROS CARGA</td>
    </tr>
    <tr>
        <td class="label-cell">Indiviso (%):</td>
        <td class="value-cell value-half">BLOCK Y TABLAROCA</td>
        <td class="label-cell">Superficie accesoria:</td>
        <td class="value-cell value-half">VIGUETA Y BOVEDILLA</td>
    </tr>
    <tr>
        <td class="label-cell">Lote privativo:</td>
        <td class="value-cell value-half">BLOCK Y TABLAROCA</td>
        <td class="label-cell">Superficie vendible:</td>
        <td class="value-cell value-half">VIGUETA Y BOVEDILLA</td>
    </tr>
    <tr>
        <td class="label-cell">Lote proporcional:</td>
        <td class="value-cell value-half">BLOCK Y TABLAROCA</td>
    </tr>
</table>
</div>



<div class="page-break"></div>




<div style="margin-bottom: 10px;">
    <div
        style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
        Elementos de la construcción (DEPARTAMENTO)
    </div>
    <div style="font-weight: bold; font-size: 10px; border-bottom: 1px solid #adadad; margin-bottom: 3px;">
        Obra negra
    </div>
</div>
