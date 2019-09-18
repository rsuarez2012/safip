<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $table = 'paquetes';

	protected $fillable = ['nombre','precio_sol','precio_dolar','destino','descripcion','extracto','servicio','categoria','imagen','visible','destacado','fecha_sale','fecha_llega','cupos'];
}
