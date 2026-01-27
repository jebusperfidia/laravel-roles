{{-- ======================================================================= --}}
{{-- SECCIÓN: CARPINTERÍA, INSTALACIONES Y ENFOQUES (ALINEACIÓN CORREGIDA) --}}
{{-- ======================================================================= --}}

<div style="margin-top: 10px; margin-bottom: 10px;">

    {{-- 1. CARPINTERÍA --}}
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px;">
        Carpintería
    </div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Puertas de acceso:</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->woodwork_access_doors ?? 'MADERA DE TIPO TAMBOR ACABADO BARNIZ' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Puertas Interiores:</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->woodwork_interior_doors ?? 'MADERA DE TIPO TAMBOR ACABADO BARNIZ' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Muebles fijos (general):</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->woodwork_kitchen_furniture ?? 'COCINA INTEGRAL DE MDF CON CUBIERTA DE GRANITO...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Muebles fijos (recámaras):</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->woodwork_bedroom_closets ?? 'CLOSETS DE MADERA MDF BARNIZADA...' }}
            </td>
        </tr>
    </table>

    {{-- 2. INSTALACIONES HIDRÁULICAS, SANITARIAS Y ELÉCTRICAS --}}
    <div
        style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px; margin-top: 5px;">
        Instalaciones Hidráulicas, Sanitarias y Eléctricas
    </div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Muebles de Baño:</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->installations_bath_furniture ?? 'INODOROS CERÁMICOS DE UNA PIEZA...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">
                Ramaleos Hidráulicos:<br>
                <span style="font-size: 8px; font-weight: normal; color: #555;">(Tipo Oculta)</span>
            </td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->installations_hydraulic_pipes ?? 'RAMALEOS A BASE DE TUBERÍA DE PPR...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">
                Ramaleos Sanitarios:<br>
                <span style="font-size: 8px; font-weight: normal; color: #555;">(Tipo Oculta)</span>
            </td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->installations_sanitary_pipes ?? 'TUBERIA Y CONEXIONES DE P.V.C....' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">
                Instalaciones Eléctricas:<br>
                <span style="font-size: 8px; font-weight: normal; color: #555;">(Tipo Oculta)</span>
            </td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->installations_electric_wiring ?? 'TUBERIA POLIFLEX PARA CABLEADO...' }}
            </td>
        </tr>
    </table>

    {{-- 3. PUERTAS Y VENTANERÍA METÁLICA --}}
    <div
        style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px; margin-top: 5px;">
        Puertas y Ventanería Metálica
    </div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Puerta Patio Servicio:</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->metalwork_service_door ?? 'NO PRESENTA' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Ventanería:</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->metalwork_windows ?? 'ALUMINIO DE 2 PULGADAS...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Otros (Especificar):</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->metalwork_other ?? 'NO PRESENTA' }}
            </td>
        </tr>
    </table>

    {{-- 4. OTROS ELEMENTOS --}}
    <div
        style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px; margin-top: 5px;">
        Otros Elementos
    </div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Vidriería:</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->other_glassware ?? 'VIDRIO CLARO DE 6 MM...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Cerrajería:</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->other_locksmith ?? 'CHAPA DE SEGURIDAD EN ACCESO...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Fachadas:</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->other_facades ?? 'MODERNA DE LÍNEAS RECTAS...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Cuenta con elevador:</td>
            <td class="value-cell" colspan="3" style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->has_elevator ?? 'Existe.' }}
            </td>
        </tr>
    </table>

    {{-- 5. INSTALACIONES ESPECIALES (TABLA) --}}
    <div
        style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px; margin-top: 10px;">
        Instalaciones especiales, obras complementarias y elementos accesorios:
    </div>

    <div style="font-weight: bold; font-size: 10px; margin-bottom: 2px;">Privativas:</div>

    <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
        <thead>
            <tr style="background-color: #777; color: #fff; text-align: center; font-weight: bold;">
                <td style="width: 10%; border: 1px solid #fff; padding: 2px;">Clave</td>
                <td style="width: 45%; border: 1px solid #fff; padding: 2px;">Descripción</td>
                <td style="width: 10%; border: 1px solid #fff; padding: 2px;">Cant.</td>
                <td style="width: 15%; border: 1px solid #fff; padding: 2px;">Unidad</td>
                <td style="width: 10%; border: 1px solid #fff; padding: 2px;">Edad</td>
                <td style="width: 10%; border: 1px solid #fff; padding: 2px;">V. Útil</td>
            </tr>
        </thead>
        <tbody>
            {{-- DATA DUMMY PARA EJEMPLO --}}
            <tr style="background-color: #ddd;">
                <td style="padding: 3px; text-align: center;">EA09</td>
                <td style="padding: 3px;">Cocinas integrales movibles</td>
                <td style="padding: 3px; text-align: center;">1.00</td>
                <td style="padding: 3px; text-align: center;">PIEZA</td>
                <td style="padding: 3px; text-align: center;">11</td>
                <td style="padding: 3px; text-align: center;">25</td>
            </tr>
            <tr style="background-color: #eee;">
                <td style="padding: 3px; text-align: center;">OC17</td>
                <td style="padding: 3px;">Bodega privativa</td>
                <td style="padding: 3px; text-align: center;">1.00</td>
                <td style="padding: 3px; text-align: center;">PIEZA</td>
                <td style="padding: 3px; text-align: center;">11</td>
                <td style="padding: 3px; text-align: center;">70</td>
            </tr>
        </tbody>
    </table>

    {{-- 6. APLICABILIDAD DE LOS ENFOQUES --}}
    <div
        style="font-weight:bold; font-size:12px; color:#000; margin-top:15px; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
        APLICABILIDAD DE LOS ENFOQUES
    </div>

    {{-- Tabla de Enfoques --}}
    <table style="width: 100%; border-collapse: separate; border-spacing: 5px 0;">
       {{--  <tr>

            <td style="width: 33%;">
                <table class="form-table">
                    <tr>
                        <td class="label-cell" style="width: 45%;">Enfoque de mercado:</td>
                        <td class="value-cell"
                            style="text-align: center; font-weight: bold; border: 1px solid #ccc; background-color: #eee;">
                            SI SE APLICA
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 33%;">
                <table class="form-table">
                    <tr>
                        <td class="label-cell" style="width: 45%;">Enfoque de costos:</td>
                        <td class="value-cell"
                            style="text-align: center; font-weight: bold; border: 1px solid #ccc; background-color: #eee;">
                            SI SE APLICA
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 33%;">
                <table class="form-table">
                    <tr>
                        <td class="label-cell" style="width: 45%;">Enfoque de ingresos:</td>
                        <td class="value-cell"
                            style="text-align: center; font-weight: bold; border: 1px solid #ccc; background-color: #eee;">
                            NO SE APLICA
                        </td>
                    </tr>
                </table>
            </td>
        </tr> --}}

        <tr>
            <td style="width: 33%;">
                <table class="form-table">
                    <tr>
                        <td class="label-top">Enfoque de mercado:</td>
                        <td class="value-top">SI SE APLICA</td>
                    </tr>
                </table>
            </td>
            <td style="width: 33%;">
                <table class="form-table">
                    <tr>
                        <td class="label-top">Enfoque de costos:</td>
                        <td class="value-top">SI SE APLICA</td>
                    </tr>
                </table>
            </td>
            <td style="width: 33%;">
                <table class="form-table">
                    <tr>
                        <td class="label-top">Enfoque de ingresos:</td>
                        <td class="value-top">NO SE APLICA</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- 7. TEXTOS DE DEFINICIONES --}}
    <div style="margin-top: 15px;">
        <div style="font-size: 9px; text-align: justify; margin-bottom: 10px;">
            <span style="font-weight: bold;">Enfoque comparativo de mercado:</span><br>
            Este enfoque se basa en el uso de información que refleje las transacciones del mercado, se utiliza en los
            avalúos de bienes que pueden ser analizados con bienes comparables existentes en el mercado abierto, se basa
            en la investigación de la demanda de dichos bienes, operaciones de compraventa recientes, operaciones de
            renta o alquiler y que, mediante una homologación de los datos obtenidos, permiten al valuador estimar un
            valor de mercado.
        </div>
        <div style="font-size: 9px; text-align: justify;">
            <span style="font-weight: bold;">Enfoque de costos:</span><br>
            El valor unitario de reposición nuevo aplicado a cada tipo de construcción se determina tomando como
            referencia los valores unitarios publicados por empresas especializadas en costos por metro cuadrado de
            construcción, tales como los catálogos de costos BIMSA y PRISMA, realizando los ajustes necesarios para su
            adecuación al tipo de construcción valuado.
        </div>
    </div>

</div>
