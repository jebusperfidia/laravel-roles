<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .page-break {
            page-break-after: always;
        }

        /* <--- ESTO ES MAGIA PARA DOMPDF */
        .header {
            text-align: center;
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 8px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>{{ $titulo }}</h1>
        <p>Folio: <strong>{{ $folio }}</strong></p>
    </div>

    <p><strong>Cliente:</strong> {{ $cliente }}</p>
    <p><strong>Fecha:</strong> {{ $fecha }}</p>

    <div style="margin-top: 50px; text-align: center;">
        <h3>Resumen Ejecutivo</h3>
        <p>{{ $contenido }}</p>
    </div>

    <div class="page-break"></div>

    <h3>Detalles Técnicos (Página 2)</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Terreno</td>
                <td>$1,000,000.00</td>
            </tr>
            <tr>
                <td>Construcción</td>
                <td>$2,500,000.00</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
