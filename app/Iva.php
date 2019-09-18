<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Iva extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'iva';
    protected $fillable = [
        'id','iva','users_id'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
