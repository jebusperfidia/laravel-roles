<header>
    {{-- Quitamos el padding-bottom extra para pegarlo más a la línea verde si es necesario --}}
    <table style="width: 100%; border-bottom: 2px solid #25998b;">
        <tr>
            {{-- COLUMNA IZQUIERDA: LOGO COMPLETO --}}
            {{-- Le damos más espacio (70%) y alineamos al centro vertical --}}
            <td style="width: 65%; vertical-align: middle;">
                {{-- USAMOS LA IMAGEN COMPLETA (Logo + Texto) --}}
                {{-- Aumentamos el width a 220px (ajusta si lo quieres más grande o chico) --}}
                <img src="{{ public_path('assets/img/pdf/logo_header.png') }}"
                    style="width: 420px; height: auto; display: block;">
            </td>

            {{-- COLUMNA DERECHA: DATOS TÉCNICOS --}}
            {{-- Reducimos un poco el ancho (30%) para que el logo tenga protagonismo --}}
            <td style="width: 35%; vertical-align: middle;">
                <table class="info-table">
                    <tr>
                        {{-- Ajustamos porcentajes internos para que se vea balanceado --}}
                        <td class="info-label" style="width: 50%;">Número Interno:</td>
                        <td class="info-value" style="width: 50%;">{{ $valuation->folio ?? 'S/N' }}</td>
                    </tr>
                    <br>
                    <tr>
                        <td class="info-label">Fecha del Avalúo:</td>
                        {{-- Formateamos la fecha si existe, si no, usa la de hoy --}}
                        <td class="info-value">{{ isset($valuation->valuation_date) ? date('d/m/Y',
                            strtotime($valuation->valuation_date)) : date('d/m/Y') }}</td>
                    </tr>
                    <br>
                    <tr>
                        <td class="info-label">Fecha de caducidad:</td>
                        {{-- Formateamos la fecha si existe, si no, usa la de hoy --}}
                        <td class="info-value">{{ isset($valuation->valuation_date) ? date('d/m/Y',
                            strtotime($valuation->valuation_date)) : date('d/m/Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</header>
