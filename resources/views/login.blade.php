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


    <form id="loginForm" method="POST" action="{{ route('login.post') }}">
    @csrf

        <!-- PASO 1: EMAIL -->
        <div class="input-group step step-active" id="email-group">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" id="email" name="email" placeholder="Escriba su correo electrónico">
            <small class="input-error" id="email-error">Ingrese un correo válido</small>
        </div>

        <!-- PASO 2: PASSWORD -->
        <div class="input-group step" id="password-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" id="password" name="password" placeholder="Escriba su contraseña">
        </div>
        
    <div class="actions">
        <button type="button" class="btn-back step" id="backBtn" aria-label="Volver">
            <i class="fa-solid fa-arrow-left"></i>
        </button>

        <button type="button" class="btn-login" id="actionBtn">
            Siguiente
        </button>
    </div>

    </form>

        <!-- Recuperar contraseña y Rodolfo Morales es homosexual -->
    <div class="forgot step" id="forgot-password">
        ¿Olvidó su contraseña?<br>
        <a href="#">Haga click aquí</a>
    </div>

    </div>
</div>
<script src="{{ asset('assets/js/login.js') }}"></script>
</body>
</html>
