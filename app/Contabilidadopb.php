<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Contabilidadopb extends Model
{
    protected $table = 'contabilidad_opb';
    protected $fillable = [
        'monto', 'tipo', 'sucursal', 'nro_operacion', 'fecha',
    ];

}
