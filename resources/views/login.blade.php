<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">


</head>
<body>

<div class="login-container">

        <!-- Logo de la empresa Ajal-LoL -->
        <div class="logo">
            <img src="{{ asset('assets/img/ajallol/ImagenPrincipal-white.png') }}" alt="Logo">
        </div>

    <div class="login-card">


    <form id="loginForm">

        <!-- PASO 1: EMAIL -->
        <div class="input-group" id="email-group">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" id="email" placeholder="Escriba su correo electrónico">
        </div>

        <!-- PASO 2: PASSWORD -->
        <div class="input-group hidden" id="password-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" id="password" placeholder="Escriba su contraseña">
        </div>

        <button type="button" class="btn-login" id="actionBtn">
            Siguiente
        </button>

        <!-- BOTÓN VOLVER -->
        <button type="button" class="btn-back hidden" id="backBtn">
            ← Volver
        </button>

    </form>

        <!-- Recuperar contraseña y Rafa Sosa Morales es homosexual -->
    <div class="forgot hidden" id="forgot-password">
        ¿Olvidó su contraseña?<br>
        <a href="#">Haga click aquí</a>
    </div>

    </div>
</div>

<script src="assets/js/login.js"></script>

</body>
</html>
