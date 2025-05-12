<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulario de Pedido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Complete su pedido</h3>

                    <!-- Mostrar resumen del carrito -->
                    <div class="mb-6">
                        <h4 class="text-md font-semibold mb-2">Resumen del pedido</h4>
                        <ul class="list-disc pl-6">
                            @foreach(session('cart', []) as $item)
                                <li>{{ $item['name'] }} - {{ $item['quantity'] }} x ${{ $item['price'] }}</li>
                            @endforeach
                        </ul>
                        <p class="mt-2 font-semibold">
                            Total productos: ${{ number_format(collect(session('cart'))->sum(fn($item) => $item['price'] * $item['quantity']), 2) }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('order.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="metodo_pago" class="block text-sm font-medium text-gray-700">Método de pago</label>
                            <select id="metodo_pago" name="metodo_pago" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                                <option value="tarjeta">Tarjeta de crédito</option>
                                <option value="paypal">PayPal</option>
                                <option value="contra_reembolso">Contra reembolso</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="direccion_envio" class="block text-sm font-medium text-gray-700">Dirección de envío</label>
                            <textarea id="direccion_envio" name="direccion_envio" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-700" style="color: #3182ce;">
                                Confirmar Pedido
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
