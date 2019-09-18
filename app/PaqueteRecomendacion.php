<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteRecomendacion extends Model
{
    protected $table = 'paquete_recomendaciones';

	protected $fillable = ['descripcion','paquete_id'];
}
