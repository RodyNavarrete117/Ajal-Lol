'use strict';

(function () {

  /* ═══════════════════════════════════════════════
     BRANDING — shrink + hide on scroll
  ═══════════════════════════════════════════════ */
  function initHeader() {
    const branding = document.querySelector('.branding');
    const topbar   = document.querySelector('.topbar');
    let lastScroll  = 0;

    const updateBranding = () => {
      const current        = window.scrollY;
      const topbarHeight   = topbar ? topbar.offsetHeight : 0;
      const brandingHeight = branding ? branding.offsetHeight : 0;
      const offset         = Math.max(0, topbarHeight - current);

      if (branding) branding.style.top = offset + 'px';
      branding?.classList.toggle('scrolled', current > topbarHeight);

      const main = document.querySelector('#main');
      if (main) main.style.paddingTop = brandingHeight + 'px';
    };

    updateBranding();
    window.addEventListener('load', updateBranding);
    setTimeout(updateBranding, 100);

    window.addEventListener('scroll', () => {
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
    }, { passive: true });
  }

  /* ═══════════════════════════════════════════════
     SCROLL SPY — activa el link según la sección
  ═══════════════════════════════════════════════ */
  function initScrollSpy() {
    const branding = document.querySelector('.branding');
    const sections = document.querySelectorAll('section[id], #hero');
    const navLinks = document.querySelectorAll('.navmenu a');

    function update() {
      const scroll  = window.scrollY;
      const offset  = (branding ? branding.offsetHeight : 70) + 30;
      let currentId = '';

      sections.forEach(sec => {
        if (scroll >= sec.offsetTop - offset) currentId = sec.id;
      });

      navLinks.forEach(a => {
        let match = false;

        if (currentId === 'hero') {
          match = a.hash === '' && a.pathname === window.location.pathname;
        } else {
          match = !!currentId && a.hash === `#${currentId}`;
        }

        a.classList.toggle('active', match);
      });
    }

    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('load',   update);
    setTimeout(update, 300);
  }

  /* ═══════════════════════════════════════════════
     MOBILE NAV
  ═══════════════════════════════════════════════ */
  function initMobileNav() {
    const btn      = document.querySelector('.mobile-nav-toggle');
    const nav      = document.querySelector('#navmenu');
    const overlay  = document.querySelector('#nav-overlay');
    const closeBtn = document.querySelector('.nav-close-btn');

    function closeMenu() {
      nav.style.right = '-110%';
      if (overlay) { overlay.style.opacity = '0'; overlay.style.pointerEvents = 'none'; }
      btn?.classList.remove('bi-x-lg');
      btn?.classList.add('bi-list');
      btn?.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
      document.documentElement.style.overflow = '';
      document.body.style.touchAction = '';
      document.querySelectorAll('.nav-dropdown.open').forEach(el => el.classList.remove('open'));
    }

    function openMenu() {
      nav.style.right = '0px';
      if (overlay) { overlay.style.opacity = '1'; overlay.style.pointerEvents = 'auto'; }
      btn?.classList.remove('bi-list');
      btn?.classList.add('bi-x-lg');
      btn?.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
      document.documentElement.style.overflow = 'hidden';
      document.body.style.touchAction = 'none';
    }

    btn?.addEventListener('click', () => nav.style.right === '0px' ? closeMenu() : openMenu());
    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);

    nav?.addEventListener('touchstart', e => e.stopPropagation(), { passive: true });
    nav?.addEventListener('touchmove',  e => e.stopPropagation(), { passive: true });

    document.querySelectorAll('#navmenu a:not(.nav-dropdown-toggle)').forEach(a => {
      a.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });
  }

  /* ═══════════════════════════════════════════════
     NAV DROPDOWN — acordeón móvil
  ═══════════════════════════════════════════════ */
  function initNavDropdown() {
    const dropdowns = document.querySelectorAll('.nav-dropdown');
    const isMobile  = () => window.innerWidth <= 1100;

    dropdowns.forEach(dd => {
      const toggle = dd.querySelector('.nav-dropdown-toggle');

      toggle?.addEventListener('click', e => {
        if (!isMobile()) return;
        e.preventDefault();
        const isOpen = dd.classList.contains('open');
        dropdowns.forEach(d => d.classList.remove('open'));
        if (!isOpen) dd.classList.add('open');
        toggle.setAttribute('aria-expanded', String(!isOpen));
      });

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

          document.querySelector('.navmenu')?.classList.remove('open');
          document.querySelector('#nav-overlay')?.classList.remove('open');
          document.body.style.overflow = '';
        });
      });
    });

    document.addEventListener('click', e => {
      if (!e.target.closest('.nav-dropdown')) {
        dropdowns.forEach(d => {
          d.classList.remove('open');
          d.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
        });
      }
    });

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        dropdowns.forEach(d => {
          d.classList.remove('open');
          d.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
        });
      }
    });
  }

    /* ═══════════════════════════════════════════════
     SCROLLBAR RADIUS — quita bordes en extremos
  ═══════════════════════════════════════════════ */
  function initScrollbarRadius() {
    const html = document.documentElement;

    function update() {
      const scroll    = window.scrollY;
      const maxScroll = document.body.scrollHeight - window.innerHeight;

      html.classList.toggle('scroll-top',    scroll < 10);
      html.classList.toggle('scroll-bottom', scroll > maxScroll - 10);
    }

    window.addEventListener('scroll', update, { passive: true });
    update();
  }

  /* ── Init ── */
  function init() {
    initHeader();
    initScrollSpy();
    initMobileNav();
    initNavDropdown();
    initScrollbarRadius();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();