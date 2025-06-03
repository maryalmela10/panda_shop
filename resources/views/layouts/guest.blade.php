@extends('layouts.app')

@section('title', 'Recuperar contraseña')

@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light rounded-top text-center">
                    <h3 class="mb-0 fw-bold color-destacado">
                        <i class="fas fa-unlock-alt me-2"></i>¿Olvidaste tu contraseña?
                    </h3>
                </div>
                <div class="card-body bg-white">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif

                    <p class="mb-4 text-muted text-center">
                        Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold color-destacado">
                                <i class="fas fa-envelope me-2"></i>Correo electrónico
                            </label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback d-block text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold">
                                <i class="fas fa-paper-plane me-2"></i>Enviar enlace de recuperación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="color-destacado fw-bold text-decoration-none">
                    <i class="fas fa-arrow-left me-2"></i>Volver al inicio de sesión
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
