@extends('admin.dashboard')

@section('title', 'Manual')
//link para agregar estilos de esta área
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/manual.css') }}">
@endpush

@section('content')
    <h2>Manual del Administrador</h2>

    <p>
        En esta sección encontrarás una guía rápida para el uso del panel de administración.
    </p>

@endsection
