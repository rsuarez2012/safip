<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Reservation_polices extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'reservation_polices';
    protected $fillable = [
        'id', 'prodcuts_id','description'
    ];


    
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
