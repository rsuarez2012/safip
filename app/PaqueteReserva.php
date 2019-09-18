<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteReserva extends Model
{
    protected $table = 'paquete_reservas';

	protected $fillable = ['descripcion','paquete_id'];
}
