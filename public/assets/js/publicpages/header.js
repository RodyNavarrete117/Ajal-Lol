/**
 * AJAL LOL — header.js
 * Ruta: assets/js/publicpages/header.js
 * Contiene: Header shrink · Active nav · Mobile nav · Nav dropdown
 * Depende de: utils.js (AjalUtils)
 */

'use strict';

(function () {
  const { $, $$, on } = window.AjalUtils;

  /* ═══════════════════════════════════════════════
     HEADER — shrink + active nav
  ═══════════════════════════════════════════════ */
function initHeader() {
  const branding = $('.branding');
  const topbar   = $('.topbar');
  const navLinks = $$('.navmenu a[href^="#"]');
  const sections = $$('section[id], #hero');
  let lastScroll  = 0;

  // Ejecutar al cargar para posicionar correctamente desde el inicio
  const updateBranding = () => {
    const current        = window.scrollY;
    const topbarHeight   = topbar.offsetHeight;
    const brandingHeight = branding.offsetHeight;
    const offset         = Math.max(0, topbarHeight - current);
    branding.style.top   = offset + 'px';
    branding?.classList.toggle('scrolled', current > topbarHeight);

    // Solo el alto del branding, no incluir el topbar
    const main = document.querySelector('#main');
    if (main) main.style.paddingTop = brandingHeight + 'px';
  };

  // Llamar inmediatamente al cargar
  updateBranding();

  // Y también después de que todo cargue completamente
  window.addEventListener('load', updateBranding);
  setTimeout(updateBranding, 100);

  on(window, 'scroll', () => {
    const current = window.scrollY;
    updateBranding();

    if (current > 1500) {
      if (current > lastScroll) {
        branding?.classList.add('nav-hidden');
      } else {
        branding?.classList.remove('nav-hidden');
      }
    } else {
      branding?.classList.remove('nav-hidden');
    }

    lastScroll = current;

    let currentId = '';
    sections.forEach(sec => {
      if (current >= sec.offsetTop - 140) currentId = sec.id;
    });
    navLinks.forEach(a => {
      a.classList.toggle('active', a.getAttribute('href') === `#${currentId}`);
    });
  }, { passive: true });
}

  /* ═══════════════════════════════════════════════
     MOBILE NAV
  ═══════════════════════════════════════════════ */
  function initMobileNav() {
    const toggle  = $('.mobile-nav-toggle');
    const nav     = $('#navmenu') || $('.navmenu');
    const overlay = $('#nav-overlay');

    const open  = () => {
      nav?.classList.add('open');
      overlay?.classList.add('open');
      toggle?.setAttribute('aria-expanded', 'true');
      toggle?.classList.replace('bi-list', 'bi-x-lg');
      document.body.style.overflow = 'hidden';
    };
    const close = () => {
      nav?.classList.remove('open');
      overlay?.classList.remove('open');
      toggle?.setAttribute('aria-expanded', 'false');
      toggle?.classList.replace('bi-x-lg', 'bi-list');
      document.body.style.overflow = '';
    };

    on(toggle,  'click', () => nav?.classList.contains('open') ? close() : open());
    on(overlay, 'click', close);
    $$('.navmenu a').forEach(a => on(a, 'click', close));
    on(document, 'keydown', e => { if (e.key === 'Escape') close(); });
  }

  /* ═══════════════════════════════════════════════
     NAV DROPDOWN
  ═══════════════════════════════════════════════ */
  function initNavDropdown() {
    const dropdowns = $$('.nav-dropdown');
    const isMobile  = () => window.innerWidth <= 1100;

    dropdowns.forEach(dd => {
      const toggle = dd.querySelector('.nav-dropdown-toggle');

      // Mobile: abrir/cerrar al click
      toggle?.addEventListener('click', e => {
        if (!isMobile()) return;
        e.preventDefault();
        const isOpen = dd.classList.contains('open');
        dropdowns.forEach(d => d.classList.remove('open'));
        if (!isOpen) dd.classList.add('open');
        toggle.setAttribute('aria-expanded', String(!isOpen));
      });

      // Links con data-year: scroll + activar tab
      dd.querySelectorAll('.nav-dropdown-menu a[data-year]').forEach(link => {
        link.addEventListener('click', e => {
          e.preventDefault();
          const year   = link.dataset.year;
          const target = document.querySelector('#portfolio');
          if (!target) return;

          target.scrollIntoView({ behavior: 'smooth', block: 'start' });

          setTimeout(() => {
            document.querySelector(`.year-tab[data-year="${year}"]`)?.click();
          }, 600);

          // Cerrar menú móvil
          document.querySelector('.navmenu')?.classList.remove('open');
          document.querySelector('#nav-overlay')?.classList.remove('open');
          document.body.style.overflow = '';
        });
      });
    });

    // Cerrar al click fuera
    on(document, 'click', e => {
      if (!e.target.closest('.nav-dropdown')) {
        dropdowns.forEach(d => {
          d.classList.remove('open');
          d.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
        });
      }
    });

    // Cerrar con Escape
    on(document, 'keydown', e => {
      if (e.key === 'Escape') {
        dropdowns.forEach(d => {
          d.classList.remove('open');
          d.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
        });
      }
    });
  }

  /* ── Init ── */
  function init() {
    initHeader();
    initMobileNav();
    initNavDropdown();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();