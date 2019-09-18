<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteResponsabilidad extends Model
{
    protected $table = 'paquete_responsabilidades';

	protected $fillable = ['descripcion','paquete_id'];
}
