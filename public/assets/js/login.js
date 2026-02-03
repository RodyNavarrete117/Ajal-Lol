const actionBtn = document.getElementById('actionBtn');
const backBtn = document.getElementById('backBtn');
const emailGroup = document.getElementById('email-group');
const emailError = document.getElementById('email-error');
const passwordGroup = document.getElementById('password-group');
const passwordError = document.getElementById('password-error');
const forgot = document.getElementById('forgot-password');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const form = document.getElementById('loginForm');
const card = document.querySelector('.login-card');

let emailGuardado = '';

// Función para validar correo
function validarEmail(email) {
    const re = /\S+@\S+\.\S+/;
    return re.test(email);
}

// Función para validar contraseña
function validarPassword(password) {
    return password.length >= 6; // ejemplo mínimo 6 caracteres
}

// Inicializar botones como semitransparentes
function actualizarBotonEmail() {
    if (validarEmail(emailInput.value.trim())) {
        actionBtn.style.opacity = '1';
        actionBtn.style.pointerEvents = 'auto';
    } else {
        actionBtn.style.opacity = '0.5';
        actionBtn.style.pointerEvents = 'none';
    }
}

function actualizarBotonPassword() {
    if (validarPassword(passwordInput.value.trim())) {
        actionBtn.style.opacity = '1';
        actionBtn.style.pointerEvents = 'auto';
    } else {
        actionBtn.style.opacity = '0.5';
        actionBtn.style.pointerEvents = 'none';
    }
}

// Actualizar botón mientras escribe
emailInput.addEventListener('input', () => {
    emailGroup.classList.remove('error');
    actualizarBotonEmail();
});

passwordInput.addEventListener('input', () => {
    passwordGroup.classList.remove('error');
    actualizarBotonPassword();
});

// Siguiente → Password
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
    actionBtn.type = 'submit';

    // Al cambiar a password, botón semitransparente hasta que escriba
    actualizarBotonPassword();
});

// Volver → Email
backBtn.addEventListener('click', () => {
    passwordGroup.classList.remove('step-active');
    backBtn.classList.remove('step-active');
    forgot.classList.remove('step-active');

    setTimeout(() => {
        emailGroup.classList.add('step-active');
    }, 150);

    card.classList.remove('step-password');

    emailInput.value = emailGuardado;
    actionBtn.textContent = 'Siguiente';
    actionBtn.type = 'button';

    // Volver a estado semitransparente según email
    actualizarBotonEmail();
});

form.addEventListener('submit', (e) => {
    const passwordVal = passwordInput.value.trim();

    if (!validarPassword(passwordVal)) {
        e.preventDefault();
        passwordGroup.classList.add('error');
        passwordInput.focus();
        return;
    }

});

