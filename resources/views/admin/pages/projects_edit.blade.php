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
            Selecciona un año para gestionar sus imágenes y filtros. Los cambios se reflejan en el sitio público.
        </p>
    </div>

    {{-- BLOQUE 1: TÍTULO FIJO + SUBTÍTULO --}}
    <div class="section-block">
        <div class="section-block__header">
            <span class="section-block__icon"><i class="fa fa-pen-to-square"></i></span>
            <div>
                <div class="section-block__title">Encabezado de la página</div>
                <div class="section-block__sub">El título es fijo. Solo el subtítulo es editable.</div>
            </div>
        </div>

        <div class="title-preview-row">
            <div class="title-fixed-block">
                <span class="title-fixed-label">Título (fijo)</span>
                <span class="title-fixed-value">Proyectos</span>
                <span class="title-fixed-badge"><i class="fa fa-lock"></i> No editable</span>
            </div>
        </div>

        <form method="POST" action="#" class="texts-form">
            @csrf
            @method('PUT')
            <div class="form-group subtitle-group">
                <label for="subtitulo">Subtítulo visible</label>
                <div class="subtitle-input-wrap">
                    <input
                        type="text"
                        id="subtitulo"
                        name="subtitulo"
                        value="{{ old('subtitulo', $pageData->subtitulo ?? 'Nuestro trabajo año con año') }}"
                        placeholder="Ej: Nuestro trabajo año con año"
                    >
                    <button type="submit" class="btn-save btn-save--inline">
                        <i class="fa fa-floppy-disk"></i> Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- BLOQUE 2: SELECTOR DE AÑOS --}}
    <div class="section-block">
        <div class="section-block__header">
            <span class="section-block__icon"><i class="fa fa-calendar"></i></span>
            <div>
                <div class="section-block__title">Años registrados</div>
                <div class="section-block__sub">Selecciona un año para editar su contenido. Puedes agregar o eliminar años.</div>
            </div>
        </div>

        <div class="year-manager">
            <div class="year-tabs" id="yearTabs" role="tablist">
                @foreach($years as $y)
                    <div class="year-tab {{ $y == $activeYear ? 'active' : '' }}"
                         data-year="{{ $y }}" role="tab"
                         aria-selected="{{ $y == $activeYear ? 'true' : 'false' }}">
                        <span class="year-tab__label">{{ $y }}</span>
                        <button class="year-tab__del" type="button"
                                data-year="{{ $y }}" aria-label="Eliminar año {{ $y }}">
                            <i class="fa fa-xmark"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            <button class="btn-add-year" type="button" id="btnAddYear">
                <i class="fa fa-plus"></i> Agregar año
            </button>
        </div>

        <div class="add-year-form" id="addYearForm" style="display:none">
            <input type="number" id="newYearInput" placeholder="Ej: 2025"
                   min="2000" max="2099" class="new-year-input">
            <button type="button" class="btn-save btn-save--sm" id="btnConfirmYear">
                <i class="fa fa-check"></i> Confirmar
            </button>
            <button type="button" class="btn-cancel btn-cancel--sm" id="btnCancelYear">
                Cancelar
            </button>
        </div>
    </div>

    {{-- BLOQUE 3: CONTENIDO DEL AÑO ACTIVO --}}
    <div class="section-block" id="yearContentBlock">
        <div class="section-block__header">
            <span class="section-block__icon"><i class="fa fa-images"></i></span>
            <div>
                <div class="section-block__title">
                    Contenido del año
                    <span class="year-content-badge" id="yearContentBadge">{{ $activeYear }}</span>
                </div>
                <div class="section-block__sub">Gestiona las imágenes y categorías de este año.</div>
            </div>
        </div>

        {{-- Sub-tabs --}}
        <div class="content-tabs" role="tablist">
            <button class="content-tab active" data-tab="images" type="button">
                <i class="fa fa-images"></i> Imágenes
            </button>
            <button class="content-tab" data-tab="categories" type="button">
                <i class="fa fa-tags"></i> Categorías
            </button>
        </div>

        {{-- TAB: IMÁGENES --}}
        <div class="tab-panel active" id="tabImages">
            <div class="img-toolbar">
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
                         data-cat="{{ $img->category }}">
                        <div class="img-thumb">
                            @if($img->image_path)
                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                     alt="{{ $img->description }}" loading="lazy">
                            @else
                                <div class="thumb-placeholder"><i class="fa fa-image"></i></div>
                            @endif
                            <span class="cat-badge">{{ $img->category }}</span>
                            <span class="year-badge">{{ $img->year }}</span>
                            <div class="img-overlay">
                                <button class="overlay-details-btn" type="button" data-id="{{ $img->id }}">
                                    Detalles
                                </button>
                            </div>
                        </div>
                        <div class="img-body">
                            <p class="img-desc">{{ $img->description ?: 'Sin descripción.' }}</p>
                            <div class="img-actions">
                                <button class="btn-edit-img" type="button" data-id="{{ $img->id }}">Editar</button>
                                <button class="btn-del-img" type="button" data-id="{{ $img->id }}" data-url="#">Eliminar</button>
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
                    Categorías del año <strong id="catYearLabel">{{ $activeYear }}</strong>.
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
                    <input type="text" id="newCatInput" placeholder="Nueva categoría..." class="new-cat-input">
                    <button type="button" class="btn-save btn-save--sm" id="btnAddCat">
                        <i class="fa fa-plus"></i> Agregar
                    </button>
                </div>
            </div>
        </div>

    </div>{{-- /.section-block year-content --}}

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

                    <div class="img-panel-label">Año</div>
                    <div class="modal-year-display" id="modalYearDisplay">
                        <i class="fa fa-calendar-days"></i>
                        <span id="modalYearVal">{{ $activeYear }}</span>
                    </div>
                    <input type="hidden" id="selectedYear" name="year" value="{{ $activeYear }}">

                    <div class="form-group" style="margin-top:18px">
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
                                   placeholder="Busca el proyecto entrada...">
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