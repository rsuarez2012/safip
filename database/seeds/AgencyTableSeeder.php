<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class AgencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Pagina\User::class,20)->create();
        $faker = Faker::create();
        for ($i=1; $i <= 20; $i++) {
            DB::table('Agencies')->insert([
                'business_name'        => $faker->name(),
                'legal_representative' => $faker->name(),
                'district'             => $faker->sentence(2),
                'website'              => $faker->sentence(2),
                'date'                 => date('Y-m-d'),
                'corporate_phone'      => rand(1000000,9999999),
                'user_phone'           => rand(1000000,9999999),
                'status'               => $faker->randomElement(['approved','processing','rejected']),
                'user_web_id'          => $i,
            ]);
        }
    }
}
