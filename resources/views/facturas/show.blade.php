@extends('layouts.app')

@section('content')

<div class="page-header fade-in fade-in-1">
    <h1><i class="bi bi-receipt"></i> {{ $factura->numero }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('facturas.enviarForm', $factura) }}" class="btn btn-primary">
            <i class="bi bi-envelope"></i> Enviar
        </a>
        <a href="{{ route('facturas.pdf', $factura) }}" class="btn btn-stone" target="_blank">
            <i class="bi bi-file-pdf"></i> PDF
        </a>
        <a href="{{ route('facturas.edit', $factura) }}" class="btn btn-stone">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('facturas.index') }}" class="btn btn-stone">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row g-3">

    {{-- Info principal --}}
    <div class="col-md-8">
        <div class="card fade-in fade-in-2">
            <div class="card-body p-4">

                {{-- Cabecera factura --}}
                <div class="d-flex justify-content-between align-items-start mb-4 pb-3 border-bottom">
                    <div>
                        <div class="small text-muted mb-1">Cliente</div>
                        <div class="fw-bold fs-5">{{ $factura->cliente->nombre }}</div>
                        <div class="small text-muted">{{ $factura->cliente->email }}</div>
                        @if($factura->cliente->nif)
                        <div class="small text-muted">NIF: {{ $factura->cliente->nif }}</div>
                        @endif
                        @if($factura->cliente->direccion)
                        <div class="small text-muted">{{ $factura->cliente->direccion }}</div>
                        @endif
                    </div>
                    <div class="text-end">
                        @php $badges = ['borrador'=>'secondary','enviada'=>'primary','pagada'=>'success','vencida'=>'danger']; @endphp
                        <span class="badge bg-{{ $badges[$factura->estado] }} mb-2">{{ ucfirst($factura->estado) }}</span>
                        <div class="small text-muted">Emisión: <strong>{{ $factura->fecha->format('d/m/Y') }}</strong></div>
                        @if($factura->fecha_vencimiento)
                        <div class="small text-muted">Vence: <strong>{{ $factura->fecha_vencimiento->format('d/m/Y') }}</strong></div>
                        @endif
                    </div>
                </div>

                {{-- Tabla importes --}}
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th class="text-end">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Servicios profesionales</td>
                            <td class="text-end">{{ number_format($factura->base_imponible, 2, ',', '.') }} €</td>
                        </tr>
                        <tr>
                            <td class="text-muted">IVA ({{ number_format($factura->iva, 0) }}%)</td>
                            <td class="text-end text-muted">{{ number_format($factura->base_imponible * $factura->iva / 100, 2, ',', '.') }} €</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="fw-bold fs-5 border-top border-2">TOTAL</td>
                            <td class="fw-bold fs-5 text-end border-top border-2"
                                style="color:var(--color-primary);">
                                {{ number_format($factura->total, 2, ',', '.') }} €
                            </td>
                        </tr>
                    </tfoot>
                </table>

                @if($factura->notas)
                <div class="mt-3 p-3 rounded" style="background:var(--color-stone);border-left:3px solid var(--color-accent);">
                    <div class="small text-muted mb-1">Notas</div>
                    {{ $factura->notas }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Panel lateral --}}
    <div class="col-md-4">

        {{-- Resumen --}}
        <div class="card fade-in fade-in-3 mb-3">
            <div class="card-header bg-white">
                <i class="bi bi-info-circle me-2" style="color:var(--color-primary);"></i>Resumen
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted small">Base imponible</span>
                    <span class="fw-semibold">{{ number_format($factura->base_imponible, 2, ',', '.') }} €</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted small">IVA {{ number_format($factura->iva, 0) }}%</span>
                    <span class="fw-semibold">{{ number_format($factura->base_imponible * $factura->iva / 100, 2, ',', '.') }} €</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold fs-5" style="color:var(--color-primary);">
                        {{ number_format($factura->total, 2, ',', '.') }} €
                    </span>
                </div>
            </div>
        </div>

        {{-- Acciones rápidas --}}
        <div class="card fade-in fade-in-4">
            <div class="card-header bg-white">
                <i class="bi bi-lightning me-2" style="color:var(--color-primary);"></i>Acciones
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('facturas.enviarForm', $factura) }}" class="btn btn-primary w-100">
                    <i class="bi bi-envelope"></i> Enviar al cliente
                </a>
                <a href="{{ route('facturas.pdf', $factura) }}" class="btn btn-stone w-100" target="_blank">
                    <i class="bi bi-file-pdf"></i> Descargar PDF
                </a>
                <a href="{{ route('facturas.edit', $factura) }}" class="btn btn-stone w-100">
                    <i class="bi bi-pencil"></i> Editar factura
                </a>
                <form action="{{ route('facturas.destroy', $factura) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar esta factura?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn w-100" style="background:#f3e8e8;color:#c47a7a;border:1px solid #e8c5c5;">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
