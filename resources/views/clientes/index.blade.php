@extends('layouts.app')

@section('content')

<div class="page-header fade-in fade-in-1">
    <h1><i class="bi bi-people"></i> Clientes</h1>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Cliente
    </a>
</div>

<div class="card fade-in fade-in-2">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>NIF</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                <tr>
                    <td>
                        <span class="badge bg-secondary">{{ $cliente->codigo }}</span>
                    </td>
                    <td class="fw-semibold">{{ $cliente->nombre }}</td>
                    <td class="text-muted">{{ $cliente->email }}</td>
                    <td class="text-muted">{{ $cliente->telefono ?? '—' }}</td>
                    <td class="text-muted">{{ $cliente->nif ?? '—' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('clientes.show', $cliente) }}"
                               class="btn btn-stone btn-sm" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('clientes.edit', $cliente) }}"
                               class="btn btn-stone btn-sm" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este cliente?')">
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
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-people d-block"></i>
                            No hay clientes aún.
                            <a href="{{ route('clientes.create') }}">Crea el primero</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 fade-in fade-in-3">
    {{ $clientes->links() }}
</div>

@endsection
