<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteItinerario extends Model
{
    protected $table = 'paquete_itinerarios';

	protected $fillable = ['descripcion','paquete_id','fecha'];
}
