@extends('admin.dashboard')

@section('title', 'Usuarios')
//link para agregar estilos de esta área
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/users.css') }}">
@endpush

@section('content')
    <h2>Gestión de Usuarios</h2>
    <p>Aquí puedes crear, editar y eliminar usuarios.</p>
@endsection
