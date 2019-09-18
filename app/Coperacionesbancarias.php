<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Coperacionesbancarias extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'operaciones_bancarias';
    protected $fillable = [
        'procedencia',
        'tipo_operacion',
        'fecha',
        'descripcion',
        'monto',
        'saldo',
        'sucursal',
        'nro_operacion',
        'hora_operacion',
        'usuario',
        'utc',
        'referencia',
        'status',
        'empresa',
        'moneda',
    ];

    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
