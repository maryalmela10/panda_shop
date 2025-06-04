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
    Schema::table('pedidos', function (Blueprint $table) {
        $table->string('estado')->default('pendiente');
        $table->string('justificante_pago')->nullable();
        $table->decimal('cantidad_transferencia', 8, 2)->nullable();
        $table->date('fecha_transferencia')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            //
        });
    }
};
