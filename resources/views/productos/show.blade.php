<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalles del producto
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded p-6 mb-6">
            <h3 class="text-2xl font-bold mb-2">{{ $producto->nombre }}</h3>
            <p class="text-gray-600 mb-2">Precio: ${{ $producto->precio }}</p>
            <p class="text-gray-800">{{ $producto->descripcion }}</p>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h4 class="text-xl font-semibold mb-4">Reseñas</h4>

            @if ($producto->reviews->isEmpty())
                <p class="text-gray-500">Este producto aún no tiene reseñas.</p>
            @else
                @foreach ($producto->reviews as $review)
                    <div class="border-b py-4">
                        <p class="text-yellow-500">
                            @for ($i = 0; $i < 5; $i++)
                                {{ $i < $review->estrellas ? '★' : '☆' }}
                            @endfor
                        </p>
                        <p class="text-gray-700 italic mb-1">"{{ $review->comentario }}"</p>
                        <p class="text-sm text-gray-500">Por: {{ $review->usuario->name }} el {{ \Carbon\Carbon::parse($review->fecha)->format('d/m/Y') }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
