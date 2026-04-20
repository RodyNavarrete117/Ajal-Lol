<footer id="footer" class="footer" role="contentinfo">

  <!-- Donaciones -->
  <div class="footer-donate">
    <div class="container">
      <h2 class="footer-donate-title">
        ¡Tu apoyo transforma vidas!
      </h2>
      <p>Te invitamos a hacer una donación a través de PayPal para ayudarnos a continuar con nuestra labor. Cada aporte, por pequeño que sea, nos acerca más a lograr nuestros objetivos.</p>

      <a href="https://paypal.me/AjalLolAC"
         class="btn-paypal" target="_blank" rel="noopener noreferrer"
         aria-label="Donar a Ajal Lol a través de PayPal">
        <span class="btn-paypal__icon">
          <i class="bi bi-paypal" aria-hidden="true"></i>
        </span>
        <span class="btn-paypal__content">
          <span class="btn-paypal__label">Donar con PayPal</span>
          <span class="btn-paypal__sub">Seguro · Rápido · Fácil</span>
        </span>
        <i class="bi bi-arrow-right btn-paypal__arrow" aria-hidden="true"></i>
      </a>

      <p class="thanks">
        <i class="bi bi-heart-fill" aria-hidden="true"></i>
        ¡Gracias por tu generosidad y por formar parte de esta causa!
      </p>
    </div>
  </div>

  <!-- Cuerpo del footer -->
  <div class="container footer-main">

    <div class="footer-about">
      <span class="sitename">Ajal-lol A.C.</span>
      <address style="font-style:normal">
        <p>
          @if(!empty($contacto->direccion_contacto))
            {{ $contacto->direccion_contacto }}<br>
          @else
            <span style="opacity:.6">Dirección no disponible</span><br>
          @endif
          @if(!empty($contacto->horario_contacto))
            {{ $contacto->horario_contacto }}
          @else
            <span style="opacity:.6">Horario no disponible</span>
          @endif
        </p>
        <p style="margin-top:.75rem">
          @if(!empty($contacto->telefono_contacto))
          <i class="bi bi-telephone" aria-hidden="true"></i>&nbsp;
          <a href="tel:{{ preg_replace('/\s+/', '', $contacto->telefono_contacto) }}"
             style="color:inherit">
            {{ $contacto->telefono_contacto }}
          </a><br>
          @else
          <i class="bi bi-telephone" aria-hidden="true"></i>&nbsp;
          <span style="opacity:.6">Teléfono no disponible</span><br>
          @endif

          @if(!empty($contacto->email_contacto))
          <i class="bi bi-envelope" aria-hidden="true"></i>&nbsp;
          <a href="mailto:{{ $contacto->email_contacto }}" style="color:inherit">
            {{ $contacto->email_contacto }}
          </a>
          @else
          <i class="bi bi-envelope" aria-hidden="true"></i>&nbsp;
          <span style="opacity:.6">Correo no disponible</span>
          @endif
        </p>
      </address>
    </div>

    <nav class="footer-links" aria-label="Mapa del sitio">
      <h4>Enlaces útiles</h4>
      <ul>
        <li><a href="#hero"><i class="bi bi-chevron-right" aria-hidden="true"></i> Inicio</a></li>
        <li><a href="#about"><i class="bi bi-chevron-right" aria-hidden="true"></i> Nosotros</a></li>
        <li><a href="#services"><i class="bi bi-chevron-right" aria-hidden="true"></i> Actividades</a></li>
        <li><a href="#portfolio"><i class="bi bi-chevron-right" aria-hidden="true"></i> Proyectos</a></li>
        <li><a href="#team"><i class="bi bi-chevron-right" aria-hidden="true"></i> Directiva</a></li>
        <li><a href="#contact"><i class="bi bi-chevron-right" aria-hidden="true"></i> Contacto</a></li>
      </ul>
    </nav>

    <div class="footer-social">
      <h4>Síguenos</h4>
      <p style="font-size:.88rem;color:rgba(255,255,255,.5);margin-bottom:.5rem">
        Mantente informado de nuestras actividades.
      </p>
      <div class="social-row" role="list" aria-label="Redes sociales">
        @if(!empty($contacto->facebook_url))
        <a href="{{ $contacto->facebook_url }}"
           aria-label="Facebook de Ajal Lol" role="listitem"
           target="_blank" rel="noopener noreferrer">
          <i class="bi bi-facebook" aria-hidden="true"></i>
        </a>
        @endif
        @if(!empty($contacto->instagram_url))
        <a href="{{ $contacto->instagram_url }}"
           aria-label="Instagram de Ajal Lol" role="listitem"
           target="_blank" rel="noopener noreferrer">
          <i class="bi bi-instagram" aria-hidden="true"></i>
        </a>
        @endif
        @if(!empty($contacto->linkedin_url))
        <a href="{{ $contacto->linkedin_url }}"
           aria-label="LinkedIn de Ajal Lol" role="listitem"
           target="_blank" rel="noopener noreferrer">
          <i class="bi bi-linkedin" aria-hidden="true"></i>
        </a>
        @endif
        @if(empty($contacto->facebook_url) && empty($contacto->instagram_url) && empty($contacto->linkedin_url))
          <span style="opacity:.6;font-size:.85rem">Redes no disponibles</span>
        @endif
      </div>
    </div>

  </div>

  <div class="footer-bottom">
    <div class="container">
      <p>©{{ date('Y') }} <span>Ajal-lol A.C.</span> — Todos los derechos reservados</p>
    </div>
  </div>

</footer>