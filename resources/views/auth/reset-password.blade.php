@extends('layouts.app')
@section('title', 'Restablecer contraseña')
@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light rounded-top text-center">
                    <h3 class="mb-0 fw-bold color-destacado">
                        <i class="fas fa-key me-2"></i>Restablecer contraseña
                    </h3>
                </div>
                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label color-destacado">Correo electrónico</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email', $email ?? '') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback d-block text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Nueva contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label color-destacado">Nueva contraseña</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required minlength="8">
                            @error('password')
                                <div class="invalid-feedback d-block text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirmar contraseña -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label color-destacado">Confirmar contraseña</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                   name="password_confirmation" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold">
                                <i class="fas fa-save me-2"></i>Restablecer contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
