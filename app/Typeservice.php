<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Typeservice extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'type_service';
    protected $fillable = [
        'id', 'name',
        'active'
    ];

   
    
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
