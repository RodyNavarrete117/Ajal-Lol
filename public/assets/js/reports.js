// ============================================
// NAVEGACIÓN
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
// TOGGLE EDICIÓN & INIT CABECERA
// ============================================
function toggleEdit(btn) {
    const input = btn.closest('.input-with-icon').querySelector('input');
    if (!input) return;
    input.readOnly = !input.readOnly;
    btn.classList.toggle('active', !input.readOnly);
    if (!input.readOnly) input.focus();
}

function initHeaderInputs() {
    const form = document.getElementById('create-report-form');
    if (!form) return;
    form.querySelectorAll('.input-with-icon').forEach(wrapper => {
        const input = wrapper.querySelector('input');
        const btn   = wrapper.querySelector('.btn-edit-input');
        if (input && btn) input.readOnly = true;
        if (input && !btn) input.classList.add('free-input');
    });
}

function setTodayDate() {
    const inputFecha = document.querySelector('[name="fecha"]');
    if (!inputFecha || inputFecha.value) return;
    const today = new Date();
    const y = today.getFullYear();
    const m = String(today.getMonth() + 1).padStart(2, '0');
    const d = String(today.getDate()).padStart(2, '0');
    inputFecha.value = `${y}-${m}-${d}`;
}

// ============================================
// TABLA — BENEFICIARIOS
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
    toggleRemoveButton();
}

function removeLastRow() {
    const table = document.getElementById('beneficiaries-table');
    const rows  = table.querySelectorAll('.table-row');
    if (rows.length <= 6) return; 
    rows[rows.length - 1].remove();
    rowCount = table.querySelectorAll('.table-row').length;
    renumberRows();
    toggleRemoveButton();
}

function renumberRows() {
    document.querySelectorAll('#beneficiaries-table .table-row').forEach((row, i) => {
        const cell = row.querySelector('.row-num');
        if (cell) cell.textContent = i + 1;
        row.querySelectorAll('input[name]').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, `[${i}]`);
        });
    });
}

function toggleRemoveButton() {
    const btnRemove = document.getElementById('btn-remove-row');
    const rowLength = document.querySelectorAll('#beneficiaries-table .table-row').length;
    if (btnRemove) {
        btnRemove.style.display = rowLength > 6 ? 'flex' : 'none';
    }
}

// ============================================
// MODAL & ELIMINAR INFORME
// ============================================
let currentReportId = null;

