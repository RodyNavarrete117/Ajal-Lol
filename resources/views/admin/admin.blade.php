<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}"> <!-- Esta es la manera de colocar la dirección del CSS sucia de Rafa-->

</head>
<body>

    <div class="container">
        <div class="box">
            <p>Texto de ejemplo del layout ADMIN</p>

            {{-- Aquí se inyecta el contenido --}}
            @yield('content')
        </div>
    </div>

</body>
</html>
