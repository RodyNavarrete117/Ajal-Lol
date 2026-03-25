const actionBtn     = document.getElementById('actionBtn');
const backBtn       = document.getElementById('backBtn');
const emailGroup    = document.getElementById('email-group');
const passwordGroup = document.getElementById('password-group');
const forgot        = document.getElementById('forgot-password');
const emailInput    = document.getElementById('email');
const passwordInput = document.getElementById('password');
const form          = document.getElementById('loginForm');
const card          = document.querySelector('.login-card');

let emailGuardado = '';

// ─────────────────────────────────────────────────────────────────────────────
// TOAST
// ─────────────────────────────────────────────────────────────────────────────
const TOAST_ICONS = {
    danger:  '✕',
    success: '✓',
    warning: '!',
    info:    'i',
};

function showToast(type = 'danger', title = 'Error', message = '', seconds = 4) {
    const container = document.getElementById('toast-container');
    const toast     = document.createElement('div');
    toast.className = 'toast';

    const icon = TOAST_ICONS[type] || 'i';

    toast.innerHTML = `
        <div class="toast-inner">
            <div class="toast-icon ${type}">${icon}</div>
            <div class="toast-body">
                <p class="toast-title">${title}</p>
                <p class="toast-msg">${message}</p>
            </div>
            <button class="toast-close" onclick="dismissToast(this.closest('.toast'))">✕</button>
        </div>
        <div class="toast-bar-wrap">
            <div class="toast-bar ${type}"></div>
        </div>
    `;

    container.appendChild(toast);

    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            toast.classList.add('show');
            const bar = toast.querySelector('.toast-bar');
            bar.style.transition = `width ${seconds}s linear`;
            requestAnimationFrame(() => { bar.style.width = '0%'; });
        });
    });

    toast._timer = setTimeout(() => dismissToast(toast), seconds * 1000);
}

function dismissToast(toast) {
    if (!toast) return;
    clearTimeout(toast._timer);
    toast.classList.remove('show');
    toast.classList.add('hide');
    setTimeout(() => toast.remove(), 380);
}

// ─────────────────────────────────────────────────────────────────────────────
// AL CARGAR: si Laravel devolvió error, saltar al paso de contraseña y mostrar toast
// ─────────────────────────────────────────────────────────────────────────────
window.addEventListener('DOMContentLoaded', () => {
    if (window.__hasAuthError__) {
        const mensaje = window.__authError__ || 'Correo o contraseña incorrectos.';

        emailGuardado = emailInput.value.trim();

        if (emailGuardado) {
            emailGroup.classList.remove('step-active');
            passwordGroup.classList.add('step-active');
            backBtn.classList.add('step-active');
            forgot.classList.add('step-active');
            card.classList.add('step-password');
            actionBtn.textContent = 'Iniciar sesión';
            actionBtn.type        = 'submit';
            actualizarBotonPassword();
        }

        setTimeout(() => {
            showToast('danger', 'Credenciales inválidas', mensaje, 4);
        }, 300);

    } else {
        actualizarBotonEmail();
    }
});

// ─────────────────────────────────────────────────────────────────────────────
// VALIDACIONES
// ─────────────────────────────────────────────────────────────────────────────
function validarEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function validarPassword(password) {
    return password.trim().length > 0;
}

function actualizarBotonEmail() {
    const ok                      = validarEmail(emailInput.value.trim());
    actionBtn.style.opacity       = ok ? '1' : '0.5';
    actionBtn.style.pointerEvents = ok ? 'auto' : 'none';
}

function actualizarBotonPassword() {
    const ok                      = validarPassword(passwordInput.value);
    actionBtn.style.opacity       = ok ? '1' : '0.5';
    actionBtn.style.pointerEvents = ok ? 'auto' : 'none';
}

// ─────────────────────────────────────────────────────────────────────────────
// EVENTOS DE INPUT
// ─────────────────────────────────────────────────────────────────────────────
emailInput.addEventListener('input', () => {
    emailGroup.classList.remove('error');
    actualizarBotonEmail();
});

passwordInput.addEventListener('input', () => {
    passwordGroup.classList.remove('error');
    actualizarBotonPassword();
});

// ─────────────────────────────────────────────────────────────────────────────
// SIGUIENTE → PASSWORD
// ─────────────────────────────────────────────────────────────────────────────
actionBtn.addEventListener('click', () => {
    if (passwordGroup.classList.contains('step-active')) return;

    const emailVal = emailInput.value.trim();

    if (!validarEmail(emailVal)) {
        emailGroup.classList.add('error');
        emailInput.focus();
        return;
    }

    emailGuardado = emailVal;

    emailGroup.classList.remove('step-active');

    setTimeout(() => {
        passwordGroup.classList.add('step-active');
        backBtn.classList.add('step-active');
        forgot.classList.add('step-active');
    }, 150);

    card.classList.add('step-password');

    actionBtn.textContent = 'Iniciar sesión';
    actionBtn.type        = 'submit';

    actualizarBotonPassword();
});

// ─────────────────────────────────────────────────────────────────────────────
// VOLVER → EMAIL
// ─────────────────────────────────────────────────────────────────────────────
backBtn.addEventListener('click', () => {
    passwordGroup.classList.remove('step-active');
    backBtn.classList.remove('step-active');
    forgot.classList.remove('step-active');

    setTimeout(() => {
        emailGroup.classList.add('step-active');
    }, 150);

    card.classList.remove('step-password');

    emailInput.value      = emailGuardado;
    actionBtn.textContent = 'Siguiente';
    actionBtn.type        = 'button';

    actualizarBotonEmail();
});

// ─────────────────────────────────────────────────────────────────────────────
// SUBMIT
// ─────────────────────────────────────────────────────────────────────────────
form.addEventListener('submit', (e) => {
    if (!validarPassword(passwordInput.value)) {
        e.preventDefault();
        passwordGroup.classList.add('error');
        passwordInput.focus();
    }
});