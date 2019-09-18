<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Comision extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'comision';
    protected $fillable = [
        'id', 'only_operator', 'consolidadores_id','laereas_id','comision','created_at','users_id'
    ];

    public function consolidadores(){
        return $this->belongsTo('App\Consolidador');
    }

    public function laereas(){
        return $this->belongsto('App\Laerea');
    }
    public function scopeBusqueda($query,$dato1="",$dato2="")
    {

        if ($dato1 == "") {

        } else {
            if ($dato2 == "") {

            } else {
                $resultado = $query->where('consolidadores_id', '=', '%' . $dato1 . '%')
                    ->Where('laereas_id', '=', '%' . $dato . '%');
            }
            return $resultado->comision;
        }
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
