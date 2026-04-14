<header id="header" class="header">

  <!-- Topbar -->
  <div class="topbar" role="complementary" aria-label="Información de contacto rápido">
    <div class="container">

      <address class="contact-info" style="font-style:normal">
        <i class="bi bi-envelope" aria-hidden="true">
          <a href="mailto:{{ $contacto->email_contacto }}">
            {{ $contacto->email_contacto }}
          </a>
        </i>
        <i class="bi bi-telephone" aria-hidden="true">
          <a href="tel:{{ preg_replace('/\s+/', '', $contacto->telefono_contacto) }}">
            {{ $contacto->telefono_contacto }}
          </a>
        </i>
      </address>

      <div class="social-links" role="list" aria-label="Redes sociales">
        @if($contacto->facebook_url)
        <a href="{{ $contacto->facebook_url }}"
           aria-label="Facebook" role="listitem" target="_blank" rel="noopener noreferrer">
          <i class="bi bi-facebook" aria-hidden="true"></i>
        </a>
        @endif
        @if($contacto->instagram_url)
        <a href="{{ $contacto->instagram_url }}"
           aria-label="Instagram" role="listitem" target="_blank" rel="noopener noreferrer">
          <i class="bi bi-instagram" aria-hidden="true"></i>
        </a>
        @endif
        @if($contacto->linkedin_url)
        <a href="{{ $contacto->linkedin_url }}"
           aria-label="LinkedIn" role="listitem" target="_blank" rel="noopener noreferrer">
          <i class="bi bi-linkedin" aria-hidden="true"></i>
        </a>
        @endif
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

          <li class="nav-dropdown nav-dropdown-proyectos" role="none">
              <a href="{{ url('/#portfolio') }}" class="nav-dropdown-toggle" role="menuitem"
                aria-haspopup="true" aria-expanded="false">
                  <i class="nav-icon bi bi-folder2-open"></i>
                  Proyectos
                  <i class="bi bi-chevron-down nav-dropdown-arrow" aria-hidden="true"></i>
              </a>
              <ul class="nav-dropdown-menu" role="menu">
                  @foreach($anos as $ano)
                  <li role="none">
                      <a href="{{ route('events.year', ['year' => $ano->ano]) }}" role="menuitem">
                          <i class="bi bi-calendar3" aria-hidden="true"></i> {{ $ano->ano }}
                      </a>
                  </li>
                  @endforeach
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
</header>