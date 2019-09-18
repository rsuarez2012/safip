<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Consolidador extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'consolidadores';
    protected $fillable = [
        'id','empresas_id','nombre', 'rif', 'direccion',
        'telefono','email','web','descripcion'
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
