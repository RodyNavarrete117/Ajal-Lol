@extends('admin.dashboard')

@section('title', 'Editar Página - Nosotros')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/about_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-building-columns"></i>
                </div>
                <h2>Editar Página Nosotros</h2>
            </div>
            <p class="subtitle">
                Desde aquí puedes actualizar la información institucional que se muestra en la página pública.
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="#">
            @csrf

            <div class="form-group">
                <label for="historia">
                    Historia
                </label>
                <textarea
                    id="historia"
                    name="historia"
                    rows="5"
                    placeholder="Escribe la historia de la organización..."
                >La organización fue fundada en el año 2000 por cinco mujeres comprometidas con el desarrollo social.</textarea>
            </div>

            <div class="form-group">
                <label for="mision">
                    Misión
                </label>
                <textarea
                    id="mision"
                    name="mision"
                    rows="5"
                    placeholder="Escribe la misión de la organización..."
                >Brindar apoyo y asistencia a comunidades vulnerables mediante programas sociales.</textarea>
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