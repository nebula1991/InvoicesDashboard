<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'email',
        'telefono',
        'nif',
        'direccion',
    ];

    // Genera automáticamente CLI-001, CLI-002...
public static function generarCodigo(): string
{
    $ultimo = self::max('id') ?? 0;
    return 'CLI-' . str_pad($ultimo + 1, 3, '0', STR_PAD_LEFT);
}

    // Un cliente puede tener muchas facturas
    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}
