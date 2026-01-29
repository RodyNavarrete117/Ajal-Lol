@extends('user.dashboard')

@section('title', 'Formularios')
<!-- //link para agregar estilos de esta área -->
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/usercss/home.css') }}">
@endpush

@section('content')
    <h2>Formularios</h2>
    <p>Gestión básica de formularios.</p>
@endsection
