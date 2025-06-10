@extends('layouts.app')
@section('title', 'Detalle del Pedido')

@section('content')
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary my-3">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
<div class="container py-5">
    <div class="card shadow rounded-3 border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-dark">
                <i class="fas fa-clipboard-list me-2 text-secondary"></i>Pedido #{{ $pedido->id }}
            </h4>
            <span class="badge px-3 py-2 rounded-pill fw-semibold text-white"
                style="background-color:
                    @switch($pedido->estado)
                        @case('pendiente') #ffc107; @break
                        @case('confirmado') #0d6efd; @break
                        @case('enviado') #6f42c1; @break
                        @case('entregado') #198754; @break
                        @default #adb5bd;
                    @endswitch">
                {{ ucfirst($pedido->estado) }}
            </span>
        </div>

        <div class="card-body bg-white">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-secondary mb-3"><i class="fas fa-user me-2"></i>Datos del Cliente</h5>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item"><strong>Nombre:</strong> {{ $pedido->usuario->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $pedido->usuario->email }}</li>
                        <li class="list-group-item"><strong>Dirección:</strong> {{ $pedido->direccion_envio }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5 class="text-secondary mb-3"><i class="fas fa-file-invoice-dollar me-2"></i>Detalles del Pedido</h5>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item"><strong>Método de pago:</strong> {{ ucfirst($pedido->metodo_pago) }}</li>
                        <li class="list-group-item"><strong>Fecha:</strong> {{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</li>
                        <li class="list-group-item"><strong>Coste de envío:</strong> €{{ number_format($pedido->coste_envio, 2) }}</li>
                        <li class="list-group-item"><strong>Total pagado:</strong> €{{ number_format($pedido->total_pagado, 2) }}</li>
                        @if ($pedido->metodo_pago === 'transferencia' && $pedido->justificante_pago)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Justificante:</strong>
                                <a href="{{ asset($pedido->justificante_pago) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                    Descargar
                                </a>
                            </li>
                            <li class="list-group-item"><strong>Fecha de transferencia:</strong> {{ \Carbon\Carbon::parse($pedido->fecha_transferencia)->format('d/m/Y') }}</li>
                        @endif
                    </ul>
                </div>
            </div>

            <h5 class="text-secondary mb-3"><i class="fas fa-boxes me-2"></i>Productos</h5>
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedido->productos as $producto)
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->pivot->cantidad }}</td>
                                <td>€{{ number_format($producto->precio, 2) }}</td>
                                <td>€{{ number_format($producto->pivot->cantidad * $producto->precio, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h5 class="text-secondary mb-3"><i class="fas fa-exchange-alt me-2"></i>Cambiar estado</h5>
            <form action="{{ route('admin.pedidos.update', $pedido->id) }}" method="POST" class="d-flex align-items-center gap-3">
                @csrf
                @method('PUT')
                <select name="estado" class="form-select w-auto">
                    @foreach(['pendiente', 'confirmado', 'enviado', 'entregado'] as $estado)
                        <option value="{{ $estado }}" {{ $pedido->estado == $estado ? 'selected' : '' }}>
                            {{ ucfirst($estado) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i>Actualizar</button>
            </form>
        </div>
    </div>
</div>
@endsection
