document.addEventListener('DOMContentLoaded', function () {

    // ─────────────────────────────────────────────────────────────
    // TOAST
    // ─────────────────────────────────────────────────────────────
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

        // Estructura con clase .toast-inner explícita
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
            <div class="toast-bar-wrap">
                <div class="toast-bar"></div>
            </div>
        `;

        container.appendChild(toast);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                toast.classList.add('show');
                const bar = toast.querySelector('.toast-bar');
                bar.style.transition = `width ${duration}ms linear`;
                requestAnimationFrame(() => { bar.style.width = '0%'; });
            });
        });

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

    // ─────────────────────────────────────────────────────────────
    // MODAL DE CONFIRMACIÓN — ELIMINAR
    // ─────────────────────────────────────────────────────────────
    let pendingDeleteItem = null;

    const modal = document.createElement('div');
    modal.id = 'delete-modal';
    modal.className = 'delete-modal';
    modal.innerHTML = `
        <div class="delete-modal-backdrop"></div>
        <div class="delete-modal-card">
            <div class="delete-modal-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M19 6V20C19 20.53 18.79 21.04 18.41 21.41C18.04 21.79 17.53 22 17 22H7C6.47 22 5.96 21.79 5.59 21.41C5.21 21.04 5 20.53 5 20V6M8 6V4C8 3.47 8.21 2.96 8.59 2.59C8.96 2.21 9.47 2 10 2H14C14.53 2 15.04 2.21 15.41 2.59C15.79 2.96 16 3.47 16 4V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <h3 class="delete-modal-title">¿Eliminar sección?</h3>
            <p class="delete-modal-msg">Estás a punto de eliminar <strong id="delete-page-name"></strong>. Esta acción no se puede deshacer.</p>
            <div class="delete-modal-actions">
                <button class="delete-modal-cancel">Cancelar</button>
                <button class="delete-modal-confirm">Sí, eliminar</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    function openDeleteModal(pageItem) {
        pendingDeleteItem = pageItem;
        const name = pageItem.querySelector('.page-name').textContent;
        document.getElementById('delete-page-name').textContent = `"${name}"`;
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        modal.classList.remove('open');
        document.body.style.overflow = '';
        pendingDeleteItem = null;
    }

    modal.querySelector('.delete-modal-backdrop').addEventListener('click', closeDeleteModal);
    modal.querySelector('.delete-modal-cancel').addEventListener('click', closeDeleteModal);

    modal.querySelector('.delete-modal-confirm').addEventListener('click', function () {
        if (!pendingDeleteItem) return;
        const name = pendingDeleteItem.querySelector('.page-name').textContent;

        pendingDeleteItem.style.transition = 'all 0.4s ease';
        pendingDeleteItem.style.opacity = '0';
        pendingDeleteItem.style.transform = 'translateX(40px)';
        pendingDeleteItem.style.maxHeight = pendingDeleteItem.offsetHeight + 'px';

        setTimeout(() => {
            pendingDeleteItem.style.maxHeight = '0';
            pendingDeleteItem.style.padding = '0';
            pendingDeleteItem.style.marginBottom = '0';
        }, 300);

        setTimeout(() => {
            pendingDeleteItem.remove();
            showToast('success', 'Sección eliminada', `"${name}" fue eliminada correctamente.`);
        }, 600);

        closeDeleteModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('open')) closeDeleteModal();
    });

    // ─────────────────────────────────────────────────────────────
    // TABS — Activas / Inactivas
    // ─────────────────────────────────────────────────────────────
    const tabs      = document.querySelectorAll('.tab-btn');
    const pagesList = document.querySelector('.pages-list');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            if (this.classList.contains('active')) return;
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const isInactivas = this.textContent.trim().toLowerCase().includes('inactivas');

            pagesList.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
            pagesList.style.opacity    = '0';
            pagesList.style.transform  = 'translateY(8px)';

            setTimeout(() => {
                pagesList.style.opacity   = '1';
                pagesList.style.transform = 'translateY(0)';
                if (isInactivas) {
                    showToast('info', 'Sin secciones inactivas', 'No hay secciones desactivadas por el momento.');
                }
            }, 250);
        });
    });

    // ─────────────────────────────────────────────────────────────
    // BOTONES ELIMINAR
    // ─────────────────────────────────────────────────────────────
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            openDeleteModal(this.closest('.page-item'));
        });
    });

    // ─────────────────────────────────────────────────────────────
    // BOTÓN CREAR NUEVA SECCIÓN
    // ─────────────────────────────────────────────────────────────
    const btnNew = document.querySelector('.btn-new-page');
    if (btnNew) {
        btnNew.addEventListener('click', function () {
            showToast('info', 'Próximamente', 'La función de crear secciones estará disponible pronto.');
        });
    }

});