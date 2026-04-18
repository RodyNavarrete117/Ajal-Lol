/* ==================== projects_edit — JS ==================== */
(function () {
    'use strict';

    function showToast(message, type = 'success') {
        const existing = document.querySelector('.edit-toast');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.className = `edit-toast edit-toast--${type}`;
        toast.innerHTML = `
            <span class="edit-toast__icon">
                ${type === 'success' ? '<i class="fa fa-circle-check"></i>' : '<i class="fa fa-circle-exclamation"></i>'}
            </span>
            <span class="edit-toast__msg">${message}</span>`;

        const panelOpen = document.getElementById('detailsPanel')?.classList.contains('open');
        if (panelOpen && window.innerWidth > 480) toast.style.right = '360px';

        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('edit-toast--show'));
        setTimeout(() => {
            toast.classList.remove('edit-toast--show');
            toast.addEventListener('transitionend', () => toast.remove(), { once: true });
        }, 3400);
    }

    function validateForm(form) {
        let valid = true;
        form.querySelectorAll('input[required], textarea[required], select[required]').forEach(field => {
            clearError(field);
            if (!field.value.trim()) { markError(field, 'Este campo es obligatorio.'); valid = false; }
        });
        return valid;
    }
    function markError(field, msg) {
        field.classList.add('field--error');
        const err = document.createElement('span');
        err.className = 'field-error-msg'; err.textContent = msg;
        field.insertAdjacentElement('afterend', err);
        field.addEventListener('input', () => clearError(field), { once: true });
    }
    function clearError(field) {
        field.classList.remove('field--error');
        field.parentElement?.querySelector('.field-error-msg')?.remove();
    }

    /* Fecha local en ISO (YYYY-MM-DD) — sin depender de UTC */
    function todayISO() {
        const t = new Date();
        const y = t.getFullYear();
        const m = String(t.getMonth() + 1).padStart(2, '0');
        const d = String(t.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    const MESES = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                   'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    function toReadableDate(isoStr) {
        if (!isoStr) return '';
        const [, m, d] = isoStr.split('-');
        return `${parseInt(d, 10)} de ${MESES[parseInt(m, 10) - 1]}`;
    }

    function updateDateReadable(val) {
        const btn   = document.getElementById('datePickerBtn');
        const label = document.getElementById('datePickerLabel');
        if (label) label.textContent = val ? toReadableDate(val) : 'Selecciona una fecha';
        if (btn)   btn.classList.toggle('has-date', !!val);
        const input = document.getElementById('eventDateInput');
        if (input && val) input.value = val;
    }

    let years = Array.from(
        document.querySelectorAll('.year-dropdown-item')
    ).map(el => el.dataset.year);

    let currentIdx = 0;

    const visToggle  = document.getElementById('visToggleBtn');
    let visibilities = visToggle
        ? JSON.parse(visToggle.dataset.visibilities || '{}')
        : {};

    const subtitleInput = document.getElementById('subtituloInput');
    let subtitles = subtitleInput
        ? JSON.parse(subtitleInput.dataset.subtitles || '{}')
        : {};

    function currentYear() { return years[currentIdx]; }

    const yearDisplayNum  = document.getElementById('yearDisplayNum');
    const yearLabelBadge  = document.getElementById('yearLabelBadge');
    const formYearInput   = document.getElementById('formYear');
    const btnDelYear      = document.getElementById('btnDelYear');
    const btnPrev         = document.getElementById('btnPrevYear');
    const btnNext         = document.getElementById('btnNextYear');
    const selectedYearHid = document.getElementById('selectedYear');

    function renderYear() {
        const y = currentYear();
        if (!y) return;
        if (yearDisplayNum) yearDisplayNum.textContent = y;
        if (yearLabelBadge) yearLabelBadge.textContent = y;
        if (formYearInput)  formYearInput.value         = y;
        if (btnDelYear)     btnDelYear.dataset.year     = y;
        if (selectedYearHid) selectedYearHid.value      = y;
        const sb1 = document.getElementById('settingsYearBadge');
        const sb2 = document.getElementById('settingsYearBadgeDanger');
        if (sb1) sb1.textContent = y;
        if (sb2) sb2.textContent = y;
        if (btnPrev) btnPrev.disabled = currentIdx >= years.length - 1;
        if (btnNext) btnNext.disabled = currentIdx <= 0;
        if (subtitleInput) subtitleInput.value = subtitles[y] ?? '';
        const subtitleBadge = document.getElementById('subtitleYearBadge');
        if (subtitleBadge) subtitleBadge.textContent = y;
        updateVisUI(y);
        document.querySelectorAll('.year-dropdown-item').forEach(item => {
            const active = item.dataset.year === y;
            item.classList.toggle('active', active);
            item.setAttribute('aria-selected', String(active));
        });
        filterImagesByYear(y);
        document.querySelectorAll('#catFilter .pill').forEach(p => p.classList.remove('active'));
        document.querySelector('#catFilter .pill[data-cat="todas"]')?.classList.add('active');
        updateGlobalSaveBtn?.();
    }

    btnNext?.addEventListener('click', () => {
        if (currentIdx > 0) { currentIdx--; renderYear(); closeDropdown(); }
    });
    btnPrev?.addEventListener('click', () => {
        if (currentIdx < years.length - 1) { currentIdx++; renderYear(); closeDropdown(); }
    });

    const yearDisplayBtn  = document.getElementById('yearDisplayBtn');
    const yearDropdown    = document.getElementById('yearDropdown');

    if (yearDropdown) {
        document.body.appendChild(yearDropdown);
        yearDropdown.style.display = 'none';
    }

    function positionDropdown() {
        if (!yearDropdown || !yearDisplayBtn) return;
        const rect = yearDisplayBtn.getBoundingClientRect();
        const ddW = Math.max(rect.width, 120);
        let left = rect.left + (rect.width / 2) - (ddW / 2);
        left = Math.max(8, Math.min(left, window.innerWidth - ddW - 8));
        yearDropdown.style.top   = (rect.bottom + 6) + 'px';
        yearDropdown.style.left  = left + 'px';
        yearDropdown.style.width = ddW + 'px';
    }

    function openDropdown() {
        if (!yearDropdown) return;
        yearDropdown.style.visibility = 'hidden';
        yearDropdown.style.display    = 'block';
        positionDropdown();
        yearDropdown.style.visibility = '';
        yearDisplayBtn?.setAttribute('aria-expanded', 'true');
    }
    function closeDropdown() {
        if (!yearDropdown) return;
        yearDropdown.style.display = 'none';
        yearDisplayBtn?.setAttribute('aria-expanded', 'false');
    }
    function toggleDropdown() {
        yearDropdown?.style.display === 'none' ? openDropdown() : closeDropdown();
    }

    yearDisplayBtn?.addEventListener('click', e => { e.stopPropagation(); toggleDropdown(); });
    yearDropdown?.addEventListener('click', e => {
        const item = e.target.closest('.year-dropdown-item');
        if (!item) return;
        const y = item.dataset.year;
        const idx = years.indexOf(y);
        if (idx !== -1) { currentIdx = idx; renderYear(); }
        closeDropdown();
    });
    document.addEventListener('click', e => {
        if (!e.target.closest('#yearDisplayWrap') && !e.target.closest('#yearDropdown')) closeDropdown();
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDropdown(); });
    window.addEventListener('scroll', () => { if (yearDropdown?.style.display !== 'none') positionDropdown(); }, { passive: true });
    window.addEventListener('resize', () => { if (yearDropdown?.style.display !== 'none') positionDropdown(); }, { passive: true });

    const btnAddYear     = document.getElementById('btnAddYear');
    const addYearForm    = document.getElementById('addYearForm');
    const btnConfirmYear = document.getElementById('btnConfirmYear');
    const btnCancelYear  = document.getElementById('btnCancelYear');

    // Variables del nuevo dropdown personalizado
    const yearSelectContainer = document.getElementById('newYearSelectContainer');
    const yearDisplay         = document.getElementById('newYearDisplay');
    const yearValueSpan       = document.getElementById('newYearValue');
    const yearDropdownList    = document.getElementById('newYearDropdown');
    let selectedNewYear       = ''; // Aquí se guarda el año elegido

    if (yearDropdownList) {
        document.body.appendChild(yearDropdownList);
        yearDropdownList.style.position = 'fixed';
        yearDropdownList.style.zIndex   = '99999';
        yearDropdownList.style.display  = 'none';
    }

    function positionNewYearDropdown() {
        if (!yearDropdownList || !yearDisplay) return;
        const rect = yearDisplay.getBoundingClientRect();
        yearDropdownList.style.top   = (rect.bottom + 4) + 'px';
        yearDropdownList.style.left  = rect.left + 'px';
        yearDropdownList.style.width = rect.width + 'px';
    }

    function buildAvailableYears() {
        const cur = new Date().getFullYear();
        const all = [];
        for (let y = cur; y >= 2023; y--) {
            if (!years.includes(String(y))) all.push(String(y));
        }
        return all;
    }

    function populateYearSelect() {
        if (!yearDropdownList || !yearValueSpan) return;
        yearDropdownList.innerHTML = '';
        const available = buildAvailableYears();
        
        if (available.length === 0) {
            yearValueSpan.textContent = 'Vacío';
            selectedNewYear = '';
            const div = document.createElement('div');
            div.className = 'elegant-select-option disabled';
            div.textContent = 'Sin años';
            yearDropdownList.appendChild(div);
        } else {
            // Ponemos el primer año disponible por defecto
            yearValueSpan.textContent = available[0];
            selectedNewYear = available[0];
            
            available.forEach(y => {
                const div = document.createElement('div');
                div.className = 'elegant-select-option';
                div.textContent = y;
                div.addEventListener('click', (e) => {
                    e.stopPropagation();
                    selectedNewYear = y;
                    yearValueSpan.textContent = y;
                    yearDropdownList.style.display = 'none'; // Cerramos al elegir
                });
                yearDropdownList.appendChild(div);
            });
        }
    }

    yearDisplay?.addEventListener('click', (e) => {
        e.stopPropagation();
        const isHidden = yearDropdownList.style.display === 'none';
        if (isHidden) {
            positionNewYearDropdown();
            yearDropdownList.style.display = 'block';
        } else {
            yearDropdownList.style.display = 'none';
        }
    });

    // Cerrar el menú si hacen clic en otra parte de la pantalla
    document.addEventListener('click', (e) => {
        if (yearSelectContainer && !yearSelectContainer.contains(e.target)) {
            if (yearDropdownList) yearDropdownList.style.display = 'none';
        }
    });

    function setAddYearIcon(isOpen) {
        const icon = btnAddYear?.querySelector('i');
        if (!icon) return;
        icon.className = isOpen ? 'fa fa-xmark' : 'fa fa-plus';
        if (btnAddYear) btnAddYear.title = isOpen ? 'Cancelar' : 'Agregar año';
    }

    btnAddYear?.addEventListener('click', () => {
        const isOpen = addYearForm?.style.display !== 'none';
        if (isOpen) { hideAddYearForm(); }
        else {
            populateYearSelect();
            addYearForm.style.display = 'flex';
            closeDropdown(); // Cierra el menú principal de arriba si estaba abierto
            setAddYearIcon(true);
        }
    });

    function hideAddYearForm() {
        if (addYearForm) addYearForm.style.display = 'none';
        if (yearDropdownList) yearDropdownList.style.display = 'none';
        setAddYearIcon(false);
    }

    btnCancelYear?.addEventListener('click', hideAddYearForm);
    btnConfirmYear?.addEventListener('click', confirmAddYear);

    function confirmAddYear() {
        // En lugar del viejo select, usamos la variable 'selectedNewYear'
        const val = selectedNewYear; 
        
        if (!val) { showToast('Selecciona un año.', 'error'); return; }
        if (years.includes(val)) { showToast('Ese año ya existe.', 'error'); return; }

        const token = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        fetch('/admin/pages/projects/year-store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ year: val })
        })
        .then(res => { if (!res.ok) throw new Error(); return res.json(); })
        .then(() => {
            years.push(val);
            years.sort((a, b) => Number(b) - Number(a));
            currentIdx = years.indexOf(val);
            const visCount = Object.values(visibilities).filter(Boolean).length;
            visibilities[val] = visCount < 5;
            subtitles[val] = '';
            addYearToDropdown(val);
            hideAddYearForm();
            renderYear();
            updateVisCounter(); 
            showToast(`Año ${val} agregado.`);
        })
        .catch(() => showToast('Error al agregar el año.', 'error'));
    }
    
    function addYearToDropdown(year) {
        if (!yearDropdown) return;
        yearDropdown.innerHTML = '';
        years.forEach(y => {
            const div = document.createElement('div');
            div.className = 'year-dropdown-item' + (y === year ? ' active' : '');
            div.dataset.year = y;
            div.setAttribute('role', 'option');
            div.setAttribute('aria-selected', String(y === year));
            const isVis = visibilities[y] ?? false;
            div.innerHTML = `
                <span class="ydi-num">${y}</span>
                <span class="ydi-dot ${isVis ? 'vis-on' : 'vis-off'}"
                      title="${isVis ? 'Visible' : 'Oculto'}"></span>`;
            yearDropdown.appendChild(div);
        });
    }

    const confirmDelBg     = document.getElementById('confirmDelBg');
    const confirmDelYearEl = document.getElementById('confirmDelYear');
    const btnConfirmDelOk  = document.getElementById('btnConfirmDelOk');
    const btnConfirmDelCnl = document.getElementById('btnConfirmDelCancel');
    let yearPendingDelete  = null;

    function openConfirmDel(year) {
        yearPendingDelete = year;
        if (confirmDelYearEl) confirmDelYearEl.textContent = year;
        confirmDelBg?.classList.add('open');
    }
    function closeConfirmDel() {
        confirmDelBg?.classList.remove('open');
        yearPendingDelete = null;
    }

    btnConfirmDelCnl?.addEventListener('click', closeConfirmDel);
    confirmDelBg?.addEventListener('click', e => { if (e.target === confirmDelBg) closeConfirmDel(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && confirmDelBg?.classList.contains('open')) closeConfirmDel();
    });

    btnConfirmDelOk?.addEventListener('click', () => {
        const y = yearPendingDelete;
        if (!y) return;
        const token = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        fetch('/admin/pages/projects/year-destroy', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ year: y })
        })
        .then(res => { if (!res.ok) throw new Error(); return res.json(); })
        .then(() => {
            closeConfirmDel();
            years.splice(years.indexOf(y), 1);
            delete visibilities[y];
            delete subtitles[y];
            if (currentIdx >= years.length) currentIdx = years.length - 1;
            addYearToDropdown(currentYear());
            document.querySelectorAll(`.img-card[data-year="${y}"]`).forEach(c => c.remove());
            renderYear();
            updateVisCounter();
            showToast(`Año ${y} eliminado.`);
        })
        .catch(() => showToast('Error al eliminar el año.', 'error'));
    });
    document.addEventListener('click', e => {
        const delBtn = e.target.closest('#btnDelYear');
        if (!delBtn) return;
        const y = currentYear();
        if (years.length <= 1) { showToast('Debe existir al menos un año.', 'error'); return; }
        openConfirmDel(y);
    });

    const visStatusTxt   = document.getElementById('visStatusTxt');
    const visCounterTxt  = document.getElementById('visCounterTxt');
    const visCounter     = document.getElementById('visCounter');

    visToggle?.addEventListener('click', () => {
        const y        = currentYear();
        const isOn     = visibilities[y] ?? true;
        const visCount = Object.values(visibilities).filter(Boolean).length;
        if (!isOn && visCount >= 5) {
            showToast('Límite de 5 años visibles alcanzado. Oculta otro año primero.', 'error');
            return;
        }

        const newVal = !isOn;
        const token  = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        fetch('/admin/pages/projects/year-update', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify({ 
                year:      y, 
                subtitulo: subtitleInput?.value.trim() ?? '', 
                visible:   newVal 
            })
        })
        .then(res => { if (!res.ok) throw new Error(); return res.json(); })
        .then(() => {
            visibilities[y] = newVal;
            updateVisUI(y);
            updateVisCounter();
            updateDropdownVisItem(y);
            showToast(newVal ? `Año ${y} ahora es visible en el sitio.` : `Año ${y} ocultado del sitio.`);
        })
        .catch(() => showToast('Error al actualizar visibilidad.', 'error'));
    });

    function updateVisUI(year) {
        const isOn = visibilities[year] ?? true;
        if (visToggle) {
            visToggle.classList.toggle('on', isOn);
            visToggle.setAttribute('aria-pressed', String(isOn));
        }
        if (visStatusTxt) visStatusTxt.textContent = isOn ? 'Activo' : 'Oculto';
    }

    function updateVisCounter() {
        const count = Object.values(visibilities).filter(Boolean).length;
        if (visCounterTxt) visCounterTxt.textContent = `${count} / 5 visibles`;
        const existing = visCounter?.querySelector('.vis-limit-badge');
        if (count >= 5) {
            if (!existing) {
                const badge = document.createElement('span');
                badge.className = 'vis-limit-badge'; badge.textContent = 'Límite';
                visCounter?.appendChild(badge);
            }
        } else { existing?.remove(); }
    }

    function updateDropdownVisItem(year) {
        const item = yearDropdown?.querySelector(`.year-dropdown-item[data-year="${year}"]`);
        if (!item) return;
        const isVis = visibilities[year] ?? true;
        const dot   = item.querySelector('.ydi-dot');
        if (dot) {
            dot.className = `ydi-dot ${isVis ? 'vis-on' : 'vis-off'}`;
            dot.title     = isVis ? 'Visible' : 'Oculto';
        }
    }

    function cardsOfYear(year) {
        return Array.from(document.querySelectorAll(`#imgGrid .img-card[data-year="${year}"]`));
    }

    function refreshFilterPills(year) {
        const cards     = cardsOfYear(year);
        const toolbar   = document.getElementById('imgToolbar');
        const catFilter = document.getElementById('catFilter');
        if (!catFilter || !toolbar) return;
        if (cards.length === 0) { toolbar.style.display = 'none'; return; }
        toolbar.style.display = '';
        const usedCats = new Set(cards.map(c => c.dataset.cat));
        catFilter.querySelectorAll('.pill[data-cat]').forEach(pill => {
            const cat = pill.dataset.cat;
            if (cat === 'todas') return;
            pill.style.display = usedCats.has(cat) ? '' : 'none';
        });
    }

    function filterImagesByYear(year) {
        let visible = 0;
        document.querySelectorAll('#imgGrid .img-card').forEach(card => {
            const show = card.dataset.year === year;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        refreshFilterPills(year);
        refreshEmptyState(visible, year);
    }

    function filterImagesByCat(cat) {
        const year = currentYear();
        let visible = 0;
        document.querySelectorAll('#imgGrid .img-card').forEach(card => {
            if (card.dataset.year !== year) return;
            const show = cat === 'todas' || card.dataset.cat === cat;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        refreshEmptyState(visible, year);
    }

    function refreshEmptyState(visible, year) {
        const grid = document.getElementById('imgGrid');
        grid?.querySelector('.img-empty')?.remove();
        if (visible === 0) {
            const empty = document.createElement('div');
            empty.className = 'img-empty';
            const totalOfYear = cardsOfYear(year ?? currentYear()).length;
            if (totalOfYear === 0) {
                empty.innerHTML = `
                    <i class="fa fa-folder-open"></i>
                    <p>Aún no hay imágenes para este año.</p>
                    <button class="btn-empty-upload" type="button" id="btnEmptyUpload">
                        <i class="fa fa-plus"></i> Subir primera imagen
                    </button>`;
            } else {
                empty.innerHTML = `
                    <i class="fa fa-magnifying-glass"></i>
                    <p>Ninguna imagen coincide con este filtro.</p>`;
            }
            grid?.appendChild(empty);
            document.getElementById('btnEmptyUpload')?.addEventListener('click', () => {
                document.getElementById('btnAddImage')?.click();
            });
        }
    }

    const btnGlobalSave      = document.getElementById('btnGlobalSave');
    const btnGlobalSaveLabel = document.getElementById('btnGlobalSaveLabel');
    const btnGlobalSaveIcon  = document.getElementById('btnGlobalSaveIcon');

    function updateGlobalSaveBtn() {
        if (!btnGlobalSave) return;
        const y            = currentYear();
        const subtitleVal  = subtitleInput?.value.trim() ?? '';
        const savedSub     = subtitles[y] ?? '';
        const hasSubChange = subtitleVal !== savedSub;
        const hasImages    = cardsOfYear(y).length > 0;
        
        // Verifica si hay imágenes pendientes, deletes o updates
        const hasPendingWork = pendingImages.filter(Boolean).length > 0 || pendingDeletes.length > 0 || pendingUpdates.length > 0 || pendingCatDeletes.length > 0 || pendingCatNews.length > 0 || pendingCatOrder;;

        if (!hasImages && !hasPendingWork) {
            btnGlobalSave.disabled = true;
            btnGlobalSave.title    = 'Agrega al menos una imagen antes de guardar';
            if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Guardar';
            if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-floppy-disk';
            return;
        }
        
        btnGlobalSave.disabled = !(hasSubChange || hasPendingWork);
        btnGlobalSave.title    = '';
        if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = (hasSubChange || hasPendingWork) ? 'Guardar cambios' : 'Guardar';
        if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-floppy-disk';
    }

    // LISTAS PRINCIPALES DEL SISTEMA
    let pendingImages = [];
    let pendingUpdates = []; 
    let pendingCatNews = [];
    let pendingDeletes = [];
    let pendingCatDeletes = [];
    let pendingCatOrder = false;
    let editState = { isEditing: false, type: null, idOrIndex: null };

    btnGlobalSave?.addEventListener('click', async function () {
            const toUpload = pendingImages.filter(Boolean);
            const y     = currentYear();
            const sub   = subtitleInput?.value.trim() ?? '';
            const token = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Guardando...';
            if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-spinner fa-spin';
            btnGlobalSave.disabled = true;

            // 1. SUBIR IMÁGENES NUEVAS
            for (const item of toUpload) {
                const fd = new FormData();
                fd.append('_token',      token);
                fd.append('year',        y);
                fd.append('image',       item.file);
                fd.append('titulo',      item.titulo);
                fd.append('description', item.description);
                fd.append('category',    item.category);
                fd.append('event_date',  item.date);

                try {
                    const res = await fetch('/admin/pages/projects/image', { method: 'POST', body: fd });
                    if (!res.ok) throw new Error();
                } catch(err) {
                    showToast('Error al subir una imagen.', 'error');
                    if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Guardar';
                    if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-floppy-disk';
                    btnGlobalSave.disabled = false;
                    return; // Detiene todo y NO recarga
                }
            }

            // 2. ELIMINAR IMÁGENES MARCADAS
            for (const id of pendingDeletes) {
                try {
                    const res = await fetch(`/admin/pages/projects/image/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
                    });
                    if (!res.ok) throw new Error();
                    document.querySelector(`.img-card[data-id="${id}"]`)?.remove();
                } catch {
                    showToast('Error al eliminar una imagen.', 'error');
                }
            }

            // 3. PROCESAR ACTUALIZACIONES (EDICIONES)
            for (const update of pendingUpdates) {
                const fd = new FormData();
                fd.append('_token', token);
                // 🔥 LE QUITAMOS EL _method = PUT PORQUE TU RUTA ES POST 🔥
                if (update.file) fd.append('image', update.file); 
                fd.append('titulo', update.titulo);
                fd.append('description', update.description);
                fd.append('category', update.category);
                fd.append('event_date', update.date);

                try {
                    const res = await fetch(`/admin/pages/projects/image/${update.id}`, {
                        method: 'POST', // Tu web.php espera POST
                        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                        body: fd
                    });
                    
                    if (!res.ok) {
                        const errorData = await res.json();
                        console.error("DETALLES DEL ERROR:", errorData);
                        let errorMsg = 'Error al actualizar.';
                        if (errorData.errors) errorMsg = Object.values(errorData.errors).flat().join(' | ');
                        else if (errorData.message) errorMsg = errorData.message;
                        throw new Error(errorMsg);
                    }
                } catch(err) {
                    showToast(err.message, 'error');
                    if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Guardar';
                    if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-floppy-disk';
                    btnGlobalSave.disabled = false;
                    return; // Detiene la ejecución
                }
            }

            // 3.5 ELIMINAR CATEGORÍAS PENDIENTES
            for (const id of pendingCatDeletes) {
                try {
                    const res = await fetch(`/admin/pages/projects/category/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
                    });
                    if (!res.ok) throw new Error();
                } catch {
                    showToast('Error al eliminar una categoría.', 'error');
                }
            }
            pendingCatDeletes = [];

            // 3.6 CREAR CATEGORÍAS NUEVAS
            const manager = document.getElementById('catPillsManager');
            for (const nombre of pendingCatNews) {
                try {
                    const res = await fetch('/admin/pages/projects/category', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                        body: JSON.stringify({ nombre })
                    });
                    if (!res.ok) throw new Error();
                    const data = await res.json();
                    const pill = manager?.querySelector(`.cat-mgr-pill--pending-new[data-cat="${nombre}"]`);
                    if (pill) { pill.dataset.id = data.id; pill.classList.remove('cat-mgr-pill--pending-new'); }
                } catch {
                    showToast(`Error al guardar la categoría "${nombre}".`, 'error');
                }
            }
            pendingCatNews = [];

            // 3.7 GUARDAR ORDEN DE CATEGORÍAS
            if (pendingCatOrder) {
                const manager = document.getElementById('catPillsManager');
                const orden = Array.from(manager?.querySelectorAll('.cat-mgr-pill') || [])
                    .filter(p => p.dataset.id)
                    .map((p, i) => ({ id: p.dataset.id, orden: i + 1 }));

                try {
                    await fetch('/admin/pages/projects/category-order', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                        body: JSON.stringify({ orden })
                    });
                } catch {
                    showToast('Error al guardar el orden.', 'error');
                }
                pendingCatOrder = false;
            }

            // 4. GUARDAR SUBTÍTULO
            try {
                await fetch('/admin/pages/projects/year-update', {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                    body: JSON.stringify({ year: y, subtitulo: sub, visible: visibilities[y] ?? true })
                });
            } catch(err) {
                console.error('Error year-update:', err);
            }

            // LIMPIAR TODO AL FINALIZAR
            pendingImages = [];
            pendingDeletes = [];
            pendingUpdates = [];
            
            // Guardar qué tab y año estaba activo antes de recargar
            const activeTab = document.querySelector('.content-tab.active')?.dataset.tab ?? 'images';
            sessionStorage.setItem('activeTab', activeTab);
            sessionStorage.setItem('activeYear', currentYear());

            window.location.reload();
    });

    subtitleInput?.addEventListener('input', updateGlobalSaveBtn);

    const tabPanels = {
        images:     document.getElementById('tabImages'),
        categories: document.getElementById('tabCategories'),
        settings:   document.getElementById('tabSettings'),
    };
    document.querySelectorAll('.content-tab').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.content-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

              if (window.innerWidth <= 680) {
                    btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                }
            const target = btn.dataset.tab;
            Object.entries(tabPanels).forEach(([key, panel]) => {
                if (!panel) return;
                const show = key === target;
                panel.style.display = show ? '' : 'none';
                panel.classList.toggle('active', show);
                if (show) {
                    panel.classList.remove('tab-entering');
                    void panel.offsetWidth;
                    panel.classList.add('tab-entering');
                }
            });
        });
    });

    document.getElementById('catFilter')?.addEventListener('click', e => {
        const pill = e.target.closest('.pill');
        if (!pill) return;
        document.querySelectorAll('#catFilter .pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        filterImagesByCat(pill.dataset.cat);
    });

    document.getElementById('catPillsManager')?.addEventListener('click', e => {
        const delBtn = e.target.closest('.cat-mgr-pill__del');
        if (!delBtn) return;

        const pill   = delBtn.closest('.cat-mgr-pill');
        const catId  = pill?.dataset.id;
        const catName = pill?.dataset.cat;
        if (!pill) return;

        // Si es nueva y aún no guardada, simplemente quitarla
        if (pill.classList.contains('cat-mgr-pill--pending-new')) {
            const nombre = pill.dataset.cat;
            pendingCatNews = pendingCatNews.filter(n => n !== nombre);
            pill.remove();
            document.querySelector(`#catFilter .pill[data-cat="${nombre}"]`)?.remove();
            document.querySelector(`#catPillsWrap .cat-pill[data-value="${nombre}"]`)?.remove();
            updateGlobalSaveBtn();
            showToast(`Categoría "${nombre}" descartada.`);
            return;
        }

        const isPending = pill.classList.contains('cat-mgr-pill--pending-del');

        if (isPending) {
            // Deshacer
            pill.classList.remove('cat-mgr-pill--pending-del');
            pendingCatDeletes = pendingCatDeletes.filter(id => id !== catId);
            delBtn.innerHTML = '<i class="fa fa-xmark"></i>';
            delBtn.title = 'Marcar para eliminar';
            showToast(`"${catName}" restaurada.`);
        } else {
            // Verificar si hay imágenes que usan esta categoría
            const imagenesEnUso = Array.from(document.querySelectorAll(`#imgGrid .img-card[data-cat="${catName}"]`))
                .filter(card => !card.classList.contains('pending-card'));

            if (imagenesEnUso.length > 0) {
                const añosEnUso = [...new Set(imagenesEnUso.map(card => card.dataset.year))].sort().join(', ');
                showToast(`No se puede eliminar "${catName}" — está en uso en: ${añosEnUso}. Reasigna o elimina esas imágenes primero.`, 'error');
                return;
            }

            // Marcar para eliminar
            pill.classList.add('cat-mgr-pill--pending-del');
            pendingCatDeletes.push(catId);
            delBtn.innerHTML = '<i class="fa fa-rotate-left"></i>';
            delBtn.title = 'Deshacer';
            showToast(`"${catName}" marcada para eliminar. Guarda para confirmar.`, 'error');
        }

        updateGlobalSaveBtn();
    });

    function addCategory() {
        const input = document.getElementById('newCatInput');
        const val   = input?.value.trim();
        if (!val) { showToast('Escribe un nombre de categoría.', 'error'); return; }

        const manager = document.getElementById('catPillsManager');
        const exists = Array.from(manager?.querySelectorAll('.cat-mgr-pill__name') || [])
                        .some(el => el.textContent.toLowerCase() === val.toLowerCase());
        if (exists) { showToast('Esa categoría ya existe.', 'error'); return; }

        // Agregar píldora al manager como pendiente (sin guardar aún)
        const pill = document.createElement('div');
        pill.className = 'cat-mgr-pill cat-mgr-pill--pending-new';
        pill.dataset.cat = val;
        pill.dataset.id  = ''; // sin id hasta guardar
        pill.innerHTML = `
            <span class="cat-mgr-pill__name">${val}</span>
            <button class="cat-mgr-pill__del" type="button" title="Quitar">
                <i class="fa fa-xmark"></i>
            </button>`;
        manager?.appendChild(pill);

        // Agregar al filtro de imágenes
        const filter = document.getElementById('catFilter');
        const btn = document.createElement('button');
        btn.className = 'pill'; btn.dataset.cat = val; btn.type = 'button'; btn.textContent = val;
        filter?.appendChild(btn);

        // Agregar a las píldoras del modal
        const catPillsWrap = document.getElementById('catPillsWrap');
        const modalPill = document.createElement('button');
        modalPill.type = 'button';
        modalPill.className = 'cat-pill';
        modalPill.dataset.value = val;
        modalPill.textContent = val;
        catPillsWrap?.appendChild(modalPill);

        // Agregar a la lista de pendientes para crear
        pendingCatNews.push(val);

        if (input) input.value = '';
        updateGlobalSaveBtn();
        showToast(`Categoría "${val}" lista para guardar.`);
    }

    function initCatDragAndDrop() {
    const manager = document.getElementById('catPillsManager');
    if (!manager) return;

    let dragSrc = null;

    manager.addEventListener('dragstart', e => {
        const pill = e.target.closest('.cat-mgr-pill');
        if (!pill) return;
        dragSrc = pill;
        pill.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
    });

    manager.addEventListener('dragend', e => {
        const pill = e.target.closest('.cat-mgr-pill');
        if (pill) pill.classList.remove('dragging');
        manager.classList.remove('drag-over-active');
        dragSrc = null;
    });

    manager.addEventListener('dragover', e => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        const pill = e.target.closest('.cat-mgr-pill');
        if (!pill || pill === dragSrc) return;
        manager.classList.add('drag-over-active');

        const rect = pill.getBoundingClientRect();
        const mid  = rect.left + rect.width / 2;
        if (e.clientX < mid) {
            manager.insertBefore(dragSrc, pill);
        } else {
            manager.insertBefore(dragSrc, pill.nextSibling);
        }
    });

    manager.addEventListener('drop', e => {
        e.preventDefault();
        pendingCatOrder = true;
        updateGlobalSaveBtn();
        showToast('Orden cambiado. Guarda para confirmar.');
    });

    // Hacer las píldoras arrastrables
    function makeDraggable() {
        manager.querySelectorAll('.cat-mgr-pill').forEach(pill => {
            pill.setAttribute('draggable', 'true');
        });
    }

    makeDraggable();

    // Observer para nuevas píldoras que se agreguen dinámicamente
    new MutationObserver(makeDraggable).observe(manager, { childList: true });
}

    document.getElementById('btnAddCat')?.addEventListener('click', addCategory);
    document.getElementById('newCatInput')?.addEventListener('keydown', e => { if (e.key === 'Enter') addCategory(); });

    const modalBg     = document.getElementById('imgModalBg');
    const modalForm   = document.getElementById('imgModalForm');
    const modalTitle  = document.getElementById('imgModalTitle');
    const modalSub    = document.getElementById('imgModalSub');
    const methodField = document.getElementById('methodField');

    function openModal() {
        modalBg?.classList.add('open');
        setTimeout(() => {
            document.getElementById('imgModal')?.querySelector('input,textarea,select,button')?.focus();
        }, 240);
    }
    function closeModal() {
        modalBg?.classList.remove('open');
        resetUploadZone();
        modalForm?.reset();
        if (methodField) methodField.innerHTML = '';
        updateDateReadable('');
        document.getElementById('dpCalendar')?.remove();
    }

    document.getElementById('imgModalClose')?.addEventListener('click', closeModal);
    document.getElementById('imgModalCancel')?.addEventListener('click', closeModal);
    modalBg?.addEventListener('click', e => { if (e.target === modalBg) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && modalBg?.classList.contains('open')) closeModal(); });

    // ABRIR MODAL PARA AÑADIR
    document.getElementById('btnAddImage')?.addEventListener('click', () => {
        const y = currentYear();
        if (selectedYearHid) selectedYearHid.value = y;
        if (modalTitle) modalTitle.textContent = 'Añadir Imagen del Proyecto';
        if (modalSub)   modalSub.textContent   = `Nueva imagen para el año ${y}`;
        if (methodField) methodField.innerHTML = '';
        const submitLabel = document.getElementById('modalSubmitLabel');
        if (submitLabel) submitLabel.textContent = 'Continuar';
        const dateInput = document.getElementById('eventDateInput');
        if (dateInput) {
            dateInput.value = todayISO();
            updateDateReadable(dateInput.value);
        }
        
        editState = { isEditing: false, type: null, idOrIndex: null };
        const uploadText = document.querySelector('.upload-text');
        if(uploadText) uploadText.textContent = 'Haz clic o arrastra una imagen';

        const firstPill = document.querySelector('#catPillsWrap .cat-pill');
        document.querySelectorAll('#catPillsWrap .cat-pill').forEach(p => p.classList.remove('cat-pill--active'));
        if (firstPill) {
            firstPill.classList.add('cat-pill--active');
            const hidden = document.getElementById('catInput');
            if (hidden) hidden.value = firstPill.dataset.value;
        }

        openModal();
    });

    // ══════ LÓGICA UNIFICADA PARA ELIMINAR / DESHACER / EDITAR EN EL GRID ══════
    document.getElementById('imgGrid')?.addEventListener('click', e => {
        const targetBtn = e.target.closest('button');
        if (!targetBtn) return;

        // 1. MARCAR PARA ELIMINAR
        if (targetBtn.classList.contains('btn-del-img')) {
            if (targetBtn.classList.contains('btn-remove-pending')) {
                const idx = parseInt(targetBtn.dataset.index);
                pendingImages[idx] = null;
                targetBtn.closest('.img-card')?.remove();
                updateGlobalSaveBtn();
                const totalCards = document.getElementById('imgGrid')?.querySelectorAll('.img-card').length ?? 0;
                const addMore = document.getElementById('imgAddMore');
                if (addMore) addMore.style.display = totalCards < 9 ? 'flex' : 'none';
                return;
            }

            const id = targetBtn.dataset.id;
            const card = document.querySelector(`.img-card[data-id="${id}"]`);
            if (!card) return;

            card.style.opacity = '0.4';
            card.style.outline = '2px dashed #c0392b';
            card.style.transition = 'opacity 0.2s, outline 0.2s';

            targetBtn.innerHTML = '<i class="fa fa-rotate-left"></i> Deshacer';
            targetBtn.style.background = '';
            targetBtn.style.color = '';
            targetBtn.classList.remove('btn-del-img');
            targetBtn.classList.add('btn-undo-del');

            card.querySelector('.btn-edit-img').style.display = 'none';

            pendingDeletes.push(id);
            updateGlobalSaveBtn();
            showToast('Imagen marcada para eliminar. Da clic en Guardar arriba para confirmar.', 'error');
            return;
        }

        // 2. DESHACER ELIMINACIÓN
        if (targetBtn.classList.contains('btn-undo-del')) {
            const card = targetBtn.closest('.img-card');
            const id = card?.dataset.id;

            pendingDeletes = pendingDeletes.filter(d => d !== id);

            card.style.opacity = '1';
            card.style.outline = 'none';

            // Restaurar botón eliminar con ícono
            targetBtn.innerHTML = '<i class="fa fa-trash-can"></i>';
            targetBtn.style.background = '';
            targetBtn.style.color = '';
            targetBtn.classList.remove('btn-undo-del');
            targetBtn.classList.add('btn-del-img');

            // Mostrar botón editar de nuevo
            card.querySelector('.btn-edit-img').style.display = '';

            updateGlobalSaveBtn();
            showToast('Eliminación cancelada.', 'success');
            return;
        }

        // 3. EDITAR
        if (targetBtn.classList.contains('btn-edit-img')) {
            const card = targetBtn.closest('.img-card');
            const isPending = card.classList.contains('pending-card');

            editState.isEditing = true;
            editState.type = isPending ? 'pending' : 'saved';
            editState.idOrIndex = isPending ? card.dataset.pendingIndex : card.dataset.id;

            // CÓDIGO NUEVO (Ya trae el .trim() para limpiar los espacios)
            const title = card.querySelector('.img-title')?.textContent?.trim() || '';
            const desc = card.querySelector('.img-desc')?.textContent?.trim() || '';
            const cat = card.querySelector('.cat-badge')?.textContent || document.getElementById('catFilter')?.querySelector('.active')?.dataset.cat || 'todas';
            const dateISO = card.dataset.date || '';

            if (modalTitle) modalTitle.textContent = 'Editar Imagen';
            if (modalSub)   modalSub.textContent   = 'Modifica los datos sin necesidad de resubir la foto';
            const submitLabel = document.getElementById('modalSubmitLabel');
            if (submitLabel) submitLabel.textContent = 'Actualizar';

            document.getElementById('imgTituloInput').value = title;
            document.getElementById('imgDescInput').value = desc;
            
            const catInput = document.getElementById('catInput');
            if(catInput && cat !== 'todas') catInput.value = cat;

            // Marcar visualmente la pill correcta
            document.querySelectorAll('#catPillsWrap .cat-pill').forEach(p => {
                p.classList.toggle('cat-pill--active', p.dataset.value === cat);
            });

            const dateInput = document.getElementById('eventDateInput');
            if (dateInput && dateISO) {
                dateInput.value = dateISO;
                updateDateReadable(dateISO);
            }

            resetUploadZone();
            const imgSrc = card.querySelector('.img-thumb img')?.src;
            if (imgSrc) {
                showPreview(imgSrc);
                const uploadText = document.querySelector('.upload-text');
                if(uploadText) uploadText.textContent = 'Clic para cambiar la imagen (Opcional)';
            }

            openModal();
            return;
        }
    });

    // ══════ SUBMIT DEL MODAL (AÑADIR O EDITAR) ══════
    modalForm?.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!validateForm(this)) {
            showToast('Por favor completa los campos obligatorios.', 'error');
            return;
        }

        const file        = fileInput?.files?.[0];
        const titulo      = document.getElementById('imgTituloInput')?.value.trim();
        const description = document.getElementById('imgDescInput')?.value.trim();
        const category    = document.getElementById('catInput')?.value;
        const date        = document.getElementById('eventDateInput')?.value;
        const dateLabel   = document.getElementById('datePickerLabel')?.textContent;

        if (!editState.isEditing && !file) { 
            showToast('Selecciona una imagen.', 'error'); 
            return; 
        }
        if (!date) { showToast('Selecciona una fecha.', 'error'); return; }

        if (editState.isEditing) {
            const card = editState.type === 'pending' 
                ? document.querySelector(`.pending-card[data-pending-index="${editState.idOrIndex}"]`)
                : document.querySelector(`.img-card:not(.pending-card)[data-id="${editState.idOrIndex}"]`);

            if (card) {
                if (file) card.querySelector('.img-thumb img').src = URL.createObjectURL(file);
                const titleEl = card.querySelector('.img-title');
                if (titleEl) titleEl.textContent = titulo;
                card.querySelector('.img-desc').textContent = description;
                card.querySelector('.cat-badge').textContent = category;
                card.querySelector('.img-date').innerHTML = `<i class="fa fa-calendar-day"></i> ${dateLabel}`;
                card.dataset.cat = category;
                card.dataset.date = date; 
                
                if (editState.type === 'pending') {
                    const pImg = pendingImages[editState.idOrIndex];
                    if (file) pImg.file = file;
                    pImg.titulo = titulo;
                    pImg.description = description;
                    pImg.category = category;
                    pImg.date = date;
                    pImg.dateLabel = dateLabel;
                } else {
                    pendingUpdates.push({
                        id: editState.idOrIndex,
                        file: file || null, 
                        titulo: titulo,
                        description: description,
                        category: category,
                        date: date
                    });
                    card.style.outline = '2px solid #2d7d46';
                }
            }
            showToast('Cambios listos para guardar.');

        } else {
            const pending = { file, titulo, description, category, date, dateLabel };
            pendingImages.push(pending);

            const previewUrl = URL.createObjectURL(file);
            const card = document.createElement('div');
            card.className = 'img-card pending-card';
            card.dataset.year = currentYear();
            card.dataset.cat  = category;
            card.dataset.date = date;
            card.dataset.pendingIndex = pendingImages.length - 1;
            card.innerHTML = `
                <div class="img-thumb">
                    <img src="${previewUrl}" alt="${description}">
                    <span class="cat-badge">${category}</span>
                    <span class="pending-badge"><i class="fa fa-clock"></i> Pendiente</span>
                </div>
                <div class="img-body">
                    <p class="img-date"><i class="fa fa-calendar-day"></i> ${dateLabel}</p>
                    <p class="img-title" style="font-weight:600; font-size:13px; color:var(--text-heading); margin-bottom:4px;">${titulo}</p>
                    <p class="img-desc">${description}</p>
                    <div class="img-actions">
                        <button class="btn-edit-img" type="button">Editar</button>
                        <button class="btn-del-img btn-remove-pending" type="button" data-index="${pendingImages.length - 1}">
                            <i class="fa fa-xmark"></i> Quitar
                        </button>
                    </div>
                </div>`;
            document.getElementById('imgGrid')?.querySelector('.img-empty')?.remove();
            document.getElementById('imgGrid')?.appendChild(card);
            
            const totalCards = document.getElementById('imgGrid')?.querySelectorAll('.img-card').length ?? 0;
            const addMore = document.getElementById('imgAddMore');
            if (addMore) addMore.style.display = totalCards < 9 ? 'flex' : 'none';
            showToast('Imagen lista para guardar.');
        }

        updateGlobalSaveBtn();
        closeModal();
    });


    /* ════════════════════════════════════
       DATE PICKER CUSTOM
    ════════════════════════════════════ */
    (function initDatePicker() {
        const btn      = document.getElementById('datePickerBtn');
        const hiddenIn = document.getElementById('eventDateInput');
        if (!btn || !hiddenIn) return;

        let dpViewMonth = new Date().getMonth();

        const DIAS = ['Lu','Ma','Mi','Ju','Vi','Sa','Do'];

        function getActiveYear() {
            const num = document.getElementById('yearDisplayNum');
            return parseInt(num?.textContent?.trim() || new Date().getFullYear(), 10);
        }

        function todayYM() {
            const n = new Date();
            return n.getFullYear() * 12 + n.getMonth();
        }

        function renderGrid(direction = null) {
            const cal = document.getElementById('dpCalendar');
            if (!cal) return;

            const activeYear = getActiveYear();
            const now        = new Date();
            const todayStr   = todayISO();
            const tYM        = todayYM();
            const curYM      = activeYear * 12 + dpViewMonth;

            cal.querySelector('.dp-month-label').textContent = `${MESES[dpViewMonth]} ${activeYear}`;
            cal.querySelector('#dpBtnPrev').disabled = dpViewMonth <= 0;
            cal.querySelector('#dpBtnNext').disabled = (curYM + 1) > tYM;

            const grid = cal.querySelector('.dp-days');
            grid.innerHTML = '';

            if (direction) {
                grid.classList.remove('slide-left', 'slide-right');
                void grid.offsetWidth;
                grid.classList.add(direction === 'next' ? 'slide-left' : 'slide-right');
            }

            const firstDay    = new Date(activeYear, dpViewMonth, 1).getDay();
            const offset      = firstDay === 0 ? 6 : firstDay - 1;
            const daysInMonth = new Date(activeYear, dpViewMonth + 1, 0).getDate();
            const selectedISO = hiddenIn.value;

            for (let i = 0; i < 42; i++) {
                const d = i - offset + 1;
                const btn2 = document.createElement('button');
                btn2.type = 'button';
                btn2.className = 'dp-day';

                if (d < 1 || d > daysInMonth) {
                    btn2.disabled = true;
                    btn2.style.visibility = 'hidden';
                } else {
                    const mm     = String(dpViewMonth + 1).padStart(2, '0');
                    const dd     = String(d).padStart(2, '0');
                    const isoStr = `${activeYear}-${mm}-${dd}`;
                    btn2.textContent = d;

                    if (isoStr > todayStr) {
                        btn2.disabled = true;
                        btn2.style.visibility = 'hidden';
                    } else {
                        if (isoStr === selectedISO) btn2.classList.add('selected');
                        if (isoStr === todayStr)    btn2.classList.add('today');
                        btn2.addEventListener('click', e => {
                            e.stopPropagation();
                            hiddenIn.value = isoStr;
                            updateDateReadable(isoStr);
                            closeCalendar();
                        });
                    }
                }
                grid.appendChild(btn2);
            }
        }

        function createShell() {
            const cal = document.createElement('div');
            cal.className = 'date-picker-calendar';
            cal.id = 'dpCalendar';

            const nav = document.createElement('div');
            nav.className = 'dp-nav';

            const btnPrev = document.createElement('button');
            btnPrev.type = 'button'; btnPrev.className = 'dp-nav-btn'; btnPrev.id = 'dpBtnPrev';
            btnPrev.innerHTML = '<i class="fa fa-chevron-left"></i>';
            btnPrev.addEventListener('click', e => {
                e.stopPropagation();
                if (dpViewMonth > 0) { 
                    dpViewMonth--; 
                    renderGrid(); 
                }
            });

            const label = document.createElement('span');
            label.className = 'dp-month-label';

            const btnNext = document.createElement('button');
            btnNext.type = 'button'; btnNext.className = 'dp-nav-btn'; btnNext.id = 'dpBtnNext';
            btnNext.innerHTML = '<i class="fa fa-chevron-right"></i>';
            btnNext.addEventListener('click', e => {
                e.stopPropagation();
                const activeYear = getActiveYear();
                const nextYM     = activeYear * 12 + (dpViewMonth + 1);
                const tYM        = todayYM();
                if (dpViewMonth < 11 && nextYM <= tYM) { 
                    dpViewMonth++; 
                    renderGrid(); 
                }
            });

            nav.append(btnPrev, label, btnNext);

            const header = document.createElement('div');
            header.className = 'dp-days-header';
            DIAS.forEach(d => {
                const dn = document.createElement('div');
                dn.className = 'dp-day-name'; dn.textContent = d;
                header.appendChild(dn);
            });

            const grid = document.createElement('div');
            grid.className = 'dp-days';

            cal.append(nav, header, grid);
            return cal;
        }

        function openCalendar() {
            if (document.getElementById('dpCalendar')) { closeCalendar(); return; }

            const activeYear = getActiveYear();
            const now        = new Date();
            const tYM        = todayYM();

            if (hiddenIn.value) {
                const [savedY, m] = hiddenIn.value.split('-');
                const savedYM = parseInt(savedY, 10) * 12 + (parseInt(m, 10) - 1);
                dpViewMonth = parseInt(m, 10) - 1;
                if (savedYM > tYM || parseInt(savedY, 10) !== activeYear) {
                    dpViewMonth = Math.min(now.getMonth(), 11);
                    if (activeYear * 12 + dpViewMonth > tYM) {
                        dpViewMonth = tYM - activeYear * 12;
                    }
                }
            } else {
                const maxMonth = tYM - activeYear * 12;
                dpViewMonth = Math.max(0, Math.min(maxMonth, 11));
            }

            const cal    = createShell();
            const parent = btn.closest('.date-picker-group') || btn.parentElement;
            parent.style.position = 'relative';
            parent.appendChild(cal);
            renderGrid();

            if (window.innerWidth <= 680) {
                const overlay = document.createElement('div');
                overlay.id = 'dpOverlay';
                overlay.style.cssText = `
                    position: fixed; inset: 0;
                    background: rgba(0,0,0,0.5);
                    backdrop-filter: blur(4px);
                    -webkit-backdrop-filter: blur(4px);
                    z-index: 9998;
                    animation: fadeIn 0.2s ease;
                `;
                overlay.addEventListener('click', closeCalendar);
                document.body.appendChild(overlay);
                document.body.appendChild(cal);
            }

            requestAnimationFrame(() => {
                if (window.innerWidth > 680) {
                    cal.style.left   = 'auto';
                    cal.style.right  = '0';
                    cal.style.top    = 'auto';
                    cal.style.bottom = 'calc(100% + 6px)'; // ← siempre arriba
                }
            });
        }

        function closeCalendar() {
            document.getElementById('dpCalendar')?.remove();
            document.getElementById('dpOverlay')?.remove();
            const modal = document.getElementById('imgModal');
            if (modal) modal.style.filter = '';
        }

        btn.addEventListener('click', e => { e.stopPropagation(); openCalendar(); });

        document.addEventListener('click', e => {
            const cal = document.getElementById('dpCalendar');
            if (!cal) return;
            if (!cal.contains(e.target) && !btn.contains(e.target)) closeCalendar();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeCalendar();
        });
    })();

    const uploadZone    = document.getElementById('uploadZone');
    const fileInput     = document.getElementById('imgFile');
    const uploadInner   = document.getElementById('uploadInner');
    const uploadPreview = document.getElementById('uploadPreview');

    function showPreview(src) {
        uploadZone?.classList.add('has-preview');
        if (uploadInner) uploadInner.style.display = 'none';
        if (uploadPreview) { uploadPreview.src = src; uploadPreview.style.display = 'block'; }
    }
    function resetUploadZone() {
        uploadZone?.classList.remove('has-preview');
        if (uploadInner) uploadInner.style.display = '';
        if (uploadPreview) { uploadPreview.src = ''; uploadPreview.style.display = 'none'; }
        if (fileInput) fileInput.value = '';
    }

    uploadZone?.addEventListener('click', () => fileInput?.click());
    uploadZone?.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') fileInput?.click(); });
    uploadZone?.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
    uploadZone?.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
    uploadZone?.addEventListener('drop', e => {
        e.preventDefault(); uploadZone.classList.remove('dragover');
        const file = e.dataTransfer?.files?.[0];
        if (file && file.type.startsWith('image/')) handleFile(file);
    });
    fileInput?.addEventListener('change', () => { if (fileInput.files?.[0]) handleFile(fileInput.files[0]); });
    document.getElementById('btnChangeImg')?.addEventListener('click', e => {
        e.stopPropagation(); resetUploadZone(); fileInput?.click();
    });

    function handleFile(file) {
        if (file.size > 5 * 1024 * 1024) { showToast('La imagen supera 5 MB.', 'error'); return; }
        const reader = new FileReader();
        reader.onload = ev => showPreview(ev.target.result);
        reader.readAsDataURL(file);
    }

    const initialYear = yearDisplayNum?.textContent?.trim();
    if (initialYear) {
        const idx = years.indexOf(initialYear);
        if (idx !== -1) currentIdx = idx;
    }

    const savedYear = sessionStorage.getItem('activeYear');
    if (savedYear) {
        sessionStorage.removeItem('activeYear');
        const idx = years.indexOf(savedYear);
        if (idx !== -1) currentIdx = idx;
    }

    renderYear();
    setTimeout(updateGlobalSaveBtn, 0);

    const savedTab = sessionStorage.getItem('activeTab');
    if (savedTab) {
        sessionStorage.removeItem('activeTab');
        // Activar tab sin disparar scroll
        document.querySelectorAll('.content-tab').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => {
            p.style.display = 'none';
            p.classList.remove('active');
        });
        const tabBtn = document.querySelector(`.content-tab[data-tab="${savedTab}"]`);
        const tabPanel = document.getElementById(
            savedTab === 'images' ? 'tabImages' : savedTab === 'categories' ? 'tabCategories' : 'tabSettings'
        );
        if (tabBtn) tabBtn.classList.add('active');
        if (tabPanel) { tabPanel.style.display = ''; tabPanel.classList.add('active'); }
        window.scrollTo(0, 0);
        setTimeout(() => showToast('Guardado correctamente.'), 600);
    }

    if (!document.getElementById('edit-page-js-styles')) {
        const style = document.createElement('style');
        style.id = 'edit-page-js-styles';
        style.textContent = `
            .edit-toast { position:fixed; bottom:26px; right:26px; display:flex; align-items:center; gap:10px; padding:12px 18px; border-radius:11px; font-size:13px; font-weight:500; color:#fff; box-shadow:0 8px 26px rgba(0,0,0,0.18); opacity:0; transform:translateY(12px); transition:opacity 0.28s ease, transform 0.28s ease; z-index:9999; pointer-events:none; max-width:320px; }
            .edit-toast--show  { opacity:1; transform:translateY(0); }
            .edit-toast--success { background:#2d7d46; }
            .edit-toast--error   { background:#c0392b; }
            .edit-toast__icon  { font-size:15px; flex-shrink:0; }
            .field--error { border-color:#c0392b !important; box-shadow:0 0 0 3px rgba(192,57,43,0.14) !important; }
            .field-error-msg { margin-top:4px; font-size:12px; color:#c0392b; font-weight:500; }
            .upload-zone.dragover { border-color:var(--accent) !important; background:var(--accent-light) !important; }
            .dp-day.future { opacity:0.22; cursor:not-allowed; pointer-events:none; }
            @media(max-width:480px) { .edit-toast { z-index:1099 !important; } }
        `;
        document.head.appendChild(style);
    }

    document.getElementById('btnAddMore')?.addEventListener('click', () => {
        document.getElementById('btnAddImage')?.click();
    });

    (function() {
        const wrap = document.getElementById('catPillsWrap');
        if (!wrap) return;

        // Inicializar catInput con la primera píldora al cargar
        const firstPill = wrap.querySelector('.cat-pill');
        const hidden = document.getElementById('catInput');
        if (firstPill && hidden) hidden.value = firstPill.dataset.value;

        wrap.addEventListener('click', e => {
            const pill = e.target.closest('.cat-pill');
            if (!pill) return;
            wrap.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('cat-pill--active'));
            pill.classList.add('cat-pill--active');
            if (hidden) hidden.value = pill.dataset.value;
        });
    })();

    function initDetailsPanel() {
        const panel   = document.getElementById('detailsPanel');
        const bg      = document.getElementById('detailsPanelBg');
        const closeBtn = document.getElementById('detailsPanelClose');

        function openPanel(card) {
            const img   = card.querySelector('.img-thumb img')?.src ?? '';
            const title = card.querySelector('.img-title')?.textContent?.trim() ?? '—';
            const desc  = card.querySelector('.img-desc')?.textContent?.trim() ?? '—';
            const cat   = card.querySelector('.cat-badge')?.textContent?.trim() ?? '—';
            const date  = card.querySelector('.img-date')?.textContent?.trim() ?? '—';
            const id    = card.dataset.id ?? '—';

            document.getElementById('detailsPanelHeroBg').style.backgroundImage = `url('${img}')`;
            document.getElementById('detailsPanelTitle').textContent = title;
            document.getElementById('detailsPanelDesc').textContent  = desc;
            document.getElementById('detailsPanelCat').textContent   = cat;
            document.getElementById('detailsPanelDate').textContent  = date;
            document.getElementById('detailsPanelId').textContent    = id;

            panel.dataset.cardId = card.dataset.id ?? '';
            panel.dataset.cardPendingIndex = card.dataset.pendingIndex ?? '';
            panel.dataset.isPending = card.classList.contains('pending-card') ? '1' : '0';

            panel?.classList.add('open');
            bg?.classList.add('open');

            // Mover toast si existe
            const toast = document.querySelector('.edit-toast');
            if (toast && window.innerWidth > 480) toast.style.right = '360px';

            // Ocultar sidebar en móvil cuando el panel abre
            if (window.innerWidth <= 768) {
                document.querySelector('.sidebar')?.style.setProperty('display', 'none');
            }
        }

        function closePanel() {
            panel?.classList.remove('open');
            bg?.classList.remove('open');

            const toast = document.querySelector('.edit-toast');
            if (toast) toast.style.right = '26px';

            // Restaurar sidebar al cerrar
            if (window.innerWidth <= 768) {
                document.querySelector('.sidebar')?.style.setProperty('display', '');
            }
        }

        closeBtn?.addEventListener('click', closePanel);
        // Botón Editar del panel
        document.getElementById('detailsPanelEdit')?.addEventListener('click', () => {
            const id = panel.dataset.cardId;
            const isPending = panel.dataset.isPending === '1';
            closePanel();
            setTimeout(() => {
                const btn = isPending
                    ? document.querySelector(`.pending-card[data-pending-index="${panel.dataset.cardPendingIndex}"] .btn-edit-img`)
                    : document.querySelector(`.img-card[data-id="${id}"] .btn-edit-img`);
                btn?.click();
            }, 300);
        });

        // Botón Eliminar del panel
        document.getElementById('detailsPanelDel')?.addEventListener('click', () => {
            const id = panel.dataset.cardId;
            closePanel();
            setTimeout(() => {
                const btn = document.querySelector(`.img-card[data-id="${id}"] .btn-del-img`);
                btn?.click();
            }, 300);
        });
        bg?.addEventListener('click', closePanel);
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closePanel();
        });

        document.getElementById('imgGrid')?.addEventListener('click', e => {
            const btn = e.target.closest('.overlay-details-btn');
            if (!btn) return;
            const card = btn.closest('.img-card');
            if (card) openPanel(card);
        });
    }

    initDetailsPanel();
    initCatDragAndDrop();

})();   