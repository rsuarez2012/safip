<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Ciudad extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'ciudades';
    protected $fillable = [
        'id','ciudadnombre','paiscodigo','ciudaddistrito',  'ciudadpoblacion', 'created_at','users_id'
    ];

    public function cotizaciones(){
        return $this->belongsTo('App\Cotizacion');
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
