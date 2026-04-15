<section id="clients" class="section light-bg" aria-label="Nuestros aliados y patrocinadores">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>{{ $aliados_config->titulo_seccion ?? 'Aún no hay título en este momento' }}</h2>
      <p class="sub">{{ $aliados_config->descripcion ?? 'Aún no hay descripción en este momento' }}</p>
    </div>
  </div>

  @php
    $logosList = isset($aliados)
        ? $aliados->filter(fn($a) => !empty($a->img_path))->values()
        : collect([]);

    $total = $logosList->count();

    // Repetir logos hasta tener al menos 8 para llenar las 6 columnas
    $logosExtended = collect();
    if ($total > 0) {
        while ($logosExtended->count() < 8) {
            $logosExtended = $logosExtended->concat($logosList);
        }
        $logosExtended = $logosExtended->values();
    }

    $sizes = ['card-lg', 'card-sm', 'card-md'];

    $columns = [
        ['col-up',   '22s', [0, 1, 2, 3]],
        ['col-down', '18s', [4, 5, 6, 7]],
        ['col-up',   '25s', [1, 5, 0, 4]],
        ['col-down', '20s', [3, 2, 6, 7]],
        ['col-up',   '23s', [3, 4, 0, 2]],
        ['col-down', '19s', [6, 1, 5, 7]],
    ];
  @endphp

  @if($total > 0)

  <div class="masonry-viewport" aria-label="Galería de aliados">
    <div class="masonry-columns">

      @foreach($columns as [$dir, $dur, $indices])
      <div class="col-track {{ $dir }}" style="--dur:{{ $dur }}">
        @php
          $colLogos = collect($indices)->map(fn($idx) => $logosExtended[$idx]);
          $colLogos = $colLogos->concat($colLogos);
        @endphp
        @foreach($colLogos as $j => $logo)
        @php $size = $sizes[$j % count($sizes)]; @endphp
        <div class="logo-card {{ $size }}">
          <img src="{{ asset('storage/' . $logo->img_path) }}"
               alt="Aliado"
               loading="lazy">
        </div>
        @endforeach
      </div>
      @endforeach

    </div>
  </div>

  @else
  <div class="container">
    <p style="text-align:center; color: var(--color-muted, #999); padding: 40px 0; font-size: 15px;">
      Sin aliados de momento.
    </p>
  </div>
  @endif

</section>