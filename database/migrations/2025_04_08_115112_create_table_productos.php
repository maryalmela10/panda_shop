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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->nombre();
            $table->string('descripcion');
            $table->precio();
            $table->imagen_url();
            $table->disponible();
            $table->stock();
            $table->categoria_id();
            $table->num_ventas();
            $table->timestamp('fecha_reposicion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
