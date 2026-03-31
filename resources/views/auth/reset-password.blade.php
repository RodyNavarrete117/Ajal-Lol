<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nueva contraseña</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<style>
  .password-field {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #ffffff;
    border-radius: 20px;
    padding: 0 16px 0 18px;
    height: 48px;
  }

  .password-field i {
    color: #6f6f6f;
    font-size: 15px;
    flex-shrink: 0;
  }

  .password-field input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    font-size: 15px;
    min-width: 0;
    padding: 0;
  }

  .toggle-password {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    color: #aaa;
    font-size: 14px;
    flex-shrink: 0;
  }

  /* Más altura para que quepan la barra y el mensaje */
  .step-active.password-field {
    max-height: 80px !important;
  }

  .strength-bar-wrapper {
    margin: 6px 0 4px;
  }

  .strength-bar {
    height: 5px;
    border-radius: 4px;
    background: #e0e0e0;
    overflow: hidden;
  }

  .strength-fill {
    height: 100%;
    width: 0%;
    border-radius: 4px;
    transition: width 0.3s, background 0.3s;
  }

  .strength-label {
    font-size: 12px;
    margin-top: 4px;
    font-weight: 500;
    color: white;
  }

  .match-msg {
    font-size: 12px;
    margin-top: 4px;
    min-height: 18px;
    color: white;
  }

  .login-card {
    max-height: 400px !important;
    padding-bottom: 25px;
  }
</style>
<body>
<div class="login-container">
  <div class="logo">
    <img src="{{ asset('assets/img/ajallol/ImagenPrincipal-white.png') }}" alt="Logo">
  </div>
  <div class="login-card">

    @if ($errors->has('token'))
      <p style="color:#E24B4A;font-size:14px;text-align:center;margin-bottom:16px;">
        <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('token') }}
      </p>
    @endif

    <form method="POST" action="{{ route('password.reset') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ $email }}">

  {{-- Campo nueva contraseña --}}
<div class="step step-active @error('password') error @enderror" style="margin-bottom: 6px;">
  <div class="password-field">
    <i class="fa-solid fa-lock"></i>
    <input type="password" name="password" id="password" placeholder="Nueva contraseña (mín. 8 caracteres)">
    <button type="button" class="toggle-password" onclick="toggleVisibility('password', 'eye1')">
      <i class="fa-solid fa-eye" id="eye1"></i>
    </button>
  </div>
</div>

{{-- Barra de seguridad --}}
<div class="strength-bar-wrapper">
  <div class="strength-bar">
    <div class="strength-fill" id="strengthFill"></div>
  </div>
  <p class="strength-label" id="strengthLabel" style="color:#aaa;">Escribe tu contraseña</p>
</div>

@error('password')
  <small class="input-error">{{ $message }}</small>
@enderror

{{-- Campo confirmar contraseña --}}
<div class="step step-active" style="margin-top: 16px;">
  <div class="password-field">
    <i class="fa-solid fa-lock"></i>
    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar nueva contraseña">
    <button type="button" class="toggle-password" onclick="toggleVisibility('password_confirmation', 'eye2')">
      <i class="fa-solid fa-eye" id="eye2"></i>
    </button>
  </div>
</div>

      {{-- Mensaje de coincidencia --}}
      <p class="match-msg" id="matchMsg"></p>

      <div class="actions" style="margin-top: 10px;">
        <button type="submit" class="btn-login" id="submitBtn" style="width:100%" disabled>Guardar contraseña</button>
      </div>
    </form>

  </div>
</div>

<script>
  function toggleVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  }

  function getStrength(password) {
    let score = 0;
    if (password.length >= 8)           score++;
    if (password.length >= 12)          score++;
    if (/[A-Z]/.test(password))         score++;
    if (/[0-9]/.test(password))         score++;
    if (/[^A-Za-z0-9]/.test(password))  score++;
    return score;
  }

  function updateUI() {
    const password  = document.getElementById('password').value;
    const confirm   = document.getElementById('password_confirmation').value;
    const fill      = document.getElementById('strengthFill');
    const label     = document.getElementById('strengthLabel');
    const matchMsg  = document.getElementById('matchMsg');
    const submitBtn = document.getElementById('submitBtn');

    const score = getStrength(password);
    const levels = [
      { pct: '0%',   color: '#e0e0e0', text: 'Escribe tu contraseña', labelColor: '#aaa' },
      { pct: '20%',  color: '#E24B4A', text: 'Muy débil',             labelColor: '#E24B4A' },
      { pct: '40%',  color: '#f97316', text: 'Débil',                 labelColor: '#f97316' },
      { pct: '60%',  color: '#eab308', text: 'Regular',               labelColor: '#eab308' },
      { pct: '80%',  color: '#22c55e', text: 'Buena',                 labelColor: '#22c55e' },
      { pct: '100%', color: '#16a34a', text: 'Muy segura',            labelColor: '#16a34a' },
    ];
    const level = password.length === 0 ? levels[0] : levels[Math.min(score, 5)];
    fill.style.width      = level.pct;
    fill.style.background = level.color;
    label.textContent     = level.text;
    label.style.color     = level.labelColor;

    if (confirm.length === 0) {
      matchMsg.textContent = '';
    } else if (password === confirm) {
      matchMsg.textContent = '✓ Las contraseñas coinciden';
      matchMsg.style.color = '#22c55e';
    } else {
      matchMsg.textContent = '✗ Las contraseñas no coinciden';
      matchMsg.style.color = '#E24B4A';
    }

    const strong  = score >= 3;
    const matches = password === confirm && confirm.length > 0;

      if (strong && matches) {
        submitBtn.disabled = false;
        submitBtn.classList.add('enabled');
      } else {
        submitBtn.disabled = true;
        submitBtn.classList.remove('enabled');
      }
  }

  document.getElementById('password').addEventListener('input', updateUI);
  document.getElementById('password_confirmation').addEventListener('input', updateUI);
</script>
</body>
</html>