<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class PaginaRestauranteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=101; $i <= 130; $i++) {
            DB::table('PaginaRestaurantes')->insert([
                'nombre'         => $faker->randomElement(['Resto ','Deluxe ','Food ']).
                					$faker->sentence(2),
                'destino_id'     => rand(1,5),					
                'peruano_id'     => $i,
                'comunidad_id'   => $i,
                'extranjero_id'  => $i,
            ]);
        }
    }
}
