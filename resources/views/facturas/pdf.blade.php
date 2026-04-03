<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            padding: 40px;
        }

        /* ── CABECERA ── */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }
        .header-left, .header-right {
            display: table-cell;
            vertical-align: top;
        }
        .header-right {
            text-align: right;
        }
        .empresa-nombre {
            font-size: 24px;
            font-weight: bold;
            color: #1a1a2e;
        }
        .empresa-datos {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
            line-height: 1.6;
        }
        .factura-titulo {
            font-size: 28px;
            font-weight: bold;
            color: #1a1a2e;
        }
        .factura-numero {
            font-size: 14px;
            color: #666;
            margin-top: 4px;
        }

        /* ── LÍNEA SEPARADORA ── */
        .divider {
            border-top: 3px solid #1a1a2e;
            margin-bottom: 30px;
        }

        /* ── DATOS CLIENTE / FACTURA ── */
        .info-block {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .info-left, .info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .info-right {
            text-align: right;
        }
        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .info-value {
            font-size: 13px;
            line-height: 1.7;
        }
        .info-value strong {
            font-size: 15px;
        }

        /* ── TABLA DE CONCEPTOS ── */
        .tabla-conceptos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .tabla-conceptos thead tr {
            background-color: #1a1a2e;
            color: white;
        }
        .tabla-conceptos th {
            padding: 10px 12px;
            text-align: left;
            font-size: 12px;
        }
        .tabla-conceptos th.text-right,
        .tabla-conceptos td.text-right {
            text-align: right;
        }
        .tabla-conceptos tbody tr {
            border-bottom: 1px solid #eee;
        }
        .tabla-conceptos tbody td {
            padding: 10px 12px;
        }

        /* ── TOTALES ── */
        .totales {
            width: 280px;
            margin-left: auto;
            margin-bottom: 30px;
        }
        .totales table {
            width: 100%;
            border-collapse: collapse;
        }
        .totales td {
            padding: 6px 10px;
            font-size: 13px;
        }
        .totales td:last-child {
            text-align: right;
        }
        .totales .total-final {
            background-color: #1a1a2e;
            color: white;
            font-weight: bold;
            font-size: 15px;
        }
        .totales .subtotal-row {
            border-top: 1px solid #ddd;
        }

        /* ── ESTADO ── */
        .estado-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .estado-borrador { background: #e2e3e5; color: #383d41; }
        .estado-enviada  { background: #cce5ff; color: #004085; }
        .estado-pagada   { background: #d4edda; color: #155724; }
        .estado-vencida  { background: #f8d7da; color: #721c24; }

        /* ── NOTAS ── */
        .notas {
            background: #f8f9fa;
            border-left: 4px solid #1a1a2e;
            padding: 12px 16px;
            font-size: 12px;
            color: #555;
            margin-bottom: 30px;
        }

        /* ── PIE ── */
        .footer {
            text-align: center;
            font-size: 11px;
            color: #aaa;
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    {{-- CABECERA --}}
    <div class="header">
        <div class="header-left">
            <div class="empresa-nombre">Tu Empresa S.L.</div>
            <div class="empresa-datos">
                NIF: B-12345678<br>
                Calle Ejemplo 123, 43001 Tarragona<br>
                info@tuempresa.com · +34 600 000 000
            </div>
        </div>
        <div class="header-right">
            <div class="factura-titulo">FACTURA</div>
            <div class="factura-numero">{{ $factura->numero }}</div>
            <div style="margin-top: 8px;">
                <span class="estado-badge estado-{{ $factura->estado }}">
                    {{ ucfirst($factura->estado) }}
                </span>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    {{-- DATOS CLIENTE Y FECHAS --}}
    <div class="info-block">
        <div class="info-left">
            <div class="info-label">Facturar a</div>
            <div class="info-value">
                <strong>{{ $factura->cliente->nombre }}</strong><br>
                @if($factura->cliente->nif)
                    NIF: {{ $factura->cliente->nif }}<br>
                @endif
                @if($factura->cliente->direccion)
                    {{ $factura->cliente->direccion }}<br>
                @endif
                {{ $factura->cliente->email }}<br>
                @if($factura->cliente->telefono)
                    {{ $factura->cliente->telefono }}
                @endif
            </div>
        </div>
        <div class="info-right">
            <div class="info-label">Fecha de emisión</div>
            <div class="info-value">{{ $factura->fecha->format('d/m/Y') }}</div>

            @if($factura->fecha_vencimiento)
            <div class="info-label" style="margin-top: 12px;">Fecha de vencimiento</div>
            <div class="info-value">{{ $factura->fecha_vencimiento->format('d/m/Y') }}</div>
            @endif
        </div>
    </div>

    {{-- TABLA CONCEPTOS --}}
    <table class="tabla-conceptos">
        <thead>
            <tr>
                <th>Concepto</th>
                <th class="text-right">Importe</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Servicios profesionales</td>
                <td class="text-right">{{ number_format($factura->base_imponible, 2, ',', '.') }} €</td>
            </tr>
        </tbody>
    </table>

    {{-- TOTALES --}}
    <div class="totales">
        <table>
            <tr class="subtotal-row">
                <td>Base imponible</td>
                <td>{{ number_format($factura->base_imponible, 2, ',', '.') }} €</td>
            </tr>
            <tr>
                <td>IVA ({{ number_format($factura->iva, 0) }}%)</td>
                <td>{{ number_format($factura->base_imponible * $factura->iva / 100, 2, ',', '.') }} €</td>
            </tr>
            <tr class="total-final">
                <td>TOTAL</td>
                <td>{{ number_format($factura->total, 2, ',', '.') }} €</td>
            </tr>
        </table>
    </div>

    {{-- NOTAS --}}
    @if($factura->notas)
    <div class="notas">
        <strong>Notas:</strong> {{ $factura->notas }}
    </div>
    @endif

    {{-- PIE --}}
    <div class="footer">
        Gracias por confiar en nosotros · Tu Empresa S.L. · www.tuempresa.com
    </div>

</body>
</html>
