<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class QantuTarifa extends Model
{
     protected $table = 'qantu_tarifas';
    protected $fillable = ['qantu_venta_id','paquete_tarifa_venta_id'];
      //QANTU  VENTA
    public function qantu(){
    	return $this->belongsTo('\App\Pagina\QantuVenta','qantu_venta_id');
    }

    	// PAQUETE TARIFA VENTA
    	 public function tarifa(){
    	return $this->belongsTo('\App\Pagina\PaqueteTarifaVenta','paquete_tarifa_venta_id');
    }
}
