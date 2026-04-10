@extends('admin.dashboard')

@section('title', 'Editor de Proyectos')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/projects_edit.css') }}">
@endpush

@section('content')
@php
    $years      = $years      ?? ['2023', '2024', '2025'];
    $categories = $categories ?? ['Jornadas dentales', 'Jornadas de salud', 'Proyectos productivos', 'Adulto Mayor'];
    $images     = $images     ?? collect([]);
    $pageData   = $pageData   ?? null;

    $yearsSorted    = collect($years)->sortDesc()->values()->toArray();
    $activeYear     = $activeYear ?? $yearsSorted[0] ?? '2025';
    $yearSubtitles  = $yearSubtitles  ?? [];
    $yearVisibility = $yearVisibility ?? collect($yearsSorted)->mapWithKeys(fn($y) => [$y => true])->toArray();
    $visCount       = collect($yearVisibility)->filter()->count();
@endphp

<div class="edit-page-wrapper">
<div class="edit-card">

    {{-- ══ HERO — título + selector de año en la misma banda ══ --}}
    <div class="edit-hero">
        <div class="edit-hero__deco edit-hero__deco--1"></div>
        <div class="edit-hero__deco edit-hero__deco--2"></div>

        <div class="edit-hero__inner">

            {{-- Izquierda: icono + texto --}}
            <div class="edit-hero__left">
                <div class="edit-hero__icon"><i class="fa fa-folder-open"></i></div>
                <div>
                    <h1 class="edit-hero__title">Editor de Proyectos</h1>
                    <p class="edit-hero__sub">Gestiona años, imágenes y visibilidad pública.</p>
                </div>
            </div>

            {{-- Derecha: selector de año (píldora unificada) --}}
            <div class="year-selector" id="yearSelector">

                {{-- PÍLDORA: [‹ | 2025 ↓ | ›] --}}
                <div class="year-pill">

                    <button class="year-pill-nav" id="btnPrevYear" type="button"
                            aria-label="Año anterior" title="Ir al año anterior">
                        <i class="fa fa-chevron-left"></i>
                    </button>

                    <div class="year-pill-sep"></div>

                    <div class="year-display-wrap" id="yearDisplayWrap">
                        <button class="year-display-btn" id="yearDisplayBtn"
                                type="button" aria-haspopup="listbox" aria-expanded="false">
                            <span class="year-display-num" id="yearDisplayNum">{{ $activeYear }}</span>
                            <span class="year-display-sub">AÑO ACTIVO</span>
                            <i class="fa fa-chevron-down year-display-arrow" id="yearDisplayArrow"></i>
                        </button>

                        <div class="year-dropdown" id="yearDropdown" role="listbox"
                             aria-label="Lista de años" style="display:none">
                            @foreach($yearsSorted as $y)
                            <div class="year-dropdown-item {{ $y == $activeYear ? 'active' : '' }}"
                                 data-year="{{ $y }}" role="option"
                                 aria-selected="{{ $y == $activeYear ? 'true' : 'false' }}">
                                <span class="ydi-num">{{ $y }}</span>
                                <span class="ydi-dot {{ ($yearVisibility[$y] ?? true) ? 'vis-on' : 'vis-off' }}"
                                      title="{{ ($yearVisibility[$y] ?? true) ? 'Visible' : 'Oculto' }}"></span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="year-pill-sep"></div>

                    <button class="year-pill-nav" id="btnNextYear" type="button"
                            aria-label="Año siguiente" title="Ir al año siguiente">
                        <i class="fa fa-chevron-right"></i>
                    </button>

                </div>{{-- /.year-pill --}}

                <button class="btn-add-year-icon" type="button" id="btnAddYear"
                        title="Agregar nuevo año" aria-label="Agregar año">
                    <i class="fa fa-plus"></i>
                </button>

            </div>{{-- /.year-selector --}}

            {{-- Dentro de .edit-hero__inner, después del .year-selector --}}
            <button type="button" class="btn-hero-save" id="btnGlobalSave" disabled>
                <i class="fa fa-floppy-disk" id="btnGlobalSaveIcon"></i>
                <span id="btnGlobalSaveLabel">Guardar</span>
            </button>
        </div>

        {{-- Formulario agregar año: select con años disponibles --}}
        <div class="add-year-inline" id="addYearForm" style="display:none">
            <i class="fa fa-calendar-plus add-year-inline__icon"></i>
            <span class="add-year-inline__label">Nuevo año:</span>
            <select id="newYearSelect" class="new-year-select">
                {{-- Opciones generadas por JS según años ya registrados --}}
            </select>
            <button type="button" class="btn-hero-sm btn-hero-sm--confirm" id="btnConfirmYear">
                <i class="fa fa-check"></i> Agregar
            </button>
            <button type="button" class="btn-hero-sm btn-hero-sm--cancel" id="btnCancelYear">
                Cancelar
            </button>
        </div>

    </div>

    {{-- ══ BANDA SUBTÍTULO (entre hero y contenido) ══ --}}
    <div class="subtitle-band" id="heroSubtitleBand">
        <span class="subtitle-band__label">
            <i class="fa fa-pen"></i> Subtítulo del 
            <span class="year-label-badge" id="subtitleYearBadge">{{ $activeYear }}</span>
        </span>
        <input
            type="text"
            id="subtituloInput"
            name="subtitulo"
            class="subtitle-band__input"
            value="{{ old('subtitulo', $yearSubtitles[$activeYear] ?? '') }}"
            placeholder="Ej: Año en el que se ayudó a mucha gente..."
            data-subtitles='@json($yearSubtitles)'
        >
    </div>

    {{-- ══ CONTENIDO ══ --}}
    <div class="edit-container">

        {{-- TABS: imágenes / categorías / configuración --}}
        <div class="content-tabs" role="tablist">
            <button class="content-tab active" data-tab="images" type="button">
                <i class="fa fa-images"></i> Imágenes
            </button>
            <button class="content-tab" data-tab="categories" type="button">
                <i class="fa fa-tags"></i> Categorías
            </button>
            <button class="content-tab" data-tab="settings" type="button">
                <i class="fa fa-sliders"></i> Configuración
            </button>
        </div>

        {{-- TAB: IMÁGENES --}}
        <div class="tab-panel active" id="tabImages">
            <div class="img-toolbar" id="imgToolbar">
                <div class="filter-wrap" id="catFilter" role="group" aria-label="Filtrar por categoría">
                    <button class="pill active" data-cat="todas" type="button">Todo</button>
                    @foreach($categories as $cat)
                        <button class="pill" data-cat="{{ $cat }}" type="button">{{ $cat }}</button>
                    @endforeach
                </div>
                <button class="btn-add-img" type="button" id="btnAddImage">
                    <i class="fa fa-plus"></i> Añadir imagen
                </button>
            </div>

            <div class="img-grid" id="imgGrid">
                @forelse($images as $img)
                    <div class="img-card"
                         data-id="{{ $img->id }}"
                         data-year="{{ $img->year }}"
                         data-cat="{{ $img->category }}"
                         data-date="{{ optional($img->event_date)?->format('Y-m-d') ?? '' }}"
                         style="{{ $img->year != $activeYear ? 'display:none' : '' }}">
                        <div class="img-thumb">
                            @if($img->image_path)
                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                     alt="{{ $img->description }}" loading="lazy">
                            @else
                                <div class="thumb-placeholder"><i class="fa fa-image"></i></div>
                            @endif
                            <span class="cat-badge">{{ $img->category }}</span>
                            <div class="img-overlay">
                                <button class="overlay-details-btn" type="button"
                                        data-id="{{ $img->id }}">Detalles</button>
                            </div>
                        </div>
                        <div class="img-body">
                            <p class="img-date">
                                <i class="fa fa-calendar-day"></i>
                                @if($img->event_date)
                                    @php
                                        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                                        $d = \Carbon\Carbon::parse($img->event_date);
                                    @endphp
                                    {{ $d->day }} de {{ $meses[$d->month - 1] }}
                                @else
                                    Sin fecha
                                @endif
                            </p>
                            <p class="img-desc">{{ $img->description ?: 'Sin descripción.' }}</p>
                            <div class="img-actions">
                                <button class="btn-edit-img" type="button"
                                        data-id="{{ $img->id }}">Editar</button>
                                <button class="btn-del-img" type="button"
                                        data-id="{{ $img->id }}" data-url="#">Eliminar</button>
                                <span class="img-id-tag">ID: {{ $img->id }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="img-empty" id="imgEmpty">
                        <i class="fa fa-folder-open"></i>
                        <p>No hay imágenes para este año. Añade la primera.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- TAB: CATEGORÍAS --}}
        <div class="tab-panel" id="tabCategories" style="display:none">
            <div class="cat-manager">
                <p class="cat-manager__hint">
                    Estas categorías son <strong>globales</strong> — se aplican a todos los años.
                    Añade o elimina según lo que necesites.
                </p>
                <div class="cat-list" id="catList">
                    @foreach($categories as $cat)
                        <div class="cat-item" data-cat="{{ $cat }}">
                            <span class="cat-item__dot"></span>
                            <span class="cat-item__name">{{ $cat }}</span>
                            <button class="cat-item__del" type="button" title="Eliminar categoría">
                                <i class="fa fa-xmark"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
                <div class="cat-add-row">
                    <input type="text" id="newCatInput" placeholder="Nueva categoría..."
                           class="new-cat-input">
                    <button type="button" class="btn-save btn-save--sm" id="btnAddCat">
                        <i class="fa fa-plus"></i> Agregar
                    </button>
                </div>
            </div>
        </div>

        {{-- TAB: CONFIGURACIÓN --}}
        <div class="tab-panel" id="tabSettings" style="display:none">
            <div class="settings-panel">

                {{-- Fila 1: Visibilidad --}}
                <div class="settings-card">
                    <div class="settings-card__icon settings-card__icon--vis">
                        <i class="fa fa-eye"></i>
                    </div>
                    <div class="settings-card__text">
                        <div class="settings-card__title">
                            Visible en el sitio
                            <div class="vis-counter" id="visCounter">
                                <span id="visCounterTxt">{{ $visCount }} / 5</span>
                                @if($visCount >= 5)<span class="vis-limit-badge">Límite</span>@endif
                            </div>
                        </div>
                        <div class="settings-card__sub">
                            Año <span class="year-label-badge" id="settingsYearBadge">{{ $activeYear }}</span>
                            — controla si aparece en la página pública.
                        </div>
                    </div>
                    <div class="settings-card__action">
                        <button class="vis-toggle {{ ($yearVisibility[$activeYear] ?? true) ? 'on' : '' }}"
                                id="visToggleBtn" type="button"
                                data-visibilities='@json($yearVisibility)'
                                aria-pressed="{{ ($yearVisibility[$activeYear] ?? true) ? 'true' : 'false' }}">
                            <span class="vis-track"><span class="vis-thumb"></span></span>
                        </button>
                        <span class="vis-status-txt" id="visStatusTxt">
                            {{ ($yearVisibility[$activeYear] ?? true) ? 'Activo' : 'Oculto' }}
                        </span>
                    </div>
                </div>

                {{-- Fila 2: Eliminar año --}}
                <div class="settings-card settings-card--danger">
                    <div class="settings-card__icon settings-card__icon--danger">
                        <i class="fa fa-trash-can"></i>
                    </div>
                    <div class="settings-card__text">
                        <div class="settings-card__title settings-card__title--danger">Eliminar año</div>
                        <div class="settings-card__sub">
                            Borra el año <span class="year-label-badge settings-card__year-badge--danger" id="settingsYearBadgeDanger">{{ $activeYear }}</span>
                            y todas sus imágenes. Acción irreversible.
                        </div>
                    </div>
                    <div class="settings-card__action">
                        <button class="btn-del-year-settings" type="button" id="btnDelYear"
                                data-year="{{ $activeYear }}">
                            <i class="fa fa-trash-can"></i> Eliminar
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>{{-- /.edit-container --}}
</div>{{-- /.edit-card --}}

