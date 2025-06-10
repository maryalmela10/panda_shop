@extends('layouts.app')

@section('title', 'Servicio no disponible')

@section('content')
    <div class="container py-5 text-center">
        <h1 class="display-4 text-muted">503</h1>
        <p class="lead">Estamos realizando tareas de mantenimiento. Vuelve pronto.</p>
        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Ir al inicio</a>
    </div>
@endsection
