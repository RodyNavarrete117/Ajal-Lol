/* ==================== about.js ==================== */
(function () {
    'use strict';

    const { $, $$, on } = window.AjalUtils;

    /* ════ ANIMACIÓN DE CAMPOS GENERALES ════ */
    function initAboutGeneralInfo() {
        const items = $$('.about-general-item');
        if (!items.length) return;

        const obs = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const index = [...items].indexOf(entry.target);
                setTimeout(() => {
                    entry.target.classList.add('about-general-item--visible');
                }, index * 120);
                obs.unobserve(entry.target);
            });
        }, { threshold: 0.2 });

        items.forEach(item => obs.observe(item));
    }

    /* ── Init ── */
    function init() {
        initAboutGeneralInfo();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();