<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class PaginaCategoriaPaquetesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('PaginaCategoriaPaquetes')->insert([
            'nombre' => 'NACIONAL / NORTE',
        ]);
        DB::table('PaginaCategoriaPaquetes')->insert([
            'nombre' => 'NACIONAL / CENTRO',
        ]);
        DB::table('PaginaCategoriaPaquetes')->insert([
            'nombre' => 'NACIONAL / SUR',
        ]);
        DB::table('PaginaCategoriaPaquetes')->insert([
            'nombre' => 'INTERNACIONAL',
        ]);
        DB::table('PaginaCategoriaPaquetes')->insert([
            'nombre' => 'LUNA DE MIEL',
        ]);
        DB::table('PaginaCategoriaPaquetes')->insert([
            'nombre' => 'FULL DAY',
        ]);
        DB::table('PaginaCategoriaPaquetes')->insert([
            'nombre' => 'SALIDA CONFIRMADA',
        ]);
    }
}
