<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CombustibleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('combustible')->insert([
            'vehiculo_id' => 1,
            'fecha' => date('Y-m-d'),
            'precio_unitario' => 3.72,
            'costo' => 500,
            'volumen' => 135,
            'usuario_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
