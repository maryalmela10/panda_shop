@extends('layouts.app')

@section('title', 'Nuevo pedido')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light rounded-top">
                    <h3 class="mb-0 fw-bold color-destacado">
                        <i class="fas fa-shopping-cart me-2"></i>Crear nuevo pedido
                    </h3>
                </div>
                <div class="card-body bg-white">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>¡Ups!</strong> Hay algunos problemas con tus datos:<br><br>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pedidos.store') }}" method="POST">
                        @csrf

                        {{-- Método de pago --}}
                        <div class="mb-4">
                            <label for="metodo_pago" class="form-label fw-bold color-destacado">
                                <i class="fas fa-credit-card me-1"></i>Método de pago
                            </label>
                            <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                                <option value="">Selecciona un método de pago</option>
                                <option value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta de crédito/débito</option>
                                <option value="paypal" {{ old('metodo_pago') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                <option value="transferencia" {{ old('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia bancaria</option>
                                <option value="contra_reembolso" {{ old('metodo_pago') == 'contra_reembolso' ? 'selected' : '' }}>Contra reembolso</option>
                            </select>
                        </div>

                        {{-- Dirección de envío --}}
                        <div class="mb-4">
                            <label for="direccion_envio" class="form-label fw-bold color-destacado">
                                <i class="fas fa-map-marker-alt me-1"></i>Dirección de envío
                            </label>
                            <textarea name="direccion_envio" id="direccion_envio" rows="3" class="form-control" required>{{ old('direccion_envio') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success px-4 fw-bold">
                                <i class="fas fa-check me-2"></i>Confirmar pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
