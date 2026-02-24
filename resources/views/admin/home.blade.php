@extends('admin.dashboard')

@section('title', 'Inicio')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/home.css') }}">
@endpush

@section('content')
<div class="admin-home">

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">
                Bienvenido {{ session('nombre') ?? 'Usuario' }}
            </h1>

            <p class="hero-subtitle">
                Rol actual:
                <strong style="text-transform: capitalize;">
                    {{ session('rol') ?? 'sin rol' }}
                </strong>
            </p>

            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $totalUsers }}</span>
                    <span class="stat-label">Usuarios</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $totalPages }}</span>
                    <span class="stat-label">Páginas</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $totalForms }}</span>
                    <span class="stat-label">Formularios</span>
                </div>
            </div>
        </div>

        <!-- Decoración Maya -->
        <div class="hero-decoration">
            <div class="maya-bg-pattern"></div>
            <div class="maya-glyph-strip-top"></div>
            <div class="maya-glyph-strip"></div>
            <div class="maya-serpent"></div>
            <div class="maya-sun"></div>
            <div class="maya-calendar"></div>
            <div class="maya-square-glyph"></div>
            <div class="maya-dot-cross"></div>
            <div class="maya-venus"></div>
            <div class="maya-numbers"></div>
            <div class="maya-creature"></div>
            <div class="maya-pyramid"></div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="section-header">
        <h2>Accesos Rápidos</h2>
        <p>Navega a las secciones principales del sistema</p>
    </div>

    <div class="widgets-grid">

        <a href="{{ url('/admin/home') }}" class="widget-card card-home">
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

        <a href="{{ url('/admin/page') }}" class="widget-card card-page">
            <div class="widget-icon">
                <i class="fa fa-globe"></i>
            </div>
            <div class="widget-info">
                <h3>Página</h3>
                <p>Gestión de páginas</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ url('/admin/report') }}" class="widget-card card-reports">
            <div class="widget-icon">
                <i class="fa fa-chart-line"></i>
            </div>
            <div class="widget-info">
                <h3>Informe</h3>
                <p>Reportes del sistema</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ url('/admin/manual') }}" class="widget-card card-manual">
            <div class="widget-icon">
                <i class="fa fa-book"></i>
            </div>
            <div class="widget-info">
                <h3>Manual</h3>
                <p>Documentación</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

        @if(session('rol') === 'administrador')
        <a href="{{ url('/admin/users') }}" class="widget-card card-users">
            <div class="widget-icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="widget-info">
                <h3>Usuarios</h3>
                <p>Gestión de usuarios</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>
        @endif

        <a href="{{ url('/admin/forms') }}" class="widget-card card-forms">
            <div class="widget-icon">
                <i class="fa fa-file-lines"></i>
            </div>
            <div class="widget-info">
                <h3>Formularios</h3>
                <p>Gestión de formularios</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ url('/admin/settings') }}" class="widget-card card-settings">
            <div class="widget-icon">
                <i class="fa fa-gear"></i>
            </div>
            <div class="widget-info">
                <h3>Ajustes</h3>
                <p>Configuración</p>
            </div>
            <div class="widget-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </a>

    </div>
</div>
@endsection