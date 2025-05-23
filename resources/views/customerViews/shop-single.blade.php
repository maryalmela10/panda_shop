@extends('layouts.app')

@section('title', 'Detalle de Producto')

@section('content')
    <!-- Product Details -->
    <div class="container py-5">
        <div class="row">
            <!-- Imagen del producto -->
            <div class="col-lg-5 mt-5">
                <div class="card mb-3">
                    <img class="card-img img-fluid" src="{{ asset('assets/img/' . $producto->imagen_url) }}" alt="{{ $producto->nombre }}"
                        id="product-detail">
                </div>
            </div>

            <!-- Detalles del producto -->
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h2">{{ $producto->nombre }}</h1>
                        <p class="h3 py-2">${{ number_format($producto->precio, 2) }}</p>

                        <p class="py-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa{{ $i <= $promedio ? 's' : 'r' }} fa-star text-warning"></i>
                            @endfor
                            <span class="text-muted">({{ $producto->reviews->count() }} Reseñas)</span>
                        </p>

                        <h6>Descripción:</h6>
                        <p>{{ $producto->descripcion }}</p>

                        <p><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
                        <p><strong>Ventas:</strong> {{ $producto->num_ventas }}+</p>

                        @if ($disponible)
                            <form action="{{ route('cart.add', $producto->id) }}" method="GET">
                                <div class="row pb-3">
                                    <div class="col d-grid">
                                        <button type="submit" class="btn btn-success btn-lg">Agregar al carrito</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-danger mt-3" role="alert">
                                Producto agotado
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos relacionados -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center pt-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1">Productos relacionados</h1>
                    <p>Encuentra productos similares que te pueden interesar.</p>
                </div>
            </div>
            <div class="row">
                @forelse ($relacionados as $rel)
                    <div class="col-12 col-md-3 mb-4">
                        <div class="card h-100">
                            <a href="{{ route('shop.product', ['producto' => $rel->id]) }}">
                                <img src="{{ asset('assets/img/' . $rel->imagen_url) }}" class="card-img-top" alt="{{ $rel->nombre }}">
                            </a>
                            <div class="card-body">
                                <ul class="list-unstyled d-flex justify-content-between">
                                    <li>
                                        @for ($s = 1; $s <= round($rel->getReviewPromedio()); $s++)
                                            <i class="text-warning fa fa-star"></i>
                                        @endfor
                                        @for ($s = round($rel->getReviewPromedio()) + 1; $s <= 5; $s++)
                                            <i class="text-muted fa fa-star"></i>
                                        @endfor
                                    </li>
                                    <li class="text-muted text-right">${{ number_format($rel->precio, 2) }}</li>
                                </ul>
                                <a href="{{ route('shop.product', ['producto' => $rel->id]) }}"
                                    class="h2 text-decoration-none text-dark">
                                    {{ $rel->nombre }}
                                </a>
                                <p class="card-text">{{ Str::limit($rel->descripcion, 50) }}</p>
                                <p class="text-muted">Reseñas ({{ $rel->reviews->count() }})</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center">
                        <p>No hay productos relacionados.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
