<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Laerea extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'laereas';
    protected $fillable = [
        'id','empresas_id','nombre', 'rif', 'direccion',
        'telefono','email','web','descripcion','counter','users_id','updated_by'
    ];

    public function empresas(){
        return $this->belongsTo('App\Empresa');
    }

    public function comisiones(){
        return $this->belongsTo('App\Comision');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
