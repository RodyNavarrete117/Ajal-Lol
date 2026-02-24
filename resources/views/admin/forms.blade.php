@extends('admin.dashboard')

@section('title', 'Formulario')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/forms.css') }}">
<!-- Sweet Alert 2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
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
            <div class="stat-card">
                <span class="stat-number">{{ $forms->where('fecha_envio', '>=', now()->subDays(7))->count() }}</span>
                <span class="stat-label">Esta semana</span>
            </div>
        </div>
    </div>

    <div class="table-container">
        <!-- Barra de herramientas -->
        <div class="table-toolbar">
            <div class="search-box">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M9 17A8 8 0 1 0 9 1a8 8 0 0 0 0 16zM18 18l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Buscar por nombre, correo o asunto..." class="search-input">
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
                        <path d="M6 9l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Más reciente</span>
                </button>
                <!-- Exportar PDF -->
                <button type="button" class="export-button">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                        <path d="M3 17v-2a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2M10 3v12m0 0l-4-4m4 4l4-4"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"/>
                    </svg>
                    Exportar PDF
                </button>

                <script>
                const exportButton = document.querySelector('.export-button');
                exportButton.addEventListener('click', exportForms); // Solo JS
                </script>
        </div>

        <!-- Tabla -->
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
                        <th>Teléfono</th>
                        <th class="sortable" data-column="date">
                            Fecha
                            <svg class="sort-icon" width="16" height="16" viewBox="0 0 16 16">
                                <path d="M8 3v10M8 3l-3 3m3-3l3 3" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            </svg>
                        </th>
                        <th class="th-actions">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($forms as $form)
                    <tr data-id="{{ $form->id_formcontacto }}" data-date="{{ $form->fecha_envio }}">
                        <td class="td-checkbox">
                            <input type="checkbox" class="row-checkbox" value="{{ $form->id_formcontacto }}">
                        </td>
                        <td data-label="Nombre">
                            <div class="user-info">
                                <div class="user-avatar">{{ strtoupper(substr($form->nombre_completo, 0, 1)) }}</div>
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
                            <span class="date-badge">{{ \Carbon\Carbon::parse($form->fecha_envio)->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="td-actions">
                            <div class="action-buttons">
                                <button class="btn-action btn-view" onclick="viewForm({{ $form->id_formcontacto }})" title="Ver detalles">
                                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                                        <path d="M10 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M10 5C5.5 5 2 10 2 10s3.5 5 8 5 8-5 8-5-3.5-5-8-5z" stroke="currentColor" stroke-width="1.5"/>
                                    </svg>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteForm({{ $form->id_formcontacto }})" title="Eliminar">
                                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                                        <path d="M3 5h14M8 5V3h4v2m-5 4v6m4-6v6m-7-9v11a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
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

        <!-- Paginación -->
        <div class="table-footer">
            <div class="footer-info">
                Mostrando <strong>{{ $forms->count() > 0 ? '1-' . $forms->count() : '0' }}</strong> de <strong>{{ $forms->count() }}</strong> registros
            </div>
            <div class="pagination">
                <button class="page-btn" disabled>Anterior</button>
                <button class="page-btn active">1</button>
                <button class="page-btn" disabled>Siguiente</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('assets/js/forms.js') }}"></script>
@endpush