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
        }, 3200);
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
        field.parentElement.querySelector('.field-error-msg')?.remove();
    }

    /* ════════════════════════════════════
       FECHA DE HOY (formato YYYY-MM-DD)
    ════════════════════════════════════ */
    function todayISO() {
        const d = new Date();
        return d.toISOString().split('T')[0];
    }

    /* ════════════════════════════════════
       ACORDEONES DE AÑO
    ════════════════════════════════════ */
    const accordionList = document.getElementById('yearAccordionList');

    // Toggle abrir/cerrar al hacer clic en la cabecera
    accordionList?.addEventListener('click', e => {
        // Botón eliminar año
        const delBtn = e.target.closest('.year-del-btn');
        if (delBtn) {
            e.stopPropagation();
            deleteYear(delBtn.dataset.year);
            return;
        }

        // Clic en cabecera
        const head = e.target.closest('.year-accordion__head');
        if (!head) return;
        const acc = head.closest('.year-accordion');
        if (!acc) return;

        const isOpen = acc.classList.contains('open');
        // Cerrar todos primero (comportamiento acordeón)
        accordionList.querySelectorAll('.year-accordion.open').forEach(a => {
            if (a !== acc) {
                a.classList.remove('open');
                a.querySelector('.year-accordion__head')?.setAttribute('aria-expanded', 'false');
            }
        });
        acc.classList.toggle('open', !isOpen);
        head.setAttribute('aria-expanded', String(!isOpen));
    });

    // Teclado en cabecera
    accordionList?.addEventListener('keydown', e => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        const head = e.target.closest('.year-accordion__head');
        if (head) { e.preventDefault(); head.click(); }
    });

    /* ── Eliminar año ── */
    function deleteYear(year) {
        const accs = accordionList?.querySelectorAll('.year-accordion');
        if (accs && accs.length <= 1) {
            showToast('Debe existir al menos un año.', 'error');
            return;
        }
        if (!confirm(`¿Eliminar el año ${year} y todo su contenido? Esta acción no se puede deshacer.`)) return;

        const acc = accordionList?.querySelector(`.year-accordion[data-year="${year}"]`);
        if (acc) {
            acc.style.transition = 'opacity 0.22s, transform 0.22s';
            acc.style.opacity = '0'; acc.style.transform = 'translateX(8px)';
            setTimeout(() => acc.remove(), 230);
        }
        showToast(`Año ${year} eliminado.`);
    }

    /* ════════════════════════════════════
       SUBTÍTULO DE AÑO — formularios
    ════════════════════════════════════ */
    accordionList?.addEventListener('submit', e => {
        const form = e.target.closest('.year-subtitle-form');
        if (!form) return;

        if (!validateForm(form)) {
            e.preventDefault();
            showToast('Escribe un subtítulo para guardar.', 'error');
            return;
        }

        // Actualizar el preview en la cabecera en tiempo real
        const year  = form.dataset.year;
        const input = form.querySelector('.year-subtitle-input');
        const val   = input?.value.trim();
        if (val) {
            const preview = document.getElementById(`previewSub-${year}`);
            if (preview) preview.textContent = val;
        }
        // Dejar que el form haga submit normalmente
    });

    // Preview en tiempo real mientras escribe
    accordionList?.addEventListener('input', e => {
        const input = e.target.closest('.year-subtitle-input');
        if (!input) return;
        const year = input.dataset.year;
        const preview = document.getElementById(`previewSub-${year}`);
        if (!preview) return;
        preview.textContent = input.value.trim() || 'Sin subtítulo — haz clic para editar';
    });

    /* ════════════════════════════════════
       AGREGAR NUEVO AÑO
    ════════════════════════════════════ */
    const btnAddYear     = document.getElementById('btnAddYear');
    const addYearForm    = document.getElementById('addYearForm');
    const newYearInput   = document.getElementById('newYearInput');
    const btnConfirmYear = document.getElementById('btnConfirmYear');
    const btnCancelYear  = document.getElementById('btnCancelYear');

    btnAddYear?.addEventListener('click', () => {
        addYearForm.style.display = 'flex';
        newYearInput?.focus();
        btnAddYear.style.display = 'none';
    });

    function hideAddYearForm() {
        addYearForm.style.display = 'none';
        btnAddYear.style.display = '';
        if (newYearInput) newYearInput.value = '';
    }

    btnCancelYear?.addEventListener('click', hideAddYearForm);

    btnConfirmYear?.addEventListener('click', () => {
        const val = newYearInput?.value.trim();
        if (!val || isNaN(val) || val.length !== 4) {
            showToast('Ingresa un año válido (ej: 2026).', 'error');
            return;
        }
        if (accordionList?.querySelector(`.year-accordion[data-year="${val}"]`)) {
            showToast('Ese año ya existe.', 'error');
            return;
        }
        addYearAccordion(val);
        hideAddYearForm();
        showToast(`Año ${val} agregado.`);
    });

    newYearInput?.addEventListener('keydown', e => {
        if (e.key === 'Enter') btnConfirmYear?.click();
        if (e.key === 'Escape') hideAddYearForm();
    });

    function addYearAccordion(year) {
        const acc = document.createElement('div');
        acc.className = 'year-accordion open';
        acc.dataset.year = year;
        acc.id = `acc-${year}`;
        acc.innerHTML = `
            <div class="year-accordion__head" role="button" tabindex="0" aria-expanded="true">
                <div class="year-accordion__left">
                    <span class="year-accordion__num">${year}</span>
                    <span class="year-accordion__preview-sub" id="previewSub-${year}">Sin subtítulo — haz clic para editar</span>
                </div>
                <div class="year-accordion__right">
                    <span class="year-img-count">0 img.</span>
                    <button class="year-del-btn" type="button" data-year="${year}" title="Eliminar año ${year}">
                        <i class="fa fa-trash-can"></i>
                    </button>
                    <span class="year-chevron"><i class="fa fa-chevron-down"></i></span>
                </div>
            </div>
            <div class="year-accordion__body">
                <div class="year-subtitle-form-wrap">
                    <form method="POST" action="#" class="year-subtitle-form" data-year="${year}">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="year" value="${year}">
                        <div class="form-group subtitle-group">
                            <label for="subtitulo-${year}">Subtítulo del año ${year}</label>
                            <div class="subtitle-input-wrap">
                                <input type="text" id="subtitulo-${year}" name="subtitulo"
                                    value="" placeholder="Ej: Año en el que se ayudó a mucha gente..."
                                    data-year="${year}" class="year-subtitle-input">
                                <button type="submit" class="btn-save btn-save--inline">
                                    <i class="fa fa-floppy-disk"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="content-tabs" role="tablist" data-year="${year}">
                    <button class="content-tab active" data-tab="images" data-year="${year}" type="button">
                        <i class="fa fa-images"></i> Imágenes
                    </button>
                    <button class="content-tab" data-tab="categories" data-year="${year}" type="button">
                        <i class="fa fa-tags"></i> Categorías
                    </button>
                </div>
                <div class="tab-panel active" id="tabImages-${year}" data-year="${year}">
                    <div class="img-toolbar">
                        <div class="filter-wrap" id="catFilter-${year}" role="group">
                            <button class="pill active" data-cat="todas" type="button">Todo</button>
                        </div>
                        <button class="btn-add-img" type="button" data-year="${year}">
                            <i class="fa fa-plus"></i> Añadir imagen
                        </button>
                    </div>
                    <div class="img-grid" id="imgGrid-${year}">
                        <div class="img-empty" id="imgEmpty-${year}">
                            <i class="fa fa-folder-open"></i>
                            <p>No hay imágenes para ${year}. Añade la primera.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-panel" id="tabCategories-${year}" data-year="${year}" style="display:none">
                    <div class="cat-manager">
                        <p class="cat-manager__hint">Categorías del año <strong>${year}</strong>.</p>
                        <div class="cat-list" id="catList-${year}"></div>
                        <div class="cat-add-row">
                            <input type="text" id="newCatInput-${year}" placeholder="Nueva categoría..."
                                   class="new-cat-input" data-year="${year}">
                            <button type="button" class="btn-save btn-save--sm btn-add-cat" data-year="${year}">
                                <i class="fa fa-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
        accordionList?.appendChild(acc);
    }

    /* ════════════════════════════════════
       CONTENT TABS (imágenes / categorías)
       Delegado sobre accordionList
    ════════════════════════════════════ */
    accordionList?.addEventListener('click', e => {
        const tab = e.target.closest('.content-tab');
        if (!tab) return;

        const year   = tab.dataset.year;
        const target = tab.dataset.tab;
        const acc    = document.getElementById(`acc-${year}`);
        if (!acc) return;

        // Desactivar todos los tabs del mismo año
        acc.querySelectorAll('.content-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        // Mostrar/ocultar paneles
        const panels = { images: `tabImages-${year}`, categories: `tabCategories-${year}` };
        Object.entries(panels).forEach(([key, id]) => {
            const panel = document.getElementById(id);
            if (!panel) return;
            const show = key === target;
            panel.style.display = show ? '' : 'none';
            panel.classList.toggle('active', show);
        });
    });

    /* ════════════════════════════════════
       FILTROS DE CATEGORÍA (delegado)
    ════════════════════════════════════ */
    accordionList?.addEventListener('click', e => {
        const pill = e.target.closest('.pill');
        if (!pill || e.target.closest('.content-tab')) return;

        const filterWrap = pill.closest('[id^="catFilter-"]');
        if (!filterWrap) return;

        filterWrap.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');

        const year = filterWrap.id.replace('catFilter-', '');
        const cat  = pill.dataset.cat;
        filterImagesByYear(year, cat);
    });

    function filterImagesByYear(year, cat) {
        const grid  = document.getElementById(`imgGrid-${year}`);
        if (!grid) return;
        let visible = 0;
        grid.querySelectorAll('.img-card').forEach(card => {
            const show = cat === 'todas' || card.dataset.cat === cat;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        let empty = document.getElementById(`imgEmpty-${year}`);
        if (visible === 0) {
            if (!empty) {
                empty = document.createElement('div');
                empty.id = `imgEmpty-${year}`; empty.className = 'img-empty';
                empty.innerHTML = '<i class="fa fa-folder-open"></i><p>No hay imágenes con este filtro.</p>';
                grid.appendChild(empty);
            }
            empty.style.display = '';
        } else if (empty) {
            empty.style.display = 'none';
        }
    }

    /* ════════════════════════════════════
       CATEGORY MANAGER (delegado)
    ════════════════════════════════════ */
    accordionList?.addEventListener('click', e => {
        // Eliminar categoría
        const delBtn = e.target.closest('.cat-item__del');
        if (delBtn) {
            const item    = delBtn.closest('.cat-item');
            const catName = item?.dataset.cat;
            const year    = item?.dataset.year;
            if (!catName) return;
            item.style.transition = 'opacity 0.2s, transform 0.2s';
            item.style.opacity = '0'; item.style.transform = 'translateX(8px)';
            setTimeout(() => {
                item.remove();
                document.querySelector(`#catFilter-${year} .pill[data-cat="${catName}"]`)?.remove();
            }, 200);
            showToast(`Categoría "${catName}" eliminada.`);
            return;
        }

        // Agregar categoría
        const addBtn = e.target.closest('.btn-add-cat');
        if (addBtn) {
            addCategory(addBtn.dataset.year);
            return;
        }
    });

    accordionList?.addEventListener('keydown', e => {
        if (e.key !== 'Enter') return;
        const input = e.target.closest('.new-cat-input');
        if (input) addCategory(input.dataset.year);
    });

    function addCategory(year) {
        const input = document.getElementById(`newCatInput-${year}`);
        const val   = input?.value.trim();
        if (!val) { showToast('Escribe un nombre de categoría.', 'error'); return; }

        const catList = document.getElementById(`catList-${year}`);
        const exists = Array.from(catList?.querySelectorAll('.cat-item__name') || [])
                           .some(el => el.textContent.toLowerCase() === val.toLowerCase());
        if (exists) { showToast('Esa categoría ya existe.', 'error'); return; }

        const item = document.createElement('div');
        item.className = 'cat-item'; item.dataset.cat = val; item.dataset.year = year;
        item.innerHTML = `
            <span class="cat-item__dot"></span>
            <span class="cat-item__name">${val}</span>
            <button class="cat-item__del" type="button" title="Eliminar categoría">
                <i class="fa fa-xmark"></i>
            </button>`;
        catList?.appendChild(item);

        // Pill al filtro del año
        const filterWrap = document.getElementById(`catFilter-${year}`);
        if (filterWrap) {
            const btn = document.createElement('button');
            btn.className = 'pill'; btn.dataset.cat = val; btn.type = 'button'; btn.textContent = val;
            filterWrap.appendChild(btn);
        }

        // Opción al select del modal si coincide con año activo
        const selectedYear = document.getElementById('selectedYear');
        if (selectedYear?.value === year) {
            const sel = document.getElementById('catInput');
            if (sel) {
                const opt = document.createElement('option');
                opt.value = val; opt.textContent = val;
                sel.appendChild(opt);
            }
        }

        if (input) input.value = '';
        showToast(`Categoría "${val}" agregada.`);
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
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            document.getElementById('imgModal')?.querySelector('input,textarea,select,button')?.focus();
        }, 240);
    }
    function closeModal() {
        modalBg?.classList.remove('open');
        document.body.style.overflow = '';
        resetUploadZone();
        modalForm?.reset();
        if (methodField) methodField.innerHTML = '';
        setFeatured(false);
    }

    document.getElementById('imgModalClose')?.addEventListener('click', closeModal);
    document.getElementById('imgModalCancel')?.addEventListener('click', closeModal);
    modalBg?.addEventListener('click', e => { if (e.target === modalBg) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    /* ── Añadir imagen (delegado en accordionList) ── */
    accordionList?.addEventListener('click', e => {
        const addBtn = e.target.closest('.btn-add-img');
        if (!addBtn) return;

        const year = addBtn.dataset.year;
        document.getElementById('selectedYear').value = year;

        if (modalTitle) modalTitle.textContent = 'Añadir Imagen del Proyecto';
        if (modalSub)   modalSub.textContent   = `Nueva imagen para el año ${year}`;
        if (methodField) methodField.innerHTML = '';

        // Fecha por defecto: hoy
        const dateInput = document.getElementById('eventDateInput');
        if (dateInput) dateInput.value = todayISO();

        openModal();
    });

    /* ── Editar imagen (delegado en accordionList) ── */
    accordionList?.addEventListener('click', e => {
        const editBtn = e.target.closest('.btn-edit-img');
        if (!editBtn) return;

        const id   = editBtn.dataset.id;
        const card = document.querySelector(`.img-card[data-id="${id}"]`);
        if (!card) return;

        const year = card.dataset.year;
        document.getElementById('selectedYear').value = year;

        if (modalTitle) modalTitle.textContent = `Editar Imagen — ID: ${id}`;
        if (modalSub)   modalSub.textContent   = 'Modifica los datos de esta imagen';
        if (methodField) methodField.innerHTML = `<input type="hidden" name="_method" value="PUT">`;

        const updateUrl = editBtn.dataset.updateUrl;
        if (updateUrl && modalForm) modalForm.action = updateUrl;

        // Prellenar descripción
        const desc = card.querySelector('.img-desc')?.textContent?.trim() ?? '';
        const descInput = document.getElementById('imgDescInput');
        if (descInput) descInput.value = desc === 'Sin descripción.' ? '' : desc;

        // Prellenar fecha — leer del badge de fecha de la card
        const dateText = card.querySelector('.img-date')?.textContent?.trim().replace(/[^0-9/]/g, '') ?? '';
        const dateInput = document.getElementById('eventDateInput');
        if (dateInput) {
            if (dateText && dateText.includes('/')) {
                // Convertir DD/MM/YYYY → YYYY-MM-DD
                const [dd, mm, yyyy] = dateText.split('/');
                dateInput.value = `${yyyy}-${mm}-${dd}`;
            } else {
                dateInput.value = todayISO();
            }
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
        if (imgEl) showPreview(imgEl.src);
        else resetUploadZone();

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
    const featuredVal = document.getElementById('featuredVal');
    function setFeatured(on) {
        const check = document.getElementById('featuredCheck');
        check?.classList.toggle('on', on);
        check?.setAttribute('aria-checked', String(on));
        if (featuredVal) featuredVal.value = on ? '1' : '0';
    }
    document.getElementById('featuredRow')?.addEventListener('click', () => setFeatured(featuredVal?.value !== '1'));
    document.getElementById('featuredCheck')?.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); setFeatured(featuredVal?.value !== '1'); }
    });

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
       ELIMINAR IMAGEN (delegado)
    ════════════════════════════════════ */
    accordionList?.addEventListener('click', e => {
        const delBtn = e.target.closest('.btn-del-img');
        if (!delBtn) return;

        const id  = delBtn.dataset.id;
        const url = delBtn.dataset.url;

        if (!confirm('¿Eliminar esta imagen? Esta acción no se puede deshacer.')) return;

        const card = document.querySelector(`.img-card[data-id="${id}"]`);
        const year = card?.dataset.year;

        const removeCard = () => {
            if (card) {
                card.style.transition = 'opacity 0.22s, transform 0.22s';
                card.style.opacity = '0'; card.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    card.remove();
                    if (year) {
                        const filter = document.getElementById(`catFilter-${year}`)
                            ?.querySelector('.pill.active')?.dataset.cat || 'todas';
                        filterImagesByYear(year, filter);
                        updateImgCount(year);
                    }
                }, 230);
            }
            showToast('Imagen eliminada.');
        };

        if (!url || url === '#') { removeCard(); return; }

        const token = document.querySelector('meta[name="csrf-token"]')?.content
                   || document.querySelector('input[name="_token"]')?.value || '';
        fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' } })
            .then(res => { if (!res.ok) throw new Error(); return res.json(); })
            .then(removeCard)
            .catch(() => showToast('No se pudo eliminar la imagen.', 'error'));
    });

    /* Actualizar contador de imágenes en cabecera del acordeón */
    function updateImgCount(year) {
        const count = document.getElementById(`imgGrid-${year}`)?.querySelectorAll('.img-card').length ?? 0;
        const badge = document.querySelector(`#acc-${year} .year-img-count`);
        if (badge) badge.textContent = `${count} img.`;
    }

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
                transition:opacity 0.28s ease,transform 0.28s ease;
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
            .field-error-msg {
                margin-top:4px; font-size:12px;
                color:#c0392b; font-weight:500;
            }
            .upload-zone.dragover {
                border-color:var(--accent) !important;
                background:var(--accent-light) !important;
            }
        `;
        document.head.appendChild(style);
    }

})();