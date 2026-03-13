// ESTO FORMABA PARTE DEL ARCHIVO BLADE PERO LO VOY MOVER AQUÍ
 document.addEventListener('DOMContentLoaded', () => {
        const flashToast = document.getElementById('flash-toast');
        if (flashToast) {
            showToast(flashToast.dataset.message);
            flashToast.remove();
        }

        // Sincronizar organización
        const headerOrgInput = document.getElementById('nombre_organizacion_header');
        const mobileOrgInput = document.getElementById('nombre_organizacion_mobile');
        const hiddenOrgInput = document.getElementById('nombre_organizacion');

        function syncOrg(val) {
            if (hiddenOrgInput) hiddenOrgInput.value = val;
            if (headerOrgInput) headerOrgInput.value = val;
            if (mobileOrgInput) mobileOrgInput.value = val;
        }
        if (headerOrgInput) headerOrgInput.addEventListener('input', () => syncOrg(headerOrgInput.value));
        if (mobileOrgInput) mobileOrgInput.addEventListener('input', () => syncOrg(mobileOrgInput.value));

        // Sincronizar fecha
        const headerFechaInput = document.getElementById('fecha_header');
        const mobileFechaInput = document.getElementById('fecha_mobile');
        const hiddenFechaInput = document.getElementById('fecha');

        function syncFecha(val) {
            if (hiddenFechaInput) hiddenFechaInput.value = val;
            if (headerFechaInput) headerFechaInput.value = val;
            if (mobileFechaInput) mobileFechaInput.value = val;
        }
        const today = new Date().toISOString().split('T')[0];
        if (headerFechaInput && !headerFechaInput.value) headerFechaInput.value = today;
        if (mobileFechaInput && !mobileFechaInput.value) mobileFechaInput.value = today;
        if (hiddenFechaInput && !hiddenFechaInput.value) hiddenFechaInput.value = today;

        if (headerFechaInput) headerFechaInput.addEventListener('change', () => syncFecha(headerFechaInput.value));
        if (mobileFechaInput) mobileFechaInput.addEventListener('change', () => syncFecha(mobileFechaInput.value));

        // Mostrar campos móvil según pantalla
        function applyMobileFields() {
            const isMobile    = window.innerWidth <= 768;
            const orgMobile   = document.getElementById('nombre_organizacion_mobile');
            const fechaMobile = document.querySelector('.form-fecha-mobile');
            const headerOrg   = document.querySelector('.header-org');
            const headerFecha = document.querySelector('.header-fecha');
            if (orgMobile)   orgMobile.closest('.form-org-mobile').style.display   = isMobile ? 'flex' : 'none';
            if (fechaMobile) fechaMobile.style.display = isMobile ? 'flex' : 'none';
            if (headerOrg)   headerOrg.style.display   = isMobile ? 'none' : 'flex';
            if (headerFecha) headerFecha.style.display  = isMobile ? 'none' : 'flex';
        }
        applyMobileFields();
        window.addEventListener('resize', applyMobileFields);
    });

    function toggleEditById(inputId, hiddenId) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const isReadonly = input.hasAttribute('readonly');
        if (isReadonly) {
            input.removeAttribute('readonly');
            input.focus();
        } else {
            input.setAttribute('readonly', true);
            const hidden = document.getElementById(hiddenId);
            if (hidden) hidden.value = input.value;
            if (hiddenId === 'nombre_organizacion') {
                const h = document.getElementById('nombre_organizacion_header');
                const m = document.getElementById('nombre_organizacion_mobile');
                if (h) h.value = input.value;
                if (m) m.value = input.value;
            }
            if (hiddenId === 'fecha') {
                const h = document.getElementById('fecha_header');
                const m = document.getElementById('fecha_mobile');
                if (h) h.value = input.value;
                if (m) m.value = input.value;
            }
        }
    }
