/**
 * AJAL LOL — visualpage.js
 * Vanilla JS · Sin dependencias externas
 * Incluye: cursor personalizado, preloader animado, scroll suave,
 *          nav activo, contador animado, marquee, portfolio filter,
 *          lightbox, FAQ, formulario, ripple, parallax hero
 */

(function () {
  'use strict';

  /* ═══════════════════════════════════════════════
     UTILIDADES
  ═══════════════════════════════════════════════ */
  const $ = (sel, ctx = document) => ctx.querySelector(sel);
  const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];
  const on = (el, ev, fn, opts) => el?.addEventListener(ev, fn, opts);

  /* ═══════════════════════════════════════════════
     CURSOR PERSONALIZADO
  ═══════════════════════════════════════════════ */
  function initCursor() {
    // Solo en dispositivos con puntero fino (mouse)
    if (!window.matchMedia('(pointer: fine)').matches) return;

    const dot  = document.createElement('div');
    const ring = document.createElement('div');
    dot.id  = 'cursor-dot';
    ring.id = 'cursor-ring';
    document.body.append(dot, ring);

    let mx = 0, my = 0, rx = 0, ry = 0;

    document.addEventListener('mousemove', e => {
      mx = e.clientX; my = e.clientY;
      // El dot sigue inmediatamente al puntero
      dot.style.left = mx + 'px';
      dot.style.top  = my + 'px';
    });

    // Ring sigue con una inercia mínima y suave (.35 = rápido, casi instantáneo)
    function animateRing() {
      rx += (mx - rx) * .35;
      ry += (my - ry) * .35;
      ring.style.left = rx + 'px';
      ring.style.top  = ry + 'px';
      requestAnimationFrame(animateRing);
    }
    animateRing();

    // Hover en elementos interactivos
    const hoverEls = 'a, button, input, textarea, [data-cursor-hover]';
    on(document, 'mouseover', e => {
      if (e.target.closest(hoverEls)) document.body.classList.add('cursor-hover');
    });
    on(document, 'mouseout', e => {
      if (e.target.closest(hoverEls)) document.body.classList.remove('cursor-hover');
    });

    // Ocultar al salir de la ventana
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
     HEADER — shrink + active nav
  ═══════════════════════════════════════════════ */
  function initHeader() {
    const header   = $('#header');
    const navLinks = $$('.navmenu a[href^="#"]');
    const sections = $$('section[id], #hero');

    on(window, 'scroll', () => {
      // Shrink al hacer scroll
      header?.classList.toggle('scrolled', window.scrollY > 60);

      // Resaltar enlace activo según sección visible
      let current = '';
      sections.forEach(sec => {
        if (window.scrollY >= sec.offsetTop - 140) current = sec.id;
      });
      navLinks.forEach(a => {
        a.classList.toggle('active', a.getAttribute('href') === `#${current}`);
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

    // Cerrar con Escape
    on(document, 'keydown', e => { if (e.key === 'Escape') close(); });
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
     SCROLL TOP
  ═══════════════════════════════════════════════ */
  function initScrollTop() {
    const btn = $('#scroll-top');
    if (!btn) return;
    on(window, 'scroll', () => btn.classList.toggle('visible', window.scrollY > 500), { passive: true });
    on(btn, 'click', e => { e.preventDefault(); window.scrollTo({ top: 0, behavior: 'smooth' }); });
  }

  /* ═══════════════════════════════════════════════
     INTERSECTION OBSERVER — animaciones de entrada
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

    // Envolver en .marquee-outer si no existe
    let outer = track.parentElement;
    if (!outer.classList.contains('marquee-outer')) {
      const wrapper = document.createElement('div');
      wrapper.className = 'marquee-outer';
      track.parentNode.insertBefore(wrapper, track);
      wrapper.appendChild(track);
      outer = wrapper;
    }

    // Duplicar para loop sin corte
    const clone = track.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    outer.appendChild(clone);
  }

  /* ═══════════════════════════════════════════════
     YEAR TABS — cambia el panel activo
  ═══════════════════════════════════════════════ */
  function initYearTabs() {
    const yearBtns = $$('.year-tab');
    const panels   = $$('.year-panel');
    if (!yearBtns.length) return;

    yearBtns.forEach(btn => {
      on(btn, 'click', () => {
        yearBtns.forEach(b => { b.classList.remove('active'); b.setAttribute('aria-selected', 'false'); });
        panels.forEach(p => p.classList.remove('active'));

        btn.classList.add('active');
        btn.setAttribute('aria-selected', 'true');

        const panel = $(`#panel-${btn.dataset.year}`);
        if (panel) {
          panel.classList.add('active');
          // Resetear filtro de categoría al mostrar el panel
          const firstFilter = panel.querySelector('.portfolio-filters button');
          if (firstFilter) firstFilter.click();
        }
      });
    });
  }

  /* ═══════════════════════════════════════════════
     PORTFOLIO — filtros de categoría (por panel)
  ═══════════════════════════════════════════════ */
  function initPortfolio() {
    // Cada .portfolio-filters opera de forma independiente dentro de su panel
    $$('.portfolio-filters').forEach(filterGroup => {
      const btns  = $$('button', filterGroup);
      const panel = filterGroup.closest('.year-panel');
      const items = panel ? $$('.portfolio-item', panel) : $$('.portfolio-item');

      items.forEach(item => { item.style.transition = 'opacity .3s ease'; });

      btns.forEach(btn => {
        on(btn, 'click', () => {
          btns.forEach(b => { b.classList.remove('active'); b.setAttribute('aria-selected', 'false'); });
          btn.classList.add('active');
          btn.setAttribute('aria-selected', 'true');

          const filter = btn.dataset.filter;
          items.forEach(item => {
            const show = filter === '*' || item.classList.contains(filter.replace('.', ''));
            if (show) {
              item.style.display = '';
              requestAnimationFrame(() => { item.style.opacity = '1'; });
            } else {
              item.style.opacity = '0';
              setTimeout(() => { item.style.display = 'none'; }, 300);
            }
          });
        });
      });
    });
  }

  /* ═══════════════════════════════════════════════
     LIGHTBOX
  ═══════════════════════════════════════════════ */
function initLightbox() {
  const lb      = document.getElementById('lightbox');
  const lbImg   = document.getElementById('lightbox-img');
  const lbClose = document.getElementById('lightbox-close');
  if (!lb || !lbImg) return;

  function openLightbox(src) {
    lbImg.src = src;
    lb.style.display = 'flex';
    lb.getBoundingClientRect();
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
    if (lbClose) lbClose.focus();
  }

  function closeLightbox() {
    lb.classList.remove('open');
    document.body.style.overflow = '';
    setTimeout(function() {
      lb.style.display = 'none';
      lbImg.src = '';
    }, 400);
  }

  // Desktop: click en lupa
  document.querySelectorAll('.zoom-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      var img = btn.closest('.portfolio-item').querySelector('img');
      if (img) openLightbox(img.src);
    });
  });

  // Móvil: tap directo en la imagen
  document.querySelectorAll('.portfolio-item img').forEach(function(img) {
    img.addEventListener('touchend', function(e) {
      e.preventDefault();
      openLightbox(img.src);
    });
  });

  // Cerrar con X
  if (lbClose) {
    lbClose.addEventListener('click', function(e) {
      e.stopPropagation();
      closeLightbox();
    });
  }

  // Cerrar al hacer click en el fondo oscuro
  lb.addEventListener('click', function(e) {
    if (e.target === lb) closeLightbox();
  });

  // Cerrar con Escape
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && lb.classList.contains('open')) closeLightbox();
  });

  // Swipe hacia abajo para cerrar en móvil
  var touchStartY = 0;
  lb.addEventListener('touchstart', function(e) {
    touchStartY = e.touches[0].clientY;
  }, { passive: true });
  lb.addEventListener('touchend', function(e) {
    if (e.changedTouches[0].clientY - touchStartY > 80) closeLightbox();
  });
}

 /* ═══════════════════════════════════════════════
     MOBILE PORTFOLIO
  ═══════════════════════════════════════════════ */
function initMobilePortfolio() {
  if (window.innerWidth > 768) return;

  document.body.classList.add('is-touch');

  document.querySelectorAll('.portfolio-grid').forEach(function(grid) {
    var items = Array.from(grid.querySelectorAll('.portfolio-item'));
    if (!items.length) return;

    // Vaciar el grid
    grid.innerHTML = '';

    // Dividir en grupos de 3
    var groups = [];
    for (var i = 0; i < items.length; i += 3) {
      groups.push(items.slice(i, i + 3));
    }

    groups.forEach(function(group) {
      // Contenedor del carrusel
      var carousel = document.createElement('div');
      carousel.className = 'carousel-group';
      group.forEach(function(item) {
        carousel.appendChild(item);
      });
      grid.appendChild(carousel);

      // ── Padding lateral SIEMPRE (grupos de 1, 2 o 3) ──
      carousel.style.paddingLeft  = 'calc((100% - 75vw) / 2)';
      carousel.style.paddingRight = 'calc((100% - 75vw) / 2)';
      carousel.style.boxSizing    = 'border-box';

      // Puntos indicadores solo si hay más de 1 imagen en el grupo
      if (group.length > 1) {
        var dots = document.createElement('div');
        dots.className = 'carousel-dots';
        group.forEach(function(_, idx) {
          var dot = document.createElement('div');
          var dotInicial = (group.length === 3) ? 1 : 0;
          dot.className = 'carousel-dot' + (idx === dotInicial ? ' active' : '');
          dots.appendChild(dot);
        });
        grid.appendChild(dots);

        // Centrar en la 2ª imagen al arrancar (solo si hay 3)
        if (group.length === 3) {
          requestAnimationFrame(function() {
            var itemW = carousel.offsetWidth * 0.75;
            carousel.scrollLeft = itemW;
          });
        }

        // Actualizar punto activo al hacer scroll
        carousel.addEventListener('scroll', function() {
          var itemWidth = carousel.offsetWidth * 0.75;
          var index = Math.round(carousel.scrollLeft / itemWidth);
          dots.querySelectorAll('.carousel-dot').forEach(function(d, i) {
            d.classList.toggle('active', i === index);
          });
        }, { passive: true });
      }
    });

    // Tap en imagen abre lightbox
    grid.querySelectorAll('.portfolio-item').forEach(function(item) {
      var touchStartX = 0;
      var touchStartY = 0;

      item.addEventListener('touchstart', function(e) {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
      }, { passive: true });

      item.addEventListener('touchend', function(e) {
        var deltaX = Math.abs(e.changedTouches[0].clientX - touchStartX);
        var deltaY = Math.abs(e.changedTouches[0].clientY - touchStartY);
        if (deltaX > 10 || deltaY > 10) return;

        e.preventDefault();
        var img = item.querySelector('img');
        if (img) {
          var lb    = document.getElementById('lightbox');
          var lbImg = document.getElementById('lightbox-img');
          if (!lb || !lbImg) return;
          lbImg.src = img.src;
          lb.style.display = 'flex';
          lb.getBoundingClientRect();
          lb.classList.add('open');
          document.body.style.overflow = 'hidden';
        }
      });
    });
  });
}
  /* ═══════════════════════════════════════════════
     FAQ ACCORDION
  ═══════════════════════════════════════════════ */
  function initFaq() {
    const items = $$('.faq-item');
    items.forEach(item => {
      const btn = item.querySelector('.faq-question');
      if (!btn) return;

      // Asegurar que tenga el toggle icon
      if (!btn.querySelector('.faq-toggle')) {
        const icon = document.createElement('span');
        icon.className = 'faq-toggle';
        icon.innerHTML = '<i class="bi bi-chevron-right"></i>';
        btn.appendChild(icon);
      }

      on(btn, 'click', () => {
        const isOpen = item.classList.contains('open');
        // Cerrar todos antes de abrir el actual
        items.forEach(i => {
          i.classList.remove('open');
          i.querySelector('.faq-question')?.setAttribute('aria-expanded', 'false');
        });
        if (!isOpen) {
          item.classList.add('open');
          btn.setAttribute('aria-expanded', 'true');
        }
      });
    });
  }

  /* ═══════════════════════════════════════════════
     FORMULARIO DE CONTACTO
  ═══════════════════════════════════════════════ */
  function initContactForm() {
    const form   = $('#contact-form');
    const status = $('#js-form-status');
    if (!form) return;

    on(form, 'submit', e => {
      e.preventDefault();

      const btn = form.querySelector('.form-submit');
      const originalHTML = btn.innerHTML;

      btn.disabled = true;
      btn.innerHTML = `<span><i class="bi bi-hourglass-split"></i> Enviando…</span>`;

      // Simulación — reemplazar con fetch real cuando haya backend
      setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = originalHTML;

        if (status) {
          status.textContent = '✓ ¡Mensaje recibido! Nos pondremos en contacto pronto.';
          status.className = 'form-status success';
          setTimeout(() => { status.className = 'form-status'; status.textContent = ''; }, 5000);
        }
        form.reset();
      }, 1200);
    });

    // Validación visual en tiempo real
    $$('input[required], textarea[required]', form).forEach(input => {
      on(input, 'blur', () => {
        input.style.borderColor = input.checkValidity() ? '' : 'var(--rose-soft)';
      });
      on(input, 'input', () => {
        if (input.value) input.style.borderColor = '';
      });
    });
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
        Object.assign(ripple.style, {
          width:  size + 'px',
          height: size + 'px',
          left:   x + 'px',
          top:    y + 'px',
        });
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

      circles.forEach((c, i) => {
        c.style.transform = `translateY(${y * (i + 1) * 0.12}px)`;
      });

      if (content) {
        content.style.transform = `translateY(${y * 0.18}px)`;
        content.style.opacity   = String(1 - pct * 1.4);
      }
    }, { passive: true });
  }

  /* ═══════════════════════════════════════════════
     HIGHLIGHT CARD EN HOVER (stats)
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
     INIT
  ═══════════════════════════════════════════════ */
  function init() {
    initCursor();
    initPreloader();
    initHeader();
    initMobileNav();
    initSmoothScroll();
    initScrollTop();
    initAnimations();
    initCounters();
    initMarquee();
    initYearTabs();
    initPortfolio();
    initLightbox();
    initMobilePortfolio();
    initFaq();
    initContactForm();
    initRipple();
    initParallax();
    initStatCards();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();

/* ═══════════════════════════════════════════════
   NAV DROPDOWN
═══════════════════════════════════════════════ */
(function initNavDropdown() {
  const dropdowns = document.querySelectorAll('.nav-dropdown');
  const isMobile  = () => window.innerWidth <= 1100;

  dropdowns.forEach(dd => {
    const toggle = dd.querySelector('.nav-dropdown-toggle');

    // Desktop: hover ya funciona con CSS.
    // Mobile: toggle al hacer click en el enlace padre.
    toggle?.addEventListener('click', e => {
      if (!isMobile()) return;
      e.preventDefault();
      const isOpen = dd.classList.contains('open');
      // Cerrar todos los demás
      dropdowns.forEach(d => d.classList.remove('open'));
      if (!isOpen) dd.classList.add('open');
      toggle.setAttribute('aria-expanded', String(!isOpen));
    });

    // Links del submenú con data-year: navegar y activar el tab del año
    dd.querySelectorAll('.nav-dropdown-menu a[data-year]').forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        const year   = link.dataset.year;
        const target = document.querySelector('#portfolio');
        if (!target) return;

        // Scroll suave a la sección
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Activar el tab de año correspondiente tras el scroll
        setTimeout(() => {
          const yearBtn = document.querySelector(`.year-tab[data-year="${year}"]`);
          yearBtn?.click();
        }, 600);

        // Cerrar menú móvil si está abierto
        document.querySelector('.navmenu')?.classList.remove('open');
        document.querySelector('#nav-overlay')?.classList.remove('open');
        document.body.style.overflow = '';
      });
    });
  });

  // Cerrar dropdowns al hacer click fuera (desktop)
  document.addEventListener('click', e => {
    if (!e.target.closest('.nav-dropdown')) {
      dropdowns.forEach(d => {
        d.classList.remove('open');
        d.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
      });
    }
  });

  // Cerrar con Escape
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      dropdowns.forEach(d => {
        d.classList.remove('open');
        d.querySelector('.nav-dropdown-toggle')?.setAttribute('aria-expanded', 'false');
      });
    }
  });
})();