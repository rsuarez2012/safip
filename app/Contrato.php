<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Contrato extends Model
{
    //
	 use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'contratos';
    protected $fillable = [
        'fecha_inicio','fecha_fin','sueldo'
    ];

     public function Datoslaborales()
    {
        return $this->belongsTo('App\Datoslaborales', 'datoslaborables_id');
        //return $this->hasOne('App\Datoslaborales');
    }
}
 