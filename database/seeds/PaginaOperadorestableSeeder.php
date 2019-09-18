<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class PaginaOperadorestableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Pagina\PaginaCategoriaOperador::class, 10)->create();
        factory(App\Operador::class, 30)->create();
        factory(App\Pagina\PaginaPeruano::class, 130)->create();
        factory(App\Pagina\PaginaComunidad::class, 130)->create();
        factory(App\Pagina\PaginaExtranjero::class, 130)->create();

        $faker = Faker::create();
        for ($i=1; $i <= 100; $i++) {
            DB::table('PaginaServicios')->insert([
                'nombre'         => $faker->sentence(2)." Services.",
                'operador_id'    => rand(1,30),
                'peruano_id'     => $i,
                'comunidad_id'   => $i,
                'extranjero_id'  => $i,
            ]);
        }
    }
}
