// ============================================
// NAVEGACIÓN ENTRE VISTAS
// ============================================
function showCalendarView() {
    document.getElementById('calendar-view').classList.add('active');
    document.getElementById('create-view').classList.remove('active');
    document.getElementById('history-view').classList.remove('active');
}

function showCreateView() {
    document.getElementById('calendar-view').classList.remove('active');
    document.getElementById('create-view').classList.add('active');
    document.getElementById('history-view').classList.remove('active');
}

function showHistoryView() {
    document.getElementById('calendar-view').classList.remove('active');
    document.getElementById('create-view').classList.remove('active');
    document.getElementById('history-view').classList.add('active');
}

// ============================================
// TABLA DE BENEFICIARIOS — FILAS DINÁMICAS
// ============================================
let rowCount = document.querySelectorAll('#beneficiaries-table .table-row').length;

function addRow() {
    const table = document.getElementById('beneficiaries-table');
    const idx   = rowCount++;
    const row   = document.createElement('div');
    row.className = 'table-row';
    row.id = `row-${idx}`;
    row.innerHTML = `
        <div class="table-cell row-num">${idx + 1}</div>
        <div class="table-cell">
            <input type="text" name="beneficiarios[${idx}][nombre]" placeholder="Nombre completo">
        </div>
        <div class="table-cell">
            <input type="text" name="beneficiarios[${idx}][curp]" placeholder="CURP"
                   maxlength="18" style="text-transform:uppercase">
        </div>`;
    table.appendChild(row);
    renumberRows();
}

function renumberRows() {
    document.querySelectorAll('#beneficiaries-table .table-row').forEach((row, i) => {
        const cell = row.querySelector('.row-num');
        if (cell) cell.textContent = i + 1;
    });
}

// ============================================
// TOGGLE EDICIÓN DE INPUTS (botón lápiz)
// ============================================
function toggleEdit(btn) {
    const input = btn.closest('.input-with-icon').querySelector('input');
    if (!input) return;
    input.readOnly = !input.readOnly;
    if (!input.readOnly) input.focus();
}

// ============================================
// EXPORTAR CSV
// ============================================
function exportarCSV() {
    const rows = [['#', 'Nombre completo', 'CURP']];
    document.querySelectorAll('#beneficiaries-table .table-row').forEach((row, i) => {
        const inputs = row.querySelectorAll('input');
        const nombre = inputs[0]?.value?.trim();
        const curp   = inputs[1]?.value?.trim();
        if (nombre || curp) {
            rows.push([i + 1, nombre || '', curp || '']);
        }
    });
    const csv  = rows.map(r => r.map(v => `"${v}"`).join(',')).join('\n');
    const link = document.createElement('a');
    link.href     = 'data:text/csv;charset=utf-8,\uFEFF' + encodeURIComponent(csv);
    link.download = 'beneficiarios.csv';
    link.click();
}

// ============================================
// MODAL DE DETALLES DEL EVENTO
// ============================================
let currentReportId = null;

