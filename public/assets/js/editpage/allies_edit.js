/* ==================== allies_edit.js ==================== */
(function () {
    'use strict';

    const MAX_SIZE_MB = 2;
    const MAX_SLOTS   = 18;

    /* ── Referencias DOM ── */
    const logosGrid       = document.getElementById('logosGrid');
    const btnAddLogo      = document.getElementById('btnAddLogo');
    const logosAddBar     = document.getElementById('logosAddBar');
    const logosCounter    = document.getElementById('logosCounter');
    const progressFill    = document.getElementById('logosProgressFill');

    /* ── Toast ─────────────────────────────────────────── */
    function showToast(message, type = 'success') {
        const existing = document.querySelector('.edit-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = `edit-toast edit-toast--${type}`;
        toast.innerHTML = `
            <span class="edit-toast__icon">
                ${type === 'success'
                    ? '<i class="fa fa-circle-check"></i>'
                    : '<i class="fa fa-circle-exclamation"></i>'}
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

    /* ── Actualizar contador y barra de progreso ── */
    function updateCounter() {
        const count = logosGrid.querySelectorAll('.logo-slot').length;
        const pct   = Math.round((count / MAX_SLOTS) * 100);

        logosCounter.textContent = `${count} / ${MAX_SLOTS}`;
        progressFill.style.width = `${pct}%`;

        const isMax = count >= MAX_SLOTS;
        logosCounter.classList.toggle('is-max', isMax);
        progressFill.classList.toggle('is-max', isMax);
        logosAddBar.classList.toggle('is-max', isMax);
        btnAddLogo.disabled = isMax;
    }

    /* ── Preview de imagen ──────────────────────────────── */
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

    function clearSlot(slotNum) {
        const preview = document.getElementById(`preview-${slotNum}`);
        const nameEl  = document.getElementById(`name-${slotNum}`);
        const input   = document.getElementById(`logo_${slotNum}`);
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
    }

    /* ── Validar archivo ── */
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

    /* ── Inicializar eventos de un slot ── */
    function initSlot(slot) {
        const slotNum = slot.dataset.slot || slot.id.replace('slot-', '');

        const preview = slot.querySelector('.logo-slot__preview');
        const input   = slot.querySelector('.logo-input');
        const btnClear= slot.querySelector('.btn-clear');

        // Click en preview → abrir file picker
        preview?.addEventListener('click', () => input?.click());

        // Cambio de archivo
        input?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            if (!validateFile(file)) { this.value = ''; return; }
            setPreview(slotNum, file);
        });

        // Botón limpiar
        btnClear?.addEventListener('click', () => clearSlot(slotNum));

        // Drag & Drop
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
        });
    }

    /* ── Construir un slot nuevo ── */
    function buildSlot(n) {
        const slot = document.createElement('div');
        slot.className = 'logo-slot';
        slot.id = `slot-${n}`;
        slot.dataset.slot = n;
        slot.innerHTML = `
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
                <input
                    type="file"
                    id="logo_${n}"
                    name="logo_${n}"
                    accept="image/png,image/jpeg,image/svg+xml,image/webp"
                    class="logo-input"
                    data-slot="${n}"
                    style="display:none;"
                >
                <button type="button" class="btn-clear" data-slot="${n}" title="Quitar imagen">
                    <i class="fa fa-xmark"></i>
                </button>
            </div>
            <div class="logo-slot__name" id="name-${n}">Sin imagen</div>
        `;
        return slot;
    }

    /* ── Botón agregar logo ── */
    btnAddLogo?.addEventListener('click', () => {
        const current = logosGrid.querySelectorAll('.logo-slot').length;
        if (current >= MAX_SLOTS) {
            showToast(`Máximo de ${MAX_SLOTS} logos alcanzado.`, 'error');
            return;
        }

        const n    = current + 1;
        const slot = buildSlot(n);
        logosGrid.appendChild(slot);

        // Animación de entrada
        requestAnimationFrame(() => {
            slot.style.opacity   = '1';
            slot.style.transform = 'translateY(0)';
        });

        initSlot(slot);
        updateCounter();

        // Scroll suave al nuevo slot
        setTimeout(() => slot.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 80);

        if (n >= MAX_SLOTS) {
            showToast(`Has alcanzado el máximo de ${MAX_SLOTS} logos.`, 'error');
        }
    });

    /* ── Validación y submit ── */
    const form = document.querySelector('.edit-container form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const titulo = document.getElementById('titulo_aliados');
            if (titulo && !titulo.value.trim()) {
                titulo.classList.add('field--error');
                titulo.focus();
                showToast('Por favor completa el título de la sección.', 'error');
                titulo.addEventListener('input', () => titulo.classList.remove('field--error'), { once: true });
                return;
            }

            showToast('Cambios guardados correctamente.', 'success');
            /* TODO: reemplazar con fetch/axios o form.submit() */
        });
    }

    /* ── Init slots existentes ── */
    logosGrid?.querySelectorAll('.logo-slot').forEach(slot => initSlot(slot));
    updateCounter();

})();