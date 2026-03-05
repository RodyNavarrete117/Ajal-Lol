// ============================================
// VARIABLES GLOBALES
// ============================================
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// ========================================
// HELPER PARA BLOQUEAR SCROLL EN SWEETALERT
// ========================================
const swalScrollFix = {
    didOpen: () => {
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
    },
    didClose: () => {
        document.body.style.overflow = '';
        document.documentElement.style.overflow = '';
    }
};

// ========================================
// TOAST NOTIFICATIONS
// ========================================

function showErrorAlert(title, message) {
    Swal.fire({
        title: title,
        html: `<div style="display:flex;flex-direction:column;align-items:center;gap:12px;">
            <div style="width:52px;height:52px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p style="margin:0;font-size:14px;opacity:0.85">${message}</p>
        </div>`,
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#7d3f6a',
        customClass: { popup: 'swal-custom-popup', title: 'swal-custom-title', confirmButton: 'swal-confirm-btn' },
        buttonsStyling: true,
        ...swalScrollFix // <--- Bloqueo de scroll inyectado
    });
}

function showToast(type, title, message) {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const icons = {
        success: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
        error:   `<svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>`
    };

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-icon">${icons[type]}</div>
        <div class="toast-body">
            <div class="toast-title">${title}</div>
            ${message ? `<div class="toast-message">${message}</div>` : ''}
        </div>
        <button class="toast-close" onclick="dismissToast(this.parentElement)">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </button>
        <div class="toast-progress"></div>
    `;

    container.appendChild(toast);

    setTimeout(() => dismissToast(toast), 3000);
}

function dismissToast(toast) {
    if (!toast || toast.classList.contains('toast-hide')) return;
    toast.classList.add('toast-hide');
    setTimeout(() => toast.remove(), 300);
}



// ========================================
// CUSTOM SELECT
// ========================================
function initCustomSelect() {
    const realSelect = document.getElementById('userRole');
    if (!realSelect) return;

    const wrapper = document.createElement('div');
    wrapper.className = 'custom-select-wrapper';
    wrapper.id = 'customRoleSelect';
    realSelect.parentNode.insertBefore(wrapper, realSelect);
    realSelect.style.display = 'none';
    wrapper.appendChild(realSelect);

    const trigger = document.createElement('div');
    trigger.className = 'custom-select-trigger placeholder';
    trigger.innerHTML = `<span class="trigger-text">Seleccione un rol</span>
        <svg class="arrow" viewBox="0 0 24 24" fill="none" width="16" height="16"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
    wrapper.appendChild(trigger);

    const dropdown = document.createElement('div');
    dropdown.className = 'custom-select-dropdown';
    dropdown.style.display = 'none';
    dropdown.style.position = 'fixed';
    dropdown.style.zIndex = '99999';
    document.body.appendChild(dropdown);

    const options = [
        { value: '',              label: 'Seleccione un rol', disabled: true },
        { value: 'administrador', label: 'Administrador' },
        { value: 'editor',        label: 'Editor' },
    ];

    options.forEach(opt => {
        const div = document.createElement('div');
        div.className = 'custom-select-option' + (opt.disabled ? ' disabled' : '');
        div.textContent = opt.label;
        div.dataset.value = opt.value;
        if (!opt.disabled) {
            div.addEventListener('mousedown', (e) => {
                e.preventDefault();
                realSelect.value = opt.value;
                trigger.querySelector('.trigger-text').textContent = opt.label;
                trigger.classList.remove('placeholder');
                dropdown.querySelectorAll('.custom-select-option').forEach(o => o.classList.remove('selected'));
                div.classList.add('selected');
                closeDropdown();
            });
        }
        dropdown.appendChild(div);
    });

    function openDropdown() {
        const rect = trigger.getBoundingClientRect();
        dropdown.style.display = 'block';
        dropdown.style.top   = rect.bottom + window.scrollY + 'px';
        dropdown.style.left  = rect.left + window.scrollX + 'px';
        dropdown.style.width = rect.width + 'px';
        wrapper.classList.add('open');
    }

    function closeDropdown() {
        dropdown.classList.add('closing');
        wrapper.classList.remove('open');
        setTimeout(() => {
            dropdown.style.display = 'none';
            dropdown.classList.remove('closing');
        }, 150);
    }

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        wrapper.classList.contains('open') ? closeDropdown() : openDropdown();
    });

    document.addEventListener('click', (e) => {
        if (!wrapper.contains(e.target) && !dropdown.contains(e.target)) {
            closeDropdown();
        }
    });
}

