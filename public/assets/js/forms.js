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
        e.stopPropagation();
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
    const selectionBar      = document.getElementById('selectionBar');
    const selCountEl        = document.getElementById('selCount');
    const selectAllHeaderCb = document.getElementById('selectAll');
    const tbody             = document.querySelector('#formsTable tbody');

    if (!tbody || !selectionBar) return;

    function getChecked() {
        return [...document.querySelectorAll('.row-checkbox')].filter(c => c.checked);
    }

    function updateSelectionBar() {
        const checked = getChecked();
        const count   = checked.length;
        if (selCountEl) selCountEl.textContent = count;
        selectionBar.classList.toggle('has-selection', count > 0);

        if (selectAllHeaderCb) {
            const allBoxes = document.querySelectorAll('.row-checkbox').length;
            selectAllHeaderCb.checked = count === allBoxes && allBoxes > 0;
        }

        // ── Actualizar label/tooltip del botón exportar de la barra ──
        updateExportSelBtnLabel(count);

        if (count > 0) {
            getAllFormRows().forEach(row => row.style.display = '');
            const tableFooter = document.querySelector('.table-footer');
            const tableContainer = document.querySelector('.table-container');
            if (tableContainer) tableContainer.style.marginBottom = '80px';
            if (tableFooter)    tableFooter.style.display = 'none';
        } else {
            const tableFooter    = document.querySelector('.table-footer');
            const tableContainer = document.querySelector('.table-container');
            if (tableContainer) tableContainer.style.marginBottom = '';
            if (tableFooter)    tableFooter.style.display = '';
            renderPage();
        }
    }

    function triggerSelectAnimation(tr, selected) {
        tr.classList.remove('row-selected', 'row-unselected');
        void tr.offsetWidth;
        if (selected) {
            tr.classList.add('row-selected');
        } else {
            tr.classList.add('row-unselected');
        }
    }

    document.querySelectorAll('.user-avatar').forEach(avatar => {
        if (!avatar.querySelector('.avatar-cb-hint')) {
            const hint = document.createElement('span');
            hint.className = 'avatar-cb-hint';
            hint.setAttribute('aria-hidden', 'true');
            avatar.appendChild(hint);
        }

        avatar.addEventListener('click', function (e) {
            if (e.target.classList.contains('row-checkbox')) return;
            const cb = this.querySelector('.row-checkbox');
            if (cb) { 
                cb.checked = !cb.checked; 
                cb.dispatchEvent(new Event('change')); 
            }
        });
    });

    document.querySelectorAll('.row-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            triggerSelectAnimation(this.closest('tr'), this.checked);
            updateSelectionBar();
        });
    });

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

    // ── Exportar seleccionados ───────────────────────────────────────────
    const exportSelBtn = document.getElementById('exportSelBtn');
    if (exportSelBtn) {
        exportSelBtn.addEventListener('click', () => {
            const ids = getChecked().map(cb => cb.value);
            if (!ids.length) return;
            exportSelectedForms(ids);
        });
    }

    // ── Eliminar seleccionados ───────────────────────────────────────────
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
                } 
            });
        });
    }
}

// ── Actualiza el texto/tooltip del botón "Exportar" de la barra flotante ──
function updateExportSelBtnLabel(count) {
    const btn = document.getElementById('exportSelBtn');
    if (!btn) return;

    // Eliminar TODOS los nodos de texto sueltos para evitar duplicados
    Array.from(btn.childNodes)
        .filter(n => n.nodeType === Node.TEXT_NODE)
        .forEach(n => n.remove());

    // Reutilizar o crear el span dedicado al label
    let labelSpan = btn.querySelector('.export-sel-label');
    if (!labelSpan) {
        labelSpan = document.createElement('span');
        labelSpan.className = 'export-sel-label';
        btn.appendChild(labelSpan);
    }

    if (count === 1) {
        labelSpan.textContent = ' Exportar este';
        btn.title = 'Exportar solo este registro';
    } else if (count > 1) {
        labelSpan.textContent = ` Exportar (${count})`;
        btn.title = `Exportar ${count} registros seleccionados`;
    } else {
        labelSpan.textContent = ' Exportar';
        btn.title = '';
    }
}

// ── Exportar registros seleccionados (1 ó varios) ────────────────────────
async function exportSelectedForms(ids) {
    const esSolo = ids.length === 1;
    showExportToast('loading', '', esSolo ? 'Preparando ficha del contacto…' : '');

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
        const url  = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href  = url;
        link.download = esSolo
            ? `contacto_${ids[0]}.pdf`
            : `formularios_seleccionados_${ids.length}.pdf`;
        document.body.appendChild(link);
        link.click();
        link.remove();
        window.URL.revokeObjectURL(url);

        showExportToast('success', '', esSolo
            ? '¡Ficha del contacto descargada!'
            : `¡${ids.length} registros exportados!`);

    } catch (error) {
        console.error('Error exportando PDF:', error);
        showExportToast('error', error.message);
    }
}

