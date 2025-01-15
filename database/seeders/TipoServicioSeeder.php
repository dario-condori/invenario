<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_servicio')->insert([
            'descripcion' => 'Cambio de aceite',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tipo_servicio')->insert([
            'descripcion' => 'Cambio de llantas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tipo_servicio')->insert([
            'descripcion' => 'Mantenimiento general',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
