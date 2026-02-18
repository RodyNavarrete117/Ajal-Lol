@extends('admin.dashboard')

@section('title', 'Editar Página - Contacto')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/contact_edit.css') }}">
@endpush

@section('content')

<div class="edit-container">
    <h2>Editar Página Contacto</h2>
    <p class="subtitle">
        Modifica la información de contacto que se mostrará en el sitio público.
    </p>

    <form method="POST" action="#">
        @csrf

        <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input 
                type="email" 
                id="correo" 
                name="correo" 
                value="contacto@ajallol.org"
                required
            >
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input 
                type="text" 
                id="telefono" 
                name="telefono" 
                value="+52 999 123 4567"
            >
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea 
                id="direccion" 
                name="direccion" 
                rows="4"
            >Calle Principal #123, Yucatán, México.</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Guardar Cambios</button>
            <button type="button" class="btn-cancel">Cancelar</button>
        </div>
    </form>
</div>

@endsection