// ============================================
// FECHA SELECCIONADA EN CALENDARIO
// ============================================
let calendarSelectedDate = null;

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
    applyDateToForm(calendarSelectedDate);
}

function showHistoryView() {
    document.getElementById('calendar-view').classList.remove('active');
    document.getElementById('create-view').classList.remove('active');
    document.getElementById('history-view').classList.add('active');
}

// ============================================
// APLICAR FECHA AL FORMULARIO
// ============================================
function applyDateToForm(dateStr) {
    const today = new Date();
    const y = today.getFullYear();
    const m = String(today.getMonth() + 1).padStart(2, '0');
    const d = String(today.getDate()).padStart(2, '0');
    const fechaToUse = dateStr || `${y}-${m}-${d}`;

    const h   = document.getElementById('fecha_header');
    const mob = document.getElementById('fecha_mobile');
    const hid = document.getElementById('fecha');

    if (h)   h.value   = fechaToUse;
    if (mob) mob.value = fechaToUse;
    if (hid) hid.value = fechaToUse;
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
    const hid = document.getElementById('fecha');
    if (hid && hid.value) return;
    applyDateToForm(calendarSelectedDate);
}

// ============================================
// TABLA — BENEFICIARIOS
// Nombres de campos según tipo activo:
//   asistencia → asistencias[i][asistencianombrebeneficiario] / asistencias[i][asistenciaedadbeneficiario]
//   reporte    → beneficiarios[i][reportenombrebeneficiario] / beneficiarios[i][reportecurpbeneficiario] / beneficiarios[i][reporteedadbeneficiario]
// ============================================
let rowCount = document.querySelectorAll('#beneficiaries-table .table-row').length;

function getTipoActivo() {
    return document.querySelector('.tipo-pill.active')?.dataset.tipo || 'asistencia';
}

