<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmación del Pedido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Resumen de su pedido</h3>

                    <!-- Mostrar resumen del carrito -->
                    <div class="mb-6">
                        <h4 class="text-md font-semibold mb-2">Productos</h4>
                        <ul class="list-disc pl-6">
                            @foreach($order->productos as $producto)
                                <li>{{ $producto->nombre }} - {{ $producto->pivot->cantidad }} x ${{ $producto->pivot->precio }}</li>
                            @endforeach
                        </ul>

                        <p class="mt-2 font-semibold">
                            Total productos: ${{ number_format($totalProductos, 2) }}
                        </p>
                    </div>

                    <!-- Mostrar dirección de envío -->
                    <div class="mb-6">
                        <h4 class="text-md font-semibold mb-2">Dirección de Envío</h4>
                        <p>{{ $order->direccion_envio }}</p>
                    </div>

                    <!-- Mostrar coste de envío -->
                    <div class="mb-6">
                        <h4 class="text-md font-semibold mb-2">Coste de Envío</h4>
                        <p>${{ number_format($order->coste_envio, 2) }}</p>
                    </div>

                    <!-- Mostrar total cost -->
                    <p class="mt-2 font-semibold">
                        Total del pedido: ${{ number_format($totalProductos + $order->coste_envio, 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
