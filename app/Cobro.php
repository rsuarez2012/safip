<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Cobro extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cuentas_cobrar';
    protected $fillable = [
        'id','venta_boleto_id','nro_ticket','dni_ruc','cliente_id','fecha','dias','monto','formaPago','bancoEmisor',
        'bancoReceptor','nroOperacion','codigo','status','created_at','updated_at','users_id'
    ];

    public function empresas(){
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