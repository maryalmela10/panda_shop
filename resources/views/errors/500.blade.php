@extends('layouts.app')

@section('title', 'Error del servidor')

@section('content')
    <div class="container py-5 text-center">
        <h1 class="display-4 text-danger">500</h1>
        <p class="lead">Algo salió mal en el servidor. Intenta de nuevo más tarde.</p>
        <a href="{{ route('home') }}" class="btn btn-outline-dark mt-3">Volver al inicio</a>
    </div>
@endsection
