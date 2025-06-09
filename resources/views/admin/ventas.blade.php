@extends('layouts.app')

@section('title', 'Ventas')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Resumen de Ventas</h2>

        {{-- Tarjetas de resumen --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Hoy</h5>
                        <p class="fs-4 mb-0">€ {{ number_format($ventasDia, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Semana</h5>
                        <p class="fs-4 mb-0">€ {{ number_format($ventasSemana, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Mes</h5>
                        <p class="fs-4 mb-0">€ {{ number_format($ventasMes, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Año</h5>
                        <p class="fs-4 mb-0">€ {{ number_format($ventasAnio, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráfico de barras --}}
        <h4 class="mb-3">Historial de los últimos 7 días</h4>
        <canvas id="ventasChart" height="100"></canvas>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('ventasChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Ventas (€)',
                    data: {!! json_encode($data) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 20
                        }
                    }
                }
            }
        });
    </script>
@endpush
