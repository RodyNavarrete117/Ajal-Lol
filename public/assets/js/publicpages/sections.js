/**
 * AJAL LOL — sections.js
 * Ruta: assets/js/publicpages/sections.js
 * Contiene: Contadores animados · Marquee infinito
 *           Stats hover · FAQ accordion
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
  document.addEventListener('click', function(e) {
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

  /* ── Init ── */
  function init() {
    initCounters();
    initMarquee();
    initStatCards();
    initFaq();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();