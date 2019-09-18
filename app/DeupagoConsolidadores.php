<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class DeupagoConsolidadores extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'deupago_consolidadores';
    protected $fillable = [
        'fecha',
        'venta_boleto_id',
        'nro_ticket',
        'codigo',
        'dni_ruc',
        'nombre_cliente', 
        'laereas_id' ,
        'ruta',
        'consolidadores_id',
        'aviajes_id',
        'pago_consolidador',
        'porpagar',
        'comision_agencia',
        'igv',
        'total',
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
}
