@extends('admin.dashboard')

@section('title', 'Formulario')
<!-- //link para agregar estilos de esta área// -->
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/forms.css') }}">
@endpush

@section('content')
    <h2>Apoyo</h2>
    <p>Interesados en realizar donaciones o colaboraciones</p>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Asunto</th>
                    <th>Teléfono</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Salomón Alcocer</td>
                    <td>soysalo123@gmail.com</td>
                    <td>Me interesa colaborar</td>
                    <td>999-273-4936</td>
                    <td>15/01/2026</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
