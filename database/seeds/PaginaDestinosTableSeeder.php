<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PaginaDestinosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('PaginaCategoriaHoteles')->insert([
            'nombre' => 'Vip',
        ]);
        DB::table('PaginaCategoriaHoteles')->insert([
            'nombre' => 'Economico',
        ]);
        DB::table('PaginaCategoriaHoteles')->insert([
            'nombre' => 'Basico',
        ]);
        DB::table('PaginaCategoriaHoteles')->insert([
            'nombre' => 'Turista',
        ]);
        DB::table('PaginaCategoriaHoteles')->insert([
            'nombre' => 'Primero',
        ]);


        DB::table('PaginaDestinos')->insert([
            'nombre'    => 'Cusco',
            //'pais_id'   => 168, 
        ]);
        DB::table('PaginaDestinos')->insert([
            'nombre'    => 'Lima',
            //'pais_id'   => 168,
        ]);
        DB::table('PaginaDestinos')->insert([
            'nombre'    => 'Machu picchu',
            //'pais_id'   => 168,
        ]);
        DB::table('PaginaDestinos')->insert([
            'nombre'    => 'Piura',
            //'pais_id'   => 168,
        ]);
        DB::table('PaginaDestinos')->insert([
            'nombre' => 'Arequipa',
            //'pais_id'   => 168,
        ]);

        
        factory(App\Pagina\PaginaHotel::class, 150)->create();
        
    }
}
