<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adelanto extends Model
{
    
    protected $table = 'adelantos';
    protected $fillable = [
        'monto','fecha','empleado_id','tipo','motivo'
    ];
}
