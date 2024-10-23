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
        Schema::create('almacen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comercio_productos_id')->comment('Identificador de la proforma');
            $table->unsignedBigInteger('producto_id')->comment('Identificador del producto');
            $table->unsignedBigInteger('tipo_almacen_id')->comment('Identificador del tipo de almacen');
            $table->decimal('cantidad')->comment('Cantidad del producto para almacenes');
            $table->decimal('precio')->comment('Precio de compra del producto por cada 1000 unidades');
            $table->timestamps();

            $table->foreign('comercio_productos_id')->references('id')->on('comercio_productos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('tipo_almacen_id')->references('id')->on('tipo_almacen');
            $table->comment('Tabla para registro de almacenes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacen');
    }
};
