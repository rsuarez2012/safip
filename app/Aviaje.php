<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Aviaje extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'agencia_viajes';
    protected $fillable = [
        'id','empresas_id','nombre', 'rif', 'direccion',
        'telefono','email','web','descripcion','counter',
        'users_id','updated_by','status'
    ];

    public function empresas(){
        return $this->belongsTo('App\Empresa');
    }

    public function cotizaciones(){
        return $this->belongsTo('App\Cotizacion');
    }

}
