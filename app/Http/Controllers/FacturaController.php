<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Factura;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facturas = Factura::with('cliente')->latest()->paginate(10);
        return view('facturas.index', compact('facturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('facturas.create', compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'       => 'required|exists:clientes,id',
            'fecha'            => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha',
            'base_imponible'   => 'required|numeric|min:0',
            'iva'              => 'required|numeric|min:0|max:100',
            'estado'           => 'required|in:borrador,enviada,pagada,vencida',
            'notas'            => 'nullable|string',
        ]);

        // Calcular total automáticamente
        $base = $request->base_imponible;
        $iva  = $request->iva;
        $total = $base + ($base * $iva / 100);

        Factura::create(array_merge($request->all(), [
            'numero' => Factura::generarNumero(),
            'total'  => $total,
        ]));

        return redirect()->route('facturas.index')
            ->with('success', 'Factura creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Factura $factura)
    {
        return view('facturas.show', compact('factura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Factura $factura)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('facturas.edit', compact('factura', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            'cliente_id'       => 'required|exists:clientes,id',
            'fecha'            => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha',
            'base_imponible'   => 'required|numeric|min:0',
            'iva'              => 'required|numeric|min:0|max:100',
            'estado'           => 'required|in:borrador,enviada,pagada,vencida',
            'notas'            => 'nullable|string',
        ]);

        $base  = $request->base_imponible;
        $iva   = $request->iva;
        $total = $base + ($base * $iva / 100);

        $factura->update(array_merge($request->all(), ['total' => $total]));

        return redirect()->route('facturas.index')
            ->with('success', 'Factura actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Factura $factura)
    {
        $factura->delete();

        return redirect()->route('facturas.index')
            ->with('success', 'Factura eliminada correctamente.');
    }

    public function pdf(Factura $factura)
    {
        $pdf = Pdf::loadView('facturas.pdf', compact('factura'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('factura-' . $factura->numero . '.pdf');
    }
}
