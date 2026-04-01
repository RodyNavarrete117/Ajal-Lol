@extends('admin.dashboard')

@section('title', 'Páginas')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/page.css') }}">
@endpush

@section('content')
<div class="pages-container">

    {{-- ── HEADER ─────────────────────────────────────────────── --}}
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

    {{-- ── TABS ────────────────────────────────────────────────── --}}
    <div class="filter-tabs">
        <button class="tab-btn active">✓ Activas</button>
        <button class="tab-btn">Inactivas</button>
    </div>

    {{-- ── LISTA DE PÁGINAS ────────────────────────────────────── --}}
    <div class="pages-list">

        {{-- ── INICIO ──────────────────────────────────────────── --}}
        <div class="page-item">
            <div class="page-icon-wrapper">
                <svg class="icon-home" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z"/>
                    <path class="door" d="M9 22V12H15V22" fill="rgba(255,255,255,0.3)"/>
                </svg>
            </div>
            <div class="page-content">
                <div class="page-name">Inicio</div>
                <div class="page-description">
                    Bienvenidos al portal informativo de Ajal Lol. Organización de Asistencia Social, sin fines de lucro.
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.pages.home.edit') }}" class="action-btn btn-edit" title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="{{ url('/') }}" class="action-btn btn-view" title="Ver en el sitio" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <button class="action-btn btn-delete" title="Eliminar" data-page="Inicio">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── NOSOTROS ─────────────────────────────────────────── --}}
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
                <a href="{{ route('admin.pages.about.edit') }}" class="action-btn btn-edit" title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="{{ url('/nosotros') }}" class="action-btn btn-view" title="Ver en el sitio" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <button class="action-btn btn-delete" title="Eliminar" data-page="Nosotros">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── ALIADOS ──────────────────────────────────────────── --}}
        <div class="page-item">
            <div class="page-icon-wrapper">
                <svg class="icon-aliados" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="page-content">
                <div class="page-name">Aliados</div>
                <div class="page-description">
                    Organizaciones e instituciones que colaboran con Ajal Lol en sus programas comunitarios.
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.pages.allies.edit') }}" class="action-btn btn-edit" title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="{{ url('/aliados') }}" class="action-btn btn-view" title="Ver en el sitio" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <button class="action-btn btn-delete" title="Eliminar" data-page="Aliados">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── ACTIVIDADES ──────────────────────────────────────── --}}
        <div class="page-item">
            <div class="page-icon-wrapper">
                <svg class="icon-actividades" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8"  y1="2" x2="8"  y2="6"/>
                    <line x1="3"  y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="page-content">
                <div class="page-name">Actividades</div>
                <div class="page-description">
                    Registro de actividades realizadas por año. Talleres, jornadas y eventos comunitarios.
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.pages.activities.edit') }}" class="action-btn btn-edit" title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="{{ url('/actividades') }}" class="action-btn btn-view" title="Ver en el sitio" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <button class="action-btn btn-delete" title="Eliminar" data-page="Actividades">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── PROYECTOS ────────────────────────────────────────── --}}
        <div class="page-item">
            <div class="page-icon-wrapper">
                <svg class="icon-proyectos" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div class="page-content">
                <div class="page-name">Proyectos</div>
                <div class="page-description">
                    Proyectos sociales clasificados por categoría y año. Alimentación, educación, salud y más.
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.pages.projects.edit') }}" class="action-btn btn-edit" title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="{{ url('/proyectos') }}" class="action-btn btn-view" title="Ver en el sitio" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <button class="action-btn btn-delete" title="Eliminar" data-page="Proyectos">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── DIRECTIVA ────────────────────────────────────────── --}}
        <div class="page-item">
            <div class="page-icon-wrapper">
                <svg class="icon-directiva" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div class="page-content">
                <div class="page-name">Directiva</div>
                <div class="page-description">
                    Integrantes del consejo directivo de la organización, con foto y cargo.
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.pages.board.edit') }}" class="action-btn btn-edit" title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="{{ url('/directiva') }}" class="action-btn btn-view" title="Ver en el sitio" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <button class="action-btn btn-delete" title="Eliminar" data-page="Directiva">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── PREGUNTAS FRECUENTES ─────────────────────────────── --}}
        <div class="page-item">
            <div class="page-icon-wrapper">
                <svg class="icon-faq" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div class="page-content">
                <div class="page-name">Preguntas frecuentes</div>
                <div class="page-description">
                    Respuestas a las dudas más comunes sobre la organización, sus servicios y cómo colaborar.
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.pages.faq.edit') }}" class="action-btn btn-edit" title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="{{ url('/preguntas-frecuentes') }}" class="action-btn btn-view" title="Ver en el sitio" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <button class="action-btn btn-delete" title="Eliminar" data-page="Preguntas frecuentes">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── CONTACTO ─────────────────────────────────────────── --}}
        <div class="page-item">
            <div class="page-icon-wrapper">
                <svg class="icon-contact" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path class="envelope-flap" d="M22 7L13.03 12.7C12.7213 12.8934 12.3643 12.996 12 12.996C11.6357 12.996 11.2787 12.8934 10.97 12.7L2 7"/>
                </svg>
            </div>
            <div class="page-content">
                <div class="page-name">Contacto</div>
                <div class="page-description">
                    Formulario de contacto y datos de ubicación para que los usuarios se comuniquen con la organización.
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.pages.contact.edit') }}" class="action-btn btn-edit" title="Editar">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="{{ url('/contacto') }}" class="action-btn btn-view" title="Ver en el sitio" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <button class="action-btn btn-delete" title="Eliminar" data-page="Contacto">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6H5H21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 11V17M14 11V17" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

    </div>{{-- /pages-list --}}
</div>{{-- /pages-container --}}

<script src="{{ asset('assets/js/page.js') }}"></script>
@endsection