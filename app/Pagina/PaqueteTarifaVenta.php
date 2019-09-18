<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaqueteTarifaVenta extends Model
{
	 protected $table = 'paquete_tarifa_ventas';
    protected $fillable = ['tarifa_fee','utilidad','total_utilidad'];
      // QANTU TARIFA
    public function qantu(){
    	return $this->hasMany('\App\Pagina\QantuTarifa','paquete_tarifa_venta_id');
    }
     // OTRO TARIFA
    public function tarifa(){
    	return $this->hasOne('\App\Pagina\OtroTarifa','paquete_tarifa_venta_id');
    }
   
}
