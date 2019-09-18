<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaPasajero extends Model
{
	protected $table = 'reserva_pasajeros';
	protected $fillable = [
		'nombre','apellido','telefono','documento','documento_num',
		'reserva_id'		
	];
}
