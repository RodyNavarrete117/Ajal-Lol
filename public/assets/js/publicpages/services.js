/* ─────────────────────────────────────────
   SELECTOR DE AÑOS — Sección Actividades
   ───────────────────────────────────────── */
(function () {
    'use strict';

    /* ════ DATOS DE ACTIVIDADES POR AÑO ════
       Agrega o quita años/tarjetas según necesites.
       El array vacío [] mostrará el mensaje "sin actividades".
    ══════════════════════════════════════════ */
    const ACTIVITIES_BY_YEAR = {
        2020: [
            { icon: 'fas fa-hands-helping', title: 'Apoyo alimentario',        desc: 'Distribución de despensas a familias vulnerables durante la pandemia en comunidades de Yucatán.' },
            { icon: 'fas fa-mask',          title: 'Entrega de cubrebocas',    desc: 'Donación de más de 5,000 cubrebocas a comunidades rurales con apoyo de aliados locales.' },
        ],
        2021: [
            { icon: 'fas fa-seedling',      title: 'Huertos familiares',       desc: 'Programa de huertos en traspatio para 200 familias en municipios de la zona oriente.' },
            { icon: 'fas fa-hand-holding-heart', title: 'Brigada de salud',   desc: 'Jornada de salud preventiva con más de 400 atenciones gratuitas.' },
            { icon: 'fas fa-book-open',     title: 'Apoyo educativo',          desc: 'Entrega de útiles escolares y tablets a niños de comunidades de escasos recursos.' },
        ],
        2022: [
            { icon: 'fas fa-feather',       title: 'Cría de pavos',            desc: 'Inicio del programa de engorda de pavos de traspatio con donativos de OXXO, beneficiando a 350 familias.' },
            { icon: 'fas fa-droplet',       title: 'Cisternas comunitarias',   desc: 'Construcción de 12 cisternas comunitarias en localidades sin acceso a agua potable.' },
            { icon: 'fas fa-tooth',         title: 'Primera jornada dental',   desc: 'Primer año del programa de jornadas dentales con la Fundación Smile y Global Dental.' },
        ],
        2023: [
            { icon: 'fas fa-tooth',         title: 'Jornada dental',           desc: 'Por segundo año consecutivo, se realizaron jornadas de servicios dentales con el apoyo de la Fundación Smile y Global Dental. Un equipo de 35 dentistas brindó servicios gratuitos, atendiendo a 159 pacientes de varios municipios.' },
            { icon: 'bi bi-heart-pulse-fill', title: 'Jornada de salud',       desc: 'Realizamos 2 jornadas de salud en Hoctún con detección gratuita de niveles de azúcar, presión arterial, peso, talla, vista y orientación psicológica, beneficiando a 300 personas.' },
            { icon: 'bi bi-easel',          title: 'Talleres de capacitación', desc: 'Con el apoyo de Mentors International, se realizaron cursos de administración básica para pequeños emprendedores en varios municipios, beneficiando a 150 personas.' },
            { icon: 'bi bi-tree',           title: 'Reforestación',            desc: 'El Ayuntamiento de Mérida donó 1,666 plantas forestales y maderables a 11 localidades para reforestar predios de producción y traspatio.' },
            { icon: 'bi bi-feather',        title: 'Cría de pavos de engorda', desc: 'Como seguimiento al proyecto iniciado en 2022 con donativos de OXXO que benefició a 350 familias, en 2023 se pudo continuar con el programa de engorda de pavos de traspatio.' },
            { icon: 'bi bi-droplet-half',   title: 'Entrega de tinacos',       desc: 'Gracias a la gestión de Ajal Lol y la aportación de Mariana Trinitaria, se llevaron programas de abastecimiento de agua a varias comunidades, beneficiando a más de 400 familias.' },
        ],
        2024: [],  // Agrega las actividades cuando estén disponibles
        2025: [],
    };

    /* ── Delays de animación por posición ── */
    const DELAYS = [0, 80, 160, 0, 80, 160, 0, 80, 160];

    /* ── Referencias DOM ── */
    const grid        = document.getElementById('activitiesGrid');
    const dotsToggle  = document.getElementById('dotsToggle');
    const yearDropdown = document.getElementById('yearDropdown');
    const yearLabel   = document.querySelector('.year-label-inline');
    const allYearBtns = document.querySelectorAll('.year-btn:not(.year-btn--dots)');
    const dropdownItems = document.querySelectorAll('.year-dropdown__item');

    if (!grid) return;

    let activeYear = 2023;
    let dropdownOpen = false;

    /* ════ RENDERIZAR TARJETAS ════ */
    function buildCard(act, index) {
        const delay = DELAYS[index] ?? 0;
        return `
        <article class="activity-card" data-anim="fade-up" data-delay="${delay}" role="listitem">
            <div class="icon" aria-hidden="true"><i class="${act.icon}"></i></div>
            <h3>${act.title}</h3>
            <p>${act.desc}</p>
        </article>`;
    }

    function buildEmpty(year) {
        return `
        <div class="year-empty" role="status" aria-live="polite">
            <div class="year-empty__icon"><i class="fas fa-calendar-xmark"></i></div>
            <p class="year-empty__title">Sin actividades registradas</p>
            <p class="year-empty__sub">No hay actividades disponibles para el año <strong>${year}</strong>.</p>
        </div>`;
    }

    function renderYear(year) {
        const acts = ACTIVITIES_BY_YEAR[year] ?? [];

        /* Salida con fade */
        grid.classList.add('year-transitioning');
        grid.classList.remove('year-visible');

        setTimeout(() => {
            if (acts.length === 0) {
                grid.innerHTML = buildEmpty(year);
            } else {
                grid.innerHTML = acts.map((a, i) => buildCard(a, i)).join('');
            }

            /* Entrada con fade */
            requestAnimationFrame(() => {
                grid.classList.remove('year-transitioning');
                grid.classList.add('year-visible');
            });

            /* Actualizar subtítulo */
            if (yearLabel) yearLabel.textContent = `Actividades ${year}`;
        }, 220);
    }

    /* ════ CAMBIAR AÑO ACTIVO ════ */
    function setActiveYear(year, source = 'tab') {
        year = parseInt(year);
        if (year === activeYear) return;
        activeYear = year;

        /* Actualizar tabs principales */
        allYearBtns.forEach(btn => {
            const isActive = parseInt(btn.dataset.year) === year;
            btn.classList.toggle('active', isActive);
            btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        /* Actualizar items del dropdown */
        dropdownItems.forEach(item => {
            item.classList.toggle('active', parseInt(item.dataset.year) === year);
        });

        /* Si el año viene del dropdown, cerrarlo */
        if (source === 'dropdown') closeDropdown();

        renderYear(year);
    }

    /* ════ DROPDOWN ════ */
    function openDropdown() {
        dropdownOpen = true;
        yearDropdown.classList.add('open');
        dotsToggle.classList.add('open');
        dotsToggle.setAttribute('aria-expanded', 'true');
    }

    function closeDropdown() {
        dropdownOpen = false;
        yearDropdown.classList.remove('open');
        dotsToggle.classList.remove('open');
        dotsToggle.setAttribute('aria-expanded', 'false');
    }

    function toggleDropdown() {
        dropdownOpen ? closeDropdown() : openDropdown();
    }

    /* Cerrar al hacer click fuera */
    document.addEventListener('click', e => {
        if (!e.target.closest('.year-selector__dots')) closeDropdown();
    });

    /* Cerrar con Escape */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && dropdownOpen) closeDropdown();
    });

    /* ════ EVENT LISTENERS ════ */
    dotsToggle?.addEventListener('click', e => {
        e.stopPropagation();
        toggleDropdown();
    });

    allYearBtns.forEach(btn => {
        btn.addEventListener('click', () => setActiveYear(btn.dataset.year, 'tab'));
    });

    dropdownItems.forEach(item => {
        item.addEventListener('click', () => setActiveYear(item.dataset.year, 'dropdown'));
    });

    /* ════ INIT ════ */
    /* Marcar 2023 como activo al cargar */
    allYearBtns.forEach(btn => {
        if (parseInt(btn.dataset.year) === activeYear) {
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
        }
    });

    /* El grid ya tiene las tarjetas de 2023 en el HTML,
       sólo necesitamos aplicar la clase de visibilidad */
    grid.classList.add('year-visible');

})();