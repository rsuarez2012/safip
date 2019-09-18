<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalidaConfirmada extends Model
{
    protected $table = 'salidas_confirmadas';

	protected $fillable = ['nombre','precio_sol','precio_dolar','destino','descripcion','extracto','servicio','categoria','imagen','visible','destacado','cupos','fecha_sale','fecha_entra'];
}
