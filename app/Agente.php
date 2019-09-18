<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Agente extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'id', 'role_id',
        'role', 'apellidos',
        'nombres', 'email',
        'password','pais','ciudad',
        'direccion','telefono','imagen',
        'active','code','boletos','ncppagar',
        'ancppagar','ncpcobrar',',ancpcobrar','configuracion',
        'vboletos','cclave','pconso','deuaviajes','opb','empresas_id', 'sucursales_id'
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
