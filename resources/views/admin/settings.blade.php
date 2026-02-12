@extends('admin.dashboard')

@section('title', 'Ajustes')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/settings.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<body>
    <div class="settings-container">
        <!-- Tabs horizontales -->
        <div class="tabs-header">
            <button class="tab-btn active" data-tab="security">
                <i class="fas fa-lock"></i>
                <span>Seguridad</span>
            </button>
            <button class="tab-btn" data-tab="profile">
                <i class="fas fa-user"></i>
                <span>Perfil</span>
            </button>
            <button class="tab-btn" data-tab="notifications">
                <i class="fas fa-bell"></i>
                <span>Notificaciones</span>
            </button>
        </div>

        <div class="tabs-content">
            
            <!-- Tab: Seguridad -->
            <div class="tab-panel active" id="security">
                <div class="panel-header">
                    <h3>Cambiar contraseña</h3>
                </div>

                <form id="passwordForm" class="settings-form">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="current">Contraseña actual</label>
                            <div class="input-wrapper">
                                <input type="password" id="current" class="form-input" placeholder="Ingresa tu contraseña actual">
                                <button type="button" class="toggle-password" data-target="current">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new">Nueva contraseña</label>
                            <div class="input-wrapper">
                                <input type="password" id="new" class="form-input" placeholder="Mínimo 8 caracteres">
                                <button type="button" class="toggle-password" data-target="new">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthBar"></div>
                                </div>
                                <span class="strength-text" id="strengthText"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm">Confirmar contraseña</label>
                            <div class="input-wrapper">
                                <input type="password" id="confirm" class="form-input" placeholder="Repite la contraseña">
                                <button type="button" class="toggle-password" data-target="confirm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-check"></i> Actualizar contraseña
                    </button>
                </form>

                <div class="divider"></div>

                <div class="panel-header">
                    <h3>Sesión</h3>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Mantener sesión iniciada</div>
                        <div class="setting-desc">Permanece conectado en este dispositivo</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="keep_session" name="keep_session">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <!-- Tab: Perfil -->
            <div class="tab-panel" id="profile">
                <div class="panel-header">
                    <h3>Información personal</h3>
                </div>

                <form class="settings-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Nombre completo</label>
                            <input type="text" id="name" class="form-input" placeholder="Tu nombre">
                        </div>

                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" class="form-input" placeholder="correo@ejemplo.com">
                        </div>

                        <div class="form-group full">
                            <label for="role">Rol</label>
                            <input type="text" id="role" class="form-input" value="Administrador" disabled>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Guardar cambios
                    </button>
                </form>
            </div>

            <!-- Tab: Notificaciones -->
            <div class="tab-panel" id="notifications">
                <div class="panel-header">
                    <h3>Preferencias de notificación</h3>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Notificaciones por email</div>
                        <div class="setting-desc">Recibe actualizaciones importantes por correo</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Alerta de posibles contribuyentes</div>
                        <div class="setting-desc">Notifica cuando haya una solicitud o interés en contribuir</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Cambios en la página</div>
                        <div class="setting-desc">Recibe alertas cuando se realicen modificaciones en la plataforma</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Guardar preferencias
                </button>
            </div>

        </div>
    </div>
</body>

@push('scripts')
<script src="{{ asset('assets/js/settings.js') }}"></script>
@endpush
@endsection