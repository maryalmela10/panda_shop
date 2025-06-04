@extends('layouts.app')

@section('title', 'Mi cuenta')

@section('content')
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
        <h2 class="h2 mb-4">Panel de cliente</h2>

        {{-- Resumen visual del usuario --}}
        <div class="row mb-4 justify-content-center">
            @if(!(Auth::check() && Auth::user()->rol == 1))
                <div class="col-md-4">
                    <div class="dashboard-card">
                        <h4>Pedidos</h4>
                        <p>{{ count($pedidos) }} pedidos</p>
                        <a href="{{ route('pedidos.index') }}" class="btn btn-success btn-sm mt-2">Ver pedidos</a>
                    </div>
                </div>
            @endif
            <div class="col-md-4">
                <div class="dashboard-card">
                    <h4>Perfil</h4>
                    <p>{{ Auth::user()->name }}</p>
                    <a href="{{ route('dashboard.profile') }}" class="btn btn-success btn-sm mt-2">Editar perfil</a>
                </div>
            </div>
            @if(!(Auth::check() && Auth::user()->rol == 1))
                <div class="col-md-4">
                    <div class="dashboard-card">
                        <h4>Carrito</h4>
                        <p>{{ $carritoCantidad ?? 0 }} productos</p>
                        <a href="{{ route('cart.index') }}" class="btn btn-success btn-sm mt-2">Ir al carrito</a>
                    </div>
                </div>
            @endif
        </div>

        {{-- Tabla de historial de pedidos recientes --}}
        @if(!(Auth::check() && Auth::user()->rol == 1))
        <div class="row mt-4">
            <div class="col-12">
                <h5>Historial de pedidos recientes</h5>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Nº pedido</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedidos as $pedido)
                            <tr>
                                <td>{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($pedido->estado ?? 'Pendiente') }}</td>
                                <td>${{ number_format($pedido->total_pagado, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No tienes pedidos recientes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
@endsection
