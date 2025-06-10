@extends('layouts.app')

@section('title', 'Acceso denegado')

@section('content')
    <div class="container py-5 text-center">
        <h1 class="display-4 text-danger">403</h1>
        <p class="lead">No tienes permiso para acceder a esta página.</p>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-3">Volver</a>
    </div>
@endsection
