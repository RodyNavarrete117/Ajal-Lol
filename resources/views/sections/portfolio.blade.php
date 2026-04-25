<section id="portfolio" class="section light-bg">
  <div class="container">

    <div class="section-title" data-anim="fade-up" id="title-year">
      <h2>Proyectos</h2>
      <p class="sub">Nuestro <span>trabajo año con año</span></p>
    </div>

  @if($anos->isEmpty())
      <div class="portfolio-empty" data-anim="fade-up">
           <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                <line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="14" x2="15" y2="14"/>
            </svg>
          <p>Aún no hay proyectos publicados.</p>
      </div>
  @else
      {{-- TABS DE AÑO --}}
      <div class="year-tabs" role="tablist" aria-label="Seleccionar año" data-anim="fade-up">
          @foreach($anos as $i => $ano)
              <button class="year-tab {{ $i === 0 ? 'active' : '' }}"
                      data-year="{{ $ano->ano }}"
                      role="tab"
                      aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                      aria-controls="panel-{{ $ano->ano }}">
                  {{ $ano->ano }}
              </button>
          @endforeach
      </div>

      {{-- PANELES POR AÑO --}}
      @foreach($anos as $i => $ano)
          @php
              $imagenesAno = $imagenes->filter(fn($img) => $img->ano->ano == $ano->ano);
              $catsUsadas  = $imagenesAno->map(fn($img) => $img->categoria)->unique('id_categoria');
          @endphp

          <div id="panel-{{ $ano->ano }}"
              class="year-panel {{ $i === 0 ? 'active' : '' }}"
              role="tabpanel">

              {{-- Filtros: solo si hay más de una categoría --}}
              @if($catsUsadas->count() > 1)
                  <div class="portfolio-filters" role="tablist"
                      aria-label="Filtrar proyectos {{ $ano->ano }}" data-anim="fade-up">
                      <button class="active" data-filter="*" role="tab" aria-selected="true">Todo</button>
                      @foreach($catsUsadas as $cat)
                          <button data-filter=".y{{ $ano->ano }}-{{ Str::slug($cat->nombre) }}"
                                  role="tab" aria-selected="false">
                              {{ $cat->nombre }}
                          </button>
                      @endforeach
                  </div>
              @endif

              {{-- Grid --}}
              <div class="portfolio-grid" data-anim="fade-up" data-delay="100" role="list">
                  @foreach($imagenesAno as $img)
                      @php
                          $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                                    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                          $fechaTexto = $img->event_date
                              ? \Carbon\Carbon::parse($img->event_date)->day . ' de ' . $meses[\Carbon\Carbon::parse($img->event_date)->month - 1] . ' · ' . $ano->ano
                              : $ano->ano;
                      @endphp

                      <div class="portfolio-item y{{ $ano->ano }}-{{ Str::slug($img->categoria->nombre) }}"
                          role="listitem"
                          data-titulo="{{ $img->titulo ?? $img->categoria->nombre }}"
                          data-fecha="{{ $fechaTexto }}">

                          <img src="{{ asset('storage/' . $img->image_path) }}"
                              alt="{{ $img->description }}" loading="lazy">

                          <div class="portfolio-info">
                              <h3>{{ $img->titulo ?? $img->categoria->nombre }}</h3>
                              <p>{{ $fechaTexto }}</p>
                              <button class="zoom-btn" aria-label="Ampliar imagen">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                      <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/>
                                  </svg>
                              </button>
                          </div>
                      </div>
                  @endforeach
              </div>

          </div>
      @endforeach
  @endif

  {{-- Lightbox --}}
  <div id="lightbox" class="lightbox-overlay"
       role="dialog" aria-modal="true" aria-label="Imagen ampliada">
        <button id="lightbox-close" class="lightbox-close" aria-label="Cerrar imagen">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    <img id="lightbox-img" class="lightbox-img" src="" alt="Imagen del proyecto ampliada">
  </div>
</section>