@extends('admin.dashboard')

@section('title', 'Editar Página - Aliados / Patrocinadores')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap">
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/aliados_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-handshake"></i>
                </div>
                <h2>Editar Sección de Aliados</h2>
            </div>
            <p class="subtitle">
                Administra los logos de organizaciones aliadas y patrocinadores que se muestran en el sitio.
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf

            {{-- Título de sección --}}
            <div class="form-group">
                <label for="titulo_aliados">Título de la sección</label>
                <input
                    type="text"
                    id="titulo_aliados"
                    name="titulo_aliados"
                    value="{{ old('titulo_aliados', 'Nuestros Aliados') }}"
                    placeholder="Ej. Nuestros Aliados, Patrocinadores..."
                    required
                >
                @error('titulo_aliados')
                    <span class="field-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Grid de logos --}}
            <div class="logos-section-label">
                <span class="logos-label-text">Logos (6 espacios)</span>
                <span class="logos-label-hint">Formatos: PNG, JPG, SVG · Máx. 2MB por imagen</span>
            </div>

            <div class="logos-grid">

                @for ($i = 1; $i <= 6; $i++)
                <div class="logo-slot" id="slot-{{ $i }}">
                    <div class="logo-slot__preview" id="preview-{{ $i }}">
                        <div class="logo-slot__empty">
                            <i class="fa fa-image"></i>
                            <span>Logo {{ $i }}</span>
                        </div>
                    </div>
                    <div class="logo-slot__actions">
                        <label class="btn-upload" for="logo_{{ $i }}">
                            <i class="fa fa-arrow-up-from-bracket"></i>
                            Subir imagen
                        </label>
                        <input
                            type="file"
                            id="logo_{{ $i }}"
                            name="logo_{{ $i }}"
                            accept="image/png,image/jpeg,image/svg+xml,image/webp"
                            class="logo-input"
                            data-slot="{{ $i }}"
                            style="display:none;"
                        >
                        <button type="button" class="btn-clear" data-slot="{{ $i }}" title="Quitar imagen">
                            <i class="fa fa-xmark"></i>
                        </button>
                    </div>
                    <div class="logo-slot__name" id="name-{{ $i }}">Sin imagen</div>
                </div>
                @endfor

            </div>

            {{-- Form actions --}}
            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fa fa-floppy-disk" style="margin-right:7px;"></i>
                    Guardar Cambios
                </button>
                <button type="button" class="btn-cancel" onclick="window.history.back()">
                    Cancelar
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/editpage/aliados_edit.js') }}"></script>
@endpush