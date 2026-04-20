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
            <div class="edit-header-top">
                <a href="{{ route('admin.home') }}" class="edit-back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <div>
                    <h2>Editar Donaciones</h2>
                    <p class="subtitle">Configura cómo los usuarios pueden apoyar a la organización</p>
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <form method="POST" action="#">
            @csrf

            <div class="accordion">

                {{-- ===== INFORMACIÓN GENERAL ===== --}}
                <div class="accordion-item active">
                    <div class="accordion-header">
                        <span class="accordion-title">Información general</span>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </div>

                    <div class="accordion-content">

                        <div class="form-group">
                            <label>Título principal</label>
                            <input type="text" name="title" placeholder="Ej: Apoya nuestra causa">
                        </div>

                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="description" placeholder="Explica cómo ayudan las donaciones..."></textarea>
                        </div>

                    </div>
                </div>

                {{-- ===== DATOS BANCARIOS ===== --}}
                <div class="accordion-item">
                    <div class="accordion-header">
                        <span class="accordion-title">Datos bancarios</span>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </div>

                    <div class="accordion-content">

                        <div class="bank-card">

                            <div class="bank-card-title">Cuenta bancaria</div>

                            <div class="form-group">
                                <label>Nombre del beneficiario</label>
                                <input type="text" name="beneficiary" placeholder="Ej: Ajal Lol A.C.">
                            </div>

                            <div class="form-group">
                                <label>Banco</label>
                                <input type="text" name="bank" placeholder="Ej: BBVA">
                            </div>

                            <div class="form-group">
                                <label>Cuenta / CLABE</label>
                                <input type="text" name="account" placeholder="012345678901234567">
                            </div>

                        </div>

                    </div>
                </div>

                {{-- ===== DONACIÓN EXTERNA ===== --}}
                <div class="accordion-item">
                    <div class="accordion-header">
                        <span class="accordion-title">Donación en línea</span>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </div>

                    <div class="accordion-content">

                        <div class="form-group">
                            <label>Link de donación</label>
                            <input type="url" name="donation_link" placeholder="https://paypal.me/...">
                        </div>

                    </div>
                </div>

                {{-- ===== MENSAJE FINAL ===== --}}
                <div class="accordion-item">
                    <div class="accordion-header">
                        <span class="accordion-title">Mensaje de agradecimiento</span>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </div>

                    <div class="accordion-content">

                        <div class="form-group">
                            <label>Mensaje</label>
                            <textarea name="thanks_message" placeholder="Gracias por apoyar nuestra causa..."></textarea>
                        </div>

                    </div>
                </div>

            </div>
            

            {{-- BOTONES --}}
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
<div id="toast" class="edit-toast">
    <i class="fa-solid fa-circle-check edit-toast__icon"></i>
    <span>Cambios guardados correctamente</span>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.accordion-header').forEach(header => {
    header.addEventListener('click', () => {
        const item = header.parentElement;
        item.classList.toggle('active');
    });
});
</script>
@endpush