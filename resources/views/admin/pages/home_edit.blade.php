@extends('admin.dashboard')

@section('title', 'Editar Página - Inicio')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/home_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- ── Hero Header ── --}}
        <div class="edit-header">
            <div class="edit-header__bg">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <div class="edit-header-top">
                <a href="{{ url('/admin/page') }}" class="edit-back-btn">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <div class="edit-icon">
                    <i class="fa fa-house"></i>
                </div>
                <div class="edit-header-text">
                    <h2>Editor de Inicio</h2>
                    <p class="subtitle">Modifica el contenido principal que se muestra en la página de inicio del sitio web.</p>
                </div>
            </div>
        </div>

        {{-- ── Tabs ── --}}
        <div class="edit-tabs-bar">
            <button class="edit-tab active" data-target="hero">
                <i class="fa fa-heading"></i>
                Hero
            </button>
            <button class="edit-tab" data-target="stats">
                <i class="fa fa-chart-simple"></i>
                Estadísticas
            </button>
            <button class="edit-tab" data-target="videos">
                <i class="fa fa-film"></i>
                Videos
            </button>
        </div>

        {{-- ── Form ── --}}
        <form method="POST" action="{{ route('admin.pages.home.update') }}">
            @csrf

            {{-- ══ PANEL: Hero ══ --}}
            <div class="edit-panel active" id="panel-hero">
                <div class="panel-title">
                    <i class="fa fa-heading"></i>
                    Encabezado principal
                </div>

                <div class="form-group">
                    <label for="eyebrow">Etiqueta superior (eyebrow)</label>
                    <input type="text" id="eyebrow" name="eyebrow"
                        value="{{ old('eyebrow', 'Organización sin fines de lucro') }}"
                        placeholder="Ej: Organización sin fines de lucro">
                    <span class="field-hint">Texto pequeño que aparece arriba del título principal.</span>
                </div>

                <div class="form-group">
                    <label for="titulo_principal">Título principal <span class="req">*</span></label>
                    <input type="text" id="titulo_principal" name="titulo_principal"
                        value="{{ old('titulo_principal', 'Portal informativo de') }}"
                        placeholder="Ej: Portal informativo de" required>
                </div>

                <div class="form-group">
                    <label for="titulo_em">Nombre en cursiva (parte destacada)</label>
                    <input type="text" id="titulo_em" name="titulo_em"
                        value="{{ old('titulo_em', 'Ajal Lol A.C.') }}"
                        placeholder="Ej: Ajal Lol A.C.">
                    <span class="field-hint">Aparece en la segunda línea del título, en cursiva y color rosa.</span>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción <span class="req">*</span></label>
                    <textarea id="descripcion" name="descripcion" rows="3"
                        placeholder="Escribe una descripción breve..." required
                    >{{ old('descripcion', 'Transformando vidas en las comunidades mayas de Yucatán desde el año 2000, con amor, compromiso e interculturalidad.') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="btn_primario">Botón primario (texto)</label>
                        <input type="text" id="btn_primario" name="btn_primario"
                            value="{{ old('btn_primario', 'Conoce más') }}"
                            placeholder="Ej: Conoce más">
                    </div>
                    <div class="form-group">
                        <label for="btn_primario_url">Botón primario (enlace)</label>
                        <input type="text" id="btn_primario_url" name="btn_primario_url"
                            value="{{ old('btn_primario_url', '#about') }}"
                            placeholder="Ej: #about o /nosotros">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fa fa-floppy-disk"></i>
                        Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: Estadísticas ══ --}}
            <div class="edit-panel" id="panel-stats"
                 data-stats='@json($statsData ?? [])'>

                <div class="panel-title">
                    <i class="fa fa-chart-simple"></i>
                    Estadísticas destacadas
                </div>

                {{-- Totales acumulados --}}
                <div class="stats-totals-bar">
                    <div class="stats-tot-cell">
                        <span class="stats-tot-num" id="statTotBen">0</span>
                        <span class="stats-tot-lbl">Beneficiarios</span>
                    </div>
                    <div class="stats-tot-cell">
                        <span class="stats-tot-num" id="statTotProy">0</span>
                        <span class="stats-tot-lbl">Proyectos</span>
                    </div>
                    <div class="stats-tot-cell">
                        <span class="stats-tot-num" id="statTotHrs">0</span>
                        <span class="stats-tot-lbl">Horas de apoyo</span>
                    </div>
                    <div class="stats-tot-cell">
                        <span class="stats-tot-num" id="statTotVol">0</span>
                        <span class="stats-tot-lbl">Voluntarios</span>
                    </div>
                </div>

                {{-- Form agregar año (oculto por defecto) --}}
                <div class="stats-add-yr-form" id="statsAddYrForm">
                    <label>Nuevo año:</label>
                    <input class="stats-ayi" type="number" id="statsAyiInp"
                           min="2000" max="2100" placeholder="2025">
                    <button class="stats-btn-ok" id="statsBtnOk" type="button">
                        <i class="fa fa-check"></i> Agregar
                    </button>
                    <button class="stats-btn-cx" id="statsBtnCx" type="button">Cancelar</button>
                </div>

                {{-- Carrusel de años --}}
                <div class="stats-yr-row" id="statsYrRow"></div>

                {{-- Dropdown (el JS lo mueve al body) --}}
                <div class="stats-yr-dd" id="statsYrDd" role="listbox" style="display:none"></div>

                {{-- Panel del año activo --}}
                <div id="statsYrPanel"></div>

                {{-- Input hidden para serializar al guardar --}}
                <input type="hidden" name="stats_data" id="statsDataInput">

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fa fa-floppy-disk"></i>
                        Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: Videos ══ --}}
            <div class="edit-panel" id="panel-videos">
                <div class="panel-title">
                    <i class="fa fa-film"></i>
                    Videos de YouTube
                </div>
                <p class="panel-desc">
                    Videos que se muestran al presionar <strong>Ver video</strong> en el hero.
                    Máximo <strong>10 videos</strong>.
                </p>

                <div class="videos-list" id="videosList">

                    @php
                        $videos_default = [
                            ['id' => 'lRM7kJdDUM4', 'titulo' => 'Ajal Lol A.C. — Nuestra historia'],
                            ['id' => 'dQw4w9WgXcQ',  'titulo' => 'Actividades 2023'],
                        ];
                    @endphp

                    @foreach($videos_default as $vi => $vid)
                    <div class="video-row" id="video-row-{{ $vi + 1 }}">
                        <div class="video-row__num">{{ $vi + 1 }}</div>
                        <div class="video-row__thumb" id="vthumb-{{ $vi + 1 }}">
                            <img src="https://img.youtube.com/vi/{{ $vid['id'] }}/mqdefault.jpg" alt="Miniatura" loading="lazy">
                            <span class="video-row__play"><i class="fa fa-play"></i></span>
                        </div>
                        <div class="video-row__fields">
                            <div class="form-group">
                                <label for="vid_titulo_{{ $vi + 1 }}">Título del video</label>
                                <input type="text"
                                    id="vid_titulo_{{ $vi + 1 }}"
                                    name="vid_titulo_{{ $vi + 1 }}"
                                    value="{{ old('vid_titulo_' . ($vi+1), $vid['titulo']) }}"
                                    placeholder="Ej: Nuestra historia"
                                    class="vid-title-input">
                            </div>
                            <div class="form-group">
                                <label for="vid_id_{{ $vi + 1 }}">ID o URL de YouTube</label>
                                <input type="text"
                                    id="vid_id_{{ $vi + 1 }}"
                                    name="vid_id_{{ $vi + 1 }}"
                                    value="{{ old('vid_id_' . ($vi+1), $vid['id']) }}"
                                    placeholder="Ej: lRM7kJdDUM4"
                                    class="vid-id-input"
                                    data-thumb="vthumb-{{ $vi + 1 }}">
                                <span class="field-hint">ID del video o URL completa de YouTube.</span>
                            </div>
                        </div>
                        <button type="button" class="btn-remove-video" data-row="{{ $vi + 1 }}" title="Eliminar video">
                            <i class="fa fa-xmark"></i>
                        </button>
                    </div>
                    @endforeach

                </div>

                <div class="video-add-bar" id="videoAddBar">
                    <button type="button" class="btn-add-video" id="btnAddVideo">
                        <i class="fa fa-plus"></i>
                        Agregar video
                    </button>
                    <span class="video-max-hint">Máximo <strong>10 videos</strong> en total</span>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fa fa-floppy-disk"></i>
                        Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/editpage/home_edit.js') }}"></script>
@endpush