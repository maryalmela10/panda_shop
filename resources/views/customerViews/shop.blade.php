@extends('layouts.app')

@section('title', 'Tienda')

@section('content')
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
        <div class="row">
            {{-- Sidebar de categorías --}}
            @include('partials.shop-sidebar', ['categories' => $categories])

            {{-- Productos --}}
            <div class="col-lg-9">
                {{-- Botones de administración --}}
                @if(Auth::check() && Auth::user()->rol == 1)
                    <div class="d-flex justify-content-end mb-4 gap-2">
                        <a href="{{ route('admin.productos.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Añadir producto
                        </a>
                        <a href="{{ route('admin.categorias.create') }}" class="btn btn-success">
                            <i class="fas fa-folder-plus"></i> Añadir categoría
                        </a>
                    </div>
                @endif

                {{-- Filtros de navegación --}}
                <div class="row">
                    <div class="col-md-6 pb-4">
                        <div class="d-flex">
                            <form method="GET" action="{{ route('shop') }}" class="d-flex">
                                @if (request('categoria_id'))
                                    <input type="hidden" name="categoria_id" value="{{ request('categoria_id') }}">
                                @endif
                                <select name="sort" class="form-control me-2" onchange="this.form.submit()">
                                    <option value="">Ordenación por defecto</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio:
                                        ascendente</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                        Precio: descendente</option>
                                    <option value="bestsellers" {{ request('sort') == 'bestsellers' ? 'selected' : '' }}>Los
                                        más vendidos</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Productos grid --}}
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <img class="card-img rounded-0 img-fluid" src="{{ asset('productos/' . $product->imagen) }}"
                                        alt="{{ $product->nombre }}">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            @if(!Auth::check() || (Auth::check() && Auth::user()->rol == 1))
                                                {{-- Solo mostrar el icono de ver producto --}}
                                                <li>
                                                    <a class="btn btn-success text-white mt-2"
                                                        href="{{ route('shop.product', ['producto' => $product->id]) }}">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </li>
                                            @else
                                                {{-- Usuario logueado y no admin: mostrar todos los iconos --}}
                                                <li>
                                                    <a class="btn btn-success text-white"
                                                        href="{{ route('shop.product', ['producto' => $product->id]) }}">
                                                        <i class="far fa-heart"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-success text-white mt-2"
                                                        href="{{ route('shop.product', ['producto' => $product->id]) }}">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-success text-white mt-2"
                                                        href="{{ route('cart.add', $product->id) }}">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('shop.product', $product->id) }}"
                                        class="h3 text-decoration-none text-center">{{ $product->nombre }}</a>
                                    <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                        <span class="fw-bold">${{ number_format($product->precio, 2) }}</span>
                                        <span>
                                            @php
                                                $promedio = round($product->getReviewPromedio());
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa{{ $i <= $promedio ? 's' : 'r' }} fa-star text-warning"></i>
                                            @endfor
                                            <span class="text-muted small ms-1">({{ $product->reviews->count() }})</span>
                                        </span>
                                    </div>

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
