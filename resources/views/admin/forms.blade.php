@extends('admin.dashboard')

@section('title', 'Formulario')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/forms.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

    {{-- Header con estadísticas --}}
    <div class="page-header">
        <div class="header-content">
            <h2>Formularios de Contacto</h2>
            <p>Interesados en realizar donaciones o colaboraciones</p>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <span class="stat-number">{{ $forms->count() }}</span>
                <span class="stat-label">Total</span>
            </div>

            {{--
                Tarjeta dinámica: busca el período más reciente con datos.
                Cascada: semana → mes → 3 meses → 6 meses → año
            --}}
            @php
                $periods = [
                    ['days' => 7,   'label' => 'Esta semana'],
                    ['days' => 30,  'label' => 'Este mes'],
                    ['days' => 90,  'label' => 'Últimos 3 meses'],
                    ['days' => 180, 'label' => 'Últimos 6 meses'],
                    ['days' => 365, 'label' => 'Este año'],
                ];
                $dynamicCount = 0;
                $dynamicLabel = 'Este año';
                foreach ($periods as $period) {
                    $count = $forms->where('fecha_envio', '>=', now()->subDays($period['days']))->count();
                    if ($count > 0) {
                        $dynamicCount = $count;
                        $dynamicLabel = $period['label'];
                        break;
                    }
                }
            @endphp
            <div class="stat-card">
                <span class="stat-number">{{ $dynamicCount }}</span>
                <span class="stat-label">{{ $dynamicLabel }}</span>
            </div>
        </div>
    </div>

    <div class="table-container" id="tableContainer">

        {{-- Barra de herramientas --}}
        <div class="table-toolbar">

            <div class="search-box">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M9 17A8 8 0 1 0 9 1a8 8 0 0 0 0 16zM18 18l-4.35-4.35"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <input type="text"
                    id="searchInput"
                    placeholder="Buscar por nombre, correo o asunto..."
                    class="search-input">
            </div>

            <div class="filter-group">
                <select id="dateFilter" class="filter-select">
                    <option value="">Todas las fechas</option>
                    <option value="today">Hoy</option>
                    <option value="week">Esta semana</option>
                    <option value="month">Este mes</option>
                </select>

                <button id="sortDate" class="sort-button" data-order="desc">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M6 9l4 4 4-4"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Más reciente</span>
                </button>

                <button type="button" class="export-button">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                        <path d="M3 17v-2a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2M10 3v12m0 0l-4-4m4 4l4-4"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Exportar PDF
                </button>
            </div>

        </div>
        {{-- FIN table-toolbar --}}

        {{-- Tabla --}}
        <div class="table-wrapper">
            <table class="admin-table" id="formsTable">
                <thead>
                    <tr>
                        <th class="th-checkbox">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>Nombre completo</th>
                        <th>Correo</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Teléfono</th>
                        <th class="sortable" data-column="date">
                            Fecha
                            <svg class="sort-icon" width="16" height="16" viewBox="0 0 16 16">
                                <path d="M8 3v10M8 3l-3 3m3-3l3 3"
                                    stroke="currentColor" stroke-width="1.5" fill="none"/>
                            </svg>
                        </th>
                        <th class="th-actions">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($forms as $form)
                    <tr data-id="{{ $form->id_formcontacto }}" data-date="{{ $form->fecha_envio }}">

                        <td data-label="Nombre">
                            <div class="user-info">
                                <div class="user-avatar">
                                    <input type="checkbox"
                                        class="row-checkbox"
                                        value="{{ $form->id_formcontacto }}">
                                    <span class="avatar-letter">
                                        {{ strtoupper(substr($form->nombre_completo, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="user-name">{{ $form->nombre_completo }}</span>
                            </div>
                        </td>

                        <td data-label="Correo">
                            <a href="mailto:{{ $form->correo }}" class="email-link">
                                {{ $form->correo }}
                            </a>
                        </td>

                        <td data-label="Asunto">
                            <span class="subject-text">{{ $form->asunto }}</span>
                        </td>

                        <td data-label="Mensaje" title="{{ $form->mensaje }}">
                            <span class="message-text">{{ $form->mensaje }}</span>
                        </td>

                        <td data-label="Teléfono">
                            @if($form->numero_telefonico)
                                <a href="tel:{{ $form->numero_telefonico }}" class="phone-link">
                                    {{ $form->numero_telefonico }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        <td data-label="Fecha">
                            <span class="date-badge">
                                {{ \Carbon\Carbon::parse($form->fecha_envio)->format('d/m/Y H:i') }}
                            </span>
                        </td>

                        <td class="td-actions">
                            <div class="action-buttons">
                                <button class="btn-action btn-view"
                                    onclick="viewForm({{ $form->id_formcontacto }})"
                                    title="Ver detalles">
                                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                                        <path d="M10 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"
                                            stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M10 5C5.5 5 2 10 2 10s3.5 5 8 5 8-5 8-5-3.5-5-8-5z"
                                            stroke="currentColor" stroke-width="1.5"/>
                                    </svg>
                                </button>
                                <button class="btn-action btn-delete"
                                    onclick="deleteForm({{ $form->id_formcontacto }})"
                                    title="Eliminar">
                                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                                        <path d="M3 5h14M8 5V3h4v2m-5 4v6m4-6v6m-7-9v11a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V5"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <div class="empty-content">
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                                    <circle cx="32" cy="32" r="30" stroke="#e5e7eb" stroke-width="4"/>
                                    <path d="M32 20v16m0 4h.02" stroke="#9ca3af" stroke-width="4" stroke-linecap="round"/>
                                </svg>
                                <p>No hay formularios para mostrar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- FIN table-wrapper --}}

        {{-- Paginación --}}
        <div class="table-footer">
            <div class="footer-info">
                Mostrando <strong>{{ $forms->count() > 0 ? '1-' . $forms->count() : '0' }}</strong>
                de <strong>{{ $forms->count() }}</strong> registros
            </div>
            <div class="pagination">
                <button class="page-btn" disabled>Anterior</button>
                <button class="page-btn active">1</button>
                <button class="page-btn" disabled>Siguiente</button>
            </div>
        </div>
        {{-- FIN table-footer --}}

    </div>
    {{-- FIN table-container --}}

    {{-- Modal de detalle de formulario --}}
    <div class="form-modal-overlay" id="formModalOverlay" role="dialog" aria-modal="true">
        <div class="form-modal" id="formModal">

            <div class="form-modal-header">
                <div class="form-modal-avatar" id="modalAvatar">?</div>
                <div class="form-modal-title">
                    <h3 id="modalName">—</h3>
                    <span id="modalAsunto">—</span>
                </div>
                <button class="form-modal-close" id="modalClose" aria-label="Cerrar">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M14 4L4 14M4 4l10 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <div class="form-modal-body">

                <div class="form-modal-field">
                    <div class="form-modal-field-icon">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                            <path d="M2 5l8 5 8-5M2 5v10a1 1 0 001 1h14a1 1 0 001-1V5a1 1 0 00-1-1H3a1 1 0 00-1 1z"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="form-modal-field-content">
                        <div class="form-modal-field-label">Correo electrónico</div>
                        <div class="form-modal-field-value" id="modalCorreo">—</div>
                    </div>
                </div>

                <div class="form-modal-field">
                    <div class="form-modal-field-icon">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                            <path d="M2 3h3l2 4.5L5 9a11 11 0 006 6l1.5-2 4.5 2v3A1 1 0 0116 19C8.3 19 1 11.7 1 4a1 1 0 011-1z"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="form-modal-field-content">
                        <div class="form-modal-field-label">Teléfono</div>
                        <div class="form-modal-field-value" id="modalTelefono">—</div>
                    </div>
                </div>

                <div class="form-modal-field">
                    <div class="form-modal-field-icon">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                            <circle cx="10" cy="9" r="7" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M10 6v4l2.5 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="form-modal-field-content">
                        <div class="form-modal-field-label">Fecha de envío</div>
                        <div class="form-modal-field-value">
                            <span class="form-modal-date-badge" id="modalFecha">—</span>
                        </div>
                    </div>
                </div>

                <div class="form-modal-field">
                    <div class="form-modal-field-icon">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                            <path d="M2 5h16M2 10h10M2 15h7"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="form-modal-field-content">
                        <div class="form-modal-field-label">Mensaje</div>
                        <div class="form-modal-message" id="modalMensaje">—</div>
                    </div>
                </div>

            </div>

            <div class="form-modal-footer">
                <button class="form-modal-btn form-modal-btn-close" id="modalBtnClose">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M12 4L4 12M4 4l8 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    Cerrar
                </button>
                <button class="form-modal-btn form-modal-btn-delete" id="modalBtnDelete">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                        <path d="M3 5h14M8 5V3h4v2m-5 4v6m4-6v6m-7-9v11a2 2 0 002 2h6a2 2 0 002-2V5"
                            stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                    Eliminar
                </button>
            </div>

        </div>
    </div>

    {{-- Barra flotante de selección --}}
    <div class="selection-bar" id="selectionBar">
        <div class="sel-info">
            <span>Seleccionados:</span>
            <span class="sel-count" id="selCount">0</span>
        </div>
        <div class="sel-actions">
            <button class="sel-btn sel-btn-all" id="selectAllBtn">Seleccionar todos</button>
            <button class="sel-btn sel-btn-clear" id="clearSelBtn">Limpiar selección</button>
            <button class="sel-btn sel-btn-delete" id="deleteSelBtn">Eliminar seleccionados</button>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/forms.js') }}"></script>
@endpush