<section id="portfolio" class="section light-bg">

  <div class="container">

    <div class="section-title" data-anim="fade-up">
      <h2>Proyectos</h2>
      <p class="sub">Nuestro <span>trabajo año con año</span></p>
    </div>

    {{-- ══════════════════════════════════════
         TABS DE AÑO (nivel 1)
    ══════════════════════════════════════ --}}
    <div class="year-tabs" role="tablist" aria-label="Seleccionar año" data-anim="fade-up">
      <button class="year-tab active" data-year="2023"
              role="tab" aria-selected="false" aria-controls="panel-2023">
        2023
      </button>
      <button class="year-tab" data-year="2024"
              role="tab" aria-selected="false" aria-controls="panel-2024">
        2024
      </button>
      {{-- Para agregar más años duplica la línea de arriba cambiando data-year y aria-controls --}}
    </div>

    {{-- ══════════════════════════════════════
         PANEL: 2023
    ══════════════════════════════════════ --}}
    <div id="panel-2023" class="year-panel active" role="tabpanel">

      <div class="portfolio-filters" role="tablist" aria-label="Filtrar proyectos 2023" data-anim="fade-up">
        <button class="active" data-filter="*"          role="tab" aria-selected="true">Todo</button>
        <button data-filter=".y2023-dental"             role="tab" aria-selected="false">Jornadas dentales</button>
        <button data-filter=".y2023-salud"              role="tab" aria-selected="false">Jornadas de salud</button>
        <button data-filter=".y2023-productivo"         role="tab" aria-selected="false">Proyectos productivos</button>
        <button data-filter=".y2023-adulto"             role="tab" aria-selected="false">Adulto Mayor</button>
      </div>

      <div class="portfolio-grid" data-anim="fade-up" data-delay="100" role="list">

        <div class="portfolio-item y2023-dental" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/pavo1.jpg" alt="Jornada dental 2023" loading="lazy">
          <div class="portfolio-info">
            <h3>Jornada dental</h3>
            <p>2023</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2023-dental" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/pavo4.jpg" alt="Jornada dental 2023 — voluntarios" loading="lazy">
          <div class="portfolio-info">
            <h3>Jornada dental</h3>
            <p>2023</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2023-salud" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/pavo2.jpg" alt="Celebración 10 de mayo 2023" loading="lazy">
          <div class="portfolio-info">
            <h3>Celebración del 10 de mayo</h3>
            <p>2023</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2023-salud" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/act1.jpg" alt="10 de mayo 2023 — actividades" loading="lazy">
          <div class="portfolio-info">
            <h3>Celebración del 10 de mayo</h3>
            <p>2023</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2023-productivo" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/may2.jpg" alt="Engorda de pavo 2023" loading="lazy">
          <div class="portfolio-info">
            <h3>Engorda de pavo</h3>
            <p>15 localidades · 2023</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2023-productivo" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/may1.jpg" alt="Pavo 2023 — familias beneficiadas" loading="lazy">
          <div class="portfolio-info">
            <h3>Engorda de pavo</h3>
            <p>15 localidades · 2023</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2023-productivo" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/dental1.jpg" alt="Pavo 2023 — entrega" loading="lazy">
          <div class="portfolio-info">
            <h3>Engorda de pavo</h3>
            <p>15 localidades · 2023</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2023-adulto" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/dental2.jpg" alt="Adulto Mayor 2023" loading="lazy">
          <div class="portfolio-info">
            <h3>Día del Adulto Mayor</h3>
            <p>2023</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2023-adulto" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/act2.jpg" alt="Activación física adultos mayores 2023" loading="lazy">
          <div class="portfolio-info">
            <h3>Día del Adulto Mayor</h3>
            <p>Activación física · 2023</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

      </div>
    </div>

    {{-- ══════════════════════════════════════
         PANEL: 2024
    ══════════════════════════════════════ --}}
    <div id="panel-2024" class="year-panel" role="tabpanel">

      <div class="portfolio-filters" role="tablist" aria-label="Filtrar proyectos 2024" data-anim="fade-up">
        <button class="active" data-filter="*"          role="tab" aria-selected="true">Todo</button>
        <button data-filter=".y2024-dental"             role="tab" aria-selected="false">Jornadas dentales</button>
        <button data-filter=".y2024-salud"              role="tab" aria-selected="false">Jornadas de salud</button>
        <button data-filter=".y2024-productivo"         role="tab" aria-selected="false">Proyectos productivos</button>
        <button data-filter=".y2024-adulto"             role="tab" aria-selected="false">Adulto Mayor</button>
      </div>

      <div class="portfolio-grid" data-anim="fade-up" data-delay="100" role="list">

        {{-- ↓ Reemplaza estas imágenes con las reales del año 2024 --}}
        <div class="portfolio-item y2024-dental" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/dental1.jpg" alt="Jornada dental 2024" loading="lazy">
          <div class="portfolio-info">
            <h3>Jornada dental</h3>
            <p>2024</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2024-salud" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/dental2.jpg" alt="Jornada de salud 2024" loading="lazy">
          <div class="portfolio-info">
            <h3>Jornada de salud</h3>
            <p>2024</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2024-productivo" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/may1.jpg" alt="Proyecto productivo 2024" loading="lazy">
          <div class="portfolio-info">
            <h3>Proyecto productivo</h3>
            <p>2024</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

        <div class="portfolio-item y2024-adulto" role="listitem">
          <img src="https://ajal-lol.org/assets/img/img_proy/may2.jpg" alt="Adulto Mayor 2024" loading="lazy">
          <div class="portfolio-info">
            <h3>Adulto Mayor</h3>
            <p>2024</p>
            <button class="zoom-btn" aria-label="Ampliar imagen"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
          </div>
        </div>

      </div>
    </div>

  </div>{{-- /container --}}

  {{-- Lightbox --}}
  <div id="lightbox" class="lightbox-overlay"
       role="dialog" aria-modal="true" aria-label="Imagen ampliada">
    <button id="lightbox-close" class="lightbox-close" aria-label="Cerrar imagen">
      <i class="bi bi-x-lg" aria-hidden="true"></i>
    </button>
    <img id="lightbox-img" class="lightbox-img" src="" alt="Imagen del proyecto ampliada">
  </div>
</section>