<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehiculos')->insert([
            'marca' => 'Nissan Condor',
            'modelo' => '2005',
            'color' => 'Blanco',
            'placa' => '1234 ABC',
            'usuario_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // DB::table('vehiculos')->insert([
        //     'marca' => 'Toyota Dina',
        //     'modelo' => '2015',
        //     'color' => 'Azul',
        //     'placa' => '2345 XYZ',
        //     'usuario_id' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}
