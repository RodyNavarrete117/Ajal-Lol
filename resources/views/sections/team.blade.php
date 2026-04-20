<section id="team" class="section">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>{{ !empty($directivaConfig->titulo_directiva) ? $directivaConfig->titulo_directiva : 'Sin título disponible' }}</h2>
      @php
        $subtitulo = !empty($directivaConfig->subtitulo_directiva) ? $directivaConfig->subtitulo_directiva : 'Sin subtítulo disponible';
        $palabras   = explode(' ', $subtitulo);
        $primera    = array_shift($palabras);
        $resto      = implode(' ', $palabras);
      @endphp
      <p class="sub">
        <span>{{ $primera }}</span>{{ $resto ? ' ' . $resto : '' }}
      </p>
    </div>

  <div class="team-carousel-wrapper">
      <div class="team-grid" id="teamGrid" role="list">

        @forelse($directiva as $index => $miembro)
        <article class="team-card"
                data-anim="zoom-in"
                data-delay="{{ $index * 100 }}"
                role="listitem">
          <div class="member-img">
            @if($miembro->foto_directiva)
              <img src="{{ asset('storage/' . $miembro->foto_directiva) }}"
                  alt="Fotografía de {{ $miembro->nombre_directiva }}, {{ $miembro->cargo_directiva }}"
                  loading="lazy">
            @else
              <div class="member-img-placeholder">
                <i class="fa fa-user" aria-hidden="true"></i>
              </div>
            @endif
          </div>
          <div class="member-info">
            <h3>{{ $miembro->nombre_directiva ?? 'Sin nombre' }}</h3>
            <span>{{ $miembro->cargo_directiva ?? 'Sin cargo' }}</span>
          </div>
        </article>
        @empty
        <p style="text-align:center;color:var(--text-light)">No hay miembros registrados aún.</p>
        @endforelse

      </div>
    </div>

    <div class="team-carousel-controls">
      <button class="carousel-btn" id="teamPrev" aria-label="Anterior"><i class="fa fa-chevron-left"></i></button>
      <div class="carousel-dots" id="teamDots"></div>
      <button class="carousel-btn" id="teamNext" aria-label="Siguiente"><i class="fa fa-chevron-right"></i></button>
    </div>
  </div>

</section>