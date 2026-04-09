@extends('admin.dashboard')

@section('title', 'Editar Página - Directiva')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap">
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/board_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-shield-halved"></i>
                </div>
                <h2>Editar Página Directiva</h2>
            </div>
            <p class="subtitle">
                Actualiza los integrantes del consejo directivo con su foto, nombre completo y cargo correspondiente.
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf

            {{-- Campos generales --}}
            <div class="general-fields">
                <div class="form-group">
                    <label for="titulo_seccion">Título de la sección</label>
                    <input type="text" id="titulo_seccion" name="titulo_seccion"
                           value="{{ old('titulo_seccion', 'Directiva') }}"
                           placeholder="Escribe el título de la sección..." required>
                    @error('titulo_seccion')
                        <span class="field-error-msg">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="subtitulo">Subtítulo</label>
                    <input type="text" id="subtitulo" name="subtitulo"
                           value="{{ old('subtitulo', 'Comité Directivo') }}"
                           placeholder="Ej: Comité Directivo...">
                </div>
            </div>

            {{-- Divisor --}}
            <div class="members-label">
                <span class="members-label-text">
                    <i class="fa fa-users"></i>
                    Miembros del consejo
                </span>
                <span class="members-label-hint">Foto · Nombre · Cargo</span>
            </div>

            {{-- Grid de miembros --}}
            <div class="members-grid" id="membersGrid">
                @for ($i = 1; $i <= 3; $i++)
                <div class="member-card" id="member-{{ $i }}">

                    {{-- Head --}}
                    <div class="member-card__head" data-member="{{ $i }}">
                        <div class="member-card__num">{{ $i }}</div>
                        <div class="member-card__thumb" id="thumb-{{ $i }}">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="member-card__head-info">
                            <div class="member-card__head-name" id="head-name-{{ $i }}">
                                <span class="member-card__head-empty">Sin nombre</span>
                            </div>
                            <div class="member-card__head-cargo" id="head-cargo-{{ $i }}">
                                <span style="color:var(--text-placeholder);font-style:italic">Sin cargo</span>
                            </div>
                        </div>
                        <div class="member-card__head-actions">
                            <button type="button" class="member-card__chevron" title="Expandir / contraer">
                                <i class="fa fa-chevron-down"></i>
                            </button>
                            <button type="button" class="btn-remove-member" data-member="{{ $i }}" title="Quitar miembro">
                                <i class="fa fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="member-card__body">

                        {{-- Columna izquierda: foto --}}
                        <div class="member-photo-col">
                            <div class="member-photo" id="photo-preview-{{ $i }}">
                                <div class="member-photo__empty">
                                    <i class="fa fa-user"></i>
                                    <span>Subir foto</span>
                                </div>
                            </div>
                            <div class="member-photo-actions">
                                <label class="btn-photo-upload" for="foto_{{ $i }}">
                                    <i class="fa fa-camera"></i>
                                    Subir foto
                                </label>
                                <button type="button" class="btn-photo-clear" data-member="{{ $i }}">
                                    <i class="fa fa-xmark"></i>
                                    Quitar
                                </button>
                                <input type="file" id="foto_{{ $i }}"
                                       name="foto_{{ $i }}"
                                       accept="image/png,image/jpeg,image/webp"
                                       class="photo-input" data-member="{{ $i }}"
                                       style="display:none;">
                            </div>
                        </div>

                        {{-- Columna derecha: campos --}}
                        <div class="member-fields-col">
                            <div class="member-fields">
                                <div class="form-group">
                                    <label for="miembro_nombre_{{ $i }}">Nombre completo</label>
                                    <input type="text" id="miembro_nombre_{{ $i }}"
                                           name="miembro_nombre_{{ $i }}"
                                           value="{{ old('miembro_nombre_' . $i) }}"
                                           placeholder="Ej: Ing. Paula Guadalupe Pech Puc"
                                           class="nombre-input" data-member="{{ $i }}">
                                </div>
                                <div class="form-group">
                                    <label for="miembro_cargo_{{ $i }}">Cargo</label>
                                    <input type="text" id="miembro_cargo_{{ $i }}"
                                           name="miembro_cargo_{{ $i }}"
                                           value="{{ old('miembro_cargo_' . $i) }}"
                                           placeholder="Ej: Presidenta, Secretaria..."
                                           class="cargo-input" data-member="{{ $i }}">
                                </div>
                            </div>
                        </div>

                    </div>{{-- /body --}}
                </div>
                @endfor
            </div>

            <button type="button" class="btn-add-member" id="btnAddMember">
                <i class="fa fa-plus"></i>
                Agregar miembro
            </button>

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
<script src="{{ asset('assets/js/editpage/board_edit.js') }}"></script>
@endpush