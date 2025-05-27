@extends('layouts.app')

@section('title', 'Confirmación del Pedido')

@section('content')
<section class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div class="card shadow-sm border-0">
        <div class="card-header bg-light rounded-top text-center">
          <h3 class="mb-0 fw-bold color-destacado">
            <i class="fas fa-clipboard-check me-2"></i>Resumen de su pedido
          </h3>
        </div>
        <div class="card-body bg-white">

          <!-- Productos -->
          <div class="mb-4">
            <h4 class="mb-3 fw-bold color-destacado text-decoration-underline">
              <i class="fas fa-box-open me-2"></i>Productos
            </h4>
            <ul class="list-group list-group-flush">
              @foreach($order->productos as $producto)
                <li class="list-group-item bg-light d-flex justify-content-between align-items-center">
                  <div>
                    <span class="fw-bold text-success">{{ $producto->nombre }}</span>
                    <span class="text-muted">(x{{ $producto->pivot->cantidad }})</span>
                  </div>
                  <div class="color-destacado fw-bold">
                    ${{ number_format($producto->pivot->precio * $producto->pivot->cantidad, 2) }}
                  </div>
                </li>
              @endforeach
            </ul>
            <p class="mt-3 fw-bold fs-5 text-end color-destacado text-decoration-underline">
              Total productos: ${{ number_format($totalProductos, 2) }}
            </p>
          </div>

          <!-- Dirección de envío -->
          <div class="mb-4">
            <h4 class="mb-3 fw-bold color-destacado text-decoration-underline">
              <i class="fas fa-map-marker-alt me-2"></i>Dirección de Envío
            </h4>
            <div class="bg-light rounded p-3">
              <span class="fw-semibold">{{ $order->direccion_envio }}</span>
            </div>
          </div>

          <!-- Coste de envío -->
          <div class="mb-4">
            <h4 class="mb-3 fw-bold color-destacado text-decoration-underline">
              <i class="fas fa-truck me-2"></i>Coste de Envío
            </h4>
            <div class="bg-light rounded p-3">
              <span class="color-destacado fw-bold">${{ number_format($order->coste_envio, 2) }}</span>
            </div>
          </div>

          <!-- Total del pedido -->
          <div class="mb-4 d-flex justify-content-between align-items-center bg-light rounded p-3">
            <h4 class="fw-bold color-destacado text-decoration-underline mb-0">
              <i class="fas fa-dollar-sign me-2"></i>Total del pedido:
            </h4>
            <h4 class="fw-bold color-destacado text-decoration-underline mb-0">
              ${{ number_format($totalProductos + $order->coste_envio, 2) }}
            </h4>
          </div>

          <div class="text-center">
            <a href="{{ route('shop') }}" class="btn btn-success px-4 fw-bold">
              <i class="fas fa-shopping-bag me-2"></i>Seguir Comprando
            </a>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
