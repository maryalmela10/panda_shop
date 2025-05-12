<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Carrito de Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Productos en el carrito</h3>

                    <ul class="list-disc pl-6">
                        @forelse($cart as $item)
                            <li class="mb-2">
                                {{ $item['name'] }} - {{ $item['quantity'] }} x ${{ $item['price'] }}

                                <!-- Enlace para eliminar una unidad -->
                                <a href="{{ route('cart.remove', $item['id']) }}"
                                   class="ml-4 text-red-600 hover:underline">
                                    Eliminar
                                </a>
                            </li>
                        @empty
                            <li>No hay productos en el carrito.</li>
                        @endforelse
                    </ul>

                    <hr class="my-4">

                    <p class="font-semibold">Total: ${{ number_format($totalCost, 2) }}</p>

                    <hr class="my-4">

                    <!-- Enlace para ir al formulario de pedido -->
                    @if(count($cart) > 0)
                        <a href="{{ route('order.create') }}"
                           class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-700" style="color: #3182ce;">
                            Realizar Pedido
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
