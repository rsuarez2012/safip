<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Banco extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'bancos';
    protected $fillable = [
        'id','banco','nrocuenta', 'monto','users_id'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
