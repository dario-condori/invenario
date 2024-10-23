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
        Schema::create('comercio_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comercio_id')->comment('Identificador de la proforma');
            $table->unsignedBigInteger('producto_id')->comment('Identificador del producto');
            $table->unsignedBigInteger('tipo_origen_id')->comment('Identificador del tipo de origen del producto');
            $table->decimal('cantidad_compra')->comment('Cantidad del producto comprado para comercializar');
            $table->decimal('precio_compra')->comment('Precio de compra del producto a comercializar por cada 1000 unidades');
            $table->decimal('precio_compra_total')->comment('Precio total de compra del producto a comercializar');
            $table->decimal('cantidad_venta')->comment('Cantidad del producto vendido al cliente');
            $table->decimal('precio_venta')->comment('Precio de venta del producto al cliente por cada 1000 unidades');
            $table->decimal('precio_venta_total')->comment('Precio de venta total del producto al cliente');
            $table->timestamps();

            $table->foreign('comercio_id')->references('id')->on('comercio')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('tipo_origen_id')->references('id')->on('tipo_origen');
            $table->comment('Tabla para registro de productos de la proforma');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercio_productos');
    }
};
