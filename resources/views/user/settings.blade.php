@extends('user.dashboard')

@section('title', 'Ajustes')

@push('styles')
{{-- Carga el CSS específico de la vista Ajustes del usuario --}}
<link rel="stylesheet" href="{{ asset('assets/css/usercss/settings.css') }}">
@endpush

@section('content')
<body>
    <div class="container">
        <div class="header">
            Configuración de contraseña
        </div>
        
        <div class="form-content">
            <h3 class="form-title">Cambiar contraseña:</h3>
            
            <div class="form-group">
                <label for="current">Escriba su contraseña actual:</label>
                <input type="password" id="current" placeholder="••••••••••••••••••••">
            </div>
            
            <div class="form-group">
                <label for="new">Escriba su nueva contraseña:</label>
                <input type="password" id="new" placeholder="••••••••••••••••••••">
            </div>
            
            <div class="form-group">
                <label for="confirm">Confirma su nueva contraseña:</label>
                <input type="password" id="confirm" placeholder="••••••••••••••••••••">
            </div>
            
            <button class="btn-actualizar">Actualizar</button>

            <div class="checkbox-container">
                <label class="checkbox-wrapper">
                    <input type="checkbox" id="keep_session" name="keep_session">
                    <span class="checkmark"></span>
                    <span class="checkbox-text">Mantener mi sesión iniciada en este dispositivo</span>
                </label>
            </div>
        </div>
    </div>
</body>
@endsection