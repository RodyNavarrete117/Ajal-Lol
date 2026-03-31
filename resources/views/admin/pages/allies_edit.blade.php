@extends('admin.dashboard')

@section('title', 'Editar Página - Aliados')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/allies_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- ── Header banner ───────────────────────────────────── --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-handshake"></i>
                </div>
                <h2>Editar Página Aliados</h2>
            </div>
            <p class="subtitle">
                Administra los logos y datos de las organizaciones aliadas que aparecen en el sitio público.
            </p>
        </div>

        {{-- ── Formulario ──────────────────────────────────────── --}}
        <div class="edit-form-body">
            <form method="POST" action="#" enctype="multipart/form-data" id="allies-form">
                @csrf

                {{-- Campo oculto: id_pagina (se llenará cuando se conecte la BD) --}}
                <input type="hidden" name="id_pagina" value="1">

                {{-- Sección: Textos de la sección --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa fa-pen-to-square"></i>
                        Textos de la sección
                    </div>

                    <div class="form-group">
                        <label for="titulo_seccion">Título</label>
                        <input
                            type="text"
                            id="titulo_seccion"
                            name="titulo_seccion"
                            value="Aliados"
                            placeholder="Ej: Aliados"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="subtitulo">Subtítulo destacado</label>
                        <input
                            type="text"
                            id="subtitulo"
                            name="subtitulo"
                            value="confían"
                            placeholder="Palabra en negrita dentro del subtítulo..."
                        >
                        <span class="field-hint">
                            Se mostrará como: «Organizaciones que <strong>confían</strong> en nosotros»
                        </span>
                    </div>
                </div>

                {{-- Sección: Logos de aliados --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa fa-images"></i>
                        Logos de aliados
                        <span class="ally-counter" id="ally-counter">0 registros</span>
                    </div>

                    {{-- Zona de arrastre --}}
                    <div class="dropzone" id="dropzone">
                        <div class="dropzone-inner">
                            <div class="dropzone-icon">
                                <i class="fa fa-cloud-arrow-up"></i>
                            </div>
                            <p class="dropzone-text">Arrastra los logos aquí</p>
                            <p class="dropzone-sub">o haz clic para seleccionar archivos</p>
                            <span class="dropzone-badge">PNG · JPG · SVG · WEBP</span>
                        </div>
                        <input
                            type="file"
                            id="ally-file-input"
                            name="img_aliados[]"
                            multiple
                            accept="image/png,image/jpeg,image/svg+xml,image/webp"
                            class="dropzone-input"
                        >
                    </div>

                    {{-- Grid de preview --}}
                    <div class="allies-grid" id="allies-grid">
                        {{--
                            Estructura que generará el JS por cada aliado:
                            Campos mapeados a la tabla `aliados`:
                            - img_aliados  → imagen del logo
                            - nombre       → nombre del aliado
                            - url          → sitio web
                            - activo       → toggle visible/oculto
                            - id_pagina    → oculto, heredado del form
                        --}}
                    </div>

                    <p class="allies-empty" id="allies-empty">
                        <i class="fa fa-image"></i>
                        Aún no hay aliados. Arrastra imágenes arriba para agregarlos.
                    </p>
                </div>

                {{-- Acciones --}}
                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fa fa-floppy-disk" style="margin-right:8px;"></i>
                        Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">
                        Cancelar
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/editpage/allies_edit.js') }}"></script>
@endpush