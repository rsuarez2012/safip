<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class OtroTarifa extends Model
{
   protected $table = 'otro_tarifas';
    protected $fillable = ['paquete_tarifa_venta_id','otro_venta_id'];
     //OTRO  VENTA
    public function otro()
    {
    	return $this->belongsTo('\App\Pagina\OtroVenta','otro_venta_id');
    }

    // PAQUETE TARIFA VENTA
    public function tarifa()
    {
    	return $this->belongsTo('\App\Pagina\PaqueteTarifaVenta','paquete_tarifa_venta_id');
    }
}
