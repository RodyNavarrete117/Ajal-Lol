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
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Escriba su correo electrónico"
                    value="{{ old('email') }}"
                >
                <small class="input-error" id="email-error">Ingrese un correo válido</small>
            </div>

            <!-- PASO 2: PASSWORD -->
            <div class="input-group step" id="password-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Escriba su contraseña">
                <i class="fa-solid fa-eye toggle-password" id="togglePassword" style="left: 280px"></i>
            </div>

            <div class="step" id="remember-group">
                <label style="color: white; font-size: 14px; cursor: pointer;">
                    <input type="checkbox" name="remember_me" value="1" style="margin-right: 5px;">
                    Mantener sesión iniciada
                </label>
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

        <!-- Recuperar contraseña -->
        <div class="forgot step" id="forgot-password">
            ¿Olvidó su contraseña?<br>
            <a href="{{ route('password.forgot') }}">Haga click aquí</a>
        </div>

    </div>
</div>

<!-- ── Toast container ───────────────────────────────────────────────────── -->
<div id="toast-container"></div>

{{-- Pasar errores de Laravel al JS --}}
@if ($errors->any())
    <script>
        window.__authError__    = @json($errors->first());
        window.__hasAuthError__ = true;
    </script>
@else
    <script>
        window.__hasAuthError__ = false;
    </script>
@endif

<script src="{{ asset('assets/js/login.js') }}"></script>
@if (session('status'))
<script>
  window.addEventListener('DOMContentLoaded', () => {
    showToast('success', '¡Éxito!', @json(session('status')), 5);
  });
</script>
@endif

{{-- Toast para mensajes de error (¡Aquí va lo del middleware!) --}}
@if (session('error'))
<script>
  window.addEventListener('DOMContentLoaded', () => {
    // Asumo que tu función showToast acepta 'error' o 'danger' como primer parámetro
    showToast('error', 'Acceso denegado', @json(session('error')), 5);
  });
</script>
@endif
</body>
</html>