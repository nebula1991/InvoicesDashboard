<div class="mb-3">
    <label class="form-label">Nombre *</label>
    <input type="text" name="nombre"
           class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $cliente->nombre ?? '') }}"
           placeholder="Nombre completo o empresa" required>
    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Email *</label>
    <input type="email" name="email"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $cliente->email ?? '') }}"
           placeholder="correo@ejemplo.com" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control"
               value="{{ old('telefono', $cliente->telefono ?? '') }}"
               placeholder="+34 600 000 000">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">NIF / CIF</label>
        <input type="text" name="nif" class="form-control"
               value="{{ old('nif', $cliente->nif ?? '') }}"
               placeholder="12345678A">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Dirección</label>
    <textarea name="direccion" class="form-control" rows="3"
              placeholder="Calle, número, ciudad, código postal">{{ old('direccion', $cliente->direccion ?? '') }}</textarea>
</div>
