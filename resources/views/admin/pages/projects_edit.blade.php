@extends('admin.dashboard')

@section('title', 'Editar Página - Proyectos')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/projects_edit.css') }}">
@endpush

@section('content')
@php
    $years      = $years      ?? ['2023', '2024', '2025'];
    $categories = $categories ?? ['Jornadas dentales', 'Jornadas de salud', 'Proyectos productivos', 'Adulto Mayor'];
    $images     = $images     ?? collect([]);
    $pageData   = $pageData   ?? null;
    $activeYear = $activeYear ?? $years[0] ?? '2023';

    // Subtítulos por año — en producción vendría de BD
    $yearSubtitles = $yearSubtitles ?? [];
@endphp

<div class="edit-page-wrapper">
<div class="edit-container">

    {{-- HEADER --}}
    <div class="edit-header">
        <div class="edit-header-top">
            <div class="edit-icon"><i class="fa fa-folder-open"></i></div>
            <h2>Administración de Contenido de Proyectos</h2>
        </div>
        <p class="subtitle">
            Cada año es una sección independiente con su propio subtítulo e imágenes. Los cambios se reflejan en el sitio público.
        </p>
    </div>

    {{-- BLOQUE: AÑOS COMO SECCIONES ACORDEÓN --}}
    <div class="section-block" id="yearsBlock">
        <div class="section-block__header">
            <span class="section-block__icon"><i class="fa fa-calendar"></i></span>
            <div>
                <div class="section-block__title">Años y su contenido</div>
                <div class="section-block__sub">Cada año tiene su subtítulo, categorías e imágenes. Expande para editar.</div>
            </div>
        </div>

        {{-- ACORDEONES POR AÑO --}}
        <div class="year-accordion-list" id="yearAccordionList">
            @foreach($years as $y)
            @php
                $yImages = $images->where('year', $y);
                $ySub    = $yearSubtitles[$y] ?? '';
            @endphp
            <div class="year-accordion {{ $y == $activeYear ? 'open' : '' }}" data-year="{{ $y }}" id="acc-{{ $y }}">

                {{-- Cabecera del acordeón --}}
                <div class="year-accordion__head" role="button" tabindex="0" aria-expanded="{{ $y == $activeYear ? 'true' : 'false' }}">
                    <div class="year-accordion__left">
                        <span class="year-accordion__num">{{ $y }}</span>
                        <span class="year-accordion__preview-sub" id="previewSub-{{ $y }}">
                            {{ $ySub ?: 'Sin subtítulo — haz clic para editar' }}
                        </span>
                    </div>
                    <div class="year-accordion__right">
                        <span class="year-img-count">{{ $yImages->count() }} img.</span>
                        <button class="year-del-btn" type="button" data-year="{{ $y }}" title="Eliminar año {{ $y }}">
                            <i class="fa fa-trash-can"></i>
                        </button>
                        <span class="year-chevron"><i class="fa fa-chevron-down"></i></span>
                    </div>
                </div>

                {{-- Cuerpo del acordeón --}}
                <div class="year-accordion__body">

                    {{-- Subtítulo del año --}}
                    <div class="year-subtitle-form-wrap">
                        <form method="POST" action="#" class="year-subtitle-form" data-year="{{ $y }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="year" value="{{ $y }}">
                            <div class="form-group subtitle-group">
                                <label for="subtitulo-{{ $y }}">Subtítulo del año {{ $y }}</label>
                                <div class="subtitle-input-wrap">
                                    <input
                                        type="text"
                                        id="subtitulo-{{ $y }}"
                                        name="subtitulo"
                                        value="{{ old('subtitulo', $ySub) }}"
                                        placeholder="Ej: Año en el que se ayudó a mucha gente..."
                                        data-year="{{ $y }}"
                                        class="year-subtitle-input"
                                    >
                                    <button type="submit" class="btn-save btn-save--inline">
                                        <i class="fa fa-floppy-disk"></i> Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Sub-tabs imágenes / categorías --}}
                    <div class="content-tabs" role="tablist" data-year="{{ $y }}">
                        <button class="content-tab active" data-tab="images" data-year="{{ $y }}" type="button">
                            <i class="fa fa-images"></i> Imágenes
                        </button>
                        <button class="content-tab" data-tab="categories" data-year="{{ $y }}" type="button">
                            <i class="fa fa-tags"></i> Categorías
                        </button>
                    </div>

                    {{-- TAB: IMÁGENES --}}
                    <div class="tab-panel active" id="tabImages-{{ $y }}" data-year="{{ $y }}">
                        <div class="img-toolbar">
                            <div class="filter-wrap" id="catFilter-{{ $y }}" role="group" aria-label="Filtrar por categoría">
                                <button class="pill active" data-cat="todas" type="button">Todo</button>
                                @foreach($categories as $cat)
                                    <button class="pill" data-cat="{{ $cat }}" type="button">{{ $cat }}</button>
                                @endforeach
                            </div>
                            <button class="btn-add-img" type="button" data-year="{{ $y }}">
                                <i class="fa fa-plus"></i> Añadir imagen
                            </button>
                        </div>

                        <div class="img-grid" id="imgGrid-{{ $y }}">
                            @forelse($yImages as $img)
                                <div class="img-card"
                                     data-id="{{ $img->id }}"
                                     data-year="{{ $img->year }}"
                                     data-cat="{{ $img->category }}">
                                    <div class="img-thumb">
                                        @if($img->image_path)
                                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                                 alt="{{ $img->description }}" loading="lazy">
                                        @else
                                            <div class="thumb-placeholder"><i class="fa fa-image"></i></div>
                                        @endif
                                        <span class="cat-badge">{{ $img->category }}</span>
                                        <div class="img-overlay">
                                            <button class="overlay-details-btn" type="button" data-id="{{ $img->id }}">
                                                Detalles
                                            </button>
                                        </div>
                                    </div>
                                    <div class="img-body">
                                        <p class="img-date">
                                            <i class="fa fa-calendar-day"></i>
                                            {{ optional($img->event_date)->format('d/m/Y') ?? 'Sin fecha' }}
                                        </p>
                                        <p class="img-desc">{{ $img->description ?: 'Sin descripción.' }}</p>
                                        <div class="img-actions">
                                            <button class="btn-edit-img" type="button" data-id="{{ $img->id }}">Editar</button>
                                            <button class="btn-del-img" type="button" data-id="{{ $img->id }}" data-url="#">Eliminar</button>
                                            <span class="img-id-tag">ID: {{ $img->id }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="img-empty" id="imgEmpty-{{ $y }}">
                                    <i class="fa fa-folder-open"></i>
                                    <p>No hay imágenes para {{ $y }}. Añade la primera.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- TAB: CATEGORÍAS --}}
                    <div class="tab-panel" id="tabCategories-{{ $y }}" data-year="{{ $y }}" style="display:none">
                        <div class="cat-manager">
                            <p class="cat-manager__hint">
                                Categorías del año <strong>{{ $y }}</strong>. Añade o elimina según lo necesites.
                            </p>
                            <div class="cat-list" id="catList-{{ $y }}">
                                @foreach($categories as $cat)
                                    <div class="cat-item" data-cat="{{ $cat }}" data-year="{{ $y }}">
                                        <span class="cat-item__dot"></span>
                                        <span class="cat-item__name">{{ $cat }}</span>
                                        <button class="cat-item__del" type="button" title="Eliminar categoría">
                                            <i class="fa fa-xmark"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <div class="cat-add-row">
                                <input type="text" id="newCatInput-{{ $y }}" placeholder="Nueva categoría..." class="new-cat-input" data-year="{{ $y }}">
                                <button type="button" class="btn-save btn-save--sm btn-add-cat" data-year="{{ $y }}">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                    </div>

                </div>{{-- /.year-accordion__body --}}
            </div>{{-- /.year-accordion --}}
            @endforeach
        </div>{{-- /#yearAccordionList --}}

        {{-- Agregar nuevo año --}}
        <div class="add-year-bar">
            <button class="btn-add-year" type="button" id="btnAddYear">
                <i class="fa fa-plus"></i> Agregar año
            </button>
            <div class="add-year-form" id="addYearForm" style="display:none">
                <input type="number" id="newYearInput" placeholder="Ej: 2026"
                       min="2000" max="2099" class="new-year-input">
                <button type="button" class="btn-save btn-save--sm" id="btnConfirmYear">
                    <i class="fa fa-check"></i> Confirmar
                </button>
                <button type="button" class="btn-cancel btn-cancel--sm" id="btnCancelYear">
                    Cancelar
                </button>
            </div>
        </div>

    </div>{{-- /.section-block --}}

</div>{{-- /.edit-container --}}
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

            <div class="img-modal__body">

                {{-- Panel izquierdo --}}
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
                    <div class="form-group" style="margin-top:14px">
                        <label for="imgDescInput">Descripción de la imagen</label>
                        <textarea id="imgDescInput" name="description" rows="4"
                                  placeholder="Describe brevemente esta imagen..." required></textarea>
                    </div>
                </div>

                {{-- Panel derecho --}}
                <div class="img-modal__panel">

                    {{-- Fecha del evento (reemplaza al año en el modal) --}}
                    <div class="form-group">
                        <label for="eventDateInput">
                            Fecha
                            <span class="optional-tag">(por defecto: hoy)</span>
                        </label>
                        <input type="date" id="eventDateInput" name="event_date" required>
                    </div>

                    <div class="form-group" style="margin-top:6px">
                        <label for="catInput">Categoría</label>
                        <select id="catInput" name="category" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="img-panel-label" style="margin-top:18px">¿Proyecto destacado?</div>
                    <label class="check-row" id="featuredRow">
                        <span class="custom-check" id="featuredCheck"
                              role="checkbox" aria-checked="false" tabindex="0"></span>
                        <span class="check-label">Marcar como proyecto destacado</span>
                    </label>
                    <input type="hidden" id="featuredVal" name="featured" value="0">

                    <div class="form-group" style="margin-top:18px">
                        <label for="projSearch">
                            Proyecto asociado
                            <span class="optional-tag">(opcional)</span>
                        </label>
                        <div class="search-wrap">
                            <i class="fa fa-magnifying-glass search-prefix-icon"></i>
                            <input type="text" id="projSearch" name="related_project"
                                   placeholder="Busca el proyecto...">
                        </div>
                    </div>
                </div>

            </div>{{-- /.img-modal__body --}}

            <div class="img-modal__footer">
                <button type="submit" class="btn-save">
                    <i class="fa fa-floppy-disk"></i> Guardar Cambios
                </button>
                <button type="button" class="btn-cancel" id="imgModalCancel">Cancelar</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/editpage/project_edit.js') }}"></script>
@endpush