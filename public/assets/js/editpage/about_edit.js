/* ==================== about_edit.js ==================== */
(function () {
    'use strict';

    const ROUTES = window.ABOUT_ROUTES ?? {};
    const CSRF   = ROUTES.csrfToken ?? document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    /* ── helpers fetch ── */
    async function apiFetch(url, body) {
        const isJson = !(body instanceof FormData);
        const res = await fetch(url, {
            method : 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept'      : 'application/json',
                ...(isJson ? { 'Content-Type': 'application/json' } : {}),
            },
            body: isJson ? JSON.stringify(body) : body,
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message ?? 'Error en la solicitud.');
        return data;
    }

    /* ── Toast ── */
    function showToast(message, type = 'success') {
        document.querySelector('.edit-toast')?.remove();
        const toast = document.createElement('div');
        toast.className = `edit-toast edit-toast--${type}`;
        toast.innerHTML = `
            <span class="edit-toast__icon">
                <i class="fa ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i>
            </span>
            <span class="edit-toast__msg">${message}</span>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('edit-toast--show'));
        setTimeout(() => {
            toast.classList.remove('edit-toast--show');
            toast.addEventListener('transitionend', () => toast.remove(), { once: true });
        }, 3200);
    }

    /* ── Tabs ── */
    document.querySelectorAll('.edit-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.edit-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.edit-panel').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            const panel = document.getElementById('panel-' + tab.dataset.target);
            if (panel) panel.classList.add('active');
        });
    });

    /* ── Preview imagen historia ── */
    const fileInput   = document.getElementById('imagen_historia');
    const previewEl   = document.getElementById('histImgPreview');
    const btnClear    = document.getElementById('btnClearHist');
    const uploadArea  = document.getElementById('histImgArea');
    const quitarInput = document.getElementById('quitar_imagen');

    function renderPreview(file) {
        const reader = new FileReader();
        reader.onload = e => {
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
        if (quitarInput) quitarInput.value = '1';
    }

    previewEl?.addEventListener('click', () => fileInput?.click());

    fileInput?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        if (file.size > 5 * 1024 * 1024) { showToast('La imagen supera el límite de 5MB.', 'error'); this.value = ''; return; }
        const allowed = ['image/png', 'image/jpeg', 'image/webp'];
        if (!allowed.includes(file.type)) { showToast('Formato no permitido. Usa PNG, JPG o WEBP.', 'error'); this.value = ''; return; }
        if (quitarInput) quitarInput.value = '0';
        renderPreview(file);
    });

    btnClear?.addEventListener('click', clearPreview);

    uploadArea?.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('drag-over'); });
    uploadArea?.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
    uploadArea?.addEventListener('drop', e => {
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
        if (quitarInput) quitarInput.value = '0';
        renderPreview(file);
    });

    /* ── Acordeón identidad ── */
    document.querySelectorAll('.identity-card__toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const card = btn.closest('.identity-card');
            const isCollapsed = card.dataset.collapsed === 'true';
            card.dataset.collapsed = isCollapsed ? 'false' : 'true';
        });
    });

    /* ── Guardar Encabezado ── */
    document.getElementById('btnSaveEncabezado')?.addEventListener('click', async () => {
        const titulo    = document.getElementById('titulo_pagina')?.value.trim();
        const subtitulo = document.getElementById('subtitulo_pagina')?.value.trim();
        try {
            const data = await apiFetch(ROUTES.encabezado, { titulo, subtitulo });
            showToast(data.message ?? 'Encabezado guardado.', 'success');
        } catch (err) {
            showToast(err.message ?? 'Error al guardar.', 'error');
        }
    });

    /* ── Guardar Historia ── */
    document.getElementById('btnSaveHistoria')?.addEventListener('click', async () => {
        const formData = new FormData();
        formData.append('badge_texto',        document.getElementById('badge_imagen')?.value.trim() ?? '');
        formData.append('etiqueta_superior',   document.getElementById('eyebrow_historia')?.value.trim() ?? '');
        formData.append('titulo_bloque',       document.getElementById('titulo_historia')?.value.trim() ?? '');
        formData.append('texto_destacado',     document.getElementById('texto_destacado')?.value.trim() ?? '');
        formData.append('texto_descriptivo',   document.getElementById('texto_descripcion')?.value.trim() ?? '');
        formData.append('quitar_imagen',       document.getElementById('quitar_imagen')?.value ?? '0');
        formData.append('_token',              CSRF);
        const file = fileInput?.files[0];
        if (file) formData.append('imagen_historia', file);
        try {
            const data = await apiFetch(ROUTES.historia, formData);
            showToast(data.message ?? 'Historia guardada.', 'success');
        } catch (err) {
            showToast(err.message ?? 'Error al guardar.', 'error');
        }
    });

    /* ── Guardar Identidad ── */
    document.getElementById('btnSaveIdentidad')?.addEventListener('click', async () => {
        const payload = {
            identidad_titulo    : document.getElementById('identidad_titulo')?.value.trim(),
            identidad_subtitulo : document.getElementById('identidad_subtitulo')?.value.trim(),
            titulo_mision       : document.getElementById('titulo_mision')?.value.trim(),
            mision              : document.getElementById('mision')?.value.trim(),
            titulo_vision       : document.getElementById('titulo_vision')?.value.trim(),
            vision              : document.getElementById('vision')?.value.trim(),
            titulo_objetivo     : document.getElementById('titulo_objetivo')?.value.trim(),
            objetivo_general    : document.getElementById('objetivo_general')?.value.trim(),
            titulo_valores      : document.getElementById('titulo_valores')?.value.trim(),
            valores             : document.getElementById('valores')?.value.trim(),
        };
        try {
            const data = await apiFetch(ROUTES.identidad, payload);
            showToast(data.message ?? 'Identidad guardada.', 'success');
        } catch (err) {
            showToast(err.message ?? 'Error al guardar.', 'error');
        }
    });

})();