<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Destination extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'destination';
    protected $fillable = [
        'id', 'destination_name',
        'active'
    ];


    
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
