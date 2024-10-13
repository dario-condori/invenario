<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('personal')->insert([
            'nombres' => 'Juan',
            'apellido_1' => 'Perez',
            'apellido_2' => 'Paz',
            'ci' => '123456',
            'expedido_id' => 2,
            'fecha_ingreso' => '2024-06-01',
            'sueldo' => 3000,
            'extra' => 0,
            'usuario_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
