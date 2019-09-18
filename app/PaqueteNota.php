<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteNota extends Model
{
    protected $table = 'paquete_notas';

	protected $fillable = ['descripcion','paquete_id'];
}
