@extends('events.layout')

@section('title', 'Proyectos Destacados')
@section('description', 'Los proyectos más representativos de Ajal Lol A.C. año por año.')

@section('content')

{{-- Hero --}}
<section class="eventos-hero">
  <div class="container">
    <div class="eventos-hero-content" data-anim="fade-up">
      <span class="eventos-eyebrow">
        <i class="bi bi-star-fill" aria-hidden="true"></i>
        Selección especial
      </span>
      <h1 style="font-size:clamp(3rem,7vw,5.5rem)">Destacados</h1>
      <p>Un proyecto emblemático por año — los momentos que mejor representan el trabajo de Ajal Lol A.C. en las comunidades mayas de Yucatán.</p>
    </div>

    <div class="year-nav" data-anim="fade-up" data-delay="100">
      <a href="{{ route('events.leadingevents') }}" class="year-nav-btn active">
        <i class="bi bi-star-fill"></i> Destacados
      </a>
      <a href="{{ route('events.year', ['year' => 2023]) }}" class="year-nav-btn">2023</a>
      <a href="{{ route('events.year', ['year' => 2024]) }}" class="year-nav-btn">2024</a>
      <a href="{{ route('events.year', ['year' => 2025]) }}" class="year-nav-btn">2025</a>
    </div>
  </div>
</section>

{{-- ══════════════════════════════
     DESTACADO 2023
══════════════════════════════ --}}
<section class="destacado-section section">
  <div class="container">

    <div class="destacado-year-label" data-anim="fade-up">
      <span class="destacado-year-num">2023</span>
      <div class="destacado-year-line"></div>
    </div>

    <div class="destacado-layout" data-anim="fade-up" data-delay="80">

      {{-- Galería de imágenes --}}
      <div class="destacado-galeria">
        <div class="destacado-img-principal">
          <img src="{{ asset('assets/img/img_proy/dental1.jpg') }}"
               alt="Jornada dental 2023 — imagen principal" loading="lazy">
          <span class="evento-card-tag">Salud</span>
        </div>
        <div class="destacado-img-secundarias">
          <div class="destacado-img-sec">
            <img src="{{ asset('assets/img/img_proy/dental2.jpg') }}"
                 alt="Jornada dental 2023" loading="lazy">
          </div>
          <div class="destacado-img-sec">
            <img src="{{ asset('assets/img/img_proy/may1.jpg') }}"
                 alt="Equipo de voluntarios" loading="lazy">
          </div>
        </div>
      </div>

      {{-- Contenido --}}
      <div class="destacado-contenido">
        <p class="evento-card-date">
          <i class="bi bi-calendar-event" aria-hidden="true"></i> Marzo 2023
        </p>
        <h2>Jornada dental gratuita</h2>
        <p class="destacado-resumen">
          Por segundo año consecutivo, Ajal Lol coordinó una jornada de salud bucal
          sin precedentes en la región, reuniendo a 35 dentistas voluntarios de Fundación
          Smile y Global Dental para brindar atención a comunidades que normalmente no
          tienen acceso a estos servicios.
        </p>
        <p>
          Durante tres días de intensa actividad, el equipo realizó extracciones, limpiezas,
          obturaciones y orientación preventiva. Cada paciente recibió un kit de higiene
          bucal y seguimiento personalizado. La jornada se extendió a 4 municipios distintos,
          superando la meta original de 100 atenciones.
        </p>

        <div class="destacado-stats">
          <div class="destacado-stat">
            <span class="destacado-stat-num">159</span>
            <span class="destacado-stat-label">Pacientes atendidos</span>
          </div>
          <div class="destacado-stat">
            <span class="destacado-stat-num">35</span>
            <span class="destacado-stat-label">Dentistas voluntarios</span>
          </div>
          <div class="destacado-stat">
            <span class="destacado-stat-num">4</span>
            <span class="destacado-stat-label">Municipios</span>
          </div>
        </div>

        <div class="destacado-aliados">
          <span class="destacado-aliado-label">Aliados:</span>
          <span class="destacado-aliado-tag">Fundación Smile</span>
          <span class="destacado-aliado-tag">Global Dental</span>
        </div>

        <a href="{{ route('events.details', ['year' => 2023, 'slug' => 'jornada-dental']) }}"
           class="destacado-btn">
          Ver proyecto completo <i class="bi bi-arrow-right" aria-hidden="true"></i>
        </a>
      </div>

    </div>
  </div>
</section>