function addRow() {
    const table = document.getElementById('beneficiaries-table');
    const tipo  = getTipoActivo();
    const idx   = rowCount++;
    const row   = document.createElement('div');
    row.className = 'table-row';
    row.id = `row-${idx}`;

    if (tipo === 'asistencia') {
        row.style.gridTemplateColumns = '44px 1fr 1fr';
        row.innerHTML = `
            <div class="table-cell row-num">${idx + 1}</div>
            <div class="table-cell">
                <input type="text" name="asistencias[${idx}][asistencianombrebeneficiario]" placeholder="Nombre completo">
            </div>
            <div class="table-cell">
                <input type="number" name="asistencias[${idx}][asistenciaedadbeneficiario]"
                       placeholder="Edad" min="0" max="120">
            </div>`;
    } else {
        row.style.gridTemplateColumns = '44px 1fr 1fr 1fr';
        row.innerHTML = `
            <div class="table-cell row-num">${idx + 1}</div>
            <div class="table-cell">
                <input type="text" name="beneficiarios[${idx}][reportenombrebeneficiario]" placeholder="Nombre completo">
            </div>
            <div class="table-cell">
                <input type="text" name="beneficiarios[${idx}][reportecurpbeneficiario]"
                       placeholder="CURP" maxlength="18" style="text-transform:uppercase">
            </div>
            <div class="table-cell">
                <input type="number" name="beneficiarios[${idx}][reporteedadbeneficiario]"
                       placeholder="Edad" min="0" max="120">
            </div>`;
    }

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
    const tipo = getTipoActivo();
    document.querySelectorAll('#beneficiaries-table .table-row').forEach((row, i) => {
        const cell = row.querySelector('.row-num');
        if (cell) cell.textContent = i + 1;

        if (tipo === 'asistencia') {
            row.querySelectorAll('input[name*="asistencias["]').forEach(input => {
                input.name = input.name.replace(/asistencias\[\d+\]/, `asistencias[${i}]`);
            });
        } else {
            row.querySelectorAll('input[name*="beneficiarios["]').forEach(input => {
                input.name = input.name.replace(/beneficiarios\[\d+\]/, `beneficiarios[${i}]`);
            });
        }
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
// TIPO DE INFORME — PILLS
// ============================================
function initTipoInforme() {
    const pills = document.querySelectorAll('.tipo-pill');
    if (!pills.length) return;

    pills.forEach(pill => {
        pill.addEventListener('click', () => {
            pills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');

            const tipo = pill.dataset.tipo;

            // Sincronizar ambos hidden de tipo (header y form)
            const hiddenHeader = document.getElementById('tipo_informe');
            const hiddenForm   = document.getElementById('tipo_informe_form');
            if (hiddenHeader) hiddenHeader.value = tipo;
            if (hiddenForm)   hiddenForm.value   = tipo;

            aplicarTipoInforme(tipo);
        });
    });

    const tipoInicial = document.querySelector('.tipo-pill.active')?.dataset.tipo || 'asistencia';
    aplicarTipoInforme(tipoInicial);
}

function aplicarTipoInforme(tipo) {
    const tableHeader = document.querySelector('.table-header');
    const tableBody   = document.getElementById('beneficiaries-table');
    if (!tableHeader || !tableBody) return;

    const esAsistencia = tipo === 'asistencia';

    // Cabeceras
    if (esAsistencia) {
        tableHeader.innerHTML = `
            <div class="table-col">Nº</div>
            <div class="table-col">Persona beneficiaria</div>
            <div class="table-col">Edad</div>`;
        tableHeader.style.gridTemplateColumns = '44px 1fr 1fr';
    } else {
        tableHeader.innerHTML = `
            <div class="table-col">Nº</div>
            <div class="table-col">Persona beneficiaria</div>
            <div class="table-col">CURP</div>
            <div class="table-col">Edad</div>`;
        tableHeader.style.gridTemplateColumns = '44px 1fr 1fr 1fr';
    }

    // Filas: conservar valores y cambiar nombres de campos
    tableBody.querySelectorAll('.table-row').forEach((row, i) => {
        // Leer valores actuales (sin importar el nombre que tengan ahora)
        const nombreVal = row.querySelector('input[name*="[asistencianombrebeneficiario]"], input[name*="[reportenombrebeneficiario]"]')?.value || '';
        const curpVal   = row.querySelector('input[name*="[reportecurpbeneficiario]"]')?.value   || '';
        const edadVal   = row.querySelector('input[name*="[asistenciaedadbeneficiario]"], input[name*="[reporteedadbeneficiario]"]')?.value || '';

        row.style.gridTemplateColumns = esAsistencia ? '44px 1fr 1fr' : '44px 1fr 1fr 1fr';

        if (esAsistencia) {
            row.innerHTML = `
                <div class="table-cell row-num">${i + 1}</div>
                <div class="table-cell">
                    <input type="text" name="asistencias[${i}][asistencianombrebeneficiario]"
                           placeholder="Nombre completo" value="${nombreVal}">
                </div>
                <div class="table-cell">
                    <input type="number" name="asistencias[${i}][asistenciaedadbeneficiario]"
                           placeholder="Edad" min="0" max="120" value="${edadVal}">
                </div>`;
        } else {
            row.innerHTML = `
                <div class="table-cell row-num">${i + 1}</div>
                <div class="table-cell">
                    <input type="text" name="beneficiarios[${i}][reportenombrebeneficiario]"
                           placeholder="Nombre completo" value="${nombreVal}">
                </div>
                <div class="table-cell">
                    <input type="text" name="beneficiarios[${i}][reportecurpbeneficiario]"
                           placeholder="CURP" maxlength="18"
                           style="text-transform:uppercase" value="${curpVal}">
                </div>
                <div class="table-cell">
                    <input type="number" name="beneficiarios[${i}][reporteedadbeneficiario]"
                           placeholder="Edad" min="0" max="120" value="${edadVal}">
                </div>`;
        }

        // Animación de filas
        if (!document.body.classList.contains('performance-mode')) {
            row.style.opacity = '0';
            row.style.transform = 'translateY(10px)';
            row.style.transition = 'none';
            setTimeout(() => {
                row.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                row.style.transitionDelay = `${i * 50}ms`;
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, 10);
        }
    });

    // Labels móvil dinámicos
    let styleEl = document.getElementById('dynamic-cell-labels');
    if (!styleEl) {
        styleEl = document.createElement('style');
        styleEl.id = 'dynamic-cell-labels';
        document.head.appendChild(styleEl);
    }
    if (esAsistencia) {
        styleEl.textContent = `
            @media (max-width: 768px) {
                .table-cell:nth-child(2)::before { content: 'Persona beneficiaria' !important; }
                .table-cell:nth-child(3)::before { content: 'Edad' !important; }
                .table-cell:nth-child(4)::before { display: none !important; }
            }
        `;
    } else {
        styleEl.textContent = `
            @media (max-width: 768px) {
                .table-cell:nth-child(2)::before { content: 'Persona beneficiaria' !important; }
                .table-cell:nth-child(3)::before { content: 'CURP' !important; }
                .table-cell:nth-child(4)::before { content: 'Edad' !important; display: block !important; }
            }
        `;
    }
}

// ============================================
// MODAL & ELIMINAR INFORME
// ============================================
let currentReportId = null;

function openEventModal(id, title, date, lugar) {
    currentReportId = id;
    const fechaFormateada = formatDate(date);

    document.getElementById('event-modal-title').textContent    = title;
    document.getElementById('event-modal-subtitle').textContent = fechaFormateada;
    document.getElementById('event-modal-lugar').textContent    = lugar || 'Sin especificar';

    const btnView = document.getElementById('btn-modal-view');
    const btnPdf  = document.getElementById('btn-modal-pdf');
    const btnEditReport = document.getElementById('btn-modal-edit-report');
    const count = (typeof eventsFromDB !== 'undefined' && eventsFromDB[date])
    ? eventsFromDB[date].beneficiaries_count : null;
    document.getElementById('modal-info-beneficiarios').textContent =
    count !== null ? `${count} personas` : '—';
    if (btnView) { btnView.href = `${ROUTE_BASE}/${id}/pdf`; btnView.target = '_blank'; }
    if (btnPdf)  { btnPdf.href  = `${ROUTE_BASE}/${id}/pdf`; btnPdf.target  = '_blank'; }
    if (btnEditReport) btnEditReport.href = `${ROUTE_BASE}/${id}/edit`;

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
        const key = `${currentYear}-${String(currentMonth+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;

        const now = new Date();
        const todayKey = `${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}-${String(now.getDate()).padStart(2,'0')}`;
        if (key === todayKey) div.classList.add('today');
        if (calendarSelectedDate === key) div.classList.add('selected');

        if (typeof eventsFromDB !== 'undefined' && eventsFromDB[key]) {
            const evt = eventsFromDB[key];
            div.classList.add('has-event');
            div.title = evt.title;

            div.addEventListener('click', () => {
                if (calendarSelectedDate === key) {
                    openEventModal(evt.id, evt.title, key, evt.lugar);
                } else {
                    calendarSelectedDate = key;
                    markSelectedDay(div);
                    updateCalendarNotes(evt.title, key, evt.lugar);
                }
            });
        } else {
            div.addEventListener('click', () => {
                calendarSelectedDate = key;
                markSelectedDay(div);
                const notes = document.getElementById('selected-date-notes');
                if (notes) notes.textContent = 'Sin eventos para ' + formatDate(key);
            });
        }
    }
    return div;
}

function markSelectedDay(activeDiv) {
    document.querySelectorAll('.calendar-date.selected').forEach(el => el.classList.remove('selected'));
    activeDiv.classList.add('selected');
}

function updateCalendarNotes(title, date, lugar) {
    const notes = document.getElementById('selected-date-notes');
    if (notes) {
        notes.innerHTML = `<strong>${title}</strong><br>${lugar} · ${formatDate(date)}`;
    }
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
            if (span) span.textContent = 'Recientes';
            if (path) path.setAttribute('d', 'M4 6h16M4 12h10M4 18h4');
            btnSort.classList.remove('active');
        } else {
            if (span) span.textContent = 'Antiguos';
            if (path) path.setAttribute('d', 'M4 18h16M4 12h10M4 6h4');
            btnSort.classList.add('active');
        }

        sortHistoryList(newOrder);
    });
}

function sortHistoryList(order) {
    const list = document.getElementById('history-list');
    if (!list) return;
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

    updateCountBadge();
}

// ============================================
// PANEL DE FILTROS COLAPSABLE Y LÓGICA
// ============================================
function initPanelToggle() {
    const btnToggle = document.getElementById('btn-toggle-filters');
    const panel     = document.getElementById('filters-panel');
    if (!btnToggle || !panel) return;

    btnToggle.addEventListener('click', () => {
        if (panel.classList.contains('open')) {
            panel.classList.add('closing');
            panel.classList.remove('open');
            btnToggle.classList.remove('active');
            panel.addEventListener('transitionend', () => {
                panel.classList.remove('closing');
            }, { once: true });
        } else {
            panel.classList.remove('closing');
            panel.classList.add('open');
            btnToggle.classList.add('active');
        }
    });
}

function initCustomDropdowns() {
    const dropdowns = document.querySelectorAll('.custom-dropdown');
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.custom-dropdown')) dropdowns.forEach(d => d.classList.remove('open'));
    });

    dropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const label   = dropdown.querySelector('.dropdown-label');
        const items   = dropdown.querySelectorAll('.dropdown-item');

        const initialSelected = dropdown.querySelector('.dropdown-item.selected');
        if (initialSelected) {
            dropdown.dataset.value = initialSelected.dataset.value;
            if (label) label.textContent = initialSelected.textContent.trim();
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
                if (label) label.textContent = item.textContent.trim();
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
    const items   = dropdown.querySelectorAll('.dropdown-item');
    const label   = dropdown.querySelector('.dropdown-label');
    const trigger = dropdown.querySelector('.dropdown-trigger');

    let targetItem = dropdown.querySelector(`.dropdown-item[data-value="${valueToSelect}"]`);
    if (!targetItem) targetItem = dropdown.querySelector('.dropdown-item[data-value="all"]');

    if (targetItem) {
        items.forEach(i => i.classList.remove('selected'));
        targetItem.classList.add('selected');
        if (label) label.textContent = targetItem.textContent.trim();
        dropdown.dataset.value = targetItem.dataset.value;
        if (trigger) trigger.classList.remove('active');
    }
}

function initFilters() {
    initPanelToggle();
    initCustomDropdowns();

    const quickTags = document.querySelectorAll('.filter-tag');

    applyFilterLogic('year');
    updateCountBadge();

    quickTags.forEach(tag => {
        tag.addEventListener('click', () => {
            quickTags.forEach(t => t.classList.remove('active'));
            tag.classList.add('active');
            resetCustomDropdown('dropdown-month', 'all');
            resetCustomDropdown('dropdown-year', 'all');
            applyFilterLogic(tag.dataset.filter);
            updateCountBadge();
        });
    });
}

function triggerDropdownFilter() {
    const dropMonth = document.getElementById('dropdown-month');
    const dropYear  = document.getElementById('dropdown-year');
    const mVal = dropMonth ? dropMonth.dataset.value : 'all';
    const yVal = dropYear  ? dropYear.dataset.value  : 'all';

    if (dropMonth) {
        const trigger = dropMonth.querySelector('.dropdown-trigger');
        if (trigger) mVal !== 'all' ? trigger.classList.add('active') : trigger.classList.remove('active');
    }
    if (dropYear) {
        const trigger = dropYear.querySelector('.dropdown-trigger');
        if (trigger) yVal !== 'all' ? trigger.classList.add('active') : trigger.classList.remove('active');
    }

    applyFilterLogic('custom');
    updateCountBadge();
}

function applyFilterLogic(mode) {
    const dropMonth = document.getElementById('dropdown-month');
    const dropYear  = document.getElementById('dropdown-year');
    const now = new Date();
    const search = (document.getElementById('search-input')?.value || '').toLowerCase().trim();

    document.querySelectorAll('#history-list .history-group').forEach(group => {
        const card = group.querySelector('.history-item');
        if (!card) return;

        const dateStr = card.dataset.fecha;
        const fecha   = new Date(dateStr + 'T00:00:00');
        let show = true;

        if (mode === 'all') {
            show = true;
        } else if (mode === 'week') {
            const sw = new Date(now);
            sw.setDate(now.getDate() - now.getDay());
            sw.setHours(0, 0, 0, 0);
            show = (fecha >= sw);
        } else if (mode === 'month') {
            show = (fecha.getMonth() === now.getMonth() && fecha.getFullYear() === now.getFullYear());
        } else if (mode === 'year') {
            show = (fecha.getFullYear() === now.getFullYear());
        } else if (mode === 'custom') {
            const selectedYear  = dropYear  ? dropYear.dataset.value  : 'all';
            const selectedMonth = dropMonth ? dropMonth.dataset.value : 'all';
            const cardYear  = dateStr.substring(0, 4);
            const cardMonth = dateStr.substring(5, 7);
            show = (selectedYear  === 'all' || cardYear  === selectedYear) &&
                   (selectedMonth === 'all' || cardMonth === selectedMonth);
        }

        if (show && search) {
            const texto = (card.querySelector('h4')?.textContent || '').toLowerCase() +
                          (card.querySelector('.history-place')?.textContent || '').toLowerCase();
            if (!texto.includes(search)) show = false;
        }

        group.classList.toggle('hidden', !show);
    });

    updateCountBadge();
}

// ============================================
// BÚSQUEDA EN TIEMPO REAL
// ============================================
function initSearch() {
    const input = document.getElementById('search-input');
    if (!input) return;
    input.addEventListener('input', () => {
        const activeTag = document.querySelector('.filter-tag.active');
        const mode = activeTag ? activeTag.dataset.filter : 'all';
        const dropMonth = document.getElementById('dropdown-month');
        const dropYear  = document.getElementById('dropdown-year');
        const hasCustom = (dropMonth?.dataset.value !== 'all') || (dropYear?.dataset.value !== 'all');
        applyFilterLogic(hasCustom ? 'custom' : mode);
    });
}

// ============================================
// CONTADOR DE RESULTADOS
// ============================================
function updateCountBadge() {
    const badge = document.getElementById('count-badge');
    if (!badge) return;
    const visible = document.querySelectorAll('#history-list .history-group:not(.hidden)').length;
    badge.textContent = visible;

    const list = document.getElementById('history-list');
    if (!list) return;
    let emptyState = list.querySelector('.empty-state');

    if (visible === 0) {
        if (!emptyState) {
            emptyState = document.createElement('div');
            emptyState.className = 'empty-state';
            emptyState.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
                </svg>
                <p>No se encontraron informes</p>`;
            list.appendChild(emptyState);
        }
    } else if (emptyState) {
        emptyState.remove();
    }
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
// AUTOCOMPLETE
// ============================================
const MUNICIPIOS_YUCATAN = [
    "Abalá, Yucatán","Acanceh, Yucatán","Akil, Yucatán","Baca, Yucatán","Bokobá, Yucatán",
    "Buctzotz, Yucatán","Cacalchén, Yucatán","Calotmul, Yucatán","Cansahcab, Yucatán",
    "Cantamayec, Yucatán","Celestún, Yucatán","Cenotillo, Yucatán","Conkal, Yucatán",
    "Cuncunul, Yucatán","Cuzamá, Yucatán","Chacsinkín, Yucatán","Chankom, Yucatán",
    "Chapab, Yucatán","Chemax, Yucatán","Chicxulub Pueblo, Yucatán","Chichimilá, Yucatán",
    "Chikindzonot, Yucatán","Chocholá, Yucatán","Chumayel, Yucatán","Dzán, Yucatán",
    "Dzemul, Yucatán","Dzidzantún, Yucatán","Dzilam de Bravo, Yucatán",
    "Dzilam González, Yucatán","Dzitás, Yucatán","Dzoncauich, Yucatán","Espita, Yucatán",
    "Halachó, Yucatán","Hocabá, Yucatán","Hoctún, Yucatán","Homún, Yucatán","Huhí, Yucatán",
    "Hunucmá, Yucatán","Ixil, Yucatán","Izamal, Yucatán","Kanasín, Yucatán",
    "Kantunil, Yucatán","Kaua, Yucatán","Kinchil, Yucatán","Kopomá, Yucatán",
    "Mama, Yucatán","Maní, Yucatán","Maxcanú, Yucatán","Mayapán, Yucatán","Mérida, Yucatán",
    "Mocochá, Yucatán","Motul, Yucatán","Muna, Yucatán","Muxupip, Yucatán","Opichén, Yucatán",
    "Oxkutzcab, Yucatán","Panabá, Yucatán","Peto, Yucatán","Pixoy, Yucatán","Progreso, Yucatán",
    "Quintana Roo, Yucatán","Río Lagartos, Yucatán","Sacalum, Yucatán","Samahil, Yucatán",
    "Sanahcat, Yucatán","San Felipe, Yucatán","Santa Elena, Yucatán","Seyé, Yucatán",
    "Sinanché, Yucatán","Sotuta, Yucatán","Sucilá, Yucatán","Sudzal, Yucatán",
    "Suma de Hidalgo, Yucatán","Tahdziú, Yucatán","Tahmek, Yucatán","Teabo, Yucatán",
    "Tecoh, Yucatán","Tekal de Venegas, Yucatán","Tekantó, Yucatán","Tekax, Yucatán",
    "Tekit, Yucatán","Tekom, Yucatán","Telchac Pueblo, Yucatán","Telchac Puerto, Yucatán",
    "Temax, Yucatán","Temozón, Yucatán","Tepakán, Yucatán","Tetiz, Yucatán","Teya, Yucatán",
    "Ticul, Yucatán","Timucuy, Yucatán","Tinum, Yucatán","Tixcacalcupul, Yucatán",
    "Tixkokob, Yucatán","Tixmehuac, Yucatán","Tixpéhual, Yucatán","Tizimín, Yucatán",
    "Tunkás, Yucatán","Tzucacab, Yucatán","Uayma, Yucatán","Ucú, Yucatán","Umán, Yucatán",
    "Valladolid, Yucatán","Xocchel, Yucatán","Yaxcabá, Yucatán","Yaxkukul, Yucatán",
    "Yobaín, Yucatán"
];

function initAutocomplete(inputId, dropdownId, getDbSuggestions, includeMunicipios) {
    const input = document.getElementById(inputId);
    const dropdown = document.getElementById(dropdownId);
    if (!input || !dropdown) return;

    let activeIndex = -1;
    let currentItems = [];

    function normalize(str) {
        return str.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function buildList(query) {
        const q = normalize(query.trim());
        if (!q) { closeDropdown(); return; }

        const dbItems = getDbSuggestions()
            .filter(s => s && normalize(s).includes(q))
            .slice(0, 5);

        const munItems = includeMunicipios
            ? MUNICIPIOS_YUCATAN.filter(m =>
                normalize(m).includes(q) &&
                !dbItems.some(d => normalize(d) === normalize(m))
              ).slice(0, 6)
            : [];

        if (!dbItems.length && !munItems.length) { closeDropdown(); return; }

        dropdown.innerHTML = '';
        currentItems = [];
        activeIndex = -1;

        if (dbItems.length) {
            const lbl = document.createElement('li');
            lbl.className = 'ac-section-label';
            lbl.textContent = 'Registrados';
            dropdown.appendChild(lbl);
            dbItems.forEach(text => {
                currentItems.push(text);
                dropdown.appendChild(buildItem(text, 'db'));
            });
        }

        if (munItems.length) {
            const lbl = document.createElement('li');
            lbl.className = 'ac-section-label';
            lbl.textContent = 'Municipios de Yucatán';
            dropdown.appendChild(lbl);
            munItems.forEach(text => {
                currentItems.push(text);
                dropdown.appendChild(buildItem(text, 'mun'));
            });
        }

        dropdown.classList.add('open');
    }

    function buildItem(text, type) {
        const li = document.createElement('li');
        li.className = 'ac-item';
        const badge = type === 'db'
            ? '<span class="ac-item-badge badge-db">BD</span>'
            : '<span class="ac-item-badge badge-mun">Mun</span>';
        li.innerHTML = `${badge}<span class="ac-item-text">${text}</span>`;
        li.addEventListener('mousedown', e => { e.preventDefault(); selectItem(text); });
        return li;
    }

    function selectItem(text) {
        input.value = text;
        closeDropdown();
        input.focus();
    }

    function closeDropdown() {
        dropdown.classList.remove('open');
        dropdown.innerHTML = '';
        currentItems = [];
        activeIndex = -1;
    }

    function highlightItem(index) {
        const items = dropdown.querySelectorAll('.ac-item');
        items.forEach((el, i) => el.classList.toggle('ac-active', i === index));
    }

    input.addEventListener('input', () => buildList(input.value));
    input.addEventListener('focus', () => { if (input.value) buildList(input.value); });
    input.addEventListener('blur',  () => setTimeout(closeDropdown, 150));

    input.addEventListener('keydown', e => {
        const items = dropdown.querySelectorAll('.ac-item');
        if (!dropdown.classList.contains('open') || !items.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIndex = Math.min(activeIndex + 1, items.length - 1);
            highlightItem(activeIndex);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIndex = Math.max(activeIndex - 1, 0);
            highlightItem(activeIndex);
        } else if (e.key === 'Enter' && activeIndex >= 0) {
            e.preventDefault();
            selectItem(currentItems[activeIndex]);
        } else if (e.key === 'Escape') {
            closeDropdown();
        }
    });
}

function initAllAutocompletes() {
    initAutocomplete(
        'input-evento', 'ac-evento',
        () => (typeof DB_EVENTOS !== 'undefined' ? DB_EVENTOS : []),
        false
    );
    initAutocomplete(
        'input-lugar', 'ac-lugar',
        () => (typeof DB_LUGARES !== 'undefined' ? DB_LUGARES : []),
        true
    );
}

// ============================================
// INIT PRINCIPAL
// ============================================
document.addEventListener('DOMContentLoaded', function () {
    if (localStorage.getItem('performanceMode') === 'true') {
        document.body.classList.add('performance-mode');
    }

    generateCalendar();
    initHeaderInputs();
    setTodayDate();
    toggleRemoveButton();

    initSort();
    initFilters();
    initSearch();
    initAllAutocompletes();
    initTipoInforme();

    const btnAdd    = document.getElementById('btn-add-row');
    const btnRemove = document.getElementById('btn-remove-row');
    if (btnAdd)    btnAdd.addEventListener('click', addRow);
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

    // Botones Exportar e Imprimir — generan PDF sin guardar en BD
    document.querySelectorAll('.btn-form[data-action="pdf_download"], .btn-form[data-action="pdf_print"]').forEach(btn => {
        btn.addEventListener('click', function () {
            if (!form || !validarCamposObligatorios(form)) return;
            const action   = this.dataset.action;
            const formData = new FormData(form);
            formData.set('_action', action);

            fetch(ROUTE_PREVIEW_PDF, {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
                .then(res => { if (!res.ok) throw new Error(); return res.blob(); })
                .then(blob => {
                    const url = URL.createObjectURL(blob);
                    if (action === 'pdf_download') {
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'informe.pdf';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    } else {
                        window.open(url, '_blank');
                    }
                })
                .catch(() => alert('No se pudo generar el PDF. Intenta de nuevo.'));
        });
    });

    // Botón Guardar
    if (form) {
        form.addEventListener('submit', () => {
            const actionInput = document.getElementById('form-action');
            if (actionInput) actionInput.value = 'save';
        });
    }
});