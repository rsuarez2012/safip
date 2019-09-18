<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Tpago extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tpago';
    protected $fillable = [
        'id','pago'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
