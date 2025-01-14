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
            $table->string('cliente', 75)->default('-')->comment('Nombre del cliente');
            $table->string('cliente_celular', 20)->default('0')->comment('Número de celular del cliente');
            $table->unsignedBigInteger('vehiculo_id')->comment('Identificador del vehículo');
            $table->unsignedBigInteger('combustible_id')->comment('Identificador del cargado de combustible en el vehículo');
            $table->integer('vuelta')->comment('Número de vuelta del vehiculo');
            $table->date('fecha')->comment('Fecha en la cual se procede a la venta de ladrillos');
            $table->decimal('transporte')->default(0)->comment('Precio del transporte por el traslado de productos');
            $table->string('lugar_venta', 150)->comment('Lugar donde se vendió el producto');
            $table->string('observacion', 250)->nullable()->comment('Observaciones respecto al producto vendido');
            $table->decimal('refresco')->default(0)->comment('Costo de refresco por la vuelta');
            $table->decimal('peaje')->default(0)->comment('Costo de peaje en caso de pasar por las trancas de ABC');
            $table->decimal('viatico')->default(0)->comment('Otros gastos por ejemplo compra de otros productos');
            $table->decimal('corte_mitad')->default(0)->comment('Costo por el corte de ladrillos a la mitad');
            $table->decimal('costo_combustible')->default(0)->comment('Costo del combustible durante el traslado');
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
