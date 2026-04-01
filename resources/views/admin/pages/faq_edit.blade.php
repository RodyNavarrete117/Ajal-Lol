@extends('admin.dashboard')

@section('title', 'Editar Página - Preguntas Frecuentes')

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap">
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/faq_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- Header --}}
        <div class="edit-header">
            <div class="edit-header-top">
                <div class="edit-icon">
                    <i class="fa fa-circle-question"></i>
                </div>
                <h2>Editar Página Preguntas Frecuentes</h2>
            </div>
            <p class="subtitle">
                Administra las preguntas y respuestas más comunes sobre la organización, sus servicios y cómo colaborar.
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="#">
            @csrf

            {{-- Campos generales --}}
            <div class="form-group">
                <label for="titulo_seccion">Título de la sección</label>
                <input
                    type="text"
                    id="titulo_seccion"
                    name="titulo_seccion"
                    value="{{ old('titulo_seccion', 'Preguntas Frecuentes') }}"
                    placeholder="Escribe el título de la sección..."
                    required
                >
                @error('titulo_seccion')
                    <span class="field-error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción introductoria</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="3"
                    placeholder="Escribe un texto introductorio para la sección..."
                >{{ old('descripcion', 'Respuestas a las dudas más comunes sobre la organización, sus servicios y cómo colaborar.') }}</textarea>
                @error('descripcion')
                    <span class="field-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Divisor --}}
            <div class="faqs-label">
                <span class="faqs-label-text">Preguntas y respuestas</span>
                <span class="faqs-label-hint">PNG, JPG, SVG · Máx. 2MB</span>
            </div>

            {{-- Lista de pares pregunta/respuesta --}}
            <div class="faq-list" id="faqList">

                @for ($i = 1; $i <= 2; $i++)
                <div class="faq-card" id="faq-{{ $i }}">

                    <div class="faq-card__drag" title="Arrastrar para reordenar">
                        <i class="fa fa-grip-vertical"></i>
                    </div>

                    <div class="faq-card__num">{{ $i }}</div>

                    <div class="faq-card__fields">
                        <div class="form-group">
                            <label for="pregunta_{{ $i }}">Pregunta</label>
                            <input
                                type="text"
                                id="pregunta_{{ $i }}"
                                name="pregunta_{{ $i }}"
                                value="{{ old('pregunta_' . $i) }}"
                                placeholder="Escribe la pregunta frecuente..."
                            >
                        </div>
                        <div class="form-group">
                            <label for="respuesta_{{ $i }}">Respuesta</label>
                            <textarea
                                id="respuesta_{{ $i }}"
                                name="respuesta_{{ $i }}"
                                rows="3"
                                placeholder="Escribe la respuesta detallada..."
                            >{{ old('respuesta_' . $i) }}</textarea>
                        </div>
                    </div>

                    <button type="button" class="faq-card__remove" data-faq="{{ $i }}" title="Eliminar pregunta">
                        <i class="fa fa-xmark"></i>
                    </button>

                </div>
                @endfor

            </div>

            {{-- Botón agregar --}}
            <button type="button" class="btn-add-faq" id="btnAddFaq">
                <i class="fa fa-plus"></i>
                Agregar pregunta
            </button>

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

@push('scripts')
<script src="{{ asset('assets/js/editpage/faq_edit.js') }}"></script>
@endpush