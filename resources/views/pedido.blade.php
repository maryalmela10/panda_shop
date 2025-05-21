@extends('layouts.app')

@section('title', 'Formulario de Pedido')

@section('content')
<section class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <h3 class="mb-4 text-success text-center">Complete su pedido</h3>

      <!-- Resumen del carrito -->
      @php
        $cart = session('cart', []);
        $totalProductos = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
      @endphp

      @if(count($cart) === 0)
        <div class="alert alert-warning text-center">No hay productos en el carrito.</div>
      @else
        <div class="list-group mb-4">
          @foreach($cart as $item)
            <div class="list-group-item d-flex justify-content-between">
              <div>
                <h5 class="mb-1">{{ $item['name'] }}</h5>
                <small>Cantidad: {{ $item['quantity'] }} x ${{ number_format($item['price'], 2) }}</small>
              </div>
              <div>
                ${{ number_format($item['price'] * $item['quantity'], 2) }}
              </div>
            </div>
          @endforeach
        </div>

        <p class="mb-4 fw-semibold fs-5 text-end">Total productos: ${{ number_format($totalProductos, 2) }}</p>

        <form method="POST" action="{{ route('order.store') }}">
          @csrf

          <div class="mb-3">
            <label for="metodo_pago" class="form-label">Método de pago</label>
            <select id="metodo_pago" name="metodo_pago" class="form-select" required>
              <option value="" disabled selected>Seleccione un método</option>
              <option value="tarjeta">Tarjeta de crédito</option>
              <option value="paypal">PayPal</option>
              <option value="contra_reembolso">Contra reembolso</option>
            </select>
            @error('metodo_pago')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="direccion_envio" class="form-label">Dirección de envío</label>
            <textarea id="direccion_envio" name="direccion_envio" rows="3" class="form-control" required>{{ old('direccion_envio') }}</textarea>
            @error('direccion_envio')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-success w-100">Confirmar Pedido</button>
        </form>
      @endif

    </div>
  </div>
</section>
@endsection
