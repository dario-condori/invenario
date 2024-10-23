<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin\TipoOrigen;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsuariosSeeder::class,
            DepartamentoSeeder::class,
            ProductosSeeder::class,
            VehiculosSeeder::class,
            PersonalSeeder::class,
            CombustibleSeeder::class,
            ComercioSeeder::class,
            TipoAlmacenSeeder::class,
            TipoOrigenSeeder::class,
        ]);
    }
}
