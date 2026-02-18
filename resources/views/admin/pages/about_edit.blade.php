@extends('admin.dashboard')

@section('title', 'Editar Página - Nosotros')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/about_edit.css') }}">
@endpush

@section('content')

<div class="edit-container">
    <h2>Editar Página Nosotros</h2>
    <p class="subtitle">
        Desde aquí puedes actualizar la información institucional que se muestra en la página pública.
    </p>

    <form method="POST" action="#">
        @csrf

        <div class="form-group">
            <label for="historia">Historia</label>
            <textarea id="historia" name="historia" rows="5">
La organización fue fundada en el año 2000 por cinco mujeres comprometidas con el desarrollo social.
            </textarea>
        </div>

        <div class="form-group">
            <label for="mision">Misión</label>
            <textarea id="mision" name="mision" rows="5">
Brindar apoyo y asistencia a comunidades vulnerables mediante programas sociales.
            </textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Guardar Cambios</button>
            <button type="button" class="btn-cancel">Cancelar</button>
        </div>
    </form>
</div>

@endsection