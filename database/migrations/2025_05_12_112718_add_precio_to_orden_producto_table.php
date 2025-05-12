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
    Schema::table('orden_producto', function (Blueprint $table) {
        $table->decimal('precio', 8, 2); // Asegúrate de usar el tipo correcto de dato
    });
}

public function down()
{
    Schema::table('orden_producto', function (Blueprint $table) {
        $table->dropColumn('precio');
    });
}
};
