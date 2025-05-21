@extends('layouts.app')

@section('title', 'Confirmación del Pedido')

@section('content')
<section class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <h3 class="mb-4 text-success text-center">Resumen de su pedido</h3>

      <!-- Productos -->
      <div class="mb-4">
        <h4 class="mb-3">Productos</h4>
        <ul class="list-group">
          @foreach($order->productos as $producto)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>{{ $producto->nombre }} (x{{ $producto->pivot->cantidad }})</div>
              <div>${{ number_format($producto->pivot->precio * $producto->pivot->cantidad, 2) }}</div>
            </li>
          @endforeach
        </ul>
        <p class="mt-3 fw-semibold fs-5 text-end">Total productos: ${{ number_format($totalProductos, 2) }}</p>
      </div>

      <!-- Dirección de envío -->
      <div class="mb-4">
        <h4 class="mb-3">Dirección de Envío</h4>
        <p>{{ $order->direccion_envio }}</p>
      </div>

      <!-- Coste de envío -->
      <div class="mb-4">
        <h4 class="mb-3">Coste de Envío</h4>
        <p>${{ number_format($order->coste_envio, 2) }}</p>
      </div>

      <!-- Total del pedido -->
      <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4>Total del pedido:</h4>
        <h4 class="text-success">${{ number_format($totalProductos + $order->coste_envio, 2) }}</h4>
      </div>

      <div class="text-center">
        <a href="{{ route('shop') }}" class="btn btn-primary">Seguir Comprando</a>
      </div>

    </div>
  </div>
</section>
@endsection
