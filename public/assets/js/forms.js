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
    initCustomSelects();
    initMobileSearch(); 
    updateSelectionBarPosition();
    renderPage(); 
});

function initMobileSearch() {
    const searchBox   = document.querySelector('.search-box');
    const searchIcon  = document.querySelector('.search-icon');
    const searchInput = document.getElementById('searchInput');
    if (!searchBox || !searchIcon || !searchInput) return;

    searchIcon.addEventListener('click', (e) => {
        e.stopPropagation(); // evita que el click cierre inmediatamente
        const expanded = searchBox.classList.toggle('is-expanded');
        if (expanded) {
            searchInput.focus();
        } else {
            searchInput.value = '';
            filterTerm  = '';
            currentPage = 1;
            renderPage();
        }
    });

    // Contraer al hacer click fuera
    document.addEventListener('click', e => {
        if (!searchBox.contains(e.target)) {
            if (searchBox.classList.contains('is-expanded')) {
                searchBox.classList.remove('is-expanded');
                searchInput.value = '';
                filterTerm  = '';
                currentPage = 1;
                renderPage();
            }
        }
    });

    // Contraer al presionar Escape
    searchInput.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            searchBox.classList.remove('is-expanded');
            searchInput.value = '';
            filterTerm  = '';
            currentPage = 1;
            renderPage();
        }
    });
}

// ============================================
// 1. LÓGICA DE FILTROS, BÚSQUEDA Y ORDENAMIENTO
// ============================================
function initTableFilters() {
    const tbody = document.querySelector('#formsTable tbody');
    if (!tbody) return;

    const searchInput = document.getElementById('searchInput');
    const dateFilter  = document.getElementById('dateFilter');
    const sortDateBtn = document.getElementById('sortDate');
    let currentOrder  = 'desc';

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterTerm  = this.value.toLowerCase().trim();
            currentPage = 1;
            renderPage();
        });
    }

    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            filterDate  = this.value;
            currentPage = 1;
            renderPage();
        });
    }

    if (sortDateBtn) {
        sortDateBtn.addEventListener('click', function() {
            currentOrder = currentOrder === 'desc' ? 'asc' : 'desc';
            this.dataset.order = currentOrder;
            const span = this.querySelector('span');
            if (span) span.textContent = currentOrder === 'desc' ? 'Más reciente' : 'Más antiguo';

            const rows = Array.from(tbody.querySelectorAll('tr:not(.empty-state)'));
            rows.sort((a, b) => {
                const dateA = new Date(a.dataset.date);
                const dateB = new Date(b.dataset.date);
                return currentOrder === 'desc' ? dateB - dateA : dateA - dateB;
            });
            rows.forEach(row => tbody.appendChild(row));
            renderPage();
        });
    }
}

