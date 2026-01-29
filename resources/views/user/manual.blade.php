@extends('user.dashboard')

@section('title', 'Manual')
//link para agregar estilos de esta área
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/usercss/manual.css') }}">
@section('content')
    <h2>Manual</h2>
    <p>Manual de uso para el usuario.</p>
@endsection
