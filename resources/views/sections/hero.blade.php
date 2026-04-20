<section id="hero" class="hero section" aria-label="Presentación principal">

  <div class="hero-circle hero-circle-1" aria-hidden="true"></div>
  <div class="hero-circle hero-circle-2" aria-hidden="true"></div>
  <div class="hero-circle hero-circle-3" aria-hidden="true"></div>

  <div class="container">
    <div class="hero-content">

      @if(!empty($hero_data->eyebrow))
      <p class="hero-eyebrow">{{ $hero_data->eyebrow }}</p>
      @endif

      <h1>
        {{ $hero_data->titulo_principal ?: 'Título no disponible' }}
        @if(!empty($hero_data->titulo_em))
        <em>{{ $hero_data->titulo_em }}</em>
        @endif
      </h1>

      <p>{{ $hero_data->descripcion ?: 'Texto no disponible' }}</p>

      <div class="hero-buttons">
        <a href="#about" class="btn-rose">
          <i class="bi bi-heart-fill" aria-hidden="true"></i>
          Conoce más
        </a>

        @if($hero_videos->isNotEmpty())
        <a href="{{ $hero_videos->first()->youtube_url }}"
           class="btn-ghost" target="_blank" rel="noopener noreferrer"
           aria-label="Ver video en YouTube">
          <span class="play-icon" aria-hidden="true"><i class="bi bi-play-fill"></i></span>
          Ver video
        </a>
        @endif
      </div>

    </div>
  </div>

  <div class="hero-scroll" aria-hidden="true">
    <div class="hero-scroll-line"></div>
    <span>Scroll</span>
  </div>

</section>