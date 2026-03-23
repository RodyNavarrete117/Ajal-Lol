<header id="header" class="header">

  <!-- Topbar -->
  <div class="topbar" role="complementary" aria-label="Información de contacto rápido">
    <div class="container">

      <address class="contact-info" style="font-style:normal">
        <i class="bi bi-envelope" aria-hidden="true">
          <a href="mailto:ajal-lol@hotmail.com">ajal-lol@hotmail.com</a>
        </i>
        <i class="bi bi-telephone" aria-hidden="true">
          <a href="tel:+529991773532">+52 999 177 3532</a>
        </i>
      </address>

      <div class="social-links" role="list" aria-label="Redes sociales">
        <a href="https://www.facebook.com/p/Ajal-Lol-AC-100064161455063/"
           aria-label="Facebook" role="listitem" target="_blank" rel="noopener noreferrer">
          <i class="bi bi-facebook" aria-hidden="true"></i>
        </a>
        <a href="https://www.instagram.com/ajal_lol/?hl=es-la"
           aria-label="Instagram" role="listitem" target="_blank" rel="noopener noreferrer">
          <i class="bi bi-instagram" aria-hidden="true"></i>
        </a>
        <a href="https://mx.linkedin.com/in/ajal-lol-a-c-103b811a0"
           aria-label="LinkedIn" role="listitem" target="_blank" rel="noopener noreferrer">
          <i class="bi bi-linkedin" aria-hidden="true"></i>
        </a>
      </div>

    </div>
  </div>

  <!-- Branding + Navegación -->
  <div class="branding">
    <div class="container">

      <a href="{{ url('/') }}" class="logo" aria-label="Ajal Lol A.C. — Inicio">
        <img src="{{ asset('assets/img/ajallol/ImagenPrincipal.png') }}" alt="Logotipo Ajal Lol">
      </a>

      <nav id="navmenu" class="navmenu" aria-label="Navegación principal">
        <button class="nav-close-btn bi bi-x-lg" aria-label="Cerrar menú"></button>
        <ul role="menubar">

          <li role="none">
            <a href="{{ url('/') }}" role="menuitem"
               class="{{ request()->is('/') ? 'active' : '' }}">
              <i class="nav-icon bi bi-house-door"></i>
              Inicio
            </a>
          </li>

          {{-- Nosotros con dropdown --}}
          <li class="nav-dropdown" role="none">
            <a href="{{ url('/#about') }}" class="nav-dropdown-toggle" role="menuitem"
               aria-haspopup="true" aria-expanded="false">
              <i class="nav-icon bi bi-people"></i>
              Nosotros
              <i class="bi bi-chevron-down nav-dropdown-arrow" aria-hidden="true"></i>
            </a>
            <ul class="nav-dropdown-menu" role="menu">
              <li role="none">
                <a href="{{ url('/#about') }}" role="menuitem">
                  <i class="bi bi-book"></i> Historia
                </a>
              </li>
              <li role="none">
                <a href="{{ url('/#team') }}" role="menuitem">
                  <i class="bi bi-person-badge"></i> Directiva
                </a>
              </li>
              <li role="none">
                <a href="{{ url('/#pricing') }}" role="menuitem">
                  <i class="bi bi-star"></i> Identidad
                </a>
              </li>
            </ul>
          </li>

          <li role="none">
            <a href="{{ url('/#services') }}" role="menuitem">
              <i class="nav-icon bi bi-lightning"></i>
              Actividades
            </a>
          </li>

          {{-- Proyectos con dropdown de años --}}
          <li class="nav-dropdown nav-dropdown-proyectos" role="none">
            <a href="{{ url('/#portfolio') }}" class="nav-dropdown-toggle" role="menuitem"
               aria-haspopup="true" aria-expanded="false">
              <i class="nav-icon bi bi-folder2-open"></i>
              Proyectos
              <i class="bi bi-chevron-down nav-dropdown-arrow" aria-hidden="true"></i>
            </a>
            <ul class="nav-dropdown-menu" role="menu">
              <li role="none">
                <a href="{{ route('events.year', ['year' => 2023]) }}" role="menuitem"
                   class="{{ request()->is('events/2023') ? 'active' : '' }}">
                  <i class="bi bi-calendar3" aria-hidden="true"></i> 2023
                </a>
              </li>
              <li role="none">
                <a href="{{ route('events.year', ['year' => 2024]) }}" role="menuitem"
                   class="{{ request()->is('events/2024') ? 'active' : '' }}">
                  <i class="bi bi-calendar3" aria-hidden="true"></i> 2024
                </a>
              </li>
              <li role="none">
                <a href="{{ route('events.year', ['year' => 2025]) }}" role="menuitem"
                   class="{{ request()->is('events/2025') ? 'active' : '' }}">
                  <i class="bi bi-calendar3" aria-hidden="true"></i> 2025
                </a>
              </li>
            </ul>
          </li>

          <li role="none">
            <a href="{{ url('/#faq') }}" role="menuitem">
              <i class="nav-icon bi bi-question-circle"></i>
              Preguntas
            </a>
          </li>

          <li role="none">
            <a href="{{ url('/#contact') }}" role="menuitem">
              <i class="nav-icon bi bi-envelope"></i>
              Contacto
            </a>
          </li>

        </ul>
      </nav>

      <button class="mobile-nav-toggle d-xl-none bi bi-list"
              aria-label="Abrir menú de navegación"
              aria-expanded="false"
              aria-controls="navmenu"></button>

    </div>
  </div>
