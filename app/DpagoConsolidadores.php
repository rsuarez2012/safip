<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class DpagoConsolidadores extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'dpago_consolidadores';
    protected $fillable = [
        'id', 'venta_boleto_id', 'nro_ticket', 'abono' ,'tipo_pago','banco_emisor','banco_receptor','nro_operacion','nro_operacion_bancaria',
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
