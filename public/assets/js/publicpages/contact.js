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

    /* Capturar el HTML original UNA sola vez, antes de cualquier interacción */
    const btn          = form.querySelector('.form-submit');
    const originalHTML = btn.innerHTML.trim();

    on(form, 'submit', e => {
      e.preventDefault();

      /* ── Estado: Enviando ── */
      btn.disabled = true;
      btn.classList.add('form-submit--sending');
      btn.innerHTML = `
        <span>
          <svg class="btn-spinner" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2.5" stroke-dasharray="32" stroke-dashoffset="32" stroke-linecap="round"/>
          </svg>
          Enviando…
        </span>
      `;

      /* ── Simulación (reemplazar con fetch real) ── */
      setTimeout(() => {

        /* ── Estado: Enviado con éxito ── */
        btn.classList.remove('form-submit--sending');
        btn.classList.add('form-submit--success');
        btn.innerHTML = `
          <span>
            <svg viewBox="0 0 24 24" fill="none" width="18" height="18" aria-hidden="true">
              <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            ¡Enviado con éxito!
          </span>
        `;

        /* Mensaje de estado debajo del botón */
        if (status) {
          status.textContent = '✓ ¡Mensaje recibido! Nos pondremos en contacto pronto.';
          status.className   = 'form-status success';
        }

        form.reset();

        /* ── Volver al estado original después de 4 s ── */
        setTimeout(() => {
          btn.disabled = false;
          btn.classList.remove('form-submit--success');
          btn.innerHTML = originalHTML;

          if (status) {
            status.className  = 'form-status';
            status.textContent = '';
          }
        }, 4000);

      }, 1400);
    });

    /* ── Validación visual en tiempo real ── */
    $$('input[required], textarea[required]', form).forEach(input => {
      on(input, 'blur', () => {
        input.style.borderColor = input.checkValidity() ? '' : 'var(--rose-soft)';
      });
      on(input, 'input', () => {
        if (input.value) input.style.borderColor = '';
      });
    });
  }

  /* ── Init ── */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initContactForm);
  } else {
    initContactForm();
  }

})();