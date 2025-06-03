@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4 class="h4">Iniciar sesión</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Username or Email -->
                        <div class="mb-3">
                            <x-input-label for="login" :value="__('Correo electrónico o usuario')" />
                            <x-text-input id="login" class="form-control" type="text" name="login" :value="old('login')" required autofocus />
                            <x-input-error :messages="$errors->get('login')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <x-input-label for="password" :value="__('Contraseña')" />
                            <x-text-input id="password" class="form-control" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="d-flex justify-content-between">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            @endif
                            <x-primary-button class="btn btn-success">
                                {{ __('Iniciar sesión') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <span class="text-muted">¿No tienes cuenta?</span>
                        <a href="{{ route('register') }}" class="fw-bold text-success ms-1">
                            Regístrate
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
