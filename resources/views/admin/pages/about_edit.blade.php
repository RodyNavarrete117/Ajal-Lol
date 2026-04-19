@extends('admin.dashboard')

@section('title', 'Editar Página - Nosotros')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/about_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- ── Hero Header ── --}}
        <div class="edit-header">
            <div class="edit-header__bg">
                <svg viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0-3-3.87"/></svg>
                <svg viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0-3-3.87"/></svg>
                <svg viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0-3-3.87"/></svg>
                <svg viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0-3-3.87"/></svg>
                <svg viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0-3-3.87"/></svg>
                <svg viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0-3-3.87"/></svg>
            </div>
            <div class="edit-header-top">
                <a href="{{ url('/admin/page') }}" class="edit-back-btn">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <div class="edit-icon">
                    <i class="fa fa-user-group"></i>
                </div>
                <div class="edit-header-text">
                    <h2>Editor de Nosotros</h2>
                    <p class="subtitle">Actualiza la información institucional que se muestra en la página pública.</p>
                </div>
            </div>
        </div>

        {{-- ── Tabs ── --}}
        <div class="edit-tabs-bar">
            <button class="edit-tab active" data-target="encabezado">
                <i class="fa fa-heading"></i> Encabezado
            </button>
            <button class="edit-tab" data-target="historia">
                <i class="fa fa-image"></i> Historia
            </button>
            <button class="edit-tab" data-target="general">
                <i class="fa fa-circle-info"></i> General
            </button>
            <button class="edit-tab" data-target="identidad">
                <i class="fa fa-landmark"></i> Identidad
            </button>
        </div>

        <div class="edit-form-body">

            {{-- ══ PANEL: Encabezado ══ --}}
            <div class="edit-panel active" id="panel-encabezado">
                <div class="form-section-title">
                    <i class="fa fa-heading"></i>
                    Encabezado de la página
                </div>

                <div class="form-group">
                    <label for="titulo_pagina">Título principal</label>
                    <input type="text" id="titulo_pagina" name="titulo_pagina"
                        value="{{ old('titulo_pagina', $encabezado->titulo ?? '') }}"
                        placeholder="Ej: Nosotros">
                </div>

                <div class="form-group">
                    <label for="subtitulo_pagina">Subtítulo / descripción corta</label>
                    <input type="text" id="subtitulo_pagina" name="subtitulo_pagina"
                        value="{{ old('subtitulo_pagina', $encabezado->subtitulo ?? '') }}"
                        placeholder="Ej: Conoce más sobre nuestra historia">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-save" id="btnSaveEncabezado">
                        <i class="fa fa-floppy-disk"></i> Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: Historia ══ --}}
            <div class="edit-panel" id="panel-historia">
                <div class="form-section-title">
                    <i class="fa fa-image"></i>
                    Bloque historia — imagen y contenido
                </div>

                <div class="form-group">
                    <label>Imagen principal</label>
                    <div class="image-upload-area" id="histImgArea">
                        <div class="image-upload-area__preview" id="histImgPreview">
                            @if(!empty($historia->imagen))
                                <img src="{{ Storage::url($historia->imagen) }}" alt="Imagen actual">
                            @else
                                <div class="image-upload-area__empty">
                                    <i class="fa fa-image"></i>
                                    <span>Haz clic o arrastra una imagen aquí</span>
                                    <small>PNG, JPG, WEBP · Máx. 5MB</small>
                                </div>
                            @endif
                        </div>
                        <div class="image-upload-area__actions">
                            <label class="btn-img-upload" for="imagen_historia">
                                <i class="fa fa-arrow-up-from-bracket"></i>
                                Seleccionar imagen
                            </label>
                            <button type="button" class="btn-img-clear" id="btnClearHist">
                                <i class="fa fa-xmark"></i> Quitar
                            </button>
                            <input type="file" id="imagen_historia" name="imagen_historia"
                                accept="image/png,image/jpeg,image/webp" style="display:none;">
                            <input type="hidden" id="quitar_imagen" name="quitar_imagen" value="0">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="badge_imagen">Texto del badge sobre la imagen</label>
                    <input type="text" id="badge_imagen" name="badge_imagen"
                        value="{{ old('badge_imagen', $historia->badge_texto ?? '') }}"
                        placeholder="Ej: Fundada en el año 2000">
                    <span class="field-hint">Aparece como etiqueta sobre la foto, en la esquina inferior izquierda.</span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="eyebrow_historia">Etiqueta superior</label>
                        <input type="text" id="eyebrow_historia" name="eyebrow_historia"
                            value="{{ old('eyebrow_historia', $historia->etiqueta_superior ?? '') }}"
                            placeholder="Ej: Nuestra Historia">
                    </div>
                    <div class="form-group">
                        <label for="titulo_historia">Título del bloque</label>
                        <input type="text" id="titulo_historia" name="titulo_historia"
                            value="{{ old('titulo_historia', $historia->titulo_bloque ?? '') }}"
                            placeholder="Ej: Así comenzó Ajal Lol">
                    </div>
                </div>

                <div class="form-group">
                    <label for="texto_destacado">Texto destacado (blockquote)</label>
                    <textarea id="texto_destacado" name="texto_destacado" rows="4"
                        placeholder="Texto en cursiva que aparece resaltado con borde lateral...">{{ old('texto_destacado', $historia->texto_destacado ?? '') }}</textarea>
                    <span class="field-hint">Se mostrará en cursiva con un borde izquierdo de color.</span>
                </div>

                <div class="form-group">
                    <label for="texto_descripcion">Texto descriptivo</label>
                    <textarea id="texto_descripcion" name="texto_descripcion" rows="4"
                        placeholder="Texto explicativo más amplio sobre la organización...">{{ old('texto_descripcion', $historia->texto_descriptivo ?? '') }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-save" id="btnSaveHistoria">
                        <i class="fa fa-floppy-disk"></i> Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: General ══ --}}
            <div class="edit-panel" id="panel-general">
                <div class="form-section-title">
                    <i class="fa fa-circle-info"></i>
                    Información general
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="anio_fundacion">Año de fundación</label>
                        <input type="number" id="anio_fundacion" name="anio_fundacion"
                            value="{{ old('anio_fundacion', $general->ano_fundacion ?? '') }}"
                            min="1900" max="2099" placeholder="Ej: 2000">
                    </div>
                    <div class="form-group">
                        <label for="num_beneficiarios">Beneficiarios</label>
                        <input type="text" id="num_beneficiarios" name="num_beneficiarios"
                            value="{{ old('num_beneficiarios', $general->beneficiarios ?? '') }}"
                            placeholder="Ej: Más de 500 familias">
                    </div>
                </div>

                <div class="form-group">
                    <label for="ubicacion">Ubicación</label>
                    <input type="text" id="ubicacion" name="ubicacion"
                        value="{{ old('ubicacion', $general->ubicacion ?? '') }}"
                        placeholder="Ej: Mérida, Yucatán, México">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-save" id="btnSaveGeneral">
                        <i class="fa fa-floppy-disk"></i> Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: Identidad ══ --}}
            <div class="edit-panel" id="panel-identidad">
                <div class="form-section-title">
                    <i class="fa fa-landmark"></i>
                    Identidad institucional
                </div>

                <div class="identity-header-fields">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="identidad_titulo">Título principal</label>
                            <input type="text" id="identidad_titulo" name="identidad_titulo"
                                value="{{ old('identidad_titulo', $identidad->titulo ?? '') }}"
                                placeholder="Ej: Nuestra Identidad">
                        </div>
                        <div class="form-group">
                            <label for="identidad_subtitulo">Subtítulo</label>
                            <input type="text" id="identidad_subtitulo" name="identidad_subtitulo"
                                value="{{ old('identidad_subtitulo', $identidad->subtitulo ?? '') }}"
                                placeholder="Ej: Los principios que nos guían">
                        </div>
                    </div>
                </div>

                <p class="section-desc">
                    Textos de la sección <strong>Nuestra Identidad</strong> del sitio público, distribuidos en 4 tarjetas.
                </p>

                <div class="identity-grid">

                    {{-- Misión --}}
                    @php $mision = $identidadItems->get('mision') @endphp
                    <div class="identity-card identity-card--mision" data-collapsed="true">
                        <button type="button" class="identity-card__toggle">
                            <div class="identity-card__header">
                                <div class="identity-card__icon"><i class="fa fa-circle-dot"></i></div>
                                <span class="identity-card__label">Misión</span>
                            </div>
                            <div class="identity-card__chevron"><i class="fa fa-chevron-down"></i></div>
                        </button>
                        <div class="identity-card__body">
                            <div class="form-group">
                                <label for="titulo_mision">Título de la tarjeta</label>
                                <input type="text" id="titulo_mision" name="titulo_mision"
                                    value="{{ old('titulo_mision', $mision->titulo ?? '') }}"
                                    placeholder="Ej: Misión">
                            </div>
                            <div class="form-group">
                                <label for="mision">Contenido</label>
                                <textarea id="mision" name="mision" rows="4"
                                    placeholder="Impulsar programas que aporten positivamente...">{{ old('mision', $mision->contenido ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Visión --}}
                    @php $vision = $identidadItems->get('vision') @endphp
                    <div class="identity-card identity-card--vision" data-collapsed="true">
                        <button type="button" class="identity-card__toggle">
                            <div class="identity-card__header">
                                <div class="identity-card__icon"><i class="fa fa-eye"></i></div>
                                <span class="identity-card__label">Visión</span>
                            </div>
                            <div class="identity-card__chevron"><i class="fa fa-chevron-down"></i></div>
                        </button>
                        <div class="identity-card__body">
                            <div class="form-group">
                                <label for="titulo_vision">Título de la tarjeta</label>
                                <input type="text" id="titulo_vision" name="titulo_vision"
                                    value="{{ old('titulo_vision', $vision->titulo ?? '') }}"
                                    placeholder="Ej: Visión">
                            </div>
                            <div class="form-group">
                                <label for="vision">Contenido</label>
                                <textarea id="vision" name="vision" rows="4"
                                    placeholder="Ser un referente a nivel nacional...">{{ old('vision', $vision->contenido ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Objetivo General --}}
                    @php $objetivo = $identidadItems->get('objetivo') @endphp
                    <div class="identity-card identity-card--objetivo" data-collapsed="true">
                        <button type="button" class="identity-card__toggle">
                            <div class="identity-card__header">
                                <div class="identity-card__icon"><i class="fa fa-flag"></i></div>
                                <span class="identity-card__label">Objetivo General</span>
                            </div>
                            <div class="identity-card__chevron"><i class="fa fa-chevron-down"></i></div>
                        </button>
                        <div class="identity-card__body">
                            <div class="form-group">
                                <label for="titulo_objetivo">Título de la tarjeta</label>
                                <input type="text" id="titulo_objetivo" name="titulo_objetivo"
                                    value="{{ old('titulo_objetivo', $objetivo->titulo ?? '') }}"
                                    placeholder="Ej: Objetivo General">
                            </div>
                            <div class="form-group">
                                <label for="objetivo_general">Contenido</label>
                                <textarea id="objetivo_general" name="objetivo_general" rows="4"
                                    placeholder="Contribuir al mejoramiento de la calidad de vida...">{{ old('objetivo_general', $objetivo->contenido ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Valores --}}
                    @php $valores = $identidadItems->get('valores') @endphp
                    <div class="identity-card identity-card--valores" data-collapsed="true">
                        <button type="button" class="identity-card__toggle">
                            <div class="identity-card__header">
                                <div class="identity-card__icon"><i class="fa fa-heart"></i></div>
                                <span class="identity-card__label">Valores</span>
                            </div>
                            <div class="identity-card__chevron"><i class="fa fa-chevron-down"></i></div>
                        </button>
                        <div class="identity-card__body">
                            <div class="form-group">
                                <label for="titulo_valores">Título de la tarjeta</label>
                                <input type="text" id="titulo_valores" name="titulo_valores"
                                    value="{{ old('titulo_valores', $valores->titulo ?? '') }}"
                                    placeholder="Ej: Valores">
                            </div>
                            <div class="form-group">
                                <label for="valores">Contenido</label>
                                <textarea id="valores" name="valores" rows="5"
                                    placeholder="Solidaridad: ser empáticos...">{{ old('valores', $valores->contenido ?? '') }}</textarea>
                                <span class="field-hint">Escribe cada valor en una línea separada. Usa el formato <strong>Nombre:</strong> descripción.</span>
                            </div>
                        </div>
                    </div>

                </div>{{-- /identity-grid --}}

                <div class="form-actions">
                    <button type="button" class="btn-save" id="btnSaveIdentidad">
                        <i class="fa fa-floppy-disk"></i> Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

        </div>{{-- /edit-form-body --}}
    </div>{{-- /edit-container --}}
</div>{{-- /edit-page-wrapper --}}

@endsection

@push('scripts')
<script>
    window.ABOUT_ROUTES = {
        encabezado : '{{ route("admin.pages.about.encabezado") }}',
        historia   : '{{ route("admin.pages.about.historia") }}',
        general    : '{{ route("admin.pages.about.general") }}',
        identidad  : '{{ route("admin.pages.about.identidad") }}',
        csrfToken  : '{{ csrf_token() }}',
    };
</script>
<script src="{{ asset('assets/js/editpage/about_edit.js') }}"></script>
@endpush