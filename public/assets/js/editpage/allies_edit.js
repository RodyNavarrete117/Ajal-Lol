/* ==================== allies_edit.js ==================== */
(function () {
    'use strict';

    const MAX_SIZE_MB = 2;
    const MAX_SLOTS   = 18;

    /* ── Referencias DOM ── */
    const logosGrid    = document.getElementById('logosGrid');
    const btnAddLogo   = document.getElementById('btnAddLogo');
    const logosAddBar  = document.getElementById('logosAddBar');
    const logosCounter = document.getElementById('logosCounter');
    const progressFill = document.getElementById('logosProgressFill');
    const totalLogos   = document.getElementById('totalLogos');

    /* ════ TOAST ════ */
    function showToast(message, type = 'success') {
        document.querySelector('.edit-toast')?.remove();
        const toast = document.createElement('div');
        toast.className = `edit-toast edit-toast--${type}`;
        toast.innerHTML = `
            <span class="edit-toast__icon">
                <i class="fa ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i>
            </span>
            <span class="edit-toast__msg">${message}</span>
        `;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('edit-toast--show'));
        setTimeout(() => {
            toast.classList.remove('edit-toast--show');
            toast.addEventListener('transitionend', () => toast.remove(), { once: true });
        }, 3400);
    }

    /* ════ CONTADOR Y PROGRESO ════ */
    function updateCounter() {
        const count = logosGrid.querySelectorAll('.logo-slot').length;
        const pct   = Math.round((count / MAX_SLOTS) * 100);

        if (logosCounter) logosCounter.textContent = `${count} / ${MAX_SLOTS}`;
        if (progressFill) progressFill.style.width = `${pct}%`;
        if (totalLogos)   totalLogos.value = count;

        const isMax = count >= MAX_SLOTS;
        logosCounter?.classList.toggle('is-max', isMax);
        progressFill?.classList.toggle('is-max', isMax);
        logosAddBar?.classList.toggle('is-max', isMax);
        if (btnAddLogo) btnAddLogo.disabled = isMax;
    }

    /* ════ PREVIEW ════ */
    function setPreview(slotNum, file) {
        const preview = document.getElementById(`preview-${slotNum}`);
        const nameEl  = document.getElementById(`name-${slotNum}`);
        if (!preview || !nameEl) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            preview.innerHTML = `<img src="${e.target.result}" alt="Logo ${slotNum}">`;
            preview.classList.add('has-image');
            nameEl.textContent = file.name;
            nameEl.classList.add('has-file');
        };
        reader.readAsDataURL(file);
    }

    /* ════ LIMPIAR SLOT ════ */
    function clearSlot(slotNum) {
        const preview   = document.getElementById(`preview-${slotNum}`);
        const nameEl    = document.getElementById(`name-${slotNum}`);
        const input     = document.getElementById(`logo_${slotNum}`);
        const eliminar  = document.getElementById(`eliminar_${slotNum}`);
        const btnClear  = document.querySelector(`[data-slot="${slotNum}"].btn-clear`);
        if (!preview || !nameEl || !input) return;

        preview.innerHTML = `
            <div class="logo-slot__empty">
                <i class="fa fa-image"></i>
                <span>Logo ${slotNum}</span>
            </div>
        `;
        preview.classList.remove('has-image');
        nameEl.textContent = 'Sin imagen';
        nameEl.classList.remove('has-file');
        input.value = '';

        if (eliminar && btnClear?.dataset.hasImage === '1') {
            eliminar.value = '1';
            btnClear.dataset.hasImage = '0';
        }
    }

    /* ════ VALIDAR ARCHIVO ════ */
    function validateFile(file) {
        if (file.size > MAX_SIZE_MB * 1024 * 1024) {
            showToast(`El archivo supera el límite de ${MAX_SIZE_MB}MB.`, 'error');
            return false;
        }
        const allowed = ['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'];
        if (!allowed.includes(file.type)) {
            showToast('Formato no permitido. Usa PNG, JPG, SVG o WEBP.', 'error');
            return false;
        }
        return true;
    }

    /* ════ INIT SLOT ════ */
    function initSlot(slot) {
        const slotNum  = slot.dataset.slot || slot.id.replace('slot-', '');
        const preview  = slot.querySelector('.logo-slot__preview');
        const input    = slot.querySelector('.logo-input');
        const btnClear = slot.querySelector('.btn-clear');

        preview?.addEventListener('click', () => input?.click());

        input?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            if (!validateFile(file)) { this.value = ''; return; }
            setPreview(slotNum, file);
            const eliminar = document.getElementById(`eliminar_${slotNum}`);
            if (eliminar) eliminar.value = '0';
        });

        btnClear?.addEventListener('click', () => {
            const hasImageBD = btnClear.dataset.hasImage === '1';
            const hasFileNew = input && input.files && input.files.length > 0;

            if (!hasImageBD && !hasFileNew) {
                // Sin imagen — eliminar slot del DOM
                const slotEl = document.getElementById(`slot-${slotNum}`);
                if (slotEl) {
                    slotEl.style.cssText = 'transition:opacity .25s,transform .25s;opacity:0;transform:translateY(6px);';
                    setTimeout(() => { slotEl.remove(); updateCounter(); }, 250);
                }
            } else {
                // Con imagen — solo limpiar
                clearSlot(slotNum);
            }
        });

        preview?.addEventListener('dragover', (e) => {
            e.preventDefault();
            preview.style.borderColor = 'var(--accent)';
            preview.style.background  = 'var(--accent-light)';
        });

        preview?.addEventListener('dragleave', () => {
            preview.style.borderColor = '';
            preview.style.background  = '';
        });

        preview?.addEventListener('drop', (e) => {
            e.preventDefault();
            preview.style.borderColor = '';
            preview.style.background  = '';
            const file = e.dataTransfer.files[0];
            if (!file) return;
            if (!validateFile(file)) return;
            const dt = new DataTransfer();
            dt.items.add(file);
            if (input) input.files = dt.files;
            setPreview(slotNum, file);
            const eliminar = document.getElementById(`eliminar_${slotNum}`);
            if (eliminar) eliminar.value = '0';
        });
    }

    /* ════ BUILD SLOT NUEVO (id=0) ════ */
    function buildSlot(n) {
        const slot = document.createElement('div');
        slot.className    = 'logo-slot';
        slot.id           = `slot-${n}`;
        slot.dataset.slot = n;
        slot.style.cssText = 'opacity:0;transform:translateY(8px);';
        slot.innerHTML = `
            <input type="hidden" name="id_logo_${n}" class="logo-id-input" value="0">
            <input type="hidden" name="eliminar_logo_${n}" id="eliminar_${n}" value="0">
            <div class="logo-slot__preview" id="preview-${n}">
                <div class="logo-slot__empty">
                    <i class="fa fa-image"></i>
                    <span>Logo ${n}</span>
                </div>
            </div>
            <div class="logo-slot__actions">
                <label class="btn-upload" for="logo_${n}">
                    <i class="fa fa-arrow-up-from-bracket"></i>
                    Subir
                </label>
                <input type="file"
                       id="logo_${n}"
                       name="logo_${n}"
                       accept="image/png,image/jpeg,image/svg+xml,image/webp"
                       class="logo-input"
                       data-slot="${n}"
                       style="display:none;">
                <button type="button" class="btn-clear" data-slot="${n}" data-has-image="0" title="Quitar imagen">
                    <i class="fa fa-xmark"></i>
                </button>
            </div>
            <div class="logo-slot__name" id="name-${n}">Sin imagen</div>
        `;
        return slot;
    }

    /* ════ AGREGAR LOGO ════ */
    btnAddLogo?.addEventListener('click', () => {
        const current = logosGrid.querySelectorAll('.logo-slot').length;
        if (current >= MAX_SLOTS) {
            showToast(`Máximo de ${MAX_SLOTS} logos alcanzado.`, 'error');
            return;
        }
        const n    = current + 1;
        const slot = buildSlot(n);
        logosGrid.appendChild(slot);
        requestAnimationFrame(() => {
            slot.style.cssText = 'transition:opacity .3s,transform .3s;opacity:1;transform:translateY(0);';
        });
        initSlot(slot);
        updateCounter();
        setTimeout(() => slot.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 80);
        if (n >= MAX_SLOTS) showToast(`Has alcanzado el máximo de ${MAX_SLOTS} logos.`, 'error');
    });

    /* ════ VALIDACIÓN ════ */
    function validateForm(form) {
        const titulo = document.getElementById('titulo_aliados');
        if (titulo && !titulo.value.trim()) {
            titulo.classList.add('field--error');
            titulo.focus();
            titulo.addEventListener('input', () => titulo.classList.remove('field--error'), { once: true });
            return false;
        }
        return true;
    }

    /* ════ SUBMIT ════ */
    const form = document.getElementById('allies-edit-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            if (!validateForm(form)) {
                e.preventDefault();
                showToast('Por favor completa el título de la sección.', 'error');
            }
        });
    }

    /* ════ INIT ════ */
    logosGrid?.querySelectorAll('.logo-slot').forEach(slot => initSlot(slot));
    updateCounter();

    // ── Toast automático desde mensajes del servidor ──
    const flashSuccess = document.getElementById('flash-success');
    const flashError   = document.getElementById('flash-error');
    if (flashSuccess) showToast(flashSuccess.dataset.msg, 'success');
    if (flashError)   showToast(flashError.dataset.msg,   'error');

})();