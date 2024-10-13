<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departamento')->insert([
            'descripcion' => 'Chuquisaca',
            'sigla' => 'CH',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('departamento')->insert([
            'descripcion' => 'La Paz',
            'sigla' => 'LP',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('departamento')->insert([
            'descripcion' => 'Cochabamba',
            'sigla' => 'CB',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('departamento')->insert([
            'descripcion' => 'Oruro',
            'sigla' => 'OR',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('departamento')->insert([
            'descripcion' => 'Potosí',
            'sigla' => 'PT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('departamento')->insert([
            'descripcion' => 'Tarija',
            'sigla' => 'TJ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('departamento')->insert([
            'descripcion' => 'Santa Cruz',
            'sigla' => 'SC',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('departamento')->insert([
            'descripcion' => 'Beni',
            'sigla' => 'BN',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('departamento')->insert([
            'descripcion' => 'Pando',
            'sigla' => 'PD',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('departamento')->insert([
            'descripcion' => 'Otros',
            'sigla' => 'OTR',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
