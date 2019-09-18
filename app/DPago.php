<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class DPago extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'dcuentas_pagar';
    protected $fillable = [
       'id','venta_boleto_id','codigo', 'abono' ,'tipo_pago','banco_emisor','banco_receptor','nro_operacion','created_at','updated_at','users_id'
    ];

    public function bancose(){
        return $this->belongsTo('App\Empresa');
    }

    public function sucursales(){
        return $this->belongsto('App\Sucursal');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
