<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Recommendations_to_carry extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'recommendations_to_carry';
    protected $fillable = [
        'id', 'prodcuts_id','description'
    ];


    
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
