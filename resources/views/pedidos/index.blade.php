@extends('layouts.app')

@section('title', 'Mis pedidos')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 color-destacado fw-bold">
        <i class="fas fa-shopping-bag me-2"></i>Mis pedidos
    </h2>

    @forelse ($pedidos as $pedido)
        @php
            $totalPedido = 0;
        @endphp
        <div class="dashboard-card mb-4 shadow-sm border-0">
            <div class="card-header bg-light d-flex flex-wrap justify-content-between align-items-center rounded-top" style="border-radius: 10px 10px 0 0;">
                <span class="fw-bold color-destacado">
                    <i class="fas fa-box-open me-2"></i>Pedido #{{ $pedido->id }}
                </span>
                <span class="text-muted small">
                    <i class="far fa-calendar-alt me-1"></i>{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}
                </span>
            </div>
            <div class="card-body bg-white">
                <ul class="list-unstyled mb-0">
                    @foreach ($pedido->productos as $producto)
                        @php
                            $subtotal = $producto->precio * $producto->pivot->cantidad;
                            $totalPedido += $subtotal;
                        @endphp
                        <li class="mb-3 border-bottom pb-2 d-flex flex-column flex-md-row align-items-md-center">
                            <span class="fw-bold text-success d-block flex-grow-1">
                                <i class="fas fa-cube me-1"></i>{{ $producto->nombre }}
                                <span class="text-muted ms-2">({{ $producto->pivot->cantidad }} unidades)</span>
                            </span>
                            <span class="color-destacado fw-bold ms-md-auto mt-2 mt-md-0 text-end">
                                {{ $producto->pivot->cantidad }} x ${{ number_format($producto->precio, 2) }}
                                = <strong>${{ number_format($subtotal, 2) }}</strong>
                            </span>
                        </li>
                    @endforeach
                </ul>
                {{-- Coste de envío --}}
                <div class="d-flex justify-content-end align-items-center pt-2">
                    <div class="bg-light px-4 py-2 rounded" style="display: inline-block;">
                        <span class="fw-bold color-destacado">
                            <i class="fas fa-truck"></i>
                            Coste de envío: ${{ number_format($pedido->coste_envio, 2) }}
                        </span>
                    </div>
                </div>
                {{-- Total del pedido (productos + envío) --}}
                <div class="d-flex justify-content-end align-items-center pt-3">
                    <div class="bg-light px-4 py-2 rounded" style="display: inline-block;">
                        <span class="fw-bold color-destacado">
                            <i class="fas fa-dollar-sign"></i>
                            Total del pedido: ${{ number_format($totalPedido + $pedido->coste_envio, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert bg-light text-success border-0 shadow-sm">
            <i class="fas fa-info-circle me-2"></i>No has realizado ningún pedido aún.
        </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $pedidos->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