// AQUÍ TERMINA LA PARTE QUE MOVI DE BLADE PARA UNIFICARLO EN UN SOLO JS

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

            // Actualizar href del botón "Solo formato"
            const btnBlank = document.getElementById('btn-blank');
            if (btnBlank) {
                btnBlank.href = tipo === 'reporte'
                    ? (typeof ROUTE_BLANK_REPORT     !== 'undefined' ? ROUTE_BLANK_REPORT     : '#')
                    : (typeof ROUTE_BLANK_ATTENDANCE !== 'undefined' ? ROUTE_BLANK_ATTENDANCE : '#');
            }

            aplicarTipoInforme(tipo);
        });
    });

    const tipoInicial = document.querySelector('.tipo-pill.active')?.dataset.tipo || 'asistencia';

    // Ajustar href inicial del botón "Solo formato"
    const btnBlankInit = document.getElementById('btn-blank');
    if (btnBlankInit) {
        btnBlankInit.href = tipoInicial === 'reporte'
            ? (typeof ROUTE_BLANK_REPORT     !== 'undefined' ? ROUTE_BLANK_REPORT     : '#')
            : (typeof ROUTE_BLANK_ATTENDANCE !== 'undefined' ? ROUTE_BLANK_ATTENDANCE : '#');
    }

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

    const count = (typeof eventsFromDB !== 'undefined' && eventsFromDB[date])
        ? eventsFromDB[date].beneficiaries_count : null;
    document.getElementById('modal-info-beneficiarios').textContent =
        count !== null ? `${count} personas` : '—';

    const btnView       = document.getElementById('btn-modal-view');
    const btnPdf        = document.getElementById('btn-modal-pdf');
    const btnEditReport = document.getElementById('btn-modal-edit-report');
    if (btnView)       { btnView.href       = `${ROUTE_BASE}/${id}/pdf`; btnView.target = '_blank'; }
    if (btnPdf)        { btnPdf.href        = `${ROUTE_BASE}/${id}/pdf`; btnPdf.target  = '_blank'; }
    if (btnEditReport) { btnEditReport.href = `${ROUTE_BASE}/${id}/edit`; }

    document.getElementById('event-modal').classList.add('active');
    document.getElementById('event-overlay').classList.add('active');
    document.body.classList.add('modal-open');
    document.documentElement.style.overflow = 'hidden'; 
}

function closeEventModal() {
    document.getElementById('event-modal').classList.remove('active');
    document.getElementById('event-overlay').classList.remove('active');
    document.body.classList.remove('modal-open');
    document.documentElement.style.overflow = ''; 
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

    list.dataset.sorting = 'true'; // ← agregar esto

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

    delete list.dataset.sorting; // ← agregar esto al final

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
            // Lunes de la semana actual
            const sw = new Date(now);
            const dayOfWeek = now.getDay() === 0 ? 6 : now.getDay() - 1;
            sw.setDate(now.getDate() - dayOfWeek);
            sw.setHours(0, 0, 0, 0);
            // Domingo de la semana actual
            const ew = new Date(sw);
            ew.setDate(sw.getDate() + 6);
            ew.setHours(23, 59, 59, 999);
            show = (fecha >= sw && fecha <= ew);
        } else if (mode === 'future') {
            const tomorrow = new Date(now);
            tomorrow.setHours(0, 0, 0, 0);
            tomorrow.setDate(tomorrow.getDate() + 1);
            show = (fecha >= tomorrow);
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
    const visible = document.querySelectorAll('#history-list .history-group:not(.hidden)').length;
    if (badge) badge.textContent = visible;

    const list = document.getElementById('history-list');
    if (!list) return;
    let emptyState = list.querySelector('.empty-state');

    if (visible === 0) {
        const activeTag = document.querySelector('.filter-tag.active');
        const mode = activeTag ? activeTag.dataset.filter : 'all';
        const search = (document.getElementById('search-input')?.value || '').trim();

        const messages = {
            week:   { icon: 'calendar-week',   title: 'Sin eventos esta semana',  sub: 'No hay registros para la semana actual.' },
            future: { icon: 'calendar-future', title: 'Sin eventos futuros',      sub: 'No hay programados más allá del día de hoy.' },
            month:  { icon: 'calendar-month',  title: 'Sin eventos este mes',     sub: 'No hay registrados del mes.' },
            year:   { icon: 'calendar-year',   title: 'Sin eventos este año',     sub: 'Aún no hay registros para este año.' },
            all:    { icon: 'folder',           title: 'Sin eventos registrados',  sub: 'Aún no se ha creado nada.' },
        };

        const ctx = search
            ? { icon: 'search', title: 'Sin resultados', sub: `No se encontraron eventos para "${search}".` }
            : (messages[mode] || messages.all);

        const icons = {
            'calendar-week': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/></svg>`,
            'calendar-future': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="M12 14v4m0 0l-2-2m2 2l2-2"/></svg>`,
            'calendar-month': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><circle cx="12" cy="16" r="2"/></svg>`,
            'calendar-year':  `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="M8 15l2 2 4-4"/></svg>`,
            'folder': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>`,
            'search': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M8 11h6M11 8v6" opacity="0.5"/></svg>`,
        };

        if (!emptyState) {
            emptyState = document.createElement('div');
            emptyState.className = 'empty-state empty-state--contextual';
            list.appendChild(emptyState);
        }
        emptyState.innerHTML = `
            <div class="empty-state-icon">${icons[ctx.icon] || icons.folder}</div>
            <p class="empty-state-title">${ctx.title}</p>
            <p class="empty-state-sub">${ctx.sub}</p>`;

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
     initAutocomplete(
        'edit-evento-display', 'edit-ac-evento',
        () => (typeof DB_EVENTOS !== 'undefined' ? DB_EVENTOS : []),
        false
    );
    initAutocomplete(
        'edit-lugar-display', 'edit-ac-lugar',
        () => (typeof DB_LUGARES !== 'undefined' ? DB_LUGARES : []),
        true
    );
}

// ============================================
// VISTA EDITAR
// ============================================
let editRowCount = 0;

function openEditView(id, from = 'history') {
    closeEventModal();

    fetch(`${ROUTE_API_REPORT}/${id}`, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('edit-org-display').value    = data.nombre_organizacion || '';
        document.getElementById('edit-fecha-display').value  = data.fecha || '';
        document.getElementById('edit-evento-display').value = data.evento || '';
        document.getElementById('edit-lugar-display').value  = data.lugar || '';
        document.getElementById('edit-nombre-org').value     = data.nombre_organizacion || '';
        document.getElementById('edit-fecha-hidden').value   = data.fecha || '';

        const tipo = (data.beneficiaries && data.beneficiaries.length > 0) ? 'reporte' : 'asistencia';
        document.getElementById('edit-tipo').value = tipo;

        const form = document.getElementById('edit-report-form');
        form.action = `${ROUTE_BASE}/${id}`;

        document.getElementById('edit-view').dataset.from = from;

        renderEditTable(tipo, data.beneficiaries || [], data.attendances || []);

        document.getElementById('calendar-view').classList.remove('active');
        document.getElementById('create-view').classList.remove('active');
        document.getElementById('history-view').classList.remove('active');
        document.getElementById('edit-view').classList.add('active');

        document.querySelector('.reports-container').style.padding = '0.5rem';
    })
    .catch(() => alert('No se pudo cargar el informe. Intenta de nuevo.'));
}

