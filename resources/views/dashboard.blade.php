<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <!-- Carrito -->
            <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M4 7h16M5 11h14M6 15h12M7 19h10" />
                </svg>
                <span class="ml-2">Carrito</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    {{-- Mensaje de éxito --}}
                    @if (session('success'))
                        <div style="color: #047857 !important; background-color: #d1fae5; border-color: #34d399 !important;" class="px-4 py-3 rounded mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                   @if (session('error'))
                        <div style="color: #b91c1c !important; background-color: #fee2e2; border-color: #f87171 !important;" class="px-4 py-3 rounded mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif


                    <hr class="my-4">

                    <h2 class="text-lg font-semibold mb-4">Filtrar productos por categoría</h2>

                    <form method="GET" action="{{ route('dashboard') }}">
                        <select name="categoria_id" onchange="this.form.submit()" class="border rounded p-2">
                            <option value="">-- Todas las categorías --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (isset($selectedCategory) && $selectedCategory == $category->id) ? 'selected' : '' }}>
                                    {{ $category->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <hr class="my-4">

                    <h3 class="text-md font-semibold mb-2">Productos</h3>
                    <ul class="list-disc pl-6">
                        @foreach($products as $product)
                            <div>
                                <h4>
                                    <a href="{{ route('productos.show', $product) }}" style="color: #2563eb !important;" class="hover:underline">
                                        {{ $product->nombre }}
                                    </a>
                                </h4>

                                <p>${{ $product->precio }}</p>
                                <p>
                                    Calificación:
                                    {{ $product->reviews_avg_estrellas ? number_format($product->reviews_avg_estrellas, 1) : 'Sin calificaciones' }} / 5
                                </p>
                                <a href="{{ route('cart.add', $product->id) }}" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-700" style="color: #3182ce;">
                                    Agregar al carrito
                                </a>
                                <a href="{{ route('reviews.create', $product) }}" style="color: #2563eb !important; text-decoration: underline;" class="text-sm">
                                    Escribir una reseña
                                </a>

                            </div>
                            <br>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
