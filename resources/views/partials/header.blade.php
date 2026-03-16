<header id="header" class="header sticky-top">

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
        <img src="{{ asset('assets/img/logo.webp') }}" alt="Logotipo Ajal Lol" width="90" height="54">
      </a>

      <nav id="navmenu" class="navmenu" aria-label="Navegación principal">
        <ul role="menubar">

          <li role="none">
            <a href="{{ url('/') }}" role="menuitem"
               class="{{ request()->is('/') ? 'active' : '' }}">
              Inicio
            </a>
          </li>

          {{-- Nosotros con dropdown --}}
          <li class="nav-dropdown" role="none">
            <a href="{{ url('/#about') }}" class="nav-dropdown-toggle" role="menuitem"
               aria-haspopup="true" aria-expanded="false">
              Nosotros
              <i class="bi bi-chevron-down nav-dropdown-arrow" aria-hidden="true"></i>
            </a>
            <ul class="nav-dropdown-menu" role="menu">
              <li role="none"><a href="{{ url('/#about') }}"   role="menuitem">Historia</a></li>
              <li role="none"><a href="{{ url('/#team') }}"    role="menuitem">Directiva</a></li>
              <li role="none"><a href="{{ url('/#pricing') }}" role="menuitem">Identidad</a></li>
            </ul>
          </li>

          <li role="none">
            <a href="{{ url('/#services') }}" role="menuitem">Actividades</a>
          </li>

          {{-- Proyectos con dropdown de años --}}
          <li class="nav-dropdown" role="none">
            <a href="{{ url('/#portfolio') }}" class="nav-dropdown-toggle" role="menuitem"
               aria-haspopup="true" aria-expanded="false">
              Proyectos
              <i class="bi bi-chevron-down nav-dropdown-arrow" aria-hidden="true"></i>
            </a>
            <ul class="nav-dropdown-menu" role="menu">
              <li role="none">
                <a href="{{ url('/#portfolio') }}" role="menuitem">
                  <i class="bi bi-grid-3x3-gap" aria-hidden="true"></i> General
                </a>
              </li>
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
            <a href="{{ url('/#faq') }}" role="menuitem">FAQ</a>
          </li>
          <li role="none">
            <a href="{{ url('/#contact') }}" role="menuitem">Contacto</a>
          </li>

        </ul>
      </nav>

      <button class="mobile-nav-toggle d-xl-none bi bi-list"
              aria-label="Abrir menú de navegación"
              aria-expanded="false"
              aria-controls="navmenu"></button>

    </div>
  </div>

</header>