/**
 * AJAL LOL — utils.js
 * Ruta: assets/js/publicpages/utils.js
 * Contiene: Utilidades · Cursor · Preloader · Scroll top
 *           Animaciones (IntersectionObserver) · Ripple · Parallax
 * Debe cargarse primero — los demás módulos dependen de las utilidades
 */

'use strict';

/* ═══════════════════════════════════════════════
   UTILIDADES GLOBALES
   Expuestas en window.AjalUtils para que otros
   módulos puedan reutilizarlas
═══════════════════════════════════════════════ */
window.AjalUtils = {
  $:  (sel, ctx = document) => ctx.querySelector(sel),
  $$: (sel, ctx = document) => [...ctx.querySelectorAll(sel)],
  on: (el, ev, fn, opts)    => el?.addEventListener(ev, fn, opts),
};

const { $, $$, on } = window.AjalUtils;

/* ═══════════════════════════════════════════════
   CURSOR PERSONALIZADO
═══════════════════════════════════════════════ */
function initCursor() {
  if (!window.matchMedia('(pointer: fine)').matches) return;

  const dot  = document.createElement('div');
  const ring = document.createElement('div');
  dot.id  = 'cursor-dot';
  ring.id = 'cursor-ring';
  document.body.append(dot, ring);

  let mx = 0, my = 0, rx = 0, ry = 0;

  document.addEventListener('mousemove', e => {
    mx = e.clientX; my = e.clientY;
    dot.style.left = mx + 'px';
    dot.style.top  = my + 'px';
  });

  function animateRing() {
    rx += (mx - rx) * .35;
    ry += (my - ry) * .35;
    ring.style.left = rx + 'px';
    ring.style.top  = ry + 'px';
    requestAnimationFrame(animateRing);
  }
  animateRing();

  const hoverEls = 'a, button, input, textarea, [data-cursor-hover]';
  on(document, 'mouseover', e => { if (e.target.closest(hoverEls)) document.body.classList.add('cursor-hover'); });
  on(document, 'mouseout',  e => { if (e.target.closest(hoverEls)) document.body.classList.remove('cursor-hover'); });
  on(document, 'mouseleave', () => { dot.style.opacity = '0'; ring.style.opacity = '0'; });
  on(document, 'mouseenter', () => { dot.style.opacity = '1'; ring.style.opacity = '1'; });
}

/* ═══════════════════════════════════════════════
   PRELOADER
═══════════════════════════════════════════════ */
function initPreloader() {
  const loader = $('#preloader');
  if (!loader) return;

  loader.innerHTML = `
    <div class="preloader-logo">Ajal Lol</div>
    <div class="preloader-bar"></div>
  `;

  const hide = () => {
    loader.classList.add('hidden');
    setTimeout(() => loader.remove(), 800);
  };

  if (document.readyState === 'complete') {
    setTimeout(hide, 400);
  } else {
    on(window, 'load', () => setTimeout(hide, 400));
  }
}

/* ═══════════════════════════════════════════════
   SCROLL TOP
═══════════════════════════════════════════════ */
function initScrollTop() {
  const btn = $('#scroll-top');
  if (!btn) return;
  on(window, 'scroll', () => btn.classList.toggle('visible', window.scrollY > 500), { passive: true });
  on(btn, 'click', e => { e.preventDefault(); window.scrollTo({ top: 0, behavior: 'smooth' }); });
}

/* ═══════════════════════════════════════════════
   ANIMACIONES DE ENTRADA (IntersectionObserver)
═══════════════════════════════════════════════ */
function initAnimations() {
  const els = $$('[data-anim]');
  if (!els.length) return;

  const obs = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const delay = +(entry.target.dataset.delay || 0);
      setTimeout(() => entry.target.classList.add('animated'), delay);
      obs.unobserve(entry.target);
    });
  }, { threshold: 0.1 });

  els.forEach(el => obs.observe(el));
}

/* ═══════════════════════════════════════════════
   RIPPLE EN BOTONES
═══════════════════════════════════════════════ */
function initRipple() {
  const btns = $$('.btn-rose, .btn-ghost, .form-submit, .btn-paypal');
  btns.forEach(btn => {
    btn.classList.add('ripple-container');
    on(btn, 'click', e => {
      const rect   = btn.getBoundingClientRect();
      const size   = Math.max(rect.width, rect.height);
      const x      = e.clientX - rect.left - size / 2;
      const y      = e.clientY - rect.top  - size / 2;
      const ripple = document.createElement('span');
      ripple.className = 'ripple';
      Object.assign(ripple.style, { width: size + 'px', height: size + 'px', left: x + 'px', top: y + 'px' });
      btn.appendChild(ripple);
      setTimeout(() => ripple.remove(), 650);
    });
  });
}

/* ═══════════════════════════════════════════════
   PARALLAX SUTIL EN HERO
═══════════════════════════════════════════════ */
function initParallax() {
  const hero    = $('#hero');
  const circles = $$('.hero-circle');
  const content = $('.hero-content');
  if (!hero || !window.matchMedia('(prefers-reduced-motion: no-preference)').matches) return;

  on(window, 'scroll', () => {
    const y = window.scrollY;
    if (y > window.innerHeight) return;
    const pct = y / window.innerHeight;
    circles.forEach((c, i) => { c.style.transform = `translateY(${y * (i + 1) * 0.12}px)`; });
    if (content) {
      content.style.transform = `translateY(${y * 0.18}px)`;
      content.style.opacity   = String(1 - pct * 1.4);
    }
  }, { passive: true });
}

/* ═══════════════════════════════════════════════
   SMOOTH SCROLL
═══════════════════════════════════════════════ */
function initSmoothScroll() {
  on(document, 'click', e => {
    const a = e.target.closest('a[href^="#"]');
    if (!a) return;
    const target = document.querySelector(a.getAttribute('href'));
    if (!target) return;
    e.preventDefault();
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
}

/* ═══════════════════════════════════════════════
   INIT
═══════════════════════════════════════════════ */
function initUtils() {
  initCursor();
  initPreloader();
  initScrollTop();
  initAnimations();
  initRipple();
  initParallax();
  initSmoothScroll();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initUtils);
} else {
  initUtils();
}