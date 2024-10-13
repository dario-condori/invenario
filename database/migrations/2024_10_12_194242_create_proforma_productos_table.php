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
        Schema::create('proforma_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proforma_id')->comment('Identificador de la proforma');
            $table->unsignedBigInteger('producto_id')->comment('Identificador del producto');
            $table->integer('cantidad')->default(0)->comment('Cantidad del producto cotizado');
            $table->decimal('precio_unitario',8,2)->default(0)->comment('Precio unitario del producto cotizado');
            $table->decimal('precio_total',8,2)->default(0)->comment('Precio total del producto cotizado');
            $table->timestamps();

            $table->foreign('proforma_id')->references('id')->on('proformas');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->comment('Tabla para registro de productos de la proforma');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proforma_productos');
    }
};
