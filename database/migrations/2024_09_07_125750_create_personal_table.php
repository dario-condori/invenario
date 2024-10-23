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
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 75)->comment('Nombres del personal');
            $table->string('apellido_1', 75)->comment('Primer apellido del personal');
            $table->string('apellido_2', 75)->comment('Segundo apellido del personal');
            $table->string('ci', 75)->comment('Cédula de identidad del personal');
            $table->unsignedBigInteger('expedido_id')->comment('Identificador del departamento');
            $table->date('fecha_ingreso')->comment('Fecha en la cual ingresa a trabajar');
            $table->decimal('sueldo')->comment('Monto del sueldo acordado');
            $table->decimal('extra')->comment('Monto extraordinario acordado');
            $table->unsignedBigInteger('usuario_id')->comment('Identificador de usuario que realiza el registro');
            $table->boolean('activo')->default(true)->comment('Estado del personal si se encuentra activo o no');
            $table->timestamps();

            $table->foreign('expedido_id')->references('id')->on('departamento');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->comment('Tabla para registro del personal de comercialización');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal');
    }
};
