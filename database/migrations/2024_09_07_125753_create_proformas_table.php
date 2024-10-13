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
        Schema::create('proformas', function (Blueprint $table) {
            $table->id();
            $table->integer('gestion')->comment('Gestion de la proforma');
            $table->date('fecha_registro')->comment('Fecha de registro de la proforma');
            $table->string('cliente_ci')->comment('Cédula de identidad del cliente');
            $table->string('cliente_nombre', 150)->default('-')->comment('Nombre del cliente');
            $table->unsignedBigInteger('usuario_id')->comment('Identificador de usuario que realiza el registro');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users');
            $table->comment('Tabla para registro de proformas de venta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proformas');
    }
};
