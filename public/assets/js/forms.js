// === FORMS TABLE FUNCTIONALITY ===
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('formsTable');
    const tbody = table.querySelector('tbody');
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const sortDateBtn = document.getElementById('sortDate');
    const selectAllCheckbox = document.getElementById('selectAll');
    
    let currentOrder = 'desc'; // Por defecto, más reciente primero
    let allForms = [];

    // === INICIALIZAR DATOS ===
    function initializeData() {
        // formsData viene del script inline en la vista
        allForms = typeof formsData !== 'undefined' ? formsData : [];
        renderTable(allForms);
        updateStats();
    }

    // === RENDERIZAR TABLA ===
    function renderTable(forms) {
        tbody.innerHTML = '';

        if (forms.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="empty-state">
                        <div class="empty-content">
                            <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                                <circle cx="32" cy="32" r="30" stroke="#e5e7eb" stroke-width="4"/>
                                <path d="M32 20v16m0 4h.02" stroke="#9ca3af" stroke-width="4" stroke-linecap="round"/>
                            </svg>
                            <p>No hay formularios para mostrar</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        forms.forEach(form => {
            const row = document.createElement('tr');
            row.dataset.date = form.fecha;
            row.dataset.id = form.id;
            
            const inicial = form.nombre.charAt(0).toUpperCase();
            
            row.innerHTML = `
                <td class="td-checkbox">
                    <input type="checkbox" class="row-checkbox">
                </td>
                <td>
                    <div class="user-info">
                        <div class="user-avatar">${inicial}</div>
                        <span class="user-name">${form.nombre}</span>
                    </div>
                </td>
                <td>
                    <a href="mailto:${form.correo}" class="email-link">
                        ${form.correo}
                    </a>
                </td>
                <td>
                    <span class="subject-text">${form.asunto}</span>
                </td>
                <td>
                    <a href="tel:${form.telefono}" class="phone-link">
                        ${form.telefono}
                    </a>
                </td>
                <td>
                    <span class="date-badge">${form.fecha}</span>
                </td>
                <td class="td-actions">
                    <div class="action-buttons">
                        <button class="btn-action btn-view" title="Ver detalles">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                                <path d="M10 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M10 5C5.5 5 2 10 2 10s3.5 5 8 5 8-5 8-5-3.5-5-8-5z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </button>
                        <button class="btn-action btn-delete" title="Eliminar">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                                <path d="M3 5h14M8 5V3h4v2m-5 4v6m4-6v6m-7-9v11a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                </td>
            `;
            
            tbody.appendChild(row);
        });

        updatePagination(forms.length);
    }

    // === ACTUALIZAR ESTADÍSTICAS ===
    function updateStats() {
        const totalCountEl = document.getElementById('totalCount');
        const weekCountEl = document.getElementById('weekCount');
        const today = new Date();
        const weekAgo = new Date(today);
        weekAgo.setDate(weekAgo.getDate() - 7);

        if (totalCountEl) {
            totalCountEl.textContent = allForms.length;
        }

        if (weekCountEl) {
            const weekCount = allForms.filter(form => {
                const [day, month, year] = form.fecha.split('/');
                const formDate = new Date(year, month - 1, day);
                return formDate >= weekAgo && formDate <= today;
            }).length;
            weekCountEl.textContent = weekCount;
        }
    }

    // === BÚSQUEDA EN TIEMPO REAL ===
    searchInput.addEventListener('input', function() {
        applyFilters();
    });

    // === FILTRO POR FECHA ===
    dateFilter.addEventListener('change', function() {
        applyFilters();
    });

    // === APLICAR FILTROS ===
    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const filterValue = dateFilter.value;
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        let filtered = allForms.filter(form => {
            // Filtro de búsqueda
            const matchesSearch = searchTerm === '' || 
                form.nombre.toLowerCase().includes(searchTerm) ||
                form.correo.toLowerCase().includes(searchTerm) ||
                form.asunto.toLowerCase().includes(searchTerm);

            if (!matchesSearch) return false;

            // Filtro de fecha
            if (filterValue === '') return true;

            const [day, month, year] = form.fecha.split('/');
            const formDate = new Date(year, month - 1, day);
            formDate.setHours(0, 0, 0, 0);

            switch(filterValue) {
                case 'today':
                    return formDate.getTime() === today.getTime();
                case 'week':
                    const weekAgo = new Date(today);
                    weekAgo.setDate(weekAgo.getDate() - 7);
                    return formDate >= weekAgo && formDate <= today;
                case 'month':
                    const monthAgo = new Date(today);
                    monthAgo.setMonth(monthAgo.getMonth() - 1);
                    return formDate >= monthAgo && formDate <= today;
                default:
                    return true;
            }
        });

        // Aplicar ordenamiento
        filtered = sortByDate(filtered, currentOrder);
        renderTable(filtered);
    }

    // === ORDENAR POR FECHA ===
    sortDateBtn.addEventListener('click', function() {
        currentOrder = currentOrder === 'desc' ? 'asc' : 'desc';
        this.dataset.order = currentOrder;
        
        // Actualizar texto del botón
        const buttonText = this.querySelector('span');
        buttonText.textContent = currentOrder === 'desc' ? 'Más reciente' : 'Más antigua';

        applyFilters();
    });

    function sortByDate(forms, order) {
        return forms.sort((a, b) => {
            const dateA = parseDateString(a.fecha);
            const dateB = parseDateString(b.fecha);
            
            if (order === 'desc') {
                return dateB - dateA;
            } else {
                return dateA - dateB;
            }
        });
    }

    // === SELECCIONAR TODAS LAS FILAS ===
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = tbody.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // === ACTUALIZAR ESTADO DEL "SELECCIONAR TODO" ===
    tbody.addEventListener('change', function(e) {
        if (e.target.classList.contains('row-checkbox')) {
            const checkboxes = tbody.querySelectorAll('.row-checkbox');
            const checkedBoxes = tbody.querySelectorAll('.row-checkbox:checked');
            selectAllCheckbox.checked = checkboxes.length === checkedBoxes.length && checkboxes.length > 0;
        }
    });

    // === BOTONES DE ACCIÓN ===
    tbody.addEventListener('click', function(e) {
        const viewBtn = e.target.closest('.btn-view');
        const deleteBtn = e.target.closest('.btn-delete');

        if (viewBtn) {
            const row = viewBtn.closest('tr');
            const formId = row.dataset.id;
            const form = allForms.find(f => f.id == formId);

            if (form) {
                showModal({
                    title: 'Detalles del Formulario',
                    content: `
                        <div class="modal-details">
                            <div class="detail-row">
                                <strong>Nombre:</strong> ${form.nombre}
                            </div>
                            <div class="detail-row">
                                <strong>Correo:</strong> <a href="mailto:${form.correo}">${form.correo}</a>
                            </div>
                            <div class="detail-row">
                                <strong>Teléfono:</strong> <a href="tel:${form.telefono}">${form.telefono}</a>
                            </div>
                            <div class="detail-row">
                                <strong>Asunto:</strong> ${form.asunto}
                            </div>
                            <div class="detail-row">
                                <strong>Fecha:</strong> ${form.fecha}
                            </div>
                        </div>
                    `
                });
            }
        }

        if (deleteBtn) {
            const row = deleteBtn.closest('tr');
            const formId = row.dataset.id;
            const form = allForms.find(f => f.id == formId);

            if (form && confirm(`¿Estás seguro de que deseas eliminar el formulario de ${form.nombre}?`)) {
                // Eliminar del array
                allForms = allForms.filter(f => f.id != formId);
                
                // Volver a aplicar filtros y renderizar
                applyFilters();
                updateStats();
                
                // Aquí iría la llamada AJAX para eliminar del servidor
                // deleteFormEntry(formId);
            }
        }
    });

    // === EXPORTAR DATOS ===
    document.querySelector('.export-button')?.addEventListener('click', function() {
        const visibleRows = tbody.querySelectorAll('tr:not([style*="display: none"])');
        const dataRows = Array.from(visibleRows).filter(row => !row.querySelector('.empty-state'));

        if (dataRows.length === 0) {
            alert('No hay datos para exportar');
            return;
        }

        // Crear CSV
        let csv = 'Nombre,Correo,Asunto,Teléfono,Fecha\n';
        
        dataRows.forEach(row => {
            const formId = row.dataset.id;
            const form = allForms.find(f => f.id == formId);
            if (form) {
                csv += `"${form.nombre}","${form.correo}","${form.asunto}","${form.telefono}","${form.fecha}"\n`;
            }
        });

        // Descargar archivo
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        
        link.setAttribute('href', url);
        link.setAttribute('download', `formularios_${new Date().toISOString().split('T')[0]}.csv`);
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // === FUNCIONES AUXILIARES ===
    
    function parseDateString(dateStr) {
        if (!dateStr) return new Date(0);
        const [day, month, year] = dateStr.split('/');
        return new Date(year, month - 1, day);
    }

    function updatePagination(count) {
        const showingCountEl = document.getElementById('showingCount');
        const totalCountFooterEl = document.getElementById('totalCountFooter');
        
        if (showingCountEl) {
            showingCountEl.textContent = count;
        }
        if (totalCountFooterEl) {
            totalCountFooterEl.textContent = allForms.length;
        }
    }

    function showModal({ title, content }) {
        // Crear modal si no existe
        let modal = document.getElementById('detailsModal');
        
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'detailsModal';
            modal.className = 'modal';
            modal.innerHTML = `
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"></h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            `;
            document.body.appendChild(modal);

            // Estilos del modal
            const style = document.createElement('style');
            style.textContent = `
                .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000; }
                .modal.active { display: flex; align-items: center; justify-content: center; }
                .modal-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
                .modal-content { position: relative; background: #fff; border-radius: 16px; max-width: 500px; width: 90%; max-height: 80vh; overflow: auto; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
                .modal-header { padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; }
                .modal-title { font-size: 20px; font-weight: 600; color: #111827; margin: 0; }
                .modal-close { background: none; border: none; font-size: 28px; color: #6b7280; cursor: pointer; line-height: 1; padding: 0; width: 32px; height: 32px; }
                .modal-close:hover { color: #111827; }
                .modal-body { padding: 24px; }
                .modal-details { display: flex; flex-direction: column; gap: 16px; }
                .detail-row { padding: 12px; background: #f9fafb; border-radius: 8px; }
                .detail-row strong { color: #374151; margin-right: 8px; }
                .detail-row a { color: #8b5cf6; text-decoration: none; }
                .detail-row a:hover { text-decoration: underline; }
            `;
            document.head.appendChild(style);

            // Event listeners para cerrar
            modal.querySelector('.modal-overlay').addEventListener('click', () => modal.classList.remove('active'));
            modal.querySelector('.modal-close').addEventListener('click', () => modal.classList.remove('active'));
        }

        modal.querySelector('.modal-title').textContent = title;
        modal.querySelector('.modal-body').innerHTML = content;
        modal.classList.add('active');
    }

    // === INICIALIZAR ===
    initializeData();
});