function setCustomSelectValue(value) {
    const wrapper = document.getElementById('customRoleSelect');
    if (!wrapper) return;
    const trigger = wrapper.querySelector('.custom-select-trigger');
    const options = wrapper.querySelectorAll('.custom-select-option');
    options.forEach(opt => {
        opt.classList.remove('selected');
        if (opt.dataset.value === value) {
            opt.classList.add('selected');
            trigger.querySelector('.trigger-text').textContent = opt.textContent;
            trigger.classList.remove('placeholder');
        }
    });
    if (!value) {
        trigger.querySelector('.trigger-text').textContent = 'Seleccione un rol';
        trigger.classList.add('placeholder');
    }
    document.getElementById('userRole').value = value;
}

function resetCustomSelect() {
    setCustomSelectValue('');
}

// ========================================
// DOM HELPERS — actualizar sin recargar
// ========================================
function updateUserRow(userId, name, email, role) {
    const row = document.querySelector(`tr[data-user-id="${userId}"]`);
    if (!row) return;
    row.querySelector('.user-name').textContent  = name;
    row.querySelector('.user-email').textContent = email;
    const badge = row.querySelector('.user-role');
    const isAdmin = role.toLowerCase() === 'administrador';
    badge.textContent = role.charAt(0).toUpperCase() + role.slice(1).toLowerCase();
    badge.className   = `badge ${isAdmin ? 'badge-admin' : 'badge-user'} user-role`;
    row.style.animation = 'none';
    row.offsetHeight;
    row.style.animation = 'fadeInUp 0.4s ease-out';
}

function addUserRow(usuario) {
    const tbody = document.getElementById('usersTableBody');
    const rowCount = tbody.querySelectorAll('.user-row').length + 1;
    const isAdmin  = usuario.cargo_usuario?.toLowerCase() === 'administrador';
    const role     = usuario.cargo_usuario ? usuario.cargo_usuario.charAt(0).toUpperCase() + usuario.cargo_usuario.slice(1).toLowerCase() : 'Sin rol';
    const tr = document.createElement('tr');
    tr.className = 'user-row';
    tr.dataset.userId = usuario.id_usuario;
    tr.style.animation = 'fadeInUp 0.4s ease-out';
    tr.innerHTML = `
        <td data-label="Número" class="user-number">${rowCount}</td>
        <td data-label="Nombre" class="user-name">${usuario.nombre_usuario}</td>
        <td data-label="Correo" class="user-email">${usuario.correo_usuario}</td>
        <td data-label="Asignación"><span class="badge ${isAdmin ? 'badge-admin' : 'badge-user'} user-role">${role}</span></td>
        <td data-label="Contraseña"><span class="password-text">******</span></td>
        <td data-label="Acciones">
            <div class="action-buttons">
                <button class="btn-action btn-edit" onclick="editUser(${usuario.id_usuario})">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M11.3333 2.00004C11.5084 1.82494 11.716 1.68605 11.9438 1.59129C12.1716 1.49653 12.4151 1.44775 12.6609 1.44775C12.9068 1.44775 13.1502 1.49653 13.3781 1.59129C13.6059 1.68605 13.8135 1.82494 13.9886 2.00004C14.1637 2.17513 14.3026 2.38274 14.3973 2.61057C14.4921 2.83839 14.5409 3.08185 14.5409 3.32771C14.5409 3.57357 14.4921 3.81703 14.3973 4.04485C14.3026 4.27268 14.1637 4.48029 13.9886 4.65538L5.16663 13.4774L1.33329 14.6667L2.52263 10.8334L11.3333 2.00004Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Editar</span>
                </button>
                <button class="btn-action btn-delete" onclick="deleteUser(${usuario.id_usuario})">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 4H3.33333H14M5.33333 4V2.66667C5.33333 2.31304 5.47381 1.97391 5.72386 1.72386C5.97391 1.47381 6.31304 1.33333 6.66667 1.33333H9.33333C9.68696 1.33333 10.0261 1.47381 10.2761 1.72386C10.5262 1.97391 10.6667 2.31304 10.6667 2.66667V4M12.6667 4V13.3333C12.6667 13.687 12.5262 14.0261 12.2761 14.2761C12.0261 14.5262 11.687 14.6667 11.3333 14.6667H4.66667C4.31304 14.6667 3.97391 14.5262 3.72386 14.2761C3.47381 14.0261 3.33333 13.687 3.33333 13.3333V4H12.6667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Borrar</span>
                </button>
            </div>
        </td>`;
    tbody.appendChild(tr);

    // Hide empty state if visible
    const noResults    = document.getElementById('noResults');
    const tableWrapper = document.querySelector('.table-wrapper');
    if (noResults)    noResults.style.display    = 'none';
    if (tableWrapper) tableWrapper.style.display = 'block';
}

