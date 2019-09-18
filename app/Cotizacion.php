<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Cotizacion extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cotizaciones';
    protected $fillable = [
        'id','count','aviajes_id','paises_id','d_ciudad_id','h_ciudad_id',  'salida_at', 'llegada_at',
       'ida_vuelta','cantidad_pasajeros','status','observacion','created_at','updated_at','users_id','anulado'
    ];

    public function empresas(){
        return $this->belongsTo('App\Empresa');
    }

    public function sucursales(){
        return $this->belongsto('App\Sucursal');
    }

    public function paises(){
        return $this->belongsto('App\Pais');
    }

    public function ciudades(){
        return $this->belongsTo('App\Ciudad');
    }

    public function users(){
        return $this->belongsTo('App\User');
    }

    public function aviajes(){
        return $this->belongsTo('App\Aviaje');
    }

    public function agentes(){
        return $this->belongsTo('App\Agente');
    }

    public static function sortdate($date)
    {
      $date = explode('-', $date);

      $dayTime = explode(' ', $date[2]);

      return $dayTime[0]."/".$date[1]."/".$date[0];
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
