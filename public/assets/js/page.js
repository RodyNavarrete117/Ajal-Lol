/* ==================== page.js ==================== */
document.addEventListener('DOMContentLoaded', function () {

    /* ════════════════════════════════════════════
       TOAST
    ════════════════════════════════════════════ */
    const TOAST_ICONS = {
        success: `<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
        error:   `<svg viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>`,
        info:    `<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>`,
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

    /* ════════════════════════════════════════════
       RIPPLE al hacer clic en la tarjeta
    ════════════════════════════════════════════ */
    function spawnRipple(card, e) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const ripple = document.createElement('span');
        ripple.className = 'card-ripple';
        ripple.style.cssText = `left:${x}px;top:${y}px`;
        card.appendChild(ripple);
        ripple.addEventListener('animationend', () => ripple.remove(), { once: true });
    }

    /* ════════════════════════════════════════════
       OBTENER URL de edición de cada tarjeta
    ════════════════════════════════════════════ */
    function getEditUrl(card) {
        return card.dataset.editUrl || null;
    }

    /* ════════════════════════════════════════════
       TARJETA CLICKEABLE
    ════════════════════════════════════════════ */
    document.querySelectorAll('.page-card').forEach(card => {
        card.addEventListener('click', function (e) {
            if (e.target.closest('.header-controls')) return;
            spawnRipple(card, e);
            const url = getEditUrl(card);
            if (url) {
                setTimeout(() => { window.location.href = url; }, 160);
            }
        });

        card.addEventListener('mouseenter', () => card.classList.add('card--hovered'));
        card.addEventListener('mouseleave', () => card.classList.remove('card--hovered'));
    });

    /* ════════════════════════════════════════════
       MODAL VISTA PREVIA
    ════════════════════════════════════════════ */
    const previewModal    = document.getElementById('preview-modal');
    const previewPageName = document.getElementById('preview-page-name');
    const previewImgDesk  = document.getElementById('preview-img-desktop');
    const previewImgMob   = document.getElementById('preview-img-mobile');
    const previewDeskWrap = document.getElementById('preview-desktop-wrap');
    const previewMobWrap  = document.getElementById('preview-mobile-wrap');
    const previewClose    = previewModal.querySelector('.preview-modal__close');
    const previewBackdrop = previewModal.querySelector('.preview-modal__backdrop');
    const tabsWrap        = previewModal.querySelector('.preview-modal__tabs');

    let currentMode   = 'desktop';
    let _errorHandled = false;

    // ── Detectar si el viewport es móvil ──
    function isMobileViewport() {
        return window.innerWidth < 768;
    }

    // ── Reordenar tabs: móvil primero o escritorio primero ──
    function reorderTabs(mobileFirst) {
        const tabDesk = tabsWrap.querySelector('[data-mode="desktop"]');
        const tabMob  = tabsWrap.querySelector('[data-mode="mobile"]');
        if (mobileFirst) {
            // Pone Móvil primero → mueve Escritorio al final
            tabsWrap.appendChild(tabDesk);
        } else {
            // Pone Escritorio primero → mueve Móvil al final
            tabsWrap.appendChild(tabMob);
        }
    }

    // ── Cambiar modo activo (desktop | mobile) ──
    function setPreviewMode(mode) {
        currentMode = mode;

        tabsWrap.querySelectorAll('.preview-tab').forEach(t => {
            t.classList.toggle('active', t.dataset.mode === mode);
        });

        if (mode === 'desktop') {
            previewDeskWrap.classList.add('active');
            previewMobWrap.classList.remove('active');
        } else {
            previewMobWrap.classList.add('active');
            previewDeskWrap.classList.remove('active');
        }

        // Reiniciar animación de entrada de la imagen activa
        const img = mode === 'desktop' ? previewImgDesk : previewImgMob;
        img.style.animation = 'none';
        requestAnimationFrame(() => { img.style.animation = ''; });
    }

    // ── Abrir modal ──
    function openPreviewModal(btn) {
        const pageName   = btn.dataset.pageName      || '';
        const desktopSrc = btn.dataset.previewDesktop || '';
        const mobileSrc  = btn.dataset.previewMobile  || '';

        previewPageName.textContent = pageName;

        // Detectar dispositivo del visitante y elegir modo + orden de tabs
        const onMobile    = isMobileViewport();
        const initialMode = onMobile ? 'mobile' : 'desktop';

        reorderTabs(onMobile);
        setPreviewMode(initialMode);

        // Cargar imágenes solo si cambiaron
        if (previewImgDesk.getAttribute('src') !== desktopSrc) previewImgDesk.src = desktopSrc;
        if (previewImgMob.getAttribute('src')  !== mobileSrc)  previewImgMob.src  = mobileSrc;

        _errorHandled = false;
        previewModal.classList.add('open');
        document.documentElement.style.overflow = 'hidden';
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => previewClose.focus());
    }

    // ── Cerrar modal ──
    function closePreviewModal() {
        previewModal.classList.remove('open');
        document.documentElement.style.overflow = '';
        document.body.style.overflow = '';
    }

    // ── Eventos tabs ──
    tabsWrap.addEventListener('click', e => {
        const tab = e.target.closest('.preview-tab');
        if (tab) setPreviewMode(tab.dataset.mode);
    });

    // ── Eventos cierre ──
    previewClose.addEventListener('click', closePreviewModal);
    previewBackdrop.addEventListener('click', closePreviewModal);

    document.addEventListener('keydown', e => {
        if (!previewModal.classList.contains('open')) return;
        if (e.key === 'Escape')     closePreviewModal();
        if (e.key === 'ArrowLeft')  setPreviewMode('desktop');
        if (e.key === 'ArrowRight') setPreviewMode('mobile');
    });

    // ── Botones preview en cada card ──
    document.querySelectorAll('.header-btn--preview').forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            openPreviewModal(btn);
        });
    });

    // ── Toast si imagen no carga — solo UNO por apertura ──
    function attachErrorHandler(img) {
        img.addEventListener('error', function () {
            if (!previewModal.classList.contains('open')) return;
            if (_errorHandled) return;
            _errorHandled = true;
            showToast('info', 'Sin vista previa', 'Aún no se ha subido una imagen de previsualización para esta sección.');
        });
    }
    attachErrorHandler(previewImgDesk);
    attachErrorHandler(previewImgMob);

});