function renumberRows() {
    document.querySelectorAll('.user-row').forEach((row, i) => {
        const cell = row.querySelector('.user-number');
        if (cell) cell.textContent = i + 1;
    });
}

// ========================================
// ACTUALIZAR ESTADÍSTICAS
// ========================================
function updateStats() {
    const rows = document.querySelectorAll('.user-row');
    const totalUsers = rows.length;
    let adminCount = 0;
    let regularCount = 0;
    
    rows.forEach(row => {
        const roleElement = row.querySelector('.user-role');
        if (roleElement) {
            const role = roleElement.textContent.trim().toLowerCase();
            if (role === 'administrador') adminCount++;
            else if (role === 'editor') regularCount++;
        }
    });
    
    const totalElement  = document.getElementById('totalUsers');
    const adminElement  = document.getElementById('adminUsers');
    const regularElement = document.getElementById('regularUsers');
    
    if (totalElement)   animateValue('totalUsers',   parseInt(totalElement.textContent)   || 0, totalUsers,   500);
    if (adminElement)   animateValue('adminUsers',   parseInt(adminElement.textContent)   || 0, adminCount,   500);
    if (regularElement) animateValue('regularUsers', parseInt(regularElement.textContent) || 0, regularCount, 500);
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
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.user-row');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const nameElement  = row.querySelector('.user-name');
            const emailElement = row.querySelector('.user-email');
            
            if (nameElement && emailElement) {
                const name  = nameElement.textContent.toLowerCase();
                const email = emailElement.textContent.toLowerCase();
                
                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                    row.style.animation = 'fadeInUp 0.3s ease-out';
                } else {
                    row.style.display = 'none';
                }
            }
        });
        
        const noResults   = document.getElementById('noResults');
        const tableWrapper = document.querySelector('.table-wrapper');
        
        if (noResults && tableWrapper) {
            if (visibleCount === 0 && searchTerm !== '') {
                noResults.style.display = 'flex';
                tableWrapper.style.display = 'none';
            } else {
                noResults.style.display = 'none';
                tableWrapper.style.display = 'block';
            }
        }
    });
}

// ========================================
// FUNCIÓN PARA ABRIR MODAL DE AGREGAR
// ========================================
function openAddUserModal() {
    document.getElementById('modalTitle').textContent = 'Agregar Nuevo Usuario';
    document.getElementById('userId').value = '';
    document.getElementById('isEditing').value = 'false';
    document.getElementById('userName').value = '';
    document.getElementById('userEmail').value = '';
    resetCustomSelect();
    document.getElementById('userPassword').value = '';
    document.getElementById('userPassword').required = true;
    document.getElementById('userPassword').placeholder = 'Ingrese la contraseña';
    document.getElementById('passwordRequired').style.display = 'inline';
    document.getElementById('passwordHint').textContent = 'Mínimo 6 caracteres';
    document.getElementById('submitBtn').textContent = 'Crear usuario';
    document.getElementById('userModal').classList.add('active');
    document.documentElement.classList.add('modal-open');
    
    // --- BLOQUEAR SCROLL ---
    document.body.style.overflow = 'hidden';
    document.documentElement.style.overflow = 'hidden';
}

// ========================================
// FUNCIÓN PARA EDITAR USUARIO
// ========================================
async function editUser(id) {
    try {
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
            setCustomSelectValue(usuario.cargo_usuario);
            document.getElementById('userPassword').value = '';
            document.getElementById('userPassword').required = false;
            document.getElementById('userPassword').placeholder = 'Dejar en blanco para mantener actual';
            document.getElementById('passwordRequired').style.display = 'none';
            document.getElementById('passwordHint').textContent = 'Dejar en blanco para mantener la contraseña actual';
            document.getElementById('submitBtn').textContent = 'Guardar cambios';
            document.getElementById('userModal').classList.add('active');
            
            // --- BLOQUEAR SCROLL ---
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'No se pudo cargar la información del usuario', confirmButtonColor: '#7d3f6a', ...swalScrollFix });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo cargar la información del usuario', confirmButtonColor: '#7d3f6a', ...swalScrollFix });
    }
}

