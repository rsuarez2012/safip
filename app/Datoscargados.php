<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Datoscargados extends Model
{
    //
	 use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'datos_cargados';
    protected $fillable = [
        'tipo_dato','nombre_dato'
    ];
}
