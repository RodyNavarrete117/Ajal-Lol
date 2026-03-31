/* ==================== ALLIES EDIT — JS ==================== */
/*
 * Tabla `aliados`:
 *   id_aliados   → auto (no se envía en creación)
 *   id_pagina    → campo oculto en el form (value="1")
 *   img_aliados  → archivo de imagen
 *   nombre       → nombre del aliado
 *   url          → sitio web
 *   activo       → 1 = visible, 0 = oculto
 */
(function () {
    'use strict';

    /* ── Referencias DOM ───────────────────────────────── */
    const dropzone  = document.getElementById('dropzone');
    const fileInput = document.getElementById('ally-file-input');
    const grid      = document.getElementById('allies-grid');
    const emptyMsg  = document.getElementById('allies-empty');
    const counter   = document.getElementById('ally-counter');
    const form      = document.getElementById('allies-form');

    if (!dropzone || !grid || !form) return;

    /* ── Estado ────────────────────────────────────────── */
    /*
     * Cada objeto representa una fila futura en `aliados`:
     * {
     *   id          : número local (no es id_aliados de BD)
     *   file        : File object
     *   previewUrl  : blob URL para mostrar la imagen
     *   img_aliados : nombre que tendrá en servidor (de momento = file.name)
     *   nombre      : nombre del aliado
     *   url         : sitio web
     *   activo      : 1 | 0
     * }
     */
    let allies = [];
    let idCounter = 0;

    /* ── Utilidades ────────────────────────────────────── */
    function updateCounter() {
        if (!counter) return;
        counter.textContent = `${allies.length} registro${allies.length !== 1 ? 's' : ''}`;
    }

    function updateEmpty() {
        emptyMsg.classList.toggle('hidden', allies.length > 0);
        updateCounter();
    }

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

    /* ── Crear tarjeta (una fila de `aliados`) ─────────── */
    function createCard(ally) {
        const card = document.createElement('div');
        card.className = 'ally-card';
        card.dataset.id = ally.id;

        card.innerHTML = `
            <div class="ally-card__img-wrap">
                <img src="${ally.previewUrl}" alt="${ally.nombre || 'Aliado'}">
            </div>

            {{-- ── Campo: nombre ── --}}
            <div class="ally-card__field">
                <input
                    type="text"
                    name="nombre[${ally.id}]"
                    value="${ally.nombre}"
                    placeholder="Nombre..."
                    maxlength="120"
                    title="nombre"
                >
            </div>

            {{-- ── Campo: url ── --}}
            <div class="ally-card__field ally-card__field--url">
                <i class="fa fa-link"></i>
                <input
                    type="url"
                    name="url[${ally.id}]"
                    value="${ally.url}"
                    placeholder="https://sitio.org"
                    title="url"
                >
            </div>

            {{-- ── Campo: activo (toggle) ── --}}
            <div class="ally-card__footer">
                <label class="toggle" title="activo">
                    <input
                        type="checkbox"
                        name="activo[${ally.id}]"
                        value="1"
                        ${ally.activo ? 'checked' : ''}
                        class="toggle-input"
                    >
                    <span class="toggle-track">
                        <span class="toggle-thumb"></span>
                    </span>
                    <span class="toggle-label">Visible</span>
                </label>

                <button type="button" class="ally-card__remove" title="Eliminar" data-id="${ally.id}">
                    <i class="fa fa-trash"></i>
                </button>
            </div>

            {{-- ── Campo oculto: img_aliados ── --}}
            <input type="hidden" name="img_aliados[${ally.id}]" value="${ally.img_aliados}">
        `;

        /* Toggle label dinámico */
        const checkbox = card.querySelector('.toggle-input');
        const label    = card.querySelector('.toggle-label');
        checkbox.addEventListener('change', () => {
            label.textContent = checkbox.checked ? 'Visible' : 'Oculto';
            const a = allies.find(a => a.id === ally.id);
            if (a) a.activo = checkbox.checked ? 1 : 0;
        });

        /* Eliminar */
        card.querySelector('.ally-card__remove').addEventListener('click', () => {
            removeAlly(ally.id);
        });

        return card;
    }

    /* ── Agregar desde archivos ─────────────────────────── */
    function addFiles(files) {
        const allowed = ['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'];
        let added = 0;

        Array.from(files).forEach(file => {
            if (!allowed.includes(file.type)) return;

            const id         = ++idCounter;
            const previewUrl = URL.createObjectURL(file);
            const nombre     = file.name.replace(/\.[^.]+$/, '').replace(/[-_]/g, ' ');

            const ally = {
                id,
                file,
                previewUrl,
                img_aliados : file.name, // el servidor renombrará al guardar
                nombre,
                url    : '',
                activo : 1,
            };

            allies.push(ally);
            grid.appendChild(createCard(ally));
            added++;
        });

        updateEmpty();

        if (added > 0) {
            showToast(`${added} aliado${added > 1 ? 's' : ''} agregado${added > 1 ? 's' : ''}.`);
        }
    }

    /* ── Eliminar aliado ────────────────────────────────── */
    function removeAlly(id) {
        allies = allies.filter(a => a.id !== id);
        const card = grid.querySelector(`[data-id="${id}"]`);
        if (card) {
            card.style.cssText = 'transform:scale(0.85);opacity:0;transition:transform .22s ease,opacity .22s ease;';
            setTimeout(() => card.remove(), 230);
        }
        setTimeout(updateEmpty, 240);
    }

    /* ── Drag & Drop ────────────────────────────────────── */
    dropzone.addEventListener('dragover',  e => { e.preventDefault(); dropzone.classList.add('dragover'); });
    dropzone.addEventListener('dragleave', e => { if (!dropzone.contains(e.relatedTarget)) dropzone.classList.remove('dragover'); });
    dropzone.addEventListener('drop', e => { e.preventDefault(); dropzone.classList.remove('dragover'); addFiles(e.dataTransfer.files); });

    fileInput.addEventListener('change', () => { addFiles(fileInput.files); fileInput.value = ''; });

    /* ── Validación y submit ────────────────────────────── */
    form.addEventListener('submit', e => {
        e.preventDefault();

        const titulo = document.getElementById('titulo_seccion');
        if (!titulo.value.trim()) {
            titulo.classList.add('field--error');
            titulo.addEventListener('input', () => titulo.classList.remove('field--error'), { once: true });
            showToast('El título de la sección es obligatorio.', 'error');
            return;
        }

        /*
         * TODO: cuando se conecte la BD, construir un FormData aquí:
         *
         * const fd = new FormData(form);
         * allies.forEach(a => fd.append(`files[${a.id}]`, a.file));
         * fetch('/admin/pages/allies/update', { method:'POST', body: fd })
         *   .then(r => r.json())
         *   .then(() => showToast('Cambios guardados.'));
         */

        showToast('Cambios guardados correctamente.');
    });

    /* ── Estilos JS ─────────────────────────────────────── */
    if (!document.getElementById('allies-js-styles')) {
        const style = document.createElement('style');
        style.id = 'allies-js-styles';
        style.textContent = `
            .edit-toast {
                position:fixed; bottom:28px; right:28px;
                display:flex; align-items:center; gap:10px;
                padding:13px 20px; border-radius:12px;
                font-size:14px; font-weight:500; color:#fff;
                box-shadow:0 8px 28px rgba(0,0,0,.18);
                opacity:0; transform:translateY(14px);
                transition:opacity .3s ease,transform .3s ease;
                z-index:9999; pointer-events:none;
            }
            .edit-toast--show    { opacity:1; transform:translateY(0); }
            .edit-toast--success { background:#2d7d46; }
            .edit-toast--error   { background:#c0392b; }
            .edit-toast__icon    { font-size:16px; }
            .field--error {
                border-color:#c0392b !important;
                box-shadow:0 0 0 3px rgba(192,57,43,.15) !important;
            }
        `;
        document.head.appendChild(style);
    }

    /* ── Init ───────────────────────────────────────────── */
    updateEmpty();

})();