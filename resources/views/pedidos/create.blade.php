@extends('layouts.app')

@section('title', 'Nuevo pedido')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <!-- Columna izquierda: formulario de pedido -->
            <div class="col-md-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light rounded-top">
                        <h3 class="mb-0 fw-bold color-destacado">
                            <i class="fas fa-shopping-cart me-2"></i>Crear nuevo pedido
                        </h3>
                    </div>
                    <div class="card-body bg-white">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>¡Ups!</strong> Hay algunos problemas con tus datos:<br><br>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="payment-form" action="{{ route('pedidos.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- Método de pago --}}
                            <div class="mb-4">
                                <label for="metodo_pago" class="form-label fw-bold color-destacado">
                                    <i class="fas fa-credit-card me-1"></i>Método de pago
                                </label>
                                <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                                    <option value="">Selecciona un método de pago</option>
                                    <option value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta
                                        de crédito/débito</option>
                                    <option value="transferencia"
                                        {{ old('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                    <option value="contra_reembolso"
                                        {{ old('metodo_pago') == 'contra_reembolso' ? 'selected' : '' }}>Contra reembolso
                                    </option>
                                </select>
                            </div>

                            {{-- Contenedor de pago con tarjeta --}}
                            <div id="stripe-container" class="d-none">
                                <label class="form-label fw-bold">Detalles de pago con tarjeta</label>
                                <div id="card-element" class="form-control"></div>
                                <div id="card-errors" class="text-danger mt-2"></div>
                            </div>

                            {{-- Campos para pago por transferencia --}}
                            <div id="transferencia-container" class="d-none border rounded p-3 bg-light mb-4">
                                <p><strong>Titular:</strong> Panda SL</p>
                                <p><strong>Número de cuenta:</strong> ES12 3456 7890 1234 5678 9012</p>

                                <div class="mb-3">
                                    <label class="form-label">Fecha de transferencia</label>
                                    <input type="date" name="fecha_transferencia" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Sube el justificante de pago</label>
                                    <input type="file" name="justificante_pago" class="form-control">
                                </div>
                            </div>

                            {{-- Contenedor para pago contra reembolso --}}
                            <div id="reembolso-container" class="d-none mb-4">
                                <div class="alert alert-warning">Recuerda que pagarás al recibir tu pedido.</div>
                            </div>

                            {{-- Dirección de envío --}}
                            <div class="mb-4">
                                <label for="direccion_envio" class="form-label fw-bold color-destacado">
                                    <i class="fas fa-map-marker-alt me-1"></i>Dirección de envío
                                </label>
                                <textarea name="direccion_envio" id="direccion_envio" rows="3" class="form-control" required>{{ old('direccion_envio') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success px-4 fw-bold">
                                    <i class="fas fa-check me-2"></i>Confirmar pedido
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Columna derecha: resumen del carrito -->
            <div class="col-md-5">
                <div class="card border shadow-sm mb-4">
                    <div class="card-header bg-light fw-bold">
                        <i class="fas fa-receipt me-2"></i>Resumen del pedido
                    </div>
                    <div class="card-body">
                        @forelse ($cart as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <strong>{{ $item['producto']->nombre }}</strong><br>
                                    <small class="text-muted">x{{ $item['quantity'] }}</small>
                                </div>
                                <div>
                                    {{ number_format($item['price'] * $item['quantity'], 2) }}€
                                </div>
                            </div>
                        @empty
                            <p>No hay productos en el carrito.</p>
                        @endforelse

                        <hr>
                        @php
                            $envio = $totalCost < 50 ? 10 : ($totalCost < 100 ? 5 : 0);
                            $envioTexto = $envio === 0 ? 'Gratis' : '$' . number_format($envio, 2);
                        @endphp
                        <p><strong>Envío:</strong> {{ $envioTexto }}</p>
                        <p><strong>Total productos:</strong> {{ number_format($totalCost, 2) }}€</p>
                        <h5 class="fw-bold mt-3">Total con envío: {{ number_format($totalCost + $envio, 2) }}€</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const metodoSelect = document.getElementById("metodo_pago");
            const stripeContainer = document.getElementById("stripe-container");
            const transferenciaContainer = document.getElementById("transferencia-container");
            const reembolsoContainer = document.getElementById("reembolso-container");
            const form = document.getElementById("payment-form");

            const stripe = Stripe("{{ $stripePublicKey }}");
            const elements = stripe.elements();

            const card = elements.create("card", {
                hidePostalCode: true
            });
            card.mount("#card-element");

            card.on("change", (event) => {
                const errorDiv = document.getElementById("card-errors");
                errorDiv.textContent = event.error ? event.error.message : '';
            });

            function actualizarVisibilidadMetodos(metodo) {
                stripeContainer.classList.toggle("d-none", metodo !== "tarjeta");
                transferenciaContainer.classList.toggle("d-none", metodo !== "transferencia");
                reembolsoContainer?.classList.toggle("d-none", metodo !== "contra_reembolso");
            }

            function limpiarErrores() {
                const alert = document.querySelector('.alert-danger');
                if (alert) alert.remove();
            }

            metodoSelect.addEventListener("change", () => {
                limpiarErrores();
                actualizarVisibilidadMetodos(metodoSelect.value);
            });

            document.querySelectorAll('input, textarea, select').forEach(el => {
                el.addEventListener('input', limpiarErrores);
                el.addEventListener('change', limpiarErrores);
            });

            actualizarVisibilidadMetodos(metodoSelect.value);

            form.addEventListener("submit", async (event) => {
                if (metodoSelect.value === "tarjeta") {
                    event.preventDefault();

                    const {
                        setupIntent,
                        error
                    } = await stripe.confirmCardSetup(
                        "{{ $intent->client_secret }}", {
                            payment_method: {
                                card: card,
                                billing_details: {
                                    name: "{{ auth()->user()->name }}"
                                }
                            }
                        }
                    );

                    if (error) {
                        document.getElementById("card-errors").textContent = error.message;
                    } else {
                        const hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.name = "payment_method";
                        hiddenInput.value = setupIntent.payment_method;
                        form.appendChild(hiddenInput);

                        form.querySelector('button[type="submit"]').disabled = true;
                        form.submit();
                    }
                }
            });
        });
    </script>
@endpush
