@extends('layouts.app')

@section('content')

<div class="page-header fade-in fade-in-1">
    <h1><i class="bi bi-person-plus"></i> Nuevo Cliente</h1>
    <a href="{{ route('clientes.index') }}" class="btn btn-stone">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card fade-in fade-in-2">
            <div class="card-body p-4">
                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    @include('clientes._form')
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar Cliente
                        </button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-stone">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