<script>
  (function () {
    var btn      = document.querySelector('.mobile-nav-toggle');
    var nav      = document.querySelector('#navmenu');
    var overlay  = document.querySelector('#nav-overlay');
    var closeBtn = document.querySelector('.nav-close-btn');

    function closeMenu() {
      nav.style.right = '-110%';
      if (overlay) { overlay.style.opacity = '0'; overlay.style.pointerEvents = 'none'; }
      btn.classList.remove('bi-x-lg');
      btn.classList.add('bi-list');
      document.body.style.overflow = '';
      document.documentElement.style.overflow = '';
      document.body.style.touchAction = '';
      // Cerrar acordeones al cerrar menú
      document.querySelectorAll('.nav-dropdown.open').forEach(function(el) {
        el.classList.remove('open');
      });
    }

    function openMenu() {
      nav.style.right = '0px';
      if (overlay) { overlay.style.opacity = '1'; overlay.style.pointerEvents = 'auto'; }
      btn.classList.remove('bi-list');
      btn.classList.add('bi-x-lg');
      // Bloquear scroll de la página pero NO del menú
      document.body.style.overflow = 'hidden';
      document.documentElement.style.overflow = 'hidden';
      document.body.style.touchAction = 'none';
    }

    if (btn) btn.addEventListener('click', function () {
      nav.style.right === '0px' ? closeMenu() : openMenu();
    });

    if (closeBtn) closeBtn.addEventListener('click', closeMenu);
    if (overlay)  overlay.addEventListener('click', closeMenu);

    /* ─── Evitar que el touch del body se propague cuando el menú está abierto ─── */
    nav.addEventListener('touchstart', function(e) {
      e.stopPropagation();
    }, { passive: true });

    nav.addEventListener('touchmove', function(e) {
      e.stopPropagation(); // el menú sí puede scrollear, la página no
    }, { passive: true });

    /* ─── Acordeón ─── */
    document.querySelectorAll('.nav-dropdown-toggle').forEach(function (toggle) {
      toggle.addEventListener('click', function (e) {
        if (window.innerWidth > 1100) return;

        var parent = this.closest('.nav-dropdown');
        var isOpen = parent.classList.contains('open');

        document.querySelectorAll('.nav-dropdown.open').forEach(function (el) {
          el.classList.remove('open');
        });

        if (!isOpen) {
          parent.classList.add('open');
          e.preventDefault();
        }
      });
    });

    /* Cerrar menú al tocar un link final */
    document.querySelectorAll('#navmenu a:not(.nav-dropdown-toggle)').forEach(function (a) {
      a.addEventListener('click', closeMenu);
    });
  })();
</script>
</header>