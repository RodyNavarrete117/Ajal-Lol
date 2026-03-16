<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Eventos') — Ajal Lol A.C.</title>
  <meta name="description" content="@yield('description', 'Eventos y proyectos de Ajal Lol A.C.')">

  <link rel="icon" href="{{ asset('assets/img/logo.webp') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  {{-- CSS base del sitio --}}
  <link href="{{ asset('assets/css/index.css') }}" rel="stylesheet">
  {{-- CSS específico de events --}}
  <link href="{{ asset('assets/css/admincss/publicpages/events.css') }}" rel="stylesheet">
</head>

<body class="events-page">

  <div id="preloader">
    <div class="preloader-logo">Ajal Lol</div>
    <div class="preloader-bar"></div>
  </div>

  <div class="nav-overlay" id="nav-overlay" aria-hidden="true"></div>

  @include('partials.header')

  <main id="main" class="main">
    @yield('content')
  </main>

  @include('partials.footer')

  <a href="#" id="scroll-top" aria-label="Volver al inicio">
    <i class="bi bi-arrow-up-short" aria-hidden="true"></i>
  </a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/publicpages/portfolio.js') }}"></script>

</body>
</html>