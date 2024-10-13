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
        Schema::create('departamento', function (Blueprint $table) {
            $table->id()->comment('Identificador de registro a nivel de la tabla');
            $table->string('descripcion', 15)->comment('Descripción del nombre del departamento');
            $table->string('sigla', 3)->comment('Sigla del departamento');
            $table->timestamps();

            $table->comment('Tabla paramétrica de los departamentos');
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
