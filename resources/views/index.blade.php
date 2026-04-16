<!DOCTYPE html>
<html lang="es">
<head>

  <!-- ── Meta base ── -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajal Lol A.C. — Asistencia Social</title>
  <meta name="description" content="Ajal Lol A.C. — Organización de Asistencia Social sin fines de lucro que apoya a comunidades mayas de Yucatán desde el año 2000.">
  <meta name="keywords"    content="Ajal Lol, asistencia social, Yucatán, voluntariado, donaciones, comunidades mayas">
  <meta name="author"      content="Ajal Lol A.C.">
  <meta name="theme-color" content="#8b2252">
  <meta name="csrf-token"  content="{{ csrf_token() }}">

  <!-- ── Open Graph ── -->
  <meta property="og:title"       content="Ajal Lol A.C. — Asistencia Social en Yucatán">
  <meta property="og:description" content="Organización sin fines de lucro que transforma vidas en comunidades mayas de Yucatán desde el año 2000.">
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

  <!-- ── CSS propio (dividido para ahorrar código) ── -->
  <link href="{{ asset('assets/css/admincss/publicpages/base.css') }}"       rel="stylesheet"> {{-- Variables, reset, utils, cursor, preloader --}}
  <link href="{{ asset('assets/css/admincss/publicpages/header.css') }}"     rel="stylesheet"> {{-- Header, nav, dropdown --}}
  <link href="{{ asset('assets/css/admincss/publicpages/sections.css') }}"   rel="stylesheet"> {{-- Hero, about, stats, aliados, actividades, team, mvov, faq --}}
  <link href="{{ asset('assets/css/admincss/publicpages/activities.css') }}" rel="stylesheet"> {{-- Selector de años — sección Actividades --}}
  <link href="{{ asset('assets/css/admincss/publicpages/contact.css') }}"    rel="stylesheet"> {{-- Formulario de contacto --}}
  <link href="{{ asset('assets/css/admincss/publicpages/footer.css') }}"     rel="stylesheet"> {{-- Footer --}}
  <link href="{{ asset('assets/css/admincss/publicpages/portfolio.css') }}"  rel="stylesheet"> {{-- Sección proyectos (year tabs, grid, lightbox) --}}

</head>

<body class="index-page">

  {{-- Preloader --}}
  @include('partials.preloader')

  {{-- Overlay nav móvil --}}
  <div class="nav-overlay" id="nav-overlay" aria-hidden="true"></div>

  {{-- Header + Navegación --}}
  @include('partials.header')

  <main id="main" class="main">

    @include('sections.hero')
    @include('sections.about')
    @include('sections.stats')
    @include('sections.clients')
    @include('sections.services')   {{-- Actividades con selector de años --}}
    @include('sections.portfolio')
    @include('sections.team')
    @include('sections.identity')
    @include('sections.faq')
    @include('sections.contact')

  </main>

  {{-- Footer --}}
  @include('partials.footer')

  {{-- Scroll top --}}
  <a href="#" id="scroll-top" aria-label="Volver al inicio de la página">
    <i class="bi bi-arrow-up-short" aria-hidden="true"></i>
  </a>

  <!-- ── Bootstrap 5.3 JS ── -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- ── JS propio (orden importante: utils primero) ── -->
  <script src="{{ asset('assets/js/publicpages/utils.js') }}"></script>
  <script src="{{ asset('assets/js/publicpages/header.js') }}"></script>
  <script src="{{ asset('assets/js/publicpages/sections.js') }}" defer></script>
  <script src="{{ asset('assets/js/publicpages/portfolio.js') }}"></script>
  <script src="{{ asset('assets/js/publicpages/services.js') }}"></script>  {{-- Selector de años — sección Actividades --}}
  <script src="{{ asset('assets/js/publicpages/contact.js') }}"></script>

</body>
</html>