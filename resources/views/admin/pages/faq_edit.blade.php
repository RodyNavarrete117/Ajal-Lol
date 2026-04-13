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
                Administra las preguntas y respuestas que se muestran en la página pública.
            </p>
        </div>

        {{-- ── Form ── --}}
        {{--
            Tabla: preguntas_frecuentes
            Columnas: id_preguntasfrecuentes, id_pagina (=7), titulo_pregunta, texto_respuesta
        --}}
        <form method="POST"
              action="{{ route('admin.pages.faq.update') }}"
              id="faq-edit-form">
            @csrf
            @method('PUT')

            {{-- id_pagina fijo (slug='preguntas-frecuentes' = id 7) --}}
            <input type="hidden" name="id_pagina" value="{{ $id_pagina }}">

            {{-- Contador total para que el controller sepa cuántos procesar --}}
            <input type="hidden" name="total_faqs" id="totalFaqs" value="{{ count($preguntas) }}">

            {{-- Label sección ── --}}
            <div class="faqs-label">
                <span class="faqs-label-text">
                    <i class="fa fa-circle-question"></i>
                    Preguntas y respuestas
                </span>
                <span class="faqs-label-hint">Haz clic en una pregunta para expandirla</span>
            </div>

            {{-- ── Lista de FAQs desde BD ── --}}
            <div class="faq-list" id="faqList">

                @forelse($preguntas as $i => $pregunta)
                @php $n = $i + 1; @endphp
                <div class="faq-card" id="faq-{{ $n }}" data-collapsed="true">

                    {{-- ID de BD: >0 = UPDATE, 0 = INSERT nuevo --}}
                    <input type="hidden"
                           name="id_{{ $n }}"
                           class="faq-id-input"
                           value="{{ $pregunta->id_preguntasfrecuentes }}">

                    {{-- Header (siempre visible) ── --}}
                    <div class="faq-card__header" data-card="faq-{{ $n }}">
                        <span class="faq-card__drag" title="Arrastrar para reordenar">
                            <i class="fa fa-grip-vertical"></i>
                        </span>
                        <span class="faq-card__num">{{ $n }}</span>
                        <span class="faq-card__summary" id="summary-{{ $n }}">
                            {{ $pregunta->titulo_pregunta ?? 'Sin pregunta' }}
                        </span>
                        <span class="faq-card__header-right">
                            <span class="faq-card__chevron"><i class="fa fa-chevron-down"></i></span>
                            <button type="button" class="faq-card__remove"
                                data-faq="{{ $n }}"
                                title="Eliminar pregunta"
                                onclick="event.stopPropagation()">
                                <i class="fa fa-xmark"></i>
                            </button>
                        </span>
                    </div>

                    {{-- Separador ── --}}
                    <div class="faq-card__divider"></div>

                    {{-- Body colapsable ── --}}
                    <div class="faq-card__body">
                        <div class="form-group">
                            <label for="titulo_pregunta_{{ $n }}">Pregunta</label>
                            <input type="text"
                                   id="titulo_pregunta_{{ $n }}"
                                   name="titulo_pregunta_{{ $n }}"
                                   value="{{ old('titulo_pregunta_' . $n, $pregunta->titulo_pregunta) }}"
                                   placeholder="Escribe la pregunta frecuente..."
                                   class="faq-pregunta-input"
                                   data-summary="summary-{{ $n }}">
                        </div>
                        <div class="form-group">
                            <label for="texto_respuesta_{{ $n }}">Respuesta</label>
                            <textarea id="texto_respuesta_{{ $n }}"
                                      name="texto_respuesta_{{ $n }}"
                                      rows="3"
                                      placeholder="Escribe la respuesta detallada...">{{ old('texto_respuesta_' . $n, $pregunta->texto_respuesta) }}</textarea>
                        </div>
                    </div>

                </div>
                @empty

                {{-- Sin preguntas en BD — card vacío inicial ── --}}
                <div class="faq-card" id="faq-1" data-collapsed="false">
                    <input type="hidden" name="id_1" class="faq-id-input" value="0">
                    <div class="faq-card__header" data-card="faq-1">
                        <span class="faq-card__drag"><i class="fa fa-grip-vertical"></i></span>
                        <span class="faq-card__num">1</span>
                        <span class="faq-card__summary is-empty" id="summary-1">Sin pregunta</span>
                        <span class="faq-card__header-right">
                            <span class="faq-card__chevron"><i class="fa fa-chevron-down"></i></span>
                            <button type="button" class="faq-card__remove" data-faq="1"
                                onclick="event.stopPropagation()">
                                <i class="fa fa-xmark"></i>
                            </button>
                        </span>
                    </div>
                    <div class="faq-card__divider"></div>
                    <div class="faq-card__body">
                        <div class="form-group">
                            <label for="titulo_pregunta_1">Pregunta</label>
                            <input type="text" id="titulo_pregunta_1" name="titulo_pregunta_1"
                                placeholder="Escribe la pregunta frecuente..."
                                class="faq-pregunta-input" data-summary="summary-1">
                        </div>
                        <div class="form-group">
                            <label for="texto_respuesta_1">Respuesta</label>
                            <textarea id="texto_respuesta_1" name="texto_respuesta_1" rows="3"
                                placeholder="Escribe la respuesta detallada..."></textarea>
                        </div>
                    </div>
                </div>

                @endforelse

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