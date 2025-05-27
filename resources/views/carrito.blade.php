@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')

{{-- Mensajes flash --}}
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

<section class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <h3 class="mb-4 text-center color-destacado fw-bold">
        <i class="fas fa-shopping-cart me-2"></i>Productos en el carrito
      </h3>

      @if (count($cart) > 0)
        <div class="list-group mb-4">
          @foreach ($cart as $item)
            <div class="list-group-item bg-light d-flex justify-content-between align-items-center">
              <div>
                <h5 class="mb-1 text-success">{{ $item['name'] }}</h5>
                <small class="text-muted">Cantidad: {{ $item['quantity'] }} x ${{ number_format($item['price'], 2) }}</small>
              </div>
              <div>
                <a href="{{ route('cart.remove', $item['id']) }}" class="btn btn-sm btn-outline-danger">
                  <i class="fa fa-trash"></i> Eliminar
                </a>
              </div>
            </div>
          @endforeach
        </div>

        {{-- Cálculo del precio de envío --}}
        @php
            if ($totalCost < 50) {
                $envio = 10;
                $envioTexto = '$10.00';
            } elseif ($totalCost < 100) {
                $envio = 5;
                $envioTexto = '$5.00';
            } else {
                $envio = 0;
                $envioTexto = 'Gratis';
            }
        @endphp

        <div class="mb-3 d-flex flex-column align-items-end">
          <div class="bg-light px-4 py-2 rounded mb-2" style="display: inline-block;">
            <span class="fw-bold color-destacado">
              <i class="fas fa-truck me-1"></i>
              Precio de envío: <span class="fw-bold">{{ $envioTexto }}</span>
            </span>
          </div>
          <div class="bg-light px-4 py-2 rounded mb-2" style="display: inline-block;">
            <span class="fw-bold color-destacado">
              <i class="fas fa-box me-1"></i>
              Total productos: ${{ number_format($totalCost, 2) }}
            </span>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="color-destacado fw-bold mb-0">
            Total con envío:
            <span>${{ number_format($totalCost + $envio, 2) }}</span>
          </h4>
          <a href="{{ route('pedidos.create') }}" class="btn btn-success">
            <i class="fas fa-check me-1"></i>Realizar Pedido
          </a>
        </div>

      @else
        <div class="alert alert-warning text-center" role="alert">
          No hay productos en el carrito.
        </div>
      @endif

    </div>
  </div>
</section>
@endsection
