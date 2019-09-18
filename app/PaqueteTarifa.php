<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteTarifa extends Model
{
    protected $table = 'paquete_tarifas';

	protected $fillable = ['descripcion','paquete_id'];
}
