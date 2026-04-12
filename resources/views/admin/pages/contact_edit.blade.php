@extends('admin.dashboard')

@section('title', 'Editar Página - Contacto')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/contact_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- ── Hero Header ── --}}
        <div class="edit-header">
            <div class="edit-header__bg">
                <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.61 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l1.27-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.61 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l1.27-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.61 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l1.27-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.61 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l1.27-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.61 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l1.27-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.61 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l1.27-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </div>
            <div class="edit-header-top">
                <div class="edit-icon"><i class="fa fa-address-card"></i></div>
                <h2>Editar Página Contacto</h2>
            </div>
            <p class="subtitle">
                Modifica la información de contacto, redes sociales y mapa que se muestran en el sitio.
            </p>
        </div>

        {{-- ── Tabs ── --}}
        <div class="edit-tabs-bar">
            <button class="edit-tab active" data-target="info">
                <i class="fa fa-circle-info"></i>
                Información
            </button>
            <button class="edit-tab" data-target="redes">
                <i class="fa fa-share-nodes"></i>
                Redes sociales
            </button>
            <button class="edit-tab" data-target="mapa">
                <i class="fa fa-map"></i>
                Mapa
            </button>
        </div>

        <form id="contact-edit-form" method="POST"
              action="{{ route('admin.pages.contact.update') }}">
            @csrf
            @method('PUT')

            {{-- ══ PANEL: Información ══ --}}
            <div class="edit-panel active" id="panel-info">
                <div class="panel-section-title">
                    <i class="fa fa-circle-info"></i>
                    Información general
                    <span class="panel-section-hint">Aparece en el header, footer y página de contacto</span>
                </div>

                <div class="info-grid">
                    <div class="form-group">
                        <label for="correo">
                            <i class="fa fa-envelope"></i>
                            Correo electrónico <span class="req">*</span>
                        </label>
                        <input type="email" id="correo" name="correo"
                            value="{{ old('correo', $contacto->email_contacto ?? '') }}"
                            placeholder="correo@ejemplo.com" required>
                        @error('correo')<span class="field-error-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="telefono">
                            <i class="fa fa-phone"></i>
                            Teléfono <span class="req">*</span>
                        </label>
                        <input type="text" id="telefono" name="telefono"
                            value="{{ old('telefono', $contacto->telefono_contacto ?? '') }}"
                            placeholder="+52 000 000 0000" required>
                        @error('telefono')<span class="field-error-msg">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion">
                        <i class="fa fa-location-dot"></i>
                        Dirección
                    </label>
                    <textarea id="direccion" name="direccion" rows="2"
                        placeholder="Calle, número, colonia, ciudad...">{{ old('direccion', $contacto->direccion_contacto ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="horario">
                        <i class="fa fa-clock"></i>
                        Horario de atención
                    </label>
                    <input type="text" id="horario" name="horario"
                        value="{{ old('horario', $contacto->horario_contacto ?? '') }}"
                        placeholder="Ej: Lun–Vie · 9:00 a.m. – 1:00 p.m.">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save"><i class="fa fa-floppy-disk"></i> Guardar Cambios</button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: Redes sociales ══ --}}
            <div class="edit-panel" id="panel-redes">
                <div class="panel-section-title">
                    <i class="fa fa-share-nodes"></i>
                    Redes sociales
                    <span class="panel-section-hint">Pega la URL completa de cada perfil</span>
                </div>

                <div class="social-grid">
                    <div class="form-group social-group social-group--fb">
                        <label for="facebook">
                            <i class="fa-brands fa-facebook"></i>
                            Facebook
                        </label>
                        <div class="input-with-prefix">
                            <span class="input-prefix"><i class="fa-brands fa-facebook"></i></span>
                            <input type="url" id="facebook" name="facebook"
                                value="{{ old('facebook', $contacto->facebook_url ?? '') }}"
                                placeholder="https://facebook.com/tu-pagina">
                        </div>
                    </div>

                    <div class="form-group social-group social-group--ig">
                        <label for="instagram">
                            <i class="fa-brands fa-instagram"></i>
                            Instagram
                        </label>
                        <div class="input-with-prefix">
                            <span class="input-prefix"><i class="fa-brands fa-instagram"></i></span>
                            <input type="url" id="instagram" name="instagram"
                                value="{{ old('instagram', $contacto->instagram_url ?? '') }}"
                                placeholder="https://instagram.com/tu-perfil">
                        </div>
                    </div>

                    <div class="form-group social-group social-group--li">
                        <label for="linkedin">
                            <i class="fa-brands fa-linkedin"></i>
                            LinkedIn
                        </label>
                        <div class="input-with-prefix">
                            <span class="input-prefix"><i class="fa-brands fa-linkedin"></i></span>
                            <input type="url" id="linkedin" name="linkedin"
                                value="{{ old('linkedin', $contacto->linkedin_url ?? '') }}"
                                placeholder="https://linkedin.com/company/tu-empresa">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save"><i class="fa fa-floppy-disk"></i> Guardar Cambios</button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: Mapa ══ --}}
            <div class="edit-panel" id="panel-mapa">
                <div class="panel-section-title">
                    <i class="fa fa-map"></i>
                    Mapa de Google
                    <span class="panel-section-hint">Copia el código embed desde Google Maps</span>
                </div>

                <div class="mapa-steps-bar">
                    <div class="mapa-step">
                        <span class="mapa-step__num">1</span>
                        <span>Abre <strong>Google Maps</strong> y busca tu ubicación</span>
                    </div>
                    <div class="mapa-step">
                        <span class="mapa-step__num">2</span>
                        <span>Haz clic en <strong>Compartir</strong> → Incorporar un mapa</span>
                    </div>
                    <div class="mapa-step">
                        <span class="mapa-step__num">3</span>
                        <span>Copia el código <strong>&lt;iframe&gt;</strong> y pégalo abajo</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mapa_embed">
                        <i class="fa fa-code"></i>
                        Código embed del mapa
                    </label>
                    <textarea id="mapa_embed" name="mapa_embed" rows="5"
                        placeholder='&lt;iframe src="https://www.google.com/maps/embed?..." ...&gt;&lt;/iframe&gt;'>{{ old('mapa_embed', $contacto->mapa_embed ?? '') }}</textarea>
                    <span class="field-hint">Google Maps → Compartir → Incorporar un mapa → Copiar HTML</span>
                </div>

                <div class="mapa-preview-label">
                    <i class="fa fa-eye"></i>
                    Vista previa del mapa
                </div>

                <div class="map-preview" id="mapPreview">
                    <div class="map-preview__empty" id="mapEmpty"
                         style="{{ ($contacto->mapa_embed ?? '') ? 'display:none' : 'display:flex' }}">
                        <i class="fa fa-map-location-dot"></i>
                        <span>La vista previa aparecerá aquí cuando pegues el código</span>
                    </div>
                    <div class="map-preview__frame" id="mapFrame"
                         style="{{ ($contacto->mapa_embed ?? '') ? 'display:block' : 'display:none' }}">
                        @if(!empty($contacto->mapa_embed))
                            {!! $contacto->mapa_embed !!}
                        @endif
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save"><i class="fa fa-floppy-disk"></i> Guardar Cambios</button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/editpage/contact_edit.js') }}"></script>
@endpush