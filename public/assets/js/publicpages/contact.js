/**
 * AJAL LOL — contact.js
 * Ruta: assets/js/publicpages/contact.js
 * Contiene: Formulario de contacto · Validación en tiempo real · Anti-spam
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

    const btn          = form.querySelector('.form-submit');
    const originalHTML = btn.innerHTML.trim();

    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content');

    /* ── Submit ── */
    on(form, 'submit', async e => {
      e.preventDefault();

      clearFieldErrors(form);
      clearStatus(status);

      /* Validar teléfono antes de enviar */
      const phoneInput = form.querySelector('[name="phone"]');
      if (phoneInput && phoneInput.value.trim()) {
        const digits = phoneInput.value.trim().replace(/\D/g, '');
        if (digits.length < 10 || digits.length > 13) {
          phoneInput.style.borderColor = 'var(--rose-soft)';
          showPhoneError(phoneInput, 'Ingresa un número válido (10–13 dígitos).');
          if (status) {
            status.textContent = '✗ Por favor revisa los campos marcados.';
            status.className   = 'form-status error';
          }
          return;
        }
      }

      /* ── Estado: Enviando ── */
      btn.disabled = true;
      btn.classList.add('form-submit--sending');
      btn.innerHTML = `
        <span>
          <svg class="btn-spinner" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2.5"
              stroke-dasharray="32" stroke-dashoffset="32" stroke-linecap="round"/>
          </svg>
          Enviando…
        </span>
      `;

      try {
        const response = await fetch('/contact', {
          method:  'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept':       'application/json',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: JSON.stringify({
            name:    form.querySelector('[name="name"]').value.trim(),
            email:   form.querySelector('[name="email"]').value.trim(),
            phone:   form.querySelector('[name="phone"]').value.trim(),
            subject: form.querySelector('[name="subject"]').value.trim(),
            message: form.querySelector('[name="message"]').value.trim(),
            website: form.querySelector('[name="website"]')?.value ?? '',
          }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
          /* ── Estado: Éxito ── */
          btn.classList.remove('form-submit--sending');
          btn.classList.add('form-submit--success');
          btn.innerHTML = `
            <span>
              <svg viewBox="0 0 24 24" fill="none" width="18" height="18" aria-hidden="true">
                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5"
                  stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              ¡Enviado con éxito!
            </span>
          `;

          if (status) {
            status.textContent = '✓ ¡Mensaje recibido! Nos pondremos en contacto pronto.';
            status.className   = 'form-status success';
          }

          form.reset();

          /* Volver al estado original después de 4 s */
          setTimeout(() => {
            restoreBtn(btn, originalHTML);
            clearStatus(status);
          }, 4000);

        } else if (response.status === 429) {
          /* ── Demasiados intentos ── */
          restoreBtn(btn, originalHTML);

          if (status) {
            status.textContent = '✗ Demasiados intentos. Espera unos minutos e intenta de nuevo.';
            status.className   = 'form-status error';
          }

        } else if (response.status === 422) {
          /* ── Errores de validación de Laravel ── */
          restoreBtn(btn, originalHTML);
          showFieldErrors(form, data.errors ?? {});

          if (status) {
            status.textContent = '✗ Por favor revisa los campos marcados.';
            status.className   = 'form-status error';
          }

        } else {
          /* ── Error general del servidor ── */
          restoreBtn(btn, originalHTML);

          if (status) {
            status.textContent = `✗ ${data.message || 'Ocurrió un error. Intenta de nuevo.'}`;
            status.className   = 'form-status error';
          }
        }

      } catch (err) {
        /* ── Error de red / conexión ── */
        console.error('Contact form error:', err);
        restoreBtn(btn, originalHTML);

        if (status) {
          status.textContent = '✗ Error de conexión. Revisa tu internet e intenta de nuevo.';
          status.className   = 'form-status error';
        }
      }
    });

    /* ── Validación visual en tiempo real — campos requeridos ── */
    $$('input[required], textarea[required]', form).forEach(input => {
      on(input, 'blur', () => {
        input.style.borderColor = input.checkValidity() ? '' : 'var(--rose-soft)';
      });
      on(input, 'input', () => {
        if (input.value) input.style.borderColor = '';
      });
    });

    /* ── Validación teléfono (opcional pero con formato) ── */
    const phoneInput = form.querySelector('[name="phone"]');
    if (phoneInput) {

      on(phoneInput, 'input', () => {
        /* Solo permite: dígitos, espacios, guiones, paréntesis y + */
        phoneInput.value = phoneInput.value.replace(/[^\d\s\-\+\(\)]/g, '');
      });

      on(phoneInput, 'blur', () => {
        const val = phoneInput.value.trim();

        if (!val) {
          phoneInput.style.borderColor = '';
          removePhoneError(phoneInput);
          return;
        }

        const digits = val.replace(/\D/g, '');

        if (digits.length < 10 || digits.length > 13) {
          phoneInput.style.borderColor = 'var(--rose-soft)';
          showPhoneError(phoneInput, 'Ingresa un número válido (10–13 dígitos).');
        } else {
          phoneInput.style.borderColor = '';
          removePhoneError(phoneInput);
        }
      });

      on(phoneInput, 'focus', () => {
        if (!phoneInput.value) phoneInput.placeholder = '+52 999 000 0000';
      });
    }
  }

  /* ═══════════════════════════════════════════════
     HELPERS
  ═══════════════════════════════════════════════ */

  function restoreBtn(btn, originalHTML) {
    btn.disabled = false;
    btn.classList.remove('form-submit--sending', 'form-submit--success');
    btn.innerHTML = originalHTML;
  }

  function clearStatus(status) {
    if (!status) return;
    status.textContent = '';
    status.className   = 'form-status';
  }

  function showFieldErrors(form, errors) {
    const fieldMap = {
      name:    'name-field',
      email:   'email-field',
      phone:   'phone-field',
      subject: 'subject-field',
      message: 'message-field',
    };

    Object.entries(errors).forEach(([field, messages]) => {
      const el = form.querySelector(`#${fieldMap[field]}`);
      if (!el) return;

      el.style.borderColor = 'var(--rose-soft)';

      const hint = document.createElement('span');
      hint.className   = 'field-error';
      hint.textContent = messages[0];
      hint.style.cssText = 'display:block;margin-top:4px;font-size:.8rem;color:var(--rose-soft);';
      el.insertAdjacentElement('afterend', hint);
    });
  }

  function clearFieldErrors(form) {
    form.querySelectorAll('.field-error').forEach(el => el.remove());
    form.querySelectorAll('input, textarea').forEach(el => {
      el.style.borderColor = '';
    });
  }

  function showPhoneError(input, msg) {
    removePhoneError(input);
    const hint = document.createElement('span');
    hint.className   = 'field-error phone-error';
    hint.textContent = msg;
    hint.style.cssText = 'display:block;margin-top:4px;font-size:.8rem;color:var(--rose-soft);';
    input.insertAdjacentElement('afterend', hint);
  }

  function removePhoneError(input) {
    const existing = input.parentElement.querySelector('.phone-error');
    if (existing) existing.remove();
  }

  /* ── Init ── */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initContactForm);
  } else {
    initContactForm();
  }

})();