{{-- ======================================================================= --}}
{{-- SECCIÓN: DECLARACIONES Y ADVERTENCIAS (PÁGINA 1 DEL PDF) --}}
{{-- ======================================================================= --}}

<div style="margin-top: 4px; margin-bottom: 20px;">
    {{-- DECLARACIONES Y ADVERTENCIAS --}}
    <div style="margin-top: 5px;">
        {{-- Título de la sección --}}
        <div
            style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
            DECLARACIONES Y ADVERTENCIAS
        </div>

        {{-- Tabla de Declaraciones --}}
        <b style="font-size:11px;">Declaraciones:</b>
        <br><br>
        <b style="font-size:11px;">SE REALIZARON LAS SIGUIENTES VERIFICACIONES:</b>
        <table style="width:100%; border-collapse:collapse;">
            {{-- 1. Identificación --}}
            <tr>
                <td class="text-right" style="width:110px; font-size:9px; padding-right:10px; vertical-align: top;">
                    {{ $dec_idDoc }}
                </td>
                <td class="uppercase" style="font-size:9px; vertical-align: top;">
                    LA IDENTIFICACIÓN FÍSICA DEL INMUEBLE COINCIDE CON LO SEÑALADO EN LA DOCUMENTACIÓN
                </td>
            </tr>
            {{-- 2. Superficies --}}
            <tr>
                <td class="text-right" style="padding-right:10px; padding-top:3px; vertical-align: top; font-size:9px;">
                    {{ $dec_areaDoc }}
                </td>
                <td class="uppercase" style="padding-top:3px; vertical-align: top; font-size:9px;">
                    LAS SUPERFICIES FISICAS OBSERVADAS COINCIDEN CON LA DOCUMENTACIÓN (CON LA APROXIMACIÓN ESPERADA PARA
                    ALCANCE DE AVALÚO).
                </td>
            </tr>
            {{-- 3. Estado Construcción --}}
            <tr>
                <td class="text-right" style="padding-right:10px; padding-top:3px; vertical-align: top; font-size:9px;">
                    {{ $dec_constState }}
                </td>
                <td class="uppercase" style="padding-top:3px; vertical-align: top; font-size:9px;">
                    SE VERIFICÓ EL ESTADO DE LA CONSTRUCCIÓN Y CONSERVACIÓN DEL INMUEBLE (CON EL ALCANCE ESPERADO PARA
                    EFECTOS DE AVALÚO).
                </td>
            </tr>
            {{-- 4. Ocupación --}}
            <tr>
                <td class="text-right" style="padding-right:10px; padding-top:3px; vertical-align: top; font-size:9px;">
                    {{ $dec_occupancy }}
                </td>
                <td class="uppercase" style="padding-top:3px; vertical-align: top; font-size:9px;">
                    EL ESTADO DE OCUPACIÓN DEL INMUEBLE Y SU USO
                </td>
            </tr>
            {{-- 5. Plan Urbano --}}
            <tr>
                <td class="text-right" style="padding-right:10px; padding-top:3px; vertical-align: top; font-size:9px;">
                    {{ $dec_urbanPlan }}
                </td>
                <td class="uppercase" style="padding-top:3px; vertical-align: top; font-size:9px;">
                    LA CONSTRUCCIÓN DEL INMUEBLE SEGÚN EL PLAN DE DESARROLLO URBANO VIGENTE (EN SU CASO).
                </td>
            </tr>
            {{-- 6. INAH --}}
            <tr>
                <td class="text-right" style="padding-right:10px; padding-top:3px; vertical-align: top; font-size:9px;">
                    {{ $dec_inahMonument }}
                </td>
                <td class="uppercase" style="padding-top:3px; vertical-align: top; font-size:9px;">
                    SI EL INMUEBLE ES CONSIDERADO MONUMENTO HISTÓRICO POR EL I.N.A.H.
                </td>
            </tr>
            {{-- 7. INBA --}}
            <tr>
                <td class="text-right" style="padding-right:10px; padding-top:3px; vertical-align: top; font-size:9px;">
                    {{ $dec_inbaHeritage }}
                </td>
                <td class="uppercase" style="padding-top:3px; vertical-align: top; font-size:9px;">
                    SI ES CONSIDERADO PATRIMONIO ARQUITECTÓNICO POR EL I.N.B.A.
                </td>
            </tr>
        </table>

        {{-- Texto de Advertencias --}}
        <div style="margin-top: 5px; font-size: 8px; text-align: justify; line-height: 1.1;">
            <b style="font-size: 11px;">Advertencias:</b>
            <p style="font-size: 10px;">Las verificaciones realizadas y señaladas en el apartado de "Declaraciones" se
                efectúan con las limitaciones señaladas en el apartado "Limitaciones del avalúo", posteriormente.</p>

            {{-- DINAMISMO DE OTRAS NOTAS --}}
            @if(!empty($otherNotes))
            <p style="font-size: 11px;">
                SEÑALAR AQUÍ OTRAS, EN SU CASO: <span style="font-weight: normal; text-transform: uppercase;">{{
                    $otherNotes }}</span>
            </p>
            @else
            <p style="font-size: 11px;">SEÑALAR AQUÍ OTRAS, EN SU CASO:</p>
            @endif
        </div>
    </div>

    {{-- TEXTO DE ADVERTENCIAS Y LIMITACIONES (FIXED TEXT) --}}
    <div style="margin-top: 10px; font-size: 9px; text-align: justify; color: #333; line-height: 1.3;">

        <div
            style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
            LIMITACIONES DEL AVALÚO
        </div>
        <p>
            El presente avalúo constituye un dictamen de valor para uso especifico del propósito expresado en la
            carátula del mismo, por lo tanto carece de validez si es utilizado para otros fines.
        </p>
        <p>
            El presente avalúo no constituye un dictamen estructural, de cimentación o de cualquier otra rama de la
            ingeniería civil o la arquitectura que no sea la valuación, por lo tanto no puede ser utilizado para fines
            relacionados con esas ramas ni se asume responsabilidad por vicios ocultos u otras características del
            inmueble
            que no puedan ser apreciadas en una visita normal de inspección física Para efectos de avalúo. Incluso
            cuando
            se aprecien algunas características que puedan constituir anomalías con respecto al estado de conservación
            normal -según la vida útil consumida- de un inmueble o a su estructura, el valuador no asume mayor
            responsabilidad que así indicarlo cuando son detectadas, ya que aunque se presenten estados de conservación
            malos o ruinosos, es obligación del valuador realizar el avalúo según los criterios y normas vigentes y
            aplicables según el propósito del mismo.
        </p>

        <p>
            No se realizaron investigaciones, excepto cuando así se indique en el avalúo, con respecto a la existencia
            de tuberías o almacenamientos de materiales peligrosos que puedan ser nocivos para la salud de las personas
            que habitan el inmueble o el estado del mismo, en el bien o en sus cercanías.
        </p>
        <p>
            Los nombres de solicitante, propietario así como los números de cuenta predial y agua y la ubicación del
            inmueble se señalan según la información proporcionada por el cliente al momento de solicitar el avalúo.
            Por lo tanto no se asume responsabilidad por errores, omisiones o diferencias con respecto a los datos
            registrados por autoridades oficiales, como lo puede ser el registro público de la propiedad y el comercio,
            catastro, u otros.
        </p>
        <p>
            Las superficies utilizadas en el avalúo son obtenidas de las fuentes indicadas en el mismo. Cuando se indica
            según medidas, corresponde a una medición física para efectos de avalúo, sin que esto represente un
            levantamiento exacto, considerando las variantes y hábitos de medición existentes, por lo que su resultado
            únicamente se destina para fines de cálculo del avalúo.
        </p>
        <p>
            La edad del inmueble se considera en base a la información documental existente (licencias de construcción,
            boleta predial, escrituras u otros) y en su caso, se estima en base a lo apreciado físicamente. Puede
            contabilizarse a partir del último mantenimiento mayor recibido.
        </p>
    </div>

    {{-- LIMITACIONES ADICIONALES (DINÁMICO) --}}
    @if(!empty($additionalLimits))
    <div style="margin-top: 10px; font-size: 9px; text-align: justify; color: #333; line-height: 1.3;">
        <b style="font-size: 10px;">LIMITACIONES ADICIONALES:</b><br>
        {!! nl2br(e($additionalLimits)) !!}
    </div>
    @endif
