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
    ['img' => 'categ_harinas.jpg', 'title' => 'Harinas', 'desc' => 'Harinas artesanales y frescas.'],
    ['img' => 'categ_chocolates_coberturas.jpg', 'title' => 'Chocolates', 'desc' => 'Coberturas premium para tus postres.'],
    ['img' => 'categ_esencias_aromas.jpg', 'title' => 'Esencias y colorantes', 'desc' => 'Colores y aromas naturales.'],
] as $category)
<div class="col-12 col-md-4 mb-4">
    <div class="category-card" style="background-image: url('{{ asset('assets/img/' . $category['img']) }}')">
        <div class="category-card-overlay">
            <h5>{{ $category['title'] }}</h5>
            <p>{{ $category['desc'] }}</p>
            <a href="{{ route('shop') }}" class="btn btn-light btn-sm">Explorar</a>
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
                <h1 class="h1">Productos más vendidos</h1>
            </div>
        </div>
        <div class="row">
            @foreach([
                ['img' => 'choco_blanco_nestle.jpg', 'title' => 'Chocolate blanco', 'price' => 240, 'reviews' => 24],
                ['img' => 'levadura_royal.jpg', 'title' => 'Levadura', 'price' => 480, 'reviews' => 48],
                ['img' => 'lapices_pasteleros.jpg', 'title' => 'Colorante', 'price' => 360, 'reviews' => 74],
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