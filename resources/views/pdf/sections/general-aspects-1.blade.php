{{-- I. ASPECTOS GENERALES --}}
<div
    style="font-weight: bold; font-size: 14px; border-bottom: text-transform: uppercase; margin-bottom: 5px;">
    I. ASPECTOS GENERALES
</div>

<div
    style="font-weight:bold; font-size:12px; color:#000; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
    ANTECEDENTES
</div>

{{-- 1. VALUADOR --}}
<div style="margin-bottom: 8px;">
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad; margin-bottom: 2px;">Valuador</div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Nombre:</td>
            <td class="value-cell" colspan="3">
                {{ $valuation->valuator ?? 'FRANCISCO JESÚS GUTIÉRREZ AGÜERO' }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Profesión:</td>
            <td class="value-cell value-half">ARQUITECTO</td>
            <td class="label-cell">Cédula prof.:</td>
            <td class="value-cell value-half">6753437</td>
        </tr>
        <tr>
            <td class="label-cell">Posgrado:</td>
            <td class="value-cell value-half">ESP. EN VALUACIÓN INMOBILIARIA</td>
            <td class="label-cell">Cédula prof.:</td>
            <td class="value-cell value-half">8693462</td>
        </tr>
    </table>
</div>

{{-- 2. SOLICITANTE (CORREGIDO CON LÓGICA DE CASCADA) --}}
<div style="margin-bottom: 8px;">
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad;; margin-bottom: 2px;">Solicitante
    </div>

    <table class="form-table">
        {{-- Fila 1: Nombre (Izq) | Colonia (Der - SUBIÓ) --}}
        <tr>
            <td class="label-cell">Nombre:</td>
            <td class="value-cell value-half">
                @if($valuation->applic_type_person === 'Moral')
                {{ $valuation->applic_company_name }}
                @else
                {{ $valuation->applic_name }} {{ $valuation->applic_first_name }} {{ $valuation->applic_second_name }}
                @endif
            </td>
            <td class="label-cell">Colonia:</td>
            <td class="value-cell value-half">
                {{ $valuation->applic_colony === 'no-listada' ? $valuation->applic_other_colony :
                $valuation->applic_colony }}
            </td>
        </tr>

        {{-- Fila 2: Calle (Izq) | C. Postal (Der - SUBIÓ) --}}
        <tr>
            <td class="label-cell">Calle y No.:</td>
            <td class="value-cell value-half">
                {{ $valuation->applic_street }}
                {{ $valuation->applic_abroad_number ? 'No. Ext: '.$valuation->applic_abroad_number : '' }}
                {{ $valuation->applic_inside_number ? 'Int: '.$valuation->applic_inside_number : '' }}
            </td>
            <td class="label-cell">C. Postal:</td>
            <td class="value-cell value-half">{{ $valuation->applic_cp }}</td>
        </tr>

        {{-- Fila 3: Alcaldía (Izq) | Teléfono (Der - SUBIÓ) --}}
        <tr>
            <td class="label-cell">Alcaldía:</td>
            <td class="value-cell value-half">{{ $municipioSolicitante }}</td>
            <td class="label-cell">Teléfono:</td>
            <td class="value-cell value-half">{{ $valuation->applic_phone ?? '-' }}</td>
        </tr>

        {{-- Fila 4: Entidad (Izq) | NSS (Der - SUBIÓ) --}}
        <tr>
            <td class="label-cell">Entidad:</td>
            <td class="value-cell value-half">{{ $estadoSolicitante }}</td>
            <td class="label-cell">N.S.S.:</td>
            <td class="value-cell value-half">{{ $valuation->applic_nss ?? '-' }}</td>
        </tr>

        {{-- Fila 5: RFC (Izq) | CURP (Der) - ¡AHORA SÍ ALINEADOS! --}}
        <tr>
            <td class="label-cell">R.F.C.:</td>
            <td class="value-cell value-half">{{ $valuation->applic_rfc ?? '-' }}</td>
            <td class="label-cell">C.U.R.P.:</td>
            <td class="value-cell value-half">{{ $valuation->applic_curp ?? '-' }}</td>
        </tr>
    </table>
</div>

{{-- 3. PROPÓSITO Y OBJETO --}}
<div style="margin-bottom: 8px;">
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad;; margin-bottom: 2px;">Propósito del
        avalúo</div>
    <table class="form-table">
        <tr>
            <td class="label-cell">Propósito:</td>
            <td class="value-cell value-half" style="font-size: 8px;">
                {{ $valuation->purpose === 'Otro' ? $valuation->purpose_other : $valuation->purpose }}
            </td>
            <td class="label-cell">Objeto:</td>
            <td class="value-cell value-half">
                {{ $valuation->objective }}
            </td>
        </tr>
    </table>
</div>

{{-- TÍTULO: INFORMACIÓN GENERAL --}}
<div
    style="font-weight:bold; font-size:12px; color:#000; margin-top: 10px; margin-bottom:5px; text-transform:uppercase; text-align:right; border-bottom:2px solid #25998b;">
    INFORMACIÓN GENERAL DEL INMUEBLE
</div>

{{-- 4. UBICACIÓN DEL INMUEBLE --}}
<div style="margin-bottom: 8px;">
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad;; margin-bottom: 2px;">Ubicación del
        inmueble</div>

    <table class="form-table">
        {{-- Calle (Full) --}}
        <tr>
            <td class="label-cell">Calle:</td>
            <td class="value-cell" colspan="3">{{ $valuation->property_street }}</td>
        </tr>
        <tr>
            <td class="label-cell">Número Ext.:</td>
            <td class="value-cell value-half">{{ $valuation->property_abroad_number }}</td>
            <td class="label-cell">Número Int.:</td>
            <td class="value-cell value-half">{{ $valuation->property_inside_number ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Conjunto:</td>
            <td class="value-cell value-half">{{ $valuation->property_housing_complex ?? '-' }}</td>
            <td class="label-cell">Edificio:</td>
            <td class="value-cell value-half">{{ $valuation->property_building ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Condominio:</td>
            <td class="value-cell value-half">{{ $valuation->property_condominium ?? '-' }}</td>
            <td class="label-cell">Entrada:</td>
            <td class="value-cell value-half">{{ $valuation->property_access ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Colonia:</td>
            <td class="value-cell value-half" style="font-size: 8px;">
                {{ $valuation->property_colony === 'no-listada' ? $valuation->property_other_colony :
                $valuation->property_colony }}
            </td>
            <td class="label-cell">Manzana:</td>
            <td class="value-cell value-half">{{ $valuation->property_block ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-cell">C. Postal:</td>
            <td class="value-cell value-half">{{ $valuation->property_cp }}</td>
            <td class="label-cell">Supermanzana:</td>
            <td class="value-cell value-half">{{ $valuation->property_super_block ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Alcaldía:</td>
            <td class="value-cell value-half">{{ $municipioInmueble }}</td>
            <td class="label-cell">Lote:</td>
            <td class="value-cell value-half">{{ $valuation->property_lot ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Entidad:</td>
            <td class="value-cell value-half">{{ $estadoInmueble }}</td>
            <td class="label-cell">Depto:</td>
            <td class="value-cell value-half">{{ $valuation->property_departament ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Ciudad:</td>
            <td class="value-cell value-half">{{ $valuation->property_city }}</td>
            <td class="label-cell">Nivel:</td>
            <td class="value-cell value-half">{{ $valuation->property_level ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Info. Adicional:</td>
            <td class="value-cell value-half">{{ $valuation->property_additional_data ?? '-' }}</td>
            <td class="label-cell">Tipo Inmueble:</td>
            <td class="value-cell value-half">{{ $valuation->property_type }}</td>
        </tr>
        <tr>
            <td class="label-cell">Constructor:</td>
            <td class="value-cell value-half">{{ $valuation->property_constructor ?? 'N/A' }}</td>
            <td class="label-cell">Tipo Vivienda:</td>
            <td class="value-cell value-half">{{ $valuation->property_type }}</td>
        </tr>

        {{-- Desc. Ubicación (Media celda, resto vacío) --}}
        <tr>
            <td class="label-cell">Desc. Ubicación:</td>
            <td class="value-cell value-half">{{ $valuation->property_constructor ?? 'N/A' }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>

{{-- 5. DATOS DEL PROPIETARIO --}}
<div style="margin-bottom: 8px;">
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad;; margin-bottom: 4px;">
        Datos del propietario del inmueble
    </div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Nombre:</td>
            <td class="value-cell value-half">
                @if($valuation->owner_type_person === 'Moral')
                {{ $valuation->owner_company_name }}
                @else
                {{ $valuation->owner_name }} {{ $valuation->owner_first_name }} {{ $valuation->owner_second_name }}
                @endif
            </td>
            <td class="label-cell">Calle y No.:</td>
            <td class="value-cell value-half">
                {{ $valuation->owner_street }} {{ $valuation->owner_abroad_number }}
            </td>
        </tr>
        <tr>
            <td class="label-cell">Colonia:</td>
            <td class="value-cell value-half">
                {{ $valuation->owner_colony === 'no-listada' ? $valuation->owner_other_colony : $valuation->owner_colony
                }}
            </td>
            <td class="label-cell">C. Postal:</td>
            <td class="value-cell value-half">{{ $valuation->owner_cp }}</td>
        </tr>
        <tr>
            <td class="label-cell">Alcaldía:</td>
            <td class="value-cell value-half">{{ $municipioPropietario }}</td>
            <td class="label-cell">Entidad:</td>
            <td class="value-cell value-half">{{ $estadoPropietario }}</td>
        </tr>
        <tr>
            <td class="label-cell">R.F.C.:</td>
            <td class="value-cell value-half">{{ $valuation->owner_rfc }}</td>
            <td class="label-cell">C.U.R.P.:</td>
            <td class="value-cell value-half">{{ $valuation->owner_curp ?? '-' }}</td>
        </tr>
    </table>

    {{-- Datos Técnicos --}}
    <table class="form-table" style="margin-top: 4px;">
        <tr>
            <td class="label-cell">Régimen Prop.:</td>
            <td class="value-cell value-half">{{ $valuation->owner_ship_regime }}</td>
            <td class="label-cell">Uso de suelo:</td>
            <td class="value-cell value-half">{{ $valuation->property_land_use }}</td>
        </tr>
        <tr>
            <td class="label-cell">Cta. Agua:</td>
            <td class="value-cell value-half">{{ $valuation->property_water_account }}</td>
            <td class="label-cell">Cta. Predial:</td>
            <td class="value-cell value-half">{{ $valuation->property_tax }}</td>
        </tr>
    </table>
</div>

{{-- 6. GEORREFERENCIA --}}
<div style="margin-top: 5px;">
    <div style="font-weight: bold; font-size: 11px; border-bottom: 1px solid #adadad;; margin-bottom: 2px;">
        Georeferencia
    </div>

    <table style="width:100%; border-collapse: separate; border-spacing: 0 2px;">
        <tr>
            <td class="label-cell" style="width: 10%;">Latitud:</td>
            <td class="value-cell" style="width: 23%;">{{ $valuation->latitude ?? 'N/A' }}</td>
            <td class="label-cell" style="width: 10%;">Longitud:</td>
            <td class="value-cell" style="width: 23%;">{{ $valuation->longitude ?? 'N/A' }}</td>
            <td class="label-cell" style="width: 10%;">Altitud:</td>
            <td class="value-cell" style="width: 24%;">{{ $valuation->altitude ?? 'N/A' }}</td>
        </tr>
    </table>
</div>
