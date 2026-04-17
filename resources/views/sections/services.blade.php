<section id="services" class="section">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Actividades</h2>
      <p class="sub">
        Nuestras actividades del:
        <span class="year-label-inline">{{ $act_ano_activo }}</span>
      </p>
    </div>

    {{-- ── Selector de años ── --}}
    @php
        $anosOrdenados  = $act_anos->sortBy('ano')->values();
        $anosRecientes  = $anosOrdenados->filter(fn($a) => $a->ano >= ($act_ano_activo - 2))->values();
        $anosAnteriores = $anosOrdenados->filter(fn($a) => $a->ano <  ($act_ano_activo - 2))->values();
    @endphp

    <div class="year-selector" data-anim="fade-up" role="tablist" aria-label="Seleccionar año de actividades"
         data-route="{{ route('public.actividades.byAno', ':ano') }}"
         data-ano-activo="{{ $act_ano_activo }}">

      {{-- "···" solo si hay años anteriores --}}
      @if($anosAnteriores->isNotEmpty())
      <div class="year-selector__dots" id="yearDots">
        <button class="year-btn year-btn--dots" id="dotsToggle"
                aria-expanded="false" aria-haspopup="listbox"
                title="Ver años anteriores">
          <span>···</span>
        </button>
        <div class="year-dropdown" id="yearDropdown" role="listbox" aria-label="Años anteriores">
          @foreach($anosAnteriores as $yr)
          <button class="year-dropdown__item {{ $yr->ano == $act_ano_activo ? 'active' : '' }}"
                  data-year="{{ $yr->ano }}" role="option">
            {{ $yr->ano }}
          </button>
          @endforeach
        </div>
      </div>
      <div class="year-selector__divider" aria-hidden="true"></div>
      @endif

      {{-- Años recientes visibles como pills --}}
      @foreach($anosRecientes as $yr)
      <button class="year-btn {{ $yr->ano == $act_ano_activo ? 'active' : '' }}"
              data-year="{{ $yr->ano }}"
              role="tab"
              aria-selected="{{ $yr->ano == $act_ano_activo ? 'true' : 'false' }}">
        {{ $yr->ano }}
      </button>
      @endforeach

    </div>

    {{-- ── Grid de actividades ── --}}
    <div class="activities-grid year-visible" role="list" id="activitiesGrid">

      @forelse($act_actividades as $i => $act)
      <article class="activity-card" role="listitem">
        <div class="icon" aria-hidden="true">
          <i class="fa {{ $act->icono_actividad ?? 'fa-star' }}"></i>
        </div>
        <h3>{{ $act->titulo_actividad }}</h3>
        <p>{{ $act->texto_actividad }}</p>
      </article>
      @empty
      <div class="year-empty" role="status" aria-live="polite">
        <div class="year-empty__icon"><i class="fas fa-calendar-xmark"></i></div>
        <p class="year-empty__title">Sin actividades registradas</p>
        <p class="year-empty__sub">
          No hay actividades disponibles para el año
          <strong>{{ $act_ano_activo }}</strong>.
        </p>
      </div>
      @endforelse

    </div>
  </div>

</section>