/* ==================== projects_edit — JS ==================== */
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

    /* ── Validación visual ─────────────────────────────── */
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
        const msg = field.parentElement.querySelector('.field-error-msg');
        if (msg) msg.remove();
    }

    /* ── Submit ────────────────────────────────────────── */
    const form = document.querySelector('.edit-container form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!validateForm(form)) {
            showToast('Por favor completa los campos obligatorios.', 'error');
            return;
        }

        showToast('Cambios guardados correctamente.', 'success');
        /* TODO: aquí irá el fetch/axios cuando se conecte la BD */
    });

    /* ── Estilos del toast y errores (inyectados una vez) ── */
    if (!document.getElementById('edit-page-js-styles')) {
        const style = document.createElement('style');
        style.id = 'edit-page-js-styles';
        style.textContent = `
            /* Toast */
            .edit-toast {
                position: fixed;
                bottom: 28px;
                right: 28px;
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 13px 20px;
                border-radius: 12px;
                font-size: 14px;
                font-weight: 500;
                color: #fff;
                box-shadow: 0 8px 28px rgba(0,0,0,0.18);
                opacity: 0;
                transform: translateY(14px);
                transition: opacity 0.3s ease, transform 0.3s ease;
                z-index: 9999;
                pointer-events: none;
            }
            .edit-toast--show {
                opacity: 1;
                transform: translateY(0);
            }
            .edit-toast--success { background: #2d7d46; }
            .edit-toast--error   { background: #c0392b; }
            .edit-toast__icon    { font-size: 16px; }

            /* Campos con error */
            .field--error {
                border-color: #c0392b !important;
                box-shadow: 0 0 0 3px rgba(192, 57, 43, 0.15) !important;
            }
            .field-error-msg {
                margin-top: 5px;
                font-size: 12px;
                color: #c0392b;
                font-weight: 500;
            }
        `;
        document.head.appendChild(style);
    }

})();