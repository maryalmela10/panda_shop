@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    @include('partials.search-modal')

    @include('partials.hero-carousel')

    <section class="container py-5">
        <div class="row justify-content-center text-center py-4">
            <div class="col-12 col-lg-8">
                <h2 class="display-5 fw-bold mb-3">Categorías destacadas del mes</h2>
                <p class="lead ">Este mes te recomendamos nuestras harinas artesanales, chocolates premium y esencias
                    naturales.
                    Ingredientes esenciales para tus mejores recetas, ¡con precios especiales!</p>
            </div>
        </div>
        <div class="row">
            {{-- sacar las 3 categorías con más ventas --}}
            @foreach ($categoriasMasVendidas as $category)
                <div class="col-12 col-md-4 mb-4">
                    <div class="category-card"
                        style="background-image: url('{{ asset('categorias/' . $category->imagen) }}')">
                        <div class="category-card-overlay">
                            <h5>{{ $category->nombre }}</h5>
                            <p>{{ $category->descripcion }}</p>
                            <a href="{{ route('shop', ['categoria_id' => $category->id]) }}"
                                class="btn btn-light btn-sm">Explorar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-light">
        <div class="container py-5">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h2 class="display-5 fw-bold mb-3 color-destacado">Productos más vendidos</h2>
                </div>
            </div>

            <div class="d-flex flex-nowrap overflow-auto gap-3 pb-3">
                @foreach ($productosMasVendidos as $product)
                    <div class="card" style="min-width: 220px; max-width: 220px;">
                        <a href="{{ route('shop.product', $product->id) }}">
                            <img src="{{ asset('productos/' . $product->imagen) }}" class="card-img-top"
                                alt="{{ $product->nombre }}">
                        </a>
                        <div class="card-body">
                            <ul class="list-unstyled d-flex justify-content-between">
                                <li>
                                    @for ($i = 0; $i < 4; $i++)
                                        <i class="text-warning fa fa-star"></i>
                                    @endfor
                                    <i class="text-muted fa fa-star"></i>
                                </li>
                                <li class="text-muted text-right">${{ $product->precio }}</li>
                            </ul>
                            <a href="{{ route('shop.product', $product->id) }}"
                                class="h6 text-decoration-none text-dark d-block">{{ $product->nombre }}</a>
                            <p class="card-text small">{{ Str::limit($product->descripcion, 50) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
