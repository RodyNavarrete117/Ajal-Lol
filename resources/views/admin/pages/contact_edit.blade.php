@extends('admin.dashboard')

@section('title', 'Editar Página - Contacto')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap">
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
                Modifica la información de contacto, redes sociales y mapa que se muestran en el sitio.
            </p>
        </div>

        <form method="POST" action="#">
            @csrf

            {{-- ── SECCIÓN 1: Información general ── --}}
            <div class="section-label">
                <span class="section-label__text">
                    <i class="fa fa-circle-info"></i>
                    Información general
                </span>
                <span class="section-label__hint">Aparece en el header, footer y página de contacto</span>
            </div>

            <div class="info-grid">

                <div class="form-group">
                    <label for="correo">
                        <i class="fa fa-envelope"></i>
                        Correo electrónico
                        <span class="req">*</span>
                    </label>
                    <input
                        type="email"
                        id="correo"
                        name="correo"
                        value="{{ old('correo', 'ajal-lol@hotmail.com') }}"
                        placeholder="correo@ejemplo.com"
                        required
                    >
                    @error('correo')
                        <span class="field-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefono">
                        <i class="fa fa-phone"></i>
                        Teléfono
                        <span class="req">*</span>
                    </label>
                    <input
                        type="text"
                        id="telefono"
                        name="telefono"
                        value="{{ old('telefono', '+52 999 177 3532') }}"
                        placeholder="+52 000 000 0000"
                        required
                    >
                    @error('telefono')
                        <span class="field-error-msg">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="form-group">
                <label for="direccion">
                    <i class="fa fa-location-dot"></i>
                    Dirección
                </label>
                <textarea
                    id="direccion"
                    name="direccion"
                    rows="2"
                    placeholder="Calle, número, colonia, ciudad..."
                >{{ old('direccion', 'Calle 24 # 99 × 21 y 19 Col. Centro, Hoctún, Yucatán.') }}</textarea>
            </div>

            <div class="form-group">
                <label for="horario">
                    <i class="fa fa-clock"></i>
                    Horario de atención
                </label>
                <input
                    type="text"
                    id="horario"
                    name="horario"
                    value="{{ old('horario', 'Lun–Vie · 9:00 a.m. – 1:00 p.m.') }}"
                    placeholder="Ej: Lun–Vie · 9:00 a.m. – 1:00 p.m."
                >
            </div>

            {{-- ── SECCIÓN 2: Redes sociales ── --}}
            <div class="section-label">
                <span class="section-label__text">
                    <i class="fa fa-share-nodes"></i>
                    Redes sociales
                </span>
                <span class="section-label__hint">Pega la URL completa de cada perfil</span>
            </div>

            <div class="social-grid">

                <div class="form-group social-group">
                    <label for="facebook">
                        <i class="fa-brands fa-facebook"></i>
                        Facebook
                    </label>
                    <div class="input-with-prefix">
                        <span class="input-prefix">facebook.com/</span>
                        <input
                            type="url"
                            id="facebook"
                            name="facebook"
                            value="{{ old('facebook') }}"
                            placeholder="https://facebook.com/tu-pagina"
                        >
                    </div>
                </div>

                <div class="form-group social-group">
                    <label for="instagram">
                        <i class="fa-brands fa-instagram"></i>
                        Instagram
                    </label>
                    <div class="input-with-prefix">
                        <span class="input-prefix">instagram.com/</span>
                        <input
                            type="url"
                            id="instagram"
                            name="instagram"
                            value="{{ old('instagram') }}"
                            placeholder="https://instagram.com/tu-perfil"
                        >
                    </div>
                </div>

                <div class="form-group social-group">
                    <label for="linkedin">
                        <i class="fa-brands fa-linkedin"></i>
                        LinkedIn
                    </label>
                    <div class="input-with-prefix">
                        <span class="input-prefix">linkedin.com/in/</span>
                        <input
                            type="url"
                            id="linkedin"
                            name="linkedin"
                            value="{{ old('linkedin') }}"
                            placeholder="https://linkedin.com/company/tu-empresa"
                        >
                    </div>
                </div>

            </div>

            {{-- ── SECCIÓN 3: Mapa ── --}}
            <div class="section-label">
                <span class="section-label__text">
                    <i class="fa fa-map"></i>
                    Mapa de Google
                </span>
                <span class="section-label__hint">Copia el código embed desde Google Maps</span>
            </div>

            <div class="form-group">
                <label for="mapa_embed">
                    <i class="fa fa-code"></i>
                    Código embed del mapa
                </label>
                <textarea
                    id="mapa_embed"
                    name="mapa_embed"
                    rows="4"
                    placeholder='&lt;iframe src="https://www.google.com/maps/embed?..." ...&gt;&lt;/iframe&gt;'
                >{{ old('mapa_embed') }}</textarea>
                <span class="field-hint">
                    En Google Maps → Compartir → Incorporar un mapa → Copiar HTML
                </span>
            </div>

            {{-- Vista previa del mapa --}}
            <div class="map-preview" id="mapPreview">
                <div class="map-preview__empty" id="mapEmpty">
                    <i class="fa fa-map-location-dot"></i>
                    <span>La vista previa del mapa aparecerá aquí</span>
                </div>
                <div class="map-preview__frame" id="mapFrame" style="display:none;"></div>
            </div>

            {{-- ── Acciones ── --}}
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
<script src="{{ asset('assets/js/editpage/contact_edit.js') }}"></script>
@endpush