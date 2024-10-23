<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_almacen')->insert([
            'descripcion' => 'Tienda',
            'ubicacion' => 'Av. Litoral',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tipo_almacen')->insert([
            'descripcion' => 'Casa',
            'ubicacion' => 'Calle San Gabriel',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
