<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="toggle-btn" id="toggleBtn">
                <i class="fa fa-bars"></i>
            </button>
            <h2 style="text-transform: capitalize;">
                {{ session('rol') ?? 'Panel' }}
            </h2>
        </div>

        <nav class="menu">
            <a href="{{ url('/admin/home') }}">
                <i class="fa fa-house"></i>
                <span>Inicio</span>
            </a>

            <a href="{{ url('/admin/page') }}">
                <i class="fa fa-globe"></i>
                <span>Página</span>
            </a>

            <a href="{{ url('/admin/report') }}">
                <i class="fa fa-chart-line"></i>
                <span>Informe</span>
            </a>

            <a href="{{ url('/admin/manual') }}">
                <i class="fa fa-book"></i>
                <span>Manual</span>
            </a>

            <a href="{{ url('/admin/users') }}">
                <i class="fa fa-users"></i>
                <span>Usuarios</span>
            </a>

            <a href="{{ url('/admin/forms') }}">
                <i class="fa fa-file-lines"></i>
                <span>Formularios</span>
            </a>

            <a href="{{ url('/admin/settings') }}">
                <i class="fa fa-gear"></i>
                <span>Ajustes</span>
            </a>
        </nav>
    </aside>

    <!-- CONTENIDO -->
    <main class="main" id="main">

        <div class="content">
            @yield('content')
        </div>

    </main>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    @stack('scripts')

</body>
</html>