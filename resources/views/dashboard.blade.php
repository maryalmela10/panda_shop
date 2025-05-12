<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

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
                        @forelse ($products as $product)
                            <li class="mb-1">{{ $product->nombre }} - ${{ $product->precio }}</li>
                        @empty
                            <li>No hay productos disponibles en esta categoría.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
