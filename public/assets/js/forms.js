/* ================================================================
   FORMS.JS — Lógica para la vista de Formularios de Contacto
   ================================================================ */

// Variable global para el token CSRF
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// ============================================
// INICIALIZACIÓN (Cuando el DOM está listo)
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    initTableFilters();
    initSelectionLogic();
    initExportLogic();
    initModalEvents();
});


// ============================================
// 1. LÓGICA DE FILTROS, BÚSQUEDA Y ORDENAMIENTO
// ============================================
function initTableFilters() {
    const tbody = document.querySelector('#formsTable tbody');
    if (!tbody) return;

    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const sortDateBtn = document.getElementById('sortDate');
    let currentOrder = 'desc'; 

    // Búsqueda en tiempo real
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const rows = tbody.querySelectorAll('tr:not(.empty-state)');

            rows.forEach(row => {
                const name = row.querySelector('.user-name')?.textContent.toLowerCase() || '';
                const email = row.querySelector('.email-link')?.textContent.toLowerCase() || '';
                const subject = row.querySelector('.subject-text')?.textContent.toLowerCase() || '';

                if (name.includes(searchTerm) || email.includes(searchTerm) || subject.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            updateFooterCount();
        });
    }

    // Filtro por Fecha
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            const filter = this.value;
            const rows = tbody.querySelectorAll('tr:not(.empty-state)');
            const now = new Date();

            rows.forEach(row => {
                const dateStr = row.dataset.date;
                if (!dateStr) return;

                const rowDate = new Date(dateStr);
                let show = true;

                if (filter === 'today') {
                    show = rowDate.toDateString() === now.toDateString();
                } else if (filter === 'week') {
                    const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                    show = rowDate >= weekAgo;
                } else if (filter === 'month') {
                    const monthAgo = new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000);
                    show = rowDate >= monthAgo;
                }

                row.style.display = show ? '' : 'none';
            });
            updateFooterCount();
        });
    }

    // Ordenar por Fecha
    if (sortDateBtn) {
        sortDateBtn.addEventListener('click', function() {
            currentOrder = currentOrder === 'desc' ? 'asc' : 'desc';
            this.dataset.order = currentOrder;
            
            const span = this.querySelector('span');
            if (span) {
                span.textContent = currentOrder === 'desc' ? 'Más reciente' : 'Más antiguo';
            }

            const rows = Array.from(tbody.querySelectorAll('tr:not(.empty-state)'));
            rows.sort((a, b) => {
                const dateA = new Date(a.dataset.date);
                const dateB = new Date(b.dataset.date);
                return currentOrder === 'desc' ? dateB - dateA : dateA - dateB;
            });

            rows.forEach(row => tbody.appendChild(row));
        });
    }

    updateFooterCount();
}

function updateFooterCount() {
    const tbody = document.querySelector('#formsTable tbody');
    if (!tbody) return;
    
    const visibleRows = tbody.querySelectorAll('tr:not(.empty-state):not([style*="display: none"])');
    const total = tbody.querySelectorAll('tr:not(.empty-state)').length;
    const footerInfo = document.querySelector('.footer-info');
    
    if (footerInfo) {
        const showing = visibleRows.length;
        footerInfo.innerHTML = `Mostrando <strong>${showing > 0 ? '1-' + showing : '0'}</strong> de <strong>${total}</strong> registros`;
    }
}


