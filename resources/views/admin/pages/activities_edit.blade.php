@extends('admin.dashboard')

@section('title', 'Editar Página - Actividades')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/activities_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- ── Hero Header ── --}}
        <div class="edit-header">
            <div class="edit-header__bg">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="edit-header-top">
                <div class="edit-icon"><i class="fa fa-calendar-days"></i></div>
                <h2>Editar Página Actividades</h2>
            </div>
            <p class="subtitle">Administra el encabezado, año activo y cada tarjeta de actividad que se muestra en la página pública.</p>
        </div>

        {{-- ── Tabs ── --}}
        <div class="edit-tabs-bar">
            <button class="edit-tab active" data-target="encabezado">
                <i class="fa fa-heading"></i> Encabezado
            </button>
            <button class="edit-tab" data-target="actividades">
                <i class="fa fa-list-check"></i> Actividades
            </button>
            <button class="edit-tab" data-target="anos">
                <i class="fa fa-calendar-days"></i> Años
            </button>
        </div>

        <form method="POST" action="#">
            @csrf

            {{-- ══ PANEL: Encabezado ══ --}}
            <div class="edit-panel active" id="panel-encabezado">
                <div class="act-section-title">
                    <i class="fa fa-heading"></i>
                    Encabezado de la página
                </div>
                <div class="act-row">
                    <div class="form-group">
                        <label for="titulo_seccion">Título principal <span class="req">*</span></label>
                        <input type="text" id="titulo_seccion" name="titulo_seccion"
                            value="{{ old('titulo_seccion', 'Actividades') }}"
                            placeholder="Ej: Actividades" required>
                        @error('titulo_seccion')<span class="field-error-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Año visible en página pública</label>
                        <div class="year-picker">
                            <button type="button" class="year-picker__btn" id="yearDown" aria-label="Año anterior">
                                <i class="fa fa-chevron-left"></i>
                            </button>
                            <div class="year-picker__display">
                                <span class="year-picker__value" id="yearDisplay">{{ old('anio_activo', date('Y')) }}</span>
                                <span class="year-picker__badge">página pública</span>
                            </div>
                            <button type="button" class="year-picker__btn" id="yearUp" aria-label="Año siguiente">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                            <input type="hidden" id="anio_activo" name="anio_activo" value="{{ old('anio_activo', date('Y')) }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subtitulo_seccion">Subtítulo</label>
                    <input type="text" id="subtitulo_seccion" name="subtitulo_seccion"
                        value="{{ old('subtitulo_seccion', 'Nuestras Actividades 2023') }}"
                        placeholder="Ej: Nuestras Actividades 2023">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-save"><i class="fa fa-floppy-disk"></i> Guardar Cambios</button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: Actividades ══ --}}
            <div class="edit-panel" id="panel-actividades">

                {{-- ── Filtro de año ── --}}
                <div class="act-year-filter">
                    <div class="act-year-filter__label">
                        <i class="fa fa-filter"></i>
                        Mostrando actividades del año
                    </div>
                    <div class="act-year-filter__controls">
                        <button type="button" class="year-filter-btn" id="filterYearDown" aria-label="Año anterior">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                        <div class="act-year-filter__display">
                            <span class="act-year-filter__value" id="filterYearDisplay">{{ date('Y') }}</span>
                        </div>
                        <button type="button" class="year-filter-btn" id="filterYearUp" aria-label="Año siguiente">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                        <input type="hidden" id="filter_anio" name="filter_anio" value="{{ date('Y') }}">
                    </div>
                    <span class="act-year-filter__hint">
                        <i class="fa fa-circle-info"></i>
                        Las tarjetas son las mismas para todos los años
                    </span>
                </div>

                <div class="act-section-title">
                    <span class="section-icon"><i class="fa fa-list-check"></i></span>
                    Tarjetas de actividades
                </div>
                <p class="act-section__desc">Cada tarjeta aparece en el grid de la página pública con ícono, título y descripción.</p>

                <div class="activities-list" id="activitiesList">

                    @php
                        $actividades = [
                            ['icono' => 'fa-tooth',       'titulo' => 'Jornada dental',           'descripcion' => 'Por segundo año consecutivo, se realizaron jornadas de servicios dentales con el apoyo de la Fundación Smile y Global Dental. Un equipo de 35 dentistas brindó servicios gratuitos, atendiendo a 159 pacientes de varios municipios.'],
                            ['icono' => 'fa-heart-pulse', 'titulo' => 'Jornada de salud',         'descripcion' => 'Realizamos 2 jornadas de salud en Hoctún con detección gratuita de niveles de azúcar, presión arterial, peso, talla, vista y orientación psicológica, beneficiando a 300 personas.'],
                            ['icono' => 'fa-chalkboard',  'titulo' => 'Talleres de capacitación', 'descripcion' => 'Con el apoyo de Mentors International, se realizaron cursos de administración básica para pequeños emprendedores en varios municipios, beneficiando a 150 personas.'],
                            ['icono' => 'fa-tree',        'titulo' => 'Reforestación',            'descripcion' => 'El Ayuntamiento de Mérida donó 1,666 plantas forestales y maderables a 11 localidades para reforestar predios de producción y traspatio.'],
                            ['icono' => 'fa-feather',     'titulo' => 'Cría de pavos de engorda', 'descripcion' => 'Como seguimiento al proyecto iniciado en 2022 con donativos de OXXO que benefició a 350 familias, en 2023 se pudo continuar con el programa de engorda de pavos de traspatio.'],
                            ['icono' => 'fa-droplet',     'titulo' => 'Entrega de tinacos',       'descripcion' => 'Gracias a la gestión de Ajal Lol y la aportación de Mariana Trinitaria, se llevaron programas de abastecimiento de agua a varias comunidades, beneficiando a más de 400 familias.'],
                        ];
                    @endphp

                    @foreach($actividades as $i => $act)
                    <div class="activity-card" id="act-{{ $i + 1 }}" data-collapsed="true">
                        <div class="activity-card__toggle" data-card="act-{{ $i + 1 }}">
                            <span class="act-card-num">{{ $i + 1 }}</span>
                            <span class="act-card-icon" id="icon-preview-{{ $i + 1 }}">
                                <i class="fa {{ $act['icono'] }}"></i>
                            </span>
                            <span class="act-card-summary">
                                <span class="act-card-summary__title" id="summary-title-{{ $i + 1 }}">{{ $act['titulo'] }}</span>
                                <span class="act-card-summary__sub" id="summary-icon-{{ $i + 1 }}">{{ $act['icono'] }}</span>
                            </span>
                            <span class="act-card-actions">
                                <span class="act-card-chevron"><i class="fa fa-chevron-down"></i></span>
                                <button type="button" class="btn-remove-act" data-act="{{ $i + 1 }}" title="Eliminar actividad">
                                    <i class="fa fa-xmark"></i>
                                </button>
                            </span>
                        </div>
                        <div class="act-card-divider"></div>
                        <div class="act-card-body">
                            <div class="act-fields-row">
                                <div class="form-group">
                                    <label>Ícono</label>
                                    <div class="icon-selector-wrap">
                                        <div class="icon-selector-trigger"
                                             data-target="act_icono_{{ $i + 1 }}"
                                             data-preview="icon-preview-{{ $i + 1 }}"
                                             data-summary-icon="summary-icon-{{ $i + 1 }}">
                                            <div class="icon-selector-trigger__preview" id="trigger-preview-{{ $i + 1 }}">
                                                <i class="fa {{ $act['icono'] }}"></i>
                                            </div>
                                            <div class="icon-selector-trigger__info">
                                                <span class="icon-selector-trigger__name" id="trigger-name-{{ $i + 1 }}">{{ \Illuminate\Support\Str::after($act['icono'], 'fa-') }}</span>
                                                <span class="icon-selector-trigger__class" id="trigger-class-{{ $i + 1 }}">{{ $act['icono'] }}</span>
                                            </div>
                                            <span class="icon-selector-trigger__arrow"><i class="fa fa-chevron-down"></i></span>
                                        </div>
                                        <input type="hidden"
                                            id="act_icono_{{ $i + 1 }}"
                                            name="act_icono_{{ $i + 1 }}"
                                            value="{{ old('act_icono_' . ($i+1), $act['icono']) }}"
                                            class="icon-hidden-input">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="act_titulo_{{ $i + 1 }}">Título</label>
                                    <input type="text"
                                        id="act_titulo_{{ $i + 1 }}"
                                        name="act_titulo_{{ $i + 1 }}"
                                        value="{{ old('act_titulo_' . ($i+1), $act['titulo']) }}"
                                        placeholder="Nombre de la actividad..."
                                        class="act-title-input"
                                        data-summary="summary-title-{{ $i + 1 }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="act_desc_{{ $i + 1 }}">Descripción</label>
                                <textarea id="act_desc_{{ $i + 1 }}" name="act_desc_{{ $i + 1 }}" rows="3"
                                    placeholder="Describe la actividad, beneficiarios, alcance...">{{ old('act_desc_' . ($i+1), $act['descripcion']) }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                <button type="button" class="btn-add-act" id="btnAddAct">
                    <i class="fa fa-plus"></i> Agregar actividad
                </button>

                <div class="form-actions">
                    <button type="submit" class="btn-save"><i class="fa fa-floppy-disk"></i> Guardar Cambios</button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: Años ══ --}}
            <div class="edit-panel" id="panel-anos">

                <div class="act-section-title">
                    <span class="section-icon"><i class="fa fa-calendar-days"></i></span>
                    Años registrados
                </div>
                <p class="act-section__desc">
                    Estos son los años que aparecen en el selector de la página pública. Puedes ocultarlos temporalmente o eliminarlos definitivamente.
                </p>

                {{-- ── Tabla de años ── --}}
                <div class="years-table-wrap">
                    <table class="years-table" id="yearsTable">
                        <thead>
                            <tr>
                                <th class="yt-col-year">Año</th>
                                <th class="yt-col-status">Estado</th>
                                <th class="yt-col-acts">Actividades</th>
                                <th class="yt-col-actions">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="yearsTableBody">

                            @php
                                $anos_registrados = [
                                    ['ano' => 2020, 'visible' => true,  'total_actividades' => 2],
                                    ['ano' => 2021, 'visible' => true,  'total_actividades' => 3],
                                    ['ano' => 2022, 'visible' => true,  'total_actividades' => 3],
                                    ['ano' => 2023, 'visible' => true,  'total_actividades' => 6],
                                    ['ano' => 2024, 'visible' => false, 'total_actividades' => 0],
                                    ['ano' => 2025, 'visible' => false, 'total_actividades' => 0],
                                ];
                            @endphp

                            @forelse($anos_registrados as $yr)
                            <tr class="year-row {{ !$yr['visible'] ? 'year-row--hidden' : '' }}"
                                data-year="{{ $yr['ano'] }}"
                                data-visible="{{ $yr['visible'] ? 'true' : 'false' }}">

                                {{-- Año --}}
                                <td class="yt-col-year">
                                    <div class="yt-year-badge">
                                        <i class="fa fa-calendar"></i>
                                        <span>{{ $yr['ano'] }}</span>
                                    </div>
                                </td>

                                {{-- Estado --}}
                                <td class="yt-col-status">
                                    @if($yr['visible'])
                                        <span class="yt-status yt-status--visible">
                                            <i class="fa fa-eye"></i> Visible
                                        </span>
                                    @else
                                        <span class="yt-status yt-status--hidden">
                                            <i class="fa fa-eye-slash"></i> Oculto
                                        </span>
                                    @endif
                                </td>

                                {{-- Nº actividades --}}
                                <td class="yt-col-acts">
                                    <span class="yt-acts-count {{ $yr['total_actividades'] === 0 ? 'yt-acts-count--empty' : '' }}">
                                        {{ $yr['total_actividades'] }}
                                        <span class="yt-acts-label">{{ $yr['total_actividades'] === 1 ? 'actividad' : 'actividades' }}</span>
                                    </span>
                                </td>

                                {{-- Acciones --}}
                                <td class="yt-col-actions">
                                    <div class="yt-actions">
                                        {{-- Toggle visible/oculto --}}
                                        <button type="button"
                                            class="yt-btn yt-btn--toggle"
                                            data-year="{{ $yr['ano'] }}"
                                            data-visible="{{ $yr['visible'] ? 'true' : 'false' }}"
                                            title="{{ $yr['visible'] ? 'Ocultar año' : 'Mostrar año' }}">
                                            <i class="fa {{ $yr['visible'] ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                            <span>{{ $yr['visible'] ? 'Ocultar' : 'Mostrar' }}</span>
                                        </button>

                                        {{-- Eliminar --}}
                                        <button type="button"
                                            class="yt-btn yt-btn--delete"
                                            data-year="{{ $yr['ano'] }}"
                                            data-acts="{{ $yr['total_actividades'] }}"
                                            title="Eliminar año {{ $yr['ano'] }}">
                                            <i class="fa fa-trash"></i>
                                            <span>Eliminar</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="yt-empty">
                                    <i class="fa fa-calendar-xmark"></i>
                                    <span>No hay años registrados.</span>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- ── Nota informativa ── --}}
                <div class="yt-info-note">
                    <i class="fa fa-circle-info"></i>
                    <p>
                        <strong>Ocultar</strong> un año lo quita del selector de la página pública pero conserva sus datos.<br>
                        <strong>Eliminar</strong> un año lo borra permanentemente junto con sus actividades asociadas.
                    </p>
                </div>

            </div>{{-- /panel-anos --}}

        </form>
    </div>
