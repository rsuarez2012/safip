<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Bancog extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'bancos_g';
    protected $fillable = [
        'id','banco'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
