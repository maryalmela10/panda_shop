@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Dashboard de Administrador</h2>

        {{-- Botón hacia vista de analíticas --}}
        <div class="mb-4">
            <a href="{{ route('admin.ventas') }}" class="btn btn-outline-dark">
                <i class="fas fa-chart-line me-1"></i> Ver analíticas detalladas de ventas
            </a>
        </div>

        <h3 class="mb-3">Pedidos recientes</h3>
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Gestionar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->usuario->name }}</td>
                        <td>
                            <select
                                class="form-select form-select-sm cambio-estado fw-semibold text-white
                                @switch($pedido->estado)
                                    @case('pendiente') bg-warning @break
                                    @case('confirmado') bg-primary @break
                                    @case('enviado') bg-purple @break
                                    @case('entregado') bg-success @break
                                    @default bg-secondary
                                @endswitch"
                                data-id="{{ $pedido->id }}" style="width: 140px;">

                                @foreach (['pendiente', 'confirmado', 'enviado', 'entregado'] as $estado)
                                    <option value="{{ $estado }}" {{ $pedido->estado === $estado ? 'selected' : '' }}>
                                        {{ ucfirst($estado) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>€ {{ number_format($pedido->total_pagado, 2) }}</td>
                        <td>{{ $pedido->fecha_pedido->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-primary"
                                target="_blank">
                                Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mt-4">
            <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary" target="_blank">
                Ver todos los pedidos
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const coloresEstado = {
            pendiente: '#ffc107',
            confirmado: '#0d6efd',
            enviado: '#6f42c1',
            entregado: '#198754',
            default: '#adb5bd'
        };

        document.querySelectorAll('.cambio-estado').forEach(select => {
            select.addEventListener('change', function() {
                const pedidoId = this.dataset.id;
                const nuevoEstado = this.value;

                // 💡 Cambia el color del select instantáneamente
                this.style.backgroundColor = coloresEstado[nuevoEstado] || coloresEstado.default;

                fetch(`/admin/pedidos/${pedidoId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            estado: nuevoEstado
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Error al actualizar');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alertify.set('notifier', 'position', 'bottom-center');
                            alertify.success('Estado actualizado');
                            setTimeout(() => window.location.reload(), 700);
                        }
                    })
                    .catch(err => {
                        alertify.set('notifier', 'position', 'bottom-center');
                        alertify.error('Error al actualizar estado');
                        console.error(err);
                    });
            });
        });
    </script>
@endpush
