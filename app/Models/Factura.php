<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'numero',
        'fecha',
        'fecha_vencimiento',
        'base_imponible',
        'iva',
        'total',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha'             => 'date',
        'fecha_vencimiento' => 'date',
        'base_imponible'    => 'decimal:2',
        'iva'               => 'decimal:2',
        'total'             => 'decimal:2',
    ];

    // Una factura pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Genera automáticamente el número de factura
    public static function generarNumero(): string
    {
        $año = date('Y');
        $ultimo = self::whereYear('created_at', $año)->count() + 1;
        return 'FAC-' . $año . '-' . str_pad($ultimo, 3, '0', STR_PAD_LEFT);
    }
}
