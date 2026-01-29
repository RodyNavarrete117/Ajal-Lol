@extends('admin.dashboard')

@section('title', 'Páginas')
<!-- //link para agregar estilos de esta área -->
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/page.css') }}">
@endpush

@section('content')
    <h2>Administración de Páginas</h2>
    <p>Gestiona las páginas del sitio web.</p>

    <ul>
        <li>Inicio</li>
        <li>Nosotros</li>
        <li>Contacto</li>
    </ul>
@endsection
