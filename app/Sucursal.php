<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Sucursal extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sucursales';
    protected $fillable = [
        'id','empresas_id','rif','nombre','direccion','created_at','users_id'
    ];

    public function empresas(){
        return $this->belongsTo('App\Empresa');
    }

    public function agentes(){
        return $this->belongsTo('App\Agente');
    }
    


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function getSucursalNombreAttribute()
    {
        return "{$this->direccion}  {$this->nombre}";
    }

}
