@extends('admin.dashboard')

@section('title', 'Editar Página - Proyectos')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/projects_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-folder-open"></i>
                </div>
                <h2>Editar Página Proyectos</h2>
            </div>
            <p class="subtitle">
                Modifica los proyectos sociales clasificados por categoría y año que se muestran en el sitio público.
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="#">
            @csrf

            <div class="form-group">
                <label for="titulo_seccion">
                    Título de la sección
                </label>
                <input
                    type="text"
                    id="titulo_seccion"
                    name="titulo_seccion"
                    value="Proyectos"
                    placeholder="Escribe el título de la sección..."
                    required
                >
            </div>

            <div class="form-group">
                <label for="descripcion">
                    Descripción
                </label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="4"
                    placeholder="Escribe una descripción general de los proyectos..."
                >Proyectos sociales clasificados por categoría y año. Alimentación, educación, salud y más.</textarea>
            </div>

            <div class="form-group">
                <label for="categorias">
                    Categorías disponibles
                </label>
                <input
                    type="text"
                    id="categorias"
                    name="categorias"
                    value="Alimentación, Educación, Salud"
                    placeholder="Ej: Alimentación, Educación, Salud..."
                >
            </div>

            <div class="form-group">
                <label for="proyecto_destacado">
                    Proyecto destacado
                </label>
                <textarea
                    id="proyecto_destacado"
                    name="proyecto_destacado"
                    rows="4"
                    placeholder="Describe el proyecto principal o más relevante..."
                ></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fa fa-floppy-disk" style="margin-right:7px;"></i>
                    Guardar Cambios
                </button>
                <button type="button" class="btn-cancel"
                    onclick="window.history.back()">
                    Cancelar
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/editpage/projects_edit.js') }}"></script>
@endpush