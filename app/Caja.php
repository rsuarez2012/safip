<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Caja extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'caja_chica';
    protected $fillable = [
        'id','monto','descripcion','users_id'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
