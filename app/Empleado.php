<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Empleado extends Model
{
     use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'empleados';
    protected $fillable = [
        'nombre','apellido','documento','email',
        'telefono_local','telefono_celular','direccion',
        'fecha_nacimiento','estado_civil','pais','foto'
    ];

	public function Datoslaborales()
    {
        return $this->hasMany('App\Datoslaborales');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
