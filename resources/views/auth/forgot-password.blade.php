<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar contraseña</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
  <style>
    .login-container {
      height: 100%;
    }

    .login-card.expanded {
      padding-bottom: 160px !important;
    }

    @keyframes fadeInCard {
      from { opacity: 0; transform: translateY(12px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .login-card {
      animation: fadeInCard 0.45s ease forwards;
      overflow: visible !important;
      padding-bottom: 8px;
      transition: padding-bottom 0.35s ease;
    }

    #toast-container {
      position: fixed; top: 1.25rem; right: 1.25rem;
      display: flex; flex-direction: column; gap: 10px;
      z-index: 9999; pointer-events: none;
    }
    .toast {
      pointer-events: all; min-width: 280px; max-width: 340px;
      border-radius: 12px; border: 0.5px solid rgba(0,0,0,.10);
      background: #fff; overflow: hidden;
      transform: translateX(120%); opacity: 0;
      transition: transform .35s cubic-bezier(.4,0,.2,1), opacity .35s ease;
      box-shadow: 0 4px 16px rgba(0,0,0,.08);
    }
    .toast.show { transform: translateX(0); opacity: 1; }
    .toast.hide { transform: translateX(120%); opacity: 0; }
    .toast-inner { display:flex; align-items:flex-start; gap:10px; padding:12px 14px 10px; }
    .toast-icon { width:20px; height:20px; flex-shrink:0; margin-top:1px; border-radius:50%;
      display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:600; }
    .toast-icon.success { background:#9FE1CB; color:#085041; }
    .toast-icon.danger  { background:#F7C1C1; color:#791F1F; }
    .toast-icon.warning { background:#FAC775; color:#633806; }
    .toast-body { flex:1; }
    .toast-title { font-size:13px; font-weight:600; color:#1a1a1a; margin:0 0 2px; }
    .toast-msg   { font-size:12px; color:#555; margin:0; line-height:1.5; }
    .toast-close { background:none; border:none; cursor:pointer; color:#aaa;
      font-size:14px; padding:0; line-height:1; flex-shrink:0; margin-top:1px; }
    .toast-close:hover { color:#333; }
    .toast-bar-wrap { height:3px; background:#f0f0f0; }
    .toast-bar { height:3px; width:100%; }
    .toast-bar.success { background:#1D9E75; }
    .toast-bar.danger  { background:#E24B4A; }
    .toast-bar.warning { background:#EF9F27; }

  #cooldown-msg {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.75);
    text-align: center;
    margin-top: 12px;
    min-height: 20px;
    padding: 0 8px;
    transition: opacity 0.3s;
  }
  </style>
</head>
<body>

<div class="login-container">
  <div class="logo">
    <img src="{{ asset('assets/img/ajallol/ImagenPrincipal-white.png') }}" alt="Logo">
  </div>

  <div class="login-card">
    <form id="forgotForm">
      @csrf

      <div class="input-group step step-active" id="email-group">
        <i class="fa-solid fa-envelope"></i>
        <input type="email" id="emailInput" name="email"
               placeholder="Ingresa tu correo electrónico" autofocus>
        <small class="input-error" id="email-error">Ingresa un correo válido</small>
      </div>

      <div class="actions">
        <a href="{{ route('login') }}"
           class="btn-back step step-active"
           style="display:flex;align-items:center;justify-content:center;text-decoration:none;">
          <i class="fa-solid fa-arrow-left"></i>
        </a>
        <button type="submit" id="submitBtn" class="btn-login"
                style="opacity:0.5;pointer-events:none;">
          Enviar enlace
        </button>
      </div>
    </form>

    <p id="cooldown-msg"></p>
  </div>
</div>

<div id="toast-container"></div>

<script>
const emailInput  = document.getElementById('emailInput');
const submitBtn   = document.getElementById('submitBtn');
const emailGroup  = document.getElementById('email-group');
const cooldownMsg = document.getElementById('cooldown-msg');

const CSRF        = document.querySelector('input[name="_token"]').value;
const ACTION_URL  = "{{ route('password.forgot.send') }}";

const LS_COUNT    = 'forgot_count';
const LS_LAST     = 'forgot_last';
const MAX_INTENTOS = 3;
const COOLDOWN_SEG = 60;

// ── Toast ────────────────────────────────────────────────
function showToast(type, title, message, seconds = 4) {
  const icons = { success:'✓', danger:'✕', warning:'!' };
  const container = document.getElementById('toast-container');
  const toast = document.createElement('div');
  toast.className = 'toast';
  toast.innerHTML = `
    <div class="toast-inner">
      <div class="toast-icon ${type}">${icons[type]||'i'}</div>
      <div class="toast-body">
        <p class="toast-title">${title}</p>
        <p class="toast-msg">${message}</p>
      </div>
      <button class="toast-close" onclick="dismissToast(this.closest('.toast'))">✕</button>
    </div>
    <div class="toast-bar-wrap"><div class="toast-bar ${type}"></div></div>`;
  container.appendChild(toast);
  requestAnimationFrame(() => requestAnimationFrame(() => {
    toast.classList.add('show');
    const bar = toast.querySelector('.toast-bar');
    bar.style.transition = `width ${seconds}s linear`;
    requestAnimationFrame(() => { bar.style.width = '0%'; });
  }));
  toast._timer = setTimeout(() => dismissToast(toast), seconds * 1000);
}

function dismissToast(toast) {
  if (!toast) return;
  clearTimeout(toast._timer);
  toast.classList.remove('show');
  toast.classList.add('hide');
  setTimeout(() => toast.remove(), 380);
}

// ── Validación ───────────────────────────────────────────
function emailValido(v) { return /\S+@\S+\.\S+/.test(v.trim()); }

function actualizarBoton() {
  const ok = emailValido(emailInput.value) && !estaBloqueado();
  submitBtn.style.opacity       = ok ? '1' : '0.5';
  submitBtn.style.pointerEvents = ok ? 'auto' : 'none';
}

emailInput.addEventListener('input', () => {
  emailGroup.classList.remove('error');
  actualizarBoton();
});

// ── Cooldown ─────────────────────────────────────────────
function getDatos() {
  return {
    count: parseInt(localStorage.getItem(LS_COUNT) || '0'),
    last:  parseInt(localStorage.getItem(LS_LAST)  || '0'),
  };
}

function segundosRestantes() {
  const { last } = getDatos();
  return Math.max(0, COOLDOWN_SEG - Math.floor((Date.now() - last) / 1000));
}

function estaBloqueado() {
  const { count, last } = getDatos();
  if (count <= 0) return false;
  const segs = Math.max(0, COOLDOWN_SEG - Math.floor((Date.now() - last) / 1000));
  if (segs <= 0) {
    if (count >= MAX_INTENTOS) localStorage.setItem(LS_COUNT, '0');
    return false;
  }
  return true;
}

let intervalo = null;

function iniciarContador() {
  if (intervalo) clearInterval(intervalo);
  document.querySelector('.login-card').classList.add('expanded');
  intervalo = setInterval(() => {
    const { count } = getDatos();
    const segs = segundosRestantes();

    if (segs <= 0) {
      clearInterval(intervalo);
      intervalo = null;
      cooldownMsg.textContent = '';
      if (count >= MAX_INTENTOS) localStorage.setItem(LS_COUNT, '0');
      document.querySelector('.login-card').classList.remove('expanded');
      actualizarBoton();
      return;
    }

    const restantes = MAX_INTENTOS - count;
    if (count >= MAX_INTENTOS) {
      cooldownMsg.textContent = `Límite alcanzado. Espera ${segs}s para intentar de nuevo.`;
    } else {
      cooldownMsg.textContent = `Puedes reenviar en ${segs}s · ${restantes} intento${restantes !== 1 ? 's' : ''} restante${restantes !== 1 ? 's' : ''}`;
    }
    actualizarBoton();
  }, 1000);
}

// ── Envío sin recarga (fetch) ────────────────────────────
document.getElementById('forgotForm').addEventListener('submit', async (e) => {
  e.preventDefault();

  if (!emailValido(emailInput.value)) {
    emailGroup.classList.add('error');
    emailInput.focus();
    return;
  }

  if (estaBloqueado()) {
    showToast('warning', 'Espera un momento', `Debes esperar ${segundosRestantes()}s antes de reenviar.`, 4);
    return;
  }

  // Deshabilitar botón mientras envía
  submitBtn.style.opacity       = '0.5';
  submitBtn.style.pointerEvents = 'none';
  submitBtn.textContent         = 'Enviando...';

  try {
    const res = await fetch(ACTION_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
      },
      body: new URLSearchParams({
        _token: CSRF,
        email:  emailInput.value.trim(),
      }),
    });

    // Registrar intento
    const { count } = getDatos();
    localStorage.setItem(LS_COUNT, count + 1);
    localStorage.setItem(LS_LAST,  Date.now());

    const restantesAhora = MAX_INTENTOS - (count + 1);

    if (res.ok || res.status === 302) {
      emailInput.value = '';
      showToast('success', '¡Correo enviado!',
        restantesAhora > 0
          ? `Revisa tu bandeja. Te quedan ${restantesAhora} intento${restantesAhora !== 1 ? 's' : ''} más.`
          : 'Revisa tu bandeja. Has alcanzado el límite de envíos.',
        10);
    } else {
      const data = await res.json().catch(() => ({}));
      const msg  = data?.errors?.email?.[0] || 'Ocurrió un error. Intenta de nuevo.';
      showToast('danger', 'Error', msg, 5);
    }

  } catch {
    showToast('danger', 'Error de conexión', 'No se pudo conectar. Verifica tu internet.', 5);
  }

  submitBtn.textContent = 'Enviar enlace';
  iniciarContador();
});

// ── Al cargar ────────────────────────────────────────────
window.addEventListener('DOMContentLoaded', () => {
  actualizarBoton();
  if (estaBloqueado()) iniciarContador();
});
</script>

</body>
</html>