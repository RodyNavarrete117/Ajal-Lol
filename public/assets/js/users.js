// Variable global para llevar el conteo de IDs
let nextUserId = 5;

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
        } else {
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
document.getElementById('searchInput').addEventListener('input', function() {
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
    if (visibleCount === 0) {
        noResults.style.display = 'flex';
    } else {
        noResults.style.display = 'none';
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
function editUser(id) {
    const row = document.querySelector(`tr[data-user-id="${id}"]`);
    const name = row.querySelector('.user-name').textContent;
    const email = row.querySelector('.user-email').textContent;
    const roleSpan = row.querySelector('.user-role');
    const role = roleSpan.textContent;
    
    document.getElementById('modalTitle').textContent = 'Editar Usuario';
    document.getElementById('userId').value = id;
    document.getElementById('isEditing').value = 'true';
    document.getElementById('userName').value = name;
    document.getElementById('userEmail').value = email;
    document.getElementById('userRole').value = role;
    document.getElementById('userPassword').value = '';
    document.getElementById('userPassword').required = false;
    document.getElementById('userPassword').placeholder = 'Dejar en blanco para mantener actual';
    document.getElementById('passwordRequired').style.display = 'none';
    document.getElementById('passwordHint').textContent = 'Dejar en blanco para mantener la contraseña actual';
    document.getElementById('submitBtn').textContent = 'Guardar cambios';
    document.getElementById('userModal').classList.add('active');
    document.body.style.overflow = 'hidden';
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
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
}

// ========================================
// FUNCIÓN PARA GUARDAR USUARIO
// ========================================
function saveUser(event) {
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

    if (isEditing) {
        // EDITAR USUARIO EXISTENTE
        updateUserInTable(userId, userName, userEmail, userRole);
        
        Swal.fire({
            icon: 'success',
            title: 'Usuario actualizado',
            text: `Los datos de ${userName} han sido actualizados correctamente`,
            confirmButtonColor: '#7d3f6a',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            closeModal();
            updateStats();
        });
    } else {
        // AGREGAR NUEVO USUARIO
        addUserToTable(nextUserId, userName, userEmail, userRole);
        nextUserId++;
        
        Swal.fire({
            icon: 'success',
            title: 'Usuario creado',
            text: `El usuario ${userName} ha sido creado correctamente`,
            confirmButtonColor: '#7d3f6a',
            confirmButtonText: 'Aceptar',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            }
        }).then(() => {
            closeModal();
            updateStats();
        });
    }
}

// ========================================
// FUNCIÓN PARA ACTUALIZAR USUARIO EN LA TABLA
// ========================================
function updateUserInTable(id, name, email, role) {
    const row = document.querySelector(`tr[data-user-id="${id}"]`);
    
    row.querySelector('.user-name').textContent = name;
    row.querySelector('.user-email').textContent = email;
    
    const roleSpan = row.querySelector('.user-role');
    roleSpan.textContent = role;
    
    // Cambiar clase del badge con animación
    if (role === 'Administrador') {
        roleSpan.className = 'badge badge-admin user-role';
    } else {
        roleSpan.className = 'badge badge-user user-role';
    }
    
    // Agregar efecto de highlight
    row.style.animation = 'none';
    setTimeout(() => {
        row.style.animation = 'pulse 0.5s ease-out';
    }, 10);
}

// ========================================
// FUNCIÓN PARA AGREGAR USUARIO A LA TABLA
// ========================================
function addUserToTable(id, name, email, role) {
    const tbody = document.getElementById('usersTableBody');
    
    const badgeClass = role === 'Administrador' ? 'badge-admin' : 'badge-user';
    
    const newRow = document.createElement('tr');
    newRow.setAttribute('data-user-id', id);
    newRow.className = 'user-row';
    newRow.style.animation = 'fadeInUp 0.5s ease-out';
    newRow.innerHTML = `
        <td data-label="Número" class="user-number">${id}</td>
        <td data-label="Nombre" class="user-name">${name}</td>
        <td data-label="Correo" class="user-email">${email}</td>
        <td data-label="Asignación"><span class="badge ${badgeClass} user-role">${role}</span></td>
        <td data-label="Contraseña"><span class="password-text">******</span></td>
        <td data-label="Acciones">
            <div class="action-buttons">
                <button class="btn-action btn-edit" onclick='editUser(${id})'>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M11.3333 2.00004C11.5084 1.82494 11.716 1.68605 11.9438 1.59129C12.1716 1.49653 12.4151 1.44775 12.6609 1.44775C12.9068 1.44775 13.1502 1.49653 13.3781 1.59129C13.6059 1.68605 13.8135 1.82494 13.9886 2.00004C14.1637 2.17513 14.3026 2.38274 14.3973 2.61057C14.4921 2.83839 14.5409 3.08185 14.5409 3.32771C14.5409 3.57357 14.4921 3.81703 14.3973 4.04485C14.3026 4.27268 14.1637 4.48029 13.9886 4.65538L5.16663 13.4774L1.33329 14.6667L2.52263 10.8334L11.3333 2.00004Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Editar</span>
                </button>
                <button class="btn-action btn-delete" onclick="deleteUser(${id})">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M2 4H3.33333H14M5.33333 4V2.66667C5.33333 2.31304 5.47381 1.97391 5.72386 1.72386C5.97391 1.47381 6.31304 1.33333 6.66667 1.33333H9.33333C9.68696 1.33333 10.0261 1.47381 10.2761 1.72386C10.5262 1.97391 10.6667 2.31304 10.6667 2.66667V4M12.6667 4V13.3333C12.6667 13.687 12.5262 14.0261 12.2761 14.2761C12.0261 14.5262 11.687 14.6667 11.3333 14.6667H4.66667C4.31304 14.6667 3.97391 14.5262 3.72386 14.2761C3.47381 14.0261 3.33333 13.687 3.33333 13.3333V4H12.6667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Borrar</span>
                </button>
            </div>
        </td>
    `;
    
    tbody.appendChild(newRow);
}

// ========================================
// FUNCIÓN PARA ELIMINAR USUARIO
// ========================================
function deleteUser(id) {
    const row = document.querySelector(`tr[data-user-id="${id}"]`);
    const name = row.querySelector('.user-name').textContent;
    
    Swal.fire({
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
    }).then((result) => {
        if (result.isConfirmed) {
            // Animación de salida antes de eliminar
            row.style.animation = 'fadeInUp 0.3s ease-out reverse';
            
            setTimeout(() => {
                // Eliminar la fila de la tabla
                row.remove();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario eliminado',
                    text: `El usuario "${name}" ha sido eliminado correctamente`,
                    confirmButtonColor: '#7d3f6a',
                    confirmButtonText: 'Aceptar',
                    timer: 2000,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    }
                }).then(() => {
                    updateStats();
                });
            }, 300);
        }
    });
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
// INICIALIZAR ESTADÍSTICAS AL CARGAR
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    updateStats();
});