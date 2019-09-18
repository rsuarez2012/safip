<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class QantuVenta extends Model
{
   protected $table = 'qantu_ventas';
    protected $fillable = ['codigo_enlace','tipo','tipo_habitacion','tipo','porcentaje','paquete_id','paquete_venta_id','a_pagar','comision'];

    // PAQUETE VENTA
    public function venta(){
    	return $this->belongsTo('\App\Pagina\PaqueteVenta','paquete_venta_id');
    }

     // QANTU TARIFA
    public function tarifa(){
    	return $this->hasOne('\App\Pagina\QantuTarifa','qantu_venta_id');
    }

}
