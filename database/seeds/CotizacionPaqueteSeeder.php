<?php

use Illuminate\Database\Seeder;

class CotizacionPaqueteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Aviaje::class, 30)->create();
        factory(App\Pais::class, 30)->create();
        factory(App\Pagina\CotizacionPaquete::class,10)->create();
    }
}