function closeEditView() {
    const editView = document.getElementById('edit-view');
    const from = editView.dataset.from || 'history';
    editView.classList.remove('active');

    document.querySelector('.reports-container').style.padding = '';

    if (from === 'calendar') {
        document.getElementById('calendar-view').classList.add('active');
    } else {
        document.getElementById('history-view').classList.add('active');
    }
}

function renderEditTable(tipo, beneficiaries, attendances) {
    const header = document.getElementById('edit-table-header');
    const body   = document.getElementById('edit-beneficiaries-table');
    const esAsistencia = tipo === 'asistencia';

    // Cabeceras
    if (esAsistencia) {
        header.style.gridTemplateColumns = '44px 1fr 1fr';
        header.innerHTML = `
            <div class="table-col">Nº</div>
            <div class="table-col">Persona beneficiaria</div>
            <div class="table-col">Edad</div>`;
    } else {
        header.style.gridTemplateColumns = '44px 1fr 1fr 1fr';
        header.innerHTML = `
            <div class="table-col">Nº</div>
            <div class="table-col">Persona beneficiaria</div>
            <div class="table-col">CURP</div>
            <div class="table-col">Edad</div>`;
    }

    // Filas
    body.innerHTML = '';
    const personas = esAsistencia ? attendances : beneficiaries;
    const minFilas = Math.max(personas.length, 6);
    editRowCount   = minFilas;

    for (let i = 0; i < minFilas; i++) {
        const p = personas[i] || {};
        body.appendChild(buildEditRow(i, tipo, p));
    }

    toggleEditRemoveButton();
}

