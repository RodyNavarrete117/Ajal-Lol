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

        <div class="edit-form-body">

            {{-- ══ PANEL: Hero ══ --}}
            <div class="edit-panel active" id="panel-hero">
                <div class="panel-title">
                    <i class="fa fa-heading"></i>
                    Encabezado principal
                </div>

                <div class="form-group">
                    <label for="eyebrow">Etiqueta superior (Titulo superior)</label>
                    <input type="text" id="eyebrow" name="eyebrow"
                        value="{{ old('eyebrow', $hero->eyebrow ?? '') }}"
                        placeholder="Ej: Organización sin fines de lucro">
                    <span class="field-hint">Texto pequeño que aparece arriba del título principal.</span>
                </div>

                <div class="form-group">
                    <label for="titulo_principal">Título principal <span class="req">*</span></label>
                    <input type="text" id="titulo_principal" name="titulo_principal"
                        value="{{ old('titulo_principal', $hero->titulo_principal ?? '') }}"
                        placeholder="Ej: Portal informativo de">
                </div>

                <div class="form-group">
                    <label for="titulo_em">Nombre en cursiva (parte destacada)</label>
                    <input type="text" id="titulo_em" name="titulo_em"
                        value="{{ old('titulo_em', $hero->titulo_em ?? '') }}"
                        placeholder="Ej: Ajal Lol A.C.">
                    <span class="field-hint">Aparece en la segunda línea del título, en cursiva y color rosa.</span>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción <span class="req">*</span></label>
                    <textarea id="descripcion" name="descripcion" rows="3"
                        placeholder="Escribe una descripción breve...">{{ old('descripcion', $hero->descripcion ?? '') }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-save" id="btnSaveHero">
                        <i class="fa fa-floppy-disk"></i>
                        Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>

            {{-- ══ PANEL: Estadísticas ══ --}}
            <div class="edit-panel" id="panel-stats"
                data-stats='@json($statsData ?? [])'
                data-bd-stats='@json($bdStats ?? [])'>

                <div class="panel-title">
                    <i class="fa fa-chart-simple"></i>
                    Estadísticas destacadas
                </div>

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

                <div class="stats-add-yr-form" id="statsAddYrForm">
                    <label>Nuevo año:</label>
                    <input class="stats-ayi" type="number" id="statsAyiInp"
                           min="2000" max="2100" placeholder="2025">
                    <button class="stats-btn-ok" id="statsBtnOk" type="button">
                        <i class="fa fa-check"></i> Agregar
                    </button>
                    <button class="stats-btn-cx" id="statsBtnCx" type="button">Cancelar</button>
                </div>

                <div class="stats-yr-row" id="statsYrRow"></div>
                <div class="stats-yr-dd" id="statsYrDd" role="listbox" style="display:none"></div>
                <div id="statsYrPanel"></div>
                <input type="hidden" name="stats_data" id="statsDataInput">

                <div class="form-actions">
                    <button type="button" class="btn-save" id="btnSaveStats">
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
                    @forelse($videos as $vi => $vid)
                    @php
                        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $vid->youtube_url, $m);
                        $ytId = $m[1] ?? '';
                    @endphp
                    <div class="video-row" id="video-row-{{ $vi + 1 }}">
                        <div class="video-row__num">{{ $vi + 1 }}</div>
                        <div class="video-row__thumb" id="vthumb-{{ $vi + 1 }}">
                            @if($ytId)
                            <img src="https://img.youtube.com/vi/{{ $ytId }}/mqdefault.jpg" alt="Miniatura" loading="lazy">
                            @else
                            <img src="" alt="Miniatura" style="opacity:0">
                            @endif
                            <span class="video-row__play"><i class="fa fa-play"></i></span>
                        </div>
                        <div class="video-row__fields">
                            <div class="form-group">
                                <label for="vid_titulo_{{ $vi + 1 }}">Título del video</label>
                                <input type="text"
                                    id="vid_titulo_{{ $vi + 1 }}"
                                    name="vid_titulo_{{ $vi + 1 }}"
                                    value="{{ old('vid_titulo_' . ($vi+1), $vid->titulo ?? '') }}"
                                    placeholder="Ej: Nuestra historia"
                                    class="vid-title-input">
                            </div>
                            <div class="form-group">
                                <label for="vid_id_{{ $vi + 1 }}">URL de YouTube</label>
                                <input type="text"
                                    id="vid_id_{{ $vi + 1 }}"
                                    name="vid_id_{{ $vi + 1 }}"
                                    value="{{ old('vid_id_' . ($vi+1), $vid->youtube_url ?? '') }}"
                                    placeholder="Ej: https://www.youtube.com/watch?v=..."
                                    class="vid-id-input"
                                    data-thumb="vthumb-{{ $vi + 1 }}">
                                <span class="field-hint">URL completa de YouTube.</span>
                            </div>
                        </div>
                        <button type="button" class="btn-remove-video" data-row="{{ $vi + 1 }}" title="Eliminar video">
                            <i class="fa fa-xmark"></i>
                        </button>
                    </div>
                    @empty
                    <div class="video-row" id="video-row-1">
                        <div class="video-row__num">1</div>
                        <div class="video-row__thumb" id="vthumb-1">
                            <img src="" alt="Miniatura" style="opacity:0">
                            <span class="video-row__play"><i class="fa fa-play"></i></span>
                        </div>
                        <div class="video-row__fields">
                            <div class="form-group">
                                <label for="vid_titulo_1">Título del video</label>
                                <input type="text" id="vid_titulo_1" name="vid_titulo_1"
                                    placeholder="Ej: Nuestra historia" class="vid-title-input">
                            </div>
                            <div class="form-group">
                                <label for="vid_id_1">URL de YouTube</label>
                                <input type="text" id="vid_id_1" name="vid_id_1"
                                    placeholder="Ej: https://www.youtube.com/watch?v=..."
                                    class="vid-id-input" data-thumb="vthumb-1">
                                <span class="field-hint">URL completa de YouTube.</span>
                            </div>
                        </div>
                        <button type="button" class="btn-remove-video" data-row="1" title="Eliminar video">
                            <i class="fa fa-xmark"></i>
                        </button>
                    </div>
                    @endforelse
                </div>

                <div class="video-add-bar" id="videoAddBar">
                    <button type="button" class="btn-add-video" id="btnAddVideo">
                        <i class="fa fa-plus"></i>
                        Agregar video
                    </button>
                    <span class="video-max-hint">Máximo <strong>10 videos</strong> en total</span>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-save" id="btnSaveVideos">
                        <i class="fa fa-floppy-disk"></i>
                        Guardar Cambios
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
    window.HOME_ROUTES = {
        hero     : '{{ route("admin.pages.home.hero") }}',
        videos   : '{{ route("admin.pages.home.videos") }}',
        stats    : '{{ route("admin.pages.home.update") }}',
        csrfToken: '{{ csrf_token() }}',
    };
</script>
<script src="{{ asset('assets/js/editpage/home_edit.js') }}"></script>
@endpush