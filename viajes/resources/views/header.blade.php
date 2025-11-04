<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viajes compartidos</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.5/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.5/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('css/micromodal.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
    <style>
        /* ===== Franja dorada con texto desplazándose ===== */
.scroll-banner {
    background: linear-gradient(90deg, #d4af37, #ffdf00, #d4af37);

    color: white;
    overflow: hidden;
    white-space: nowrap;
    padding: 8px 0;
    font-weight: 600;
    font-size: 1rem;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    border-bottom: 2px solid #a97f00;
}

.scroll-text {
    display: inline-block;
    padding-left: 100%;
    animation: scroll-left 25s linear infinite;
}

/* Animación para desplazar el texto */
@keyframes scroll-left {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-100%);
    }
}

        html {
            height: 100%;
            background-image: url("{{ asset('img/citylights.jpg') }}");
            background-size: cover;           /* cubre toda la ventana y el scroll */
            background-attachment: fixed;     /* queda fijo al hacer scroll */
            background-position: center;
            background-repeat: no-repeat;
        }

        body {
            min-height: 100%;
            margin: 0;
            background: transparent;          /* importante para que el fondo del html se vea */
        }
                    /* ===== Botón Volver Arriba ===== */
            #btn-scroll-top {
                position: fixed;
                bottom: 30px;
                right: 30px;
                background-color: #e0b908ff; /* Fucsia, puedes cambiarlo a dorado si prefieres */
                color: white;
                border: none;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                font-size: 18px;
                display: none; /* Oculto al inicio */
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 6px rgba(0,0,0,0.2);
                cursor: pointer;
                transition: all 0.3s ease;
                z-index: 9999;
            }

            #btn-scroll-top:hover {
                background-color: #ff66b2; /* tono más claro al pasar el mouse */
                transform: translateY(-3px);
            }

    </style>
</head>
<body>
    @include('menu')
    