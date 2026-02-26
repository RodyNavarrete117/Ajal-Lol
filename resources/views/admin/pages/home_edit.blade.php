@extends('admin.dashboard')

@section('title', 'Editar Página - Inicio')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/home_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-file-pen"></i>
                </div>
                <h2>Editar Página Inicio</h2>
            </div>
            <p class="subtitle">
                Modifica el contenido principal que se muestra en la página de inicio del sitio web.
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="#">
            @csrf

            <div class="form-group">
                <label for="titulo_principal">
                    Título Principal
                </label>
                <input
                    type="text"
                    id="titulo_principal"
                    name="titulo_principal"
                    value="Bienvenidos a Ajal Lol"
                    placeholder="Escribe el título principal..."
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
                    placeholder="Escribe una descripción..."
                >Organización de asistencia social sin fines de lucro comprometida con el bienestar comunitario.</textarea>
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