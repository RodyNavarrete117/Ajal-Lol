/* ==================== contact_edit.js ==================== */
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

        // Validar formato de email
        const correo = form.querySelector('#correo');
        if (correo && correo.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo.value.trim())) {
            markError(correo, 'Ingresa un correo electrónico válido.');
            valid = false;
        }

        // Validar URLs de redes sociales (si se llenaron)
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
        err.className = 'field-error-msg';
        err.textContent = msg;
        field.insertAdjacentElement('afterend', err);
        field.addEventListener('input', () => clearError(field), { once: true });
    }

    function clearError(field) {
        field.classList.remove('field--error');
        const msg = field.parentElement.querySelector('.field-error-msg');
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
            if (mapFrame) mapFrame.style.display  = 'none';
            if (mapFrame) mapFrame.innerHTML = '';
            return;
        }

        // Extraer solo el iframe del embed para seguridad
        const tmp = document.createElement('div');
        tmp.innerHTML = val;
        const iframe = tmp.querySelector('iframe');

        if (iframe) {
            // Forzar estilos seguros
            iframe.style.width  = '100%';
            iframe.style.height = '220px';
            iframe.style.border = 'none';
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
            if (mapFrame) {
                mapFrame.style.display = 'none';
                mapFrame.innerHTML = '';
            }
        }
    }

    // Actualizar preview con debounce
    let mapDebounce;
    mapaInput?.addEventListener('input', () => {
        clearTimeout(mapDebounce);
        mapDebounce = setTimeout(updateMapPreview, 600);
    });

    // Preview inicial si ya hay valor
    updateMapPreview();

    /* ── Contador de caracteres en dirección ─────────────── */
    const direccion = document.getElementById('direccion');
    if (direccion) {
        const counter = document.createElement('span');
        counter.className = 'field-hint';
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
            let val = telefono.value.trim();
            // Si empieza con 10 dígitos sin código de país, agregar +52
            if (/^\d{10}$/.test(val.replace(/\s/g, ''))) {
                telefono.value = '+52 ' + val;
            }
        });
    }

    /* ── Submit ──────────────────────────────────────────── */
    const form = document.querySelector('.edit-container form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!validateForm(form)) {
            showToast('Por favor revisa los campos marcados.', 'error');
            // Hacer scroll al primer error
            const firstError = form.querySelector('.field--error');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        showToast('Cambios guardados correctamente.', 'success');
        /* TODO: reemplazar con fetch/axios o form.submit() al conectar la BD */
    });

})();