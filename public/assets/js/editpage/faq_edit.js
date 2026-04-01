/* ==================== aliados_edit.js ==================== */
(function () {
    'use strict';

    const MAX_SIZE_MB = 2;

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

    /* ── Preview de imagen ──────────────────────────────── */
    function setPreview(slotNum, file) {
        const preview  = document.getElementById(`preview-${slotNum}`);
        const nameEl   = document.getElementById(`name-${slotNum}`);
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

    /* ── Hacer clic en preview abre el file input ───────── */
    document.querySelectorAll('.logo-slot__preview').forEach(preview => {
        preview.addEventListener('click', () => {
            const slot  = preview.id.replace('preview-', '');
            const input = document.getElementById(`logo_${slot}`);
            if (input) input.click();
        });
    });

    /* ── File inputs: validar y mostrar preview ─────────── */
    document.querySelectorAll('.logo-input').forEach(input => {
        input.addEventListener('change', function () {
            const slot = this.dataset.slot;
            const file = this.files[0];
            if (!file) return;

            if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                showToast(`El archivo supera el límite de ${MAX_SIZE_MB}MB.`, 'error');
                this.value = '';
                return;
            }

            const allowed = ['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'];
            if (!allowed.includes(file.type)) {
                showToast('Formato no permitido. Usa PNG, JPG, SVG o WEBP.', 'error');
                this.value = '';
                return;
            }

            setPreview(slot, file);
        });
    });

    /* ── Botones de limpiar ─────────────────────────────── */
    document.querySelectorAll('.btn-clear').forEach(btn => {
        btn.addEventListener('click', function () {
            clearSlot(this.dataset.slot);
        });
    });

    /* ── Drag & Drop sobre cada slot ────────────────────── */
    document.querySelectorAll('.logo-slot__preview').forEach(preview => {
        preview.addEventListener('dragover', (e) => {
            e.preventDefault();
            preview.style.borderColor = 'var(--accent)';
            preview.style.background  = 'var(--accent-light)';
        });

        preview.addEventListener('dragleave', () => {
            preview.style.borderColor = '';
            preview.style.background  = '';
        });

        preview.addEventListener('drop', (e) => {
            e.preventDefault();
            preview.style.borderColor = '';
            preview.style.background  = '';

            const slot = preview.id.replace('preview-', '');
            const file = e.dataTransfer.files[0];
            if (!file) return;

            if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                showToast(`El archivo supera el límite de ${MAX_SIZE_MB}MB.`, 'error');
                return;
            }

            const allowed = ['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'];
            if (!allowed.includes(file.type)) {
                showToast('Formato no permitido. Usa PNG, JPG, SVG o WEBP.', 'error');
                return;
            }

            // Asignar al input correspondiente y mostrar preview
            const input  = document.getElementById(`logo_${slot}`);
            const dt     = new DataTransfer();
            dt.items.add(file);
            if (input) input.files = dt.files;
            setPreview(slot, file);
        });
    });

    /* ── Validación y submit ────────────────────────────── */
    const form = document.querySelector('.edit-container form');
    if (!form) return;

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
        /* TODO: reemplazar con fetch/axios al conectar la BD */
        // form.submit();
    });

})();