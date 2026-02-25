@extends('admin.dashboard')

@section('title', 'Informes')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/reports.css') }}">
@endpush

@section('content')
<div class="reports-container">

    {{-- ── Flash ── --}}
    @if(session('success'))
        <div class="alert-success" id="flash-msg"
             style="background:#d1fae5;color:#065f46;padding:1rem 1.5rem;border-radius:12px;margin-bottom:1.5rem;font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    <!-- VISTA 1: Calendario (vista por defecto) -->
    <div id="calendar-view" class="view-section active">
        <div class="reports-header">
            <button class="btn-back" onclick="window.history.back()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="header-actions">
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

            <div class="calendar-grid">
                <div class="calendar-days">
                    <div class="day-header"><span class="day-full">Lunes</span><span class="day-short">L</span></div>
                    <div class="day-header"><span class="day-full">Martes</span><span class="day-short">M</span></div>
                    <div class="day-header"><span class="day-full">Miércoles</span><span class="day-short">X</span></div>
                    <div class="day-header"><span class="day-full">Jueves</span><span class="day-short">J</span></div>
                    <div class="day-header"><span class="day-full">Viernes</span><span class="day-short">V</span></div>
                    <div class="day-header"><span class="day-full">Sábado</span><span class="day-short">S</span></div>
                    <div class="day-header"><span class="day-full">Domingo</span><span class="day-short">D</span></div>
                </div>
                <div id="calendar-dates" class="calendar-dates">
                    <!-- Se genera dinámicamente con JavaScript -->
                </div>
            </div>

            <div class="calendar-notes">
                <h4>NOTAS</h4>
                <div id="selected-date-notes" class="notes-content">
                    Selecciona una fecha para ver los eventos
                </div>
            </div>
        </div>
    </div>

    <!-- VISTA 2: Crear Informe -->
    <div id="create-view" class="view-section">
        <div class="reports-header">
            <button class="btn-back" onclick="showCalendarView()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <h2>Informe - crear nuevo informe</h2>
        </div>

        @if($errors->any())
            <div id="validation-errors"
                 style="background:#fee2e2;color:#991b1b;padding:1rem 1.5rem;border-radius:12px;margin-bottom:1.5rem;">
                <ul style="margin:0;padding-left:1.2rem;">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.reports.store') }}" method="POST" id="create-report-form">
            @csrf
            <div class="create-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre de la organización</label>
                        <div class="input-with-icon">
                            <input type="text" name="nombre_organizacion"
                                   value="{{ old('nombre_organizacion', 'Ajal-lol AC') }}" required>
                            <button type="button" class="btn-edit-input" onclick="toggleEdit(this)">
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
                            <button type="button" class="btn-edit-input" onclick="toggleEdit(this)">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Lugar</label>
                        <div class="input-with-icon">
                            <input type="text" name="lugar"
                                   value="{{ old('lugar') }}" required placeholder="Ciudad, Estado">
                            <button type="button" class="btn-edit-input" onclick="toggleEdit(this)">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Fecha</label>
                        <div class="input-with-icon">
                            <input type="date" name="fecha"
                                   value="{{ old('fecha') }}" required>
                            <button type="button" class="btn-calendar">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="3" y="6" width="18" height="15" rx="2" stroke="currentColor" stroke-width="2"/>
                                    <path d="M3 10H21M8 3V6M16 3V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-section">
                    <div class="table-header">
                        <div class="table-col">Número</div>
                        <div class="table-col">Personas beneficiarias</div>
                        <div class="table-col">CURP</div>
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
                    <button type="button" id="btn-add-row"
                            style="width:100%;padding:0.85rem;border:2px dashed var(--rpt-border);background:transparent;border-radius:0 0 14px 14px;cursor:pointer;font-weight:600;color:var(--rpt-text-muted);transition:all .3s;">
                        + Agregar beneficiario
                    </button>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-form btn-export" id="btn-export-csv">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7 10L12 15M12 15L17 10M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Exportar
                    </button>
                    <button type="button" class="btn-form btn-print" onclick="window.print()">
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

    <!-- VISTA 3: Historial -->
    <div id="history-view" class="view-section">
        <div class="reports-header">
            <button class="btn-back" onclick="showCalendarView()">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <h2>Historial</h2>
            <div class="history-filters">
                <button class="filter-btn active" data-filter="week">Esta semana</button>
                <button class="filter-btn" data-filter="month">Este mes</button>
                <button class="filter-btn" data-filter="year">{{ date('Y') }}</button>
            </div>
        </div>

        <div class="history-list" id="history-list">
            @forelse($reports as $index => $report)
            <div class="history-group">
                <div class="history-item {{ $index % 2 === 0 ? 'highlight' : 'accent' }}"
                     data-fecha="{{ $report->fecha }}"
                     data-id="{{ $report->id_informe }}"
                     style="cursor:pointer">
                    <div class="history-content">
                        <h4>{{ Str::limit($report->evento, 45) }}</h4>
                        <span class="history-date">{{ \Carbon\Carbon::parse($report->fecha)->format('d/m/Y') }}</span>
                    </div>
                    <a href="{{ route('admin.reports.pdf', $report->id_informe) }}"
                       class="btn-print-small"
                       title="Descargar PDF"
                       onclick="event.stopPropagation()">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9V2H18V9" stroke="currentColor" stroke-width="2"/>
                            <path d="M6 18H4C2.89543 18 2 17.1046 2 16V11C2 9.89543 2.89543 9 4 9H20C21.1046 9 22 9.89543 22 11V16C22 17.1046 21.1046 18 20 18H18" stroke="currentColor" stroke-width="2"/>
                            <rect x="6" y="14" width="12" height="8" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <p style="color:var(--rpt-text-muted);text-align:center;padding:2rem;">
                No hay informes registrados aún.
            </p>
            @endforelse
        </div>
    </div>
</div>

<!-- MODAL DE DETALLES DEL EVENTO -->
<div class="event-modal-overlay" id="event-overlay" onclick="closeEventModal()"></div>
<div class="event-modal" id="event-modal">
    <button class="btn-close-modal" onclick="closeEventModal()">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
    <div class="event-modal-header">
        <h3 id="event-modal-title">—</h3>
        <p id="event-modal-subtitle"></p>
    </div>
    <div class="event-modal-content">
        <p id="event-modal-description"></p>
    </div>
    <div class="event-modal-actions">
        <a id="btn-modal-view" href="#" class="btn-modal btn-modal-view">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Ver más
        </a>
        <a id="btn-modal-pdf" href="#" class="btn-modal btn-modal-print">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 9V2H18V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6 18H4C3.46957 18 2.96086 17.7893 2.58579 17.4142C2.21071 17.0391 2 16.5304 2 16V11C2 10.4696 2.21071 9.96086 2.58579 9.58579C2.96086 9.21071 3.46957 9 4 9H20C20.5304 9 21.0391 9.21071 21.4142 9.58579C21.7893 9.96086 22 10.4696 22 11V16C22 16.5304 21.7893 17.0391 21.4142 17.4142C21.0391 17.7893 20.5304 18 20 18H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="6" y="14" width="12" height="8" stroke="currentColor" stroke-width="2"/>
            </svg>
            Imprimir PDF
        </a>
        <button class="btn-modal btn-modal-edit" id="btn-modal-delete">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 6H21M8 6V4H16V6M19 6L18 20H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Eliminar
        </button>
    </div>
</div>

{{-- Variables para reports.js --}}
<script>
    const eventsFromDB = @json($events->toArray());
    const ROUTE_BASE   = "{{ url('admin/report') }}";
    const CSRF_TOKEN   = "{{ csrf_token() }}";

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