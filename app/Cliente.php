<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Cliente extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cliente';
    protected $fillable = [
        'id','tipo_documento','empresas_id','cedula_rif','nombre','apellido',  'telefono', 'direccion',
       'email','direccion','tipo_pasajero','created_at','users_id'
    ];

    public function empresas(){
        return $this->belongsTo('App\Empresa');
    }
    public function sucursales(){
        return $this->belongsTo('App\Sucursal');
    }

    public function scopeBusqueda($query,$dato="")
    {

        if($dato==""){
            alert("Debe escribir algo en el campo de busqueda");
        }
        else{

            $resultado= $query->where('nombre','like','%'.$dato.'%')
                ->orWhere('apellido','like', '%'.$dato.'%')
                ->orWhere('email','like', '%'.$dato.'%');
        }
        return  $resultado;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
