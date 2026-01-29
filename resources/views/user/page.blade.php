@extends('user.dashboard')

@section('title', 'Página')

<!-- //link para agregar estilos de esta área -->
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/usercss/page.css') }}">

@section('content')
    <h2>Página</h2>
    <p>Sección de página del usuario.</p>
@endsection
