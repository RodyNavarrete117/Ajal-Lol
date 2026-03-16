@extends('events.layout')

@section('title', $evento['titulo'] . ' ' . $year)
@section('description', $evento['resumen'])

@section('content')

{{-- Hero del detalle --}}
<section class="detalle-hero">
  <div class="detalle-hero-img">
    <img src="{{ asset($evento['imagen_hero']) }}" alt="{{ $evento['titulo'] }}">
    <div class="detalle-hero-overlay"></div>
  </div>
  <div class="container">
    <div class="detalle-hero-content">
      <div class="detalle-breadcrumb" data-anim="fade-down">
        <a href="{{ url('/') }}">Inicio</a>
        <i class="bi bi-chevron-right" aria-hidden="true"></i>
        <a href="{{ route('events.year', ['year' => $year]) }}">Proyectos {{ $year }}</a>
        <i class="bi bi-chevron-right" aria-hidden="true"></i>
        <span>{{ $evento['titulo'] }}</span>
      </div>
      <span class="evento-card-tag detalle-tag">{{ $evento['categoria'] }}</span>
      <h1 data-anim="fade-up">{{ $evento['titulo'] }}</h1>
      <div class="detalle-hero-meta" data-anim="fade-up" data-delay="100">
        <span><i class="bi bi-calendar-event" aria-hidden="true"></i> {{ $evento['fecha'] }}</span>
        <span><i class="bi bi-geo-alt" aria-hidden="true"></i> {{ $evento['lugar'] }}</span>
        <span><i class="bi bi-people" aria-hidden="true"></i> {{ $evento['beneficiarios'] }}</span>
      </div>
    </div>
  </div>
</section>

{{-- Contenido principal --}}
<section class="detalle-body section light-bg">
  <div class="container">
    <div class="detalle-layout">

      {{-- Columna principal --}}
      <div class="detalle-main">

        {{-- Resumen destacado --}}
        <div class="detalle-resumen" data-anim="fade-up">
          <p>{{ $evento['resumen'] }}</p>
        </div>

        {{-- Descripción completa --}}
        <div class="detalle-texto" data-anim="fade-up" data-delay="80">
          <h2>Sobre este proyecto</h2>
          {!! $evento['descripcion'] !!}
        </div>

        {{-- Galería de imágenes --}}
        <div class="detalle-galeria" data-anim="fade-up" data-delay="120">
          <h2>Galería</h2>
          <div class="detalle-galeria-grid">
            @foreach($evento['galeria'] as $img)
              <div class="detalle-galeria-item">
                <img src="{{ asset($img['src']) }}" alt="{{ $img['alt'] }}" loading="lazy">
              </div>
            @endforeach
          </div>
        </div>

        {{-- Resultados / Impacto --}}
        <div class="detalle-impacto" data-anim="fade-up" data-delay="160">
          <h2>Impacto logrado</h2>
          <div class="detalle-impacto-grid">
            @foreach($evento['impacto'] as $item)
              <div class="detalle-impacto-card">
                <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
                <span class="detalle-impacto-num">{{ $item['numero'] }}</span>
                <span class="detalle-impacto-label">{{ $item['label'] }}</span>
              </div>
            @endforeach
          </div>
        </div>

      </div>

      {{-- Sidebar --}}
      <aside class="detalle-sidebar">

        {{-- Info del evento --}}
        <div class="detalle-sidebar-card" data-anim="fade-left">
          <h3>Información</h3>
          <ul class="detalle-info-list">
            <li>
              <i class="bi bi-calendar3" aria-hidden="true"></i>
              <div>
                <strong>Fecha</strong>
                <span>{{ $evento['fecha'] }}</span>
              </div>
            </li>
            <li>
              <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
              <div>
                <strong>Lugar</strong>
                <span>{{ $evento['lugar'] }}</span>
              </div>
            </li>
            <li>
              <i class="bi bi-people-fill" aria-hidden="true"></i>
              <div>
                <strong>Beneficiarios</strong>
                <span>{{ $evento['beneficiarios'] }}</span>
              </div>
            </li>
            <li>
              <i class="bi bi-tag-fill" aria-hidden="true"></i>
              <div>
                <strong>Categoría</strong>
                <span>{{ $evento['categoria'] }}</span>
              </div>
            </li>
            @if(!empty($evento['aliados']))
            <li>
              <i class="bi bi-building" aria-hidden="true"></i>
              <div>
                <strong>Aliados</strong>
                <span>{{ implode(', ', $evento['aliados']) }}</span>
              </div>
            </li>
            @endif
          </ul>
        </div>

        {{-- Otros eventos del año --}}
        <div class="detalle-sidebar-card" data-anim="fade-left" data-delay="80">
          <h3>Más proyectos {{ $year }}</h3>
          <a href="{{ route('events.year', ['year' => $year]) }}" class="detalle-sidebar-link">
            <i class="bi bi-arrow-left" aria-hidden="true"></i>
            Ver todos los proyectos {{ $year }}
          </a>
        </div>

        {{-- CTA donación --}}
        <div class="detalle-sidebar-cta" data-anim="fade-left" data-delay="160">
          <i class="bi bi-heart-fill" aria-hidden="true"></i>
          <h3>¿Te gustaría apoyar?</h3>
          <p>Tu donación nos permite seguir realizando proyectos como este.</p>
          <a href="https://youtu.be/hPr-Yc92qaY" target="_blank" rel="noopener noreferrer"
             class="detalle-cta-btn">
            <i class="bi bi-paypal" aria-hidden="true"></i> Donar ahora
          </a>
        </div>

      </aside>

    </div>
  </div>
</section>

@endsection