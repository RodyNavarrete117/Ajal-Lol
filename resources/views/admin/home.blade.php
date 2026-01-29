@extends('admin.dashboard')

@section('title', 'Inicio')
<!-- //link para agregar estilos de esta área -->
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/home.css') }}">
@endpush

@section('content')
        <div class="widgets">

        <div class="widget-card">
            <div class="widget-icon">
                <a href="{{ url('/admin/home') }}">
                    <i class="fa fa-house"></i>
                </a>
            </div>
            <div class="widget-info">
                <h3>Inicio</h3>
                <p>Panel principal</p>
            </div>
        </div>

        <div class="widget-card">
            <div class="widget-icon">
                <a href="{{ url('/admin/page') }}">
                    <i class="fa fa-globe"></i>
                </a>
            </div>
            <div class="widget-info">
                <h3>Página</h3>
                <p>Gestión de páginas</p>
            </div>
        </div>

        <div class="widget-card">
            <div class="widget-icon">
                <a href="{{ url('/admin/reports') }}">
                    <i class="fa fa-chart-line"></i>
                </a>
            </div>
            <div class="widget-info">
                <h3>Informe</h3>
                <p>Reportes del sistema</p>
            </div>
        </div>

        <div class="widget-card">
            <div class="widget-icon">
                <a href="{{ url('/admin/manual') }}">
                    <i class="fa fa-book"></i>
                </a>
            </div>
            <div class="widget-info">
                <h3>Manual</h3>
                <p>Documentación</p>
            </div>
        </div>

        <div class="widget-card">
            <div class="widget-icon">
                <a href="{{ url('/admin/users') }}">
                    <i class="fa fa-users"></i>
                </a>
            </div>
            <div class="widget-info">
                <h3>Usuarios</h3>
                <p>Gestión de usuarios</p>
            </div>
        </div>

        <div class="widget-card">
            <div class="widget-icon">
                <a href="{{ url('/admin/forms') }}">
                    <i class="fa fa-file-lines"></i>
                </a>
            </div>
            <div class="widget-info">
                <h3>Formularios</h3>
                <p>Gestión de formularios</p>
            </div>
        </div>

        <div class="widget-card">
            <div class="widget-icon">
                <a href="{{ url('/admin/settings') }}">
                    <i class="fa fa-gear"></i>
                </a>
            </div>
            <div class="widget-info">
                <h3>Ajustes</h3>
                <p>Configuración</p>
            </div>
        </div>

    </div>
@endsection
