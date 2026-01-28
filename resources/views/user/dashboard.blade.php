<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Usuario')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2>Panel de Usuario</h2>

        <nav class="menu">
            <a href="{{ url('/user/home') }}">
                <i class="fa fa-house"></i>
                <span>Inicio</span>
            </a>

            <a href="{{ url('/user/page') }}">
                <i class="fa fa-globe"></i>
                <span>Página</span>
            </a>

            <a href="{{ url('/user/report') }}">
                <i class="fa fa-chart-line"></i>
                <span>Informe</span>
            </a>

            <a href="{{ url('/user/manual') }}">
                <i class="fa fa-book"></i>
                <span>Manual</span>
            </a>

            <a href="{{ url('/user/forms') }}">
                <i class="fa fa-file-lines"></i>
                <span>Formularios</span>
            </a>

            <a href="{{ url('/user/settings') }}">
                <i class="fa fa-gear"></i>
                <span>Ajustes</span>
            </a>

            <a href="{{ url('/logout') }}">
                <i class="fa fa-right-from-bracket"></i>
                <span>Cerrar sesión</span>
            </a>
        </nav>
    </aside>

    <!-- CONTENIDO -->
    <main class="main">

        <div class="topbar">
            <h3>@yield('title')</h3>
        </div>

        <div class="content">
            @yield('content')
        </div>

    </main>

</body>
</html>
