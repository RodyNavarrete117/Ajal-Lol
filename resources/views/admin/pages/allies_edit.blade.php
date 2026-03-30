@extends('admin.dashboard')

@section('title', 'Editar Página - Aliados')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/allies_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-handshake"></i>
                </div>
                <h2>Editar Página Aliados</h2>
            </div>
            <p class="subtitle">
                Administra las organizaciones e instituciones aliadas que se muestran en el sitio público.
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
                    value="Nuestros Aliados"
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
                    placeholder="Escribe una descripción sobre los aliados..."
                >Organizaciones e instituciones que colaboran con Ajal Lol en sus programas comunitarios.</textarea>
            </div>

            <div class="form-group">
                <label for="aliado_nombre_1">
                    Aliado 1 — Nombre
                </label>
                <input
                    type="text"
                    id="aliado_nombre_1"
                    name="aliado_nombre_1"
                    value=""
                    placeholder="Nombre de la organización aliada..."
                >
            </div>

            <div class="form-group">
                <label for="aliado_url_1">
                    Aliado 1 — Sitio web
                </label>
                <input
                    type="url"
                    id="aliado_url_1"
                    name="aliado_url_1"
                    value=""
                    placeholder="https://ejemplo.org"
                >
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