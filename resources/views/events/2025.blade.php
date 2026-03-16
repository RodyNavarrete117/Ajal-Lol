@extends('events.layout')

@section('title', 'Proyectos 2025')
@section('description', 'Eventos y proyectos realizados por Ajal Lol A.C. durante el año 2025.')

@section('content')

<section class="eventos-hero">
  <div class="container">
    <div class="eventos-hero-content" data-anim="fade-up">
      <span class="eventos-eyebrow">
        <i class="bi bi-calendar3" aria-hidden="true"></i>
        Proyectos del año
      </span>
      <h1>2025</h1>
      <p>Nuevos horizontes y programas innovadores para continuar apoyando a las comunidades más vulnerables de Yucatán.</p>
    </div>

    <div class="year-nav" data-anim="fade-up" data-delay="100">
      <a href="{{ route('events.year', ['year' => 2023]) }}" class="year-nav-btn">2023</a>
      <a href="{{ route('events.year', ['year' => 2024]) }}" class="year-nav-btn">2024</a>
      <a href="{{ route('events.year', ['year' => 2025]) }}" class="year-nav-btn active">2025</a>
    </div>
  </div>
</section>

<section class="eventos-grid-section section light-bg">
  <div class="container">

    <div class="eventos-grid">

      <article class="evento-card" data-anim="fade-up" data-delay="0">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/dental1.jpg') }}"
               alt="Jornada dental 2025" loading="lazy">
          <span class="evento-card-tag">Salud</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Enero 2025
          </p>
          <h2>Jornada dental 4ta edición</h2>
          <p>Inicio de año con nuestra jornada dental ya consolidada. Nuevas alianzas con universidades de odontología para ampliar el alcance del programa.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Hoctún y municipios</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 250+ pacientes</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="80">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/may1.jpg') }}"
               alt="Programa materno infantil 2025" loading="lazy">
          <span class="evento-card-tag">Salud</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Marzo 2025
          </p>
          <h2>Programa materno infantil</h2>
          <p>Nuevo programa de atención a madres y niños en etapa de desarrollo, con seguimiento nutricional y vacunación en zonas de difícil acceso.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Zonas rurales</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 180 familias</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="160">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/pavo1.jpg') }}"
               alt="Granja comunitaria 2025" loading="lazy">
          <span class="evento-card-tag">Productivo</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Mayo 2025
          </p>
          <h2>Granja comunitaria piloto</h2>
          <p>Proyecto piloto de granja comunitaria que integra cría de aves, huerto y compostaje. Modelo sostenible replicable en otras comunidades.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Hoctún, Yucatán</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 50 familias piloto</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="0">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/act2.jpg') }}"
               alt="Festival cultural 2025" loading="lazy">
          <span class="evento-card-tag">Cultura</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Julio 2025
          </p>
          <h2>Festival de cultura maya</h2>
          <p>Primer festival para preservar y difundir la cultura maya entre las nuevas generaciones. Arte, música, gastronomía y lengua maya.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Hoctún, Yucatán</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 500+ asistentes</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="80">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/pavo2.jpg') }}"
               alt="Becas educativas 2025" loading="lazy">
          <span class="evento-card-tag">Educación</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Agosto 2025
          </p>
          <h2>Programa de becas educativas</h2>
          <p>Nuevo programa de becas para jóvenes de comunidades vulnerables que desean continuar sus estudios de preparatoria y universidad.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Estado de Yucatán</span>
            <span><i class="bi bi-mortarboard" aria-hidden="true"></i> 30 becarios</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="160">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/act1.jpg') }}"
               alt="Próximos eventos 2025" loading="lazy">
          <span class="evento-card-tag coming-soon">Próximamente</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Diciembre 2025
          </p>
          <h2>Cierre de año comunitario</h2>
          <p>Gran evento de cierre anual con entrega de reconocimientos a voluntarios, presentación de resultados y planificación participativa para 2026.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Hoctún, Yucatán</span>
            <span><i class="bi bi-clock" aria-hidden="true"></i> Por confirmar</span>
          </div>
        </div>
      </article>

    </div>
  </div>
</section>

@endsection