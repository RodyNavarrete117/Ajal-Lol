@extends('admin.dashboard')

@section('title', 'Editar Página - Donaciones')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/donations_edit.css') }}">
@endpush

@section('content')
<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- HEADER --}}
        <div class="edit-header">
            <div class="edit-header__bg">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <i class="fa-solid fa-donate"></i>
                <i class="fa-solid fa-coins"></i>
                <i class="fa-solid fa-heart"></i>
                <i class="fa-solid fa-circle-dollar-to-slot"></i>
                <i class="fa-solid fa-gift"></i>
            </div>

            <div class="edit-header-top">
                <a href="{{ route('admin.home') }}" class="edit-back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <div class="edit-header-text">
                    <h2>Editar Donaciones</h2>
                    <p class="subtitle">Configura cómo los usuarios pueden apoyar a la organización</p>
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <form method="POST" action="#">
            @csrf

            {{-- TÍTULO --}}
            <div class="form-group">
                <label>Título principal</label>
                <input type="text" name="title" placeholder="Ej: Apoya nuestra causa">
            </div>

            {{-- DESCRIPCIÓN --}}
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="description" placeholder="Explica cómo ayudan las donaciones..."></textarea>
            </div>

            {{-- CUENTA BANCARIA --}}
            <div class="form-group">
                <label>Nombre del beneficiario</label>
                <input type="text" name="beneficiary" placeholder="Ej: Ajal Lol A.C.">
            </div>

            <div class="form-group">
                <label>Banco</label>
                <input type="text" name="bank" placeholder="Ej: BBVA">
            </div>

            <div class="form-group">
                <label>Número de cuenta / CLABE</label>
                <input type="text" name="account" placeholder="Ej: 012345678901234567">
            </div>

            {{-- BOTÓN EXTERNO --}}
            <div class="form-group">
                <label>Link de donación (opcional)</label>
                <input type="url" name="donation_link" placeholder="https://paypal.me/...">
            </div>

            {{-- MENSAJE FINAL --}}
            <div class="form-group">
                <label>Mensaje de agradecimiento</label>
                <textarea name="thanks_message" placeholder="Gracias por apoyar nuestra causa..."></textarea>
            </div>

            {{-- ACCIONES --}}
            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar cambios
                </button>

                <a href="{{ route('admin.home') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i>
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

{{-- TOAST --}}
<div id="toast" class="edit-toast edit-toast--success">
    <i class="fa-solid fa-circle-check edit-toast__icon"></i>
    <span>Cambios guardados correctamente</span>
</div>
@endsection