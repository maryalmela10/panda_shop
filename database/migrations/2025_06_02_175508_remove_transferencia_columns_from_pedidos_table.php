<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'justificante_pago',
                'cantidad_transferencia',
                'fecha_transferencia',
            ]);
        });
    }

    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('justificante_pago')->nullable();
            $table->decimal('cantidad_transferencia', 8, 2)->nullable();
            $table->timestamp('fecha_transferencia')->nullable();
        });
    }
};
