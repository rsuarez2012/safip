<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class OtroVenta extends Model
{
     protected $table = 'otro_ventas';
    protected $fillable = ['proveedor_id','tipo','paquete_venta_id'];
    //PAQUETE  VENTA
    public function venta(){
    	return $this->belongsTo('\App\Pagina\PaqueteVenta','paquete_venta_id');
    }
     // OTRO TARIFA
    public function tarifa(){
    	return $this->hasMany('\App\Pagina\OtroTarifa','otro_venta_id');
    }
    // CONSOLIDADOR
    public function consolidador(){
        return $this->belongsTo('\App\Consolidador','proveedor_id');
    }
}
