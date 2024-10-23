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
        Schema::create('comercio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehiculo_id')->comment('Identificador del vehículo');
            $table->unsignedBigInteger('combustible_id')->comment('Identificador del cargado de combustible en el vehículo');
            $table->integer('vuelta')->comment('Número de vuelta del vehiculo');
            $table->date('fecha')->comment('Fecha en la cual se procede a la venta de ladrillos');
            // $table->decimal('cantidad_compra')->comment('Cantidad del producto comprado para comercializar');
            // $table->decimal('precio_compra')->comment('Precio de compra del producto a comercializar por cada 1000 unidades');
            // $table->decimal('precio_compra_total')->comment('Precio total de compra del producto a comercializar');
            // $table->decimal('cantidad_venta')->comment('Cantidad del producto vendido al cliente');
            // $table->decimal('precio_venta')->comment('Precio de venta del producto al cliente por cada 1000 unidades');
            // $table->decimal('precio_venta_total')->comment('Precio de venta total del producto al cliente');
            // $table->decimal('cantidad_saldo')->comment('Cantidad del producto que quedó como saldo');
            // $table->decimal('precio_saldo')->comment('Precio del producto que quedó como saldo');
            $table->decimal('transporte')->default(0)->comment('Precio del transporte por el traslado de productos');
            $table->string('lugar_venta', 150)->comment('Lugar donde se vendió el producto');
            $table->string('observacion', 250)->nullable()->comment('Observaciones respecto al producto vendido');
            $table->unsignedBigInteger('personal_id')->comment('Identificador del personal de comercialización');
            $table->unsignedBigInteger('usuario_id')->comment('Identificador de usuario que realiza el registro');
            $table->unsignedBigInteger('proforma_id')->comment('Identificador de la proforma');
            $table->timestamps();

            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
            $table->foreign('combustible_id')->references('id')->on('combustible');
            $table->foreign('personal_id')->references('id')->on('personal');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('proforma_id')->references('id')->on('proformas');
            $table->comment('Tabla para registro de comercialización de producto principal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercio');
    }
};
