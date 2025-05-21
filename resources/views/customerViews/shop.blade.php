@extends('layouts.app')

@section('title', 'Tienda')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Sidebar de categorías --}}
        @include('partials.shop-sidebar', ['categories' => $categories])

        {{-- Productos --}}
        <div class="col-lg-9">
            {{-- Filtros de navegación --}}
            <div class="row">
                <div class="col-md-6 pb-4">
                    <div class="d-flex">
                        <select class="form-control">
                            <option>Featured</option>
                            <option>A to Z</option>
                            <option>Item</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Productos grid --}}
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0">
                                <img class="card-img rounded-0 img-fluid" src="{{ $product->imagen_url }}" alt="{{ $product->nombre }}">
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white" href="{{ route('shop.product', ['producto' => $product->id]) }}"><i class="far fa-heart"></i></a></li>
                                        <li><a class="btn btn-success text-white mt-2" href="{{ route('shop.product', ['producto' => $product->id]) }}"><i class="far fa-eye"></i></a></li>
                                        <li><a class="btn btn-success text-white mt-2" href="{{ route('cart.add', $product->id) }}"><i class="fas fa-cart-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('shop.product', $product->id) }}" class="h3 text-decoration-none">{{ $product->nombre }}</a>
                                <p class="text-center mb-0">${{ number_format($product->precio, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
