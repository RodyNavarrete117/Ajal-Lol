// ============================================
// VARIABLES GLOBALES
// ============================================
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// ========================================
// ACTUALIZAR ESTADÍSTICAS
// ========================================
function updateStats() {
    const rows = document.querySelectorAll('.user-row');
    const totalUsers = rows.length;
    let adminCount = 0;
    let regularCount = 0;
    
    rows.forEach(row => {
        const role = row.querySelector('.user-role').textContent;
        if (role === 'Administrador') {
            adminCount++;
        } else if (role === 'Editor') {
            regularCount++;
        }
    });
    
    // Animar los números con efecto de conteo
    animateValue('totalUsers', parseInt(document.getElementById('totalUsers').textContent), totalUsers, 500);
    animateValue('adminUsers', parseInt(document.getElementById('adminUsers').textContent), adminCount, 500);
    animateValue('regularUsers', parseInt(document.getElementById('regularUsers').textContent), regularCount, 500);
}

// ========================================
// ANIMAR NÚMEROS CON EFECTO DE CONTEO
// ========================================
function animateValue(id, start, end, duration) {
    const element = document.getElementById(id);
    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;
    
    const timer = setInterval(() => {
        current += increment;
        if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
            current = end;
            clearInterval(timer);
        }
        element.textContent = Math.round(current);
    }, 16);
}

// ========================================
// BÚSQUEDA EN TIEMPO REAL
// ========================================
document.getElementById('searchInput')?.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll('.user-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const name = row.querySelector('.user-name').textContent.toLowerCase();
        const email = row.querySelector('.user-email').textContent.toLowerCase();
        
        if (name.includes(searchTerm) || email.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
            // Agregar animación de fade in
            row.style.animation = 'fadeInUp 0.3s ease-out';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Mostrar mensaje si no hay resultados
    const noResults = document.getElementById('noResults');
    const tableWrapper = document.querySelector('.table-wrapper');
    
    if (visibleCount === 0) {
        noResults.style.display = 'flex';
        tableWrapper.style.display = 'none';
    } else {
        noResults.style.display = 'none';
        tableWrapper.style.display = 'block';
    }
});

