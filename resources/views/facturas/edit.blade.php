@extends('layouts.app')

@section('content')

<div class="page-header fade-in fade-in-1">
    <h1><i class="bi bi-pencil"></i> Editar Factura</h1>
    <a href="{{ route('facturas.index') }}" class="btn btn-stone">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card fade-in fade-in-2">
            <div class="card-header bg-white d-flex align-items-center gap-2">
                <i class="bi bi-receipt" style="color:var(--color-primary);"></i>
                <span class="fw-semibold">{{ $factura->numero }}</span>
                @php $badges = ['borrador'=>'secondary','enviada'=>'primary','pagada'=>'success','vencida'=>'danger']; @endphp
                <span class="badge bg-{{ $badges[$factura->estado] }}">{{ ucfirst($factura->estado) }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('facturas.update', $factura) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('facturas._form')
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Actualizar Factura
                        </button>
                        <a href="{{ route('facturas.index') }}" class="btn btn-stone">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
