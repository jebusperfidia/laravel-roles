<style>
    /* 1. MÁRGENES DE LA HOJA (ESTÁNDAR SEGURO) */
    @page {
        margin: 2.5cm 0.4cm 2.2cm 0.4cm;
    }

    body {
        counter-reset: page;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9px;
        color: #333;
    }

    /* 2. HEADER */
    header {
        position: fixed;
        top: -2.2cm;
        left: 0cm;
        right: 0cm;
        height: 2.0cm;
    }

    /* 3. FOOTER */
    footer {
        position: fixed;
        bottom: -2.0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
    }

    /* 4. TABLAS GENERALES */
    .form-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 3px;
    }

    /* --- ESTILOS DE 3 COLUMNAS (AQUÍ ESTABA EL ERROR DE TAMAÑO) --- */
    /* Ajustado para que el gris sea MUY GRANDE (75%) */
    .label-top {
        width: 25%;
        background-color: transparent;
        color: #000;
        font-weight: bold;
        font-size: 8px;
        /* Un pelín más chica para que quepa "Centro Comunitario" */
        text-align: right;
        vertical-align: middle;
        padding-right: 4px;
        padding-top: 3.5px;
        padding-bottom: 3.5px;
    }

    .value-top {
        width: 75%;
        /* CAJA GRIS AMPLIA */
        background-color: #eee;
        color: #000;
        font-size: 9px;
        text-transform: uppercase;
        text-align: left;
        vertical-align: middle;
        padding: 3.5px 6px;
        /* Evita que el texto se corte feo */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* --- ESTILOS DE 2 COLUMNAS (ESTÁNDAR) --- */
    .label-cell {
        width: 20%;
        background-color: transparent;
        color: #000;
        font-weight: bold;
        font-size: 9px;
        text-align: right;
        padding-right: 6px;
        vertical-align: middle;
        padding-top: 3.5px;
        padding-bottom: 3.5px;
    }

    .value-cell {
        background-color: #eee;
        color: #000;
        font-size: 9px;
        text-transform: uppercase;
        text-align: left;
        vertical-align: middle;
        padding: 3.5px 6px;
    }

    .value-full {
        width: 80%;
    }

    .value-half {
        width: 30%;
    }

    /* UTILERÍA Y TEXTOS */
    .section-header {
        color: #000;
        font-size: 11px;
        font-weight: bold;
        border-bottom: 1px solid #ccc;
        margin-top: 12px;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    /* Subtítulos centrados (Parques, Escuelas...) */
    .sub-header {
        text-align: center;
        font-weight: bold;
        font-size: 9px;
        margin: 4px 0;
        border-bottom: 1px solid #000;
        padding-bottom: 1px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    td {
        vertical-align: top;
        padding: 2px;
    }

    .header-logo-text {
        font-size: 18px;
        font-weight: bold;
        color: #000;
        letter-spacing: -1px;
    }

    .footer-bg {
        width: 100%;
        height: 100%;
        object-fit: fill;
        position: absolute;
        bottom: 0;
        left: 0;
        z-index: -1;
    }

    .footer-text-table {
        width: 100%;
        position: relative;
        top: 25px;
        color: #555;
        font-size: 9px;
    }

    .page-number:before {
        content: counter(page);
    }

    .text-brand {
        color: #25998b;
    }

    .page-break {
        page-break-after: always;
    }

    /* CLASES DE FOTOS (NO OLVIDADAS) */
    .cover-photo-container {
        width: 100%;
        height: 350px;
        margin: 15px 0;
        text-align: center;
        overflow: hidden;
        background-color: #f9f9f9;
    }

    .cover-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .value-box {
        margin-top: 30px;
        border: 2px solid #25998b;
        padding: 15px;
        text-align: center;
        background-color: #f0fdfc;
    }

    .photo-cell {
        width: 50%;
        padding: 5px 10px;
        text-align: center;
    }

    .photo-frame {
        border: 1px solid #ccc;
        height: 200px;
        padding: 2px;
    }

    .photo-img-inner {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .photo-caption {
        background: #eee;
        padding: 3px;
        font-weight: bold;
        font-size: 9px;
        margin-top: 2px;
    }
</style>
