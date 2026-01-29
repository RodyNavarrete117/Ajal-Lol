@extends('admin.dashboard')

@section('title', 'Usuarios')
<!-- //link para agregar estilos de esta área -->
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/users.css') }}">
@endpush

@section('content')
    <h2>Gestión de Usuarios</h2>
    <p>Aquí puedes crear, editar y eliminar usuarios.</p>

     <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del usuario</th>
                    <th>Asignación</th>
                    <th>Correo electrónico</th>
                    <th>Contraseña</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Leonel Sanchéz Martín</td>
                    <td>Administrador</td>
                    <td>aboutme@gmail.com</td>
                    <td>*****</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
