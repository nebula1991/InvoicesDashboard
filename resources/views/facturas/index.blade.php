@extends('layouts.app')

@section('content')

<div class="page-header fade-in fade-in-1">
    <h1><i class="bi bi-receipt"></i> Facturas</h1>
    <a href="{{ route('facturas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Factura
    </a>
</div>

<div class="card fade-in fade-in-2">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Vencimiento</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $factura)
                @php $badges = ['borrador'=>'secondary','enviada'=>'primary','pagada'=>'success','vencida'=>'danger']; @endphp
                <tr>
                    <td class="fw-semibold" style="color:var(--color-primary);">{{ $factura->numero }}</td>
                    <td>
                        <a href="{{ route('clientes.show', $factura->cliente) }}"
                           class="text-decoration-none fw-semibold" style="color:var(--color-text);">
                            {{ $factura->cliente->nombre }}
                        </a>
                        <div class="small text-muted">{{ $factura->cliente->codigo }}</div>
                    </td>
                    <td class="text-muted">{{ $factura->fecha->format('d/m/Y') }}</td>
                    <td class="text-muted">{{ $factura->fecha_vencimiento?->format('d/m/Y') ?? '—' }}</td>
                    <td class="fw-semibold">{{ number_format($factura->total, 2, ',', '.') }} €</td>
                    <td><span class="badge bg-{{ $badges[$factura->estado] }}">{{ ucfirst($factura->estado) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('facturas.show', $factura) }}"
                               class="btn btn-stone btn-sm" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('facturas.edit', $factura) }}"
                               class="btn btn-stone btn-sm" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('facturas.destroy', $factura) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar esta factura?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm" title="Eliminar"
                                        style="background:#f3e8e8;color:#c47a7a;border:1px solid #e8c5c5;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-receipt d-block"></i>
                            No hay facturas aún.
                            <a href="{{ route('facturas.create') }}">Crea la primera</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 fade-in fade-in-3">
    {{ $facturas->links() }}
</div>

@endsection
