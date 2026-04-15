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

        {{-- ── Mensajes flash para toast ── --}}
        @if(session('success'))
        <span id="flash-success" data-msg="{{ session('success') }}" style="display:none;"></span>
        @endif
        @if(session('error'))
        <span id="flash-error" data-msg="{{ session('error') }}" style="display:none;"></span>
        @endif

        {{--
            Tablas:
              aliados          → id_aliados, id_pagina(=3), titulo_seccion, descripcion
              aliados_imagenes → id_imagen, id_aliados(FK), img_path
            Variables del controller:
              $config    → registro de aliados (titulo, descripcion)
              $logos     → registros de aliados_imagenes
              $id_pagina → 3
        --}}
        <form method="POST"
              action="{{ route('admin.pages.allies.update') }}"
              enctype="multipart/form-data"
              id="allies-edit-form">
            @csrf
            @method('PUT')

            <input type="hidden" name="id_pagina" value="{{ $id_pagina }}">
            <input type="hidden" name="id_config" value="{{ $config->id_aliados ?? 0 }}">
            <input type="hidden" name="total_logos" id="totalLogos" value="{{ count($logos) }}">

            {{-- ── Título ── --}}
            <div class="form-group">
                <label for="titulo_aliados">Título de la sección</label>
                <input type="text"
                       id="titulo_aliados"
                       name="titulo_aliados"
                       value="{{ old('titulo_aliados', $config->titulo_seccion ?? '') }}"
                       placeholder="Aún no hay título en este momento...">
                @error('titulo_aliados')
                    <span class="field-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- ── Descripción ── --}}
            <div class="form-group">
                <label for="descripcion_aliados">Descripción</label>
                <textarea id="descripcion_aliados"
                          name="descripcion_aliados"
                          rows="3"
                          placeholder="Aún no hay descripción en este momento...">{{ old('descripcion_aliados', $config->descripcion ?? '') }}</textarea>
            </div>

            {{-- ── Header logos ── --}}
            <div class="logos-section-label">
                <span class="logos-label-text">Logos de aliados</span>
                <div class="logos-label-right">
                    <span class="logos-counter" id="logosCounter">{{ count($logos) }} / 18</span>
                    <span class="logos-label-hint">PNG, JPG, SVG · Máx. 2MB c/u</span>
                </div>
            </div>

            {{-- ── Barra de progreso ── --}}
            <div class="logos-progress-bar">
                <div class="logos-progress-fill"
                     id="logosProgressFill"
                     style="width: {{ count($logos) > 0 ? round((count($logos) / 18) * 100) : 0 }}%">
                </div>
            </div>

            {{-- ── Grid desde BD ── --}}
            <div class="logos-grid" id="logosGrid">

                @forelse($logos as $i => $logo)
                @php $n = $i + 1; @endphp
                <div class="logo-slot" id="slot-{{ $n }}" data-slot="{{ $n }}">

                    <input type="hidden"
                           name="id_logo_{{ $n }}"
                           class="logo-id-input"
                           value="{{ $logo->id_imagen }}">

                    <input type="hidden"
                           name="eliminar_logo_{{ $n }}"
                           id="eliminar_{{ $n }}"
                           value="0">

                    <div class="logo-slot__preview {{ $logo->img_path ? 'has-image' : '' }}"
                         id="preview-{{ $n }}">
                        @if($logo->img_path)
                            <img src="{{ asset('storage/' . $logo->img_path) }}"
                                 alt="Logo {{ $n }}">
                        @else
                            <div class="logo-slot__empty">
                                <i class="fa fa-image"></i>
                                <span>Logo {{ $n }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="logo-slot__actions">
                        <label class="btn-upload" for="logo_{{ $n }}">
                            <i class="fa fa-arrow-up-from-bracket"></i>
                            Subir
                        </label>
                        <input type="file"
                               id="logo_{{ $n }}"
                               name="logo_{{ $n }}"
                               accept="image/png,image/jpeg,image/svg+xml,image/webp"
                               class="logo-input"
                               data-slot="{{ $n }}"
                               style="display:none;">
                        <button type="button"
                                class="btn-clear"
                                data-slot="{{ $n }}"
                                data-has-image="{{ $logo->img_path ? '1' : '0' }}"
                                title="Quitar imagen">
                            <i class="fa fa-xmark"></i>
                        </button>
                    </div>

                    <div class="logo-slot__name {{ $logo->img_path ? 'has-file' : '' }}"
                         id="name-{{ $n }}">
                        {{ $logo->img_path ? basename($logo->img_path) : 'Sin imagen' }}
                    </div>

                </div>
                @empty

                {{-- Sin logos — 4 slots vacíos iniciales ── --}}
                @for ($i = 1; $i <= 4; $i++)
                <div class="logo-slot" id="slot-{{ $i }}" data-slot="{{ $i }}">
                    <input type="hidden" name="id_logo_{{ $i }}" class="logo-id-input" value="0">
                    <input type="hidden" name="eliminar_logo_{{ $i }}" id="eliminar_{{ $i }}" value="0">
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
                        <button type="button"
                                class="btn-clear"
                                data-slot="{{ $i }}"
                                data-has-image="0"
                                title="Quitar imagen">
                            <i class="fa fa-xmark"></i>
                        </button>
                    </div>
                    <div class="logo-slot__name" id="name-{{ $i }}">Sin imagen</div>
                </div>
                @endfor

                @endforelse

            </div>{{-- /logosGrid --}}

            {{-- ── Botón agregar ── --}}
            <div class="logos-add-bar" id="logosAddBar">
                <button type="button" class="btn-add-logo" id="btnAddLogo">
                    <i class="fa fa-plus"></i>
                    Agregar logo
                </button>
                <span class="logos-max-hint" id="logosMaxHint">
                    Hasta <strong>18</strong> logos en total
                </span>
            </div>

            {{-- ── Form actions ── --}}
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