function buildEditRow(i, tipo, data = {}) {
    const row = document.createElement('div');
    row.className = 'table-row';
    row.id = `edit-row-${i}`;

    if (tipo === 'asistencia') {
        row.style.gridTemplateColumns = '44px 1fr 1fr';
        row.innerHTML = `
            <div class="table-cell row-num">${i + 1}</div>
            <div class="table-cell">
                <input type="text" name="asistencias[${i}][asistencianombrebeneficiario]"
                       placeholder="Nombre completo"
                       value="${data.asistencianombrebeneficiario || ''}">
            </div>
            <div class="table-cell">
                <input type="number" name="asistencias[${i}][asistenciaedadbeneficiario]"
                       placeholder="Edad" min="0" max="120"
                       value="${data.asistenciaedadbeneficiario || ''}">
            </div>`;
    } else {
        row.style.gridTemplateColumns = '44px 1fr 1fr 1fr';
        row.innerHTML = `
            <div class="table-cell row-num">${i + 1}</div>
            <div class="table-cell">
                <input type="text" name="beneficiarios[${i}][reportenombrebeneficiario]"
                       placeholder="Nombre completo"
                       value="${data.reportenombrebeneficiario || ''}">
            </div>
            <div class="table-cell">
                <input type="text" name="beneficiarios[${i}][reportecurpbeneficiario]"
                       placeholder="CURP" maxlength="18" style="text-transform:uppercase"
                       value="${data.reportecurpbeneficiario || ''}">
            </div>
            <div class="table-cell">
                <input type="number" name="beneficiarios[${i}][reporteedadbeneficiario]"
                       placeholder="Edad" min="0" max="120"
                       value="${data.reporteedadbeneficiario || ''}">
            </div>`;
    }
    return row;
}

function addEditRow() {
    const body = document.getElementById('edit-beneficiaries-table');
    const tipo = document.getElementById('edit-tipo').value;
    body.appendChild(buildEditRow(editRowCount++, tipo));
    renumberEditRows();
    toggleEditRemoveButton();
}

function removeLastEditRow() {
    const body = document.getElementById('edit-beneficiaries-table');
    const rows = body.querySelectorAll('.table-row');
    if (rows.length <= 6) return;
    rows[rows.length - 1].remove();
    editRowCount = body.querySelectorAll('.table-row').length;
    renumberEditRows();
    toggleEditRemoveButton();
}

function renumberEditRows() {
    document.querySelectorAll('#edit-beneficiaries-table .table-row').forEach((row, i) => {
        const cell = row.querySelector('.row-num');
        if (cell) cell.textContent = i + 1;
        row.querySelectorAll('input').forEach(input => {
            input.name = input.name
                .replace(/asistencias\[\d+\]/, `asistencias[${i}]`)
                .replace(/beneficiarios\[\d+\]/, `beneficiarios[${i}]`);
        });
    });
}

function toggleEditRemoveButton() {
    const btn = document.getElementById('edit-btn-remove-row');
    const rows = document.querySelectorAll('#edit-beneficiaries-table .table-row').length;
    if (btn) btn.style.display = rows > 6 ? 'flex' : 'none';
}

// ============================================
// TOAST
// ============================================
function showToast(message) {
    const existing = document.querySelector('.toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
        <div class="toast-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <path d="M22 4L12 14.01l-3-3"/>
            </svg>
        </div>
        <div class="toast-content">
            <span class="toast-text">${message}</span>
        </div>
        <div class="toast-progress"></div>`;

    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

// ============================================
// PAGINACIÓN HISTORIAL
// ============================================
function initHistorialLimit() {
    const list = document.getElementById('history-list');
    if (!list) return;

function renderPagination() {
    const oldPag = document.getElementById('hist-pagination');
    if (oldPag) oldPag.remove();

    const groups = Array.from(list.querySelectorAll('.history-group:not(.hidden)'));
    const total = groups.length;

    // Mostrar todos si son 10 o menos
    groups.forEach(g => g.style.display = '');

    const wrapper = document.createElement('div');
    wrapper.id = 'hist-pagination';

    // Contador — solo visible si hay resultados
    if (total === 0) { list.after(wrapper); return; }
    const counter = document.createElement('div');
    counter.className = 'history-meta';
    counter.innerHTML = `
        <div class="history-meta-line"></div>
        <div class="history-count">
            <span>Mostrando</span>
            <span class="count-badge" id="pag-count-badge">${total}</span>
            <span>eventos</span>
        </div>
        <div class="history-meta-line"></div>`;

    wrapper.appendChild(counter);

    // Botones solo si hay más de 10
    if (total > 10) {
        groups.forEach((g, i) => {
            g.style.display = i < 10 ? '' : 'none';
        });

        counter.querySelector('.history-count').innerHTML = `
            <span>Mostrando</span>
            <span class="count-badge" id="pag-count-badge">${Math.min(10, total)}</span>
            <span>de ${total} eventos</span>`;

        const totalPages = Math.ceil(total / 10);
        let currentPage = 1;

        const btnGroup = document.createElement('div');
        btnGroup.className = 'hist-pagination';

        function updateButtons() {
            btnGroup.querySelectorAll('.hist-page-btn[data-page]').forEach(b => {
                b.classList.toggle('active', parseInt(b.dataset.page) === currentPage);
            });
            btnPrev.disabled = currentPage === 1;
            btnNext.disabled = currentPage === totalPages;
        }

        function goToPage(i) {
            currentPage = i;
            const from = (i - 1) * 10;
            const to   = i * 10;
            groups.forEach((g, idx) => {
                g.style.display = (idx >= from && idx < to) ? '' : 'none';
            });
            const badge = document.getElementById('pag-count-badge');
            if (badge) badge.textContent = Math.min(to, total) - from;
            updateButtons();
            list.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        // Botón Anterior
        const btnPrev = document.createElement('button');
        btnPrev.className = 'hist-page-btn hist-page-nav';
        btnPrev.disabled = true;
        btnPrev.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18L9 12L15 6"/></svg>`;
        btnPrev.addEventListener('click', () => { if (currentPage > 1) goToPage(currentPage - 1); });
        btnGroup.appendChild(btnPrev);

        // Botones numerados
        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.className = 'hist-page-btn' + (i === 1 ? ' active' : '');
            btn.dataset.page = i;
            btn.textContent = i;
            btn.addEventListener('click', () => goToPage(i));
            btnGroup.appendChild(btn);
        }

        // Botón Siguiente
        const btnNext = document.createElement('button');
        btnNext.className = 'hist-page-btn hist-page-nav';
        btnNext.disabled = totalPages === 1;
        btnNext.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18L15 12L9 6"/></svg>`;
        btnNext.addEventListener('click', () => { if (currentPage < totalPages) goToPage(currentPage + 1); });
        btnGroup.appendChild(btnNext);

        wrapper.appendChild(btnGroup);
    }

    list.after(wrapper);
}

    // Llamar al inicio
    renderPagination();

