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
    Schema::table('pedido_producto', function (Blueprint $table) {
        $table->decimal('precio_producto', 8, 2);
    });
}

public function down()
{
    Schema::table('pedido_producto', function (Blueprint $table) {
        $table->dropColumn('precio_producto');
    });
}
};
