@extends('layouts.app')

@section('content')

<div class="page-header fade-in fade-in-1">
    <h1><i class="bi bi-speedometer2"></i> Dashboard</h1>
    <span class="text-muted small">{{ now()->format('d \d\e F \d\e Y') }}</span>
</div>

{{-- TARJETAS --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card primary fade-in fade-in-1">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#eaf1f8;">
                    <i class="bi bi-cash-stack" style="color:var(--color-primary);"></i>
                </div>
                <div>
                    <div class="stat-label">Total Facturado</div>
                    <div class="stat-value">{{ number_format($totalFacturado, 2, ',', '.') }} €</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card success fade-in fade-in-2">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#e8f3eb;">
                    <i class="bi bi-check-circle" style="color:#6aab7e;"></i>
                </div>
                <div>
                    <div class="stat-label">Total Cobrado</div>
                    <div class="stat-value" style="color:#6aab7e;">{{ number_format($totalPagado, 2, ',', '.') }} €</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card warning fade-in fade-in-3">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#f5f0e8;">
                    <i class="bi bi-clock-history" style="color:#c9a96e;"></i>
                </div>
                <div>
                    <div class="stat-label">Pendiente Cobro</div>
                    <div class="stat-value" style="color:#c9a96e;">{{ number_format($totalPendiente, 2, ',', '.') }} €</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card danger fade-in fade-in-4">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#f3e8e8;">
                    <i class="bi bi-exclamation-triangle" style="color:#c47a7a;"></i>
                </div>
                <div>
                    <div class="stat-label">Facturas Vencidas</div>
                    <div class="stat-value" style="color:#c47a7a;">{{ $facturasVencidas }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- GRÁFICA + TABLA --}}
<div class="row g-3">
    <div class="col-md-5 fade-in fade-in-5">
        <div class="card h-100">
            <div class="card-header bg-white">
                <i class="bi bi-pie-chart me-2" style="color:var(--color-primary);"></i>
                Facturas por Estado
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="graficaEstados" style="max-height:240px;"></canvas>
            </div>
            <div class="card-footer bg-white border-0 pb-3">
                <div class="row text-center g-2">
                    @foreach(['borrador'=>['#d4cfc9','Borrador'],'enviada'=>['#c5d8ed','Enviada'],'pagada'=>['#c5ddc9','Pagada'],'vencida'=>['#e8c5c5','Vencida']] as $estado=>[$color,$label])
                    <div class="col-3">
                        <div class="fw-bold" style="color:var(--color-text);">{{ $porEstado[$estado] }}</div>
                        <div class="small" style="color:var(--color-text-muted);">{{ $label }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7 fade-in fade-in-6">
        <div class="card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2" style="color:var(--color-primary);"></i>Últimas Facturas</span>
                <a href="{{ route('facturas.index') }}" class="btn btn-stone btn-sm">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimasFacturas as $factura)
                        @php $badges = ['borrador'=>'secondary','enviada'=>'primary','pagada'=>'success','vencida'=>'danger']; @endphp
                        <tr>
                            <td class="fw-semibold">{{ $factura->numero }}</td>
                            <td>{{ $factura->cliente->nombre }}</td>
                            <td class="fw-semibold">{{ number_format($factura->total, 2, ',', '.') }} €</td>
                            <td><span class="badge bg-{{ $badges[$factura->estado] }}">{{ ucfirst($factura->estado) }}</span></td>
                            <td>
                                <a href="{{ route('facturas.show', $factura) }}" class="btn btn-stone btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-receipt d-block"></i>
                                    No hay facturas aún
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('graficaEstados'), {
        type: 'doughnut',
        data: {
            labels: ['Borrador', 'Enviada', 'Pagada', 'Vencida'],
            datasets: [{
                data: [{{ $porEstado['borrador'] }}, {{ $porEstado['enviada'] }}, {{ $porEstado['pagada'] }}, {{ $porEstado['vencida'] }}],
                backgroundColor: ['#d4cfc9', '#7c9cbf', '#6aab7e', '#c47a7a'],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            cutout: '68%'
        }
    });
</script>

@endsection