</div>{{-- /.edit-page-wrapper --}}

{{-- MODAL — Añadir / Editar imagen --}}
<div class="img-modal-bg" id="imgModalBg" role="dialog" aria-modal="true" aria-labelledby="imgModalTitle">
    <div class="img-modal" id="imgModal">

        <div class="img-modal__header">
            <div class="img-modal__title-area">
                <div class="edit-icon"><i class="fa fa-folder-open"></i></div>
                <div>
                    <div class="img-modal__title" id="imgModalTitle">Añadir Imagen del Proyecto</div>
                    <div class="img-modal__sub" id="imgModalSub">Completa los datos de la nueva imagen</div>
                </div>
            </div>
            <button class="img-modal__close" id="imgModalClose" type="button" aria-label="Cerrar">✕</button>
        </div>

        <form method="POST" id="imgModalForm" enctype="multipart/form-data" action="#">
            @csrf
            <span id="methodField"></span>
            <input type="hidden" id="selectedYear" name="year" value="{{ $activeYear }}">

            {{-- Grid 2 columnas:
                 Col izq: upload (arriba) + fecha (abajo)
                 Col der: descripción (arriba) + categoría (abajo) --}}
            <div class="img-modal__body">

                {{-- COLUMNA IZQUIERDA --}}
                <div class="img-modal__panel">
                    <div class="img-panel-label">Selección de imagen</div>
                    <div class="upload-zone" id="uploadZone" role="button" tabindex="0">
                        <div class="upload-zone__inner" id="uploadInner">
                            <span class="upload-icon"><i class="fa fa-cloud-arrow-up"></i></span>
                            <span class="upload-text">Haz clic o arrastra una imagen</span>
                            <span class="upload-sub">PNG, JPG — máx. 5 MB</span>
                        </div>
                        <input type="file" id="imgFile" name="image"
                               accept="image/png,image/jpeg,image/webp" style="display:none">
                        <img id="uploadPreview" src="" alt="Vista previa" style="display:none">
                    </div>
                    <button class="btn-change-img" type="button" id="btnChangeImg">
                        <i class="fa fa-arrow-rotate-left"></i> Cambiar imagen
                    </button>

                    <div class="form-group date-picker-group" style="margin-top:16px">
                        <label>
                            Fecha
                            <span class="optional-tag">(por defecto: hoy)</span>
                        </label>
                        {{-- Input nativo oculto — maneja el valor ISO y las restricciones de fecha --}}
                        <input type="date" id="eventDateInput" name="event_date"
                               required style="position:absolute;opacity:0;pointer-events:none;width:0;height:0">
                        {{-- Botón visible que muestra la fecha en español --}}
                        <button type="button" class="date-picker-btn" id="datePickerBtn">
                            <i class="fa fa-calendar-day"></i>
                            <span id="datePickerLabel">Selecciona una fecha</span>
                            <i class="fa fa-chevron-down date-picker-arrow"></i>
                        </button>
                    </div>
                </div>

                {{-- COLUMNA DERECHA --}}
                <div class="img-modal__panel">
                    <div class="form-group img-modal__desc-group">
                        <label for="imgDescInput">Descripción de la imagen</label>
                        <textarea id="imgDescInput" name="description"
                                  class="img-modal__textarea-tall"
                                  placeholder="Describe brevemente esta imagen..." required></textarea>
                    </div>

                    <div class="form-group" style="margin-top:16px">
                        <label for="catInput">Categoría</label>
                        <select id="catInput" name="category" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>{{-- /.img-modal__body --}}

            <div class="img-modal__footer">
                <button type="button" class="btn-cancel" id="imgModalCancel">Cancelar</button>
                <button type="submit" class="btn-save" id="btnModalSubmit">
                    <i class="fa fa-arrow-right"></i>
                    <span id="modalSubmitLabel">Continuar</span>
                </button>
            </div>
        </form>
    </div>
