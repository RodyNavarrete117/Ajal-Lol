@extends('admin.dashboard')

@section('title', 'Usuarios')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/users.css') }}">
<!-- Sweet Alert 2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- CSRF Token para peticiones AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <!-- Encabezado Principal -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="page-title-group">
                <h1 class="page-title">Gestión de Usuarios</h1>
                <p class="page-description">Administra y controla los usuarios del sistema</p>
            </div>
        </div>
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon stat-icon-total">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-value" id="totalUsers">{{ $totalUsuarios }}</span>
                    <span class="stat-label">Total Usuarios</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-admin">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M12 15C15.866 15 19 11.866 19 8C19 4.13401 15.866 1 12 1C8.13401 1 5 4.13401 5 8C5 11.866 8.13401 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8.21 13.89L7 23L12 20L17 23L15.79 13.88" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-value" id="adminUsers">{{ $totalAdmins }}</span>
                    <span class="stat-label">Administradores</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-regular">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-value" id="regularUsers">{{ $totalEditores }}</span>
                    <span class="stat-label">Editores</span>
                </div>
            </div>
        </div>
    </div>

    <div class="users-header">
        <div class="header-left">
            <div class="search-box">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M17.5 17.5L13.875 13.875M15.8333 9.16667C15.8333 12.8486 12.8486 15.8333 9.16667 15.8333C5.48477 15.8333 2.5 12.8486 2.5 9.16667C2.5 5.48477 5.48477 2.5 9.16667 2.5C12.8486 2.5 15.8333 5.48477 15.8333 9.16667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="text" placeholder="Buscar por nombre o correo..." class="search-input" id="searchInput">
            </div>
        </div>
        <div class="header-right">
            <button class="btn-add-user" onclick="openAddUserModal()">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M9 3.75V14.25M3.75 9H14.25" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                Agregar nuevo usuario
            </button>
        </div>
    </div>

    <div class="table-container">
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Nombre del usuario</th>
                        <th>Correo electrónico</th>
                        <th>Asignación</th>
                        <th>Contraseña</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    @forelse($usuarios as $index => $usuario)
                    <tr data-user-id="{{ $usuario->id_usuario }}" class="user-row">
                        <td data-label="Número" class="user-number">{{ $index + 1 }}</td>
                        <td data-label="Nombre" class="user-name">{{ $usuario->nombre_usuario }}</td>
                        <td data-label="Correo" class="user-email">{{ $usuario->correo_usuario }}</td>
                        <td data-label="Asignación">
                            @if($usuario->cargo_usuario)
                                <span class="badge {{ strtolower($usuario->cargo_usuario) == 'administrador' ? 'badge-admin' : 'badge-user' }} user-role">
                                    {{ ucfirst(strtolower($usuario->cargo_usuario)) }}
                                </span>
                            @else
                                <span class="badge badge-user user-role">Sin rol</span>
                            @endif
                        </td>
                        <td data-label="Contraseña"><span class="password-text">******</span></td>
                        <td data-label="Acciones">
                            <div class="action-buttons">
                                <button class="btn-action btn-edit" onclick='editUser({{ $usuario->id_usuario }})'>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M11.3333 2.00004C11.5084 1.82494 11.716 1.68605 11.9438 1.59129C12.1716 1.49653 12.4151 1.44775 12.6609 1.44775C12.9068 1.44775 13.1502 1.49653 13.3781 1.59129C13.6059 1.68605 13.8135 1.82494 13.9886 2.00004C14.1637 2.17513 14.3026 2.38274 14.3973 2.61057C14.4921 2.83839 14.5409 3.08185 14.5409 3.32771C14.5409 3.57357 14.4921 3.81703 14.3973 4.04485C14.3026 4.27268 14.1637 4.48029 13.9886 4.65538L5.16663 13.4774L1.33329 14.6667L2.52263 10.8334L11.3333 2.00004Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Editar</span>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteUser({{ $usuario->id_usuario }})">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2 4H3.33333H14M5.33333 4V2.66667C5.33333 2.31304 5.47381 1.97391 5.72386 1.72386C5.97391 1.47381 6.31304 1.33333 6.66667 1.33333H9.33333C9.68696 1.33333 10.0261 1.47381 10.2761 1.72386C10.5262 1.97391 10.6667 2.31304 10.6667 2.66667V4M12.6667 4V13.3333C12.6667 13.687 12.5262 14.0261 12.2761 14.2761C12.0261 14.5262 11.687 14.6667 11.3333 14.6667H4.66667C4.31304 14.6667 3.97391 14.5262 3.72386 14.2761C3.47381 14.0261 3.33333 13.687 3.33333 13.3333V4H12.6667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Borrar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px;">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" style="margin: 0 auto 16px;">
                                <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p style="color: #6b7280; font-size: 16px;">No hay usuarios registrados en el sistema</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Mensaje cuando no hay resultados de búsqueda -->
        <div id="noResults" class="no-results" style="display: none;">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none">
                <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <p>No se encontraron usuarios</p>
        </div>
    </div>

    <div class="pagination">
        <button class="btn-pagination" disabled>Anterior</button>
        <span class="page-number active">1</span>
        <button class="btn-pagination">Siguiente</button>
    </div>

    <!-- Modal para Editar/Agregar Usuario -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Editar Usuario</h2>
                <button class="btn-close" onclick="closeModal()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <form id="userForm" onsubmit="saveUser(event)">
                <input type="hidden" id="userId">
                <input type="hidden" id="isEditing">
                
                <div class="form-group">
                    <label for="userName">Nombre completo *</label>
                    <input type="text" id="userName" class="form-control" placeholder="Ingrese el nombre completo" required>
                </div>

                <div class="form-group">
                    <label for="userEmail">Correo electrónico *</label>
                    <input type="email" id="userEmail" class="form-control" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="form-group">
                    <label for="userRole">Asignación *</label>
                    <select id="userRole" class="form-control" required>
                        <option value="">Seleccione un rol</option>
                        <option value="administrador">Administrador</option>
                        <option value="editor">Editor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="userPassword">Contraseña <span id="passwordRequired">*</span></label>
                    <div class="password-input-wrapper">
                        <input type="password" id="userPassword" class="form-control" placeholder="Ingrese la contraseña">
                        <button type="button" class="btn-toggle-password" onclick="togglePassword()">
                            <svg id="eyeIcon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M2.5 10C2.5 10 5 4.16667 10 4.16667C15 4.16667 17.5 10 17.5 10C17.5 10 15 15.8333 10 15.8333C5 15.8333 2.5 10 2.5 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                    <small class="form-hint" id="passwordHint">Mínimo 6 caracteres</small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn-primary" id="submitBtn">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('assets/js/users.js') }}"></script>
@endpush