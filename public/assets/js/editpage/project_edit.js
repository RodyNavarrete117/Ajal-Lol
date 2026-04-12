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
    const yearSelect     = document.getElementById('newYearSelect');
    const btnConfirmYear = document.getElementById('btnConfirmYear');
    const btnCancelYear  = document.getElementById('btnCancelYear');

    function buildAvailableYears() {
        const cur = new Date().getFullYear();
        const all = [];
        for (let y = cur; y >= 2000; y--) {
            if (!years.includes(String(y))) all.push(String(y));
        }
        return all;
    }

    function populateYearSelect() {
        if (!yearSelect) return;
        yearSelect.innerHTML = '';
        const available = buildAvailableYears();
        if (available.length === 0) {
            const opt = document.createElement('option');
            opt.value = ''; opt.textContent = 'Todos los años ya están registrados';
            opt.disabled = true;
            yearSelect.appendChild(opt);
        } else {
            available.forEach(y => {
                const opt = document.createElement('option');
                opt.value = y; opt.textContent = y;
                yearSelect.appendChild(opt);
            });
        }
    }

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
            yearSelect?.focus();
            closeDropdown();
            setAddYearIcon(true);
        }
    });

    function hideAddYearForm() {
        if (addYearForm) addYearForm.style.display = 'none';
        setAddYearIcon(false);
    }
    btnCancelYear?.addEventListener('click', hideAddYearForm);
    btnConfirmYear?.addEventListener('click', confirmAddYear);
    yearSelect?.addEventListener('keydown', e => {
        if (e.key === 'Enter')  confirmAddYear();
        if (e.key === 'Escape') hideAddYearForm();
    });

    function confirmAddYear() {
        const val = yearSelect?.value?.trim();
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
        if (!hasImages) {
            btnGlobalSave.disabled = true;
            btnGlobalSave.title    = 'Agrega al menos una imagen antes de guardar';
            if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Guardar';
            if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-floppy-disk';
            return;
        }
        btnGlobalSave.disabled = !hasSubChange;
        btnGlobalSave.title    = '';
        if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = hasSubChange ? 'Guardar cambios' : 'Guardar';
        if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-floppy-disk';
    }

