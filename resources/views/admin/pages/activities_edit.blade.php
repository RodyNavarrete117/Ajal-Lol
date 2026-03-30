@extends('admin.dashboard')

@section('title', 'Editar Página - Actividades')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/activities_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-calendar-days"></i>
                </div>
                <h2>Editar Página Actividades</h2>
            </div>
            <p class="subtitle">
                Actualiza el registro de actividades, talleres y eventos comunitarios que se muestran por año.
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
                    value="Actividades"
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
                    placeholder="Escribe una descripción general de las actividades..."
                >Registro de actividades realizadas por año. Talleres, jornadas y eventos comunitarios.</textarea>
            </div>

            <div class="form-group">
                <label for="anio_activo">
                    Año activo (visible por defecto)
                </label>
                <input
                    type="number"
                    id="anio_activo"
                    name="anio_activo"
                    value="2025"
                    min="2000"
                    max="2099"
                    placeholder="2025"
                >
            </div>

            <div class="form-group">
                <label for="actividad_destacada">
                    Actividad destacada
                </label>
                <textarea
                    id="actividad_destacada"
                    name="actividad_destacada"
                    rows="4"
                    placeholder="Describe la actividad principal o más reciente..."
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