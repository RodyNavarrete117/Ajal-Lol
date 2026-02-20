// Variables globales
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// ==================== SISTEMA: Dark Mode & Animaciones ====================
// Se ejecuta ANTES del DOMContentLoaded para evitar parpadeo (FOUC)
(function initSystemSettings() {
    const darkPref = localStorage.getItem('darkMode') || 'light';
    const reduceAnim = localStorage.getItem('reduceAnimations') === 'true';

    applyDarkMode(darkPref);
    if (reduceAnim) document.body.classList.add('reduce-animations');
})();

/**
 * Aplica el modo oscuro según la preferencia:
 * 'light'  → siempre claro
 * 'dark'   → siempre oscuro
 * 'auto'   → sigue prefers-color-scheme del sistema
 */
function applyDarkMode(pref) {
    if (pref === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    } else if (pref === 'auto') {
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.setAttribute('data-theme', systemDark ? 'dark' : 'light');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
    }
}

// Escuchar cambios del sistema cuando está en modo automático
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    if (localStorage.getItem('darkMode') === 'auto') {
        document.documentElement.setAttribute('data-theme', e.matches ? 'dark' : 'light');
    }
});


// ==================== DOM LOADED ====================
document.addEventListener('DOMContentLoaded', function () {

    // ── Navegación entre tabs ──────────────────────────────────────────
    const tabBtns   = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetTab = this.dataset.tab;

            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            tabPanels.forEach(panel => {
                panel.classList.remove('active');
                if (panel.id === targetTab) panel.classList.add('active');
            });
        });
    });

    // ── Toggle password visibility ────────────────────────────────────
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const icon  = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // ── Password strength indicator ───────────────────────────────────
    const newPasswordInput = document.getElementById('new');
    const strengthBar      = document.getElementById('strengthBar');
    const strengthText     = document.getElementById('strengthText');

    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function () {
            const p = this.value;
            let strength = 0;
            if (p.length >= 8)                              strength++;
            if (p.match(/[a-z]/) && p.match(/[A-Z]/))      strength++;
            if (p.match(/[0-9]/))                           strength++;
            if (p.match(/[^a-zA-Z0-9]/))                   strength++;

            strengthBar.style.width = (strength * 25) + '%';

            const levels = ['Muy débil', 'Débil', 'Media', 'Fuerte', 'Muy fuerte'];
            const colors = ['#ff4444', '#ff8800', '#ffbb33', '#00C851', '#007E33'];
            strengthText.textContent          = levels[strength] || '';
            strengthBar.style.backgroundColor = colors[strength] || '';
        });
    }

    // ── Confirm password validation ───────────────────────────────────
    const confirmPasswordInput = document.getElementById('confirm');

    if (confirmPasswordInput && newPasswordInput) {
        confirmPasswordInput.addEventListener('input', function () {
            const match = this.value && newPasswordInput.value
                ? this.value === newPasswordInput.value
                : null;

            this.style.borderColor = match === null ? '' : (match ? '#10b981' : '#ef4444');
        });
    }

    // ── Cambiar contraseña ────────────────────────────────────────────
    const passwordForm = document.getElementById('passwordForm');

    if (passwordForm) {
        passwordForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const currentPassword = document.getElementById('current').value.trim();
            const newPassword     = document.getElementById('new').value.trim();
            const confirmPassword = document.getElementById('confirm').value.trim();
            const keepSession     = document.getElementById('keep_session')?.checked ?? true;

            if (!currentPassword || !newPassword || !confirmPassword) {
                return swalWarn('Campos vacíos', 'Por favor complete todos los campos');
            }
            if (newPassword.length < 6) {
                return swalWarn('Contraseña muy corta', 'La nueva contraseña debe tener al menos 6 caracteres');
            }
            if (newPassword !== confirmPassword) {
                return swalErr('Contraseñas no coinciden', 'La nueva contraseña y la confirmación deben ser iguales');
            }
            if (currentPassword === newPassword) {
                return swalWarn('Contraseña igual', 'La nueva contraseña debe ser diferente a la actual');
            }

            try {
                Swal.fire({ title: 'Actualizando...', text: 'Por favor espera un momento', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                const response = await fetch('/admin/settings/change-password', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify({ contraseña_actual: currentPassword, contraseña_nueva: newPassword, contraseña_confirmacion: confirmPassword, mantener_sesion: keepSession })
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({ icon: 'success', title: '¡Contraseña actualizada!', text: data.message, confirmButtonColor: '#10b981', confirmButtonText: 'Perfecto', timer: 3000, timerProgressBar: true })
                        .then(() => {
                            passwordForm.reset();
                            if (strengthBar)         strengthBar.style.width = '0';
                            if (strengthText)        strengthText.textContent = '';
                            if (confirmPasswordInput) confirmPasswordInput.style.borderColor = '';
                            if (data.redirect)       window.location.href = data.redirect;
                        });
                } else {
                    swalErr('Error al actualizar', data.message);
                }
            } catch {
                swalErr('Error de conexión', 'No se pudo conectar con el servidor. Por favor intenta nuevamente.');
            }
        });
    }

    // ── Actualizar perfil ─────────────────────────────────────────────
    const profileTab = document.getElementById('profile');

    if (profileTab) {
        const profileForm = profileTab.querySelector('.settings-form');

        if (profileForm) {
            profileForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                const nombre = document.getElementById('name')?.value.trim();
                const email  = document.getElementById('email')?.value.trim();

                if (!nombre || !email) return swalWarn('Campos vacíos', 'Por favor complete todos los campos');

                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    return swalWarn('Email inválido', 'Por favor ingrese un correo electrónico válido');
                }

                try {
                    Swal.fire({ title: 'Guardando cambios...', text: 'Por favor espera un momento', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                    const response = await fetch('/admin/settings/update-profile', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                        body: JSON.stringify({ nombre_usuario: nombre, correo_usuario: email })
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({ icon: 'success', title: '¡Perfil actualizado!', text: data.message, confirmButtonColor: '#10b981', confirmButtonText: 'Perfecto', timer: 3000, timerProgressBar: true });
                        if (data.data) {
                            document.getElementById('name').value  = data.data.nombre_usuario;
                            document.getElementById('email').value = data.data.correo_usuario;
                        }
                    } else {
                        swalErr('Error al actualizar', data.message);
                    }
                } catch {
                    swalErr('Error de conexión', 'No se pudo conectar con el servidor. Por favor intenta nuevamente.');
                }
            });
        }
    }

    // ── TAB SISTEMA ───────────────────────────────────────────────────

    // Cargar preferencias guardadas al abrir la pestaña
    const savedDark    = localStorage.getItem('darkMode') || 'light';
    const savedReduce  = localStorage.getItem('reduceAnimations') === 'true';

    // Marcar radio correcto
    const radioToCheck = document.querySelector(`input[name="dark_mode"][value="${savedDark}"]`);
    if (radioToCheck) radioToCheck.checked = true;

    // Marcar toggle reduce-animations
    const reduceToggle = document.getElementById('reduce_animations');
    if (reduceToggle) {
        reduceToggle.checked = savedReduce;

        // Mostrar/ocultar hint
        const perfHint = document.getElementById('perfHint');
        if (perfHint) {
            if (savedReduce) perfHint.classList.add('visible');

            reduceToggle.addEventListener('change', function () {
                perfHint.classList.toggle('visible', this.checked);
            });
        }
    }

    // Preview en tiempo real al cambiar radio dark mode
    document.querySelectorAll('input[name="dark_mode"]').forEach(radio => {
        radio.addEventListener('change', function () {
            applyDarkMode(this.value);
        });
    });

    // Guardar configuración del sistema
    const saveSystemBtn = document.getElementById('saveSystemSettings');

    if (saveSystemBtn) {
        saveSystemBtn.addEventListener('click', function () {
            const selectedMode = document.querySelector('input[name="dark_mode"]:checked')?.value || 'light';
            const reduceAnim   = document.getElementById('reduce_animations')?.checked || false;

            // Guardar en localStorage
            localStorage.setItem('darkMode', selectedMode);
            localStorage.setItem('reduceAnimations', reduceAnim);

            // Aplicar animaciones inmediatamente
            if (reduceAnim) {
                document.body.classList.add('reduce-animations');
            } else {
                document.body.classList.remove('reduce-animations');
            }

            // Toast elegante en lugar de SweetAlert
            showToast('success', '¡Configuración guardada!', 'Tus preferencias se aplicaron correctamente.');
        });
    }

    // ── Toast personalizado ───────────────────────────────────────────
    function showToast(type, title, message) {
        // Eliminar toast anterior si existe
        const existing = document.querySelector('.settings-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = `settings-toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas fa-${type === 'success' ? 'check' : 'times'}"></i>
            </div>
            <div class="toast-body">
                <div class="toast-title">${title}</div>
                <div class="toast-msg">${message}</div>
            </div>
            <div class="toast-progress"></div>
        `;

        document.body.appendChild(toast);

        // Animar entrada
        requestAnimationFrame(() => {
            requestAnimationFrame(() => toast.classList.add('show'));
        });

        // Auto-remover
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, 2500);

        // Click para cerrar
        toast.addEventListener('click', () => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        });
    }
    function swalWarn(title, text) {
        Swal.fire({ icon: 'warning', title, text, confirmButtonColor: '#7d3f6a', confirmButtonText: 'Entendido' });
    }
    function swalErr(title, text) {
        Swal.fire({ icon: 'error', title, text, confirmButtonColor: '#ef4444', confirmButtonText: 'Intentar de nuevo' });
    }
});