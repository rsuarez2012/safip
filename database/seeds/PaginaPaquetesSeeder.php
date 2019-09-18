<?php

use Illuminate\Database\Seeder;

class PaginaPaquetesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     factory(App\Pagina\PaginaPaquete::class, 10)->create();
     factory(App\Pagina\PaginaDatoPaquete::class, 100)->create();
    }
}
