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
        Schema::create('tipo_almacen', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 75)->comment('Nombre del almacen, ejem: tienda, casa, galpon');
            $table->string('ubicacion', 150)->comment('Lugar donde se encuentra el almacen');
            $table->timestamps();

            $table->comment('Tabla para registro de tipos de almacenes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_almacen');
    }
};
