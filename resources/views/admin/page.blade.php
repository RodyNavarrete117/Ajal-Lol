@extends('admin.dashboard')

@section('title', 'Páginas')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/page.css') }}">
@endpush

@section('content')
<div class="pages-container">
    <div class="pages-header">
        <h2>Editor de la página web</h2>
        <p>Aquí podrás editar todas las secciones de la página activa de la plataforma</p>
        <button class="btn-new-page">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
            Crear nueva sección
        </button>
    </div>

    <div class="filter-tabs">
        <button class="tab-btn active">✓ Activas</button>
        <button class="tab-btn">Inactivas</button>
    </div>

    <div class="pages-list">
        <!-- INICIO -->
        <div class="page-item">
            <div class="page-icon-wrapper">
                <svg class="icon-home" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z"/>
                    <path class="door" d="M9 22V12H15V22" fill="rgba(255,255,255,0.3)"/>
                </svg>
            </div>
            <div class="page-content">
            <!-- INICIO -->
            <div class="page-name">Inicio</div>
            <div class="page-description">
                Bienvenidos al portal informativo de Ajal Lol. Organización de Asistencia Social, sin fines de lucro.
            </div>
            </div>

            <div class="page-actions">

                <!-- BOTÓN EDITAR -->
                <a href="{{ route('admin.pages.home.edit') }}"
                class="action-btn btn-edit"
                title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </a>

                <!-- BOTÓN VER -->
                <a href="{{ url('/') }}"
                class="action-btn btn-view"
                title="Ver">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>
                    </svg>
                </a>

                <!-- BOTÓN ELIMINAR (por ahora botón normal) -->
                <button class="action-btn btn-delete" title="Eliminar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </button>

            </div>
            </div>
        <!-- NOSOTROS -->
        <div class="page-item">
            <div class="page-icon-wrapper">
                <svg class="icon-team" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle class="person" cx="9" cy="7" r="4"/>
                    <path class="person" d="M3 21V19C3 17.9391 3.42143 16.9217 4.17157 16.1716C4.92172 15.4214 5.93913 15 7 15H11C12.0609 15 13.0783 15.4214 13.8284 16.1716C14.5786 16.9217 15 17.9391 15 19V21"/>
                    <circle class="person" cx="16.5" cy="7.5" r="3"/>
                    <path class="person" d="M21 21V19.5C21 18.5717 20.6313 17.6815 19.9749 17.0251C19.3185 16.3687 18.4283 16 17.5 16H17"/>
                </svg>
            </div>

            <div class="page-content">
                <div class="page-name">Nosotros</div>
                <div class="page-description">
                    Conoce más sobre nosotros. La organización fue fundada en el año 2000 por 5 mujeres quienes compartían...
                </div>
            </div>

            <div class="page-actions">

                <!-- EDITAR -->
                <a href="{{ route('admin.pages.about.edit') }}"
                class="action-btn btn-edit"
                title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </a>

                <!-- VER -->
                <a href="{{ url('/about') }}"
                class="action-btn btn-view"
                title="Ver">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>
                    </svg>
                </a>

                <!-- ELIMINAR -->
                <button class="action-btn btn-delete" title="Eliminar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </button>

            </div>
        </div>

        <!-- CONTACTO -->
        <div class="page-item">
            <div class="page-icon-wrapper">
                <svg class="icon-contact" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path class="envelope-flap"
                        d="M22 7L13.03 12.7C12.7213 12.8934 12.3643 12.996 12 12.996C11.6357 12.996 11.2787 12.8934 10.97 12.7L2 7"/>
                </svg>
            </div>

            <div class="page-content">
                <div class="page-name">Contacto</div>
                <div class="page-description">
                    Formulario de contacto y datos de ubicación para que los usuarios se comuniquen con la organización.
                </div>
            </div>

            <div class="page-actions">

                <!-- EDITAR -->
                <a href="{{ route('admin.pages.contact.edit') }}"
                class="action-btn btn-edit"
                title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </a>

                <!-- VER -->
                <a href="{{ url('/contact') }}"
                class="action-btn btn-view"
                title="Ver">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>
                    </svg>
                </a>

                <!-- ELIMINAR -->
                <button class="action-btn btn-delete" title="Eliminar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </button>

            </div>
</div>
</div>
<script src="{{ asset('assets/js/page.js') }}"></script>
@endsection