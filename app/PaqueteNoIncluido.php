<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteNoIncluido extends Model
{
    protected $table = 'paquete_noincluidos';

	protected $fillable = ['descripcion','paquete_id'];
}
