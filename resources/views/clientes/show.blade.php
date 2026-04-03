@extends('layouts.app')

@section('content')

<div class="page-header fade-in fade-in-1">
    <h1><i class="bi bi-person"></i> Detalle Cliente</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('clientes.index') }}" class="btn btn-stone">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row g-3">

    {{-- Datos del cliente --}}
    <div class="col-md-5">
        <div class="card fade-in fade-in-2 h-100">
            <div class="card-header bg-white d-flex align-items-center gap-2">
                <div style="width:36px;height:36px;border-radius:50%;background:var(--color-stone);
                            display:flex;align-items:center;justify-content:center;
                            font-weight:700;color:var(--color-accent);font-size:1rem;">
                    {{ strtoupper(substr($cliente->nombre, 0, 1)) }}
                </div>
                <div>
                    <div class="fw-semibold">{{ $cliente->nombre }}</div>
                    <div class="small text-muted">{{ $cliente->codigo }}</div>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-start gap-3 py-2 border-bottom">
                        <i class="bi bi-envelope mt-1" style="color:var(--color-primary);"></i>
                        <div>
                            <div class="small text-muted">Email</div>
                            <div>{{ $cliente->email }}</div>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-3 py-2 border-bottom">
                        <i class="bi bi-telephone mt-1" style="color:var(--color-primary);"></i>
                        <div>
                            <div class="small text-muted">Teléfono</div>
                            <div>{{ $cliente->telefono ?? '—' }}</div>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-3 py-2 border-bottom">
                        <i class="bi bi-card-text mt-1" style="color:var(--color-primary);"></i>
                        <div>
                            <div class="small text-muted">NIF / CIF</div>
                            <div>{{ $cliente->nif ?? '—' }}</div>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-3 py-2">
                        <i class="bi bi-geo-alt mt-1" style="color:var(--color-primary);"></i>
                        <div>
                            <div class="small text-muted">Dirección</div>
                            <div>{{ $cliente->direccion ?? '—' }}</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Facturas del cliente --}}
    <div class="col-md-7">
        <div class="card fade-in fade-in-3 h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span><i class="bi bi-receipt me-2" style="color:var(--color-primary);"></i>Facturas</span>
                <a href="{{ route('facturas.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Nueva
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cliente->facturas()->latest()->get() as $factura)
                        @php $badges = ['borrador'=>'secondary','enviada'=>'primary','pagada'=>'success','vencida'=>'danger']; @endphp
                        <tr>
                            <td>
                                <a href="{{ route('facturas.show', $factura) }}"
                                   class="fw-semibold text-decoration-none"
                                   style="color:var(--color-primary);">
                                    {{ $factura->numero }}
                                </a>
                            </td>
                            <td class="text-muted">{{ $factura->fecha->format('d/m/Y') }}</td>
                            <td class="fw-semibold">{{ number_format($factura->total, 2, ',', '.') }} €</td>
                            <td><span class="badge bg-{{ $badges[$factura->estado] }}">{{ ucfirst($factura->estado) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="bi bi-receipt d-block"></i>
                                    Sin facturas aún
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