function openEventModal(id, title, date, lugar) {
    currentReportId = id;
    document.getElementById('event-modal-title').textContent    = title;
    document.getElementById('event-modal-subtitle').textContent = lugar + ' — ' + formatDate(date);
    document.getElementById('event-modal-description').textContent = '';
    const btnView = document.getElementById('btn-modal-view');
    const btnPdf  = document.getElementById('btn-modal-pdf');
    if (btnView) { btnView.href = `${ROUTE_BASE}/${id}/pdf`; btnView.target = '_blank'; }
    if (btnPdf)  { btnPdf.href = `${ROUTE_BASE}/${id}/pdf`; btnPdf.target = '_blank'; }
    
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

async function deleteReport(id) {
    if (!id) return;
    if (!confirm('¿Eliminar este informe? Esta acción no se puede deshacer.')) return;
    try {
        const res = await fetch(`${ROUTE_BASE}/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
        });
        if (res.ok) { closeEventModal(); window.location.reload(); }
        else alert('No se pudo eliminar el informe. Intenta de nuevo.');
    } catch (e) { console.error(e); alert('Error de conexión al intentar eliminar.'); }
}

// ============================================
// CALENDARIO
// ============================================
let currentMonth = new Date().getMonth();
let currentYear  = new Date().getFullYear();
const monthNames = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

function generateCalendar() {
    const container = document.getElementById('calendar-dates');
    const title     = document.getElementById('calendar-month');
    if (!container || !title) return;
    container.innerHTML = '';
    title.textContent = `${monthNames[currentMonth]} ${currentYear}`;
    const firstDay    = new Date(currentYear, currentMonth, 1);
    const lastDay     = new Date(currentYear, currentMonth + 1, 0);
    const prevLast    = new Date(currentYear, currentMonth, 0);
    const startOffset = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;
    
    for (let i = startOffset; i > 0; i--) container.appendChild(createDayCell(prevLast.getDate() - i + 1, true));
    for (let d = 1; d <= lastDay.getDate(); d++) container.appendChild(createDayCell(d, false));
        
    const remaining = 42 - (startOffset + lastDay.getDate());
    for (let d = 1; d <= remaining; d++) container.appendChild(createDayCell(d, true));
}

function createDayCell(day, isOther) {
    const div = document.createElement('div');
    div.className = 'calendar-date' + (isOther ? ' other-month' : '');
    div.textContent = day;
    
    if (!isOther) {
        const key = `${currentYear}-${String(currentMonth+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
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
                document.querySelectorAll('.calendar-date.selected').forEach(el => el.classList.remove('selected'));
                div.classList.add('selected');
                const notes = document.getElementById('selected-date-notes');
                if (notes) notes.textContent = 'Sin eventos para ' + formatDate(key);
            });
        }
    }
    return div;
}

function updateCalendarNotes(title, date, lugar) {
    const notes = document.getElementById('selected-date-notes');
    if (notes) {
        notes.innerHTML = `<strong>${title}</strong><br>${lugar} · ${formatDate(date)}`;
        if (window.innerWidth < 768) notes.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

function previousMonth() { if (--currentMonth < 0) { currentMonth = 11; currentYear--; } generateCalendar(); }
function nextMonth() { if (++currentMonth > 11) { currentMonth = 0; currentYear++; } generateCalendar(); }

// ============================================
// SISTEMA DE ORDENAMIENTO
// ============================================
function initSort() {
    const btnSort = document.getElementById('btn-sort-date');
    if (!btnSort) return;

    btnSort.addEventListener('click', () => {
        const currentOrder = btnSort.dataset.order;
        const newOrder = currentOrder === 'desc' ? 'asc' : 'desc'; 
        btnSort.dataset.order = newOrder;
        
        const span = btnSort.querySelector('#sort-text');
        const path = btnSort.querySelector('.sort-icon-path');
        
        if (newOrder === 'desc') {
            span.textContent = 'Recientes';
            path.setAttribute('d', 'M4 6h16M4 12h10M4 18h4');
            btnSort.classList.remove('active');
        } else {
            span.textContent = 'Antiguos';
            path.setAttribute('d', 'M4 18h16M4 12h10M4 6h4');
            btnSort.classList.add('active');
        }

        sortHistoryList(newOrder);
    });
}

function sortHistoryList(order) {
    const list = document.getElementById('history-list');
    const groups = Array.from(list.querySelectorAll('.history-group'));
    
    groups.sort((a, b) => {
        const itemA = a.querySelector('.history-item');
        const itemB = b.querySelector('.history-item');
        if (!itemA || !itemB) return 0;
        
        const dateA = new Date(itemA.dataset.fecha + 'T00:00:00').getTime();
        const dateB = new Date(itemB.dataset.fecha + 'T00:00:00').getTime();
        
        return order === 'desc' ? dateB - dateA : dateA - dateB;
    });

    groups.forEach((group, index) => {
        list.appendChild(group);
        const item = group.querySelector('.history-item');
        if (item) {
            item.classList.remove('highlight', 'accent');
            item.classList.add(index % 2 === 0 ? 'highlight' : 'accent');
        }
    });
}

// ============================================
// PANEL DE FILTROS COLAPSABLE Y LÓGICA
// ============================================
function initPanelToggle() {
    const btnToggle = document.getElementById('btn-toggle-filters');
    const panel = document.getElementById('filters-panel');

    if (btnToggle && panel) {
        btnToggle.addEventListener('click', () => {
            panel.classList.toggle('open');
            btnToggle.classList.toggle('active');
        });
    }
}

function initCustomDropdowns() {
    const dropdowns = document.querySelectorAll('.custom-dropdown');
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.custom-dropdown')) dropdowns.forEach(d => d.classList.remove('open'));
    });

    dropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const label = dropdown.querySelector('.dropdown-label');
        const items = dropdown.querySelectorAll('.dropdown-item');

        const initialSelected = dropdown.querySelector('.dropdown-item.selected');
        if (initialSelected) {
            dropdown.dataset.value = initialSelected.dataset.value;
            label.textContent = initialSelected.textContent.trim();
        } else {
            dropdown.dataset.value = 'all';
        }

        trigger.addEventListener('click', () => {
            dropdowns.forEach(d => { if (d !== dropdown) d.classList.remove('open'); });
            dropdown.classList.toggle('open');
        });

        items.forEach(item => {
            item.addEventListener('click', () => {
                items.forEach(i => i.classList.remove('selected'));
                item.classList.add('selected');
                label.textContent = item.textContent.trim();
                dropdown.dataset.value = item.dataset.value;
                dropdown.classList.remove('open');
                
                document.querySelectorAll('.filter-tag').forEach(t => t.classList.remove('active'));
                triggerDropdownFilter();
            });
        });
    });
}

