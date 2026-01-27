{{-- ======================================================================= --}}
{{-- SECCIÓN: ELEMENTOS DE LA CONSTRUCCIÓN (CON ESTILOS GLOBALES) --}}
{{-- ======================================================================= --}}

<div style="margin-top: 10px; margin-bottom: 10px;">

    {{-- TÍTULO DE LA SECCIÓN --}}
    <div
        style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
        ELEMENTOS DE LA CONSTRUCCIÓN
    </div>

    {{-- 1. OBRA NEGRA --}}
   <div
    style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px;">
    Obra negra</div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Estructura:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->construction_structure ?? 'MIXTA MARCOS RIGIDOS DE CONCRETO ARMADO...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Cimentación:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->construction_foundation ?? 'SE SUPONE CAJÓN DE CONCRETO ARMADO' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Entrepisos:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->construction_mezzanines ?? 'SE SUPONE VIGUETA Y BOVEDILLA...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Techos:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->construction_roofs ?? 'SE SUPONE VIGUETA Y BOVEDILLA...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Muros:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->construction_walls ?? 'NO PRESENTA BLOCK HUECO DE CONCRETO...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Trabes y Col.:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->construction_beams ?? 'DE CONCRETO ARMADO' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Azoteas:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->construction_rooftops ?? 'IMPERMEABILIZADAS CON MATERIAL...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Bardas:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->construction_fences ?? 'DE CONCRETO ARMADO EN PLANTA BAJA' }}
            </td>
        </tr>
    </table>

    {{-- 2. REVESTIMIENTOS --}}

    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px;">
        Revestimientos y Acabados Interiores</div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Aplanados:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->finish_plaster ?? 'SALA: APLANADO DE YESO ACABADO LISO...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Plafones:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->finish_ceilings ?? 'SALA: APLANADO DE YESO ACABADO LISO...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Lambrines:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->finish_wainscoting ?? 'EN COCINA CON LOSETA DE MARMOL...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Escaleras:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->finish_stairs ?? 'PISOS: PROPIAS DEL EDIFICIO...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Pisos:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->finish_floors ?? 'SALA: LOSETA DE MARMOL DE 30 X 30...' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Zoclos:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->finish_skirting ?? 'PROPIO DEL PISO DE 5 CMS.' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Pintura:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->finish_paint ?? 'VINÍLICA EN GENERAL' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Recubrimientos:</td>
            <td class="value-cell" colspan="3"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->finish_special ?? 'NO PRESENTA' }}
            </td>
        </tr>
    </table>

    {{-- 3. MATRIZ DE ACABADOS (Separación de columnas arreglada) --}}
    <div style="margin-top: 15px;">
        {{-- Forzamos border-spacing horizontal para que los punteados no se toquen --}}
        <table style="width: 100%; border-collapse: separate; border-spacing: 5px 3px;">
            <thead>
                <tr>
                    <td style="width: 20%;"></td>
                    <td class="sub-header" style="width: 26%;">Pisos</td>
                    <td class="sub-header" style="width: 27%;">Muros</td>
                    <td class="sub-header" style="width: 27%;">Plafones</td>
                </tr>
            </thead>
            <tbody>
                {{-- Estancia Comedor --}}
                <tr>
                    <td class="label-cell">Estancia Comedor:</td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_living_floor ?? 'LOSETA DE MARMOL...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_living_walls ?? 'APLANADO DE YESO...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_living_ceiling ?? 'APLANADO DE YESO...' }}
                    </td>
                </tr>

                {{-- Cocina --}}
                <tr>
                    <td class="label-cell">Cocina:</td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_kitchen_floor ?? 'LOSETA DE MARMOL...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_kitchen_walls ?? 'APLANADO DE YESO...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_kitchen_ceiling ?? 'APLANADO DE YESO...' }}
                    </td>
                </tr>

                {{-- Recámara --}}
                <tr>
                    <td class="label-cell">
                        Recámara:<br><span style="font-size: 8px; font-weight: normal;">(Cantidad: 2)</span>
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_bedroom_floor ?? 'DUELA LAMINADA...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_bedroom_walls ?? 'APLANADO DE YESO...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_bedroom_ceiling ?? 'APLANADO DE YESO...' }}
                    </td>
                </tr>

                {{-- Baños --}}
                <tr>
                    <td class="label-cell">
                        Baños:<br><span style="font-size: 8px; font-weight: normal;">(Cantidad: 2)</span>
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_bath_floor ?? 'LOSETA DE MARMOL...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_bath_walls ?? 'APLANADO DE YESO...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_bath_ceiling ?? 'APLANADO DE YESO...' }}
                    </td>
                </tr>

                {{-- Patio Servicio --}}
                <tr>
                    <td class="label-cell">Patio Servicio:</td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_service_floor ?? 'LOSETA DE MARMOL...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_service_walls ?? 'APLANADO DE YESO...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_service_ceiling ?? 'APLANADO DE YESO...' }}
                    </td>
                </tr>

                {{-- Escaleras --}}
                <tr>
                    <td class="label-cell">Escaleras:</td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_stairs_floor ?? 'PROPIAS DEL EDIFICIO...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_stairs_walls ?? 'APLANADO ACABADO...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_stairs_ceiling ?? 'APLANADO ACABADO...' }}
                    </td>
                </tr>

                {{-- Estacionamiento --}}
                <tr>
                    <td class="label-cell">
                        Estacionamiento:<br><span style="font-size: 8px; font-weight: normal;">(Cantidad: 1)</span>
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_parking_floor ?? 'FIRME DE CONCRETO...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_parking_walls ?? 'CONCRETO APARENTE...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_parking_ceiling ?? 'APLANADO ACABADO...' }}
                    </td>
                </tr>

                {{-- Balcón --}}
                <tr>
                    <td class="label-cell">BALCÓN:</td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_balcony_floor ?? 'LOSETA CERÁMICA...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_balcony_walls ?? 'APLANADO ACABADO...' }}
                    </td>
                    <td class="value-cell"
                        style="background-color: transparent; border-bottom: 1px dotted #333; ">
                        {{ $valuation->area_balcony_ceiling ?? 'APLANADO ACABADO...' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Medios Baños --}}
    <table class="form-table">
        <tr>
            <td class="label-cell">Medios Baños:</td>
            <td class="value-cell"
                style="background-color: transparent; border-bottom: 1px dotted #333; ">
                {{ $valuation->area_half_baths ?? '0' }}
            </td>
        </tr>
    </table>

</div>