// ============================================
// 3. EXPORTAR A PDF  (respeta el filtro de fecha activo)
// ============================================
function initExportLogic() {
    const exportButton = document.querySelector('.export-button');
    if (exportButton) {
        exportButton.addEventListener('click', exportForms);
    }
}

async function exportForms() {
    // Construir parámetros según el filtro de fecha activo
    const params    = new URLSearchParams();
    const dateLabel = getDateFilterLabel(); // "Esta semana", "Este mes", etc.

    if (filterDate) {
        params.set('date_filter', filterDate);
    }

    showExportToast('loading', '', dateLabel ? `Exportando: ${dateLabel}…` : '');

    try {
        const url = '/admin/forms/export/pdf' + (params.toString() ? '?' + params.toString() : '');
        const response = await fetch(url, {
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

        const blob      = await response.blob();
        const objectUrl = window.URL.createObjectURL(blob);
        const link      = document.createElement('a');
        link.href       = objectUrl;

        // Nombre de archivo descriptivo según el filtro
        const suffix = {
            today: 'hoy',
            week:  'esta_semana',
            month: 'este_mes',
            year:  'este_año',
        }[filterDate] || 'todos';
        link.download = `formularios_contacto_${suffix}.pdf`;

        document.body.appendChild(link);
        link.click();
        link.remove();
        window.URL.revokeObjectURL(objectUrl);

        const successMsg = dateLabel
            ? `¡PDF de "${dateLabel}" descargado!`
            : '¡Descarga completada!';
        showExportToast('success', '', successMsg);

    } catch (error) {
        console.error('Error exportando PDF:', error);
        showExportToast('error', error.message);
    }
}

// Devuelve el label legible del filtro de fecha activo
function getDateFilterLabel() {
    const labels = {
        today: 'Hoy',
        week:  'Esta semana',
        month: 'Este mes',
        year:  'Este año',
    };
    return labels[filterDate] || '';
}

// ============================================
// TOAST DE EXPORTACIÓN
// ============================================
function showExportToast(type, message = '', customMsg = '') {
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
            msg: customMsg || 'Por favor espera...',
            extraClass: 'toast-loading',
            progress: `<div class="toast-progress-indeterminate"></div>`,
            autohide: false,
        },
        success: {
            icon: `<svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                <path d="M5 10l4 4 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>`,
            title: '¡PDF listo!',
            msg: customMsg || 'Descarga completada',
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

    const c     = configs[type];
    const toast = document.createElement('div');
    toast.id        = 'exportToast';
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
    const modalOverlay     = document.getElementById('formModalOverlay');
    const modalBtnDelete   = document.getElementById('modalBtnDelete');
    const modalCloseBtn    = document.getElementById('modalClose');
    const modalBtnCloseFooter = document.getElementById('modalBtnClose');

    if (modalCloseBtn)        modalCloseBtn.addEventListener('click', closeModal);
    if (modalBtnCloseFooter)  modalBtnCloseFooter.addEventListener('click', closeModal);
    
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
    document.documentElement.style.overflow = 'hidden'; 
}

function closeModal() { 
    const overlay = document.getElementById('formModalOverlay');
    if(overlay) overlay.classList.remove('is-open'); 
    document.body.style.overflow = ''; 
    document.documentElement.style.overflow = ''; 
    currentModalId = null; 
}

window.viewForm = async function(id) {
    currentModalId = id;
    
    const modalAvatar   = document.getElementById('modalAvatar');
    const modalName     = document.getElementById('modalName');
    const modalAsunto   = document.getElementById('modalAsunto');
    const modalCorreo   = document.getElementById('modalCorreo');
    const modalTelefono = document.getElementById('modalTelefono');
    const modalFecha    = document.getElementById('modalFecha');
    const modalMensaje  = document.getElementById('modalMensaje');

    if(modalAvatar)   modalAvatar.textContent   = '…';
    if(modalName)     modalName.textContent     = 'Cargando…';
    if(modalAsunto)   modalAsunto.textContent   = '';
    if(modalCorreo)   modalCorreo.innerHTML     = '—';
    if(modalTelefono) modalTelefono.innerHTML   = '—';
    if(modalFecha)    modalFecha.textContent    = '—';
    if(modalMensaje)  modalMensaje.textContent  = '—';
    
    openModal();

    try {
        const res  = await fetch(`/admin/forms/${id}`, {
            headers: { 
                'X-CSRF-TOKEN': csrfToken, 
                'Accept': 'application/json' 
            }
        });
        const data = await res.json();

        if (data.success) {
            const f     = data.data;
            const fecha = new Date(f.fecha_envio).toLocaleString('es-MX', {
                year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
            });

            if(modalAvatar)   modalAvatar.textContent = f.nombre_completo.charAt(0).toUpperCase();
            if(modalName)     modalName.textContent   = f.nombre_completo;
            if(modalAsunto)   modalAsunto.textContent = f.asunto || 'Sin asunto';
            if(modalCorreo)   modalCorreo.innerHTML   = `<a href="mailto:${f.correo}">${f.correo}</a>`;
            if(modalTelefono) modalTelefono.innerHTML = f.numero_telefonico 
                ? `<a href="tel:${f.numero_telefonico}">${f.numero_telefonico}</a>` 
                : `<span style="color:var(--text-muted)">No proporcionado</span>`;
            if(modalFecha)    modalFecha.textContent  = fecha;
            if(modalMensaje)  modalMensaje.textContent = f.mensaje || 'Sin mensaje';
            
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
                const dayOfWeek = now.getDay();
                const monday = new Date(now);
                monday.setDate(now.getDate() - (dayOfWeek === 0 ? 6 : dayOfWeek - 1));
                monday.setHours(0, 0, 0, 0);
                const sunday = new Date(monday);
                sunday.setDate(monday.getDate() + 6);
                sunday.setHours(23, 59, 59, 999);
                matchDate = rowDate >= monday && rowDate <= sunday;
            } else if (filterDate === 'month') {
                matchDate = rowDate.getMonth() === now.getMonth() && 
                            rowDate.getFullYear() === now.getFullYear();
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

    const thead          = document.querySelector('#formsTable thead');
    const tableToolbar   = document.querySelector('.table-toolbar');
    const tableContainer = document.querySelector('.table-container');  
    const noData = allRows.length === 0 || filtered.length === 0;

    [searchBox, sortButton, exportBtn, thead].forEach(el => {
        if (el) el.style.display = noData ? 'none' : '';
    });

    if (tableFooter) tableFooter.style.display = noData ? 'none' : '';

    if (noData) {
        tableToolbar?.classList.add('only-filter');
        tableContainer?.classList.add('no-data');
        if (window.innerWidth <= 767) {
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';
        }
    } else {
        tableToolbar?.classList.remove('only-filter');
        tableContainer?.classList.remove('no-data');
        document.body.style.overflow = '';
        document.documentElement.style.overflow = '';
    }

    if (noData && allRows.length > 0) {
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
        const wrapper = document.createElement('div');
        wrapper.className = 'custom-select-wrapper';
        select.parentNode.insertBefore(wrapper, select);
        wrapper.appendChild(select);

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

        const dropdown = document.createElement('div');
        dropdown.className = 'custom-select-dropdown';

        Array.from(select.options).forEach(opt => {
            const item = document.createElement('div');
            item.className = 'custom-select-option' + (opt.selected ? ' is-selected' : '');
            item.textContent = opt.text;
            item.dataset.value = opt.value;

            item.addEventListener('click', () => {
                select.value = opt.value;
                select.dispatchEvent(new Event('change'));

                dropdown.querySelectorAll('.custom-select-option').forEach(o => o.classList.remove('is-selected'));
                item.classList.add('is-selected');
                trigger.querySelector('.trigger-label').textContent = opt.text;

                wrapper.classList.remove('is-open');
            });

            dropdown.appendChild(item);
        });

        wrapper.appendChild(dropdown);

        trigger.addEventListener('click', e => {
            e.stopPropagation();
            const isOpen = wrapper.classList.contains('is-open');
            document.querySelectorAll('.custom-select-wrapper.is-open').forEach(w => w.classList.remove('is-open'));
            if (!isOpen) wrapper.classList.add('is-open');
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.custom-select-wrapper.is-open').forEach(w => w.classList.remove('is-open'));
    });
}

// ── Centrar selection-bar considerando el sidebar ──
function updateSelectionBarPosition() {
    const sidebar = document.querySelector('.sidebar')
                 || document.querySelector('aside')
                 || document.querySelector('nav.sidebar')
                 || document.querySelector('[class*="sidebar"]');
    
    const bar = document.getElementById('selectionBar');
    if (!bar) return;

    if (sidebar && window.innerWidth > 767) {
        const sidebarWidth = sidebar.getBoundingClientRect().width;
        bar.style.left        = sidebarWidth + 'px';
        bar.style.right       = '0';
        bar.style.marginLeft  = 'auto';
        bar.style.marginRight = 'auto';
    } else {
        bar.style.left  = '';
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
        const btn       = document.createElement('button');
        btn.className   = 'page-btn' + (i === currentPage ? ' active' : '');
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