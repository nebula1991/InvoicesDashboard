<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Tarjetas resumen
        $totalFacturado    = Factura::where('estado', '!=', 'borrador')->sum('total');
        $totalPendiente    = Factura::whereIn('estado', ['enviada', 'vencida'])->sum('total');
        $totalPagado       = Factura::where('estado', 'pagada')->sum('total');
        $facturasVencidas  = Factura::where('estado', 'vencida')->count();

        // Datos para la gráfica por estado
        $porEstado = [
            'borrador' => Factura::where('estado', 'borrador')->count(),
            'enviada'  => Factura::where('estado', 'enviada')->count(),
            'pagada'   => Factura::where('estado', 'pagada')->count(),
            'vencida'  => Factura::where('estado', 'vencida')->count(),
        ];

        // Últimas 5 facturas
        $ultimasFacturas = Factura::with('cliente')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalFacturado',
            'totalPendiente',
            'totalPagado',
            'facturasVencidas',
            'porEstado',
            'ultimasFacturas'
        ));
    }
}
