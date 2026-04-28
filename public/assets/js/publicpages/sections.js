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

})();