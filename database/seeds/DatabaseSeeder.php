<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AgencyTableSeeder::class);
        $this->call(PaginaDestinosTableSeeder::class);
        $this->call(PaginaCategoriaPaquetesSeeder::class);
        $this->call(PaginaPaquetesSeeder::class);
        $this->call(PaginaOperadorestableSeeder::class);
        $this->call(PaginaRestauranteTableSeeder::class);
        $this->call(CotizacionPaqueteSeeder::class);
    }
}
