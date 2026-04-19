<section id="pricing" class="section">
  <div class="container">
    <div class="section-title">
      <h2>{{ $identity_encabezado->titulo ?: 'Título no disponible' }}</h2>
      <p class="sub">
        {{ $identity_encabezado->subtitulo ?: 'Texto no disponible' }}
      </p>
    </div>

    <div class="mvov-grid">

      {{-- Misión --}}
      @php $mision = $identity_items->get('mision') @endphp
      <div class="mvov-card">
        <h3>
          <i class="bi bi-bullseye" aria-hidden="true"></i>
          {{ $mision->titulo ?? 'Título no disponible' }}
        </h3>
        <ul>
          @if(!empty($mision->contenido))
            @foreach(explode("\n", $mision->contenido) as $linea)
              @if(trim($linea))
              <li>{{ trim($linea) }}</li>
              @endif
            @endforeach
          @else
            <li>Texto no disponible</li>
          @endif
        </ul>
      </div>

      {{-- Visión --}}
      @php $vision = $identity_items->get('vision') @endphp
      <div class="mvov-card">
        <h3>
          <i class="bi bi-eye" aria-hidden="true"></i>
          {{ $vision->titulo ?? 'Título no disponible' }}
        </h3>
        <ul>
          @if(!empty($vision->contenido))
            @foreach(explode("\n", $vision->contenido) as $linea)
              @if(trim($linea))
              <li>{{ trim($linea) }}</li>
              @endif
            @endforeach
          @else
            <li>Texto no disponible</li>
          @endif
        </ul>
      </div>

      {{-- Objetivo General --}}
      @php $objetivo = $identity_items->get('objetivo') @endphp
      <div class="mvov-card">
        <h3>
          <i class="bi bi-flag" aria-hidden="true"></i>
          {{ $objetivo->titulo ?? 'Título no disponible' }}
        </h3>
        <ul>
          @if(!empty($objetivo->contenido))
            @foreach(explode("\n", $objetivo->contenido) as $linea)
              @if(trim($linea))
              <li>{{ trim($linea) }}</li>
              @endif
            @endforeach
          @else
            <li>Texto no disponible</li>
          @endif
        </ul>
      </div>

      {{-- Valores --}}
      @php $valores = $identity_items->get('valores') @endphp
      <div class="mvov-card">
        <h3>
          <i class="bi bi-heart" aria-hidden="true"></i>
          {{ $valores->titulo ?? 'Título no disponible' }}
        </h3>
        <ul>
          @if(!empty($valores->contenido))
            @foreach(explode("\n", $valores->contenido) as $linea)
              @if(trim($linea))
              @php $partes = explode(':', trim($linea), 2) @endphp
              <li>
                @if(count($partes) === 2)
                  <strong>{{ trim($partes[0]) }}:</strong> {{ trim($partes[1]) }}
                @else
                  {{ trim($linea) }}
                @endif
              </li>
              @endif
            @endforeach
          @else
            <li>Texto no disponible</li>
          @endif
        </ul>
      </div>

    </div>
  </div>
</section>