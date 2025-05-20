@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')
<section class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <h3 class="mb-4 text-center text-success">Productos en el carrito</h3>

      @if (count($cart) > 0)
        <div class="list-group mb-4">
          @foreach ($cart as $item)
            <div class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <h5 class="mb-1">{{ $item['name'] }}</h5>
                <small>Cantidad: {{ $item['quantity'] }} x ${{ number_format($item['price'], 2) }}</small>
              </div>
              <div>
                <a href="{{ route('cart.remove', $item['id']) }}" class="btn btn-sm btn-outline-danger">
                  <i class="fa fa-trash"></i> Eliminar
                </a>
              </div>
            </div>
          @endforeach
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4>Total: <span class="text-success">${{ number_format($totalCost, 2) }}</span></h4>
          <a href="{{ route('order.create') }}" class="btn btn-success">
            Realizar Pedido
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