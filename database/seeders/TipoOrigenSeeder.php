<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoOrigenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_origen')->insert([
            'descripcion' => 'Fabrica',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tipo_origen')->insert([
            'descripcion' => 'Almacen',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
