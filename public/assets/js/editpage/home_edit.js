/* ==================== HOME EDIT — JS ====================
   Ruta: assets/js/editpage/home_edit.js
   ========================================================= */
(function () {
    'use strict';

    const MAX_VIDEOS = 10;

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

    /* ── Tabs ─────────────────────────────────────────── */
    const tabs   = document.querySelectorAll('.edit-tab');
    const panels = document.querySelectorAll('.edit-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.target;
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            const panel = document.getElementById('panel-' + target);
            if (panel) panel.classList.add('active');
        });
    });

    /* ── Extraer ID de YouTube desde URL o ID directo ── */
    function extractYouTubeId(input) {
        input = input.trim();
        // Si ya es un ID de 11 caracteres
        if (/^[a-zA-Z0-9_-]{11}$/.test(input)) return input;

        try {
            const url = new URL(input);
            // youtube.com/watch?v=ID
            if (url.searchParams.get('v')) return url.searchParams.get('v');
            // youtu.be/ID
            if (url.hostname === 'youtu.be') return url.pathname.slice(1).split('?')[0];
            // youtube.com/embed/ID
            const embedMatch = url.pathname.match(/\/embed\/([a-zA-Z0-9_-]{11})/);
            if (embedMatch) return embedMatch[1];
        } catch {}

        return null;
    }

    /* ── Actualizar miniatura de un video ── */
    function updateThumb(thumbEl, videoId) {
        if (!thumbEl) return;
        const img = thumbEl.querySelector('img');
        if (!img) return;

        if (videoId) {
            img.src = `https://img.youtube.com/vi/${videoId}/mqdefault.jpg`;
            img.style.opacity = '1';
        } else {
            img.src = '';
            img.style.opacity = '0';
        }
    }

    /* ── Inicializar eventos de una fila de video ── */
    function initVideoRow(row) {
        const idInput    = row.querySelector('.vid-id-input');
        const thumbId    = idInput?.dataset.thumb;
        const thumbEl    = thumbId ? document.getElementById(thumbId) : null;
        const btnRemove  = row.querySelector('.btn-remove-video');

        // Actualizar miniatura cuando cambia el ID/URL
        let debounce;
        idInput?.addEventListener('input', () => {
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                const ytId = extractYouTubeId(idInput.value);
                // Guardar el ID limpio en el input si es válido
                if (ytId) idInput.dataset.ytid = ytId;
                updateThumb(thumbEl, ytId);
            }, 500);
        });

        // Eliminar fila
        btnRemove?.addEventListener('click', () => {
            if (document.querySelectorAll('.video-row').length <= 1) {
                showToast('Debe haber al menos un video.', 'error');
                return;
            }
            row.style.transition = 'opacity .2s ease, transform .2s ease';
            row.style.opacity    = '0';
            row.style.transform  = 'translateY(-6px)';
            setTimeout(() => {
                row.remove();
                renumberVideos();
                updateVideoAddBar();
            }, 220);
        });
    }

    /* ── Renumerar filas de video ── */
    function renumberVideos() {
        document.querySelectorAll('.video-row').forEach((row, i) => {
            const n = i + 1;
            row.id = `video-row-${n}`;
            const numEl = row.querySelector('.video-row__num');
            if (numEl) numEl.textContent = n;

            // Actualizar IDs y nombres de inputs
            row.querySelectorAll('input').forEach(inp => {
                if (inp.name?.startsWith('vid_titulo_')) {
                    inp.name = `vid_titulo_${n}`;
                    inp.id   = `vid_titulo_${n}`;
                }
                if (inp.name?.startsWith('vid_id_')) {
                    inp.name = `vid_id_${n}`;
                    inp.id   = `vid_id_${n}`;
                }
            });

            // Actualizar ref del thumb
            const thumbEl = row.querySelector('.video-row__thumb');
            if (thumbEl) thumbEl.id = `vthumb-${n}`;
            const idInput = row.querySelector('.vid-id-input');
            if (idInput) idInput.dataset.thumb = `vthumb-${n}`;

            const btnRemove = row.querySelector('.btn-remove-video');
            if (btnRemove) btnRemove.dataset.row = n;
        });
    }

    /* ── Actualizar estado del botón agregar ── */
    function updateVideoAddBar() {
        const count = document.querySelectorAll('.video-row').length;
        const bar   = document.getElementById('videoAddBar');
        const btn   = document.getElementById('btnAddVideo');
        if (!bar || !btn) return;
        const isMax = count >= MAX_VIDEOS;
        bar.classList.toggle('is-max', isMax);
        btn.disabled = isMax;
    }

    /* ── Construir fila de video nueva ── */
    function buildVideoRow(n) {
        const row = document.createElement('div');
        row.className  = 'video-row';
        row.id         = `video-row-${n}`;
        row.innerHTML  = `
            <div class="video-row__num">${n}</div>
            <div class="video-row__thumb" id="vthumb-${n}">
                <img src="" alt="Miniatura" loading="lazy" style="opacity:0">
                <span class="video-row__play"><i class="fa fa-play"></i></span>
            </div>
            <div class="video-row__fields">
                <div class="form-group">
                    <label for="vid_titulo_${n}">Título del video</label>
                    <input
                        type="text"
                        id="vid_titulo_${n}"
                        name="vid_titulo_${n}"
                        placeholder="Ej: Nuestra historia"
                        class="vid-title-input"
                    >
                </div>
                <div class="form-group">
                    <label for="vid_id_${n}">ID o URL de YouTube</label>
                    <input
                        type="text"
                        id="vid_id_${n}"
                        name="vid_id_${n}"
                        placeholder="Ej: lRM7kJdDUM4 o https://youtube.com/..."
                        class="vid-id-input"
                        data-thumb="vthumb-${n}"
                    >
                    <span class="field-hint">Pega el ID del video o la URL completa de YouTube.</span>
                </div>
            </div>
            <button type="button" class="btn-remove-video" data-row="${n}" title="Eliminar video">
                <i class="fa fa-xmark"></i>
            </button>
        `;
        return row;
    }

    /* ── Botón agregar video ── */
    document.getElementById('btnAddVideo')?.addEventListener('click', () => {
        const count = document.querySelectorAll('.video-row').length;
        if (count >= MAX_VIDEOS) {
            showToast(`Máximo de ${MAX_VIDEOS} videos alcanzado.`, 'error');
            return;
        }

        const n   = count + 1;
        const row = buildVideoRow(n);
        document.getElementById('videosList').appendChild(row);

        requestAnimationFrame(() => {
            row.style.opacity   = '1';
            row.style.transform = 'translateY(0)';
        });

        initVideoRow(row);
        updateVideoAddBar();

        setTimeout(() => row.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 80);
    });

    /* ── Validación ── */
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
        field.parentElement?.querySelector('.field-error-msg')?.remove();
    }

    /* ── Submit ── */
    const form = document.querySelector('.edit-container form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!validateForm(form)) {
                showToast('Por favor completa los campos obligatorios.', 'error');

                const errorField = form.querySelector('.field--error');
                if (errorField) {
                    const panel = errorField.closest('.edit-panel');
                    if (panel && !panel.classList.contains('active')) {
                        const panelId = panel.id.replace('panel-', '');
                        const tab = document.querySelector(`.edit-tab[data-target="${panelId}"]`);
                        if (tab) tab.click();
                    }
                    setTimeout(() => errorField.scrollIntoView({ behavior: 'smooth', block: 'center' }), 100);
                }
                return;
            }

            showToast('Cambios guardados correctamente.', 'success');
            /* TODO: reemplazar con fetch/axios o form.submit() */
        });
    }

    /* ── Init ── */
    document.querySelectorAll('.video-row').forEach(row => initVideoRow(row));
    updateVideoAddBar();

})();