const observer = new MutationObserver(() => {
    if (list.dataset.sorting) return; // ← ignorar durante reordenamiento
    
    list.querySelectorAll('.history-group:not(.hidden)').forEach(g => {
        g.style.display = '';
    });
    renderPagination();
});

    observer.observe(list, { subtree: true, attributeFilter: ['class'] });
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
    initHistorialLimit();

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

    // Botón "Solo formato" — genera PDF en blanco con metadatos del formulario (sin beneficiarios)
    const btnBlank = document.getElementById('btn-blank');
    if (btnBlank) {
        btnBlank.addEventListener('click', function (e) {
            e.preventDefault();

            // Solo necesitamos los campos base — no los beneficiarios
            const tipo = document.getElementById('tipo_informe_form')?.value || 'asistencia';
            const org  = document.getElementById('nombre_organizacion')?.value || '';
            const evt  = document.getElementById('input-evento')?.value        || '';
            const lug  = document.getElementById('input-lugar')?.value         || '';
            const fec  = document.getElementById('fecha')?.value               || '';
            const tel  = form?.querySelector('[name="numero_telefonico"]')?.value || '';

            const formData = new FormData();
            formData.set('_token',               CSRF_TOKEN);
            formData.set('_action',              'blank_pdf');
            formData.set('tipo_informe',         tipo);
            formData.set('nombre_organizacion',  org);
            formData.set('evento',               evt);
            formData.set('lugar',                lug);
            formData.set('fecha',                fec || new Date().toISOString().split('T')[0]);
            formData.set('numero_telefonico',    tel);

            fetch(ROUTE_PREVIEW_PDF, {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
                .then(res => { if (!res.ok) throw new Error(); return res.blob(); })
                .then(blob => {
                    const url = URL.createObjectURL(blob);
                    window.open(url, '_blank');
                })
                .catch(() => alert('No se pudo generar el formato. Intenta de nuevo.'));
        });
    }

    // Botón Guardar
    if (form) {
        form.addEventListener('submit', () => {
            const actionInput = document.getElementById('form-action');
            if (actionInput) actionInput.value = 'save';
        });
    }

    // Botones tabla edición
    const editBtnAdd    = document.getElementById('edit-btn-add-row');
    const editBtnRemove = document.getElementById('edit-btn-remove-row');
    if (editBtnAdd)    editBtnAdd.addEventListener('click', addEditRow);
    if (editBtnRemove) editBtnRemove.addEventListener('click', removeLastEditRow);

    // Botón editar del modal
  const btnEditReport = document.getElementById('btn-modal-edit-report');
    if (btnEditReport) {
        btnEditReport.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentReportId) {
                const fromCalendar = document.getElementById('calendar-view').classList.contains('active');
                openEditView(currentReportId, fromCalendar ? 'calendar' : 'history');
            }
        });
    }
});

