@extends('admin.dashboard')

@section('title', 'Editar Página - Aliados / Patrocinadores')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/allies_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- ── Hero Header ── --}}
        <div class="edit-header">
            <div class="edit-header__bg">
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
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

        {{-- ── Form ── --}}
        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf

            {{-- Título de sección --}}
            <div class="form-group">
                <label for="titulo_aliados">Título de la sección</label>
                <input type="text" id="titulo_aliados" name="titulo_aliados"
                    value="{{ old('titulo_aliados', 'Nuestros Aliados') }}"
                    placeholder="Ej. Nuestros Aliados, Patrocinadores..." required>
                @error('titulo_aliados')
                    <span class="field-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Header de logos --}}
            <div class="logos-section-label">
                <span class="logos-label-text">Logos de aliados</span>
                <div class="logos-label-right">
                    <span class="logos-counter" id="logosCounter">6 / 18</span>
                    <span class="logos-label-hint">PNG, JPG, SVG · Máx. 2MB c/u</span>
                </div>
            </div>

            {{-- Barra de progreso --}}
            <div class="logos-progress-bar">
                <div class="logos-progress-fill" id="logosProgressFill" style="width: 33.33%"></div>
            </div>

            {{-- Grid de logos — 4 columnas --}}
            <div class="logos-grid" id="logosGrid">

                @for ($i = 1; $i <= 8; $i++)
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
                            Subir
                        </label>
                        <input type="file"
                            id="logo_{{ $i }}"
                            name="logo_{{ $i }}"
                            accept="image/png,image/jpeg,image/svg+xml,image/webp"
                            class="logo-input"
                            data-slot="{{ $i }}"
                            style="display:none;">
                        <button type="button" class="btn-clear" data-slot="{{ $i }}" title="Quitar imagen">
                            <i class="fa fa-xmark"></i>
                        </button>
                    </div>
                    <div class="logo-slot__name" id="name-{{ $i }}">Sin imagen</div>
                </div>
                @endfor

            </div>

            {{-- Botón agregar --}}
            <div class="logos-add-bar" id="logosAddBar">
                <button type="button" class="btn-add-logo" id="btnAddLogo">
                    <i class="fa fa-plus"></i>
                    Agregar logo
                </button>
                <span class="logos-max-hint" id="logosMaxHint">
                    Hasta <strong>18</strong> logos en total
                </span>
            </div>

            {{-- Form actions --}}
            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fa fa-floppy-disk"></i>
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
<script src="{{ asset('assets/js/editpage/allies_edit.js') }}"></script>
@endpush