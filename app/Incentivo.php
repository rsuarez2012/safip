<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Incentivo extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'comision_incentivo';
    protected $fillable = [
        'id','primera_meta','primer_incentivo',
        'segunda_meta','segundo_incentivo',
        'tercera_meta','tercer_incentivo',
        'cuarta_meta','cuarto_incentivo',
        'quinta_meta','quinto_incentivo',
        'created_at','users_id'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
