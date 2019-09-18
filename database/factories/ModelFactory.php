<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */



// HOTELES
$factory->define(App\Pagina\PaginaHotel::class, function (Faker\Generator $faker) {
   $titulo = $faker->sentence(3); // Cualquier texto de 4 palabras 
   $nombre = $faker->randomElement(['Hostel', 'Hostal', 'Royal']);	
   return [
   	   'nombre'   	=> $nombre . " " . $titulo,
   	   'estrella' 	=> $faker->randomElement(['Hostel', 'Hst' , 'Hst 2*' , 'Hst 3*', '2*' , '3*']),
   	   'e_swb'    	=> rand(10,500),
   	   'e_dwb'    	=> rand(10,500),
   	   'e_tpl'    	=> rand(10,500),
   	   'e_chd'    	=> rand(10,500),
   	   'p_swb'    	=> rand(10,500),
   	   'p_dwb'    	=> rand(10,500),
   	   'p_tpl'    	=> rand(10,500),
   	   'p_chd'    	=> rand(10,500),
   	   'check_in' 	=> '22:00:00',
   	   'check_in' 	=> '16:30:00',
   	   'destino_id' => rand(1,5),
   	   'categoria_id' => rand(1,5),
   ];
});

// PAQUETES
$factory->define(App\Pagina\PaginaPaquete::class, function (Faker\Generator $faker) {
   return [
      'nombre'       => "Travel " . $faker->sentence(2),
      'codigo'       => strtoupper(str_random(3)) . rand(1,300) . strtoupper(str_random(2)),
      'descripcion'  => $faker->sentence(20),
      'extracto'     => $faker->sentence(5),
      'estado'       => $faker->randomElement(['visible', 'oculto' , 'destacado']),
      'imagen'       => "img_paquete_170818_NncZKTs4m3DZ2Q1.jpg",
      'categoria_id' => rand(1,3),
      'statusCreado' => 2,
   ];
});

//CATEGORIA DE OPERADOR
$factory->define(App\Pagina\PaginaCategoriaOperador::class,function (Faker\Generator $faker){
   return [
      'nombre' =>"Services " . $faker->sentence(2),
   ];
});

// DATOS PAQUETES 
$factory->define(App\Pagina\PaginaDatoPaquete::class,function (Faker\Generator $faker){
   return [
      'texto'      =>$faker->sentence(3),
      'tipo'       =>$faker->randomElement(['incluido','noincluido','llevar','importante','politcareserva','politicatarifa','fechas','responsabilidades']),
      'paquete_id' =>rand(1,10),
   ];
});

//OPERADOR
$factory->define(App\Operador::class,function (Faker\Generator $faker){
   $nombre = $faker->name();
   return [
      'empresas_id'   => 1,
      'nombre'       => $nombre,
      'rif'          => rand(1000000,9999999),
      'direccion'    => "Estado " . $faker->sentence(3) . "Avenue.",
      'telefono'     => rand(1000000,9999999),
      'email'        => $nombre . "@gmail.com",
      'web'          => $nombre . ".com",
      'descripcion'  => $faker->sentence(50),
      'user_id'      => rand(1,5),
      'updated_by'   => $nombre,
      'categoria_id' => rand(1,10),
      'destino_id'   => rand(1,5),
   ];
});

//TARIFAS DE SERVICIOS
$factory->define(App\Pagina\PaginaPeruano::class,function (Faker\Generator $faker){
   return [
      'adulto' => rand(100,1000),
      'estudiante' => rand(100,1000),
      'ninio' => rand(100,1000),
   ];
});
$factory->define(App\Pagina\PaginaComunidad::class,function (Faker\Generator $faker){
   return [
      'adulto' => rand(100,1000),
      'estudiante' => rand(100,1000),
   ];
});
$factory->define(App\Pagina\PaginaExtranjero::class,function (Faker\Generator $faker){
   return [
      'adulto' => rand(100,1000),
      'estudiante' => rand(100,1000),
      'ninio' => rand(100,1000),
   ];
});

$factory->define(App\Aviaje::class,function (Faker\Generator $faker){
   return [
      'empresas_id' => rand(1,100),
      'nombre'      => $faker->name(), 
      'rif'         => rand(1000000,9999999), 
      'direccion'   => $faker->sentence(3),
      'telefono'    => rand(1000000,9999999),
      'email'       => $faker->sentence(1)."@gmail.com",
      'web'         => $faker->sentence(1).".com",
      'descripcion' => $faker->sentence(20),
      'counter'     => $faker->name(),
      'users_id'    => $faker->name(),
      'updated_by'  => $faker->name()
   ];
});

$factory->define(App\Pais::class,function (Faker\Generator $faker){
   return [
      'PaisCodigo'    => strtoupper(str_random(8)),
      'paisnombre'    => $faker->sentence(3),
      'PaisContinente'=> $faker->sentence(3),
      'PaisRegion'    => $faker->sentence(3)
   ];
});

$factory->define(App\Pagina\CotizacionPaquete::class,function (Faker\Generator $faker){
   return [
      'agencia_id'   => rand(1,30),
      'pais_id'      => rand(1,30),
      'destino_id'   => rand(1,5),
      'fecha_salida' => "2018-08-28",
      'fecha_retorno'=> "2018-08-30",
      'pasajero'     => rand(1,5),
      'nacionalidad' => $faker->randomElement(['extranjero','comunidad','peruano']),
      'observacion'  => $faker->sentence(2),
      'user_id'      => 1
   ];
});

$factory->define(App\Pagina\User::class,function (Faker\Generator $faker){
    return [
       'name'           => $faker->name(1),
       'lastname'       => $faker->lastname(),
       'dni'            => rand(1000000,9999999),
       'pais_id'        => rand(1,5),
       'email'          => $faker->email(),
       'password'       => bcrypt("password"),
       'ciudad_id'      => rand(1,3),
       'address'        => $faker->sentence(3),
       'role'           => $faker->randomElement(['client','agency']),
       'imagen'         => "imagenes/img.png",
       'remember_token' => "adwncurmdloekdjusmwt",
    ];
 });