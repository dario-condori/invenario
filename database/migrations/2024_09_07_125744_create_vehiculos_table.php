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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('marca', 100)->comment('Marca del vehiculo');
            $table->integer('modelo')->comment('Modelo del vehiculo - gestion');
            $table->string('color', 100)->comment('Color del vehiculo');
            $table->string('placa', 10)->unique()->comment('Matricula de control del vehiculo - placa');
            $table->unsignedBigInteger('usuario_id')->comment('Identificador de usuario que realiza el registro');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users');
            $table->comment('Tabla para registro de vehiculos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
