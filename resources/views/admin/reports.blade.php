@extends('admin.dashboard')

@section('title', 'Informes')
//link para agregar estilos de esta área
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/reports.css') }}">
@endpush

@section('content')
    <h2>Informes del Sistema</h2>
    <p>Visualiza reportes y estadísticas.</p>
@endsection