// ========================================
// FUNCIÓN PARA ABRIR MODAL DE AGREGAR
// ========================================
function openAddUserModal() {
    document.getElementById('modalTitle').textContent = 'Agregar Nuevo Usuario';
    document.getElementById('userId').value = '';
    document.getElementById('isEditing').value = 'false';
    document.getElementById('userName').value = '';
    document.getElementById('userEmail').value = '';
    document.getElementById('userRole').value = '';
    document.getElementById('userPassword').value = '';
    document.getElementById('userPassword').required = true;
    document.getElementById('userPassword').placeholder = 'Ingrese la contraseña';
    document.getElementById('passwordRequired').style.display = 'inline';
    document.getElementById('passwordHint').textContent = 'Mínimo 6 caracteres';
    document.getElementById('submitBtn').textContent = 'Crear usuario';
    document.getElementById('userModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

// ========================================
// FUNCIÓN PARA EDITAR USUARIO
// ========================================
async function editUser(id) {
    try {
        // Obtener datos del usuario desde el backend
        const response = await fetch(`/admin/users/${id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            const usuario = data.data;
            
            document.getElementById('modalTitle').textContent = 'Editar Usuario';
            document.getElementById('userId').value = usuario.id_usuario;
            document.getElementById('isEditing').value = 'true';
            document.getElementById('userName').value = usuario.nombre_usuario;
            document.getElementById('userEmail').value = usuario.correo_usuario;
            document.getElementById('userRole').value = usuario.cargo_usuario;
            document.getElementById('userPassword').value = '';
            document.getElementById('userPassword').required = false;
            document.getElementById('userPassword').placeholder = 'Dejar en blanco para mantener actual';
            document.getElementById('passwordRequired').style.display = 'none';
            document.getElementById('passwordHint').textContent = 'Dejar en blanco para mantener la contraseña actual';
            document.getElementById('submitBtn').textContent = 'Guardar cambios';
            document.getElementById('userModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'No se pudo cargar la información del usuario',
                confirmButtonColor: '#7d3f6a'
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar la información del usuario',
            confirmButtonColor: '#7d3f6a'
        });
    }
}

// ========================================
// FUNCIÓN PARA CERRAR MODAL
// ========================================
function closeModal() {
    document.getElementById('userModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

// ========================================
// FUNCIÓN PARA TOGGLE PASSWORD
// ========================================
function togglePassword() {
    const passwordInput = document.getElementById('userPassword');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
            <path d="M2.5 10C2.5 10 5 4.16667 10 4.16667C15 4.16667 17.5 10 17.5 10C17.5 10 15 15.8333 10 15.8333C5 15.8333 2.5 10 2.5 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="2" y1="2" x2="18" y2="18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        `;
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
            <path d="M2.5 10C2.5 10 5 4.16667 10 4.16667C15 4.16667 17.5 10 17.5 10C17.5 10 15 15.8333 10 15.8333C5 15.8333 2.5 10 2.5 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        `;
    }
}

// ========================================
// FUNCIÓN PARA GUARDAR USUARIO
// ========================================
async function saveUser(event) {
    event.preventDefault();
    
    const userId = document.getElementById('userId').value;
    const isEditing = document.getElementById('isEditing').value === 'true';
    const userName = document.getElementById('userName').value.trim();
    const userEmail = document.getElementById('userEmail').value.trim();
    const userRole = document.getElementById('userRole').value;
    const userPassword = document.getElementById('userPassword').value;

    // Validaciones
    if (!userName || !userEmail || !userRole) {
        Swal.fire({
            icon: 'error',
            title: 'Campos incompletos',
            text: 'Por favor complete todos los campos requeridos',
            confirmButtonColor: '#7d3f6a'
        });
        return;
    }

    if (!isEditing && !userPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Contraseña requerida',
            text: 'Debe ingresar una contraseña para el nuevo usuario',
            confirmButtonColor: '#7d3f6a'
        });
        return;
    }

    if (userPassword && userPassword.length < 6) {
        Swal.fire({
            icon: 'error',
            title: 'Contraseña muy corta',
            text: 'La contraseña debe tener al menos 6 caracteres',
            confirmButtonColor: '#7d3f6a'
        });
        return;
    }

    // Preparar datos
    const formData = {
        nombre_usuario: userName,
        correo_usuario: userEmail,
        cargo_usuario: userRole,
        contraseña_usuario: userPassword
    };

    try {
        let url, method;
        
        if (isEditing) {
            url = `/admin/users/${userId}`;
            method = 'PUT';
        } else {
            url = '/admin/users';
            method = 'POST';
        }
        
        const response = await fetch(url, {
            method: method,
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
                title: isEditing ? 'Usuario actualizado' : 'Usuario creado',
                text: data.message,
                confirmButtonColor: '#7d3f6a',
                confirmButtonText: 'Aceptar',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                }
            }).then(() => {
                closeModal();
                // Recargar la página para mostrar los cambios
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Ocurrió un error al procesar la solicitud',
                confirmButtonColor: '#7d3f6a'
            });
        }
        
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al procesar la solicitud',
            confirmButtonColor: '#7d3f6a'
        });
    }
}

// ========================================
// FUNCIÓN PARA ELIMINAR USUARIO
// ========================================
async function deleteUser(id) {
    const row = document.querySelector(`tr[data-user-id="${id}"]`);
    const name = row.querySelector('.user-name').textContent;
    
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas eliminar al usuario "${name}"? Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    });
    
    if (result.isConfirmed) {
        try {
            const response = await fetch(`/admin/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Animación de salida antes de eliminar
                row.style.animation = 'fadeInUp 0.3s ease-out reverse';
                
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario eliminado',
                        text: data.message,
                        confirmButtonColor: '#7d3f6a',
                        confirmButtonText: 'Aceptar',
                        timer: 2000,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        }
                    }).then(() => {
                        // Recargar la página para actualizar la lista
                        window.location.reload();
                    });
                }, 300);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'No se pudo eliminar el usuario',
                    confirmButtonColor: '#7d3f6a'
                });
            }
            
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo eliminar el usuario',
                confirmButtonColor: '#7d3f6a'
            });
        }
    }
}

// ========================================
// CERRAR MODAL AL HACER CLIC FUERA
// ========================================
window.onclick = function(event) {
    const modal = document.getElementById('userModal');
    if (event.target === modal) {
        closeModal();
    }
}

// ========================================
// CERRAR MODAL CON TECLA ESC
// ========================================
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});

// ========================================
// INICIALIZAR ESTADÍSTICAS AL CARGAR
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    updateStats();
});