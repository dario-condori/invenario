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
        Schema::create('tipo_servicio', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 75)->comment('Nombre del servicio a realizar');
            $table->timestamps();

            $table->comment('Tabla para registro de tipos de almacenes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_servicio');
    }
};
