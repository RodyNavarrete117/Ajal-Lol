@extends('admin.dashboard')

@section('title', 'Editar Página - Actividades')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap">
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/activities_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-calendar-days"></i>
                </div>
                <h2>Editar Página Actividades</h2>
            </div>
            <p class="subtitle">
                Administra el encabezado, año activo y cada tarjeta de actividad que se muestra en la página pública.
            </p>
        </div>

        <form method="POST" action="#">
            @csrf

            {{-- ── SECCIÓN 1: Encabezado ── --}}
            <div class="act-section">
                <div class="act-section__title">
                    <i class="fa fa-heading"></i>
                    Encabezado de la página
                </div>

                <div class="act-row">
                    <div class="form-group">
                        <label for="titulo_seccion">Título principal <span class="req">*</span></label>
                        <input
                            type="text"
                            id="titulo_seccion"
                            name="titulo_seccion"
                            value="{{ old('titulo_seccion', 'Actividades') }}"
                            placeholder="Ej: Actividades"
                            required
                        >
                        @error('titulo_seccion')
                            <span class="field-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="anio_activo">Año activo (visible por defecto)</label>
                        <input
                            type="number"
                            id="anio_activo"
                            name="anio_activo"
                            value="{{ old('anio_activo', date('Y')) }}"
                            min="2000"
                            max="2099"
                            placeholder="{{ date('Y') }}"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="subtitulo_seccion">Subtítulo</label>
                    <input
                        type="text"
                        id="subtitulo_seccion"
                        name="subtitulo_seccion"
                        value="{{ old('subtitulo_seccion', 'Nuestras Actividades 2023') }}"
                        placeholder="Ej: Nuestras Actividades 2023"
                    >
                </div>
            </div>

            {{-- ── SECCIÓN 2: Tarjetas de actividades ── --}}
            <div class="act-section">
                <div class="act-section__title">
                    <i class="fa fa-grid-2"></i>
                    Tarjetas de actividades
                </div>
                <p class="act-section__desc">Cada tarjeta aparece en el grid de la página pública con ícono, título y descripción.</p>

                <div class="activities-list" id="activitiesList">

                    @php
                        $actividades = [
                            ['icono' => 'fa-tooth',        'titulo' => 'Jornada dental',          'descripcion' => 'Por segundo año consecutivo, se realizaron jornadas de servicios dentales con el apoyo de la Fundación Smile y Global Dental. Un equipo de 35 dentistas brindó servicios gratuitos, atendiendo a 159 pacientes de varios municipios.'],
                            ['icono' => 'fa-heart-pulse',  'titulo' => 'Jornada de salud',        'descripcion' => 'Realizamos 2 jornadas de salud en Hoctún con detección gratuita de niveles de azúcar, presión arterial, peso, talla, vista y orientación psicológica, beneficiando a 300 personas.'],
                            ['icono' => 'fa-chalkboard',   'titulo' => 'Talleres de capacitación','descripcion' => 'Con el apoyo de Mentors International, se realizaron cursos de administración básica para pequeños emprendedores en varios municipios, beneficiando a 150 personas.'],
                            ['icono' => 'fa-tree',         'titulo' => 'Reforestación',           'descripcion' => 'El Ayuntamiento de Mérida donó 1,666 plantas forestales y maderables a 11 localidades para reforestar predios de producción y traspatio.'],
                            ['icono' => 'fa-feather',      'titulo' => 'Cría de pavos de engorda','descripcion' => 'Como seguimiento al proyecto iniciado en 2022 con donativos de OXXO que benefició a 350 familias, en 2023 se pudo continuar con el programa de engorda de pavos de traspatio.'],
                            ['icono' => 'fa-droplet',      'titulo' => 'Entrega de tinacos',      'descripcion' => 'Gracias a la gestión de Ajal Lol y la aportación de Mariana Trinitaria, se llevaron programas de abastecimiento de agua a varias comunidades, beneficiando a más de 400 familias.'],
                        ];
                    @endphp

                    @foreach($actividades as $i => $act)
                    <div class="activity-card" id="act-{{ $i + 1 }}">

                        <div class="activity-card__side">
                            <div class="activity-card__num">{{ $i + 1 }}</div>
                            <div class="activity-card__icon-preview" id="icon-preview-{{ $i + 1 }}">
                                <i class="fa {{ $act['icono'] }}"></i>
                            </div>
                        </div>

                        <div class="activity-card__fields">
                            <div class="act-fields-row">
                                <div class="form-group">
                                    <label for="act_icono_{{ $i + 1 }}">Ícono</label>
                                    <div class="icon-selector-wrap">
                                        <div class="icon-selector-trigger" data-target="act_icono_{{ $i + 1 }}" data-preview="icon-preview-{{ $i + 1 }}">
                                            <div class="icon-selector-trigger__preview" id="trigger-preview-{{ $i + 1 }}">
                                                <i class="fa {{ $act['icono'] }}"></i>
                                            </div>
                                            <div class="icon-selector-trigger__info">
                                                <span class="icon-selector-trigger__name" id="trigger-name-{{ $i + 1 }}">{{ \Illuminate\Support\Str::after($act['icono'], 'fa-') }}</span>
                                                <span class="icon-selector-trigger__class" id="trigger-class-{{ $i + 1 }}">{{ $act['icono'] }}</span>
                                            </div>
                                            <span class="icon-selector-trigger__arrow"><i class="fa fa-chevron-down"></i></span>
                                        </div>
                                        <input
                                            type="hidden"
                                            id="act_icono_{{ $i + 1 }}"
                                            name="act_icono_{{ $i + 1 }}"
                                            value="{{ old('act_icono_' . ($i+1), $act['icono']) }}"
                                            class="icon-hidden-input"
                                        >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="act_titulo_{{ $i + 1 }}">Título de la actividad</label>
                                    <input
                                        type="text"
                                        id="act_titulo_{{ $i + 1 }}"
                                        name="act_titulo_{{ $i + 1 }}"
                                        value="{{ old('act_titulo_' . ($i+1), $act['titulo']) }}"
                                        placeholder="Nombre de la actividad..."
                                    >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="act_desc_{{ $i + 1 }}">Descripción</label>
                                <textarea
                                    id="act_desc_{{ $i + 1 }}"
                                    name="act_desc_{{ $i + 1 }}"
                                    rows="3"
                                    placeholder="Describe la actividad, beneficiarios, alcance..."
                                >{{ old('act_desc_' . ($i+1), $act['descripcion']) }}</textarea>
                            </div>
                        </div>

                        <button type="button" class="btn-remove-act" data-act="{{ $i + 1 }}" title="Eliminar actividad">
                            <i class="fa fa-xmark"></i>
                        </button>

                    </div>
                    @endforeach

                </div>{{-- /activities-list --}}

                <button type="button" class="btn-add-act" id="btnAddAct">
                    <i class="fa fa-plus"></i>
                    Agregar actividad
                </button>

            </div>

            {{-- Acciones --}}
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

{{-- ── Panel selector de íconos (global, compartido) ── --}}
<div class="icon-picker" id="iconPicker" role="dialog" aria-modal="true" aria-label="Seleccionar ícono">
    <div class="icon-picker__backdrop" id="iconPickerBackdrop"></div>
    <div class="icon-picker__panel">
        <div class="icon-picker__header">
            <span class="icon-picker__title"><i class="fa fa-icons"></i> Seleccionar ícono</span>
            <button type="button" class="icon-picker__close" id="iconPickerClose" aria-label="Cerrar">
                <i class="fa fa-xmark"></i>
            </button>
        </div>
        <div class="icon-picker__search-wrap">
            <i class="fa fa-magnifying-glass icon-picker__search-ico"></i>
            <input type="text" class="icon-picker__search" id="iconSearch" placeholder="Buscar ícono... (ej: salud, árbol, agua)">
        </div>
        <div class="icon-picker__categories" id="iconCategories"></div>
        <div class="icon-picker__grid" id="iconGrid"></div>
        <div class="icon-picker__empty" id="iconEmpty" style="display:none;">
            <i class="fa fa-face-frown-open"></i>
            <span>Sin resultados para esa búsqueda</span>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/editpage/activities_edit.js') }}"></script>
@endpush