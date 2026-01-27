<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}"> <!-- Esta es la manera de colocar la dirección del CSS sucia de Rafa-->


</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2>ADMIN</h2>

        <nav class="menu">
            <a href="#"><i class="fa fa-house"></i> Inicio</a>
            <a href="#"><i class="fa fa-globe"></i> Página</a>
            <a href="#"><i class="fa fa-chart-line"></i> Informe</a>
            <a href="#"><i class="fa fa-book"></i> Manual</a>
            <a href="#"><i class="fa fa-users"></i> Usuarios</a>
            <a href="#"><i class="fa fa-file-lines"></i> Formularios</a>
            <a href="#"><i class="fa fa-gear"></i> Ajustes</a>
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
