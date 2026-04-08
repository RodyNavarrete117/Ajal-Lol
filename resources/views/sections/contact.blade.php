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

          @if($contacto->direccion_contacto)
          <div class="info-item">
            <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
            <div>
              <strong>Dirección</strong>
              <p>{{ $contacto->direccion_contacto }}</p>
              @if($contacto->horario_contacto)
              <p style="margin-top:.4rem;font-size:.82rem;color:rgba(255,255,255,.5)">
                {{ $contacto->horario_contacto }}
              </p>
              @endif
            </div>
          </div>
          @endif

          @if($contacto->telefono_contacto)
          <div class="info-item">
            <i class="bi bi-telephone-fill" aria-hidden="true"></i>
            <div>
              <strong>Teléfono</strong>
              <p>
                <a href="tel:{{ preg_replace('/\s+/', '', $contacto->telefono_contacto) }}">
                  {{ $contacto->telefono_contacto }}
                </a>
              </p>
            </div>
          </div>
          @endif

          @if($contacto->email_contacto)
          <div class="info-item">
            <i class="bi bi-envelope-fill" aria-hidden="true"></i>
            <div>
              <strong>Correo electrónico</strong>
              <p>
                <a href="mailto:{{ $contacto->email_contacto }}">
                  {{ $contacto->email_contacto }}
                </a>
              </p>
            </div>
          </div>
          @endif

        </address>

        {{-- Mapa: solo se renderiza si hay embed guardado en BD --}}
        @if($contacto->mapa_embed)
        <div class="contact-map">
          {!! $contacto->mapa_embed !!}
        </div>
        @endif

      </div>

      <!-- Formulario -->
      <div class="contact-form-card" data-anim="fade-left">
        <h3>Envíanos un mensaje</h3>

        <form id="contact-form" novalidate aria-label="Formulario de contacto">

          {{-- Honeypot --}}
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