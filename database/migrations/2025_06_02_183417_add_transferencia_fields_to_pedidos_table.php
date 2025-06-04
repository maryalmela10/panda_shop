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
            $table->decimal('total_pagado', 8, 2)->after('coste_envio');
            $table->string('justificante_pago')->nullable()->after('estado');
            $table->timestamp('fecha_transferencia')->nullable()->after('justificante_pago');
        });
    }

    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['total_pagado', 'justificante_pago', 'fecha_transferencia']);
        });
    }
};
