/**
 * AJAL LOL — main.js
 * Vanilla JS. Sin dependencias externas.
 */

document.addEventListener('DOMContentLoaded', () => {

  /* ─── Preloader ─────────────────────────────────────────── */
  const preloader = document.getElementById('preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.classList.add('hidden');
      setTimeout(() => preloader.remove(), 600);
    });
  }

  /* ─── Scroll-top button ──────────────────────────────────── */
  const scrollBtn = document.getElementById('scroll-top');
  if (scrollBtn) {
    window.addEventListener('scroll', () => {
      scrollBtn.classList.toggle('visible', window.scrollY > 400);
    }, { passive: true });
    scrollBtn.addEventListener('click', e => {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ─── Header shrink on scroll ────────────────────────────── */
  const header = document.getElementById('header');
  if (header) {
    window.addEventListener('scroll', () => {
      header.classList.toggle('scrolled', window.scrollY > 60);
    }, { passive: true });
  }

  /* ─── Active nav link on scroll ──────────────────────────── */
  const sections = document.querySelectorAll('section[id], div[id="hero"]');
  const navLinks  = document.querySelectorAll('.navmenu a[href^="#"]');

  const setActiveLink = () => {
    let current = '';
    sections.forEach(sec => {
      if (window.scrollY >= sec.offsetTop - 120) current = sec.id;
    });
    navLinks.forEach(a => {
      a.classList.toggle('active', a.getAttribute('href') === `#${current}`);
    });
  };
  window.addEventListener('scroll', setActiveLink, { passive: true });
  setActiveLink();

  /* ─── Mobile nav ─────────────────────────────────────────── */
  const toggle  = document.querySelector('.mobile-nav-toggle');
  const navMenu = document.querySelector('.navmenu');
  const overlay = document.getElementById('nav-overlay');

  const closeNav = () => {
    navMenu?.classList.remove('open');
    overlay?.classList.remove('open');
    toggle && (toggle.className = 'mobile-nav-toggle d-xl-none bi bi-list');
  };
  const openNav = () => {
    navMenu?.classList.add('open');
    overlay?.classList.add('open');
    toggle && (toggle.className = 'mobile-nav-toggle d-xl-none bi bi-x-lg');
  };

  toggle?.addEventListener('click', () => {
    navMenu?.classList.contains('open') ? closeNav() : openNav();
  });
  overlay?.addEventListener('click', closeNav);
  document.querySelectorAll('.navmenu a').forEach(a => a.addEventListener('click', closeNav));

  /* ─── Smooth scroll for anchor links ────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (!target) return;
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

  /* ─── Intersection Observer animations ──────────────────── */
  const animatedEls = document.querySelectorAll('[data-anim]');
  if (animatedEls.length) {
    const obs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const delay = entry.target.dataset.delay ?? 0;
          setTimeout(() => entry.target.classList.add('animated'), +delay);
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    animatedEls.forEach(el => obs.observe(el));
  }

  /* ─── Stats counter ──────────────────────────────────────── */
  const counters = document.querySelectorAll('.purecounter');
  if (counters.length) {
    const countObs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el    = entry.target;
        const end   = +el.dataset.end;
        const dur   = +el.dataset.duration * 1000 || 1200;
        const start = performance.now();

        const step = (now) => {
          const progress = Math.min((now - start) / dur, 1);
          const eased    = 1 - Math.pow(1 - progress, 3);
          el.textContent = Math.floor(eased * end).toLocaleString('es-MX');
          if (progress < 1) requestAnimationFrame(step);
          else el.textContent = end.toLocaleString('es-MX');
        };
        requestAnimationFrame(step);
        countObs.unobserve(el);
      });
    }, { threshold: 0.5 });
    counters.forEach(el => countObs.observe(el));
  }

  /* ─── Marquee (aliados) duplicate for infinite loop ─────── */
  const track = document.querySelector('.marquee-track');
  if (track) {
    // duplicate children so the loop is seamless
    const clone = track.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    track.parentElement.appendChild(clone);
  }

  /* ─── Portfolio filters ──────────────────────────────────── */
  const filterBtns  = document.querySelectorAll('.portfolio-filters button');
  const portfolioItems = document.querySelectorAll('.portfolio-item');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.dataset.filter;
      portfolioItems.forEach(item => {
        const show = filter === '*' || item.classList.contains(filter.replace('.', ''));
        item.style.display = show ? '' : 'none';
      });
    });
  });

  /* ─── Lightbox ───────────────────────────────────────────── */
  const lightbox    = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');

  document.querySelectorAll('.zoom-btn').forEach(btn => {
    btn.addEventListener('click', e => {
      e.stopPropagation();
      const src = btn.closest('.portfolio-item').querySelector('img').src;
      if (lightboxImg) lightboxImg.src = src;
      lightbox?.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
  });

  const closeLightbox = () => {
    lightbox?.classList.remove('open');
    document.body.style.overflow = '';
  };
  document.getElementById('lightbox-close')?.addEventListener('click', closeLightbox);
  lightbox?.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

  /* ─── FAQ accordion ──────────────────────────────────────── */
  document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
      const item = btn.closest('.faq-item');
      const isOpen = item.classList.contains('open');
      // close all
      document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
      if (!isOpen) item.classList.add('open');
    });
  });

  /* ─── Contact form (demo — integrar con Laravel) ─────────── */
  const form = document.getElementById('contact-form');
  if (form) {
    form.addEventListener('submit', async e => {
      e.preventDefault();
      const btn    = form.querySelector('.form-submit');
      const status = form.querySelector('.form-status');

      btn.disabled = true;
      btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Enviando…';

      try {
        const res = await fetch(form.action, {
          method: 'POST',
          body: new FormData(form),
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (res.ok) {
          status.textContent = '✓ Mensaje enviado. ¡Gracias por contactarnos!';
          status.className = 'form-status success';
          form.reset();
        } else {
          throw new Error();
        }
      } catch {
        status.textContent = '✗ Ocurrió un error. Intenta más tarde.';
        status.className = 'form-status error';
      } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-send"></i> Enviar mensaje';
      }
    });
  }

});