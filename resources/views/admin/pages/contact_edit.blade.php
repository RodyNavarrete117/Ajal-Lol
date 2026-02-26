@extends('admin.dashboard')

@section('title', 'Editar Página - Contacto')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/contact_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-address-card"></i>
                </div>
                <h2>Editar Página Contacto</h2>
            </div>
            <p class="subtitle">
                Modifica la información de contacto que se mostrará en el sitio público.
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="#">
            @csrf

            <div class="form-group">
                <label for="correo">
                    Correo Electrónico
                </label>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    value="contacto@ajallol.org"
                    placeholder="correo@ejemplo.com"
                    required
                >
            </div>

            <div class="form-group">
                <label for="telefono">
                    Teléfono
                </label>
                <input
                    type="text"
                    id="telefono"
                    name="telefono"
                    value="+52 999 123 4567"
                    placeholder="+52 000 000 0000"
                >
            </div>

            <div class="form-group">
                <label for="direccion">
                    Dirección
                </label>
                <textarea
                    id="direccion"
                    name="direccion"
                    rows="4"
                    placeholder="Calle, número, ciudad, estado..."
                >Calle Principal #123, Yucatán, México.</textarea>
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