</div>

{{-- ── Modal confirmación eliminar año ── --}}
<div class="yr-confirm-overlay" id="yrConfirmOverlay" aria-hidden="true">
    <div class="yr-confirm-modal" role="dialog" aria-modal="true" aria-labelledby="yrConfirmTitle">
        <div class="yr-confirm-icon">
            <i class="fa fa-triangle-exclamation"></i>
        </div>
        <h3 class="yr-confirm-title" id="yrConfirmTitle">¿Eliminar año <span id="yrConfirmYear"></span>?</h3>
        <p class="yr-confirm-desc" id="yrConfirmDesc">
            Esta acción es permanente y no se puede deshacer.
        </p>
        <div class="yr-confirm-actions">
            <button type="button" class="btn-cancel" id="yrConfirmCancel">Cancelar</button>
            <button type="button" class="yt-btn--confirm-delete" id="yrConfirmDelete">
                <i class="fa fa-trash"></i> Sí, eliminar
            </button>
        </div>
    </div>
</div>

{{-- ── Icon Picker ── --}}
<div class="icon-picker" id="iconPicker" role="dialog" aria-modal="true">
    <div class="icon-picker__backdrop" id="iconPickerBackdrop"></div>
    <div class="icon-picker__panel">
        <div class="icon-picker__header">
            <span class="icon-picker__title"><i class="fa fa-icons"></i> Seleccionar ícono</span>
            <button type="button" class="icon-picker__close" id="iconPickerClose"><i class="fa fa-xmark"></i></button>
        </div>
        <div class="icon-picker__search-wrap">
            <i class="fa fa-magnifying-glass icon-picker__search-ico"></i>
            <input type="text" class="icon-picker__search" id="iconSearch" placeholder="Buscar ícono...">
        </div>
        <div class="icon-picker__categories" id="iconCategories"></div>
        <div class="icon-picker__grid" id="iconGrid"></div>
        <div class="icon-picker__empty" id="iconEmpty" style="display:none;">
            <i class="fa fa-face-frown-open"></i>
            <span>Sin resultados</span>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/editpage/activities_edit.js') }}"></script>
@endpush