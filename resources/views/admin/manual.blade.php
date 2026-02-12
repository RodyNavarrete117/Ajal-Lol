@extends('admin.dashboard')

@section('title', 'Manual')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/manual.css') }}">

@endpush

@section('content')
<div class="manual-container">
    <h2>Manual del Administrador</h2>
    <p>En esta sección encontrarás una guía visual para el uso del panel de administración.</p>

    <!-- Sección 1: Dashboard -->
    <div class="manual-section">
        <h3>1. Panel de Inicio (Dashboard)</h3>
        <p>Al ingresar, verás el panel principal con estadísticas y accesos rápidos a todas las secciones.</p>
        <img src="{{ asset('assets/img/imagenesdemo/ImagenMuestra.jpg') }}" alt="Dashboard">
    </div>

    <!-- Sección 2: Gestión de Usuarios -->
    <div class="manual-section">
        <h3>2. Gestión de Usuarios</h3>
        <p>Aquí puedes agregar, editar o eliminar usuarios. Haz clic en los botones correspondientes para realizar estas acciones.</p>
        <img src="{{ asset('assets/img/imagenesdemo/ImagenMuestra2.png') }}" alt="Gestión Usuarios}">
    </div>

    <!-- Sección 3: Configuración -->
    <div class="manual-section">
        <h3>3. Configuración</h3>
        <p>Accede a la sección de ajustes para configurar opciones generales del sistema.</p>
        <img src="{{ asset('assets/img/imagenesdemo/ImagenMuestra3.jpg') }}" alt="Configuración">
    </div>

    <!-- Sección 4: Reportes -->
    <div class="manual-section">
        <h3>4. Reportes</h3>
        <p>Genera reportes de usuarios, ventas u otras métricas desde esta sección.</p>
        <img src="{{ asset('assets/img/imagenesdemo/ImagenMuestra4.png') }}" alt="Reportes">
    </div>

    <p>Estas son las secciones principales del panel de administración. Cada imagen muestra los pasos o botones que debes usar.</p>
</div>
@endsection