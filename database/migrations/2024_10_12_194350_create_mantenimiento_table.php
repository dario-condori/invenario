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
        Schema::create('mantenimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehiculo_id')->comment('Identificador del vehiculo');
            $table->unsignedBigInteger('tipo_servicio_id')->comment('Identificador del tipo de servicio');
            $table->date('fecha')->comment('Fecha de mantenimiento con el servicio');
            $table->decimal('costo_servicio')->comment('Costo por el servicio');
            $table->decimal('costo_material')->comment('Costo del repuesto o material utilizado para el servicio');
            $table->unsignedBigInteger('usuario_id')->comment('Identificador de usuario que realiza el registro');
            $table->timestamps();

            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->foreign('tipo_servicio_id')->references('id')->on('tipo_servicio');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->comment('Tabla para registro de mantenimiento realizado a los vehiculos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento');
    }
};
