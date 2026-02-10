@extends('admin.dashboard')

@section('title', 'Usuarios')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/users.css') }}">
@endpush

@section('content')

<div class="users-container">
    <!-- Header con degradado -->
    <div class="users-header">
        <h2>Gestión de Usuarios</h2>
        <p>Aquí puedes crear, editar y eliminar usuarios</p>
    </div>

    <!-- Barra de acciones superior -->
    <div class="top-actions">
        <button class="btn-add-user">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="8.5" cy="7" r="4"/>
                <line x1="20" y1="8" x2="20" y2="14"/>
                <line x1="23" y1="11" x2="17" y2="11"/>
            </svg>
            Agregar nuevo usuario
        </button>

        <div class="search-container">
            <input type="text" class="search-input" placeholder="Buscar:">
        </div>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>N.</th>
                    <th>Nombre del usuario</th>
                    <th>Asignación</th>
                    <th>Correo electrónico</th>
                    <th>Contraseña</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id_usuario }}</td>
                    <td>{{ $usuario->nombre_usuario }}</td>
                    <td style="text-transform: capitalize;">{{ $usuario->cargo_usuario }}</td>
                    <td>{{ $usuario->correo_usuario }}</td>
                    <td>******</td>
                    <td class="actions">
                        <button class="btn-edit">Editar</button>
                        <button class="btn-delete">Borrar</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">
                        No hay usuarios registrados
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection