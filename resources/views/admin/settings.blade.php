@extends('admin.dashboard')

@section('title', 'Ajustes')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/settings.css') }}">
@endpush

@section('content')
    <h2>Configuración</h2>
    <p>Ajustes generales del sistema.</p>
@endsection
