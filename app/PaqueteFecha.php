<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteFecha extends Model
{
    protected $table = 'paquete_fechas';

	protected $fillable = ['descripcion','paquete_id'];
}
