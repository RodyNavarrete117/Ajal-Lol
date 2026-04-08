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
       ESTADO GLOBAL
    ════════════════════════════════════ */
    let currentYear = document.querySelector('.year-tab.active')?.dataset.year || '2023';

    /* ════════════════════════════════════
       YEAR TABS
    ════════════════════════════════════ */
    const yearTabs = document.getElementById('yearTabs');

    function setActiveYear(year) {
        currentYear = year;

        // Actualizar tabs
        yearTabs?.querySelectorAll('.year-tab').forEach(t => {
            const isActive = t.dataset.year === year;
            t.classList.toggle('active', isActive);
            t.setAttribute('aria-selected', String(isActive));
        });

        // Actualizar badge y etiquetas
        const badge = document.getElementById('yearContentBadge');
        if (badge) badge.textContent = year;
        const catYearLabel = document.getElementById('catYearLabel');
        if (catYearLabel) catYearLabel.textContent = year;

        // Actualizar año en modal
        const modalYearVal = document.getElementById('modalYearVal');
        if (modalYearVal) modalYearVal.textContent = year;
        const selectedYear = document.getElementById('selectedYear');
        if (selectedYear) selectedYear.value = year;
    }

    yearTabs?.addEventListener('click', e => {
        // Clic en la etiqueta del año (no en el botón eliminar)
        const tab = e.target.closest('.year-tab');
        const delBtn = e.target.closest('.year-tab__del');

        if (delBtn) {
            e.stopPropagation();
            deleteYear(delBtn.dataset.year);
            return;
        }
        if (tab) setActiveYear(tab.dataset.year);
    });

    /* ── Agregar año ── */
    const btnAddYear    = document.getElementById('btnAddYear');
    const addYearForm   = document.getElementById('addYearForm');
    const newYearInput  = document.getElementById('newYearInput');
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
            showToast('Ingresa un año válido (ej: 2025).', 'error');
            return;
        }
        if (yearTabs?.querySelector(`.year-tab[data-year="${val}"]`)) {
            showToast('Ese año ya existe.', 'error');
            return;
        }
        addYearTab(val);
        hideAddYearForm();
        setActiveYear(val);
        showToast(`Año ${val} agregado.`);
    });

    newYearInput?.addEventListener('keydown', e => {
        if (e.key === 'Enter') btnConfirmYear?.click();
        if (e.key === 'Escape') hideAddYearForm();
    });

    function addYearTab(year) {
        const div = document.createElement('div');
        div.className = 'year-tab';
        div.dataset.year = year;
        div.setAttribute('role', 'tab');
        div.setAttribute('aria-selected', 'false');
        div.innerHTML = `
            <span class="year-tab__label">${year}</span>
            <button class="year-tab__del" type="button" data-year="${year}" aria-label="Eliminar año ${year}">
                <i class="fa fa-xmark"></i>
            </button>`;
        yearTabs?.appendChild(div);

        // Agregar también al toggle del modal (si hay años en el modal)
        addYearToModal(year);
    }

    function addYearToModal(year) {
        // Solo actualiza el display, no el toggle — el año es fijo al del contexto
    }

    /* ── Eliminar año ── */
    function deleteYear(year) {
        const tabs = yearTabs?.querySelectorAll('.year-tab');
        if (tabs && tabs.length <= 1) {
            showToast('Debe existir al menos un año.', 'error');
            return;
        }
        if (!confirm(`¿Eliminar el año ${year} y todo su contenido?`)) return;

        const tab = yearTabs?.querySelector(`.year-tab[data-year="${year}"]`);
        if (tab) {
            tab.style.transition = 'opacity 0.2s, transform 0.2s';
            tab.style.opacity = '0'; tab.style.transform = 'scale(0.88)';
            setTimeout(() => {
                tab.remove();
                // Si era el activo, seleccionar el primero disponible
                if (currentYear === year) {
                    const first = yearTabs?.querySelector('.year-tab');
                    if (first) setActiveYear(first.dataset.year);
                }
            }, 200);
        }
        showToast(`Año ${year} eliminado.`);
    }

    /* ════════════════════════════════════
       CONTENT TABS (imágenes / categorías)
    ════════════════════════════════════ */
    const tabPanels = {
        images: document.getElementById('tabImages'),
        categories: document.getElementById('tabCategories'),
    };

    document.querySelectorAll('.content-tab').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.content-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const target = btn.dataset.tab;
            Object.entries(tabPanels).forEach(([key, panel]) => {
                if (!panel) return;
                panel.style.display = key === target ? '' : 'none';
                if (key === target) panel.classList.add('active');
                else panel.classList.remove('active');
            });
        });
    });

    /* ════════════════════════════════════
       FILTROS DE CATEGORÍA
    ════════════════════════════════════ */
    let activeCat = 'todas';

    document.getElementById('catFilter')?.addEventListener('click', e => {
        const pill = e.target.closest('.pill');
        if (!pill) return;
        document.querySelectorAll('#catFilter .pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        activeCat = pill.dataset.cat;
        filterImages();
    });

    function filterImages() {
        const cards = document.querySelectorAll('#imgGrid .img-card');
        let visible = 0;
        cards.forEach(card => {
            const show = activeCat === 'todas' || card.dataset.cat === activeCat;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        let empty = document.getElementById('imgEmpty');
        if (visible === 0) {
            if (!empty) {
                empty = document.createElement('div');
                empty.id = 'imgEmpty'; empty.className = 'img-empty';
                empty.innerHTML = '<i class="fa fa-folder-open"></i><p>No hay imágenes con este filtro.</p>';
                document.getElementById('imgGrid')?.appendChild(empty);
            }
            empty.style.display = '';
        } else if (empty) {
            empty.style.display = 'none';
        }
    }

    /* ════════════════════════════════════
       CATEGORY MANAGER
    ════════════════════════════════════ */
    const catList = document.getElementById('catList');

    catList?.addEventListener('click', e => {
        const delBtn = e.target.closest('.cat-item__del');
        if (!delBtn) return;
        const item = delBtn.closest('.cat-item');
        const catName = item?.dataset.cat;
        if (!catName) return;

        item.style.transition = 'opacity 0.2s, transform 0.2s';
        item.style.opacity = '0'; item.style.transform = 'translateX(8px)';
        setTimeout(() => {
            item.remove();
            // Quitar también del filtro de imágenes
            removePillFromFilter(catName);
        }, 200);
        showToast(`Categoría "${catName}" eliminada.`);
    });

    document.getElementById('btnAddCat')?.addEventListener('click', addCategory);
    document.getElementById('newCatInput')?.addEventListener('keydown', e => {
        if (e.key === 'Enter') addCategory();
    });

    function addCategory() {
        const input = document.getElementById('newCatInput');
        const val = input?.value.trim();
        if (!val) { showToast('Escribe un nombre de categoría.', 'error'); return; }

        // Verificar duplicado
        const exists = Array.from(catList?.querySelectorAll('.cat-item__name') || [])
                            .some(el => el.textContent.toLowerCase() === val.toLowerCase());
        if (exists) { showToast('Esa categoría ya existe.', 'error'); return; }

        // Añadir a la lista
        const item = document.createElement('div');
        item.className = 'cat-item'; item.dataset.cat = val;
        item.innerHTML = `
            <span class="cat-item__dot"></span>
            <span class="cat-item__name">${val}</span>
            <button class="cat-item__del" type="button" title="Eliminar categoría">
                <i class="fa fa-xmark"></i>
            </button>`;
        catList?.appendChild(item);

        // Añadir pill al filtro y al select del modal
        addPillToFilter(val);
        addOptionToSelect(val);

        if (input) input.value = '';
        showToast(`Categoría "${val}" agregada.`);
    }

    function addPillToFilter(val) {
        const filter = document.getElementById('catFilter');
        if (!filter) return;
        const btn = document.createElement('button');
        btn.className = 'pill'; btn.dataset.cat = val;
        btn.type = 'button'; btn.textContent = val;
        filter.appendChild(btn);
    }
    function removePillFromFilter(val) {
        document.querySelector(`#catFilter .pill[data-cat="${val}"]`)?.remove();
    }
    function addOptionToSelect(val) {
        const sel = document.getElementById('catInput');
        if (!sel) return;
        const opt = document.createElement('option');
        opt.value = val; opt.textContent = val;
        sel.appendChild(opt);
    }

    /* ════════════════════════════════════
       TEXTOS FORM
    ════════════════════════════════════ */
    document.querySelector('.texts-form')?.addEventListener('submit', function (e) {
        if (!validateForm(this)) {
            e.preventDefault();
            showToast('Por favor completa los campos obligatorios.', 'error');
        }
    });

    /* ════════════════════════════════════
       MODAL — abrir / cerrar
    ════════════════════════════════════ */
    const modalBg    = document.getElementById('imgModalBg');
    const modalForm  = document.getElementById('imgModalForm');
    const modalTitle = document.getElementById('imgModalTitle');
    const modalSub   = document.getElementById('imgModalSub');
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

    /* ── Añadir imagen ── */
    document.getElementById('btnAddImage')?.addEventListener('click', () => {
        if (modalTitle) modalTitle.textContent = 'Añadir Imagen del Proyecto';
        if (modalSub)   modalSub.textContent   = `Nueva imagen para el año ${currentYear}`;
        if (methodField) methodField.innerHTML = '';

        // Mostrar año actual en el modal
        const modalYearVal = document.getElementById('modalYearVal');
        if (modalYearVal) modalYearVal.textContent = currentYear;
        const selectedYear = document.getElementById('selectedYear');
        if (selectedYear) selectedYear.value = currentYear;

        openModal();
    });

    /* ── Editar imagen ── */
    document.getElementById('imgGrid')?.addEventListener('click', e => {
        const editBtn = e.target.closest('.btn-edit-img');
        if (!editBtn) return;

        const id   = editBtn.dataset.id;
        const card = document.querySelector(`.img-card[data-id="${id}"]`);
        if (!card) return;

        if (modalTitle) modalTitle.textContent = `Editar Imagen — ID: ${id}`;
        if (modalSub)   modalSub.textContent   = 'Modifica los datos de esta imagen del proyecto';
        if (methodField) methodField.innerHTML = `<input type="hidden" name="_method" value="PUT">`;

        const updateUrl = editBtn.dataset.updateUrl;
        if (updateUrl && modalForm) modalForm.action = updateUrl;

        // Prellenar
        const desc = card.querySelector('.img-desc')?.textContent?.trim() ?? '';
        const year = card.dataset.year;
        const cat  = card.dataset.cat;
        const imgEl = card.querySelector('.img-thumb img');

        const descInput = document.getElementById('imgDescInput');
        if (descInput) descInput.value = desc === 'Sin descripción.' ? '' : desc;

        // Año fijo en modal
        const modalYearVal = document.getElementById('modalYearVal');
        if (modalYearVal) modalYearVal.textContent = year;
        const selectedYear = document.getElementById('selectedYear');
        if (selectedYear) selectedYear.value = year;

        // Categoría
        const catSel = document.getElementById('catInput');
        if (catSel) {
            for (let i = 0; i < catSel.options.length; i++) {
                if (catSel.options[i].value === cat) { catSel.selectedIndex = i; break; }
            }
        }

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
       ELIMINAR IMAGEN
    ════════════════════════════════════ */
    document.getElementById('imgGrid')?.addEventListener('click', e => {
        const delBtn = e.target.closest('.btn-del-img');
        if (!delBtn) return;

        const id  = delBtn.dataset.id;
        const url = delBtn.dataset.url;

        if (!confirm('¿Eliminar esta imagen? Esta acción no se puede deshacer.')) return;

        if (!url || url === '#') {
            // Sin backend aún: eliminar del DOM directamente
            const card = document.querySelector(`.img-card[data-id="${id}"]`);
            if (card) {
                card.style.transition = 'opacity 0.22s, transform 0.22s';
                card.style.opacity = '0'; card.style.transform = 'scale(0.95)';
                setTimeout(() => { card.remove(); filterImages(); }, 230);
            }
            showToast('Imagen eliminada.');
            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]')?.content
                   || document.querySelector('input[name="_token"]')?.value || '';

        fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' } })
            .then(res => { if (!res.ok) throw new Error(); return res.json(); })
            .then(() => {
                const card = document.querySelector(`.img-card[data-id="${id}"]`);
                if (card) {
                    card.style.transition = 'opacity 0.22s, transform 0.22s';
                    card.style.opacity = '0'; card.style.transform = 'scale(0.95)';
                    setTimeout(() => { card.remove(); filterImages(); }, 230);
                }
                showToast('Imagen eliminada.');
            })
            .catch(() => showToast('No se pudo eliminar la imagen.', 'error'));
    });

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