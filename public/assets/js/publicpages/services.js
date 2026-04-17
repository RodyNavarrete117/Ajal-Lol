/* ─────────────────────────────────────────
   SELECTOR DE AÑOS — Sección Actividades (público)
   Conectado a BD via fetch
   ───────────────────────────────────────── */
(function () {
    'use strict';

    const selector  = document.querySelector('.year-selector');
    const grid      = document.getElementById('activitiesGrid');
    const yearLabel = document.querySelector('.year-label-inline');

    if (!selector || !grid) return;

    /* Ruta y año activo inyectados desde blade */
    const ROUTE_TEMPLATE = selector.dataset.route ?? '';
    let   activeYear     = parseInt(selector.dataset.anoActivo) || new Date().getFullYear();

    /* ── Referencias DOM ── */
    const dotsToggle   = document.getElementById('dotsToggle');
    const yearDropdown = document.getElementById('yearDropdown');
    let   dropdownOpen = false;

    /* ════ RENDERIZAR TARJETAS ════ */
    function buildCard(act) {
        const icono = act.icono_actividad ?? 'fa-star';
        return `
        <article class="activity-card" role="listitem">
            <div class="icon" aria-hidden="true"><i class="fa ${icono}"></i></div>
            <h3>${act.titulo_actividad ?? ''}</h3>
            <p>${act.texto_actividad ?? ''}</p>
        </article>`;
    }

    function buildEmpty(year) {
        return `
        <div class="year-empty" role="status" aria-live="polite">
            <div class="year-empty__icon"><i class="fas fa-calendar-xmark"></i></div>
            <p class="year-empty__title">Sin actividades registradas</p>
            <p class="year-empty__sub">
                No hay actividades disponibles para el año <strong>${year}</strong>.
            </p>
        </div>`;
    }

    /* ════ CARGAR ACTIVIDADES POR AÑO (AJAX) ════ */
    async function loadYear(year) {
        grid.classList.add('year-transitioning');
        grid.classList.remove('year-visible');

        try {
            const url = ROUTE_TEMPLATE.replace(':ano', year);
            const res = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });

            if (!res.ok) throw new Error(`HTTP ${res.status}`);

            const data = await res.json();
            const acts = data.actividades ?? [];

            setTimeout(() => {
                grid.innerHTML = acts.length
                    ? acts.map(a => buildCard(a)).join('')
                    : buildEmpty(year);

                grid.classList.remove('year-transitioning');
                void grid.offsetHeight;
                grid.classList.add('year-visible');

                if (yearLabel) yearLabel.textContent = year;
            }, 220);

        } catch (err) {
            setTimeout(() => {
                grid.innerHTML = buildEmpty(year);
                grid.classList.remove('year-transitioning');
                void grid.offsetHeight;
                grid.classList.add('year-visible');
            }, 220);
        }
    }

    /* ════ CAMBIAR AÑO ACTIVO ════ */
    function setActiveYear(year, source = 'tab') {
        year = parseInt(year);
        if (year === activeYear) return;
        activeYear = year;

        /* Actualizar pills principales */
        selector.querySelectorAll('.year-btn:not(.year-btn--dots)').forEach(btn => {
            const isActive = parseInt(btn.dataset.year) === year;
            btn.classList.toggle('active', isActive);
            btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        /* Actualizar dropdown */
        if (yearDropdown) {
            yearDropdown.querySelectorAll('.year-dropdown__item').forEach(item => {
                item.classList.toggle('active', parseInt(item.dataset.year) === year);
            });
        }

        if (source === 'dropdown') closeDropdown();

        loadYear(year);
    }

    /* ════ DROPDOWN ════ */
    function openDropdown() {
        dropdownOpen = true;
        yearDropdown?.classList.add('open');
        dotsToggle?.classList.add('open');
        dotsToggle?.setAttribute('aria-expanded', 'true');
    }

    function closeDropdown() {
        dropdownOpen = false;
        yearDropdown?.classList.remove('open');
        dotsToggle?.classList.remove('open');
        dotsToggle?.setAttribute('aria-expanded', 'false');
    }

    dotsToggle?.addEventListener('click', e => {
        e.stopPropagation();
        dropdownOpen ? closeDropdown() : openDropdown();
    });

    document.addEventListener('click', e => {
        if (!e.target.closest('.year-selector__dots')) closeDropdown();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && dropdownOpen) closeDropdown();
    });

    /* ════ EVENT LISTENERS ════ */
    selector.addEventListener('click', e => {
        const btn  = e.target.closest('.year-btn:not(.year-btn--dots)');
        const item = e.target.closest('.year-dropdown__item');

        if (btn)  setActiveYear(btn.dataset.year,  'tab');
        if (item) setActiveYear(item.dataset.year, 'dropdown');
    });

    /* ════ INIT ════ */
    grid.classList.add('year-visible');

})();