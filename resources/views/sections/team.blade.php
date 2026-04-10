<section id="team" class="section">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>{{ $directivaConfig->titulo_directiva ?? 'Directiva' }}</h2>
      <p class="sub">
        <span>{{ Str::words($directivaConfig->subtitulo_directiva ?? 'Comité Directivo', 1, '') }}</span>
        {{ implode(' ', array_slice(explode(' ', $directivaConfig->subtitulo_directiva ?? 'Comité Directivo'), 1)) }}
      </p>
    </div>

    <div class="team-grid" role="list">

      @forelse($directiva as $index => $miembro)
      <article class="team-card"
               data-anim="zoom-in"
               data-delay="{{ $index * 100 }}"
               role="listitem">
        <div class="member-img">
          @if($miembro->foto_directiva)
            <img src="{{ asset('assets/img/team/' . $miembro->foto_directiva) }}"
                 alt="Fotografía de {{ $miembro->nombre_directiva }}, {{ $miembro->cargo_directiva }}"
                 loading="lazy">
          @else
            <div class="member-img-placeholder">
              <i class="fa fa-user" aria-hidden="true"></i>
            </div>
          @endif
        </div>
        <div class="member-info">
          <h3>{{ $miembro->nombre_directiva }}</h3>
          <span>{{ $miembro->cargo_directiva }}</span>
        </div>
      </article>
      @empty
      <p style="text-align:center;color:var(--text-light)">
        No hay miembros registrados aún.
      </p>
      @endforelse

    </div>
  </div>

</section>