// ========================================
// FUNCIÓN PARA CERRAR MODAL
// ========================================
function closeModal() {
    const modal = document.getElementById('userModal');
    modal.classList.add('closing');
    setTimeout(() => {
        modal.classList.remove('active', 'closing');
        document.documentElement.classList.remove('modal-open');
        
        // --- RESTAURAR SCROLL ---
        document.body.style.overflow = '';
        document.documentElement.style.overflow = '';
    }, 250);
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
    
    const userId      = document.getElementById('userId').value;
    const isEditing   = document.getElementById('isEditing').value === 'true';
    const userName    = document.getElementById('userName').value.trim();
    const userEmail   = document.getElementById('userEmail').value.trim();
    const userRole    = document.getElementById('userRole').value;
    const userPassword = document.getElementById('userPassword').value;

    if (!userName || !userEmail || !userRole) {
        showErrorAlert('Campos incompletos', 'Por favor complete todos los campos requeridos');
        return;
    }

    if (!isEditing && !userPassword) {
        showErrorAlert('Contraseña requerida', 'Debe ingresar una contraseña para el nuevo usuario');
        return;
    }

    if (userPassword && userPassword.length < 6) {
        showErrorAlert('Contraseña muy corta', 'La contraseña debe tener al menos 6 caracteres');
        return;
    }

    const formData = {
        nombre_usuario:      userName,
        correo_usuario:      userEmail,
        cargo_usuario:       userRole,
        contraseña_usuario:  userPassword
    };

    try {
        const url    = isEditing ? `/admin/users/${userId}` : '/admin/users';
        const method = isEditing ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            closeModal();
            showToast('success', isEditing ? 'Usuario actualizado' : 'Usuario creado', data.message);
            if (isEditing) {
                updateUserRow(userId, userName, userEmail, userRole);
            } else {
                if (data.data && data.data.id_usuario) {
                    addUserRow(data.data);
                } else {
                    setTimeout(() => window.location.reload(), 800);
                }
            }
            updateStats();
        } else {
            showErrorAlert('Error', data.message || 'Ocurrió un error al procesar la solicitud');
        }
        
    } catch (error) {
        console.error('Error:', error);
        showErrorAlert('Error', 'Ocurrió un error al procesar la solicitud');
    }
}

// ========================================
// FUNCIÓN PARA ELIMINAR USUARIO
// ========================================
async function deleteUser(id) {
    const row = document.querySelector(`tr[data-user-id="${id}"]`);
    
    if (!row) {
        showErrorAlert('Error', 'No se pudo encontrar el usuario');
        return;
    }
    
    const nameElement = row.querySelector('.user-name');
    const name = nameElement ? nameElement.textContent : 'este usuario';
    
    const result = await Swal.fire({
        title: 'Eliminar usuario',
        html: `<div style="display:flex;flex-direction:column;align-items:center;gap:12px;">
            <div style="width:56px;height:56px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p style="margin:0;font-size:15px;color:var(--swal2-html-container-color)">¿Eliminar a <strong>${name}</strong>?<br><span style="font-size:13px;opacity:0.7">Esta acción no se puede deshacer.</span></p>
        </div>`,
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        customClass: {
            popup: 'swal-custom-popup',
            title: 'swal-custom-title',
            confirmButton: 'swal-confirm-btn',
            cancelButton: 'swal-cancel-btn',
        },
        buttonsStyling: true,
        focusCancel: true,
        ...swalScrollFix // <--- Bloqueo de scroll inyectado
    });
    
    if (result.isConfirmed) {
        try {
            const response = await fetch(`/admin/users/${id}`, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            
            const data = await response.json();
            
            if (data.success) {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    row.remove();
                    renumberRows();
                    updateStats();
                    showToast('success', 'Usuario eliminado', data.message);
                }, 300);
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'No se pudo eliminar el usuario', confirmButtonColor: '#7d3f6a', ...swalScrollFix });
            }
            
        } catch (error) {
            console.error('Error:', error);
            showErrorAlert('Error', 'No se pudo eliminar el usuario');
        }
    }
}

// ========================================
// CERRAR MODAL AL HACER CLIC FUERA / ESC
// ========================================
window.onclick = function(event) {
    const modal = document.getElementById('userModal');
    if (event.target === modal) closeModal();
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') closeModal();
});

// ========================================
// INICIALIZAR ESTADÍSTICAS AL CARGAR
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    updateStats();
    initCustomSelect();
});