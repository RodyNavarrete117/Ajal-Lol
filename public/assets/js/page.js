/* ==================== page.js ==================== */
document.addEventListener('DOMContentLoaded', function () {

    const SVG_EYE_ON  = `<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>`;
    const SVG_EYE_OFF = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;

    /* ── Toast ── */
    const TOAST_ICONS = {
        success: `<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
        error:   `<svg viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>`,
        info:    `<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>`,
        warning: `<svg viewBox="0 0 24 24" fill="none"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="currentColor" stroke-width="2"/><path d="M12 9v4M12 17h.01" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>`,
    };

    function showToast(type = 'info', title = '', message = '', duration = 4000) {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            document.body.appendChild(container);
        }
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-inner">
                <div class="toast-icon">${TOAST_ICONS[type] || TOAST_ICONS.info}</div>
                <div class="toast-body">
                    <p class="toast-title">${title}</p>
                    ${message ? `<p class="toast-msg">${message}</p>` : ''}
                </div>
                <button class="toast-close" aria-label="Cerrar">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
            </div>
            <div class="toast-bar-wrap"><div class="toast-bar"></div></div>
        `;
        container.appendChild(toast);
        requestAnimationFrame(() => requestAnimationFrame(() => {
            toast.classList.add('show');
            const bar = toast.querySelector('.toast-bar');
            bar.style.transition = `width ${duration}ms linear`;
            requestAnimationFrame(() => { bar.style.width = '0%'; });
        }));
        toast._timer = setTimeout(() => dismissToast(toast), duration);
        toast.querySelector('.toast-close').addEventListener('click', () => {
            clearTimeout(toast._timer);
            dismissToast(toast);
        });
    }

    function dismissToast(toast) {
        if (!toast) return;
        toast.classList.remove('show');
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 380);
    }

    /* ── Modal habilitar / deshabilitar ── */
    let pendingToggle = null;

    const modal = document.createElement('div');
    modal.id = 'toggle-modal';
    modal.className = 'toggle-modal';
    modal.innerHTML = `
        <div class="toggle-modal-backdrop"></div>
        <div class="toggle-modal-card">
            <div class="toggle-modal-icon" id="toggle-modal-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-modal-svg"></svg>
            </div>
            <h3 class="toggle-modal-title" id="toggle-modal-title"></h3>
            <p class="toggle-modal-msg" id="toggle-modal-msg"></p>
            <div class="toggle-modal-actions">
                <button class="toggle-modal-cancel">Cancelar</button>
                <button class="toggle-modal-confirm" id="toggle-modal-confirm"></button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    function openToggleModal(card, isActive) {
        pendingToggle = { card, isActive };
        const name    = card.querySelector('.header-name').textContent;
        const icon    = modal.querySelector('#toggle-modal-icon');
        const svg     = modal.querySelector('#toggle-modal-svg');
        const title   = modal.querySelector('#toggle-modal-title');
        const msg     = modal.querySelector('#toggle-modal-msg');
        const confirm = modal.querySelector('#toggle-modal-confirm');

        if (isActive) {
            icon.className      = 'toggle-modal-icon disable';
            svg.innerHTML       = SVG_EYE_OFF;
            title.textContent   = '¿Deshabilitar página?';
            msg.innerHTML       = `La página <strong>"${name}"</strong> quedará oculta para los visitantes del sitio.`;
            confirm.textContent = 'Sí, deshabilitar';
            confirm.className   = 'toggle-modal-confirm disable';
        } else {
            icon.className      = 'toggle-modal-icon enable';
            svg.innerHTML       = SVG_EYE_ON;
            title.textContent   = '¿Habilitar página?';
            msg.innerHTML       = `La página <strong>"${name}"</strong> volverá a ser visible para los visitantes del sitio.`;
            confirm.textContent = 'Sí, habilitar';
            confirm.className   = 'toggle-modal-confirm enable';
        }

        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeToggleModal() {
        modal.classList.remove('open');
        document.body.style.overflow = '';
        pendingToggle = null;
    }

    modal.querySelector('.toggle-modal-backdrop').addEventListener('click', closeToggleModal);
    modal.querySelector('.toggle-modal-cancel').addEventListener('click', closeToggleModal);

    modal.querySelector('#toggle-modal-confirm').addEventListener('click', function () {
        if (!pendingToggle) return;
        const { card, isActive } = pendingToggle;
        const name   = card.querySelector('.header-name').textContent;
        const btn    = card.querySelector('.header-btn--toggle');
        const footer = card.querySelector('.page-card__footer');

        if (isActive) {
            card.classList.add('inactive');
            card.dataset.active = '0';
            btn.classList.add('off');
            btn.querySelector('svg').innerHTML = SVG_EYE_OFF;
            btn.title = 'Habilitar página';
            footer.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M4.93 4.93l14.14 14.14"/></svg>
                <p class="inactive-since">Inactiva desde <strong>hace unos segundos</strong></p>
            `;
            showToast('warning', 'Página deshabilitada', `"${name}" ya no es visible para los visitantes.`);
        } else {
            card.classList.remove('inactive');
            card.dataset.active = '1';
            btn.classList.remove('off');
            btn.querySelector('svg').innerHTML = SVG_EYE_ON;
            btn.title = 'Deshabilitar página';
            footer.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <p class="footer-text">Actualizada <strong>hace unos segundos</strong></p>
            `;
            showToast('success', 'Página habilitada', `"${name}" ya es visible para los visitantes.`);
        }

        closeToggleModal();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal.classList.contains('open')) closeToggleModal();
    });

    /* ── Botones toggle ── */
    document.querySelectorAll('.header-btn--toggle').forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const card     = btn.closest('.page-card');
            const isActive = card.dataset.active === '1';
            openToggleModal(card, isActive);
        });
    });

    /* ── Tabs ── */
    const tabs = document.querySelectorAll('.tab-btn');
    const grid = document.getElementById('pagesGrid');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            if (this.classList.contains('active')) return;
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const isInactivas = this.textContent.trim().toLowerCase().includes('inactiva');
            const cards = grid.querySelectorAll('.page-card');

            grid.style.transition = 'opacity .22s ease';
            grid.style.opacity    = '0';

            setTimeout(() => {
                cards.forEach(card => {
                    const active = card.dataset.active === '1';
                    card.style.display = (isInactivas ? !active : active) ? '' : 'none';
                });
                const visible = [...cards].filter(c => c.style.display !== 'none');
                if (visible.length === 0 && isInactivas) {
                    showToast('info', 'Sin páginas inactivas', 'No hay páginas deshabilitadas por el momento.');
                }
                grid.style.opacity = '1';
            }, 220);
        });
    });

    /* ── Botón nueva sección ── */
    document.querySelector('.btn-new-page')?.addEventListener('click', () => {
        showToast('info', 'Próximamente', 'La función de crear secciones estará disponible pronto.');
    });

});