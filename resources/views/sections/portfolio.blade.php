<section id="portfolio" class="section light-bg">
  <div class="container">

    <div class="section-title" data-anim="fade-up" id="title-year">
      <h2>Proyectos</h2>
      <p class="sub">Nuestro <span>trabajo año con año</span></p>
    </div>

  @if($anos->isEmpty())
      <div class="portfolio-empty" data-anim="fade-up">
          <i class="bi bi-folder2-open"></i>
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
                      <div class="portfolio-item y{{ $ano->ano }}-{{ Str::slug($img->categoria->nombre) }}"
                          role="listitem">
                          <img src="{{ asset('storage/' . $img->image_path) }}"
                              alt="{{ $img->description }}" loading="lazy">
                          <div class="portfolio-info">
                              <h3>{{ $img->titulo ?? $img->categoria->nombre }}</h3>
                              <p>
                                  @if($img->event_date)
                                      @php
                                          $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                                                    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                                          $d = \Carbon\Carbon::parse($img->event_date);
                                      @endphp
                                      {{ $d->day }} de {{ $meses[$d->month - 1] }} · {{ $ano->ano }}
                                  @else
                                      {{ $ano->ano }}
                                  @endif
                              </p>
                              <button class="zoom-btn" aria-label="Ampliar imagen">
                                  <i class="bi bi-zoom-in" aria-hidden="true"></i>
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
      <i class="bi bi-x-lg" aria-hidden="true"></i>
    </button>
    <img id="lightbox-img" class="lightbox-img" src="" alt="Imagen del proyecto ampliada">
  </div>
</section>