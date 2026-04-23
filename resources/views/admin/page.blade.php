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

        {{-- INICIO · rosa --}}
        <div class="page-card" data-color="pink" data-active="1" style="--c1:#c2185b;--c2:#880e4f;--rgb:194,24,91;">
            <div class="page-card__header">
                <div class="header-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9L12 2L21 9V20c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V9Z"/><path d="M9 22V12H15V22"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9L12 2L21 9V20c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V9Z"/><path d="M9 22V12H15V22"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9L12 2L21 9V20c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V9Z"/><path d="M9 22V12H15V22"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9L12 2L21 9V20c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V9Z"/><path d="M9 22V12H15V22"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9L12 2L21 9V20c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V9Z"/><path d="M9 22V12H15V22"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9L12 2L21 9V20c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V9Z"/><path d="M9 22V12H15V22"/></svg>
                </div>
                <div class="header-identity">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9L12 2L21 9V20c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V9Z"/><path d="M9 22V12H15V22"/></svg>
                    </div>
                    <h3 class="header-name">Inicio</h3>
                </div>
                <div class="header-controls">
                    <button class="header-btn header-btn--toggle" title="Deshabilitar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <div class="header-divider"></div>
                    <a href="{{ route('admin.pages.home.edit') }}" class="header-btn" title="Editar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3c.5-.5 1.2-.8 2-.8 1.6 0 2.8 1.2 2.8 2.8 0 .8-.3 1.5-.8 2L7.5 20.5 2 22l1.5-5.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/') }}" class="header-btn" title="Ver vista previa" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
            </div>
            <div class="page-card__body">
                <p class="page-card__desc">Bienvenidos al portal informativo de Ajal Lol. Organización de Asistencia Social, sin fines de lucro.</p>
            </div>
            <div class="page-card__footer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <p class="footer-text">Actualizada <strong>hace 2 días</strong></p>
            </div>
        </div>

        {{-- NOSOTROS · violeta --}}
        <div class="page-card" data-color="violet" data-active="1" style="--c1:#6d28d9;--c2:#4c1d95;--rgb:109,40,217;">
            <div class="page-card__header">
                <div class="header-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2c0-2.2 1.8-4 4-4h4c2.2 0 4 1.8 4 4v2"/><circle cx="16.5" cy="7.5" r="3"/><path d="M21 21v-1.5c0-1.4-.8-2.6-2-3.2"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2c0-2.2 1.8-4 4-4h4c2.2 0 4 1.8 4 4v2"/><circle cx="16.5" cy="7.5" r="3"/><path d="M21 21v-1.5c0-1.4-.8-2.6-2-3.2"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2c0-2.2 1.8-4 4-4h4c2.2 0 4 1.8 4 4v2"/><circle cx="16.5" cy="7.5" r="3"/><path d="M21 21v-1.5c0-1.4-.8-2.6-2-3.2"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2c0-2.2 1.8-4 4-4h4c2.2 0 4 1.8 4 4v2"/><circle cx="16.5" cy="7.5" r="3"/><path d="M21 21v-1.5c0-1.4-.8-2.6-2-3.2"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2c0-2.2 1.8-4 4-4h4c2.2 0 4 1.8 4 4v2"/><circle cx="16.5" cy="7.5" r="3"/><path d="M21 21v-1.5c0-1.4-.8-2.6-2-3.2"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2c0-2.2 1.8-4 4-4h4c2.2 0 4 1.8 4 4v2"/><circle cx="16.5" cy="7.5" r="3"/><path d="M21 21v-1.5c0-1.4-.8-2.6-2-3.2"/></svg>
                </div>
                <div class="header-identity">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="7" r="4"/><path d="M3 21V19C3 17.94 3.42 16.92 4.17 16.17C4.92 15.42 5.94 15 7 15H11C12.06 15 13.08 15.42 13.83 16.17C14.58 16.92 15 17.94 15 19V21"/><circle cx="16.5" cy="7.5" r="3"/><path d="M21 21V19.5C21 18.57 20.63 17.68 19.97 17.03C19.32 16.37 18.43 16 17.5 16H17"/></svg>
                    </div>
                    <h3 class="header-name">Nosotros</h3>
                </div>
                <div class="header-controls">
                    <button class="header-btn header-btn--toggle" title="Deshabilitar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <div class="header-divider"></div>
                    <a href="{{ route('admin.pages.about.edit') }}" class="header-btn" title="Editar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3c.5-.5 1.2-.8 2-.8 1.6 0 2.8 1.2 2.8 2.8 0 .8-.3 1.5-.8 2L7.5 20.5 2 22l1.5-5.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/nosotros') }}" class="header-btn" title="Ver vista previa" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
            </div>
            <div class="page-card__body">
                <p class="page-card__desc">Conoce más sobre nosotros. La organización fue fundada en el año 2000 por 5 mujeres quienes compartían...</p>
            </div>
            <div class="page-card__footer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <p class="footer-text">Actualizada <strong>hace 1 semana</strong></p>
            </div>
        </div>

        {{-- ALIADOS · cian --}}
        <div class="page-card" data-color="cyan" data-active="1" style="--c1:#0e7490;--c2:#164e63;--rgb:14,116,144;">
            <div class="page-card__header">
                <div class="header-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M19.414 14.414C21 12.828 22 11.5 22 9.5a5.5 5.5 0 0 0-9.591-3.676.6.6 0 0 1-.818.001A5.5 5.5 0 0 0 2 9.5c0 2.3 1.5 4 3 5.5l5.535 5.362a2 2 0 0 0 2.879.052 2.12 2.12 0 0 0-.004-3 2.124 2.124 0 1 0 3-3 2.124 2.124 0 0 0 3.004 0 2 2 0 0 0 0-2.828l-1.881-1.882a2.41 2.41 0 0 0-3.409 0l-1.71 1.71a2 2 0 0 1-2.828 0 2 2 0 0 1 0-2.828l2.823-2.762"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M19.414 14.414C21 12.828 22 11.5 22 9.5a5.5 5.5 0 0 0-9.591-3.676.6.6 0 0 1-.818.001A5.5 5.5 0 0 0 2 9.5c0 2.3 1.5 4 3 5.5l5.535 5.362a2 2 0 0 0 2.879.052 2.12 2.12 0 0 0-.004-3 2.124 2.124 0 1 0 3-3 2.124 2.124 0 0 0 3.004 0 2 2 0 0 0 0-2.828l-1.881-1.882a2.41 2.41 0 0 0-3.409 0l-1.71 1.71a2 2 0 0 1-2.828 0 2 2 0 0 1 0-2.828l2.823-2.762"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M19.414 14.414C21 12.828 22 11.5 22 9.5a5.5 5.5 0 0 0-9.591-3.676.6.6 0 0 1-.818.001A5.5 5.5 0 0 0 2 9.5c0 2.3 1.5 4 3 5.5l5.535 5.362a2 2 0 0 0 2.879.052 2.12 2.12 0 0 0-.004-3 2.124 2.124 0 1 0 3-3 2.124 2.124 0 0 0 3.004 0 2 2 0 0 0 0-2.828l-1.881-1.882a2.41 2.41 0 0 0-3.409 0l-1.71 1.71a2 2 0 0 1-2.828 0 2 2 0 0 1 0-2.828l2.823-2.762"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M19.414 14.414C21 12.828 22 11.5 22 9.5a5.5 5.5 0 0 0-9.591-3.676.6.6 0 0 1-.818.001A5.5 5.5 0 0 0 2 9.5c0 2.3 1.5 4 3 5.5l5.535 5.362a2 2 0 0 0 2.879.052 2.12 2.12 0 0 0-.004-3 2.124 2.124 0 1 0 3-3 2.124 2.124 0 0 0 3.004 0 2 2 0 0 0 0-2.828l-1.881-1.882a2.41 2.41 0 0 0-3.409 0l-1.71 1.71a2 2 0 0 1-2.828 0 2 2 0 0 1 0-2.828l2.823-2.762"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M19.414 14.414C21 12.828 22 11.5 22 9.5a5.5 5.5 0 0 0-9.591-3.676.6.6 0 0 1-.818.001A5.5 5.5 0 0 0 2 9.5c0 2.3 1.5 4 3 5.5l5.535 5.362a2 2 0 0 0 2.879.052 2.12 2.12 0 0 0-.004-3 2.124 2.124 0 1 0 3-3 2.124 2.124 0 0 0 3.004 0 2 2 0 0 0 0-2.828l-1.881-1.882a2.41 2.41 0 0 0-3.409 0l-1.71 1.71a2 2 0 0 1-2.828 0 2 2 0 0 1 0-2.828l2.823-2.762"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M19.414 14.414C21 12.828 22 11.5 22 9.5a5.5 5.5 0 0 0-9.591-3.676.6.6 0 0 1-.818.001A5.5 5.5 0 0 0 2 9.5c0 2.3 1.5 4 3 5.5l5.535 5.362a2 2 0 0 0 2.879.052 2.12 2.12 0 0 0-.004-3 2.124 2.124 0 1 0 3-3 2.124 2.124 0 0 0 3.004 0 2 2 0 0 0 0-2.828l-1.881-1.882a2.41 2.41 0 0 0-3.409 0l-1.71 1.71a2 2 0 0 1-2.828 0 2 2 0 0 1 0-2.828l2.823-2.762"/></svg>
                </div>
                <div class="header-identity">
                <div class="header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19.414 14.414C21 12.828 22 11.5 22 9.5a5.5 5.5 0 0 0-9.591-3.676.6.6 0 0 1-.818.001A5.5 5.5 0 0 0 2 9.5c0 2.3 1.5 4 3 5.5l5.535 5.362a2 2 0 0 0 2.879.052 2.12 2.12 0 0 0-.004-3 2.124 2.124 0 1 0 3-3 2.124 2.124 0 0 0 3.004 0 2 2 0 0 0 0-2.828l-1.881-1.882a2.41 2.41 0 0 0-3.409 0l-1.71 1.71a2 2 0 0 1-2.828 0 2 2 0 0 1 0-2.828l2.823-2.762"/></svg>
                </div>
                    <h3 class="header-name">Aliados</h3>
                </div>
                <div class="header-controls">
                    <button class="header-btn header-btn--toggle" title="Deshabilitar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <div class="header-divider"></div>
                    <a href="{{ route('admin.pages.allies.edit') }}" class="header-btn" title="Editar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3c.5-.5 1.2-.8 2-.8 1.6 0 2.8 1.2 2.8 2.8 0 .8-.3 1.5-.8 2L7.5 20.5 2 22l1.5-5.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/aliados') }}" class="header-btn" title="Ver vista previa" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
            </div>
            <div class="page-card__body">
                <p class="page-card__desc">Organizaciones e instituciones que colaboran con Ajal Lol en sus programas comunitarios.</p>
            </div>
            <div class="page-card__footer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <p class="footer-text">Actualizada <strong>hace 3 días</strong></p>
            </div>
        </div>

        {{-- ACTIVIDADES · naranja --}}
        <div class="page-card" data-color="orange" data-active="1" style="--c1:#c2410c;--c2:#9a3412;--rgb:194,65,12;">
            <div class="page-card__header">
                <div class="header-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div class="header-identity">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h3 class="header-name">Actividades</h3>
                </div>
                <div class="header-controls">
                    <button class="header-btn header-btn--toggle" title="Deshabilitar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <div class="header-divider"></div>
                    <a href="{{ route('admin.pages.activities.edit') }}" class="header-btn" title="Editar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3c.5-.5 1.2-.8 2-.8 1.6 0 2.8 1.2 2.8 2.8 0 .8-.3 1.5-.8 2L7.5 20.5 2 22l1.5-5.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/actividades') }}" class="header-btn" title="Ver vista previa" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
            </div>
            <div class="page-card__body">
                <p class="page-card__desc">Registro de actividades realizadas por año. Talleres, jornadas y eventos comunitarios.</p>
            </div>
            <div class="page-card__footer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <p class="footer-text">Actualizada <strong>hace 5 días</strong></p>
            </div>
        </div>

        {{-- PROYECTOS · verde --}}
        <div class="page-card" data-color="green" data-active="1" style="--c1:#15803d;--c2:#14532d;--rgb:21,128,61;">
            <div class="page-card__header">
                <div class="header-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="header-identity">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <h3 class="header-name">Proyectos</h3>
                </div>
                <div class="header-controls">
                    <button class="header-btn header-btn--toggle" title="Deshabilitar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <div class="header-divider"></div>
                    <a href="{{ route('admin.pages.projects.edit') }}" class="header-btn" title="Editar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3c.5-.5 1.2-.8 2-.8 1.6 0 2.8 1.2 2.8 2.8 0 .8-.3 1.5-.8 2L7.5 20.5 2 22l1.5-5.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/proyectos') }}" class="header-btn" title="Ver vista previa" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
            </div>
            <div class="page-card__body">
                <p class="page-card__desc">Proyectos sociales clasificados por categoría y año. Alimentación, educación, salud y más.</p>
            </div>
            <div class="page-card__footer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <p class="footer-text">Actualizada <strong>hace 2 semanas</strong></p>
            </div>
        </div>

        {{-- DIRECTIVA · indigo --}}
        <div class="page-card" data-color="indigo" data-active="1" style="--c1:#3730a3;--c2:#312e81;--rgb:55,48,163;">
            <div class="page-card__header">
                <div class="header-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="header-identity">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3 class="header-name">Directiva</h3>
                </div>
                <div class="header-controls">
                    <button class="header-btn header-btn--toggle" title="Deshabilitar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <div class="header-divider"></div>
                    <a href="{{ route('admin.pages.board.edit') }}" class="header-btn" title="Editar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3c.5-.5 1.2-.8 2-.8 1.6 0 2.8 1.2 2.8 2.8 0 .8-.3 1.5-.8 2L7.5 20.5 2 22l1.5-5.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/directiva') }}" class="header-btn" title="Ver vista previa" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
            </div>
            <div class="page-card__body">
                <p class="page-card__desc">Integrantes del consejo directivo de la organización, con foto y cargo.</p>
            </div>
            <div class="page-card__footer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <p class="footer-text">Actualizada <strong>hace 1 mes</strong></p>
            </div>
        </div>

        {{-- PREGUNTAS FRECUENTES · ámbar --}}
        <div class="page-card" data-color="amber" data-active="1" style="--c1:#b45309;--c2:#92400e;--rgb:180,83,9;">
            <div class="page-card__header">
                <div class="header-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <div class="header-identity">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <h3 class="header-name">Preguntas frecuentes</h3>
                </div>
                <div class="header-controls">
                    <button class="header-btn header-btn--toggle" title="Deshabilitar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <div class="header-divider"></div>
                    <a href="{{ route('admin.pages.faq.edit') }}" class="header-btn" title="Editar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3c.5-.5 1.2-.8 2-.8 1.6 0 2.8 1.2 2.8 2.8 0 .8-.3 1.5-.8 2L7.5 20.5 2 22l1.5-5.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/preguntas-frecuentes') }}" class="header-btn" title="Ver vista previa" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
            </div>
            <div class="page-card__body">
                <p class="page-card__desc">Respuestas a las dudas más comunes sobre la organización, sus servicios y cómo colaborar.</p>
            </div>
            <div class="page-card__footer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <p class="footer-text">Actualizada <strong>hace 4 días</strong></p>
            </div>
        </div>

        {{-- CONTACTO · fucsia --}}
        <div class="page-card" data-color="fuchsia" data-active="1" style="--c1:#783d66;--c2:#5b2d4e;--rgb:120,61,102;">
            <div class="page-card__header">
                <div class="header-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7L13.03 12.7C12.72 12.89 12.36 13 12 13C11.64 13 11.28 12.89 10.97 12.7L2 7"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7L13.03 12.7C12.72 12.89 12.36 13 12 13C11.64 13 11.28 12.89 10.97 12.7L2 7"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7L13.03 12.7C12.72 12.89 12.36 13 12 13C11.64 13 11.28 12.89 10.97 12.7L2 7"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7L13.03 12.7C12.72 12.89 12.36 13 12 13C11.64 13 11.28 12.89 10.97 12.7L2 7"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7L13.03 12.7C12.72 12.89 12.36 13 12 13C11.64 13 11.28 12.89 10.97 12.7L2 7"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7L13.03 12.7C12.72 12.89 12.36 13 12 13C11.64 13 11.28 12.89 10.97 12.7L2 7"/></svg>
                </div>
                <div class="header-identity">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7L13.03 12.7C12.72 12.89 12.36 13 12 13C11.64 13 11.28 12.89 10.97 12.7L2 7"/></svg>
                    </div>
                    <h3 class="header-name">Contacto</h3>
                </div>
                <div class="header-controls">
                    <button class="header-btn header-btn--toggle" title="Deshabilitar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <div class="header-divider"></div>
                    <a href="{{ route('admin.pages.contact.edit') }}" class="header-btn" title="Editar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3c.5-.5 1.2-.8 2-.8 1.6 0 2.8 1.2 2.8 2.8 0 .8-.3 1.5-.8 2L7.5 20.5 2 22l1.5-5.5L17 3Z"/></svg>
                    </a>
                    <a href="{{ url('/contacto') }}" class="header-btn" title="Ver vista previa" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
            </div>
            <div class="page-card__body">
                <p class="page-card__desc">Formulario de contacto y datos de ubicación para que los usuarios se comuniquen con la organización.</p>
            </div>
            <div class="page-card__footer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <p class="footer-text">Actualizada <strong>hace 6 días</strong></p>
            </div>
        </div>

                {{-- DONATIVOS · emerald --}}
        <div class="page-card" data-color="emerald" data-active="1" style="--c1:#059669;--c2:#065f46;--rgb:5,150,105;">
            <div class="page-card__header">
                <div class="header-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 21c-4-4-8-6.5-8-11a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 4.5-4 7-8 11z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 21c-4-4-8-6.5-8-11a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 4.5-4 7-8 11z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 21c-4-4-8-6.5-8-11a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 4.5-4 7-8 11z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 21c-4-4-8-6.5-8-11a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 4.5-4 7-8 11z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 21c-4-4-8-6.5-8-11a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 4.5-4 7-8 11z"/></svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 21c-4-4-8-6.5-8-11a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 4.5-4 7-8 11z"/></svg>
                </div>
                <div class="header-identity">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 21c-4-4-8-6.5-8-11a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 4.5-4 7-8 11z"/></svg>
                    </div>
                    <h3 class="header-name">Donativos</h3>
                </div>
                <div class="header-controls">
                    <button class="header-btn header-btn--toggle" title="Deshabilitar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <div class="header-divider"></div>
                    <a href="{{ route('admin.pages.donations.edit') }}" class="header-btn" title="Editar página">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 3L2 22l5.5-1.5L22 5c1-1 1-3 0-4s-3-1-4 0Z"/></svg>
                    </a>
                    <a href="{{ url('/donativos') }}" class="header-btn" title="Ver vista previa" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
            </div>
            <div class="page-card__body">
                <p class="page-card__desc">Apoya a la organización mediante donaciones. Contribuye a nuestros programas sociales y comunitarios.</p>
            </div>
            <div class="page-card__footer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <p class="footer-text">Actualizada <strong>recientemente</strong></p>
            </div>
        </div>
            </div>{{-- /pages-grid --}}
        </div>{{-- /pages-container --}}

<script src="{{ asset('assets/js/page.js') }}"></script>
@endsection