@extends('user.dashboard')
<!-- //Se visualiza el dashboard correspondiente-->
@section('title', 'Inicio')
<!-- //Contenido principal del la vista inicio-->

@push('styles')
<!-- //link para agregar estilos de esta área -->
<link rel="stylesheet" href="{{ asset('assets/css/usercss/home.css') }}">
@endpush

@section('content')
<div class="user-home">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Bienvenido a tu Panel</h1>
            <p class="hero-subtitle">Accede a tus herramientas y contenidos desde aquí</p>

            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $totalPages ?? '0' }}</span>
                    <span class="stat-label">Páginas</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $totalForms ?? '0' }}</span>
                    <span class="stat-label">Formularios</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $totalReports ?? '0' }}</span>
                    <span class="stat-label">Informes</span>
                </div>
            </div>
        </div>

        <div class="hero-decoration">
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            <div class="decoration-circle circle-3"></div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="section-header">
        <h2>Accesos Rápidos</h2>
        <p>Navega por tus secciones disponibles</p>
    </div>

    <div class="widgets-grid">

        <a href="{{ url('/user/home') }}" class="widget-card card-home">
            <div class="widget-icon">
                <i class="fa fa-house"></i>
            </div>
            <div class="widget-info">
                <h3>Inicio</h3>
                <p>Panel principal</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ url('/user/page') }}" class="widget-card card-page">
            <div class="widget-icon">
                <i class="fa fa-globe"></i>
            </div>
            <div class="widget-info">
                <h3>Página</h3>
                <p>Contenido disponible</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ url('/user/report') }}" class="widget-card card-reports">
            <div class="widget-icon">
                <i class="fa fa-chart-line"></i>
            </div>
            <div class="widget-info">
                <h3>Informe</h3>
                <p>Tus reportes</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ url('/user/manual') }}" class="widget-card card-manual">
            <div class="widget-icon">
                <i class="fa fa-book"></i>
            </div>
            <div class="widget-info">
                <h3>Manual</h3>
                <p>Guías y ayuda</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ url('/user/forms') }}" class="widget-card card-forms">
            <div class="widget-icon">
                <i class="fa fa-file-lines"></i>
            </div>
            <div class="widget-info">
                <h3>Formularios</h3>
                <p>Formularios disponibles</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ url('/user/settings') }}" class="widget-card card-settings">
            <div class="widget-icon">
                <i class="fa fa-gear"></i>
            </div>
            <div class="widget-info">
                <h3>Ajustes</h3>
                <p>Configuración de cuenta</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

    </div>
</div>
@endsection