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
     SCROLL SPY
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
     MOBILE NAV — drawer lateral
  ═══════════════════════════════════════════════ */
  function initMobileNav() {
    const btn      = document.querySelector('.mobile-nav-toggle');
    const nav      = document.querySelector('#navmenu');
    const overlay  = document.querySelector('#nav-overlay');
    const closeBtn = document.querySelector('.nav-close-btn');

    if (!nav) return;

    function closeMenu() {
      nav.style.right = '-110%';
      if (overlay) {
        overlay.style.opacity      = '0';
        overlay.style.pointerEvents = 'none';
      }
      btn?.classList.remove('bi-x-lg');
      btn?.classList.add('bi-list');
      btn?.setAttribute('aria-expanded', 'false');
      document.body.style.overflow             = '';
      document.documentElement.style.overflow  = '';
      document.body.style.touchAction          = '';

      /* Cerrar todos los submenús */
      document.querySelectorAll('.nav-dropdown.mob-open')
        .forEach(el => el.classList.remove('mob-open'));
    }

    function openMenu() {
      nav.style.right = '0px';
      if (overlay) {
        overlay.style.opacity      = '1';
        overlay.style.pointerEvents = 'auto';
      }
      btn?.classList.remove('bi-list');
      btn?.classList.add('bi-x-lg');
      btn?.setAttribute('aria-expanded', 'true');
      document.body.style.overflow             = 'hidden';
      document.documentElement.style.overflow  = 'hidden';
      document.body.style.touchAction          = 'none';
    }

    btn?.addEventListener('click', () => {
      const isOpen = nav.style.right === '0px';
      isOpen ? closeMenu() : openMenu();
    });

    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);

    /* Evitar que el scroll del drawer cierre el menú */
    nav.addEventListener('touchstart', e => e.stopPropagation(), { passive: true });
    nav.addEventListener('touchmove',  e => e.stopPropagation(), { passive: true });

    /* Cerrar al hacer clic en enlaces que no son toggles de dropdown */
    nav.querySelectorAll('a:not(.nav-dropdown-toggle)').forEach(a => {
      a.addEventListener('click', closeMenu);
    });

    /* Cerrar con Escape */
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') closeMenu();
    });
  }

  /* ═══════════════════════════════════════════════
     NAV DROPDOWN
     Desktop: hover CSS puro (sin JS).
     Móvil:   acordeón con clase .mob-open en el <li>.
  ═══════════════════════════════════════════════ */
  function initNavDropdown() {
    const dropdowns = document.querySelectorAll('.nav-dropdown');
    const isMobile  = () => window.innerWidth <= 1100;

    dropdowns.forEach(dd => {
      const toggle = dd.querySelector('.nav-dropdown-toggle');
      if (!toggle) return;

      toggle.addEventListener('click', e => {
        /* Solo actuar en móvil */
        if (!isMobile()) return;

        e.preventDefault();
        e.stopPropagation();

        const isOpen = dd.classList.contains('mob-open');

        /* Cerrar todos los demás */
        dropdowns.forEach(d => {
          if (d !== dd) {
            d.classList.remove('mob-open');
            d.querySelector('.nav-dropdown-toggle')
             ?.setAttribute('aria-expanded', 'false');
          }
        });

        /* Toggle el actual */
        dd.classList.toggle('mob-open', !isOpen);
        toggle.setAttribute('aria-expanded', String(!isOpen));
      });
    });

    /* Cerrar dropdowns al hacer clic fuera (solo desktop) */
    document.addEventListener('click', e => {
      if (isMobile()) return;
      if (!e.target.closest('.nav-dropdown')) {
        dropdowns.forEach(d => {
          d.classList.remove('mob-open');
          d.querySelector('.nav-dropdown-toggle')
           ?.setAttribute('aria-expanded', 'false');
        });
      }
    });

    /* Cerrar con Escape */
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        dropdowns.forEach(d => {
          d.classList.remove('mob-open');
          d.querySelector('.nav-dropdown-toggle')
           ?.setAttribute('aria-expanded', 'false');
        });
      }
    });
  }

  /* ═══════════════════════════════════════════════
     SCROLLBAR RADIUS
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

function initHeroVideosModal() {
  const btn   = document.getElementById('btnVideos');
  const modal = document.getElementById('videosModal');
  const close = document.getElementById('closeVideosModal');
  const player = document.getElementById('videoPlayer');

  if (!btn || !modal) return;

  // abrir
  btn.addEventListener('click', () => {
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  });

  // cerrar
  close?.addEventListener('click', () => {
    modal.classList.remove('active');
    player.innerHTML = '';
    document.body.style.overflow = '';
  });

  // cerrar al fondo
  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.remove('active');
      player.innerHTML = '';
      document.body.style.overflow = '';
    }
  });

  // click en videos
  document.querySelectorAll('.video-item').forEach(item => {
    item.addEventListener('click', () => {
      const url = item.dataset.url;
      const id  = getYoutubeId(url);

      player.innerHTML = `
        <iframe width="100%" height="420"
          src="https://www.youtube.com/embed/${id}?autoplay=1"
          frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
        </iframe>
      `;
    });
  });

  function getYoutubeId(url) {
    const match = url.match(/(?:v=|youtu\.be\/)([^&]+)/);
    return match ? match[1] : null;
  }
}