@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')
<section class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <h3 class="mb-4 text-center fw-bold">
        <i class="fas fa-shopping-cart me-2"></i>Productos en el carrito
      </h3>

      @if (count($cartItems) > 0)
        <div class="mb-4">
          @foreach ($cartItems as $item)
            <div class="cart-item shadow rounded-4 p-3 d-flex justify-content-between align-items-center flex-wrap">
              {{-- Izquierda: Imagen y título --}}
              <div class="d-flex align-items-center gap-3 flex-grow-1">
                <img src="{{ asset('productos/' . $item['producto']->imagen) }}" alt="{{ $item['producto']->nombre }}" class="rounded" style="width: 70px; height: 70px; object-fit: cover;">
                <div>
                  <h5 class="mb-1">{{ $item['producto']->nombre }}</h5>
                  <small class="text-muted"> unitario: ${{ number_format($item['price'], 2) }}</small>
                </div>
              </div>

              {{-- Centro: Eliminar --}}
              <div class="text-center px-3">
                <a href="{{ route('cart.remove', $item['producto']->id) }}" class="btn btn-outline-danger">
                  <i class="fa fa-trash"></i>
                </a>
              </div>

              {{-- Derecha: Controles de cantidad --}}
              <div class="d-flex align-items-center gap-2">
                <a href="{{ route('cart.remove', $item['producto']->id) }}" class="btn btn-dark btn-sm">−</a>
                <span class="px-2">{{ $item['quantity'] }}</span>
                <a href="{{ route('cart.add', $item['producto']->id) }}" class="btn btn-dark btn-sm">+</a>
                <strong class="ms-3">${{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
              </div>
            </div>
          @endforeach
        </div>

        @php
            $envio = $totalCost < 50 ? 10 : ($totalCost < 100 ? 5 : 0);
            $envioTexto = $envio === 0 ? 'Gratis' : '$' . number_format($envio, 2);
        @endphp

        <div class="dashboard-card text-end">
          <p><strong><i class="fas fa-truck me-1"></i> Envío:</strong> {{ $envioTexto }}</p>
          <p><strong><i class="fas fa-box me-1"></i> Total productos:</strong> ${{ number_format($totalCost, 2) }}</p>
          <h5 class="fw-bold mt-3">Total con envío: ${{ number_format($totalCost + $envio, 2) }}</h5>
        </div>

        <div class="text-end mt-3">
          <a href="{{ route('pedidos.create') }}" class="btn bg-success text-white fw-bold shadow-sm px-4 py-2">
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

