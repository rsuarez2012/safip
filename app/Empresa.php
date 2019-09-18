<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Empresa extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'empresas';
    protected $fillable = [
        'id','logo','nombre', 'rif', 'direccion',
        'email','telefono_1','telefono_2','web',
        'slogan','dias_presupuesto_valido','porcentaje_contribucion_id',
        'concepto_retencion_id','dias_validar_retenciones','using_almacen_estante',
        'using_prod_referencial','using_banco_emisor','modulo_facturacion',
        'modulo_inventario','modulo_presupuesto','charcuteria_precio',
        'conexion_interna_externa'
    ];

   
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
