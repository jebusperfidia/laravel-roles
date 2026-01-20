<header>
    {{-- Reducimos el margin-bottom de 10px a 2px para eliminar el aire --}}
    <table style="width: 100%;  border-collapse: collapse; margin-bottom: 2px;">
        <tr>
            {{-- COLUMNA IZQUIERDA: LOGO --}}
            <td style="width: 60%; vertical-align: bottom; padding-bottom: 3px;">
                <img src="{{ public_path('assets/img/pdf/logo_header.png') }}"
                    style="width: 260px; height: auto; display: block;">
            </td>

            {{-- COLUMNA DERECHA: DATOS TÉCNICOS --}}
            <td style="width: 40%; vertical-align: bottom; padding-bottom: 3px;">
                <table style="width: 100%; border-collapse: collapse; font-family: sans-serif;">
                    <tr>
                        <td
                            style="text-align: right; font-size: 8px; font-weight: bold; color: #333; padding: 1px 5px; width: 55%;">
                            Número Interno:</td>
                        <td
                            style="background-color: #eee; text-align: center; font-size: 8px; color: #000; padding: 1px 5px; width: 45%;">
                            {{ $valuation->folio ?? 'S/N' }}</td>
                    </tr>
                    {{-- Espacio mínimo entre filas --}}
                    <tr>
                        <td style="height: 1px;"></td>
                    </tr>
                    <tr>
                        <td
                            style="text-align: right; font-size: 8px; font-weight: bold; color: #333; padding: 1px 5px;">
                            Fecha del Avalúo:</td>
                        <td
                            style="background-color: #eee; text-align: center; font-size: 8px; color: #000; padding: 1px 5px;">
                            {{-- Cambié $valuation->date por la variable que suele usar Laravel: valuation_date o
                            created_at --}}
                            {{ isset($valuation->valuation_date) ? date('d/m/Y', strtotime($valuation->valuation_date))
                            : date('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 1px;"></td>
                    </tr>
                    <tr>
                        <td
                            style="text-align: right; font-size: 8px; font-weight: bold; color: #333; padding: 1px 5px;">
                            Fecha de caducidad:</td>
                        <td
                            style="background-color: #eee; text-align: center; font-size: 8px; color: #000; padding: 1px 5px;">
                            @php
                            $fechaBase = $valuation->valuation_date ?? date('Y-m-d');
                            $fechaCaducidad = date('d/m/Y', strtotime($fechaBase . ' + 6 months'));
                            @endphp
                            {{ $fechaCaducidad }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</header>
