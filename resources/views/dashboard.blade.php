@extends('layouts.app')

@section('title', 'Mi cuenta')

@section('content')
<div class="container py-5">
    <h2 class="h2 mb-4">Panel de cliente</h2>

    {{-- Resumen visual del usuario --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="dashboard-card">
                <h4>Pedidos</h4>
                <p>12 pedidos activos</p>
                <a href="{{ route('dashboard.orders') }}" class="btn btn-success btn-sm mt-2">Ver pedidos</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <h4>Perfil</h4>
                <p>{{ Auth::user()->name }}</p>
                <a href="{{ route('dashboard.profile') }}" class="btn btn-success btn-sm mt-2">Editar perfil</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <h4>Carrito</h4>
                <p>{{ $carritoCantidad ?? 0 }} productos</p>
                <a href="{{ route('cart.index') }}" class="btn btn-success btn-sm mt-2">Ir al carrito</a>
            </div>
        </div>
    </div>

    {{-- Tabla de historial de pedidos recientes --}}
    <div class="row mt-4">
        <div class="col-12">
            <h5>Historial de pedidos recientes</h5>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>00123</td>
                        <td>10/05/2025</td>
                        <td>Pendiente</td>
                        <td>$150.00</td>
                    </tr>
                    <tr>
                        <td>00122</td>
                        <td>05/05/2025</td>
                        <td>Completado</td>
                        <td>$89.99</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection