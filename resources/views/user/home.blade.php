@extends('user.dashboard')

@section('title', 'Inicio')
//link para agregar estilos de esta área
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/usercss/home.css') }}">
@endpush

@section('content')
    <h2>Inicio</h2>
    <p>Bienvenido al panel de usuario.</p>
@endsection
