@extends('events.layout')

@section('title', 'Proyectos 2024')
@section('description', 'Eventos y proyectos realizados por Ajal Lol A.C. durante el año 2024.')

@section('content')

<section class="eventos-hero">
  <div class="container">
    <div class="eventos-hero-content" data-anim="fade-up">
      <span class="eventos-eyebrow">
        <i class="bi bi-calendar3" aria-hidden="true"></i>
        Proyectos del año
      </span>
      <h1>2024</h1>
      <p>Seguimos transformando vidas en las comunidades mayas de Yucatán con nuevos programas y alianzas estratégicas.</p>
    </div>

    <div class="year-nav" data-anim="fade-up" data-delay="100">
      <a href="{{ route('events.year', ['year' => 2023]) }}" class="year-nav-btn">2023</a>
      <a href="{{ route('events.year', ['year' => 2024]) }}" class="year-nav-btn active">2024</a>
      <a href="{{ route('events.year', ['year' => 2025]) }}" class="year-nav-btn">2025</a>
    </div>
  </div>
</section>

<section class="eventos-grid-section section light-bg">
  <div class="container">

    <div class="eventos-grid">

      <article class="evento-card" data-anim="fade-up" data-delay="0">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/dental1.jpg') }}"
               alt="Jornada dental 2024" loading="lazy">
          <span class="evento-card-tag">Salud</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Febrero 2024
          </p>
          <h2>Jornada dental 3ra edición</h2>
          <p>Tercer año consecutivo con jornadas de servicios dentales gratuitos. Ampliamos la cobertura a nuevas comunidades con un equipo de 40 dentistas voluntarios.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Hoctún y alrededores</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 200+ pacientes</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="80">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/may2.jpg') }}"
               alt="Programa de tinacos 2024" loading="lazy">
          <span class="evento-card-tag">Infraestructura</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Abril 2024
          </p>
          <h2>Programa de abastecimiento de agua</h2>
          <p>Entrega de tinacos y sistemas de captación de agua en comunidades con acceso limitado, en alianza con Mariana Trinitaria.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Varias comunidades</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 400+ familias</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="160">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/act2.jpg') }}"
               alt="Reforestación 2024" loading="lazy">
          <span class="evento-card-tag">Medio ambiente</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Junio 2024
          </p>
          <h2>Campaña de reforestación</h2>
          <p>Segunda campaña de reforestación con plantas forestales y maderables donadas por el Ayuntamiento de Mérida en 11 localidades.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> 11 localidades</span>
            <span><i class="bi bi-tree" aria-hidden="true"></i> 2,000 plantas</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="0">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/pavo4.jpg') }}"
               alt="Proyecto productivo 2024" loading="lazy">
          <span class="evento-card-tag">Productivo</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Agosto 2024
          </p>
          <h2>Proyecto de traspatio ampliado</h2>
          <p>Expansión del programa productivo a nuevas comunidades, incluyendo cría de aves y huertos familiares para mejorar la seguridad alimentaria.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> 20 localidades</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 500 familias</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="80">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/act1.jpg') }}"
               alt="Jornada de salud 2024" loading="lazy">
          <span class="evento-card-tag">Salud</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Octubre 2024
          </p>
          <h2>Jornada de salud preventiva</h2>
          <p>Detección temprana de enfermedades crónicas con apoyo de médicos voluntarios. Incluye orientación nutricional y seguimiento de casos.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Hoctún, Yucatán</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 350 personas</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="160">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/dental2.jpg') }}"
               alt="Capacitación digital 2024" loading="lazy">
          <span class="evento-card-tag">Capacitación</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Noviembre 2024
          </p>
          <h2>Talleres de alfabetización digital</h2>
          <p>Nuevo programa de capacitación en herramientas digitales para emprendedores y jóvenes de comunidades rurales, con apoyo de aliados tecnológicos.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Varios municipios</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 120 participantes</span>
          </div>
        </div>
      </article>

    </div>
  </div>
</section>

@endsection