btnGlobalSave?.addEventListener('click', async function () {
    console.log('Guardar clicked');
    const toUpload = pendingImages.filter(Boolean);
    console.log('toUpload:', toUpload.length);
    const y     = currentYear();
    const sub   = subtitleInput?.value.trim() ?? '';
    const token = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    console.log('token:', token);
    console.log('year:', y);

    if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Guardando...';
    if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-spinner fa-spin';
    btnGlobalSave.disabled = true;

    for (const item of toUpload) {
        const fd = new FormData();
        fd.append('_token',      token);
        fd.append('year',        y);
        fd.append('image',       item.file);
        fd.append('description', item.description);
        fd.append('category',    item.category);
        fd.append('event_date',  item.date);

        console.log('Enviando:', { year: y, description: item.description, category: item.category, date: item.date });

        try {
            const res = await fetch('/admin/pages/projects/image', {
                method: 'POST', body: fd
            });
            const data = await res.json();
            console.log('Respuesta POST:', res.status, data);
            if (!res.ok) throw new Error(data.error || 'Error');
        } catch(err) {
            console.error('Error imagen:', err);
            showToast('Error: ' + err.message, 'error');
            // NO recargar si hay error
            if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Guardar';
            if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-floppy-disk';
            btnGlobalSave.disabled = false;
            return; // detener aquí
        }
    }

    // Guardar subtítulo
    try {
        const res2 = await fetch('/admin/pages/projects/year-update', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify({ year: y, subtitulo: sub, visible: visibilities[y] ?? true })
        });
        const data2 = await res2.json();
        console.log('Respuesta PUT:', res2.status, data2);
    } catch(err) {
        console.error('Error year-update:', err);
    }

    pendingImages = [];
    showToast(`Año ${y} guardado correctamente.`);
    setTimeout(() => window.location.reload(), 1200);
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

    document.getElementById('catList')?.addEventListener('click', e => {
        const delBtn = e.target.closest('.cat-item__del');
        if (!delBtn) return;
        const item    = delBtn.closest('.cat-item');
        const catName = item?.dataset.cat;
        const catId   = item?.dataset.id;
        if (!catName) return;

        const token = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        fetch(`/admin/pages/projects/category/${catId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
        })
        .then(res => { if (!res.ok) throw new Error(); return res.json(); })
        .then(() => {
            item.style.transition = 'opacity 0.2s, transform 0.2s';
            item.style.opacity = '0'; item.style.transform = 'translateX(8px)';
            setTimeout(() => {
                item.remove();
                document.querySelector(`#catFilter .pill[data-cat="${catName}"]`)?.remove();
                const sel = document.getElementById('catInput');
                if (sel) Array.from(sel.options).forEach(o => { if (o.value === catName) o.remove(); });
            }, 200);
            showToast(`Categoría "${catName}" eliminada.`);
        })
        .catch(() => showToast('Error al eliminar la categoría.', 'error'));
    });

    document.getElementById('btnAddCat')?.addEventListener('click', addCategory);
    document.getElementById('newCatInput')?.addEventListener('keydown', e => { if (e.key === 'Enter') addCategory(); });

    function addCategory() {
        const input = document.getElementById('newCatInput');
        const val   = input?.value.trim();
        if (!val) { showToast('Escribe un nombre de categoría.', 'error'); return; }

        const catList = document.getElementById('catList');
        const exists = Array.from(catList?.querySelectorAll('.cat-item__name') || [])
                        .some(el => el.textContent.toLowerCase() === val.toLowerCase());
        if (exists) { showToast('Esa categoría ya existe.', 'error'); return; }

        const token = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        fetch('/admin/pages/projects/category', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify({ nombre: val })
        })
        .then(res => { if (!res.ok) throw new Error(); return res.json(); })
        .then(data => {
            const item = document.createElement('div');
            item.className = 'cat-item'; 
            item.dataset.cat = val;
            item.dataset.id  = data.id;
            item.innerHTML = `
                <span class="cat-item__dot"></span>
                <span class="cat-item__name">${val}</span>
                <button class="cat-item__del" type="button" title="Eliminar categoría">
                    <i class="fa fa-xmark"></i>
                </button>`;
            catList?.appendChild(item);

            const filter = document.getElementById('catFilter');
            const btn = document.createElement('button');
            btn.className = 'pill'; btn.dataset.cat = val; btn.type = 'button'; btn.textContent = val;
            filter?.appendChild(btn);

            const sel = document.getElementById('catInput');
            const opt = document.createElement('option');
            opt.value = val; opt.textContent = val;
            sel?.appendChild(opt);

            if (input) input.value = '';
            showToast(`Categoría "${val}" agregada.`);
        })
        .catch(() => showToast('Error al guardar la categoría.', 'error'));
    }

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
        openModal();
    });

    document.getElementById('imgGrid')?.addEventListener('click', e => {
        const editBtn = e.target.closest('.btn-edit-img');
        if (!editBtn) return;
        const id   = editBtn.dataset.id;
        const card = document.querySelector(`.img-card[data-id="${id}"]`);
        if (!card) return;
        if (modalTitle) modalTitle.textContent = `Editar Imagen — ID: ${id}`;
        if (modalSub)   modalSub.textContent   = 'Modifica los datos de esta imagen';
        if (methodField) methodField.innerHTML = `<input type="hidden" name="_method" value="PUT">`;
        const submitLabel = document.getElementById('modalSubmitLabel');
        if (submitLabel) submitLabel.textContent = 'Guardar cambios';
        const updateUrl = editBtn.dataset.updateUrl;
        if (updateUrl && modalForm) modalForm.action = updateUrl;
        const desc = card.querySelector('.img-desc')?.textContent?.trim() ?? '';
        const descInput = document.getElementById('imgDescInput');
        if (descInput) descInput.value = desc === 'Sin descripción.' ? '' : desc;
        const dateInput = document.getElementById('eventDateInput');
        if (dateInput) {
            dateInput.value = card.dataset.date || todayISO();
            updateDateReadable(dateInput.value);
        }
        const cat    = card.dataset.cat;
        const catSel = document.getElementById('catInput');
        if (catSel) {
            for (let i = 0; i < catSel.options.length; i++) {
                if (catSel.options[i].value === cat) { catSel.selectedIndex = i; break; }
            }
        }
        const imgEl = card.querySelector('.img-thumb img');
        if (imgEl) showPreview(imgEl.src); else resetUploadZone();
        openModal();
    });

    /* ════════════════════════════════════
       DATE PICKER CUSTOM
       — muestra "10 de Abril" sin año
       — restringe al año activo
       — no permite fechas futuras
       — < > usan stopPropagation para no cerrar el calendario
       — se abre arriba si no cabe abajo
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

        // Animación de dirección
        if (direction) {
            grid.classList.remove('slide-left', 'slide-right');
            void grid.offsetWidth; // reflow para reiniciar animación
            grid.classList.add(direction === 'next' ? 'slide-left' : 'slide-right');
        }

        const firstDay    = new Date(activeYear, dpViewMonth, 1).getDay();
        const offset      = firstDay === 0 ? 6 : firstDay - 1;
        const daysInMonth = new Date(activeYear, dpViewMonth + 1, 0).getDate();
        const selectedISO = hiddenIn.value;
        const todayYear   = now.getFullYear();
        const todayMonth  = now.getMonth();
        const todayDay    = now.getDate();

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

        // Nav
        const nav = document.createElement('div');
        nav.className = 'dp-nav';

        const btnPrev = document.createElement('button');
        btnPrev.type = 'button'; btnPrev.className = 'dp-nav-btn'; btnPrev.id = 'dpBtnPrev';
        btnPrev.innerHTML = '<i class="fa fa-chevron-left"></i>';
        btnPrev.addEventListener('click', e => {
            e.stopPropagation();
            const activeYear = getActiveYear();
            // No ir antes de enero (mes 0) ni antes del inicio del año activo
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
            // No pasar de diciembre (mes 11) NI pasar del mes actual de hoy
            if (dpViewMonth < 11 && nextYM <= tYM) { 
                dpViewMonth++; 
                renderGrid(); 
            }
        });

        nav.append(btnPrev, label, btnNext);

        // Header días
        const header = document.createElement('div');
        header.className = 'dp-days-header';
        DIAS.forEach(d => {
            const dn = document.createElement('div');
            dn.className = 'dp-day-name'; dn.textContent = d;
            header.appendChild(dn);
        });

        // Grid vacío
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

        // Overlay + blur en móvil
        // Overlay + blur en móvil
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
            
            // Mover el calendario al body para que quede ENCIMA del overlay
            document.body.appendChild(cal);
        }

        requestAnimationFrame(() => {
            if (window.innerWidth > 680) {
                cal.style.left  = 'auto';
                cal.style.right = '0';
                const rect = cal.getBoundingClientRect();
                if (window.innerHeight - rect.bottom < 0) {
                    cal.style.top    = 'auto';
                    cal.style.bottom = 'calc(100% + 6px)';
                }
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

    function setFeatured() {}

    // Array de imágenes pendientes
    let pendingImages = [];

    modalForm?.addEventListener('submit', function (e) {
        e.preventDefault(); // siempre prevenir el submit nativo

        if (!validateForm(this)) {
            showToast('Por favor completa los campos obligatorios.', 'error');
            return;
        }

        const file        = fileInput?.files?.[0];
        const description = document.getElementById('imgDescInput')?.value.trim();
        const category    = document.getElementById('catInput')?.value;
        const date        = document.getElementById('eventDateInput')?.value;
        const dateLabel   = document.getElementById('datePickerLabel')?.textContent;

        if (!file) { showToast('Selecciona una imagen.', 'error'); return; }
        if (!date) { showToast('Selecciona una fecha.', 'error'); return; }

        // Guardar en pendientes
        const pending = { file, description, category, date, dateLabel };
        pendingImages.push(pending);

        // Crear tarjeta visual en el grid
        const previewUrl = URL.createObjectURL(file);
        const card = document.createElement('div');
        card.className = 'img-card pending-card';
        card.dataset.year = currentYear();
        card.dataset.cat  = category;
        card.dataset.pendingIndex = pendingImages.length - 1;
        card.innerHTML = `
            <div class="img-thumb">
                <img src="${previewUrl}" alt="${description}">
                <span class="cat-badge">${category}</span>
                <span class="pending-badge">
                    <i class="fa fa-clock"></i> Pendiente
                </span>
            </div>
            <div class="img-body">
                <p class="img-date"><i class="fa fa-calendar-day"></i> ${dateLabel}</p>
                <p class="img-desc">${description}</p>
                <div class="img-actions">
                    <button class="btn-del-img btn-remove-pending" type="button"
                            data-index="${pendingImages.length - 1}">
                        <i class="fa fa-xmark"></i> Quitar
                    </button>
                </div>
            </div>`;

        document.getElementById('imgGrid')?.querySelector('.img-empty')?.remove();
        document.getElementById('imgGrid')?.appendChild(card);

        // Activar guardar
        if (btnGlobalSave) btnGlobalSave.disabled = false;
        if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Guardar';

        // Mostrar botón agregar más si hay menos de 9
        const gridEl = document.getElementById('imgGrid');
        const addMore = document.getElementById('imgAddMore');
        const totalCards = gridEl?.querySelectorAll('.img-card').length ?? 0;
        if (addMore) addMore.style.display = totalCards < 9 ? 'flex' : 'none';

        closeModal();
        showToast('Imagen lista para guardar.');
    });

    // Quitar pendiente del grid
    document.getElementById('imgGrid')?.addEventListener('click', e => {
        const btn = e.target.closest('.btn-remove-pending');
        if (!btn) return;
        const idx = parseInt(btn.dataset.index);
        pendingImages[idx] = null;
        btn.closest('.img-card')?.remove();
        const remaining = pendingImages.filter(Boolean).length;
        if (remaining === 0 && btnGlobalSave) {
            btnGlobalSave.disabled = true;
        }
        const totalCards2 = document.getElementById('imgGrid')?.querySelectorAll('.img-card').length ?? 0;
        const addMore2 = document.getElementById('imgAddMore');
        if (addMore2) addMore2.style.display = totalCards2 < 9 ? 'flex' : 'none';
    });

    document.getElementById('imgGrid')?.addEventListener('click', e => {
        const delBtn = e.target.closest('.btn-del-img');
        if (!delBtn) return;
        const id  = delBtn.dataset.id;
        const url = delBtn.dataset.url;
        if (!confirm('¿Eliminar esta imagen? Esta acción no se puede deshacer.')) return;
        const card = document.querySelector(`.img-card[data-id="${id}"]`);
        const activeCat = document.querySelector('#catFilter .pill.active')?.dataset.cat || 'todas';
        const removeCard = () => {
            if (card) {
                card.style.transition = 'opacity 0.22s, transform 0.22s';
                card.style.opacity = '0'; card.style.transform = 'scale(0.95)';
                setTimeout(() => { card.remove(); filterImagesByCat(activeCat); }, 230);
            }
            showToast('Imagen eliminada.');
            updateGlobalSaveBtn?.();
        };
        if (!url || url === '#') { removeCard(); return; }
        const token = document.querySelector('meta[name="csrf-token"]')?.content
                   || document.querySelector('input[name="_token"]')?.value || '';
        fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' } })
            .then(res => { if (!res.ok) throw new Error(); return res.json(); })
            .then(removeCard)
            .catch(() => showToast('No se pudo eliminar la imagen.', 'error'));
    });

    const initialYear = yearDisplayNum?.textContent?.trim();
    if (initialYear) {
        const idx = years.indexOf(initialYear);
        if (idx !== -1) currentIdx = idx;
    }
    renderYear();
    setTimeout(updateGlobalSaveBtn, 0);

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
        `;
        document.head.appendChild(style);
    }

        document.getElementById('btnAddMore')?.addEventListener('click', () => {
        document.getElementById('btnAddImage')?.click();
    });

})();