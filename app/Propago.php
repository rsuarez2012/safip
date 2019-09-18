<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Propago extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'pro_pago';
    protected $fillable = [
        'id','cotizacion_id','monto' ,'tipo_pago','banco_e','banco_r','numero_op','monto_f',
        'created_at','updated_at','users_id'
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
