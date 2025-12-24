<style>



    @page {
        margin: 0.5cm 1cm 1.5cm 1cm;
    }

    body {
        counter-reset: page;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9px;
        color: #333;
    }

    .page-number:before {
    content: counter(page);
    }

    /* --- COLORES --- */
    .text-brand {
        color: #25998b;
    }

    /* Títulos en NEGRO como pediste */
    .section-header {
        color: #000;
        font-size: 11px;
        font-weight: bold;
        border-bottom: 1px solid #ccc;
        margin-top: 15px;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    /* TABLAS Y GENERALES */
    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    td {
        vertical-align: top;
        padding: 3px;
    }

    .font-bold {
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .uppercase {
        text-transform: uppercase;
    }

    /* --- FOOTER ORIGINAL (EL QUE TE GUSTABA) --- */
    footer {
        position: fixed;
        bottom: -40px;
        left: 0px;
        right: 0px;
        height: 30px;
        border-top: 2px solid #25998b;
        padding-top: 5px;
        color: #555;
    }

  /*   .page-number:after {
        content: counter(page);
    } */

    /* --- CLASES NUEVAS PARA EL HEADER (SOLO ESTO ES NUEVO) --- */
    .header-logo-text {
        font-size: 24px;
        font-weight: bold;
        color: #000;
        letter-spacing: -1px;
    }

    .header-subtitle {
        font-size: 10px;
        color: #25998b;
        letter-spacing: 3px;
        font-weight: bold;
        margin-top: -2px;
    }

    /* El cuadro de la derecha con gris */
    .info-table {
        width: 100%;
        font-size: 8px;
    }

    .info-label {
        font-weight: bold;
        text-align: right;
        padding-right: 5px;
        vertical-align: middle;
        width: 40%;
    }

    .info-value {
        background-color: #d1d5db;
        padding: 2px 5px;
        text-align: right;
        vertical-align: middle;
        margin-bottom: 2px;
    }

    /* Ajuste foto portada */
    .cover-photo-container {
        width: 100%;
        height: 350px;
        margin: 20px 0;
        /* Sin bordes de color, limpio */
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

    /* Caja de valor */
    .value-box {
        margin-top: 30px;
        border: 2px solid #25998b;
        padding: 15px;
        text-align: center;
        background-color: #f0fdfc;
    }

    /* Fotos */
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
