<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class DeuagenciaViajes extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'deuagencia_viajes';
    protected $fillable = [
        'id',
        'fecha', // fecha de registro
        'venta_boleto_id', // venta del boleto - nro de cotizacion -> count en la tabla cotizaciones
        'nro_ticket', // nro_ticket en el venta_boleto
        'dni_ruc', // cliente_id en el venta_boleto
        'nombre_cliente', // nombre del cliente en el venta_boleto
        'laereas_id' , // lareas_id en el venta_boleto
        'ruta', // ruta en la venta de boleto
        'consolidadores_id',
        'aviajes_id',
        'tarifa_fee',
        'porpagar',
        'agentes_id',
        'diasc',
        'status',
        'anulado',
        'nro_operacion',
        'created_at',
        'updated_at',
        'users_id',
    ];

    public function bancose(){
        return $this->belongsTo('App\Empresa');
    }

    public function sucursales(){
        return $this->belongsto('App\Sucursal');
    }

    public function consolidadores(){
        return $this->belongsto('App\Consolidador');
    }

    public function laereas(){
        return $this->belongsto('App\Laerea');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
