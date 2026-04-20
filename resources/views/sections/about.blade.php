<section id="about" class="about section light-bg">

  <div class="container">
    <div class="section-title">
      <h2>{{ $about_encabezado->titulo ?: 'Título no disponible' }}</h2>
      <p class="sub">
        <span>{{ $about_encabezado->subtitulo ?: 'Texto no disponible' }}</span>
      </p>
    </div>

    <div class="about-grid">

      <div class="about-img-wrapper">
        @if(!empty($about_historia->imagen))
          <img src="{{ Storage::url($about_historia->imagen) }}"
               alt="Integrantes de Ajal Lol A.C. en actividad comunitaria"
               loading="lazy" width="600" height="500">
        @else
          <div class="about-img-placeholder">
            <i class="bi bi-image" aria-hidden="true"></i>
            <span>Sin imagen disponible</span>
          </div>
        @endif

        @if(!empty($about_historia->badge_texto))
        <div class="about-img-badge">
          <i class="bi bi-calendar3" aria-hidden="true"></i>&nbsp;
          {{ $about_historia->badge_texto }}
        </div>
        @endif
      </div>

      <div class="about-content">

        @if(!empty($about_historia->etiqueta_superior))
        <span class="eyebrow">{{ $about_historia->etiqueta_superior }}</span>
        @endif

        @if(!empty($about_historia->titulo_bloque))
        <h3>{{ $about_historia->titulo_bloque }}</h3>
        @endif

        @if(!empty($about_historia->texto_destacado))
        <p class="intro">{{ $about_historia->texto_destacado }}</p>
        @endif

        @if(!empty($about_historia->texto_descriptivo))
        <p>{{ $about_historia->texto_descriptivo }}</p>
        @endif

        @if(empty($about_historia->texto_destacado) && empty($about_historia->texto_descriptivo))
        <p style="color:var(--text-light)">Texto no disponible</p>
        @endif

      </div>

    </div>
  </div>

</section>