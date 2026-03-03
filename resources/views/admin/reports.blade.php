@extends('admin.dashboard')

@section('title', 'Informes')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/reports.css') }}">
@endpush

@section('content')
<div class="reports-container">

    @if(session('success'))
        <div id="flash-msg"
             style="background:#d1fae5;color:#065f46;padding:0.85rem 1.25rem;border-radius:10px;margin-bottom:1.25rem;font-weight:600;font-size:0.9rem;">
            {{ session('success') }}
        </div>
    @endif

    {{-- ════════════════════════════════════════
         VISTA 1: Calendario
    ════════════════════════════════════════ --}}
    <div id="calendar-view" class="view-section active">

        <div class="calendar-right-col">
            <button class="btn-action btn-create" onclick="showCreateView()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="6" width="18" height="15" rx="2" stroke="currentColor" stroke-width="2"/>
                    <path d="M3 10H21M8 3V6M16 3V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 14V18M10 16H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                Crear nuevo informe
            </button>
            <button class="btn-action btn-history" onclick="showHistoryView()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 8V12L14.5 14.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M3.05 11C3.55 6.5 7.36 3 12 3C16.97 3 21 7.03 21 12C21 16.97 16.97 21 12 21C8.41 21 5.32 19.18 3.64 16.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M3 16H7V20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Historial
            </button>

            <div class="calendar-notes-panel">
                <h4>NOTAS</h4>
                <p id="selected-date-notes" class="notes-content">
                    Selecciona una fecha para ver los eventos
                </p>
            </div>
        </div>

        <div class="calendar-wrapper">
            <div class="calendar-header">
                <button class="btn-nav" onclick="previousMonth()">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <h3 id="calendar-month">Enero 2026</h3>
                <button class="btn-nav" onclick="nextMonth()">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="calendar-days">
                <div class="day-header"><span class="day-full">Lunes</span><span class="day-short">L</span></div>
                <div class="day-header"><span class="day-full">Martes</span><span class="day-short">M</span></div>
                <div class="day-header"><span class="day-full">Miércoles</span><span class="day-short">X</span></div>
                <div class="day-header"><span class="day-full">Jueves</span><span class="day-short">J</span></div>
                <div class="day-header"><span class="day-full">Viernes</span><span class="day-short">V</span></div>
                <div class="day-header"><span class="day-full">Sábado</span><span class="day-short">S</span></div>
                <div class="day-header"><span class="day-full">Domingo</span><span class="day-short">D</span></div>
            </div>
            <div id="calendar-dates" class="calendar-dates"></div>
        </div>

    </div>{{-- /#calendar-view --}}


    {{-- ════════════════════════════════════════
         VISTA 2: Crear Informe
    ════════════════════════════════════════ --}}
    <div id="create-view" class="view-section">
        <div class="reports-header">
            <button class="btn-back" onclick="showCalendarView()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Volver</span>
            </button>
            <h2>Nuevo informe</h2>
        </div>

        @if($errors->any())
            <div style="background:#fee2e2;color:#991b1b;padding:0.85rem 1.25rem;border-radius:10px;margin-bottom:1rem;font-size:0.88rem;">
                <ul style="margin:0;padding-left:1.2rem;">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.reports.store') }}" method="POST" id="create-report-form">
            @csrf
            <input type="hidden" name="_action" id="form-action" value="save">

            <div class="create-form">

                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre de la organización</label>
                        <div class="input-with-icon">
                            <input type="text" name="nombre_organizacion"
                                   value="{{ old('nombre_organizacion', 'Ajal-lol AC') }}" required>
                            <button type="button" class="btn-edit-input" onclick="toggleEdit(this)" title="Editar">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Evento</label>
                        <div class="input-with-icon">
                            <input type="text" name="evento"
                                   value="{{ old('evento') }}" required placeholder="Nombre del evento">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Lugar</label>
                        <div class="input-with-icon">
                            <input type="text" name="lugar"
                                   value="{{ old('lugar') }}" required placeholder="Ciudad, Estado">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Fecha</label>
                        <div class="input-with-icon">
                            <input type="date" name="fecha" value="{{ old('fecha') }}" required>
                            <button type="button" class="btn-edit-input" onclick="toggleEdit(this)" title="Editar fecha">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-section">
                    <div class="table-header">
                        <div class="table-col">Nº</div>
                        <div class="table-col">Persona beneficiaria</div>
                        <div class="table-col">CURP</div>
                        <div class="table-col col-delete"></div>
                    </div>
                    <div class="table-body" id="beneficiaries-table">
                        @php $oldBenef = old('beneficiarios', array_fill(0, 6, ['nombre'=>'','curp'=>''])); @endphp
                        @foreach($oldBenef as $i => $b)
                        <div class="table-row" id="row-{{ $i }}">
                            <div class="table-cell row-num">{{ $i + 1 }}</div>
                            <div class="table-cell">
                                <input type="text" name="beneficiarios[{{ $i }}][nombre]"
                                       placeholder="Nombre completo" value="{{ $b['nombre'] ?? '' }}">
                            </div>
                            <div class="table-cell">
                                <input type="text" name="beneficiarios[{{ $i }}][curp]"
                                       placeholder="CURP" value="{{ $b['curp'] ?? '' }}"
                                       maxlength="18" style="text-transform:uppercase">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="table-footer-actions">
                        <button type="button" id="btn-add-row" class="btn-table-action add">
                            + Agregar beneficiario
                        </button>
                        <button type="button" id="btn-remove-row" class="btn-table-action remove">
                            - Quitar último
                        </button>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.reports.blank') }}" class="btn-form btn-blank">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 2V8H20M8 13H16M8 17H12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Solo formato
                    </a>
                    <button type="button" class="btn-form btn-export" data-action="pdf_download">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7 10L12 15M12 15L17 10M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Exportar
                    </button>
                    <button type="button" class="btn-form btn-print" data-action="pdf_print">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9V2H18V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 18H4C3.46957 18 2.96086 17.7893 2.58579 17.4142C2.21071 17.0391 2 16.5304 2 16V11C2 10.4696 2.21071 9.96086 2.58579 9.58579C2.96086 9.21071 3.46957 9 4 9H20C20.5304 9 21.0391 9.21071 21.4142 9.58579C21.7893 9.96086 22 10.4696 22 11V16C22 16.5304 21.7893 17.0391 21.4142 17.4142C21.0391 17.7893 20.5304 18 20 18H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="6" y="14" width="12" height="8" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Imprimir
                    </button>
                    <button type="submit" class="btn-form btn-save">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16L21 8V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17 21V13H7V21M7 3V8H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>


    {{-- ════════════════════════════════════════
         VISTA 3: Historial
    ════════════════════════════════════════ --}}
    <div id="history-view" class="view-section">
        <div class="reports-header">
            <button class="btn-back" onclick="showCalendarView()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Volver</span>
            </button>
            <h2>Historial</h2>

            @php
                $currentMonth = date('m');
                $currentYear  = date('Y');
                $dbYears      = $reports->pluck('fecha')->map(fn($f) => substr($f, 0, 4))->unique();
                $dbMonthsNum  = $reports->pluck('fecha')->map(fn($f) => substr($f, 5, 2))->unique();
                if (!$dbYears->contains($currentYear))     $dbYears->push($currentYear);
                if (!$dbMonthsNum->contains($currentMonth)) $dbMonthsNum->push($currentMonth);
                $dbYears     = $dbYears->sortDesc();
                $dbMonthsNum = $dbMonthsNum->sort();
                $nombresMeses = [
                    '01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril',
                    '05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto',
                    '09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre'
                ];
            @endphp

            <div class="history-controls">
                <div class="quick-filters desktop-only">
                    <button class="filter-tag" data-filter="week">Esta semana</button>
                    <button class="filter-tag" data-filter="month">Este mes</button>
                    <button class="filter-tag active" data-filter="year">Este año</button>
                    <button class="filter-tag" data-filter="all">Todos</button>
                </div>
                <div class="controls-right">
                    <button class="filter-btn" id="btn-sort-date" data-order="desc" title="Ordenar por fecha">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                            <path class="sort-desc" d="M4 6h16M4 12h10M4 18h4"/>
                            <path class="sort-asc"  d="M4 18h16M4 12h10M4 6h4"/>
                        </svg>
                        <span id="sort-text">Recientes</span>
                    </button>
                    <button class="filter-btn" id="btn-toggle-filters" title="Mostrar opciones de filtrado">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        <span>Filtros</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Panel filtros --}}
        <div class="filters-panel" id="filters-panel">
            <div class="filters-panel-inner-wrap">
                <div class="filters-panel-inner">

                    <div class="filters-section mobile-only">
                        <span class="filters-label">Rápidos:</span>
                        <div class="quick-filters">
                            <button class="filter-tag" data-filter="week">Esta semana</button>
                            <button class="filter-tag" data-filter="month">Este mes</button>
                            <button class="filter-tag active" data-filter="year">Este año</button>
                            <button class="filter-tag" data-filter="all">Todos</button>
                        </div>
                    </div>

                    <div class="filters-divider mobile-only"></div>

                    <div class="filters-section">
                        <span class="filters-label">Específicos:</span>
                        <div class="custom-filters">
                            <div class="custom-dropdown" id="dropdown-month">
                                <button class="dropdown-trigger" type="button">
                                    <span class="dropdown-label">Todos los meses</span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item selected" data-value="all">Todos los meses</li>
                                    @foreach($dbMonthsNum as $num)
                                        <li class="dropdown-item" data-value="{{ $num }}">{{ $nombresMeses[$num] }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="custom-dropdown" id="dropdown-year">
                                <button class="dropdown-trigger" type="button">
                                    <span class="dropdown-label">Todos los años</span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item selected" data-value="all">Todos los años</li>
                                    @foreach($dbYears as $year)
                                        <li class="dropdown-item" data-value="{{ $year }}">{{ $year }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Barra de búsqueda --}}
        <div class="search-bar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" id="search-input" placeholder="Buscar evento o lugar…">
        </div>

        {{-- Separador con contador --}}
        <div class="history-meta">
            <div class="history-meta-line"></div>
            <div class="history-count">
                <span>Mostrando</span>
                <span class="count-badge" id="count-badge">{{ $reports->count() }}</span>
                <span>informes</span>
            </div>
            <div class="history-meta-line"></div>
        </div>

        {{-- Lista --}}
        <div class="history-list" id="history-list">
            @forelse($reports as $index => $report)
            <div class="history-group">
                <div class="history-item {{ $index % 2 === 0 ? 'highlight' : 'accent' }}"
                     data-fecha="{{ $report->fecha }}"
                     data-id="{{ $report->id_informe }}">

                    {{-- Ícono --}}
                    <div class="item-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                    </div>

                    {{-- Contenido --}}
                    <div class="history-content">
                        <h4>{{ Str::limit($report->evento, 50) }}</h4>
                        <div class="history-meta-row">
                            <span class="history-date">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($report->fecha)->format('d/m/Y') }}
                            </span>
                            @if($report->lugar)
                                <span class="history-dot"></span>
                                <span class="history-place">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    {{ Str::limit($report->lugar, 25) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Botón PDF --}}
                    <div class="item-actions">
                        <a href="{{ route('admin.reports.pdf', $report->id_informe) }}"
                           class="btn-print-small" title="Descargar PDF"
                           onclick="event.stopPropagation()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                <rect x="6" y="14" width="12" height="8"/>
                            </svg>
                        </a>
                    </div>

                    {{-- Flecha --}}
                    <div class="item-arrow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </div>

                </div>
            </div>
            @empty
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
                </svg>
                <p>No hay informes registrados aún.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

