@extends('layouts.app')

@section('title', 'Sesión expirada')

@section('content')
    <div class="container py-5 text-center">
        <h1 class="display-4 text-secondary">419</h1>
        <p class="lead">Tu sesión ha expirado por inactividad. Por favor, vuelve a intentarlo.</p>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-3">Volver</a>
    </div>
@endsection
