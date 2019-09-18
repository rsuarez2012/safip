<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaqueteVenta extends Model
{
    protected $table = 'paquete_ventas';
    protected $fillable = ['nacionalidad','costo_neto','incentivo','user_id','cliente_id','cotizacion_id','total_venta', 'pago_mayorista','a_pagar','estado','comision','fecha','update_by'];
    // QANTU
    public function qantu(){
    	return $this->hasOne('\App\Pagina\QantuVenta','paquete_venta_id');
    }
    // OTROS
    public function otro(){
    	return $this->hasOne('\App\Pagina\OtroVenta','paquete_venta_id');
    }
     //PAQUETE ABONOS
    public function abonos(){
    	return $this->hasMany('\App\Pagina\PaqueteAbono','paquete_venta_id');
    }
    //PAQUETE ABONOS
    public function vendedor(){
        return $this->belongsTo('\App\User','user_id');
    }
    //PAQUETE ABONOS
    public function cliente(){
        return $this->belongsTo('\App\Cliente','cliente_id');
    }
    public function cotizacion(){
        return $this->belongsTo('\App\Pagina\CotizacionPaquete','cotizacion_id');
    }

}

