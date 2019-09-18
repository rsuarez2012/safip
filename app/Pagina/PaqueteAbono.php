<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaqueteAbono extends Model
{
	protected $table = 'paquete_abonos';
    protected $fillable = ['monto','tipo_pago','paquete_venta_id'];
    // PAQUETE ABONO
    public function venta(){
    	return $this->belongsTo('\App\Pagina\PaqueteVenta','paquete_venta_id');
    }
    // BANCO PAGO PAQUETES
    public function banco(){
    	return $this->hasOne('\App\Pagina\BancoPagoPaquete','paquete_abono_id');
    }

}
