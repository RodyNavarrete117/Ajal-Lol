<section id="portfolio" class="section light-bg">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Proyectos</h2>
      <p class="sub">Nuestros <span>proyectos 2024</span></p>
    </div>

    <div class="portfolio-filters" role="tablist" aria-label="Filtrar proyectos" data-anim="fade-up">
      <button class="active" data-filter="*"         role="tab" aria-selected="true">Todo</button>
      <button data-filter=".filter-dental"           role="tab" aria-selected="false">Jornadas dentales</button>
      <button data-filter=".filter-mayo"             role="tab" aria-selected="false">Jornadas de salud</button>
      <button data-filter=".filter-pavo"             role="tab" aria-selected="false">Proyectos productivos</button>
      <button data-filter=".filter-adulto"           role="tab" aria-selected="false">Adulto Mayor</button>
    </div>

    <div class="portfolio-grid" data-anim="fade-up" data-delay="100" role="list">

      <div class="portfolio-item filter-dental" role="listitem">
        <img src="{{ asset('assets/img/img_proy/dental1.jpg') }}" alt="Jornada dental — atención a paciente" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Jornada dental</h3>
          <button class="zoom-btn" aria-label="Ampliar imagen de jornada dental"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-dental" role="listitem">
        <img src="{{ asset('assets/img/img_proy/dental2.jpg') }}" alt="Jornada dental — equipo de voluntarios" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Jornada dental</h3>
          <button class="zoom-btn" aria-label="Ampliar imagen de jornada dental"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-mayo" role="listitem">
        <img src="{{ asset('assets/img/img_proy/may1.jpg') }}" alt="Celebración 10 de mayo con madres de familia" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Celebración del 10 de mayo</h3>
          <button class="zoom-btn" aria-label="Ampliar imagen del 10 de mayo"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-mayo" role="listitem">
        <img src="{{ asset('assets/img/img_proy/may2.jpg') }}" alt="Celebración 10 de mayo — actividades" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Celebración del 10 de mayo</h3>
          <button class="zoom-btn" aria-label="Ampliar imagen del 10 de mayo"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-pavo" role="listitem">
        <img src="{{ asset('assets/img/img_proy/pavo1.jpg') }}" alt="Programa de engorda de pavo en comunidad maya" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Engorda de pavo</h3>
          <p>Programa en 15 localidades del Estado de Yucatán</p>
          <button class="zoom-btn" aria-label="Ampliar imagen de engorda de pavo"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-pavo" role="listitem">
        <img src="{{ asset('assets/img/img_proy/pavo2.jpg') }}" alt="Familias beneficiadas por programa de engorda de pavo" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Engorda de pavo</h3>
          <p>Programa en 15 localidades del Estado de Yucatán</p>
          <button class="zoom-btn" aria-label="Ampliar imagen de engorda de pavo"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-pavo" role="listitem">
        <img src="{{ asset('assets/img/img_proy/pavo4.jpg') }}" alt="Entrega de aves en localidades de Yucatán" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Engorda de pavo</h3>
          <p>Programa en 15 localidades del Estado de Yucatán</p>
          <button class="zoom-btn" aria-label="Ampliar imagen de engorda de pavo"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-adulto" role="listitem">
        <img src="{{ asset('assets/img/img_proy/act1.jpg') }}" alt="Día del Adulto Mayor — celebración" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Día del Adulto Mayor</h3>
          <button class="zoom-btn" aria-label="Ampliar imagen del Día del Adulto Mayor"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-adulto" role="listitem">
        <img src="{{ asset('assets/img/img_proy/act2.jpg') }}" alt="Activación física para adultos mayores — 27 de agosto" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Día del Adulto Mayor</h3>
          <p>Activación física — 27 de agosto</p>
          <button class="zoom-btn" aria-label="Ampliar imagen de activación física"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

    </div>
  </div>

  {{-- Lightbox --}}
  <div id="lightbox" class="lightbox-overlay"
       role="dialog" aria-modal="true" aria-label="Imagen ampliada">
    <button id="lightbox-close" class="lightbox-close" aria-label="Cerrar imagen">
      <i class="bi bi-x-lg" aria-hidden="true"></i>
    </button>
    <img id="lightbox-img" class="lightbox-img" src="" alt="Imagen del proyecto ampliada">
  </div>

</section>