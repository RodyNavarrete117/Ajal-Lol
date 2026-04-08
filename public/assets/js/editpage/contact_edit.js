/* ==================== contact_edit.js ==================== */
(function () {
    'use strict';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

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

    /* ── Validación ─────────────────────────────────────── */
    function validateForm(form) {
        let valid = true;

        form.querySelectorAll('input[required], textarea[required]').forEach(field => {
            clearError(field);
            if (!field.value.trim()) {
                markError(field, 'Este campo es obligatorio.');
                valid = false;
            }
        });

        const correo = form.querySelector('#correo');
        if (correo && correo.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo.value.trim())) {
            markError(correo, 'Ingresa un correo electrónico válido.');
            valid = false;
        }

        ['facebook', 'instagram', 'linkedin'].forEach(red => {
            const input = form.querySelector(`#${red}`);
            if (input && input.value.trim()) {
                try {
                    new URL(input.value.trim());
                } catch {
                    markError(input, 'Ingresa una URL válida (debe iniciar con https://).');
                    valid = false;
                }
            }
        });

        return valid;
    }

    function markError(field, msg) {
        clearError(field);
        field.classList.add('field--error');
        const err = document.createElement('span');
        err.className   = 'field-error-msg';
        err.textContent = msg;
        field.insertAdjacentElement('afterend', err);
        field.addEventListener('input', () => clearError(field), { once: true });
    }

    function clearError(field) {
        field.classList.remove('field--error');
        const msg = field.parentElement?.querySelector('.field-error-msg');
        if (msg) msg.remove();
    }

    /* ── Vista previa del mapa embed ─────────────────────── */
    const mapaInput = document.getElementById('mapa_embed');
    const mapEmpty  = document.getElementById('mapEmpty');
    const mapFrame  = document.getElementById('mapFrame');

    function updateMapPreview() {
        const val = mapaInput?.value.trim();
        if (!val) {
            if (mapEmpty) mapEmpty.style.display = 'flex';
            if (mapFrame) { mapFrame.style.display = 'none'; mapFrame.innerHTML = ''; }
            return;
        }

        const tmp = document.createElement('div');
        tmp.innerHTML = val;
        const iframe = tmp.querySelector('iframe');

        if (iframe) {
            iframe.style.width   = '100%';
            iframe.style.height  = '340px';
            iframe.style.border  = 'none';
            iframe.style.display = 'block';
            iframe.setAttribute('loading', 'lazy');
            iframe.removeAttribute('width');
            iframe.removeAttribute('height');

            if (mapFrame) {
                mapFrame.innerHTML = '';
                mapFrame.appendChild(iframe);
                mapFrame.style.display = 'block';
            }
            if (mapEmpty) mapEmpty.style.display = 'none';
        } else {
            if (mapEmpty) mapEmpty.style.display = 'flex';
            if (mapFrame) { mapFrame.style.display = 'none'; mapFrame.innerHTML = ''; }
        }
    }

    let mapDebounce;
    mapaInput?.addEventListener('input', () => {
        clearTimeout(mapDebounce);
        mapDebounce = setTimeout(updateMapPreview, 600);
    });

    updateMapPreview();

    /* ── Contador de caracteres en dirección ─────────────── */
    const direccion = document.getElementById('direccion');
    if (direccion) {
        const counter = document.createElement('span');
        counter.className   = 'field-hint';
        counter.style.textAlign = 'right';
        counter.textContent = `${direccion.value.length} caracteres`;
        direccion.insertAdjacentElement('afterend', counter);
        direccion.addEventListener('input', () => {
            counter.textContent = `${direccion.value.length} caracteres`;
        });
    }

    /* ── Formateo automático de teléfono ─────────────────── */
    const telefono = document.getElementById('telefono');
    if (telefono) {
        telefono.addEventListener('blur', () => {
            let val = telefono.value.trim().replace(/\s/g, '');
            if (/^\d{10}$/.test(val)) {
                telefono.value = '+52 ' + val;
            }
        });
    }

    /* ── Submit con fetch ────────────────────────────────── */
    const form = document.getElementById('contact-edit-form');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        if (!validateForm(form)) {
            showToast('Por favor revisa los campos marcados.', 'error');

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

        /* Estado: guardando */
        const btns = form.querySelectorAll('.btn-save');
        btns.forEach(btn => {
            btn.disabled   = true;
            btn.innerHTML  = '<i class="fa fa-spinner fa-spin" style="margin-right:7px;"></i> Guardando…';
        });

        try {
            const response = await fetch(form.action, {
                method:  'POST',
                body:    new FormData(form),
                headers: { 'X-CSRF-TOKEN': csrfToken },
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Error al guardar.', 'error');
            }

        } catch (err) {
            console.error('contact_edit error:', err);
            showToast('Error de conexión. Intenta de nuevo.', 'error');

        } finally {
            btns.forEach(btn => {
                btn.disabled  = false;
                btn.innerHTML = '<i class="fa fa-floppy-disk" style="margin-right:7px;"></i> Guardar Cambios';
            });
        }
    });

})();