function resetCustomDropdown(dropdownId, valueToSelect) {
    const dropdown = document.getElementById(dropdownId);
    if (!dropdown) return;
    const items = dropdown.querySelectorAll('.dropdown-item');
    const label = dropdown.querySelector('.dropdown-label');
    const trigger = dropdown.querySelector('.dropdown-trigger');
    
    let targetItem = dropdown.querySelector(`.dropdown-item[data-value="${valueToSelect}"]`);
    if (!targetItem) targetItem = dropdown.querySelector('.dropdown-item[data-value="all"]');

    if (targetItem) {
        items.forEach(i => i.classList.remove('selected'));
        targetItem.classList.add('selected');
        label.textContent = targetItem.textContent.trim();
        dropdown.dataset.value = targetItem.dataset.value;
        trigger.classList.remove('active');
    }
}

function initFilters() {
    initPanelToggle();
    initCustomDropdowns();

    const quickTags = document.querySelectorAll('.filter-tag');
    
    // Iniciar por defecto en "Este año" (year)
    applyFilterLogic('year');

    quickTags.forEach(tag => {
        tag.addEventListener('click', () => {
            quickTags.forEach(t => t.classList.remove('active'));
            tag.classList.add('active');
            
            resetCustomDropdown('dropdown-month', 'all');
            resetCustomDropdown('dropdown-year', 'all');
            
            applyFilterLogic(tag.dataset.filter);
        });
    });
}

function triggerDropdownFilter() {
    const dropMonth = document.getElementById('dropdown-month');
    const dropYear = document.getElementById('dropdown-year');
    
    const mVal = dropMonth ? dropMonth.dataset.value : 'all';
    const yVal = dropYear ? dropYear.dataset.value : 'all';

    if (dropMonth) {
        const trigger = dropMonth.querySelector('.dropdown-trigger');
        mVal !== 'all' ? trigger.classList.add('active') : trigger.classList.remove('active');
    }
    if (dropYear) {
        const trigger = dropYear.querySelector('.dropdown-trigger');
        yVal !== 'all' ? trigger.classList.add('active') : trigger.classList.remove('active');
    }

    applyFilterLogic('custom');
}

