<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Anio extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'anio';
    protected $fillable = [
        'id', 'anio'
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
