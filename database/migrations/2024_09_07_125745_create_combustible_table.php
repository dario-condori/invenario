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
        Schema::create('combustible', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehiculo_id')->comment('Identificador del vehículo');
            $table->date('fecha')->comment('Fecha en la cual se carga el combustible');
            $table->string('factura',15)->comment('Factura por la carga del combustible');
            $table->decimal('precio_unitario')->default(3.72)->comment('Precio unitario del combustible, diesel 3.72 y gasolina 3.74');
            $table->decimal('costo')->comment('Costo total de combustible cargado');
            $table->decimal('volumen')->comment('Volumen total de combustible segun precio unitario y costo');
            $table->unsignedBigInteger('usuario_id')->comment('Identificador de usuario que realiza el registro');
            $table->timestamps();

            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->comment('Tabla para registro de combustible cargado por vehiculo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combustible');
    }
};
