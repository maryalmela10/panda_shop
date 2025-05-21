@extends('layouts.app')

@section('title', 'Verificar correo electrónico')

@section('content')
<div class="container py-5">
    <h2 class="h2 mb-4">Verificación de correo electrónico</h2>
    
    <div class="row">
        <div class="col-md-8">
            <div class="dashboard-card">
                <h4>Verifica tu dirección de correo electrónico</h4>
                
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <p class="mb-3">Antes de continuar, por favor revisa tu correo electrónico para encontrar el enlace de verificación.</p>
                <p>Si no has recibido el correo electrónico:</p>
                
                <form method="POST" action="{{ route('verification.resend') }}" class="mt-3">
                    @csrf
                    
                    @if (Auth::check())
                        <button type="submit" class="btn btn-success">
                            Reenviar correo de verificación
                        </button>
                    @else
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            Enviar enlace de verificación
                        </button>
                    @endif
                </form>
                
                <div class="mt-4">
                    <p>Una vez que verifiques tu correo electrónico, podrás acceder a todas las funcionalidades de tu cuenta.</p>
                    <p class="small text-muted">Verifica tu carpeta de spam si no encuentras el correo de verificación.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection