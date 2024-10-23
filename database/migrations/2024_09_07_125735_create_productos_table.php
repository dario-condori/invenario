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
        Schema::create('productos', function (Blueprint $table) {
            $table->id()->comment('Identificador de registro a nivel de la tabla');
            $table->string('descripcion', 75)->comment('Descripción del producto');
            $table->string('sigla', 8)->comment('Sigla del producto');
            $table->timestamps();

            $table->comment('Tabla paramétrica de los productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamento');
    }
};
