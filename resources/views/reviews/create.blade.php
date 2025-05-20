<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dejar una reseña</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto">
        <h3 class="text-lg mb-4">Producto: <strong>{{ $producto->nombre }}</strong></h3>

        <form method="POST" action="{{ route('reviews.store', $producto) }}">
            @csrf

            <label class="block mb-2">Estrellas (0 a 5)</label>
            <input type="number" name="estrellas" min="0" max="5" class="border p-2 w-full mb-4" required>

            <label class="block mb-2">Comentario</label>
            <textarea name="comentario" rows="4" class="border p-2 w-full mb-4" required></textarea>

            <button type="submit" style="color: #2563eb !important; text-decoration: underline;" class="text-sm">Enviar reseña</button>
        </form>
    </div>
</x-app-layout>
