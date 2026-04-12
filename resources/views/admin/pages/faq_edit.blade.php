@extends('admin.dashboard')

@section('title', 'Editar Página - Preguntas Frecuentes')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/faq_edit.css') }}">
@endpush

@section('content')

<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- ── Hero Header ── --}}
        <div class="edit-header">
            <div class="edit-header__bg">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="edit-header-top">
                <div class="edit-icon"><i class="fa fa-circle-question"></i></div>
                <h2>Editar Página Preguntas Frecuentes</h2>
            </div>
            <p class="subtitle">
                Administra las preguntas y respuestas más comunes sobre la organización, sus servicios y cómo colaborar.
            </p>
        </div>

        {{-- ── Form ── --}}
        <form method="POST" action="#">
            @csrf

            {{-- Campos generales ── --}}
            <div class="form-group">
                <label for="titulo_seccion">Título de la sección</label>
                <input type="text" id="titulo_seccion" name="titulo_seccion"
                    value="{{ old('titulo_seccion', 'Preguntas Frecuentes') }}"
                    placeholder="Ej: Preguntas Frecuentes" required>
                @error('titulo_seccion')<span class="field-error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción introductoria</label>
                <textarea id="descripcion" name="descripcion" rows="2"
                    placeholder="Texto introductorio para la sección...">{{ old('descripcion', 'Respuestas a las dudas más comunes sobre la organización, sus servicios y cómo colaborar.') }}</textarea>
                @error('descripcion')<span class="field-error-msg">{{ $message }}</span>@enderror
            </div>

            {{-- Label sección ── --}}
            <div class="faqs-label">
                <span class="faqs-label-text">
                    <i class="fa fa-circle-question"></i>
                    Preguntas y respuestas
                </span>
                <span class="faqs-label-hint">Haz clic en una pregunta para expandirla</span>
            </div>

            {{-- Lista de FAQs ── --}}
            <div class="faq-list" id="faqList">

                @php
                    $faqs_default = [
                        ['pregunta' => '¿Cómo puedo colaborar con la organización?', 'respuesta' => 'Puedes colaborar como voluntario, donante o aliado institucional. Contáctanos a través del formulario de contacto o directamente por correo electrónico.'],
                        ['pregunta' => '¿Dónde opera Ajal Lol A.C.?', 'respuesta' => 'Operamos en comunidades mayas del estado de Yucatán, principalmente en los municipios de Hoctún y alrededores.'],
                    ];
                @endphp

                @foreach($faqs_default as $i => $faq)
                @php $n = $i + 1; @endphp
                <div class="faq-card" id="faq-{{ $n }}" data-collapsed="true">

                    {{-- Header (siempre visible) ── --}}
                    <div class="faq-card__header" data-card="faq-{{ $n }}">
                        <span class="faq-card__drag" title="Arrastrar para reordenar">
                            <i class="fa fa-grip-vertical"></i>
                        </span>
                        <span class="faq-card__num">{{ $n }}</span>
                        <span class="faq-card__summary" id="summary-{{ $n }}">{{ $faq['pregunta'] }}</span>
                        <span class="faq-card__header-right">
                            <span class="faq-card__chevron"><i class="fa fa-chevron-down"></i></span>
                            <button type="button" class="faq-card__remove" data-faq="{{ $n }}"
                                title="Eliminar pregunta" onclick="event.stopPropagation()">
                                <i class="fa fa-xmark"></i>
                            </button>
                        </span>
                    </div>

                    {{-- Separador ── --}}
                    <div class="faq-card__divider"></div>

                    {{-- Body colapsable ── --}}
                    <div class="faq-card__body">
                        <div class="form-group">
                            <label for="pregunta_{{ $n }}">Pregunta</label>
                            <input type="text" id="pregunta_{{ $n }}" name="pregunta_{{ $n }}"
                                value="{{ old('pregunta_' . $n, $faq['pregunta']) }}"
                                placeholder="Escribe la pregunta frecuente..."
                                class="faq-pregunta-input" data-summary="summary-{{ $n }}">
                        </div>
                        <div class="form-group">
                            <label for="respuesta_{{ $n }}">Respuesta</label>
                            <textarea id="respuesta_{{ $n }}" name="respuesta_{{ $n }}" rows="3"
                                placeholder="Escribe la respuesta detallada...">{{ old('respuesta_' . $n, $faq['respuesta']) }}</textarea>
                        </div>
                    </div>

                </div>
                @endforeach

            </div>{{-- /faqList --}}

            <button type="button" class="btn-add-faq" id="btnAddFaq">
                <i class="fa fa-plus"></i>
                Agregar pregunta
            </button>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fa fa-floppy-disk"></i>
                    Guardar Cambios
                </button>
                <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/editpage/faq_edit.js') }}"></script>
@endpush