<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteIncluido extends Model
{
    protected $table = 'paquete_incluidos';

	protected $fillable = ['descripcion','paquete_id'];
}

