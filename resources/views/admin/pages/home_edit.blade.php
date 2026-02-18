@extends('admin.dashboard')

@section('title', 'Editar Página - Inicio')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/home_edit.css') }}">
@endpush

@section('content')

<div class="edit-container">
    <h2>Editar Página Inicio</h2>
    <p class="subtitle">
        Modifica el contenido principal que se muestra en la página de inicio del sitio web.
    </p>

    <form method="POST" action="#">
        @csrf

        <div class="form-group">
            <label for="titulo_principal">Título Principal</label>
            <input 
                type="text" 
                id="titulo_principal"
                name="titulo_principal"
                value="Bienvenidos a Ajal Lol"
                required
            >
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea 
                id="descripcion"
                name="descripcion"
                rows="4"
            >Organización de asistencia social sin fines de lucro comprometida con el bienestar comunitario.</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Guardar Cambios</button>
            <button type="button" class="btn-cancel">Cancelar</button>
        </div>
    </form>
</div>

@endsection