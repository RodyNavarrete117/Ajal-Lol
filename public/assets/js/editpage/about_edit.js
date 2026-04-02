/* ==================== about_edit.js ==================== */
(function () {
    'use strict';

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
        }, 3200);
    }

    /* ── Preview de imagen de historia ─────────────────── */
    const fileInput  = document.getElementById('imagen_historia');
    const previewEl  = document.getElementById('histImgPreview');
    const btnClear   = document.getElementById('btnClearHist');
    const uploadArea = document.getElementById('histImgArea');

    function renderPreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewEl.innerHTML = `<img src="${e.target.result}" alt="Vista previa">`;
        };
        reader.readAsDataURL(file);
    }

    function clearPreview() {
        previewEl.innerHTML = `
            <div class="image-upload-area__empty">
                <i class="fa fa-image"></i>
                <span>Haz clic o arrastra una imagen aquí</span>
                <small>PNG, JPG, WEBP · Máx. 5MB</small>
            </div>`;
        if (fileInput) fileInput.value = '';
    }

    // Click en el área preview → abre selector
    previewEl?.addEventListener('click', () => fileInput?.click());

    // Cambio de archivo
    fileInput?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 5 * 1024 * 1024) {
            showToast('La imagen supera el límite de 5MB.', 'error');
            this.value = '';
            return;
        }

        const allowed = ['image/png', 'image/jpeg', 'image/webp'];
        if (!allowed.includes(file.type)) {
            showToast('Formato no permitido. Usa PNG, JPG o WEBP.', 'error');
            this.value = '';
            return;
        }

        renderPreview(file);
    });

    // Botón quitar
    btnClear?.addEventListener('click', clearPreview);

    // Drag & Drop
    uploadArea?.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('drag-over');
    });

    uploadArea?.addEventListener('dragleave', () => {
        uploadArea.classList.remove('drag-over');
    });

    uploadArea?.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
        const file = e.dataTransfer.files[0];
        if (!file) return;

        if (file.size > 5 * 1024 * 1024) { showToast('La imagen supera el límite de 5MB.', 'error'); return; }
        const allowed = ['image/png', 'image/jpeg', 'image/webp'];
        if (!allowed.includes(file.type)) { showToast('Formato no permitido.', 'error'); return; }

        const dt = new DataTransfer();
        dt.items.add(file);
        if (fileInput) fileInput.files = dt.files;
        renderPreview(file);
    });

    /* ── Validación ──────────────────────────────────────── */
    function validateForm(form) {
        let valid = true;

        form.querySelectorAll('input[required], textarea[required]').forEach(field => {
            clearError(field);
            if (!field.value.trim()) {
                markError(field, 'Este campo es obligatorio.');
                valid = false;
            }
        });

        return valid;
    }

    function markError(field, msg) {
        field.classList.add('field--error');
        const err = document.createElement('span');
        err.className = 'field-error-msg';
        err.textContent = msg;
        field.insertAdjacentElement('afterend', err);
        field.addEventListener('input', () => clearError(field), { once: true });
    }

    function clearError(field) {
        field.classList.remove('field--error');
        field.parentElement.querySelector('.field-error-msg')?.remove();
    }

    /* ── Submit ──────────────────────────────────────────── */
    const form = document.querySelector('.edit-container form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!validateForm(form)) {
            showToast('Por favor completa los campos obligatorios.', 'error');
            form.querySelector('.field--error')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        showToast('Cambios guardados correctamente.', 'success');
        /* TODO: reemplazar con fetch/axios o form.submit() */
    });

})();