@extends('layouts.app')

@section('title', 'Detalle de Producto')

@section('content')
<!-- Product Details -->
<div class="container py-5">
    <div class="row">
        <!-- Galería -->
        <div class="col-lg-5 mt-5">
            <div class="card mb-3">
                <img class="card-img img-fluid" src="{{ asset('assets/img/shop_01.jpg') }}" alt="Product image" id="product-detail">
            </div>
            <div class="row">
                @foreach (range(1, 3) as $i)
                    <div class="col-4">
                        <a href="#">
                            <img class="card-img img-fluid" src="{{ asset("assets/img/shop_0$i.jpg") }}" alt="Product thumbnail">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Detalles -->
        <div class="col-lg-7 mt-5">
            <div class="card">
                <div class="card-body">
                    <h1 class="h2">Nombre del Producto</h1>
                    <p class="h3 py-2">$250.00</p>
                    <p class="py-2">
                        <span class="list-inline-item text-warning">★ ★ ★ ★ ☆</span>
                        <span class="text-muted">(36 Reviews)</span>
                    </p>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <h6>Marca:</h6>
                        </li>
                        <li class="list-inline-item">
                            <p class="text-muted"><strong>Easy Wear</strong></p>
                        </li>
                    </ul>

                    <h6>Descripción:</h6>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod orci. Cum sociis natoque.</p>

                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <h6>Añadir color:</h6>
                        </li>
                        <li class="list-inline-item">
                            <span class="product-color-dot color-dot-red rounded-circle ml-1"></span>
                            <span class="product-color-dot color-dot-blue rounded-circle ml-1"></span>
                            <span class="product-color-dot color-dot-black rounded-circle ml-1"></span>
                            <span class="product-color-dot color-dot-light rounded-circle ml-1"></span>
                            <span class="product-color-dot color-dot-green rounded-circle ml-1"></span>
                        </li>
                    </ul>

                    <form action="#" method="GET">
                        <input type="hidden" name="product-title" value="Activewear">
                        <div class="row">
                            <div class="col-auto">
                                <ul class="list-inline pb-3">
                                    <li class="list-inline-item">Tamaño:
                                        <input type="hidden" name="product-size" id="product-size" value="S">
                                    </li>
                                    <li class="list-inline-item"><span class="btn btn-success btn-size">S</span></li>
                                    <li class="list-inline-item"><span class="btn btn-success btn-size">M</span></li>
                                    <li class="list-inline-item"><span class="btn btn-success btn-size">L</span></li>
                                    <li class="list-inline-item"><span class="btn btn-success btn-size">XL</span></li>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <label for="quantity">Cantidad</label>
                                <input type="number" name="product-quanity" id="product-quanity" value="1" class="form-control">
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col d-grid">
                                <button type="submit" class="btn btn-success btn-lg" name="submit" value="buy">Comprar</button>
                            </div>
                            <div class="col d-grid">
                                <button type="submit" class="btn btn-success btn-lg" name="submit" value="addtocard">Agregar al carrito</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
<section class="py-5">
    <div class="container">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Productos relacionados</h1>
                <p>Encuentra productos similares que te pueden interesar.</p>
            </div>
        </div>
        <div class="row">
            @foreach (range(1, 4) as $i)
            <div class="col-12 col-md-3 mb-4">
                <div class="card h-100">
                    <a href="{{ route('shop.product') }}">
                        <img src="{{ asset("assets/img/shop_0$i.jpg") }}" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <ul class="list-unstyled d-flex justify-content-between">
                            <li>
                                @for ($s = 1; $s <= 3; $s++)
                                    <i class="text-warning fa fa-star"></i>
                                @endfor
                                <i class="text-muted fa fa-star"></i>
                                <i class="text-muted fa fa-star"></i>
                            </li>
                            <li class="text-muted text-right">$240.00</li>
                        </ul>
                        <a href="{{ route('shop.product') }}" class="h2 text-decoration-none text-dark">Producto {{ $i }}</a>
                        <p class="card-text">Descripción breve del producto.</p>
                        <p class="text-muted">Reseñas (24)</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
