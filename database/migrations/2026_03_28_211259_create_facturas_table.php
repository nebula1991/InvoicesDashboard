<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('numero')->unique();       // Ej: FAC-2025-001
            $table->date('fecha');
            $table->date('fecha_vencimiento')->nullable();
            $table->decimal('base_imponible', 10, 2)->default(0);
            $table->decimal('iva', 5, 2)->default(21); // % de IVA
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('estado', ['borrador', 'enviada', 'pagada', 'vencida'])->default('borrador');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