</div>

    {{-- MODAL — Confirmar eliminación de año --}}
<div class="confirm-modal-bg" id="confirmDelBg" role="dialog" aria-modal="true" aria-labelledby="confirmDelTitle">
    <div class="confirm-modal" id="confirmDelModal">
        <div class="confirm-modal__deco confirm-modal__deco--1"></div>
        <div class="confirm-modal__deco confirm-modal__deco--2"></div>

        <div class="confirm-modal__icon-wrap">
            <div class="confirm-modal__icon">
                <i class="fa fa-trash-can"></i>
            </div>
        </div>

        <h2 class="confirm-modal__title" id="confirmDelTitle">¿Eliminar este año?</h2>
        <p class="confirm-modal__year-display" id="confirmDelYear">2025</p>
        <p class="confirm-modal__desc">
            Esta acción eliminará el año y <strong>todas sus imágenes</strong> de forma permanente.
            No podrás recuperar esta información.
        </p>

        <div class="confirm-modal__actions">
            <button class="btn-confirm-cancel" type="button" id="btnConfirmDelCancel">
                Cancelar
            </button>
            <button class="btn-confirm-delete" type="button" id="btnConfirmDelOk">
                <i class="fa fa-trash-can"></i> Sí, eliminar
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/editpage/project_edit.js') }}"></script>
@endpush