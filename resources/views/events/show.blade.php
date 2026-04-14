@extends('events.layout')

@section('title', 'Proyectos ' . $ano->ano)
@section('description', 'Proyectos realizados por Ajal Lol A.C. durante el año ' . $ano->ano . '.')

@section('content')

<section class="eventos-hero">
  <div class="container">
    <div class="eventos-hero-content" data-anim="fade-up">
      <span class="eventos-eyebrow">
        <i class="bi bi-calendar3" aria-hidden="true"></i>
        Proyectos del año
      </span>
      <h1>{{ $ano->ano }}</h1>
      @if($ano->subtitulo)
        <p>{{ $ano->subtitulo }}</p>
      @endif
    </div>

    <div class="year-nav" data-anim="fade-up" data-delay="100">
      @foreach($anosVisibles as $a)
        <a href="{{ route('events.year', ['year' => $a->ano]) }}"
           class="year-nav-btn {{ $a->ano == $ano->ano ? 'active' : '' }}">
          {{ $a->ano }}
        </a>
      @endforeach
    </div>
  </div>
</section>

<section class="eventos-grid-section section light-bg">
  <div class="container">
    <div class="eventos-grid">
      @forelse($imagenes as $img)
        <article class="evento-card" data-anim="fade-up">
          <div class="evento-card-img">
            <img src="{{ asset('storage/' . $img->image_path) }}"
                 alt="{{ $img->description }}" loading="lazy">
            <span class="evento-card-tag">{{ $img->categoria->nombre }}</span>
          </div>
          <div class="evento-card-body">
            <p class="evento-card-date">
              <i class="bi bi-calendar-event" aria-hidden="true"></i>
              @if($img->event_date)
                @php
                  $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                            'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                  $d = \Carbon\Carbon::parse($img->event_date);
                @endphp
                {{ $meses[$d->month - 1] }} {{ $ano->ano }}
              @endif
            </p>
            <h2>{{ $img->categoria->nombre }}</h2>
            <p>{{ $img->description }}</p>
          </div>
        </article>
      @empty
        <div style="text-align:center; padding: 60px 20px; color: #888;">
          <i class="bi bi-folder2-open" style="font-size:2rem;"></i>
          <p style="margin-top:12px;">No hay imágenes registradas para este año.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>

@endsection