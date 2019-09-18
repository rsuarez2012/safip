<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaPaquete extends Model
{
    protected $table = 'reserva_paquetes';
    
    protected $fillable = [
        'paquete_id','usuario_id','nombre','apellido','correo','telefono','documento',
        'documento_num','confirma'
    ];
}
