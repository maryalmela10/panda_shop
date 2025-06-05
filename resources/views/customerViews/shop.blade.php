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
                @if (Auth::check() && Auth::user()->rol == 1)
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
                        <div class="col-md-4 ">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <a href="{{ route('shop.product', ['producto' => $product->id]) }}"
                                        class="product-image-link">
                                        <img class="card-img rounded-0 img-fluid product-hover-img"
                                            src="{{ asset('productos/' . $product->imagen) }}"
                                            alt="{{ $product->nombre }}">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('shop.product', $product->id) }}"
                                        class="h3 text-decoration-none text-center">{{ $product->nombre }}</a>
                                    <div class="text-center mb-2">
                                        <div class="fw-bold mb-1">{{ number_format($product->precio, 2) }}€</div>
                                        <div>
                                            @php
                                                $promedio = round($product->getReviewPromedio());
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa{{ $i <= $promedio ? 's' : 'r' }} fa-star text-warning"></i>
                                            @endfor
                                            <span class="text-muted small ms-1">({{ $product->reviews->count() }})</span>
                                        </div>
                                    </div>


                                    {{-- Botón agregar al carrito (fuera de la imagen) solo si no es admin --}}
                                    @php
                                        $esAdmin = Auth::check() && Auth::user()->rol == 1;
                                    @endphp

                                    @if (!$esAdmin)
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-success text-white mt-2"
                                                href="{{ route('cart.add', $product->id) }}">
                                                <i class="fas fa-cart-plus me-1"></i> Añadir al carrito
                                            </a>
                                        </div>
                                    @endif
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
