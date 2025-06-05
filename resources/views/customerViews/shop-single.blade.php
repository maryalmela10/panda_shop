@extends('layouts.app')

@section('title', 'Detalle de Producto')

@section('content')
    <div class="container">
        <a href="{{ route('shop') }}" class="btn btn-outline-secondary my-3">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
    <div class="container py-2">
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
    </div>
    <!-- Product Details -->
    <div class="container py-5">
        <div class="row">
            <!-- Imagen del producto -->
            <div class="col-lg-5 mt-5">
                <div class="card mb-3">
                    <img class="card-img img-fluid" src="{{ asset('productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                        id="product-detail">
                </div>
            </div>

            <!-- Detalles del producto -->
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h2">{{ $producto->nombre }}</h1>
                        <p class="h3 py-2">{{ number_format($producto->precio, 2) }}€</p>

                        <p class="py-2">
                            @php
                                $promedio = round($producto->getReviewPromedio());
                            @endphp
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
                            <span class="fw-bold" style="color: green;">En stock</span>
                            @if(Auth::check() && Auth::user()->rol != 1)
                                <form action="{{ route('cart.add', $producto->id) }}" method="GET">
                                    <div class="row pb-3">
                                        <div class="col d-grid">
                                            <button type="submit" class="btn btn-success btn-lg">Agregar al carrito</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-danger mt-3" role="alert">
                                Producto agotado
                            </div>
                        @endif


                        <!-- Botón Editar y Eliminar (solo para admins) -->
                        @if(Auth::check() && Auth::user()->rol == 1)
                            <div class="row pb-3">
                                <div class="col d-grid mb-2">
                                    <a href="{{ route('admin.productos.edit', $producto->id) }}"
                                    class="btn btn-warning btn-lg text-white mb-2">
                                        <i class="fas fa-edit"></i> Editar producto
                                    </a>
                                    <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-lg">
                                            <i class="fas fa-trash"></i> Eliminar producto
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @auth
        @if(auth()->user()->hasVerifiedEmail())
            @if(auth()->user()->rol != 1)
                @unless($producto->reviews->contains('usuario_id', auth()->id()))
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-7 col-xl-6">
                            <div class="border p-4 mb-4 rounded bg-light">
                                <h5 class="mb-3">¡Deja tu reseña!</h5>
                                <form action="{{ route('reviews.store', $producto) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Puntuación:</label>
                                        <select name="estrellas" class="form-select" required>
                                            <option value="">Selecciona una puntuación</option>
                                            @for($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}">{{ $i }} estrella{{ $i > 1 ? 's' : '' }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Comentario:</label>
                                        <textarea name="comentario" class="form-control" rows="3" placeholder="¿Qué te pareció el producto?" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">Enviar reseña</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-5 col-xl-4">
                            <div class="alert alert-info mb-4">
                                Ya has dejado tu reseña para este producto.
                            </div>
                        </div>
                    </div>
                @endunless
            @endif
        @endif
    @else
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="alert alert-warning mb-4">
                    <a href="{{ route('login') }}" class="alert-link">Inicia sesión</a> y verifica tu correo para dejar una reseña.
                </div>
            </div>
        </div>
    @endauth

    @if($producto->reviews->isNotEmpty())
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <h4 class="mb-4" style="color: var(--color-destacado); font-weight: 600;">Reseñas de clientes</h4>
                @foreach($producto->reviews as $review)
                    <div class="card mb-4 shadow-sm border-0" style="background-color: var(--color-secundario);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fw-bold" style="color: var(--color-destacado);">
                                    <i class="far fa-user me-1"></i>{{ $review->usuario->name }}
                                </div>
                                <div>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa{{ $i <= $review->estrellas ? 's' : 'r' }} fa-star text-orange-dark"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="mb-2" style="color: var(--color-texto);">{{ $review->comentario }}</p>
                            <small class="text-muted">
                                Publicado el {{ \Carbon\Carbon::parse($review->created_at)->format('d/m/Y') }}
                            </small>
                            @if($review->respuesta)
                                <div class="respuesta-admin mt-3 p-3 rounded">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-user-shield me-2" style="color: var(--color-principal);"></i>
                                        <strong style="color: var(--color-principal);">Respuesta del administrador:</strong>
                                    </div>
                                    <p class="mb-0" style="color: var(--color-texto);">{{ $review->respuesta }}</p>
                                </div>
                            @elseif(Auth::check() && Auth::user()->rol == 1)
                                <form action="{{ route('reviews.responder', [$producto, $review]) }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="mb-2">
                                        <textarea name="respuesta" class="form-control" rows="2" placeholder="Escribe tu respuesta..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Responder</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="alert alert-secondary" style="background-color: var(--color-fondo-secundario); color: var(--color-texto); border: none;">
                    Este producto aún no tiene reseñas.
                </div>
            </div>
        </div>
    @endif

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
                                <img src="{{ asset('productos/' . $rel->imagen) }}" class="card-img-top" alt="{{ $rel->nombre }}">
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
                                    <li class="text-muted text-right">{{ number_format($rel->precio, 2) }}€</li>
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
