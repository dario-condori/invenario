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
        Schema::create('tanque_combustible', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehiculo_id')->comment('Identificador del vehículo');
            $table->date('fecha')->comment('Fecha en la cual se carga el combustible');
            $table->decimal('precio_unitario')->default(3.72)->comment('Precio unitario del combustible, diesel 3.72 y gasolina 3.74');
            $table->decimal('costo')->comment('Costo total de combustible cargado');
            $table->unsignedBigInteger('comercio_id')->default(0)->comment('Identificador de la vuelta de comercio');
            $table->unsignedBigInteger('usuario_id')->comment('Identificador de usuario que realiza el registro');
            $table->timestamps();

            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
            // $table->foreign('comercio_id')->references('id')->on('comercio');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->comment('Tabla para registro del estado del tanque de combustible del vehiculo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanque_combustible');
    }
};