</div>


<div class="page-break"></div>

{{-- 1. CARACTERÍSTICAS (ENTORNO) --}}
<div style="margin-bottom: 10px;">
    <table style="width: 100%; border-bottom: 1px solid #adadad; margin-bottom: 5px;">
        <tr>
            <td style="font-weight:bold; font-size:10px; text-transform:uppercase; padding-bottom:2px;">
                Características
            </td>
            <td style="font-weight:bold; font-size:10px; text-transform:uppercase; text-align:right; padding-bottom:2px;">
                ENTORNO
            </td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Clasificación de zona:</td>
            <td class="value-cell value-half">{{ $urb_zoneClass }}</td>
            <td class="label-cell">Densidad de población:</td>
            <td class="value-cell value-half">{{ $urb_popDensity }}</td>
        </tr>
        <tr>
            <td class="label-cell">Uso de suelo:</td>
            <td class="value-cell value-half">{{ $urb_landUse }}</td>
            <td class="label-cell">Densidad hab.:</td>
            {{-- Usamos font-size un pelín más chico porque la descripción suele ser larga --}}
            <td class="value-cell value-half" style="font-size: 8px;">{{ $urb_housingDen }}</td>
        </tr>
        <tr>
            <td class="label-cell">Fuente uso de suelo:</td>
            <td class="value-cell value-half" style="font-size: 8px;">{{ strtoupper($urb_source) }}</td>
            <td class="label-cell">% Área libre:</td>
            <td class="value-cell value-half">{{ $urb_freeArea }}%</td>
        </tr>
        <tr>
            <td class="label-cell">Niveles permitidos:</td>
            <td class="value-cell value-half">{{ $urb_levels }}</td>
            <td class="label-cell">Reporte de Densidad:</td>
            <td class="value-cell value-half">{{ $urb_densityRep }}</td>
        </tr>
        <tr>
            <td class="label-cell">Uso construcciones:</td>
            <td class="value-cell value-half">{{ $urb_constUsage }}</td>
            <td class="label-cell">Niv. socioeconómico:</td>
            <td class="value-cell value-half">{{ $urb_socioLevel }}</td>
        </tr>
        <tr>
            <td class="label-cell">% Saturación zona:</td>
            <td class="value-cell value-half">{{ $urb_saturation }}%</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="label-cell">Vías de acceso:</td>
            <td class="value-cell" colspan="3" style="font-size: 8px; text-align: justify;">
                {{ strtoupper($urb_access) }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Construcciones:</td>
            <td class="value-cell" colspan="3" style="font-size: 8px; text-align: justify;">
                {{ strtoupper($urb_constDomin) }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Contaminación:</td>
            <td class="value-cell" colspan="3" style="font-size: 8px;">
                {{ strtoupper($urb_pollution) }}
            </td>
        </tr>
    </table>
</div>
{{-- 2. EQUIPAMIENTO URBANO --}}
<div style="margin-bottom: 10px;">
    <table style="width: 100%; border-bottom: 1px solid #adadad; margin-bottom: 5px;">
        <tr>
            <td style="font-weight:bold; font-size:10px; text-transform:uppercase; padding-bottom:2px;">
                Equipamiento Urbano
            </td>
            {{-- Puedes cambiar "Nivel 4" por algo dinámico si lo tienes, o dejarlo así --}}
            <td
                style="font-weight:bold; font-size:10px; text-transform:uppercase; text-align:right; padding-bottom:2px;">
                Nivel 4
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: separate; border-spacing: 5px 0;">
        {{-- FILA 1: IGLESIA - CENTRO - BANCOS --}}
        <tr>
            <td style="width: 33%;">
                <table class="form-table">
                    <tr>
                        <td class="label-top">Iglesia:</td>
                        <td class="value-top">{{ $eq_church }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 33%;">
                <table class="form-table">
                    <tr>
                        <td class="label-top">Centro Com:</td>
                        <td class="value-top">{{ $eq_commCenter }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 33%;">
                <table class="form-table">
                    <tr>
                        <td class="label-top">Bancos:</td>
                        <td class="value-top">{{ $eq_bank }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- FILA 2: PARQUES - ESCUELAS - MERCADO --}}
        <tr>
            {{-- Columna 1: PARQUES --}}
            <td style="width: 33%; vertical-align: top;">
                <div class="sub-header">Parques o jardines</div>
                <table class="form-table">
                    <tr>
                        <td class="label-top">Jardines:</td>
                        <td class="value-top">{{ $eq_gardens }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Parques:</td>
                        <td class="value-top">{{ $eq_parks }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Canchas:</td>
                        <td class="value-top">{{ $eq_courts }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Deportivo:</td>
                        <td class="value-top">{{ $eq_sportsCenter }}</td>
                    </tr>
                    {{-- Espaciador --}}
                    <tr>
                        <td class="label-top" style="color:transparent;">.</td>
                        <td class="value-top" style="background:transparent; color:transparent;">.</td>
                    </tr>
                </table>
            </td>

            {{-- Columna 2: ESCUELAS --}}
            <td style="width: 33%; vertical-align: top;">
                <div class="sub-header">Escuelas</div>
                <table class="form-table">
                    <tr>
                        <td class="label-top">Primarias:</td>
                        <td class="value-top">{{ $eq_primary }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Secundarias:</td>
                        <td class="value-top">{{ $eq_middle }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Prepas:</td>
                        <td class="value-top">{{ $eq_high }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Universidad:</td>
                        <td class="value-top">{{ $eq_univ }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Otras:</td>
                        <td class="value-top">{{ $eq_otherSch }}</td>
                    </tr>
                </table>
            </td>

            {{-- Columna 3: MERCADO --}}
            <td style="width: 33%; vertical-align: top;">
                <div class="sub-header">Mercado</div>
                <table class="form-table">
                    <tr>
                        <td class="label-top">Mercados:</td>
                        <td class="value-top">{{ $eq_market }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Super:</td>
                        <td class="value-top">{{ $eq_super }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Locales:</td>
                        <td class="value-top">{{ $eq_commSpaces }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Comerciales:</td>
                        <td class="value-top">{{ $eq_numComm }}</td>
                    </tr>
                    {{-- Espaciador --}}
                    <tr>
                        <td class="label-top" style="color:transparent;">.</td>
                        <td class="value-top" style="background:transparent; color:transparent;">.</td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- FILA 3: HOSPITALES - TRANSPORTE - PLAZA PÚBLICA --}}
        <tr>
            {{-- Columna 1: HOSPITALES --}}
            <td style="width: 33%; vertical-align: top;">
                <div class="sub-header">Hospitales</div>
                <table class="form-table">
                    <tr>
                        <td class="label-top">1er Nivel:</td>
                        <td class="value-top">{{ $eq_hosp1 }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">2do Nivel:</td>
                        <td class="value-top">{{ $eq_hosp2 }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">3er Nivel:</td>
                        <td class="value-top">{{ $eq_hosp3 }}</td>
                    </tr>
                </table>
            </td>

            {{-- Columna 2: TRANSPORTE (Aquí sí mostramos Mts/Min si existen) --}}
            <td style="width: 33%; vertical-align: top;">
                <div class="sub-header">Transporte</div>
                <table class="form-table">
                    <tr>
                        <td class="label-top">Urbano:</td>
                        <td class="value-top">{{ $eq_transUrb }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Frecuencia:</td>
                        <td class="value-top">{{ $eq_transFreq }}</td>
                    </tr>
                </table>
            </td>

            {{-- Columna 3: PLAZA PÚBLICA --}}
            <td style="width: 33%; vertical-align: top;">
                <div class="sub-header">Plaza pública</div>
                <table class="form-table">
                    <tr>
                        <td class="label-top">Plazas púb.:</td>
                        <td class="value-top">{{ $eq_plaza }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Ref. urbana:</td>
                        <td class="value-top">{{ $eq_refUrbana }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>


{{-- 3. INFRAESTRUCTURA --}}
<div style="margin-bottom: 10px;">
    <table style="width: 100%; border-bottom: 1px solid #adadad; margin-bottom: 5px;">
        <tr>
            <td style="font-weight:bold; font-size:10px; text-transform:uppercase; padding-bottom:2px;">
                Infraestructura disponible en la zona
            </td>
            <td
                style="font-weight:bold; font-size:10px; text-transform:uppercase; text-align:right; padding-bottom:2px;">
                Nivel 4
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: separate; border-spacing: 5px 0;">
        <tr>
            {{-- Columna Izquierda --}}
            <td style="width: 50%;">
                <table class="form-table">
                    <tr>
                        <td class="label-top">Vialidades:</td>
                        <td class="value-top">{{ $inf_vialidades }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Guarniciones:</td>
                        <td class="value-top">{{ $inf_guarniciones }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Alumbrado público:</td>
                        <td class="value-top">{{ $inf_alumbrado }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Red agua potable:</td>
                        <td class="value-top">{{ $inf_agua }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Red aguas resid.:</td>
                        <td class="value-top">{{ $inf_drenaje }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Drenaje pluvial:</td>
                        <td class="value-top">{{ $inf_drenaje_pluvial }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Otro desalojo:</td>
                        <td class="value-top">{{ $inf_otro_desalojo }}</td>
                    </tr>
                </table>
            </td>
            {{-- Columna Derecha --}}
            <td style="width: 50%;">
                <table class="form-table">
                    <tr>
                        <td class="label-top">Banquetas:</td>
                        <td class="value-top">{{ $inf_banquetas }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Gas Natural:</td>
                        <td class="value-top">{{ $inf_gas }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Vigilancia:</td>
                        <td class="value-top">{{ $inf_vigilancia }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Acometida elect.:</td>
                        <td class="value-top">{{ $inf_acometida_elec }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Drenaje calle:</td>
                        <td class="value-top">{{ $inf_drenaje_calle }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Sistema mixto:</td>
                        <td class="value-top">{{ $inf_sistema_mixto }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Suministro elec.:</td>
                        <td class="value-top">{{ $inf_suministro_elec }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

{{-- 4. OTROS SERVICIOS --}}
<div style="margin-bottom: 5px;">
    <div
        style="font-weight:bold; font-size:10px; border-bottom:1px solid #adadad; margin-bottom:5px; padding-bottom:2px; text-transform:uppercase;">
        Otros servicios
    </div>
    <table style="width: 100%; border-collapse: separate; border-spacing: 5px 0;">
        <tr>
            <td style="width: 50%;">
                <table class="form-table">
                    <tr>
                        <td class="label-top">Teléfonos sum.:</td>
                        <td class="value-top">{{ $inf_telefonos_sum }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Señalización:</td>
                        <td class="value-top">{{ $inf_senyalizacion }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Recolección:</td>
                        <td class="value-top">{{ $inf_recoleccion }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%;">
                <table class="form-table">
                    <tr>
                        <td class="label-top">Acometida tel.:</td>
                        <td class="value-top">{{ $inf_acometida_tel }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">Nomenclatura:</td>
                        <td class="value-top">{{ $inf_nomenclatura }}</td>
                    </tr>
                    <tr>
                        <td class="label-top">% Infraestructura:</td>
                        <td class="value-top">{{ $inf_porcentaje }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
