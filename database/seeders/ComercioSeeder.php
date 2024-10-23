<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComercioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //---add proforma 1
        DB::table('proformas')->insert([
            'gestion' => date('Y'),
            'fecha_registro' => date('Y-m-d'),
            'cliente_ci' => 0,
            'cliente_nombre' => 'Mercedes Sosa',
            'usuario_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('proforma_productos')->insert([
            'proforma_id' => 1,
            'producto_id' => 1,
            'cantidad' => 3000,
            'precio_unitario' => 650,
            'precio_total' => 1950,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        //---add proforma 2
        DB::table('proformas')->insert([
            'gestion' => date('Y'),
            'fecha_registro' => date('Y-m-d'),
            'cliente_ci' => 0,
            'cliente_nombre' => 'Pablo Perez',
            'usuario_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('proforma_productos')->insert([
            'proforma_id' => 2,
            'producto_id' => 2,
            'cantidad' => 2000,
            'precio_unitario' => 650,
            'precio_total' => 1300,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //---registro de comercialización
        DB::table('comercio')->insert([
            'vehiculo_id' => 1,
            'combustible_id' => 1,
            'vuelta' => 1,
            'fecha' => '2024-07-01',
            // 'producto_id' => 1,
            // 'cantidad_compra' => 3000,
            // 'precio_compra' => 550,
            // 'precio_compra_total' => 1650,
            // 'cantidad_venta' => 3000,
            // 'precio_venta' => 680,
            // 'precio_venta_total' => 2040,
            // 'cantidad_saldo' => 0,
            // 'precio_saldo' => 0,
            'transporte' => 350,
            'lugar_venta' => 'Senkata',
            'observacion' => '-',
            'personal_id' => 1,
            'usuario_id' => 1,
            'proforma_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('comercio')->insert([
            'vehiculo_id' => 1,
            'combustible_id' => 1,
            'vuelta' => 2,
            'fecha' => '2024-07-02',
            // 'producto_id' => 1,
            // 'cantidad_compra' => 3000,
            // 'precio_compra' => 550,
            // 'precio_compra_total' => 1650,
            // 'cantidad_venta' => 2000,
            // 'precio_venta' => 680,
            // 'precio_venta_total' => 1360,
            // 'cantidad_saldo' => 1000,
            // 'precio_saldo' => 550,
            'transporte' => 350,
            'lugar_venta' => 'Horizontes',
            'observacion' => 'Saldo en tienda',
            'personal_id' => 1,
            'usuario_id' => 1,
            'proforma_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