{{-- ══════════════════════════════
     DESTACADO 2024
══════════════════════════════ --}}
<section class="destacado-section section light-bg">
  <div class="container">

    <div class="destacado-year-label" data-anim="fade-up">
      <span class="destacado-year-num">2024</span>
      <div class="destacado-year-line"></div>
    </div>

    <div class="destacado-layout destacado-layout--reverse" data-anim="fade-up" data-delay="80">

      {{-- Galería --}}
      <div class="destacado-galeria">
        <div class="destacado-img-principal">
          <img src="{{ asset('assets/img/img_proy/may2.jpg') }}"
               alt="Programa de agua 2024 — imagen principal" loading="lazy">
          <span class="evento-card-tag">Infraestructura</span>
        </div>
        <div class="destacado-img-secundarias">
          <div class="destacado-img-sec">
            <img src="{{ asset('assets/img/img_proy/pavo4.jpg') }}"
                 alt="Entrega de tinacos" loading="lazy">
          </div>
          <div class="destacado-img-sec">
            <img src="{{ asset('assets/img/img_proy/act2.jpg') }}"
                 alt="Comunidades beneficiadas" loading="lazy">
          </div>
        </div>
      </div>

      {{-- Contenido --}}
      <div class="destacado-contenido">
        <p class="evento-card-date">
          <i class="bi bi-calendar-event" aria-hidden="true"></i> Abril 2024
        </p>
        <h2>Programa de abastecimiento de agua</h2>
        <p class="destacado-resumen">
          En alianza con Mariana Trinitaria, Ajal Lol ejecutó el programa de mayor
          alcance en su historia: llevar agua potable segura a más de 400 familias
          en comunidades donde el acceso al líquido vital es irregular o inexistente.
        </p>
        <p>
          El programa incluyó la instalación de tinacos de alta capacidad, sistemas
          de captación de agua pluvial y talleres de uso eficiente del recurso. Cada
          familia recibió orientación personalizada sobre mantenimiento y conservación.
          El impacto se extendió a comunidades que no habían sido atendidas anteriormente.
        </p>

        <div class="destacado-stats">
          <div class="destacado-stat">
            <span class="destacado-stat-num">400+</span>
            <span class="destacado-stat-label">Familias beneficiadas</span>
          </div>
          <div class="destacado-stat">
            <span class="destacado-stat-num">12</span>
            <span class="destacado-stat-label">Comunidades</span>
          </div>
          <div class="destacado-stat">
            <span class="destacado-stat-num">400+</span>
            <span class="destacado-stat-label">Tinacos instalados</span>
          </div>
        </div>

        <div class="destacado-aliados">
          <span class="destacado-aliado-label">Aliados:</span>
          <span class="destacado-aliado-tag">Mariana Trinitaria</span>
          <span class="destacado-aliado-tag">Ayuntamiento de Mérida</span>
        </div>

        <a href="{{ route('events.details', ['year' => 2024, 'slug' => 'programa-agua']) }}"
           class="destacado-btn">
          Ver proyecto completo <i class="bi bi-arrow-right" aria-hidden="true"></i>
        </a>
      </div>

    </div>
  </div>
</section>

{{-- ══════════════════════════════
     DESTACADO 2025
══════════════════════════════ --}}
<section class="destacado-section section">
  <div class="container">

    <div class="destacado-year-label" data-anim="fade-up">
      <span class="destacado-year-num">2025</span>
      <div class="destacado-year-line"></div>
    </div>

    <div class="destacado-layout" data-anim="fade-up" data-delay="80">

      {{-- Galería --}}
      <div class="destacado-galeria">
        <div class="destacado-img-principal">
          <img src="{{ asset('assets/img/img_proy/act1.jpg') }}"
               alt="Festival cultura maya 2025" loading="lazy">
          <span class="evento-card-tag" style="background:var(--gold);color:var(--text-dark)">Cultura</span>
        </div>
        <div class="destacado-img-secundarias">
          <div class="destacado-img-sec">
            <img src="{{ asset('assets/img/img_proy/act2.jpg') }}"
                 alt="Actividades culturales" loading="lazy">
          </div>
          <div class="destacado-img-sec">
            <img src="{{ asset('assets/img/img_proy/pavo1.jpg') }}"
                 alt="Participantes del festival" loading="lazy">
          </div>
        </div>
      </div>

      {{-- Contenido --}}
      <div class="destacado-contenido">
        <p class="evento-card-date">
          <i class="bi bi-calendar-event" aria-hidden="true"></i> Julio 2025
        </p>
        <h2>Festival de cultura maya</h2>
        <p class="destacado-resumen">
          El primer festival organizado por Ajal Lol para preservar y difundir la
          riqueza cultural maya entre las nuevas generaciones. Un evento histórico
          que reunió a más de 500 personas en una celebración de identidad, lengua
          y tradición.
        </p>
        <p>
          El festival incluyó presentaciones de danza tradicional, concurso de
          gastronomía maya, talleres de lengua yucateca para niños, exposición de
          artesanías y música en vivo. Artistas y artesanos locales tuvieron un
          espacio para mostrar y vender sus obras, generando también ingresos para
          las familias participantes.
        </p>

        <div class="destacado-stats">
          <div class="destacado-stat">
            <span class="destacado-stat-num">500+</span>
            <span class="destacado-stat-label">Asistentes</span>
          </div>
          <div class="destacado-stat">
            <span class="destacado-stat-num">20</span>
            <span class="destacado-stat-label">Artesanos locales</span>
          </div>
          <div class="destacado-stat">
            <span class="destacado-stat-num">8</span>
            <span class="destacado-stat-label">Actividades simultáneas</span>
          </div>
        </div>

        <div class="destacado-aliados">
          <span class="destacado-aliado-label">Aliados:</span>
          <span class="destacado-aliado-tag">INAH Yucatán</span>
          <span class="destacado-aliado-tag">Municipio de Hoctún</span>
        </div>

        <a href="{{ route('events.details', ['year' => 2025, 'slug' => 'festival-maya']) }}"
           class="destacado-btn">
          Ver proyecto completo <i class="bi bi-arrow-right" aria-hidden="true"></i>
        </a>
      </div>

    </div>
  </div>
</section>

@endsection