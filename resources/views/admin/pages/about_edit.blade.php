@extends('admin.dashboard')

@section('title', 'Editar Página - Nosotros')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/about_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- ── Header banner ───────────────────────────────────── --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-building-columns"></i>
                </div>
                <h2>Editar Página Nosotros</h2>
            </div>
            <p class="subtitle">
                Actualiza la información institucional que se muestra en la página pública.
            </p>
        </div>

        {{-- ── Formulario ──────────────────────────────────────── --}}
        <div class="edit-form-body">
            <form method="POST" action="#">
                @csrf

                {{-- Sección: Información general --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa fa-circle-info"></i>
                        Información general
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="anio_fundacion">Año de fundación</label>
                            <input
                                type="number"
                                id="anio_fundacion"
                                name="anio_fundacion"
                                value="2000"
                                min="1900"
                                max="2099"
                                placeholder="Ej: 2000"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="num_beneficiarios">Beneficiarios</label>
                            <input
                                type="text"
                                id="num_beneficiarios"
                                name="num_beneficiarios"
                                value=""
                                placeholder="Ej: Más de 500 familias"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ubicacion">Ubicación</label>
                        <input
                            type="text"
                            id="ubicacion"
                            name="ubicacion"
                            value=""
                            placeholder="Ej: Mérida, Yucatán, México"
                        >
                    </div>

                    <div class="form-group">
                        <label for="historia">Historia</label>
                        <textarea
                            id="historia"
                            name="historia"
                            rows="5"
                            placeholder="Escribe la historia de la organización..."
                        >La organización fue fundada en el año 2000 por cinco mujeres comprometidas con el desarrollo social.</textarea>
                    </div>
                </div>

                {{-- Sección: Identidad institucional --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa fa-landmark"></i>
                        Identidad institucional
                    </div>

                    <div class="form-group">
                        <label for="mision">Misión</label>
                        <textarea
                            id="mision"
                            name="mision"
                            rows="4"
                            placeholder="Escribe la misión de la organización..."
                        >Brindar apoyo y asistencia a comunidades vulnerables mediante programas sociales.</textarea>
                    </div>

                    <div class="form-group">
                        <label for="vision">Visión</label>
                        <textarea
                            id="vision"
                            name="vision"
                            rows="4"
                            placeholder="Escribe la visión de la organización..."
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="valores">Valores</label>
                        <textarea
                            id="valores"
                            name="valores"
                            rows="3"
                            placeholder="Ej: Solidaridad, Compromiso, Respeto, Transparencia..."
                        ></textarea>
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fa fa-floppy-disk" style="margin-right:8px;"></i>
                        Guardar Cambios
                    </button>
                    <button type="button" class="btn-cancel" onclick="window.history.back()">
                        Cancelar
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/editpage/about_edit.js') }}"></script>
@endpush