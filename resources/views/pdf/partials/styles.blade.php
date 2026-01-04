<style>
    /* 1. AJUSTE DE MÁRGENES DE LA HOJA */
    /* Dejamos más espacio arriba (3.5cm) y abajo (2.5cm) para que quepan Header y Footer sin tapar texto */
    @page {
       margin: 3.2cm 0.4cm 0.5cm 0.4cm;
    }

    body {
        counter-reset: page;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9px;
        color: #333;
    }

    /* 2. DEFINICIÓN DEL HEADER FIJO */
    header {
       position: fixed;
    top: -3cm;
    left: 0cm;
    right: 0cm;
    height: 3cm;

    }

    /* 3. DEFINICIÓN DEL FOOTER FIJO */
  footer {
position: fixed;
/* Lo bajamos casi hasta el corte de hoja */
bottom: -0.5cm;
left: 0cm;
right: 0cm;
/* Altura suficiente para el logo, pero sin empujar el contenido hacia arriba */
height: 3cm;
}

    /* --- ESTILOS DEL HEADER (EXTRAÍDOS DE TU FRONT PAGE) --- */
    .header-logo-text {
        font-size: 18px;
        /* Ajustado un poco */
        font-weight: bold;
        color: #000;
        letter-spacing: -1px;
    }

    .info-table {
        width: 100%;
        font-size: 8px;
        border-collapse: separate;
        border-spacing: 2px;
    }

    .info-label {
        font-weight: bold;
        text-align: right;
        padding-right: 5px;
        vertical-align: middle;
        width: 40%;
        background-color: #E0E0E0;
        /* El gris para las etiquetas */
        padding: 2px;
    }

    .info-value {
        background-color: #F5F5F5;
        /* Un gris más claro para los valores */
        padding: 2px 5px;
        text-align: left;
        /* Cambiado a left para que se lea mejor */
        vertical-align: middle;
        font-weight: bold;
    }

    /* --- ESTILOS DEL FOOTER --- */
    .footer-bg {
    width: 100%;
    height: 100%;
    object-fit: fill; /* Forzamos a que llene el contenedor */
    position: absolute;
    bottom: 0;
    left: 0;
    z-index: -1;
    }

    .footer-text-table {
        width: 100%;
        position: relative;
        /* Juega con este top para "aterrizar" el texto sobre la barra verde */
        top: 25px;
        color: #555;
        /* O blanco #FFF si tu barra es muy oscura */
        font-size: 9px;
    }

    /* --- UTILIDADES GENERALES QUE YA TENÍAS --- */
    .page-number:before {
        content: counter(page);
    }

    .text-brand {
        color: #25998b;
    }

    .section-header {
        color: #000;
        font-size: 11px;
        font-weight: bold;
        border-bottom: 1px solid #ccc;
        margin-top: 15px;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

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

    /* Estilos específicos de secciones (Portada, Fotos, etc.) se mantienen igual... */
    .cover-photo-container {
        width: 100%;
        height: 350px;
        margin: 20px 0;
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

    /* Salto de página forzado */
    .page-break {
        page-break-after: always;
    }
</style>
