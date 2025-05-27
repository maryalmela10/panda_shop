@extends('layouts.app')

@section('title', 'Editar perfil')

@section('content')
    <div class="container py-5">
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
        <h2 class="h2 mb-4 color-destacado"><i class="fas fa-user-edit me-2"></i>Editar perfil</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="dashboard-card p-4 shadow-sm">
                    {{-- Información de perfil --}}
                    <h4 class="mb-3 color-destacado"><i class="fas fa-user-circle me-2"></i>Datos personales</h4>
                    @include('profile.partials.update-profile-information-form', ['user' => $user])

                    <hr class="my-4">

                    {{-- Cambiar contraseña --}}
                    <h4 class="mb-3 color-destacado"><i class="fas fa-key me-2"></i>Cambiar contraseña</h4>
                    @include('profile.partials.update-password-form', ['user' => $user])

                    <hr class="my-4">

                    {{-- Eliminar cuenta --}}
                    <h4 class="mb-3 color-destacado"><i class="fas fa-trash me-2"></i>Eliminar cuenta</h4>
                    @include('profile.partials.delete-user-form', ['user' => $user])
                </div>
            </div>
        </div>
    </div>
@endsection
