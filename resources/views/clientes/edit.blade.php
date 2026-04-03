@extends('layouts.app')

@section('content')

<div class="page-header fade-in fade-in-1">
    <h1><i class="bi bi-pencil"></i> Editar Cliente</h1>
    <a href="{{ route('clientes.index') }}" class="btn btn-stone">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card fade-in fade-in-2">
            <div class="card-header bg-white d-flex align-items-center gap-2">
                <span class="badge bg-secondary">{{ $cliente->codigo }}</span>
                <span class="fw-semibold">{{ $cliente->nombre }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('clientes._form')
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Actualizar Cliente
                        </button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-stone">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
