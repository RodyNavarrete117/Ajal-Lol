@extends('admin.dashboard')

@section('title', 'Páginas')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap">
<link rel="stylesheet" href="{{ asset('assets/css/admincss/page.css') }}">
@endpush

@section('content')
<div class="pages-container">

    {{-- ── HEADER ── --}}
    <div class="pages-header">
        <div class="pages-header__text">
            <h2>Editor de la página web</h2>
            <p>Aquí podrás editar todas las secciones de la página activa de la plataforma</p>
        </div>
        <button class="btn-new-page">
            <svg viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            Crear nueva sección
        </button>
    </div>

    {{-- ── TABS ── --}}
    <div class="filter-tabs">
        <button class="tab-btn active">
            <svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Activas
        </button>
        <button class="tab-btn">
            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M4.93 4.93l14.14 14.14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Inactivas
        </button>
    </div>

    {{-- ── GRID DE PÁGINAS ── --}}
    <div class="pages-grid" id="pagesGrid">

        {{-- INICIO · color: rosa --}}
        <div class="page-card" data-color="pink" style="--c1:#e91e8c;--c2:#c2185b;--rgb:233,30,140;">
            <div class="page-card__header">
                <div class="page-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9L12 2L21 9V20C21 20.53 20.79 21.04 20.41 21.41C20.04 21.79 19.53 22 19 22H5C4.47 22 3.96 21.79 3.59 21.41C3.21 21.04 3 20.53 3 20V9Z"/>
                        <path d="M9 22V12H15V22"/>
                    </svg>
                </div>
                <div class="page-card__actions">
                    <a href="{{ route('admin.pages.home.edit') }}" class="card-btn card-btn--edit" title="Editar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3C17.26 2.74 17.57 2.53 17.92 2.39C18.26 2.24 18.63 2.17 19 2.17C19.37 2.17 19.74 2.24 20.08 2.39C20.43 2.53 20.74 2.74 21 3C21.26 3.26 21.47 3.57 21.61 3.92C21.75 4.26 21.83 4.63 21.83 5C21.83 5.37 21.75 5.74 21.61 6.08C21.47 6.43 21.26 6.74 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/') }}" class="card-btn card-btn--view" title="Ver sitio" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <button class="card-btn card-btn--delete" title="Eliminar" data-page="Inicio">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6H21M19 6V20C19 20.53 18.79 21.04 18.41 21.41C18.04 21.79 17.53 22 17 22H7C6.47 22 5.96 21.79 5.59 21.41C5.21 21.04 5 20.53 5 20V6M8 6V4C8 3.47 8.21 2.96 8.59 2.59C8.96 2.21 9.47 2 10 2H14C14.53 2 15.04 2.21 15.41 2.59C15.79 2.96 16 3.47 16 4V6"/></svg>
                    </button>
                </div>
            </div>
            <div class="page-card__body">
                <h3 class="page-card__name">Inicio</h3>
                <p class="page-card__desc">Bienvenidos al portal informativo de Ajal Lol. Organización de Asistencia Social, sin fines de lucro.</p>
            </div>
            <div class="page-card__footer">
                <span class="page-card__status">
                    <span class="status-dot"></span>Activa
                </span>
                <a href="{{ route('admin.pages.home.edit') }}" class="card-btn--goto">
                    Editar página
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12H19M13 6l6 6-6 6"/></svg>
                </a>
            </div>
        </div>

        {{-- NOSOTROS · color: violeta --}}
        <div class="page-card" data-color="violet" style="--c1:#7c3aed;--c2:#6d28d9;--rgb:124,58,237;">
            <div class="page-card__header">
                <div class="page-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M3 21V19C3 17.94 3.42 16.92 4.17 16.17C4.92 15.42 5.94 15 7 15H11C12.06 15 13.08 15.42 13.83 16.17C14.58 16.92 15 17.94 15 19V21"/>
                        <circle cx="16.5" cy="7.5" r="3"/>
                        <path d="M21 21V19.5C21 18.57 20.63 17.68 19.97 17.03C19.32 16.37 18.43 16 17.5 16H17"/>
                    </svg>
                </div>
                <div class="page-card__actions">
                    <a href="{{ route('admin.pages.about.edit') }}" class="card-btn card-btn--edit" title="Editar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3C17.26 2.74 17.57 2.53 17.92 2.39C18.26 2.24 18.63 2.17 19 2.17C19.37 2.17 19.74 2.24 20.08 2.39C20.43 2.53 20.74 2.74 21 3C21.26 3.26 21.47 3.57 21.61 3.92C21.75 4.26 21.83 4.63 21.83 5C21.83 5.37 21.75 5.74 21.61 6.08C21.47 6.43 21.26 6.74 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/nosotros') }}" class="card-btn card-btn--view" title="Ver sitio" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <button class="card-btn card-btn--delete" title="Eliminar" data-page="Nosotros">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6H21M19 6V20C19 20.53 18.79 21.04 18.41 21.41C18.04 21.79 17.53 22 17 22H7C6.47 22 5.96 21.79 5.59 21.41C5.21 21.04 5 20.53 5 20V6M8 6V4C8 3.47 8.21 2.96 8.59 2.59C8.96 2.21 9.47 2 10 2H14C14.53 2 15.04 2.21 15.41 2.59C15.79 2.96 16 3.47 16 4V6"/></svg>
                    </button>
                </div>
            </div>
            <div class="page-card__body">
                <h3 class="page-card__name">Nosotros</h3>
                <p class="page-card__desc">Conoce más sobre nosotros. La organización fue fundada en el año 2000 por 5 mujeres quienes compartían...</p>
            </div>
            <div class="page-card__footer">
                <span class="page-card__status"><span class="status-dot"></span>Activa</span>
                <a href="{{ route('admin.pages.about.edit') }}" class="card-btn--goto">Editar página <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12H19M13 6l6 6-6 6"/></svg></a>
            </div>
        </div>

        {{-- ALIADOS · color: cian --}}
        <div class="page-card" data-color="cyan" style="--c1:#0891b2;--c2:#0e7490;--rgb:8,145,178;">
            <div class="page-card__header">
                <div class="page-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="page-card__actions">
                    <a href="{{ route('admin.pages.allies.edit') }}" class="card-btn card-btn--edit" title="Editar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3C17.26 2.74 17.57 2.53 17.92 2.39C18.26 2.24 18.63 2.17 19 2.17C19.37 2.17 19.74 2.24 20.08 2.39C20.43 2.53 20.74 2.74 21 3C21.26 3.26 21.47 3.57 21.61 3.92C21.75 4.26 21.83 4.63 21.83 5C21.83 5.37 21.75 5.74 21.61 6.08C21.47 6.43 21.26 6.74 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/aliados') }}" class="card-btn card-btn--view" title="Ver sitio" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <button class="card-btn card-btn--delete" title="Eliminar" data-page="Aliados">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6H21M19 6V20C19 20.53 18.79 21.04 18.41 21.41C18.04 21.79 17.53 22 17 22H7C6.47 22 5.96 21.79 5.59 21.41C5.21 21.04 5 20.53 5 20V6M8 6V4C8 3.47 8.21 2.96 8.59 2.59C8.96 2.21 9.47 2 10 2H14C14.53 2 15.04 2.21 15.41 2.59C15.79 2.96 16 3.47 16 4V6"/></svg>
                    </button>
                </div>
            </div>
            <div class="page-card__body">
                <h3 class="page-card__name">Aliados</h3>
                <p class="page-card__desc">Organizaciones e instituciones que colaboran con Ajal Lol en sus programas comunitarios.</p>
            </div>
            <div class="page-card__footer">
                <span class="page-card__status"><span class="status-dot"></span>Activa</span>
                <a href="{{ route('admin.pages.allies.edit') }}" class="card-btn--goto">Editar página <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12H19M13 6l6 6-6 6"/></svg></a>
            </div>
        </div>

        {{-- ACTIVIDADES · color: naranja --}}
        <div class="page-card" data-color="orange" style="--c1:#ea580c;--c2:#c2410c;--rgb:234,88,12;">
            <div class="page-card__header">
                <div class="page-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="page-card__actions">
                    <a href="{{ route('admin.pages.activities.edit') }}" class="card-btn card-btn--edit" title="Editar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3C17.26 2.74 17.57 2.53 17.92 2.39C18.26 2.24 18.63 2.17 19 2.17C19.37 2.17 19.74 2.24 20.08 2.39C20.43 2.53 20.74 2.74 21 3C21.26 3.26 21.47 3.57 21.61 3.92C21.75 4.26 21.83 4.63 21.83 5C21.83 5.37 21.75 5.74 21.61 6.08C21.47 6.43 21.26 6.74 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/actividades') }}" class="card-btn card-btn--view" title="Ver sitio" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <button class="card-btn card-btn--delete" title="Eliminar" data-page="Actividades">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6H21M19 6V20C19 20.53 18.79 21.04 18.41 21.41C18.04 21.79 17.53 22 17 22H7C6.47 22 5.96 21.79 5.59 21.41C5.21 21.04 5 20.53 5 20V6M8 6V4C8 3.47 8.21 2.96 8.59 2.59C8.96 2.21 9.47 2 10 2H14C14.53 2 15.04 2.21 15.41 2.59C15.79 2.96 16 3.47 16 4V6"/></svg>
                    </button>
                </div>
            </div>
            <div class="page-card__body">
                <h3 class="page-card__name">Actividades</h3>
                <p class="page-card__desc">Registro de actividades realizadas por año. Talleres, jornadas y eventos comunitarios.</p>
            </div>
            <div class="page-card__footer">
                <span class="page-card__status"><span class="status-dot"></span>Activa</span>
                <a href="{{ route('admin.pages.activities.edit') }}" class="card-btn--goto">Editar página <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12H19M13 6l6 6-6 6"/></svg></a>
            </div>
        </div>

        {{-- PROYECTOS · color: verde --}}
        <div class="page-card" data-color="green" style="--c1:#16a34a;--c2:#15803d;--rgb:22,163,74;">
            <div class="page-card__header">
                <div class="page-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <div class="page-card__actions">
                    <a href="{{ route('admin.pages.projects.edit') }}" class="card-btn card-btn--edit" title="Editar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3C17.26 2.74 17.57 2.53 17.92 2.39C18.26 2.24 18.63 2.17 19 2.17C19.37 2.17 19.74 2.24 20.08 2.39C20.43 2.53 20.74 2.74 21 3C21.26 3.26 21.47 3.57 21.61 3.92C21.75 4.26 21.83 4.63 21.83 5C21.83 5.37 21.75 5.74 21.61 6.08C21.47 6.43 21.26 6.74 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/proyectos') }}" class="card-btn card-btn--view" title="Ver sitio" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <button class="card-btn card-btn--delete" title="Eliminar" data-page="Proyectos">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6H21M19 6V20C19 20.53 18.79 21.04 18.41 21.41C18.04 21.79 17.53 22 17 22H7C6.47 22 5.96 21.79 5.59 21.41C5.21 21.04 5 20.53 5 20V6M8 6V4C8 3.47 8.21 2.96 8.59 2.59C8.96 2.21 9.47 2 10 2H14C14.53 2 15.04 2.21 15.41 2.59C15.79 2.96 16 3.47 16 4V6"/></svg>
                    </button>
                </div>
            </div>
            <div class="page-card__body">
                <h3 class="page-card__name">Proyectos</h3>
                <p class="page-card__desc">Proyectos sociales clasificados por categoría y año. Alimentación, educación, salud y más.</p>
            </div>
            <div class="page-card__footer">
                <span class="page-card__status"><span class="status-dot"></span>Activa</span>
                <a href="{{ route('admin.pages.projects.edit') }}" class="card-btn--goto">Editar página <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12H19M13 6l6 6-6 6"/></svg></a>
            </div>
        </div>

        {{-- DIRECTIVA · color: indigo --}}
        <div class="page-card" data-color="indigo" style="--c1:#4338ca;--c2:#3730a3;--rgb:67,56,202;">
            <div class="page-card__header">
                <div class="page-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <div class="page-card__actions">
                    <a href="{{ route('admin.pages.board.edit') }}" class="card-btn card-btn--edit" title="Editar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3C17.26 2.74 17.57 2.53 17.92 2.39C18.26 2.24 18.63 2.17 19 2.17C19.37 2.17 19.74 2.24 20.08 2.39C20.43 2.53 20.74 2.74 21 3C21.26 3.26 21.47 3.57 21.61 3.92C21.75 4.26 21.83 4.63 21.83 5C21.83 5.37 21.75 5.74 21.61 6.08C21.47 6.43 21.26 6.74 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/directiva') }}" class="card-btn card-btn--view" title="Ver sitio" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <button class="card-btn card-btn--delete" title="Eliminar" data-page="Directiva">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6H21M19 6V20C19 20.53 18.79 21.04 18.41 21.41C18.04 21.79 17.53 22 17 22H7C6.47 22 5.96 21.79 5.59 21.41C5.21 21.04 5 20.53 5 20V6M8 6V4C8 3.47 8.21 2.96 8.59 2.59C8.96 2.21 9.47 2 10 2H14C14.53 2 15.04 2.21 15.41 2.59C15.79 2.96 16 3.47 16 4V6"/></svg>
                    </button>
                </div>
            </div>
            <div class="page-card__body">
                <h3 class="page-card__name">Directiva</h3>
                <p class="page-card__desc">Integrantes del consejo directivo de la organización, con foto y cargo.</p>
            </div>
            <div class="page-card__footer">
                <span class="page-card__status"><span class="status-dot"></span>Activa</span>
                <a href="{{ route('admin.pages.board.edit') }}" class="card-btn--goto">Editar página <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12H19M13 6l6 6-6 6"/></svg></a>
            </div>
        </div>

        {{-- PREGUNTAS FRECUENTES · color: amarillo --}}
        <div class="page-card" data-color="amber" style="--c1:#d97706;--c2:#b45309;--rgb:217,119,6;">
            <div class="page-card__header">
                <div class="page-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                <div class="page-card__actions">
                    <a href="{{ route('admin.pages.faq.edit') }}" class="card-btn card-btn--edit" title="Editar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3C17.26 2.74 17.57 2.53 17.92 2.39C18.26 2.24 18.63 2.17 19 2.17C19.37 2.17 19.74 2.24 20.08 2.39C20.43 2.53 20.74 2.74 21 3C21.26 3.26 21.47 3.57 21.61 3.92C21.75 4.26 21.83 4.63 21.83 5C21.83 5.37 21.75 5.74 21.61 6.08C21.47 6.43 21.26 6.74 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/preguntas-frecuentes') }}" class="card-btn card-btn--view" title="Ver sitio" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <button class="card-btn card-btn--delete" title="Eliminar" data-page="Preguntas frecuentes">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6H21M19 6V20C19 20.53 18.79 21.04 18.41 21.41C18.04 21.79 17.53 22 17 22H7C6.47 22 5.96 21.79 5.59 21.41C5.21 21.04 5 20.53 5 20V6M8 6V4C8 3.47 8.21 2.96 8.59 2.59C8.96 2.21 9.47 2 10 2H14C14.53 2 15.04 2.21 15.41 2.59C15.79 2.96 16 3.47 16 4V6"/></svg>
                    </button>
                </div>
            </div>
            <div class="page-card__body">
                <h3 class="page-card__name">Preguntas frecuentes</h3>
                <p class="page-card__desc">Respuestas a las dudas más comunes sobre la organización, sus servicios y cómo colaborar.</p>
            </div>
            <div class="page-card__footer">
                <span class="page-card__status"><span class="status-dot"></span>Activa</span>
                <a href="{{ route('admin.pages.faq.edit') }}" class="card-btn--goto">Editar página <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12H19M13 6l6 6-6 6"/></svg></a>
            </div>
        </div>

        {{-- CONTACTO · color: rosa fucsia --}}
        <div class="page-card" data-color="fuchsia" style="--c1:#9b4d77;--c2:#783d66;--rgb:155,77,119;">
            <div class="page-card__header">
                <div class="page-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <path d="M22 7L13.03 12.7C12.72 12.89 12.36 13 12 13C11.64 13 11.28 12.89 10.97 12.7L2 7"/>
                    </svg>
                </div>
                <div class="page-card__actions">
                    <a href="{{ route('admin.pages.contact.edit') }}" class="card-btn card-btn--edit" title="Editar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3C17.26 2.74 17.57 2.53 17.92 2.39C18.26 2.24 18.63 2.17 19 2.17C19.37 2.17 19.74 2.24 20.08 2.39C20.43 2.53 20.74 2.74 21 3C21.26 3.26 21.47 3.57 21.61 3.92C21.75 4.26 21.83 4.63 21.83 5C21.83 5.37 21.75 5.74 21.61 6.08C21.47 6.43 21.26 6.74 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/contacto') }}" class="card-btn card-btn--view" title="Ver sitio" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <button class="card-btn card-btn--delete" title="Eliminar" data-page="Contacto">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6H21M19 6V20C19 20.53 18.79 21.04 18.41 21.41C18.04 21.79 17.53 22 17 22H7C6.47 22 5.96 21.79 5.59 21.41C5.21 21.04 5 20.53 5 20V6M8 6V4C8 3.47 8.21 2.96 8.59 2.59C8.96 2.21 9.47 2 10 2H14C14.53 2 15.04 2.21 15.41 2.59C15.79 2.96 16 3.47 16 4V6"/></svg>
                    </button>
                </div>
            </div>
            <div class="page-card__body">
                <h3 class="page-card__name">Contacto</h3>
                <p class="page-card__desc">Formulario de contacto y datos de ubicación para que los usuarios se comuniquen con la organización.</p>
            </div>
            <div class="page-card__footer">
                <span class="page-card__status"><span class="status-dot"></span>Activa</span>
                <a href="{{ route('admin.pages.contact.edit') }}" class="card-btn--goto">Editar página <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12H19M13 6l6 6-6 6"/></svg></a>
            </div>
        </div>

    </div>{{-- /pages-grid --}}
</div>{{-- /pages-container --}}

<script src="{{ asset('assets/js/page.js') }}"></script>
@endsection