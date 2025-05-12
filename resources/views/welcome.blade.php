@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

@include('partials.search-modal')

@include('partials.hero-carousel')

<section class="container py-5">
    <div class="row text-center pt-3">
        <div class="col-lg-6 m-auto">
            <h1 class="h1">Categorías destacadas del mes</h1>
            <p>Este mes te recomendamos nuestras harinas artesanales, chocolates premium y esencias naturales. Ingredientes esenciales para tus mejores recetas, ¡con precios especiales!</p>
        </div>
    </div>
    <div class="row">
        {{-- sacar las 3 categorías con más ventas --}} 
        @foreach ([
            ['img' => 'categ_harinas.jpg', 'title' => 'Harinas'],
            ['img' => 'categ_chocolates_coberturas.jpg', 'title' => 'Chocolates'],
            ['img' => 'categ_esencias_aromas.jpg', 'title' => 'Esencias y colorantes'],
        ] as $category)
        <div class="col-12 col-md-4 p-5 mt-3 text-center">
            <a href="#"><img src="{{ asset('assets/img/' . $category['img']) }}" class="rounded-circle img-fluid border"></a>
            <h5 class="mt-3 mb-3">{{ $category['title'] }}</h5>
            <p><a class="btn btn-success">Go Shop</a></p>
        </div>
        @endforeach
    </div>
</section>

<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Featured Product</h1>
                <p>Reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </div>
        </div>
        <div class="row">
            @foreach([
                ['img' => 'feature_prod_01.jpg', 'title' => 'Gym Weight', 'price' => 240, 'reviews' => 24],
                ['img' => 'feature_prod_02.jpg', 'title' => 'Cloud Nike Shoes', 'price' => 480, 'reviews' => 48],
                ['img' => 'feature_prod_03.jpg', 'title' => 'Summer Addides Shoes', 'price' => 360, 'reviews' => 74],
            ] as $product)
            <div class="col-12 col-md-4 mb-4">
                <div class="card h-100">
                    <a href="#">
                        <img src="{{ asset('assets/img/' . $product['img']) }}" class="card-img-top" alt="{{ $product['title'] }}">
                    </a>
                    <div class="card-body">
                        <ul class="list-unstyled d-flex justify-content-between">
                            <li>@for($i = 0; $i < 3; $i++)<i class="text-warning fa fa-star"></i>@endfor<i class="text-muted fa fa-star"></i><i class="text-muted fa fa-star"></i></li>
                            <li class="text-muted text-right">${{ $product['price'] }}.00</li>
                        </ul>
                        <a href="#" class="h2 text-decoration-none text-dark">{{ $product['title'] }}</a>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        <p class="text-muted">Reviews ({{ $product['reviews'] }})</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection