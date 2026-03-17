/**
 * AJAL LOL — contact.js
 * Ruta: assets/js/publicpages/contact.js
 * Contiene: Formulario de contacto · Validación en tiempo real
 * Depende de: utils.js (AjalUtils)
 */

'use strict';

(function () {
  const { $, $$, on } = window.AjalUtils;

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
      on(input, 'blur',  () => { input.style.borderColor = input.checkValidity() ? '' : 'var(--rose-soft)'; });
      on(input, 'input', () => { if (input.value) input.style.borderColor = ''; });
    });
  }

  /* ── Init ── */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initContactForm);
  } else {
    initContactForm();
  }

})();