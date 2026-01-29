@extends('user.dashboard')

@section('title', 'Informe')

<!-- //link para agregar estilos de esta área -->
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/usercss/reports.css') }}">

@section('content')
    <h2>Informe</h2>
    <p>Visualización de informes.</p>
@endsection