<!-- MODAL -->
<div class="event-modal-overlay" id="event-overlay" onclick="closeEventModal()"></div>
<div class="event-modal" id="event-modal">

    <button class="btn-close-modal" onclick="closeEventModal()">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    {{-- Hero con gradiente --}}
    <div class="event-modal-hero">
        <div class="modal-hero-icon">
            {{-- Ícono de manos / evento --}}
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 11V7a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v4M14 9V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v5M10 10V5a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v9l-1-1a2 2 0 0 0-2.73.12l-.14.15 4 5.5A5 5 0 0 0 8 21h6a5 5 0 0 0 5-5v-5a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2z" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h3 id="event-modal-title">—</h3>
        <div class="modal-hero-chips">
            <div class="modal-chip" id="modal-chip-fecha">
                <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="white" stroke-width="2"/><path d="M16 2v4M8 2v4M3 10h18" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                <span id="event-modal-subtitle">—</span>
            </div>
            <div class="modal-chip" id="modal-chip-lugar">
                {{-- Silueta de ciudad --}}
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M2 20h20M4 20V10l5-4 5 4v10M14 20v-6h4v6M9 12h2M9 16h2" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span id="event-modal-lugar">—</span>
            </div>
        </div>
    </div>

    {{-- Tarjetas de info --}}
    <div class="event-modal-body">
        <div class="modal-info-card">
            <div class="modal-info-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="modal-info-text">
                <div class="modal-info-label">Fecha del evento</div>
                <div class="modal-info-value" id="modal-info-fecha">—</div>
            </div>
        </div>
        <div class="modal-info-card">
            <div class="modal-info-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M2 20h20M4 20V10l5-4 5 4v10M14 20v-6h4v6M9 12h2M9 16h2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="modal-info-text">
                <div class="modal-info-label">Lugar</div>
                <div class="modal-info-value" id="modal-info-lugar">—</div>
            </div>
        </div>
        <div class="modal-info-card">
            <div class="modal-info-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="modal-info-text">
                <div class="modal-info-label">Organización</div>
                <div class="modal-info-value" id="modal-info-org">Ajal-lol AC</div>
            </div>
        </div>
    </div>

    {{-- Acciones --}}
    <div class="event-modal-actions">
        <a id="btn-modal-view" href="#" class="btn-modal btn-modal-view" target="_blank">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
            </svg>
            Ver PDF
        </a>
        <a id="btn-modal-pdf" href="#" class="btn-modal btn-modal-print" target="_blank">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M6 9V2H18V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6 18H4C2.89543 18 2 17.1046 2 16V11C2 9.89543 2.89543 9 4 9H20C21.1046 9 22 9.89543 22 11V16C22 17.1046 21.1046 18 20 18H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="6" y="14" width="12" height="8" stroke="currentColor" stroke-width="2"/>
            </svg>
            Imprimir PDF
        </a>
        <button class="btn-modal btn-modal-edit" id="btn-modal-delete">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M3 6H21M8 6V4H16V6M19 6L18 20H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Eliminar informe
        </button>
    </div>

</div>

<script>
    const eventsFromDB      = @json($events->toArray());
    const ROUTE_BASE        = "{{ url('admin/report') }}";
    const CSRF_TOKEN        = "{{ csrf_token() }}";
    const ROUTE_PREVIEW_PDF = "{{ route('admin.reports.previewPdf') }}";

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => showCreateView());
    @endif

    document.addEventListener('DOMContentLoaded', () => {
        const flash = document.getElementById('flash-msg');
        if (flash) setTimeout(() => { flash.style.transition = 'opacity .5s'; flash.style.opacity = '0'; }, 3000);
    });
</script>
<script src="{{ asset('assets/js/reports.js') }}"></script>
@endsection