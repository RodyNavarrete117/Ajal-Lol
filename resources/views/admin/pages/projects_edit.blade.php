@extends('admin.dashboard')

@section('title', 'Editar Página - Preguntas Frecuentes')

@push('styles')
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

            <div class="form-group">
                <label for="titulo_seccion">
                    Título de la sección
                </label>
                <input
                    type="text"
                    id="titulo_seccion"
                    name="titulo_seccion"
                    value="Preguntas Frecuentes"
                    placeholder="Escribe el título de la sección..."
                    required
                >
            </div>

            <div class="form-group">
                <label for="descripcion">
                    Descripción introductoria
                </label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="3"
                    placeholder="Escribe un texto introductorio para la sección..."
                >Respuestas a las dudas más comunes sobre la organización, sus servicios y cómo colaborar.</textarea>
            </div>

            <div class="form-group">
                <label for="pregunta_1">
                    Pregunta 1
                </label>
                <input
                    type="text"
                    id="pregunta_1"
                    name="pregunta_1"
                    value=""
                    placeholder="Escribe la pregunta..."
                >
            </div>

            <div class="form-group">
                <label for="respuesta_1">
                    Respuesta 1
                </label>
                <textarea
                    id="respuesta_1"
                    name="respuesta_1"
                    rows="3"
                    placeholder="Escribe la respuesta..."
                ></textarea>
            </div>

            <div class="form-group">
                <label for="pregunta_2">
                    Pregunta 2
                </label>
                <input
                    type="text"
                    id="pregunta_2"
                    name="pregunta_2"
                    value=""
                    placeholder="Escribe la pregunta..."
                >
            </div>

            <div class="form-group">
                <label for="respuesta_2">
                    Respuesta 2
                </label>
                <textarea
                    id="respuesta_2"
                    name="respuesta_2"
                    rows="3"
                    placeholder="Escribe la respuesta..."
                ></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fa fa-floppy-disk" style="margin-right:7px;"></i>
                    Guardar Cambios
                </button>
                <button type="button" class="btn-cancel"
                    onclick="window.history.back()">
                    Cancelar
                </button>
            </div>

        </form>
    </div>
</div>

@endsection