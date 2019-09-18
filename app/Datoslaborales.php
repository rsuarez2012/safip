<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Datoslaborales extends Model
{
    //
	 use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'datos_laborales';
    protected $fillable = [
        'empleado_id','contrato_id','empresa_id','fecha_ingreso','empresa',
        'tipo_empleado','turno','ocupacion','forma_pago',
        'tipo_moneda','categoria_ocupacional','cargo',
        'banco','numero_cuenta'
    ];

    public function Empleado()
    {
        return $this->belongsTo('App\Empleado');
    }
    public function Contrato()
    {
        return $this->hasMany('App\Contrato');
        //return $this->belongsTo('App\Contrato');
    }
}