function openEventModal(id, title, date, lugar) {
    currentReportId = id;

    document.getElementById('event-modal-title').textContent    = title;
    document.getElementById('event-modal-subtitle').textContent = lugar + ' — ' + formatDate(date);
    document.getElementById('event-modal-description').textContent = '';

    document.getElementById('btn-modal-view').href = `${ROUTE_BASE}/${id}`;
    document.getElementById('btn-modal-pdf').href  = `${ROUTE_BASE}/${id}/pdf`;

    document.getElementById('event-modal').classList.add('active');
    document.getElementById('event-overlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeEventModal() {
    document.getElementById('event-modal').classList.remove('active');
    document.getElementById('event-overlay').classList.remove('active');
    document.body.style.overflow = '';
    currentReportId = null;
}

// ============================================
// ELIMINAR INFORME (desde el modal)
// ============================================
async function deleteReport(id) {
    if (!id) return;

    const confirmed = confirm('¿Eliminar este informe? Esta acción no se puede deshacer.');
    if (!confirmed) return;

    try {
        const response = await fetch(`${ROUTE_BASE}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept':       'application/json',
            }
        });

        if (response.ok) {
            closeEventModal();
            window.location.reload();
        } else {
            alert('No se pudo eliminar el informe. Intenta de nuevo.');
        }
    } catch (error) {
        console.error('Error al eliminar:', error);
        alert('Error de conexión al intentar eliminar.');
    }
}

// ============================================
// CALENDARIO — generación dinámica
// ============================================
let currentMonth = new Date().getMonth();
let currentYear  = new Date().getFullYear();

const monthNames = [
    'Enero','Febrero','Marzo','Abril','Mayo','Junio',
    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
];

function generateCalendar() {
    const container = document.getElementById('calendar-dates');
    const title     = document.getElementById('calendar-month');
    if (!container || !title) return;

    container.innerHTML = '';
    title.textContent   = `${monthNames[currentMonth]} ${currentYear}`;

    const firstDay    = new Date(currentYear, currentMonth, 1);
    const lastDay     = new Date(currentYear, currentMonth + 1, 0);
    const prevLast    = new Date(currentYear, currentMonth, 0);
    const startOffset = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;

    for (let i = startOffset; i > 0; i--)
        container.appendChild(createDayCell(prevLast.getDate() - i + 1, true));

    for (let d = 1; d <= lastDay.getDate(); d++)
        container.appendChild(createDayCell(d, false));

    const remaining = 42 - (startOffset + lastDay.getDate());
    for (let d = 1; d <= remaining; d++)
        container.appendChild(createDayCell(d, true));
}

function createDayCell(day, isOther) {
    const div = document.createElement('div');
    div.className = 'calendar-date' + (isOther ? ' other-month' : '');
    div.textContent = day;

    if (!isOther) {
        const key = `${currentYear}-${String(currentMonth + 1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;

        if (typeof eventsFromDB !== 'undefined' && eventsFromDB[key]) {
            const evt = eventsFromDB[key];
            div.classList.add('has-event');
            div.title = evt.title;
            div.addEventListener('click', () => {
                openEventModal(evt.id, evt.title, key, evt.lugar);
                updateCalendarNotes(evt.title, key, evt.lugar);
            });
        } else {
            div.addEventListener('click', () => {
                document.querySelectorAll('.calendar-date.selected')
                    .forEach(el => el.classList.remove('selected'));
                div.classList.add('selected');
                document.getElementById('selected-date-notes').textContent =
                    'Sin eventos para ' + formatDate(key);
            });
        }
    }
    return div;
}

function updateCalendarNotes(title, date, lugar) {
    const notes = document.getElementById('selected-date-notes');
    if (notes) notes.innerHTML = `<strong>${title}</strong><br>${lugar} · ${formatDate(date)}`;
}

function previousMonth() {
    if (--currentMonth < 0) { currentMonth = 11; currentYear--; }
    generateCalendar();
}

function nextMonth() {
    if (++currentMonth > 11) { currentMonth = 0; currentYear++; }
    generateCalendar();
}

// ============================================
// FILTROS DE HISTORIAL
// ============================================
function applyHistoryFilter(filter) {
    const now   = new Date();
    const cards = document.querySelectorAll('#history-list .history-item');

    cards.forEach(card => {
        const fecha = new Date(card.dataset.fecha + 'T00:00:00');
        let show = true;

        if (filter === 'week') {
            const startWeek = new Date(now);
            startWeek.setDate(now.getDate() - now.getDay());
            startWeek.setHours(0,0,0,0);
            show = fecha >= startWeek;
        } else if (filter === 'month') {
            show = fecha.getMonth()    === now.getMonth() &&
                   fecha.getFullYear() === now.getFullYear();
        } else if (filter === 'year') {
            show = fecha.getFullYear() === now.getFullYear();
        }

        const group = card.closest('.history-group');
        if (group) group.style.display = show ? '' : 'none';
    });
}

// ============================================
// HELPER: YYYY-MM-DD → DD/MM/YYYY
// ============================================
function formatDate(dateStr) {
    if (!dateStr) return '';
    const [y, m, d] = dateStr.split('-');
    return `${d}/${m}/${y}`;
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function () {

    generateCalendar();

    // Agregar fila
    const btnAdd = document.getElementById('btn-add-row');
    if (btnAdd) btnAdd.addEventListener('click', addRow);

    // Exportar CSV
    const btnExport = document.getElementById('btn-export-csv');
    if (btnExport) btnExport.addEventListener('click', exportarCSV);

    // Eliminar desde modal
    const btnDelete = document.getElementById('btn-modal-delete');
    if (btnDelete) btnDelete.addEventListener('click', () => deleteReport(currentReportId));

    // Filtros historial
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            applyHistoryFilter(this.dataset.filter);
        });
    });

    // Click en items del historial → abrir modal
    document.querySelectorAll('#history-list .history-item').forEach(item => {
        item.addEventListener('click', function () {
            const id    = this.dataset.id;
            const fecha = this.dataset.fecha;
            const title = this.querySelector('h4')?.textContent || '';
            const lugar = (typeof eventsFromDB !== 'undefined' && eventsFromDB[fecha])
                          ? eventsFromDB[fecha].lugar : '';
            openEventModal(id, title, fecha, lugar);
        });
    });

    // Cerrar modal con ESC
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeEventModal();
    });
});