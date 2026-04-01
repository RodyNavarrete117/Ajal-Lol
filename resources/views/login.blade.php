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

    <style>
        /* ── Toast container ────────────────────────────────────────── */
        #toast-container {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 9999;
            pointer-events: none;
        }

        /* ── Toast card ─────────────────────────────────────────────── */
        .toast {
            pointer-events: all;
            min-width: 280px;
            max-width: 340px;
            border-radius: 12px;
            border: 0.5px solid rgba(0, 0, 0, 0.10);
            background: #ffffff;
            overflow: hidden;
            transform: translateX(120%);
            opacity: 0;
            transition: transform 0.35s cubic-bezier(.4, 0, .2, 1), opacity 0.35s ease;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }
        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }
        .toast.hide {
            transform: translateX(120%);
            opacity: 0;
        }

        /* ── Toast body ─────────────────────────────────────────────── */
        .toast-inner {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px 10px;
        }
        .toast-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            margin-top: 1px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
        }
        .toast-icon.danger  { background: #F7C1C1; color: #791F1F; }
        .toast-icon.success { background: #9FE1CB; color: #085041; }
        .toast-icon.warning { background: #FAC775; color: #633806; }
        .toast-icon.info    { background: #B5D4F4; color: #0C447C; }

        .toast-body { flex: 1; }

        .toast-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0 0 2px;
        }
        .toast-msg {
            font-size: 12px;
            color: #555555;
            margin: 0;
            line-height: 1.5;
        }
        .toast-close {
            background: none;
            border: none;
            cursor: pointer;
            color: #aaaaaa;
            font-size: 14px;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .toast-close:hover { color: #333333; }

        /* ── Barra de progreso ──────────────────────────────────────── */
        .toast-bar-wrap {
            height: 3px;
            background: #f0f0f0;
        }
        .toast-bar {
            height: 3px;
            width: 100%;
        }
        .toast-bar.danger  { background: #E24B4A; }
        .toast-bar.success { background: #1D9E75; }
        .toast-bar.warning { background: #EF9F27; }
        .toast-bar.info    { background: #378ADD; }
    </style>
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
</body>
</html>