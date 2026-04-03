@extends('admin.dashboard')

@section('title', 'Editar Página - Inicio')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap">
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/home_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- ── Header ── --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-file-pen"></i>
                </div>
                <h2>Editar Página Inicio</h2>
            </div>
            <p class="subtitle">
                Modifica el contenido principal que se muestra en la página de inicio del sitio web.
            </p>
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
        <form method="POST" action="#">
            @csrf

            {{-- ══ PANEL: Hero ══ --}}
            <div class="edit-panel active" id="panel-hero">
                <div class="panel-title">
                    <i class="fa fa-heading"></i>
                    Encabezado principal
                </div>

                <div class="form-group">
                    <label for="eyebrow">Etiqueta superior (eyebrow)</label>
                    <input
                        type="text"
                        id="eyebrow"
                        name="eyebrow"
                        value="{{ old('eyebrow', 'Organización sin fines de lucro') }}"
                        placeholder="Ej: Organización sin fines de lucro"
                    >
                    <span class="field-hint">Texto pequeño que aparece arriba del título principal.</span>
                </div>

                <div class="form-group">
                    <label for="titulo_principal">Título principal <span class="req">*</span></label>
                    <input
                        type="text"
                        id="titulo_principal"
                        name="titulo_principal"
                        value="{{ old('titulo_principal', 'Portal informativo de') }}"
                        placeholder="Ej: Portal informativo de"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="titulo_em">Nombre en cursiva (parte destacada)</label>
                    <input
                        type="text"
                        id="titulo_em"
                        name="titulo_em"
                        value="{{ old('titulo_em', 'Ajal Lol A.C.') }}"
                        placeholder="Ej: Ajal Lol A.C."
                    >
                    <span class="field-hint">Aparece en la segunda línea del título, en cursiva y color rosa.</span>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción <span class="req">*</span></label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="3"
                        placeholder="Escribe una descripción breve..."
                        required
                    >{{ old('descripcion', 'Transformando vidas en las comunidades mayas de Yucatán desde el año 2000, con amor, compromiso e interculturalidad.') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="btn_primario">Botón primario (texto)</label>
                        <input
                            type="text"
                            id="btn_primario"
                            name="btn_primario"
                            value="{{ old('btn_primario', 'Conoce más') }}"
                            placeholder="Ej: Conoce más"
                        >
                    </div>
                    <div class="form-group">
                        <label for="btn_primario_url">Botón primario (enlace)</label>
                        <input
                            type="text"
                            id="btn_primario_url"
                            name="btn_primario_url"
                            value="{{ old('btn_primario_url', '#about') }}"
                            placeholder="Ej: #about o /nosotros"
                        >
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fa fa-floppy-disk" style="margin-right:7px;"></i>
                        Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: Estadísticas ══ --}}
            <div class="edit-panel" id="panel-stats">
                <div class="panel-title">
                    <i class="fa fa-chart-simple"></i>
                    Estadísticas destacadas
                </div>
                <p class="panel-desc">Números que aparecen en la banda de estadísticas de la página de inicio.</p>

                <div class="stats-grid">

                    <div class="stat-card">
                        <div class="stat-card__icon" style="background:rgba(139,62,114,0.12);color:#8B3E72;">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div class="stat-card__fields">
                            <div class="form-group">
                                <label for="stat1_num">Número</label>
                                <input type="text" id="stat1_num" name="stat1_num" value="{{ old('stat1_num', '25+') }}" placeholder="Ej: 25+">
                            </div>
                            <div class="form-group">
                                <label for="stat1_label">Etiqueta</label>
                                <input type="text" id="stat1_label" name="stat1_label" value="{{ old('stat1_label', 'Años de servicio') }}" placeholder="Ej: Años de servicio">
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card__icon" style="background:rgba(8,145,178,0.12);color:#0891b2;">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="stat-card__fields">
                            <div class="form-group">
                                <label for="stat2_num">Número</label>
                                <input type="text" id="stat2_num" name="stat2_num" value="{{ old('stat2_num', '500+') }}" placeholder="Ej: 500+">
                            </div>
                            <div class="form-group">
                                <label for="stat2_label">Etiqueta</label>
                                <input type="text" id="stat2_label" name="stat2_label" value="{{ old('stat2_label', 'Familias beneficiadas') }}" placeholder="Ej: Familias beneficiadas">
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card__icon" style="background:rgba(22,163,74,0.12);color:#16a34a;">
                            <i class="fa fa-map-location-dot"></i>
                        </div>
                        <div class="stat-card__fields">
                            <div class="form-group">
                                <label for="stat3_num">Número</label>
                                <input type="text" id="stat3_num" name="stat3_num" value="{{ old('stat3_num', '11') }}" placeholder="Ej: 11">
                            </div>
                            <div class="form-group">
                                <label for="stat3_label">Etiqueta</label>
                                <input type="text" id="stat3_label" name="stat3_label" value="{{ old('stat3_label', 'Comunidades atendidas') }}" placeholder="Ej: Comunidades atendidas">
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card__icon" style="background:rgba(217,119,6,0.12);color:#d97706;">
                            <i class="fa fa-handshake"></i>
                        </div>
                        <div class="stat-card__fields">
                            <div class="form-group">
                                <label for="stat4_num">Número</label>
                                <input type="text" id="stat4_num" name="stat4_num" value="{{ old('stat4_num', '35') }}" placeholder="Ej: 35">
                            </div>
                            <div class="form-group">
                                <label for="stat4_label">Etiqueta</label>
                                <input type="text" id="stat4_label" name="stat4_label" value="{{ old('stat4_label', 'Colaboradores activos') }}" placeholder="Ej: Colaboradores activos">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fa fa-floppy-disk" style="margin-right:7px;"></i>
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
                    Estos videos se muestran en el modal al presionar el botón <strong>Ver video</strong> del hero.
                    Puedes agregar hasta <strong>10 videos</strong>.
                </p>

                {{-- Lista de videos --}}
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
                            <img
                                src="https://img.youtube.com/vi/{{ $vid['id'] }}/mqdefault.jpg"
                                alt="Miniatura"
                                loading="lazy"
                            >
                            <span class="video-row__play"><i class="fa fa-play"></i></span>
                        </div>
                        <div class="video-row__fields">
                            <div class="form-group">
                                <label for="vid_titulo_{{ $vi + 1 }}">Título del video</label>
                                <input
                                    type="text"
                                    id="vid_titulo_{{ $vi + 1 }}"
                                    name="vid_titulo_{{ $vi + 1 }}"
                                    value="{{ old('vid_titulo_' . ($vi+1), $vid['titulo']) }}"
                                    placeholder="Ej: Nuestra historia"
                                    class="vid-title-input"
                                >
                            </div>
                            <div class="form-group">
                                <label for="vid_id_{{ $vi + 1 }}">ID o URL de YouTube</label>
                                <input
                                    type="text"
                                    id="vid_id_{{ $vi + 1 }}"
                                    name="vid_id_{{ $vi + 1 }}"
                                    value="{{ old('vid_id_' . ($vi+1), $vid['id']) }}"
                                    placeholder="Ej: lRM7kJdDUM4 o https://youtube.com/watch?v=..."
                                    class="vid-id-input"
                                    data-thumb="vthumb-{{ $vi + 1 }}"
                                >
                                <span class="field-hint">Pega el ID del video o la URL completa de YouTube.</span>
                            </div>
                        </div>
                        <button type="button" class="btn-remove-video" data-row="{{ $vi + 1 }}" title="Eliminar video">
                            <i class="fa fa-xmark"></i>
                        </button>
                    </div>
                    @endforeach

                </div>

                {{-- Botón agregar --}}
                <div class="video-add-bar" id="videoAddBar">
                    <button type="button" class="btn-add-video" id="btnAddVideo">
                        <i class="fa fa-plus"></i>
                        Agregar video
                    </button>
                    <span class="video-max-hint">
                        Máximo <strong>10 videos</strong> en total
                    </span>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fa fa-floppy-disk" style="margin-right:7px;"></i>
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