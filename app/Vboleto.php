<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Vboleto extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cotizaciones';
    protected $fillable = [
        'id','cotizaciones_id','consolidadores_id','laereas_id','codigo','subtotal',  'ivg', 'total','created_at','updated_at','users_id'
    ];

    public function laereas(){
        return $this->belongsTo('App\Laerea');
    }

    public function cotizaciones(){
        return $this->belongsto('App\Cotizacion');
    }

    public function consolidadores(){
        return $this->belongsto('App\Consolidador');
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
