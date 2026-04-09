/* ==================== projects_edit — JS ==================== */
(function () {
    'use strict';

    /* ════════════════════════════════════
       TOAST
    ════════════════════════════════════ */
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

    /* ════════════════════════════════════
       VALIDACIÓN
    ════════════════════════════════════ */
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

    /* ════════════════════════════════════
       HELPERS
    ════════════════════════════════════ */
    function todayISO() {
        return new Date().toISOString().split('T')[0];
    }

    const MESES = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                   'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    function toReadableDate(isoStr) {
        if (!isoStr) return '';
        const [, m, d] = isoStr.split('-');
        return `${parseInt(d, 10)} de ${MESES[parseInt(m, 10) - 1]}`;
    }

    function updateDateReadable(val) {
        const el = document.getElementById('dateReadable');
        if (el) el.textContent = val ? toReadableDate(val) : '';
    }

    /* ════════════════════════════════════
       ESTADO GLOBAL
    ════════════════════════════════════ */
    // Lista de años ordenados de más reciente a más antiguo
    let years = Array.from(
        document.querySelectorAll('.year-dropdown-item')
    ).map(el => el.dataset.year);

    // Índice del año actualmente mostrado
    let currentIdx = 0;

    // Visibilidades: { '2023': true, '2024': false, ... }
    const visToggle  = document.getElementById('visToggleBtn');
    let visibilities = visToggle
        ? JSON.parse(visToggle.dataset.visibilities || '{}')
        : {};

    // Subtítulos: { '2023': 'Texto...', ... }
    const subtitleInput = document.getElementById('subtituloInput');
    let subtitles = subtitleInput
        ? JSON.parse(subtitleInput.dataset.subtitles || '{}')
        : {};

    function currentYear() { return years[currentIdx]; }

    /* ════════════════════════════════════
       YEAR SELECTOR — RENDER
    ════════════════════════════════════ */
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

        // Display central
        if (yearDisplayNum) yearDisplayNum.textContent = y;
        if (yearLabelBadge) yearLabelBadge.textContent = y;
        if (formYearInput)  formYearInput.value         = y;
        if (btnDelYear)     btnDelYear.dataset.year     = y;
        if (selectedYearHid) selectedYearHid.value      = y;
        // Badges del tab de configuración
        const sb1 = document.getElementById('settingsYearBadge');
        const sb2 = document.getElementById('settingsYearBadgeDanger');
        if (sb1) sb1.textContent = y;
        if (sb2) sb2.textContent = y;

        // Botones prev/next
        if (btnPrev) btnPrev.disabled = currentIdx >= years.length - 1;
        if (btnNext) btnNext.disabled = currentIdx <= 0;

        // Subtítulo
        if (subtitleInput) subtitleInput.value = subtitles[y] ?? '';

        // Visibilidad
        updateVisUI(y);

        // Dropdown — marcar activo
        document.querySelectorAll('.year-dropdown-item').forEach(item => {
            const active = item.dataset.year === y;
            item.classList.toggle('active', active);
            item.setAttribute('aria-selected', String(active));
        });

        // Grid de imágenes — mostrar solo las del año activo
        filterImagesByYear(y);

        // Filtro pills — resetear a "todas"
        document.querySelectorAll('#catFilter .pill').forEach(p => p.classList.remove('active'));
        document.querySelector('#catFilter .pill[data-cat="todas"]')?.classList.add('active');

        // Actualizar botón global
        updateGlobalSaveBtn?.();
    }

    /* ════════════════════════════════════
       YEAR SELECTOR — NAVEGACIÓN
    ════════════════════════════════════ */
    // El array está ordenado de reciente (idx 0) a antiguo (idx n-1)
    // "Siguiente" (más reciente) = idx disminuye
    // "Anterior" (más antiguo) = idx aumenta

    btnNext?.addEventListener('click', () => {
        if (currentIdx > 0) { currentIdx--; renderYear(); closeDropdown(); }
    });
    btnPrev?.addEventListener('click', () => {
        if (currentIdx < years.length - 1) { currentIdx++; renderYear(); closeDropdown(); }
    });

    /* ════════════════════════════════════
       YEAR DROPDOWN
    ════════════════════════════════════ */
    const yearDisplayBtn  = document.getElementById('yearDisplayBtn');
    const yearDropdown    = document.getElementById('yearDropdown');

    /* Mover el dropdown al <body> para que position:fixed
       no sea afectado por transforms de ancestros */
    if (yearDropdown) {
        document.body.appendChild(yearDropdown);
        yearDropdown.style.display = 'none';
    }

    function positionDropdown() {
        if (!yearDropdown || !yearDisplayBtn) return;
        const rect = yearDisplayBtn.getBoundingClientRect();
        // El dropdown tiene el mismo ancho que el botón central del año
        // con un mínimo de 120px para que quepan los números
        const ddW = Math.max(rect.width, 120);
        // Alinear al centro del botón
        let left = rect.left + (rect.width / 2) - (ddW / 2);
        left = Math.max(8, Math.min(left, window.innerWidth - ddW - 8));
        yearDropdown.style.top   = (rect.bottom + 6) + 'px';
        yearDropdown.style.left  = left + 'px';
        yearDropdown.style.width = ddW + 'px';
    }

    function openDropdown() {
        if (!yearDropdown) return;
        // Mostrar invisible primero para medir ancho real
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
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeDropdown();
    });
    window.addEventListener('scroll', () => {
        if (yearDropdown?.style.display !== 'none') positionDropdown();
    }, { passive: true });
    window.addEventListener('resize', () => {
        if (yearDropdown?.style.display !== 'none') positionDropdown();
    }, { passive: true });

    /* ════════════════════════════════════
       AGREGAR NUEVO AÑO
    ════════════════════════════════════ */
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
        if (isOpen) {
            hideAddYearForm();
        } else {
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
        if (!val) {
            showToast('Selecciona un año.', 'error'); return;
        }
        if (years.includes(val)) {
            showToast('Ese año ya existe.', 'error'); return;
        }
        // Agregar al array en orden descendente
        years.push(val);
        years.sort((a, b) => Number(b) - Number(a));
        currentIdx = years.indexOf(val);

        // Visibilidad por defecto: oculto si ya hay 5 visibles
        const visCount = Object.values(visibilities).filter(Boolean).length;
        visibilities[val] = visCount < 5;
        subtitles[val] = '';

        // Añadir al dropdown y cerrar
        addYearToDropdown(val);
        hideAddYearForm();
        renderYear();
        showToast(`Año ${val} agregado.`);
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

    /* ════════════════════════════════════
       ELIMINAR AÑO
    ════════════════════════════════════ */
    /* ── Modal de confirmación para eliminar año ── */
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
    });

    // El botón de eliminar ahora abre el modal
    document.addEventListener('click', e => {
        const delBtn = e.target.closest('#btnDelYear');
        if (!delBtn) return;
        const y = currentYear();
        if (years.length <= 1) { showToast('Debe existir al menos un año.', 'error'); return; }
        openConfirmDel(y);
    });

    /* ════════════════════════════════════
       VISIBILIDAD DEL AÑO
    ════════════════════════════════════ */
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

        visibilities[y] = !isOn;
        updateVisUI(y);
        updateVisCounter();
        updateDropdownVisItem(y);

        // Persistir en backend (fetch)
        // fetch('/admin/projects/year-visibility', { method:'POST', ... })
        showToast(!isOn ? `Año ${y} activado en el sitio.` : `Año ${y} ocultado del sitio.`);
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
        const total = years.length;
        if (visCounterTxt) visCounterTxt.textContent = `${count} / 5 visibles`;

        // Badge límite
        const existing = visCounter?.querySelector('.vis-limit-badge');
        if (count >= 5) {
            if (!existing) {
                const badge = document.createElement('span');
                badge.className = 'vis-limit-badge'; badge.textContent = 'Límite';
                visCounter?.appendChild(badge);
            }
        } else {
            existing?.remove();
        }
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

    /* ════════════════════════════════════
       FILTRAR IMÁGENES POR AÑO
    ════════════════════════════════════ */
    /* Retorna las cards visibles del año activo */
    function cardsOfYear(year) {
        return Array.from(document.querySelectorAll(`#imgGrid .img-card[data-year="${year}"]`));
    }

    /* Actualiza las pills del filtro mostrando solo las categorías
       que realmente tienen imágenes en el año activo */
    function refreshFilterPills(year) {
        const cards    = cardsOfYear(year);
        const toolbar  = document.getElementById('imgToolbar');
        const catFilter = document.getElementById('catFilter');
        if (!catFilter || !toolbar) return;

        if (cards.length === 0) {
            // Sin imágenes: ocultar toolbar de filtros
            toolbar.style.display = 'none';
            return;
        }

        // Con imágenes: mostrar toolbar y activar solo pills con contenido
        toolbar.style.display = '';
        const usedCats = new Set(cards.map(c => c.dataset.cat));
        catFilter.querySelectorAll('.pill[data-cat]').forEach(pill => {
            const cat = pill.dataset.cat;
            if (cat === 'todas') return; // "Todo" siempre visible
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
        // Eliminar empty state anterior
        grid?.querySelector('.img-empty')?.remove();

        if (visible === 0) {
            const empty = document.createElement('div');
            empty.className = 'img-empty';
            const totalOfYear = cardsOfYear(year ?? currentYear()).length;

            if (totalOfYear === 0) {
                // Año completamente vacío — estado de inicio con botón
                empty.innerHTML = `
                    <i class="fa fa-folder-open"></i>
                    <p>Aún no hay imágenes para este año.</p>
                    <button class="btn-empty-upload" type="button" id="btnEmptyUpload">
                        <i class="fa fa-plus"></i> Subir primera imagen
                    </button>`;
            } else {
                // Hay imágenes pero el filtro activo no tiene resultados
                empty.innerHTML = `
                    <i class="fa fa-magnifying-glass"></i>
                    <p>Ninguna imagen coincide con este filtro.</p>`;
            }
            grid?.appendChild(empty);

            // El botón del estado vacío también abre el modal
            document.getElementById('btnEmptyUpload')?.addEventListener('click', () => {
                document.getElementById('btnAddImage')?.click();
            });
        }
    }

    /* ════════════════════════════════════
       SUBTÍTULO DEL AÑO
    ════════════════════════════════════ */
    /* ════════════════════════════════════
       BOTÓN GLOBAL DE GUARDAR
       — "Guardar" (disabled) cuando no hay cambios
       — "Subir" cuando el año no tiene imágenes aún
       — "Guardar cambios" cuando ya hay imágenes registradas
    ════════════════════════════════════ */
    const btnGlobalSave      = document.getElementById('btnGlobalSave');
    const btnGlobalSaveLabel = document.getElementById('btnGlobalSaveLabel');
    const btnGlobalSaveIcon  = document.getElementById('btnGlobalSaveIcon');

    function updateGlobalSaveBtn() {
        if (!btnGlobalSave) return;
        const y          = currentYear();
        const hasImages  = cardsOfYear(y).length > 0;
        const subtitleVal = subtitleInput?.value.trim() ?? '';
        const savedSub    = subtitles[y] ?? '';
        const hasChanges  = subtitleVal !== savedSub;

        if (!hasChanges) {
            // Sin cambios — desactivar
            btnGlobalSave.disabled = true;
            if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Guardar';
            if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-floppy-disk';
        } else if (!hasImages) {
            // Año sin imágenes, hay cambios en subtítulo — "Subir"
            btnGlobalSave.disabled = false;
            if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Subir';
            if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-cloud-arrow-up';
        } else {
            // Año con imágenes, hay cambios — "Guardar cambios"
            btnGlobalSave.disabled = false;
            if (btnGlobalSaveLabel) btnGlobalSaveLabel.textContent = 'Guardar cambios';
            if (btnGlobalSaveIcon)  btnGlobalSaveIcon.className    = 'fa fa-floppy-disk';
        }
    }

    // Escuchar cambios en el input de subtítulo
    subtitleInput?.addEventListener('input', updateGlobalSaveBtn);

    // Llamar al cambiar de año
    const origRenderYear = renderYear;

    document.getElementById('yearSubtitleForm')?.addEventListener('submit', function (e) {
        if (!validateForm(this)) {
            e.preventDefault();
            showToast('Escribe un subtítulo antes de guardar.', 'error');
            return;
        }
        subtitles[currentYear()] = subtitleInput?.value.trim() ?? '';
        // Tras guardar, actualizar el botón
        setTimeout(updateGlobalSaveBtn, 100);
    });

    /* ════════════════════════════════════
       CONTENT TABS (imágenes / categorías)
    ════════════════════════════════════ */
    const tabPanels = {
        images:     document.getElementById('tabImages'),
        categories: document.getElementById('tabCategories'),
        settings:   document.getElementById('tabSettings'),
    };
    document.querySelectorAll('.content-tab').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.content-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const target = btn.dataset.tab;
            Object.entries(tabPanels).forEach(([key, panel]) => {
                if (!panel) return;
                const show = key === target;
                panel.style.display = show ? '' : 'none';
                panel.classList.toggle('active', show);
                if (show) {
                    // Disparar animación de entrada
                    panel.classList.remove('tab-entering');
                    void panel.offsetWidth; // forzar reflow para reiniciar la animación
                    panel.classList.add('tab-entering');
                }
            });
        });
    });

    /* ════════════════════════════════════
       FILTROS DE CATEGORÍA (pills)
    ════════════════════════════════════ */
    document.getElementById('catFilter')?.addEventListener('click', e => {
        const pill = e.target.closest('.pill');
        if (!pill) return;
        document.querySelectorAll('#catFilter .pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        filterImagesByCat(pill.dataset.cat);
    });

    /* ════════════════════════════════════
       CATEGORY MANAGER
    ════════════════════════════════════ */
    document.getElementById('catList')?.addEventListener('click', e => {
        const delBtn = e.target.closest('.cat-item__del');
        if (!delBtn) return;
        const item    = delBtn.closest('.cat-item');
        const catName = item?.dataset.cat;
        if (!catName) return;
        item.style.transition = 'opacity 0.2s, transform 0.2s';
        item.style.opacity = '0'; item.style.transform = 'translateX(8px)';
        setTimeout(() => {
            item.remove();
            // Categorías globales: quitar la pill del filtro Y la opción del modal
            document.querySelector(`#catFilter .pill[data-cat="${catName}"]`)?.remove();
            const sel = document.getElementById('catInput');
            if (sel) {
                Array.from(sel.options).forEach(o => { if (o.value === catName) o.remove(); });
            }
        }, 200);
        showToast(`Categoría "${catName}" eliminada de todos los años.`);
    });

    document.getElementById('btnAddCat')?.addEventListener('click', addCategory);
    document.getElementById('newCatInput')?.addEventListener('keydown', e => {
        if (e.key === 'Enter') addCategory();
    });

    function addCategory() {
        const input = document.getElementById('newCatInput');
        const val   = input?.value.trim();
        if (!val) { showToast('Escribe un nombre de categoría.', 'error'); return; }

        const catList = document.getElementById('catList');
        const exists = Array.from(catList?.querySelectorAll('.cat-item__name') || [])
                           .some(el => el.textContent.toLowerCase() === val.toLowerCase());
        if (exists) { showToast('Esa categoría ya existe.', 'error'); return; }

        // ── Añadir a la lista de gestión ──
        const item = document.createElement('div');
        item.className = 'cat-item'; item.dataset.cat = val;
        item.innerHTML = `
            <span class="cat-item__dot"></span>
            <span class="cat-item__name">${val}</span>
            <button class="cat-item__del" type="button" title="Eliminar categoría">
                <i class="fa fa-xmark"></i>
            </button>`;
        catList?.appendChild(item);

        // ── Categorías globales: añadir pill al filtro ──
        const filter = document.getElementById('catFilter');
        const btn = document.createElement('button');
        btn.className = 'pill'; btn.dataset.cat = val;
        btn.type = 'button'; btn.textContent = val;
        filter?.appendChild(btn);

        // ── Añadir al select del modal ──
        const sel = document.getElementById('catInput');
        const opt = document.createElement('option');
        opt.value = val; opt.textContent = val;
        sel?.appendChild(opt);

        if (input) input.value = '';
        showToast(`Categoría "${val}" disponible para todos los años.`);
    }

    /* ════════════════════════════════════
       MODAL — abrir / cerrar
    ════════════════════════════════════ */
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
    }

    document.getElementById('imgModalClose')?.addEventListener('click', closeModal);
    document.getElementById('imgModalCancel')?.addEventListener('click', closeModal);
    modalBg?.addEventListener('click', e => { if (e.target === modalBg) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && modalBg?.classList.contains('open')) closeModal(); });

    /* Abrir modal para añadir */
    document.getElementById('btnAddImage')?.addEventListener('click', () => {
        const y = currentYear();
        if (selectedYearHid) selectedYearHid.value = y;
        if (modalTitle) modalTitle.textContent = 'Añadir Imagen del Proyecto';
        if (modalSub)   modalSub.textContent   = `Nueva imagen para el año ${y}`;
        if (methodField) methodField.innerHTML = '';
        // Label del botón submit del modal
        const submitLabel = document.getElementById('modalSubmitLabel');
        if (submitLabel) submitLabel.textContent = 'Continuar';
        const dateInput = document.getElementById('eventDateInput');
        if (dateInput) {
            dateInput.value = todayISO();
            updateDateReadable(dateInput.value);
        }
        openModal();
    });

    /* Abrir modal para editar */
    document.getElementById('imgGrid')?.addEventListener('click', e => {
        const editBtn = e.target.closest('.btn-edit-img');
        if (!editBtn) return;

        const id   = editBtn.dataset.id;
        const card = document.querySelector(`.img-card[data-id="${id}"]`);
        if (!card) return;

        if (modalTitle) modalTitle.textContent = `Editar Imagen — ID: ${id}`;
        if (modalSub)   modalSub.textContent   = 'Modifica los datos de esta imagen';
        if (methodField) methodField.innerHTML = `<input type="hidden" name="_method" value="PUT">`;
        // Label del botón submit del modal en edición
        const submitLabel = document.getElementById('modalSubmitLabel');
        if (submitLabel) submitLabel.textContent = 'Guardar cambios';

        const updateUrl = editBtn.dataset.updateUrl;
        if (updateUrl && modalForm) modalForm.action = updateUrl;

        // Prellenar descripción
        const desc = card.querySelector('.img-desc')?.textContent?.trim() ?? '';
        const descInput = document.getElementById('imgDescInput');
        if (descInput) descInput.value = desc === 'Sin descripción.' ? '' : desc;

        // Prellenar fecha
        const dateText  = card.querySelector('.img-date')?.textContent?.replace(/[^0-9/]/g, '').trim() ?? '';
        const dateInput = document.getElementById('eventDateInput');
        if (dateInput) {
            if (dateText.includes('/')) {
                const [dd, mm, yyyy] = dateText.split('/');
                dateInput.value = `${yyyy}-${mm}-${dd}`;
            } else {
                dateInput.value = todayISO();
            }
            updateDateReadable(dateInput.value);
        }

        // Categoría
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
       UPLOAD DE IMAGEN
    ════════════════════════════════════ */
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
    document.getElementById('eventDateInput')?.addEventListener('change', e => {
        updateDateReadable(e.target.value);
    });
    document.getElementById('btnChangeImg')?.addEventListener('click', e => {
        e.stopPropagation(); resetUploadZone(); fileInput?.click();
    });

    function handleFile(file) {
        if (file.size > 5 * 1024 * 1024) { showToast('La imagen supera 5 MB.', 'error'); return; }
        const reader = new FileReader();
        reader.onload = ev => showPreview(ev.target.result);
        reader.readAsDataURL(file);
    }

    /* ════════════════════════════════════
       DESTACADO
    ════════════════════════════════════ */
    /* Featured y projSearch eliminados del modal */
    function setFeatured() {}  /* stub para compatibilidad con closeModal */

    /* ════════════════════════════════════
       MODAL FORM — submit
    ════════════════════════════════════ */
    modalForm?.addEventListener('submit', function (e) {
        if (!validateForm(this)) {
            e.preventDefault();
            showToast('Por favor completa los campos obligatorios.', 'error');
        }
    });

    /* ════════════════════════════════════
       ELIMINAR IMAGEN
    ════════════════════════════════════ */
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
                setTimeout(() => {
                    card.remove();
                    filterImagesByCat(activeCat);
                }, 230);
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

    /* ════════════════════════════════════
       INIT
    ════════════════════════════════════ */
    const initialYear = yearDisplayNum?.textContent?.trim();
    if (initialYear) {
        const idx = years.indexOf(initialYear);
        if (idx !== -1) currentIdx = idx;
    }
    renderYear();
    // Botón global — estado inicial
    setTimeout(updateGlobalSaveBtn, 0);

    /* ════════════════════════════════════
       ESTILOS JS — toast + errores
    ════════════════════════════════════ */
    if (!document.getElementById('edit-page-js-styles')) {
        const style = document.createElement('style');
        style.id = 'edit-page-js-styles';
        style.textContent = `
            .edit-toast {
                position:fixed; bottom:26px; right:26px;
                display:flex; align-items:center; gap:10px;
                padding:12px 18px; border-radius:11px;
                font-size:13px; font-weight:500; color:#fff;
                box-shadow:0 8px 26px rgba(0,0,0,0.18);
                opacity:0; transform:translateY(12px);
                transition:opacity 0.28s ease, transform 0.28s ease;
                z-index:9999; pointer-events:none; max-width:320px;
            }
            .edit-toast--show  { opacity:1; transform:translateY(0); }
            .edit-toast--success { background:#2d7d46; }
            .edit-toast--error   { background:#c0392b; }
            .edit-toast__icon  { font-size:15px; flex-shrink:0; }
            .field--error {
                border-color:#c0392b !important;
                box-shadow:0 0 0 3px rgba(192,57,43,0.14) !important;
            }
            .field-error-msg { margin-top:4px; font-size:12px; color:#c0392b; font-weight:500; }
            .upload-zone.dragover {
                border-color:var(--accent) !important;
                background:var(--accent-light) !important;
            }
        `;
        document.head.appendChild(style);
    }

})();