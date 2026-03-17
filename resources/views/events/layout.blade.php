<!DOCTYPE html>
<html lang="es">
<head>

  <!-- ── Meta base ── -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Eventos') — Ajal Lol A.C.</title>
  <meta name="description" content="@yield('description', 'Eventos y proyectos de Ajal Lol A.C.')">
  <meta name="author"      content="Ajal Lol A.C.">
  <meta name="theme-color" content="#8b2252">

  <!-- ── Open Graph ── -->
  <meta property="og:title"       content="@yield('title', 'Eventos') — Ajal Lol A.C.">
  <meta property="og:description" content="@yield('description', 'Eventos y proyectos de Ajal Lol A.C.')">
  <meta property="og:image"       content="{{ asset('assets/img/logo.webp') }}">
  <meta property="og:type"        content="website">
  <meta property="og:locale"      content="es_MX">

  <!-- ── Favicons ── -->
  <link rel="icon"             href="{{ asset('assets/img/logo.webp') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/logo.webp') }}">

  <!-- ── Preconnect fuentes ── -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- ── Librerías externas ── -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <!-- ── CSS base compartido (idéntico al index.blade.php principal) ── -->
  <link href="{{ asset('assets/css/admincss/publicpages/base.css') }}"   rel="stylesheet"> {{-- Variables, reset, cursor, preloader, animaciones --}}
  <link href="{{ asset('assets/css/admincss/publicpages/header.css') }}" rel="stylesheet"> {{-- Header, nav, dropdown --}}
  <link href="{{ asset('assets/css/admincss/publicpages/footer.css') }}" rel="stylesheet"> {{-- Footer --}}

  <!-- ── CSS exclusivo de la carpeta events/ ── -->
  {{--
    events.css    → Hero de eventos · year-nav · grid de cards (2023, 2024, 2025)
    events-extra.css → Botón "Ver más" · página detail · página leadingevents
    Ambos archivos cubren TODOS los blades de events/:
      2023.blade.php · 2024.blade.php · 2025.blade.php
      detail.blade.php · leadingevents.blade.php
  --}}
  <link href="{{ asset('assets/css/admincss/publicpages/events.css') }}"       rel="stylesheet">
  <link href="{{ asset('assets/css/admincss/publicpages/events-extra.css') }}" rel="stylesheet">

</head>

<body class="events-page">

  <div id="preloader" role="status" aria-label="Cargando página">
    <div class="preloader-logo">Ajal Lol</div>
    <div class="preloader-bar"></div>
  </div>

  <div class="nav-overlay" id="nav-overlay" aria-hidden="true"></div>

  @include('partials.header')

  <main id="main" class="main">
    @yield('content')
  </main>

  @include('partials.footer')

  <a href="#" id="scroll-top" aria-label="Volver al inicio de la página">
    <i class="bi bi-arrow-up-short" aria-hidden="true"></i>
  </a>

  <!-- ── Bootstrap 5.3 JS ── -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- ── JS propio (orden importante: utils primero) ── -->
  <script src="{{ asset('assets/js/publicpages/utils.js') }}"></script>    {{-- Cursor, preloader, animaciones, ripple --}}
  <script src="{{ asset('assets/js/publicpages/header.js') }}"></script>   {{-- Header shrink, mobile nav, dropdown --}}
  <script src="{{ asset('assets/js/publicpages/sections.js') }}"></script> {{-- Marquee, FAQ, contadores --}}
  {{-- portfolio.js y contact.js NO se cargan: events no usa year-tabs, lightbox ni formulario --}}

</body>
</html>