// ============================================
// 2. LÓGICA DE SELECCIÓN DE FILAS Y AVATARES
// ============================================
function initSelectionLogic() {
    const selectionBar = document.getElementById('selectionBar');
    const selCountEl = document.getElementById('selCount');
    const selectAllHeaderCb = document.getElementById('selectAll');
    const tbody = document.querySelector('#formsTable tbody');

    if (!tbody || !selectionBar) return;

    function getChecked() {
        return [...document.querySelectorAll('.row-checkbox')].filter(c => c.checked);
    }

    function updateSelectionBar() {
        const count = getChecked().length;
        if(selCountEl) selCountEl.textContent = count;
        selectionBar.classList.toggle('has-selection', count > 0);
        
        // Sincronizar el checkbox de la cabecera
        if (selectAllHeaderCb) {
            const allBoxes = document.querySelectorAll('.row-checkbox').length;
            selectAllHeaderCb.checked = count === allBoxes && allBoxes > 0;
        }
    }

    function triggerSelectAnimation(tr, selected) {
        tr.classList.remove('row-selected', 'row-unselected');
        void tr.offsetWidth; // fuerza reflow
        if (selected) {
            tr.classList.add('row-selected');
        } else {
            tr.classList.add('row-unselected');
        }
    }

    // Inyectar hint visual a los avatares
    document.querySelectorAll('.user-avatar').forEach(avatar => {
        if (!avatar.querySelector('.avatar-cb-hint')) {
            const hint = document.createElement('span');
            hint.className = 'avatar-cb-hint';
            hint.setAttribute('aria-hidden', 'true');
            avatar.appendChild(hint);
        }

        // Click en el avatar para activar checkbox
        avatar.addEventListener('click', function (e) {
            if (e.target.classList.contains('row-checkbox')) return;
            const cb = this.querySelector('.row-checkbox');
            if (cb) { 
                cb.checked = !cb.checked; 
                cb.dispatchEvent(new Event('change')); 
            }
        });
    });

    // Escuchar cambios en los checkboxes
    document.querySelectorAll('.row-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            triggerSelectAnimation(this.closest('tr'), this.checked);
            updateSelectionBar();
        });
    });

    // Botón "Seleccionar todos" (Barra Flotante)
    const selectAllBtn = document.getElementById('selectAllBtn');
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', () => {
            document.querySelectorAll('.row-checkbox').forEach((cb, i) => {
                if (!cb.checked) {
                    cb.checked = true;
                    setTimeout(() => { triggerSelectAnimation(cb.closest('tr'), true); }, i * 60);
                }
            });
            setTimeout(updateSelectionBar, 0);
        });
    }

    // Checkbox "Seleccionar todos" (Cabecera de la tabla)
    if (selectAllHeaderCb) {
        selectAllHeaderCb.addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.row-checkbox').forEach(cb => {
                if (cb.checked !== isChecked) {
                    cb.checked = isChecked;
                    triggerSelectAnimation(cb.closest('tr'), isChecked);
                }
            });
            updateSelectionBar();
        });
    }

    // Botón "Limpiar selección"
    const clearSelBtn = document.getElementById('clearSelBtn');
    if (clearSelBtn) {
        clearSelBtn.addEventListener('click', () => {
            document.querySelectorAll('.row-checkbox').forEach(cb => {
                if(cb.checked) {
                    cb.checked = false;
                    triggerSelectAnimation(cb.closest('tr'), false);
                }
            });
            updateSelectionBar();
        });
    }

    // Botón "Eliminar seleccionados"
    const deleteSelBtn = document.getElementById('deleteSelBtn');
    if (deleteSelBtn) {
        deleteSelBtn.addEventListener('click', () => {
            const ids = getChecked().map(cb => cb.value);
            if (!ids.length) return;
            
            Swal.fire({
                title: `¿Eliminar ${ids.length} registro(s)?`,
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(r => { 
                if (r.isConfirmed) {
                    console.log('Falta implementar la ruta backend para eliminar múltiples. IDs:', ids);
                    // Aquí iría tu fetch a deleteMultiple
                } 
            });
        });
    }
}


// ============================================
// 3. EXPORTAR A PDF
// ============================================
function initExportLogic() {
    const exportButton = document.querySelector('.export-button');
    if (exportButton) {
        exportButton.addEventListener('click', exportForms);
    }
}

async function exportForms() {
    Swal.fire({
        title: 'Exportando...',
        text: 'Generando archivo PDF',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    try {
        const response = await fetch('/admin/forms/export/pdf', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/pdf'
            }
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => null);
            throw new Error(errorData?.message || 'Error al generar PDF');
        }

        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'formularios_contacto.pdf';
        document.body.appendChild(link);
        link.click();
        link.remove();
        window.URL.revokeObjectURL(url);

        Swal.fire({ icon: 'success', title: '¡Listo!', text: 'PDF generado correctamente', confirmButtonColor: '#7c3f69' });
    } catch (error) {
        console.error('Error exportando PDF:', error);
        Swal.fire({ icon: 'error', title: 'Error', text: error.message, confirmButtonColor: '#ef4444' });
    }
}


// ============================================
// 4. LÓGICA DEL MODAL PERSONALIZADO (VIEW FORM)
// ============================================
let currentModalId = null;

function initModalEvents() {
    const modalOverlay = document.getElementById('formModalOverlay');
    const modalBtnDelete = document.getElementById('modalBtnDelete');
    const modalCloseBtn = document.getElementById('modalClose');
    const modalBtnCloseFooter = document.getElementById('modalBtnClose');

    if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
    if (modalBtnCloseFooter) modalBtnCloseFooter.addEventListener('click', closeModal);
    
    if (modalOverlay) {
        modalOverlay.addEventListener('click', e => { 
            if (e.target === modalOverlay) closeModal(); 
        });
    }
    
    document.addEventListener('keydown', e => { 
        if (e.key === 'Escape' && document.getElementById('formModalOverlay')?.classList.contains('is-open')) {
            closeModal(); 
        }
    });

    if (modalBtnDelete) {
        modalBtnDelete.addEventListener('click', () => {
            if (!currentModalId) return;
            closeModal();
            deleteForm(currentModalId);
        });
    }
}

function openModal() { 
    const overlay = document.getElementById('formModalOverlay');
    if(overlay) overlay.classList.add('is-open');    
    document.body.style.overflow = 'hidden'; 
}

function closeModal() { 
    const overlay = document.getElementById('formModalOverlay');
    if(overlay) overlay.classList.remove('is-open'); 
    document.body.style.overflow = ''; 
    currentModalId = null; 
}

// Global para poder ser llamada desde los botones onclick="..." del HTML
window.viewForm = async function(id) {
    currentModalId = id;
    
    const modalAvatar = document.getElementById('modalAvatar');
    const modalName = document.getElementById('modalName');
    const modalAsunto = document.getElementById('modalAsunto');
    const modalCorreo = document.getElementById('modalCorreo');
    const modalTelefono = document.getElementById('modalTelefono');
    const modalFecha = document.getElementById('modalFecha');
    const modalMensaje = document.getElementById('modalMensaje');

    // Estado de carga
    if(modalAvatar) modalAvatar.textContent = '…';
    if(modalName) modalName.textContent = 'Cargando…';
    if(modalAsunto) modalAsunto.textContent = '';
    if(modalCorreo) modalCorreo.innerHTML = '—';
    if(modalTelefono) modalTelefono.innerHTML = '—';
    if(modalFecha) modalFecha.textContent = '—';
    if(modalMensaje) modalMensaje.textContent = '—';
    
    openModal();

    try {
        const res = await fetch(`/admin/forms/${id}`, {
            headers: { 
                'X-CSRF-TOKEN': csrfToken, 
                'Accept': 'application/json' 
            }
        });
        const data = await res.json();

        if (data.success) {
            const f = data.data;
            const fecha = new Date(f.fecha_envio).toLocaleString('es-MX', {
                year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
            });

            if(modalAvatar) modalAvatar.textContent = f.nombre_completo.charAt(0).toUpperCase();
            if(modalName) modalName.textContent = f.nombre_completo;
            if(modalAsunto) modalAsunto.textContent = f.asunto || 'Sin asunto';
            if(modalCorreo) modalCorreo.innerHTML = `<a href="mailto:${f.correo}">${f.correo}</a>`;
            if(modalTelefono) modalTelefono.innerHTML = f.numero_telefonico 
                ? `<a href="tel:${f.numero_telefonico}">${f.numero_telefonico}</a>` 
                : `<span style="color:var(--text-muted)">No proporcionado</span>`;
            if(modalFecha) modalFecha.textContent = fecha;
            if(modalMensaje) modalMensaje.textContent = f.mensaje || 'Sin mensaje';
            
        } else {
            closeModal();
            Swal.fire({ icon: 'error', title: 'Error', text: data.message, confirmButtonColor: '#7c3f69' });
        }
    } catch (err) {
        closeModal();
        Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo cargar el formulario', confirmButtonColor: '#7c3f69' });
    }
};


// ============================================
// 5. ELIMINAR FORMULARIO (Global)
// ============================================
window.deleteForm = async function(id) {
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch(`/admin/forms/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Eliminado!',
                    text: data.message,
                    confirmButtonColor: '#10b981',
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message, confirmButtonColor: '#7c3f69' });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo eliminar el formulario', confirmButtonColor: '#7c3f69' });
        }
    }
};