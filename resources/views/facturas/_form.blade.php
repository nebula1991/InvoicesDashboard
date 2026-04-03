<div class="mb-3">
    <label class="form-label">Cliente *</label>
    <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
        <option value="">-- Selecciona un cliente --</option>
        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}"
                {{ old('cliente_id', $factura->cliente_id ?? '') == $cliente->id ? 'selected' : '' }}>
                {{ $cliente->codigo }} - {{ $cliente->nombre }}
            </option>
        @endforeach
    </select>
    @error('cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha *</label>
        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
               value="{{ old('fecha', isset($factura) ? $factura->fecha->format('Y-m-d') : date('Y-m-d')) }}" required>
        @error('fecha') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha Vencimiento</label>
        <input type="date" name="fecha_vencimiento" class="form-control"
               value="{{ old('fecha_vencimiento', isset($factura) && $factura->fecha_vencimiento ? $factura->fecha_vencimiento->format('Y-m-d') : '') }}">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Base Imponible (€) *</label>
        <input type="number" name="base_imponible" step="0.01" min="0"
               class="form-control @error('base_imponible') is-invalid @enderror"
               value="{{ old('base_imponible', $factura->base_imponible ?? '') }}"
               id="base_imponible" required>
        @error('base_imponible') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">IVA (%) *</label>
        <select name="iva" class="form-select" id="iva">
            @foreach([0, 4, 10, 21] as $tipo)
                <option value="{{ $tipo }}"
                    {{ old('iva', $factura->iva ?? 21) == $tipo ? 'selected' : '' }}>
                    {{ $tipo }}%
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Total (€)</label>
        <input type="text" id="total_preview" class="form-control bg-light fw-bold" readonly>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Estado *</label>
    <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
        @foreach(['borrador' => 'Borrador', 'enviada' => 'Enviada', 'pagada' => 'Pagada', 'vencida' => 'Vencida'] as $value => $label)
            <option value="{{ $value }}"
                {{ old('estado', $factura->estado ?? 'borrador') == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Notas</label>
    <textarea name="notas" class="form-control" rows="3">{{ old('notas', $factura->notas ?? '') }}</textarea>
</div>

{{-- Cálculo automático del total --}}
<script>
    function calcularTotal() {
        const base = parseFloat(document.getElementById('base_imponible').value) || 0;
        const iva  = parseFloat(document.getElementById('iva').value) || 0;
        const total = base + (base * iva / 100);
        document.getElementById('total_preview').value = total.toFixed(2) + ' €';
    }

    document.getElementById('base_imponible').addEventListener('input', calcularTotal);
    document.getElementById('iva').addEventListener('change', calcularTotal);
    calcularTotal(); // Ejecutar al cargar
</script>
