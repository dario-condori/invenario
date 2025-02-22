<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            'descripcion' => 'Ladrillos de 6 huecos',
            'sigla' => 'L6H',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('productos')->insert([
            'descripcion' => 'Ladrillos de 18 huecos',
            'sigla' => 'L18H',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('productos')->insert([
            'descripcion' => 'Roja Quiba',
            'sigla' => 'RQ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('productos')->insert([
            'descripcion' => 'Incercar',
            'sigla' => 'INC',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('productos')->insert([
            'descripcion' => 'Incercar Rayado',
            'sigla' => 'INCRAY',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('productos')->insert([
            'descripcion' => 'Cabezas',
            'sigla' => 'CAB',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('productos')->insert([
            'descripcion' => 'Bota Agua',
            'sigla' => 'BOTAG',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('productos')->insert([
            'descripcion' => 'Ceranitech',
            'sigla' => 'CERTECH',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
