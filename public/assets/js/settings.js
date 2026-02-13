
// Variables globales
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {

    // Navegación entre las tablas del usuario

    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Actualizar botones activos
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Mostrar panel correspondiente
            tabPanels.forEach(panel => {
                panel.classList.remove('active');
                if (panel.id === targetTab) {
                    panel.classList.add('active');
                }
            });
        });
    });
    
    // TOGGLE PASSWORD VISIBILITY
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    
    // PASSWORD STRENGTH INDICATOR
    const newPasswordInput = document.getElementById('new');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            strengthBar.style.width = (strength * 25) + '%';
            
            const strengthLevels = ['Muy débil', 'Débil', 'Media', 'Fuerte', 'Muy fuerte'];
            const strengthColors = ['#ff4444', '#ff8800', '#ffbb33', '#00C851', '#007E33'];
            
            strengthText.textContent = strengthLevels[strength] || '';
            strengthBar.style.backgroundColor = strengthColors[strength] || '';
        });
    }

    // Validaci{on de la contraseña}
    const confirmPasswordInput = document.getElementById('confirm');
    
    if (confirmPasswordInput && newPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const newPassword = newPasswordInput.value;
            const confirmPassword = this.value;

            if (confirmPassword && newPassword) {
                if (confirmPassword === newPassword) {
                    this.style.borderColor = '#10b981';
                } else {
                    this.style.borderColor = '#ef4444';
                }
            } else {
                this.style.borderColor = '';
            }
        });
    }

    // SCambiar contraseña del usuario
    
    const passwordForm = document.getElementById('passwordForm');

    if (passwordForm) {
        passwordForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const currentPassword = document.getElementById('current').value.trim();
            const newPassword = document.getElementById('new').value.trim();
            const confirmPassword = document.getElementById('confirm').value.trim();
            const keepSession = document.getElementById('keep_session')?.checked || true;

            // Validaciones en el frontend
            if (!currentPassword || !newPassword || !confirmPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos vacíos',
                    text: 'Por favor complete todos los campos',
                    confirmButtonColor: '#7d3f6a',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            if (newPassword.length < 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Contraseña muy corta',
                    text: 'La nueva contraseña debe tener al menos 6 caracteres',
                    confirmButtonColor: '#7d3f6a',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Contraseñas no coinciden',
                    text: 'La nueva contraseña y la confirmación deben ser iguales',
                    confirmButtonColor: '#7d3f6a',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            if (currentPassword === newPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Contraseña igual',
                    text: 'La nueva contraseña debe ser diferente a la actual',
                    confirmButtonColor: '#7d3f6a',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Preparar datos
            const formData = {
                contraseña_actual: currentPassword,
                contraseña_nueva: newPassword,
                contraseña_confirmacion: confirmPassword,
                mantener_sesion: keepSession
            };

            try {
                // Mostrar loading
                Swal.fire({
                    title: 'Actualizando...',
                    text: 'Por favor espera un momento',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const response = await fetch('/admin/settings/change-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Contraseña actualizada!',
                        text: data.message,
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Perfecto',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(() => {
                        // Limpiar formulario
                        passwordForm.reset();
                        if (strengthBar) strengthBar.style.width = '0';
                        if (strengthText) strengthText.textContent = '';
                        if (confirmPasswordInput) confirmPasswordInput.style.borderColor = '';

                        // Redirigir si cerró sesión
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al actualizar',
                        text: data.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Intentar de nuevo'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor. Por favor intenta nuevamente.',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Entendido'
                });
            }
        });
    }

    
    // Actualizar informaci{} del usuario
    const profileTab = document.getElementById('profile');
    
    if (profileTab) {
        const profileForm = profileTab.querySelector('.settings-form');
        
        if (profileForm) {
            profileForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const nombre = document.getElementById('name')?.value.trim();
                const email = document.getElementById('email')?.value.trim();

                // Validaciones frontend
                if (!nombre || !email) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos vacíos',
                        text: 'Por favor complete todos los campos',
                        confirmButtonColor: '#7d3f6a',
                        confirmButtonText: 'Entendido'
                    });
                    return;
                }

                // Validar formato de email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Email inválido',
                        text: 'Por favor ingrese un correo electrónico válido',
                        confirmButtonColor: '#7d3f6a',
                        confirmButtonText: 'Entendido'
                    });
                    return;
                }

                // Preparar datos
                const formData = {
                    nombre_usuario: nombre,
                    correo_usuario: email
                };

                try {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Guardando cambios...',
                        text: 'Por favor espera un momento',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const response = await fetch('/admin/settings/update-profile', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Perfil actualizado!',
                            text: data.message,
                            confirmButtonColor: '#10b981',
                            confirmButtonText: 'Perfecto',
                            timer: 3000,
                            timerProgressBar: true
                        });

                        // Actualizar los valores en el formulario si vienen del servidor
                        if (data.data) {
                            document.getElementById('name').value = data.data.nombre_usuario;
                            document.getElementById('email').value = data.data.correo_usuario;
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al actualizar',
                            text: data.message,
                            confirmButtonColor: '#ef4444',
                            confirmButtonText: 'Intentar de nuevo'
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo conectar con el servidor. Por favor intenta nuevamente.',
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Entendido'
                    });
                }
            });
        }
    }
});