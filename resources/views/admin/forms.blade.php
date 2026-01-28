@extends('admin.dashboard')

@section('title', 'Formularios')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/forms.css') }}">
@endpush

@section('content')
    <h2>Formularios</h2>
    <p>Gestión básica de formularios.</p>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Formulario</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Registro</td>
                    <td><span class="badge active">Activo</span></td>
                    <td>2026-01-28</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Contacto</td>
                    <td><span class="badge inactive">Inactivo</span></td>
                    <td>2026-01-27</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
