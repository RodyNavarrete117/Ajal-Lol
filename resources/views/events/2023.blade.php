@extends('events.layout')

@section('title', 'Proyectos 2023')
@section('description', 'Eventos y proyectos realizados por Ajal Lol A.C. durante el año 2023.')

@section('content')

{{-- Hero de la sección --}}
<section class="eventos-hero">
  <div class="container">
    <div class="eventos-hero-content" data-anim="fade-up">
      <span class="eventos-eyebrow">
        <i class="bi bi-calendar3" aria-hidden="true"></i>
        Proyectos del año
      </span>
      <h1>2023</h1>
      <p>Un año de impacto en las comunidades mayas de Yucatán. Jornadas de salud, capacitación, proyectos productivos y más.</p>
    </div>

    {{-- Navegación entre años --}}
    <div class="year-nav" data-anim="fade-up" data-delay="100">
      <a href="{{ route('events.year', ['year' => 2023]) }}" class="year-nav-btn active">2023</a>
      <a href="{{ route('events.year', ['year' => 2024]) }}" class="year-nav-btn">2024</a>
      <a href="{{ route('events.year', ['year' => 2025]) }}" class="year-nav-btn">2025</a>
    </div>
  </div>
</section>

{{-- Grid de eventos --}}
<section class="eventos-grid-section section light-bg">
  <div class="container">

    <div class="eventos-grid">

      <article class="evento-card" data-anim="fade-up" data-delay="0">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/dental1.jpg') }}"
               alt="Jornada dental 2023" loading="lazy">
          <span class="evento-card-tag">Salud</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Marzo 2023
          </p>
          <h2>Jornada dental gratuita</h2>
          <p>Con el apoyo de Fundación Smile y Global Dental, un equipo de 35 dentistas brindó servicios gratuitos a 159 pacientes de varios municipios de Yucatán.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Hoctún, Yucatán</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 159 beneficiarios</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="80">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/may1.jpg') }}"
               alt="10 de mayo 2023" loading="lazy">
          <span class="evento-card-tag">Comunidad</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Mayo 2023
          </p>
          <h2>Celebración del 10 de mayo</h2>
          <p>Festejo especial para las madres de comunidades vulnerables, con convivencia, reconocimientos y atención personalizada.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Hoctún, Yucatán</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 200+ asistentes</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="160">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/pavo1.jpg') }}"
               alt="Engorda de pavo 2023" loading="lazy">
          <span class="evento-card-tag">Productivo</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Septiembre 2023
          </p>
          <h2>Programa de engorda de pavo</h2>
          <p>Continuación del proyecto iniciado en 2022. Distribución de pavos de traspatio en 15 localidades del Estado de Yucatán con apoyo de OXXO.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> 15 localidades</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 350 familias</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="0">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/act1.jpg') }}"
               alt="Día del Adulto Mayor 2023" loading="lazy">
          <span class="evento-card-tag">Adulto Mayor</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Agosto 2023
          </p>
          <h2>Día del Adulto Mayor</h2>
          <p>Activación física y convivencia para adultos mayores de la región. Celebración especial con actividades recreativas y atención médica básica.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Hoctún, Yucatán</span>
            <span><i class="bi bi-calendar-check" aria-hidden="true"></i> 27 de agosto</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="80">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/dental2.jpg') }}"
               alt="Jornada de salud 2023" loading="lazy">
          <span class="evento-card-tag">Salud</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Octubre 2023
          </p>
          <h2>Jornada de salud integral</h2>
          <p>Detección gratuita de niveles de azúcar, presión arterial, peso, talla y orientación psicológica. Se beneficiaron 300 personas de Hoctún y municipios cercanos.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Hoctún, Yucatán</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 300 personas</span>
          </div>
        </div>
      </article>

      <article class="evento-card" data-anim="fade-up" data-delay="160">
        <div class="evento-card-img">
          <img src="{{ asset('assets/img/img_proy/pavo2.jpg') }}"
               alt="Talleres de capacitación 2023" loading="lazy">
          <span class="evento-card-tag">Capacitación</span>
        </div>
        <div class="evento-card-body">
          <p class="evento-card-date">
            <i class="bi bi-calendar-event" aria-hidden="true"></i>
            Noviembre 2023
          </p>
          <h2>Talleres de administración básica</h2>
          <p>Con apoyo de Mentors International, cursos de administración para pequeños emprendedores en varios municipios de Yucatán.</p>
          <div class="evento-card-meta">
            <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Varios municipios</span>
            <span><i class="bi bi-people" aria-hidden="true"></i> 150 emprendedores</span>
          </div>
        </div>
      </article>

    </div>
  </div>
</section>

@endsection