@extends('layouts.app')

@section('title', 'Tienda')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Sidebar --}}
        @include('partials.shop-sidebar')

        {{-- Productos --}}
        <div class="col-lg-9">
            {{-- Filtros de navegación --}}
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-inline shop-top-menu pb-3 pt-1">
                        <li class="list-inline-item"><a class="h3 text-dark text-decoration-none mr-3" href="#">All</a></li>
                        <li class="list-inline-item"><a class="h3 text-dark text-decoration-none mr-3" href="#">Men's</a></li>
                        <li class="list-inline-item"><a class="h3 text-dark text-decoration-none" href="#">Women's</a></li>
                    </ul>
                </div>
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
                @foreach (range(1, 9) as $i)
                <div class="col-md-4">
                    <div class="card mb-4 product-wap rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="{{ asset("assets/img/shop_0$i.jpg") }}" alt="shop_0{{ $i }}">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                <ul class="list-unstyled">
                                    <li><a class="btn btn-success text-white" href="{{ route('shop.product') }}"><i class="far fa-heart"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="{{ route('shop.product') }}"><i class="far fa-eye"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="{{ route('shop.product') }}"><i class="fas fa-cart-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('shop.product') }}" class="h3 text-decoration-none">Oupidatat non</a>
                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                <li>M/L/X/XL</li>
                                <li class="pt-2">
                                    <span class="product-color-dot color-dot-red"></span>
                                    <span class="product-color-dot color-dot-blue"></span>
                                    <span class="product-color-dot color-dot-black"></span>
                                    <span class="product-color-dot color-dot-light"></span>
                                    <span class="product-color-dot color-dot-green"></span>
                                </li>
                            </ul>
                            <ul class="list-unstyled d-flex justify-content-center mb-1">
                                @for($s = 1; $s <= 3; $s++)
                                    <li><i class="text-warning fa fa-star"></i></li>
                                @endfor
                                <li><i class="text-muted fa fa-star"></i></li>
                                <li><i class="text-muted fa fa-star"></i></li>
                            </ul>
                            <p class="text-center mb-0">$250.00</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="row">
                <ul class="pagination pagination-lg justify-content-end">
                    <li class="page-item disabled"><a class="page-link active rounded-0 mr-3" href="#">1</a></li>
                    <li class="page-item"><a class="page-link rounded-0 mr-3 text-dark" href="#">2</a></li>
                    <li class="page-item"><a class="page-link rounded-0 text-dark" href="#">3</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Marcas --}}
<section class="bg-light py-5">
    <div class="container my-4">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Our Brands</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            </div>
            <div class="col-lg-9 m-auto tempaltemo-carousel">
                <div class="row d-flex flex-row">
                    <div class="col-1 align-self-center">
                        <a class="h1" href="#multi-item-example" role="button" data-bs-slide="prev">
                            <i class="text-light fas fa-chevron-left"></i>
                        </a>
                    </div>
                    <div class="col">
                        <div class="carousel slide" id="multi-item-example" data-bs-ride="carousel">
                            <div class="carousel-inner product-links-wap">
                                @foreach ([1, 2, 3] as $slide)
                                <div class="carousel-item {{ $slide == 1 ? 'active' : '' }}">
                                    <div class="row">
                                        @foreach (range(1, 4) as $brand)
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="{{ asset("assets/img/brand_0$brand.png") }}" alt="Brand Logo"></a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-1 align-self-center">
                        <a class="h1" href="#multi-item-example" role="button" data-bs-slide="next">
                            <i class="text-light fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection