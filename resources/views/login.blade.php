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

    <div class="login-card">

        <!-- Logo de la empresa Ajal-LoL -->
        <div class="logo">
            <img src="{{ asset('') }}" alt="Logo">
        </div>

        <!-- Formulario para iniciar sesión -->
        <form>
            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" placeholder="Correo">
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Contraseña">
            </div>

            <button type="button" class="btn-login">
                Iniciar sesión
            </button>
        </form>

        <!-- Recuperar contraseña y Rafa es homosexual -->
        <div class="forgot">
            ¿Olvidó su contraseña?<br>
            <a href="#">Haga click aquí</a>
        </div>

    </div>

</div>

</body>
</html>
