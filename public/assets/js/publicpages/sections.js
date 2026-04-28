/**
 * AJAL LOL — sections.js
 * Ruta: assets/js/publicpages/sections.js
 * Contiene: Contadores animados · Marquee infinito
 *           Stats hover · FAQ accordion · Team carousel
 * Depende de: utils.js (AjalUtils)
 */

'use strict';

(function () {
  const { $, $$, on } = window.AjalUtils;

  /* ═══════════════════════════════════════════════
     CONTADOR ANIMADO (stats)
  ═══════════════════════════════════════════════ */
  function initCounters() {
    const counters = $$('.purecounter');
    if (!counters.length) return;

    const obs = new IntersectionObserver(entries => {
      entries.forEach(({ isIntersecting, target }) => {
        if (!isIntersecting) return;
        const end = +target.dataset.end;
        const dur = +(target.dataset.duration ?? 1) * 1200;
        const start = performance.now();
        const easeOutCubic = t => 1 - Math.pow(1 - t, 3);

        const tick = now => {
          const p = Math.min((now - start) / dur, 1);
          target.textContent = Math.floor(easeOutCubic(p) * end).toLocaleString('es-MX');
          if (p < 1) requestAnimationFrame(tick);
          else target.textContent = end.toLocaleString('es-MX');
        };
        requestAnimationFrame(tick);
        obs.unobserve(target);
      });
    }, { threshold: 0.5 });

    counters.forEach(el => obs.observe(el));
  }

  /* ═══════════════════════════════════════════════
     MARQUEE INFINITO (aliados)
  ═══════════════════════════════════════════════ */
  function initMarquee() {
    const track = $('.marquee-track');
    if (!track) return;

    let outer = track.parentElement;
    if (!outer.classList.contains('marquee-outer')) {
      const wrapper = document.createElement('div');
      wrapper.className = 'marquee-outer';
      track.parentNode.insertBefore(wrapper, track);
      wrapper.appendChild(track);
      outer = wrapper;
    }

    const clone = track.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    outer.appendChild(clone);
  }

  /* ═══════════════════════════════════════════════
     HIGHLIGHT HOVER EN STATS
  ═══════════════════════════════════════════════ */
  function initStatCards() {
    $$('.stat-item').forEach(item => {
      on(item, 'mouseenter', () => {
        $$('.stat-item').forEach(i => i.style.opacity = i === item ? '1' : '.45');
      });
      on(item, 'mouseleave', () => {
        $$('.stat-item').forEach(i => i.style.opacity = '');
      });
    });
  }

  /* ═══════════════════════════════════════════════
     FAQ ACCORDION
  ═══════════════════════════════════════════════ */
  function initFaq() {
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.faq-question');
      if (!btn) return;

      const item = btn.closest('.faq-item');
      const answer = item.querySelector('.faq-answer');
      const isOpen = item.classList.contains('open');

      document.querySelectorAll('.faq-item').forEach(i => {
        i.classList.remove('open');
        i.querySelector('.faq-answer').style.maxHeight = '0';
      });

      if (!isOpen) {
        item.classList.add('open');
        answer.style.maxHeight = answer.scrollHeight + 'px';
      }
    });
  }

  /* ═══════════════════════════════════════════════
     TEAM CAROUSEL
  ═══════════════════════════════════════════════ */
  function initTeamCarousel() {
    const grid   = document.getElementById('teamGrid');
    const prev   = document.getElementById('teamPrev');
    const next   = document.getElementById('teamNext');
    const dotsEl = document.getElementById('teamDots');
    if (!grid || !prev || !next || !dotsEl) return;

    const perPage = () => window.innerWidth <= 560 ? 1 : window.innerWidth <= 900 ? 2 : 3;
    let current = 0;

    function totalPages() {
      return Math.ceil(grid.children.length / perPage());
    }

    function goTo(page) {
      const total = totalPages();
      current = Math.max(0, Math.min(page, total - 1));

      // Ancho de una tarjeta + su gap
      const firstCard = grid.children[0];
      if (!firstCard) return;
      const cardW = firstCard.offsetWidth;
      const gap   = parseFloat(getComputedStyle(grid).gap) || 0;

      // Cada "página" avanza perPage() tarjetas
      grid.style.transform = `translateX(-${current * perPage() * (cardW + gap)}px)`;

      dotsEl.querySelectorAll('.carousel-dot').forEach((d, i) =>
        d.classList.toggle('active', i === current)
      );

      prev.disabled = current === 0;
      next.disabled = current >= total - 1;
    }

    function buildDots() {
      dotsEl.innerHTML = '';
      const total = totalPages();

      // Oculta o muestra los controles según si hay más de una página
      const controls = document.querySelector('.team-carousel-controls');
      if (controls) {
        controls.style.display = total <= 1 ? 'none' : '';
      }

      for (let i = 0; i < total; i++) {
        const d = document.createElement('button');
        d.className = 'carousel-dot' + (i === current ? ' active' : '');
        d.setAttribute('aria-label', 'Página ' + (i + 1));
        d.addEventListener('click', () => goTo(i));
        dotsEl.appendChild(d);
      }
    }

    /* ── Flechas ── */
    prev.addEventListener('click', () => goTo(current - 1));
    next.addEventListener('click', () => goTo(current + 1));

    
    /* ── Wheel horizontal (Trackpad Definitivo) ── */
    let wheelAccum = 0;
    let lastSlideTime = 0;
    const scrollCooldown = 800; // Tiempo exacto de bloqueo (ajusta este valor a la duración de tu CSS)

    grid.parentElement.addEventListener('wheel', (e) => {
      const isHorizontal = Math.abs(e.deltaX) > Math.abs(e.deltaY);
      if (!isHorizontal || e.deltaX === 0) return;

      e.preventDefault();

      const now = Date.now();

      // 1. Si estamos dentro del tiempo de bloqueo, ignoramos y destruimos la inercia
      if (now - lastSlideTime < scrollCooldown) {
        wheelAccum = 0; 
        return;
      }

      // 2. Acumulamos la distancia del deslizamiento
      wheelAccum += e.deltaX;

      // 3. Evaluamos si cruzamos el umbral para cambiar de página (50px)
      if (wheelAccum > 50) {
        goTo(current + 1);
        lastSlideTime = now; // Guardamos la hora exacta del cambio
        wheelAccum = 0;
      } else if (wheelAccum < -50) {
        goTo(current - 1);
        lastSlideTime = now; // Guardamos la hora exacta del cambio
        wheelAccum = 0;
      }
    }, { passive: false });

    // 4. Limpieza suave por si el usuario mueve un poco el dedo pero no cambia de página
    let resetTimer;
    grid.parentElement.addEventListener('wheel', () => {
      clearTimeout(resetTimer);
      resetTimer = setTimeout(() => { wheelAccum = 0; }, 150);
    }, { passive: true });

    /* ── Resize ── */
    window.addEventListener('resize', () => {
      current = 0;
      buildDots();
      goTo(0);
    });

    buildDots();
    goTo(0);
  }

  /* ── Init ── */
  function init() {
    initCounters();
    initMarquee();
    initStatCards();
    initFaq();
    initTeamCarousel();
    initMvovAccordion();
    initActivitiesCarousel();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  function initMvovAccordion() {
    const isMobile = () => window.innerWidth <= 768;

    document.addEventListener('click', function (e) {
      if (!isMobile()) return;
      const h3 = e.target.closest('.mvov-card h3');
      if (!h3) return;

      const card = h3.closest('.mvov-card');
      const body = card.querySelector('.mvov-body');
      const isOpen = card.classList.contains('open');

      // Cierra todos
      document.querySelectorAll('.mvov-card').forEach(c => {
        c.classList.remove('open');
        c.querySelector('.mvov-body').style.maxHeight = '0';
      });

      // Abre el clickeado si estaba cerrado
      if (!isOpen) {
        card.classList.add('open');
        body.style.maxHeight = body.scrollHeight + 'px';
      }
    });

    // En resize, si sale de móvil quita los max-height inline
    window.addEventListener('resize', () => {
      if (!isMobile()) {
        document.querySelectorAll('.mvov-body').forEach(b => {
          b.style.maxHeight = '';
        });
      }
    });
  }

  function initActivitiesCarousel() {
    const isMobile = () => window.innerWidth <= 768;
    const grid = document.getElementById('activitiesGrid');
    if (!grid) return;

    let cur = 0;
    let startX = 0, diffX = 0, isDragging = false;
    let wrapper = null;
    let dotsNav = null;
    let built = false;

    function getCards() {
      return [...grid.querySelectorAll('.activity-card')];
    }

    function goTo(n) {
      const cards = getCards();
      cur = Math.max(0, Math.min(n, cards.length - 1));

      const card = cards[0];
      if (!card) return;
      // ancho real de la tarjeta + su margin-right
      const cardW = card.offsetWidth;
      const marginR = parseFloat(getComputedStyle(card).marginRight) || 0;
      const step = cardW + marginR;

      grid.style.transform = `translateX(-${cur * step}px)`;
      grid.style.transition = 'transform 0.35s cubic-bezier(.25,.46,.45,.94)';

      document.querySelectorAll('.act-carousel-dot').forEach((d, i) =>
        d.classList.toggle('active', i === cur)
      );
    }

    function buildDots(total) {
      dotsNav = document.createElement('div');
      dotsNav.className = 'act-carousel-dots';
      for (let i = 0; i < total; i++) {
        const d = document.createElement('button');
        d.className = 'act-carousel-dot' + (i === 0 ? ' active' : '');
        d.setAttribute('aria-label', 'Actividad ' + (i + 1));
        d.addEventListener('click', () => goTo(i));
        dotsNav.appendChild(d);
      }
      wrapper.insertAdjacentElement('afterend', dotsNav);
    }

function buildCarousel() {
      if (!isMobile()) return;
      const cards = getCards();
      if (cards.length <= 1) return;

      // Crear wrapper
      wrapper = document.createElement('div');
      wrapper.className = 'activities-carousel-wrapper';
      grid.parentNode.insertBefore(wrapper, grid);
      wrapper.appendChild(grid);

      grid.classList.add('is-carousel');
      cur = 0;

      buildDots(cards.length);

      let step = 0;
      let startY = 0;
      let isScrolling = null;

      grid.addEventListener('touchstart', e => {
        const card = getCards()[0];
        const marginR = parseFloat(getComputedStyle(card).marginRight) || 0;
        step = card.offsetWidth + marginR;

        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY; // Guardamos la posición Y inicial
        isDragging = true;
        isScrolling = null; // Reiniciamos la detección en cada toque
        diffX = 0;
      }, { passive: true });

      grid.addEventListener('touchmove', e => {
        if (!isDragging) return;

        const currentX = e.touches[0].clientX;
        const currentY = e.touches[0].clientY;
        
        diffX = currentX - startX;
        const diffY = currentY - startY;

        // Si es el primer movimiento, determinamos si es vertical u horizontal
        if (isScrolling === null) {
          isScrolling = Math.abs(diffY) > Math.abs(diffX);
        }

        // Si es scroll vertical, soltamos el control del carrusel
        if (isScrolling) {
          isDragging = false;
          return;
        }

        // Si es movimiento horizontal, movemos el carrusel
        grid.style.transition = 'none';
        grid.style.transform = `translateX(calc(-${cur * step}px + ${diffX}px))`;
      }, { passive: true });

      grid.addEventListener('touchend', () => {
        // Si el usuario estaba haciendo scroll vertical, ignoramos la acción de cambio de slide
        if (isScrolling) return;

        isDragging = false;
        grid.style.transition = 'transform 0.35s cubic-bezier(.25,.46,.45,.94)';
        
        if (diffX < -50) goTo(cur + 1);
        else if (diffX > 50) goTo(cur - 1);
        else goTo(cur);
      });
    }

    function destroyCarousel() {
      grid.classList.remove('is-carousel');
      grid.style.transform = '';
      grid.style.transition = '';

      if (wrapper) {
        wrapper.parentNode.insertBefore(grid, wrapper);
        wrapper.remove();
        wrapper = null;
      }
      if (dotsNav) { dotsNav.remove(); dotsNav = null; }
      cur = 0;
    }

    function onResize() {
      if (isMobile() && !built) { buildCarousel(); built = true; }
      else if (!isMobile() && built) { destroyCarousel(); built = false; }
    }

    window.addEventListener('resize', onResize);
    if (isMobile()) { buildCarousel(); built = true; }
  }

})();