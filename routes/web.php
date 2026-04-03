<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;

// Rutas protegidas con login
Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('clientes', ClienteController::class);

    Route::get('facturas/{factura}/pdf', [FacturaController::class, 'pdf'])->name('facturas.pdf');
    Route::get('facturas/{factura}/enviar', [FacturaController::class, 'enviarForm'])->name('facturas.enviarForm');
    Route::post('facturas/{factura}/enviar', [FacturaController::class, 'enviar'])->name('facturas.enviar');
    Route::resource('facturas', FacturaController::class);

});

// Rutas de autenticación de Breeze
require __DIR__.'/auth.php';