function applyFilterLogic(mode) {
    const dropMonth = document.getElementById('dropdown-month');
    const dropYear = document.getElementById('dropdown-year');
    const now = new Date();

    document.querySelectorAll('#history-list .history-group').forEach(group => {
        const card = group.querySelector('.history-item');
        if (!card) return;

        const dateStr = card.dataset.fecha; 
        const fecha = new Date(dateStr + 'T00:00:00');
        let show = true;

        if (mode === 'all') {
            show = true;
        } else if (mode === 'week') {
            const sw = new Date(now); 
            sw.setDate(now.getDate() - now.getDay()); 
            sw.setHours(0,0,0,0);
            show = (fecha >= sw);
        } else if (mode === 'month') {
            show = (fecha.getMonth() === now.getMonth() && fecha.getFullYear() === now.getFullYear());
        } else if (mode === 'year') {
            show = (fecha.getFullYear() === now.getFullYear());
        } else if (mode === 'custom') {
            const selectedYear = dropYear ? dropYear.dataset.value : 'all';
            const selectedMonth = dropMonth ? dropMonth.dataset.value : 'all';

            const cardYear = dateStr.substring(0, 4);
            const cardMonth = dateStr.substring(5, 7);

            let matchYear = (selectedYear === 'all') ? true : (cardYear === selectedYear);
            let matchMonth = (selectedMonth === 'all') ? true : (cardMonth === selectedMonth);

            show = matchYear && matchMonth;
        }

        if (show) group.classList.remove('hidden');
        else group.classList.add('hidden');
    });
}

// ============================================
// UTILIDADES
// ============================================
function formatDate(dateStr) {
    if (!dateStr) return '';
    const [y, m, d] = dateStr.split('-');
    return `${d}/${m}/${y}`;
}

function validarCamposObligatorios(form) {
    let hayError = false;
    ['evento', 'lugar', 'fecha'].forEach(name => {
        const input = form.querySelector(`[name="${name}"]`);
        if (input && !input.value.trim()) {
            hayError = true;
            input.style.border = '2px solid #ef4444';
            input.addEventListener('input', () => { input.style.border = ''; }, { once: true });
        }
    });
    if (hayError) alert('Por favor completa los campos obligatorios: Evento, Lugar y Fecha.');
    return !hayError;
}

// ============================================
// INIT PRINCIPAL
// ============================================
document.addEventListener('DOMContentLoaded', function () {
    generateCalendar();
    initHeaderInputs();
    setTodayDate();
    toggleRemoveButton();
    
    initSort();
    initFilters();

    const btnAdd = document.getElementById('btn-add-row');
    if (btnAdd) btnAdd.addEventListener('click', addRow);
    const btnRemove = document.getElementById('btn-remove-row');
    if (btnRemove) btnRemove.addEventListener('click', removeLastRow);

    const btnDelete = document.getElementById('btn-modal-delete');
    if (btnDelete) btnDelete.addEventListener('click', () => deleteReport(currentReportId));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeEventModal(); });

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

    const form = document.getElementById('create-report-form');
    document.querySelectorAll('.btn-form[data-action="pdf_download"], .btn-form[data-action="pdf_print"]').forEach(btn => {
        btn.addEventListener('click', function () {
            if (!form || !validarCamposObligatorios(form)) return;
            const action = this.dataset.action;
            const formData = new FormData(form);
            formData.set('_action', action);
            
            fetch(ROUTE_PREVIEW_PDF, { method: 'POST', body: formData, headers: { 'X-CSRF-TOKEN': CSRF_TOKEN } })
                .then(res => { if (!res.ok) throw new Error(); return res.blob(); })
                .then(blob => {
                    const url = URL.createObjectURL(blob);
                    if (action === 'pdf_download') {
                        const a = document.createElement('a'); a.href = url; a.download = 'informe.pdf';
                        document.body.appendChild(a); a.click(); document.body.removeChild(a);
                    } else { window.open(url, '_blank'); }
                })
                .catch(() => alert('No se pudo generar el PDF. Intenta de nuevo.'));
        });
    });

    if (form) {
        form.addEventListener('submit', () => { 
            const actionInput = document.getElementById('form-action');
            if (actionInput) actionInput.value = 'save'; 
        });
    }
});