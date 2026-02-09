<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cargando...</title>
    <!-- Redirige al admin después de 2 segundos -->
    <meta http-equiv="refresh" content="2;url={{ route('admin.home') }}">
    <!-- Link al CSS del loader -->
    <link rel="stylesheet" href="{{ asset('assets/css/loader.css') }}">
    <style>
        /* Centrar el loader en pantalla */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f2f5; /* fondo gris claro */
        }
    </style>
</head>
<body>
    <div class="loader"></div>
</body>
</html>