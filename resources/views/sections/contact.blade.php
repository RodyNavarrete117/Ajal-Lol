<section id="contact" class="section">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Contacto</h2>
      <p class="sub">¡<span>Comunícate</span> con nosotros!</p>
    </div>

    <div class="contact-layout">

      <!-- Información de contacto -->
      <div class="contact-info-card" data-anim="fade-right">
        <h3>¿Cómo llegar a nosotros?</h3>

        <address style="font-style:normal">
          <div class="info-item">
            <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
            <div>
              <strong>Dirección</strong>
              <p>Calle 24 # 99 x 21 y 19 Col. Centro<br>Hoctún, Yucatán.</p>
              <p style="margin-top:.4rem;font-size:.82rem;color:rgba(255,255,255,.5)">
                Lun–Vie · 9:00 a.m. – 1:00 p.m.
              </p>
            </div>
          </div>

          <div class="info-item">
            <i class="bi bi-telephone-fill" aria-hidden="true"></i>
            <div>
              <strong>Teléfono</strong>
              <p><a href="tel:+529991773532">+52 999 177 3532</a></p>
            </div>
          </div>

          <div class="info-item">
            <i class="bi bi-envelope-fill" aria-hidden="true"></i>
            <div>
              <strong>Correo electrónico</strong>
              <p><a href="mailto:ajal-lol@hotmail.com">ajal-lol@hotmail.com</a></p>
            </div>
          </div>
        </address>

        <div class="contact-map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.135541053421!2d-89.20775672497321!3d20.866586380742497!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f5691c180ca0e89%3A0x5b9e1228aa43b3ff!2sAjal-Lol%20AC!5e0!3m2!1ses-419!2smx!4v1721704139683!5m2!1ses-419!2smx"
            title="Mapa de ubicación de Ajal Lol A.C. en Hoctún, Yucatán"
            allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>

      <!-- Formulario -->
      <div class="contact-form-card" data-anim="fade-left">
        <h3>Envíanos un mensaje</h3>

        <form id="contact-form" novalidate aria-label="Formulario de contacto">

          {{-- Honeypot: oculto para humanos, visible para bots --}}
          <div style="display:none" aria-hidden="true">
            <label for="website">No llenar</label>
            <input type="text" id="website" name="website"
                   tabindex="-1" autocomplete="off">
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="name-field">Nombre completo</label>
              <input type="text" id="name-field" name="name"
                     placeholder="Tu nombre" required autocomplete="name">
            </div>
            <div class="form-group">
              <label for="email-field">Correo electrónico</label>
              <input type="email" id="email-field" name="email"
                     placeholder="tu@correo.com" required autocomplete="email">
            </div>
          </div>

          <div class="form-group">
            <label for="phone-field">
              Teléfono <span style="font-weight:400;color:var(--text-light)">(opcional)</span>
            </label>
            <input type="tel" id="phone-field" name="phone"
                   placeholder="+52 999 000 0000"
                   autocomplete="tel"
                   maxlength="17"
                   pattern="(\+52\s?)?[\d\s\-]{10,15}">
          </div>

          <div class="form-group">
            <label for="subject-field">Asunto</label>
            <input type="text" id="subject-field" name="subject"
                   placeholder="¿En qué podemos ayudarte?" required>
          </div>

          <div class="form-group">
            <label for="message-field">Mensaje</label>
            <textarea id="message-field" name="message"
                      placeholder="Escribe tu mensaje aquí…" required></textarea>
          </div>

          <button type="submit" class="form-submit">
            <i class="bi bi-send" aria-hidden="true"></i> Enviar mensaje
          </button>

          <p class="form-status" id="js-form-status" role="alert" aria-live="polite"></p>
        </form>
      </div>

    </div>
  </div>

</section>