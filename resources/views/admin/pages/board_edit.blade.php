@extends('admin.dashboard')

@section('title', 'Editar Página - Directiva')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/board_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-shield-halved"></i>
                </div>
                <h2>Editar Página Directiva</h2>
            </div>
            <p class="subtitle">
                Actualiza los integrantes del consejo directivo de la organización con su cargo correspondiente.
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
                    value="Consejo Directivo"
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
                    placeholder="Escribe una descripción sobre la directiva..."
                >Integrantes del consejo directivo de la organización, con foto y cargo.</textarea>
            </div>

            <div class="form-group">
                <label for="miembro_nombre_1">
                    Miembro 1 — Nombre completo
                </label>
                <input
                    type="text"
                    id="miembro_nombre_1"
                    name="miembro_nombre_1"
                    value=""
                    placeholder="Nombre del integrante..."
                >
            </div>

            <div class="form-group">
                <label for="miembro_cargo_1">
                    Miembro 1 — Cargo
                </label>
                <input
                    type="text"
                    id="miembro_cargo_1"
                    name="miembro_cargo_1"
                    value=""
                    placeholder="Ej: Presidenta, Secretaria, Tesorera..."
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