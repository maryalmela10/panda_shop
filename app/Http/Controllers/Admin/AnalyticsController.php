<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfDay = $now->copy()->startOfDay();
        $startOfWeek = $now->copy()->startOfWeek();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfYear = $now->copy()->startOfYear();
        $startOf7DaysAgo = $now->copy()->subDays(6)->startOfDay();

        // Traer todos los pedidos confirmados desde el inicio del año
        $pedidos = Pedido::whereIn('estado', ['confirmado', 'enviado', 'entregado'])
            ->where('fecha_pedido', '>=', $startOfYear)
            ->get();

        $ventasDia = $ventasSemana = $ventasMes = $ventasAnio = 0;
        $ventasPorDia = [];

        foreach ($pedidos as $pedido) {
            $fecha = Carbon::parse($pedido->fecha_pedido);
            $monto = $pedido->total_pagado;

            if ($fecha->gte($startOfDay)) $ventasDia += $monto;
            if ($fecha->gte($startOfWeek)) $ventasSemana += $monto;
            if ($fecha->gte($startOfMonth)) $ventasMes += $monto;
            if ($fecha->gte($startOfYear)) $ventasAnio += $monto;

            // Solo para el gráfico: últimos 7 días
            if ($fecha->gte($startOf7DaysAgo)) {
                $key = $fecha->format('Y-m-d');
                $ventasPorDia[$key] = ($ventasPorDia[$key] ?? 0) + $monto;
            }
        }

        // Asegurar días vacíos en el gráfico
        for ($i = 6; $i >= 0; $i--) {
            $dia = $now->copy()->subDays($i)->format('Y-m-d');
            $ventasPorDia[$dia] = $ventasPorDia[$dia] ?? 0;
        }

        ksort($ventasPorDia);

        return view('admin.ventas', [
            'labels' => array_keys($ventasPorDia),
            'data' => array_values($ventasPorDia),
            'ventasDia' => $ventasDia,
            'ventasSemana' => $ventasSemana,
            'ventasMes' => $ventasMes,
            'ventasAnio' => $ventasAnio,
        ]);
    }
}

