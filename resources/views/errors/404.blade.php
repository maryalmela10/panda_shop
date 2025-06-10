@extends('layouts.app')

@section('title', 'Página no encontrada')

@section('content')
    <div class="container py-5 text-center">
        <h1 class="display-4">404</h1>
        <p class="lead">Lo sentimos, la página que buscas no existe.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">
            Volver al inicio
        </a>
    </div>
@endsection
