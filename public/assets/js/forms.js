// ============================================
// VARIABLES GLOBALES
// ============================================
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// === FORMS TABLE FUNCTIONALITY ===
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('formsTable');
    const tbody = table?.querySelector('tbody');
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const sortDateBtn = document.getElementById('sortDate');
    const selectAllCheckbox = document.getElementById('selectAll');
    
    let currentOrder = 'desc'; // Por defecto, más reciente primero

    // === BÚSQUEDA EN TIEMPO REAL ===
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const rows = tbody.querySelectorAll('tr:not(.empty-state)');
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.querySelector('.user-name')?.textContent.toLowerCase() || '';
                const email = row.querySelector('.email-link')?.textContent.toLowerCase() || '';
                const subject = row.querySelector('.subject-text')?.textContent.toLowerCase() || '';

                if (name.includes(searchTerm) || email.includes(searchTerm) || subject.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            updateFooterCount();
        });
    }

    // === FILTRO POR FECHA ===
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            const filter = this.value;
            const rows = tbody.querySelectorAll('tr:not(.empty-state)');
            const now = new Date();
            let visibleCount = 0;

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
                if (show) visibleCount++;
            });

            updateFooterCount();
        });
    }

    // === ORDENAR POR FECHA ===
    if (sortDateBtn) {
        sortDateBtn.addEventListener('click', function() {
            currentOrder = currentOrder === 'desc' ? 'asc' : 'desc';
            this.dataset.order = currentOrder;
            
            const span = this.querySelector('span');
            if (span) {
                span.textContent = currentOrder === 'desc' ? 'Más reciente' : 'Más antiguo';
            }

            sortTableByDate(currentOrder);
        });
    }

    function sortTableByDate(order) {
        if (!tbody) return;
        
        const rows = Array.from(tbody.querySelectorAll('tr:not(.empty-state)'));

        rows.sort((a, b) => {
            const dateA = new Date(a.dataset.date);
            const dateB = new Date(b.dataset.date);
            return order === 'desc' ? dateB - dateA : dateA - dateB;
        });

        rows.forEach(row => tbody.appendChild(row));
    }

    // === SELECCIONAR TODAS LAS FILAS ===
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = tbody.querySelectorAll('.row-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectionCount();
        });
    }

    // === ACTUALIZAR ESTADO DEL "SELECCIONAR TODO" ===
    if (tbody) {
        tbody.addEventListener('change', function(e) {
            if (e.target.classList.contains('row-checkbox')) {
                updateSelectionCount();
                
                const allCheckboxes = tbody.querySelectorAll('.row-checkbox');
                const checkedCheckboxes = tbody.querySelectorAll('.row-checkbox:checked');
                
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = 
                        allCheckboxes.length === checkedCheckboxes.length && allCheckboxes.length > 0;
                }
            }
        });
    }

    function updateSelectionCount() {
        const selected = tbody?.querySelectorAll('.row-checkbox:checked').length || 0;
        // Aquí podrías agregar un badge o contador de seleccionados
        console.log(`Seleccionados: ${selected}`);
    }

    // === ACTUALIZAR CONTADOR DEL FOOTER ===
    function updateFooterCount() {
        if (!tbody) return;
        
        const visibleRows = tbody.querySelectorAll('tr:not(.empty-state):not([style*="display: none"])');
        const total = tbody.querySelectorAll('tr:not(.empty-state)').length;
        const footerInfo = document.querySelector('.footer-info');
        
        if (footerInfo) {
            const showing = visibleRows.length;
            footerInfo.innerHTML = `Mostrando <strong>${showing > 0 ? '1-' + showing : '0'}</strong> de <strong>${total}</strong> registros`;
        }
    }

    // === EXPORTAR DATOS ===
    const exportButton = document.querySelector('.export-button');
    if (exportButton) {
        exportButton.addEventListener('click', function() {
            exportForms();
        });
    }

    // === INICIALIZACIÓN ===
    updateFooterCount();
});

// ========================================
// VER DETALLES DE FORMULARIO
// ========================================
async function viewForm(id) {
    try {
        const response = await fetch(`/admin/forms/${id}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            const form = data.data;
            const fechaFormateada = new Date(form.fecha_envio).toLocaleString('es-MX', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            Swal.fire({
                title: '<strong>Detalles del Formulario</strong>',
                html: `
                    <div style="text-align: left; padding: 20px;">
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #7d3f6a;">Nombre:</strong>
                            <p style="margin: 5px 0;">${form.nombre_completo}</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #7d3f6a;">Correo:</strong>
                            <p style="margin: 5px 0;"><a href="mailto:${form.correo}" style="color: #8b5cf6;">${form.correo}</a></p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #7d3f6a;">Teléfono:</strong>
                            <p style="margin: 5px 0;">${form.numero_telefonico || 'N/A'}</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #7d3f6a;">Asunto:</strong>
                            <p style="margin: 5px 0;">${form.asunto}</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #7d3f6a;">Mensaje:</strong>
                            <p style="margin: 5px 0; white-space: pre-wrap; background: #f9fafb; padding: 12px; border-radius: 8px;">${form.mensaje}</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #7d3f6a;">Fecha:</strong>
                            <p style="margin: 5px 0;">${fechaFormateada}</p>
                        </div>
                    </div>
                `,
                width: '600px',
                confirmButtonColor: '#7d3f6a',
                confirmButtonText: 'Cerrar',
                showCancelButton: true,
                cancelButtonText: 'Eliminar',
                cancelButtonColor: '#ef4444',
                reverseButtons: true
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    deleteForm(id);
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
                confirmButtonColor: '#7d3f6a'
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar el formulario',
            confirmButtonColor: '#7d3f6a'
        });
    }
}

// ========================================
// ELIMINAR FORMULARIO
// ========================================
async function deleteForm(id) {
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
                    // Recargar página
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    confirmButtonColor: '#7d3f6a'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo eliminar el formulario',
                confirmButtonColor: '#7d3f6a'
            });
        }
    }
}

// ========================================
// EXPORTAR A CSV
// ========================================
function exportForms() {
    Swal.fire({
        title: 'Exportando...',
        text: 'Generando archivo CSV',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Redirigir a la ruta de exportación
    window.location.href = '/admin/forms/export';

    // Cerrar el loading después de un momento
    setTimeout(() => {
        Swal.close();
        Swal.fire({
            icon: 'success',
            title: '¡Exportado!',
            text: 'El archivo se ha descargado correctamente',
            confirmButtonColor: '#10b981',
            timer: 2000,
            timerProgressBar: true
        });
    }, 1500);
}