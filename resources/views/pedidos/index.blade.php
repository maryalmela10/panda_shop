@extends('layouts.app')

@section('title', 'Mis pedidos')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold">
            <i class="fas fa-shopping-bag me-2"></i>Mis pedidos
        </h2>

        @forelse ($pedidos as $pedido)
            @php
                $totalPedido = 0;
                foreach ($pedido->productos as $producto) {
                    $totalPedido += $producto->precio * $producto->pivot->cantidad;
                }
            @endphp
            <div class="dashboard-card mb-4 shadow-sm border-0">
                <div class="card-header bg-light d-flex flex-wrap justify-content-between align-items-center rounded-top"
                    style="border-radius: 10px 10px 0 0;">
                    <span class="fw-bold color-texto">
                        <i class="fas fa-box-open me-2"></i>Pedido #{{ $pedido->id }}
                    </span>
                    <span class="small color-texto">
                        <i class="color-texto far fa-calendar-alt me-1"></i>{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}
                    </span>
                </div>
                <div class="card-body bg-white">
                    <ul class="list-unstyled mb-0">
                        @foreach ($pedido->productos as $producto)
                            <li class="mb-3 border-bottom pb-2 d-flex flex-column flex-md-row align-items-md-center">
                                <span class="fw-bold text-success d-block flex-grow-1">
                                    <i class="fas fa-cube me-1"></i>
                                    <a href="{{ route('shop.product', ['producto' => $producto->id]) }}"
                                        class="text-decoration-none color-destacado">
                                        {{ $producto->nombre }}
                                    </a>
                                    <span class="text-muted ms-2">
                                        ({{ $producto->pivot->cantidad }}
                                        {{ $producto->pivot->cantidad == 1 ? 'unidad' : 'unidades' }})
                                    </span>
                                </span>
                                <span class="color-destacado fw-bold ms-md-auto mt-2 mt-md-0 text-end">
                                    <strong>{{ number_format($producto->precio * $producto->pivot->cantidad, 2) }}€</strong>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    {{-- Estado del pedido --}}
                    <div class="mb-3">
                        <span class="badge 
                        @switch($pedido->estado)
                            @case('pendiente') bg-warning text-white @break
                            @case('confirmado') bg-primary text-white @break
                            @case('cancelado') bg-danger text-white @break
                            @default bg-warning text-dark
                        @endswitch
                        px-3 py-2 rounded-pill fw-semibold">
                            Estado: {{ ucfirst($pedido->estado ?? 'Pendiente') }}
                        </span>
                    </div>
                    {{-- Bloque de totales igual que el carrito --}}
                    <div class="mb-3 d-flex flex-column align-items-end">
                        <div class="bg-light px-4 py-2 rounded mb-2 d-inline-block w-50 text-center">
                            <span class="fw-bold color-destacado">
                                <i class="fas fa-truck me-1"></i>
                                Precio de envío: <span class="fw-bold">{{ number_format($pedido->coste_envio, 2) }}€</span>
                            </span>
                        </div>
                        <div class="bg-light px-4 py-2 rounded mb-2 d-inline-block w-50 text-center">
                            <span class="fw-bold color-destacado">
                                <i class="fas fa-box me-1"></i>
                                Total productos: {{ number_format($totalPedido, 2) }}€
                            </span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="color-destacado fw-bold mb-0">
                            Total con envío:
                            <span>{{ number_format($totalPedido + $pedido->coste_envio, 2) }}€</span>
                        </h4>
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