function updateFooterCount(showing, total) {
    const footerInfo = document.querySelector('.footer-info');
    if (footerInfo) {
        footerInfo.innerHTML = `Mostrando <strong>${showing > 0 ? showing : '0'}</strong> de <strong>${total}</strong> registros`;
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
        if (selCountEl) selCountEl.textContent = count;
        selectionBar.classList.toggle('has-selection', count > 0);

        if (selectAllHeaderCb) {
            const allBoxes = document.querySelectorAll('.row-checkbox').length;
            selectAllHeaderCb.checked = count === allBoxes && allBoxes > 0;
        }

        // Si hay seleccionados, mostrar todos sin paginación
        if (count > 0) {
            getAllFormRows().forEach(row => row.style.display = '');
            // Ocultar paginación
            const tableFooter = document.querySelector('.table-footer');
            if (tableContainer) tableContainer.style.marginBottom = '80px';
            if (tableFooter) tableFooter.style.display = 'none';
        } else {
            // Al limpiar selección, volver a la paginación normal
            const tableFooter = document.querySelector('.table-footer');
            if (tableContainer) tableContainer.style.marginBottom = '';
            if (tableFooter) tableFooter.style.display = '';
            renderPage();
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

    const exportSelBtn = document.getElementById('exportSelBtn');
        if (exportSelBtn) {
            exportSelBtn.addEventListener('click', () => {
                const ids = getChecked().map(cb => cb.value);
                if (!ids.length) return;
                exportSelectedForms(ids);
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

async function exportSelectedForms(ids) {
    showExportToast('loading');

    try {
        const params = ids.map(id => `ids[]=${id}`).join('&');
        const response = await fetch(`/admin/forms/export/pdf?${params}`, {
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
        link.download = `formularios_seleccionados_${ids.length}.pdf`;
        document.body.appendChild(link);
        link.click();
        link.remove();
        window.URL.revokeObjectURL(url);

        showExportToast('success');

    } catch (error) {
        console.error('Error exportando PDF:', error);
        showExportToast('error', error.message);
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
    // Mostrar toast de carga
    showExportToast('loading');

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

        showExportToast('success');

    } catch (error) {
        console.error('Error exportando PDF:', error);
        showExportToast('error', error.message);
    }
}

function showExportToast(type, message = '') {
    const existing = document.getElementById('exportToast');
    if (existing) {
        existing.classList.remove('show');
        setTimeout(() => existing.remove(), 300);
    }

    const configs = {
        loading: {
            icon: `<svg width="18" height="18" viewBox="0 0 20 20" fill="none" style="animation:spin 0.8s linear infinite">
                <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                <path d="M10 2a8 8 0 0 1 8 8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>`,
            title: 'Generando PDF',
            msg: 'Por favor espera...',
            extraClass: 'toast-loading',
            progress: `<div class="toast-progress-indeterminate"></div>`,
            autohide: false,
        },
        success: {
            icon: `<svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                <path d="M5 10l4 4 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>`,
            title: '¡PDF listo!',
            msg: 'Descarga completada',
            extraClass: '',
            progress: `<div class="toast-progress"></div>`,
            autohide: true,
        },
        error: {
            icon: `<svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                <path d="M6 6l8 8M14 6l-8 8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>`,
            title: 'Error al generar',
            msg: message || 'Intenta de nuevo',
            extraClass: 'toast-error',
            progress: `<div class="toast-progress"></div>`,
            autohide: true,
        }
    };

    const c = configs[type];
    const toast = document.createElement('div');
    toast.id = 'exportToast';
    toast.className = `${c.extraClass}`;

    toast.innerHTML = `
        <div class="toast-icon">${c.icon}</div>
        <div class="toast-body">
            <div class="toast-title">${c.title}</div>
            <div class="toast-msg">${c.msg}</div>
        </div>
        ${c.progress}
    `;

    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));

    if (c.autohide) {
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 350);
        }, 2800);
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
    
    // Bloqueamos el scroll tanto en body como en html
    document.body.style.overflow = 'hidden'; 
    document.documentElement.style.overflow = 'hidden'; 
}

function closeModal() { 
    const overlay = document.getElementById('formModalOverlay');
    if(overlay) overlay.classList.remove('is-open'); 
    
    // Restauramos el scroll
    document.body.style.overflow = ''; 
    document.documentElement.style.overflow = ''; 
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

// ============================================
// 6. PAGINACIÓN
// ============================================
const ROWS_PER_PAGE = 5;
let currentPage = 1;
let filterTerm  = '';
let filterDate  = '';

function getAllFormRows() {
    return Array.from(document.querySelectorAll(
        '#formsTable tbody tr:not(.empty-state):not(.dynamic-empty)'
    ));
}

function getFilteredFormRows() {
    const now = new Date();
    return getAllFormRows().filter(row => {
        const name    = row.querySelector('.user-name')?.textContent.toLowerCase()    || '';
        const email   = row.querySelector('.email-link')?.textContent.toLowerCase()   || '';
        const subject = row.querySelector('.subject-text')?.textContent.toLowerCase() || '';
        const matchSearch = !filterTerm || name.includes(filterTerm) || email.includes(filterTerm) || subject.includes(filterTerm);

        let matchDate = true;
        if (filterDate && row.dataset.date) {
            const rowDate = new Date(row.dataset.date);
            if (filterDate === 'today') {
                matchDate = rowDate.toDateString() === now.toDateString();
            } else if (filterDate === 'week') {
                matchDate = rowDate >= new Date(now - 7 * 86400000);
            } else if (filterDate === 'month') {
                matchDate = rowDate >= new Date(now - 30 * 86400000);
            } else if (filterDate === 'year') {
                matchDate = rowDate.getFullYear() === now.getFullYear();
            }
        }

        return matchSearch && matchDate;
    });
}

function updateEmptyState() {
    const tbody       = document.querySelector('#formsTable tbody');
    const tableFooter = document.querySelector('.table-footer');
    const searchBox   = document.querySelector('.search-box');
    const sortButton  = document.getElementById('sortDate');
    const exportBtn   = document.querySelector('.export-button');
    if (!tbody) return;

    const existing = tbody.querySelector('.dynamic-empty');
    if (existing) existing.remove();

    const filtered = getFilteredFormRows();
    const allRows  = getAllFormRows();

    const thead       = document.querySelector('#formsTable thead');
    const tableToolbar = document.querySelector('.table-toolbar');
    const tableContainer = document.querySelector('.table-container');  
    const noData = allRows.length === 0 || filtered.length === 0;

    // Ocultar/mostrar: búsqueda, sort, export y columnas
    [searchBox, sortButton, exportBtn, thead].forEach(el => {
        if (el) el.style.display = noData ? 'none' : '';
    });

    // Ocultar/mostrar footer
    if (tableFooter) tableFooter.style.display = noData ? 'none' : '';

    // Centrar el toolbar cuando solo queda el select de fecha
    if (noData) {
        tableToolbar?.classList.add('only-filter');
        tableContainer?.classList.add('no-data');
        // Bloquear scroll solo en móvil
        if (window.innerWidth <= 767) {
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';
        }
    } else {
        tableToolbar?.classList.remove('only-filter');
        tableContainer?.classList.remove('no-data');
        // Restaurar scroll
        document.body.style.overflow = '';
        document.documentElement.style.overflow = '';
    }

    if (noData && allRows.length > 0) {
        // Hay datos pero el filtro no devuelve nada — mostrar mensaje
        const labels = {
            '':      null,
            'today': 'hoy',
            'week':  'esta semana',
            'month': 'este mes',
            'year':  'este año',
        };

        const searchLabel = filterTerm
            ? `"${filterTerm}"`
            : (labels[filterDate] ? `para ${labels[filterDate]}` : null);

        const mensaje = searchLabel
            ? `No hay registros ${searchLabel}`
            : 'No hay registros que coincidan';

        const iconos = {
            'today': `<svg width="56" height="56" viewBox="0 0 56 56" fill="none">
                <circle cx="28" cy="28" r="26" stroke="#e5e7eb" stroke-width="3"/>
                <path d="M20 28h16M28 20v16" stroke="#9ca3af" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="28" cy="28" r="4" fill="#e5e7eb"/>
              </svg>`,
            'week':  `<svg width="56" height="56" viewBox="0 0 56 56" fill="none">
                <rect x="10" y="14" width="36" height="32" rx="4" stroke="#e5e7eb" stroke-width="3"/>
                <path d="M10 22h36M20 10v8M36 10v8" stroke="#9ca3af" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M18 32h4m4 0h4m4 0h4" stroke="#e5e7eb" stroke-width="2" stroke-linecap="round"/>
              </svg>`,
            'month': `<svg width="56" height="56" viewBox="0 0 56 56" fill="none">
                <rect x="10" y="14" width="36" height="32" rx="4" stroke="#e5e7eb" stroke-width="3"/>
                <path d="M10 22h36M20 10v8M36 10v8" stroke="#9ca3af" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="28" cy="36" r="5" stroke="#e5e7eb" stroke-width="2"/>
                <path d="M26 36l2 2 4-4" stroke="#9ca3af" stroke-width="1.8" stroke-linecap="round"/>
              </svg>`,
            'year':  `<svg width="56" height="56" viewBox="0 0 56 56" fill="none">
                <circle cx="28" cy="28" r="20" stroke="#e5e7eb" stroke-width="3"/>
                <path d="M28 16v12l7 7" stroke="#9ca3af" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M14 28h4M38 28h4M28 14v4M28 38v4" stroke="#e5e7eb" stroke-width="2" stroke-linecap="round"/>
              </svg>`,
            '':      `<svg width="56" height="56" viewBox="0 0 56 56" fill="none">
                <circle cx="28" cy="28" r="20" stroke="#e5e7eb" stroke-width="3"/>
                <path d="M21 21l14 14M35 21L21 35" stroke="#9ca3af" stroke-width="2.5" stroke-linecap="round"/>
              </svg>`,
        };

        const icono = iconos[filterDate] || iconos[''];

        const tr = document.createElement('tr');
        tr.className = 'dynamic-empty';
        tr.innerHTML = `
            <td colspan="8" class="empty-state">
                <div class="empty-content">
                    ${icono}
                    <p>${mensaje}</p>
                    <span class="empty-hint">Prueba con otro filtro o período</span>
                </div>
            </td>`;
        tbody.appendChild(tr);
    }
}

    // ============================================
// 7. CUSTOM SELECT
// ============================================
function initCustomSelects() {
    document.querySelectorAll('.filter-select').forEach(select => {
        // Crear wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'custom-select-wrapper';
        select.parentNode.insertBefore(wrapper, select);
        wrapper.appendChild(select);

        // Trigger (botón visible)
        const trigger = document.createElement('div');
        trigger.className = 'custom-select-trigger';
        trigger.innerHTML = `
            <span class="trigger-label">${select.options[select.selectedIndex]?.text || ''}</span>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        `;
        wrapper.appendChild(trigger);

        // Dropdown con opciones
        const dropdown = document.createElement('div');
        dropdown.className = 'custom-select-dropdown';

        Array.from(select.options).forEach(opt => {
            const item = document.createElement('div');
            item.className = 'custom-select-option' + (opt.selected ? ' is-selected' : '');
            item.textContent = opt.text;
            item.dataset.value = opt.value;

            item.addEventListener('click', () => {
                // Actualizar select real (dispara los listeners existentes)
                select.value = opt.value;
                select.dispatchEvent(new Event('change'));

                // Actualizar UI
                dropdown.querySelectorAll('.custom-select-option').forEach(o => o.classList.remove('is-selected'));
                item.classList.add('is-selected');
                trigger.querySelector('.trigger-label').textContent = opt.text;

                wrapper.classList.remove('is-open');
            });

            dropdown.appendChild(item);
        });

        wrapper.appendChild(dropdown);

        // Abrir / cerrar
        trigger.addEventListener('click', e => {
            e.stopPropagation();
            const isOpen = wrapper.classList.contains('is-open');
            // Cerrar todos los demás
            document.querySelectorAll('.custom-select-wrapper.is-open').forEach(w => w.classList.remove('is-open'));
            if (!isOpen) wrapper.classList.add('is-open');
        });
    });

    // Cerrar al hacer click fuera
    document.addEventListener('click', () => {
        document.querySelectorAll('.custom-select-wrapper.is-open').forEach(w => w.classList.remove('is-open'));
    });
}

// ── Centrar selection-bar considerando el sidebar ──
function updateSelectionBarPosition() {
    const sidebar = document.querySelector('.sidebar') // cambia por el selector real de tu sidebar
                 || document.querySelector('aside')
                 || document.querySelector('nav.sidebar')
                 || document.querySelector('[class*="sidebar"]');
    
    const bar = document.getElementById('selectionBar');
    if (!bar) return;

    if (sidebar && window.innerWidth > 767) {
        const sidebarWidth = sidebar.getBoundingClientRect().width;
        bar.style.left = sidebarWidth + 'px';
        bar.style.right = '0';
        bar.style.marginLeft = 'auto';
        bar.style.marginRight = 'auto';
    } else {
        bar.style.left = '';
        bar.style.right = '';
    }
}

function renderPage() {
    const filtered   = getFilteredFormRows();
    const totalPages = Math.max(1, Math.ceil(filtered.length / ROWS_PER_PAGE));

    if (currentPage > totalPages) currentPage = totalPages;

    const start = (currentPage - 1) * ROWS_PER_PAGE;
    const end   = start + ROWS_PER_PAGE;

    getAllFormRows().forEach(row => row.style.display = 'none');
    filtered.forEach((row, i) => {
        row.style.display = (i >= start && i < end) ? '' : 'none';
    });

    const showing = filtered.slice(start, end).length;
    updateFooterCount(showing, getAllFormRows().length);

    // Rebuild paginación
    const pagination = document.querySelector('.table-footer .pagination');
    if (!pagination) return;

    const btnPrev = pagination.querySelector('.page-btn:first-child');
    const btnNext = pagination.querySelector('.page-btn:last-child');

    if (btnPrev) btnPrev.disabled = currentPage <= 1;
    if (btnNext) btnNext.disabled = currentPage >= totalPages;

    pagination.querySelectorAll('.page-btn:not(:first-child):not(:last-child)').forEach(el => el.remove());

    let startPage = Math.max(1, currentPage - 2);
    let endPage   = Math.min(totalPages, startPage + 4);
    if (endPage - startPage < 4) startPage = Math.max(1, endPage - 4);

    for (let i = startPage; i <= endPage; i++) {
        const btn = document.createElement('button');
        btn.className = 'page-btn' + (i === currentPage ? ' active' : '');
        btn.textContent = i;
        btn.addEventListener('click', () => { currentPage = i; renderPage(); });
        pagination.insertBefore(btn, btnNext);
    }
    updateEmptyState();
}

document.querySelector('.table-footer .pagination .page-btn:first-child')
    ?.addEventListener('click', () => { currentPage--; renderPage(); });
document.querySelector('.table-footer .pagination .page-btn:last-child')
    ?.addEventListener('click', () => { currentPage++; renderPage(); });