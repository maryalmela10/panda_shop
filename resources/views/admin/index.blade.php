@extends('layouts.app')
@section('title', 'Gestión de Pedidos')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <h4 class="mb-0">Todos los Pedidos</h4>
            </div>

            <div class="card-body">
                {{-- Buscador moderno --}}
                <form method="GET" class="row gy-2 gx-3 align-items-center mb-4">
                    <div class="col-md-3">
                        <input type="text" name="busqueda" class="form-control" placeholder="Buscar por ID, nombre o fecha"
                            value="{{ request('busqueda') }}">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-dark">Buscar</button>
                        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>

                {{-- Tabla de pedidos --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Método</th>
                                <th>Gestionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->id }}</td>
                                    <td>{{ $pedido->usuario->name }}</td>
                                    <td>{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</td>
                                    <td>€ {{ number_format($pedido->total_pagado, 2) }}</td>
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
                                                <option value="{{ $estado }}"
                                                    {{ $pedido->estado === $estado ? 'selected' : '' }}>
                                                    {{ ucfirst($estado) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{ ucfirst($pedido->metodo_pago) }}</td>
                                    <td>
                                        <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No se encontraron pedidos.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-3">
                    {{ $pedidos->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.querySelectorAll('.cambio-estado').forEach(select => {
            select.addEventListener('change', function() {
                const pedidoId = this.dataset.id;
                const nuevoEstado = this.value;

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
                            setTimeout(() => window.location.reload(), 700); // ⚠️ Recarga 
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
