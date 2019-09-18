<?php
 
namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class CotizacionPaquete extends Model
{
    protected $table = 'paginacotizacionpaquetes';
    protected $fillable = ['agencia_id','pais_id','destino_id','fecha_salida','fecha_retorno','pasajero','nacionalidad','observacion','user_id','estado','por_pagar'];
    // PAIS
    public function pais(){
    	return $this->belongsTo('\App\Pais','pais_id');
    }
    // DESTINO 
    public function destino(){
    	return $this->belongsTo('\App\Pagina\PaginaDestino','destino_id');
    }
    // AGENICA DE VIAJE
    public function agencia(){
    	return $this->belongsTo('\App\Aviaje','agencia_id');
    }
    // USUARIO 
    public function vendedor(){
    	return $this->belongsTo('\App\User', 'user_id');
    }
    public function boletos(){
        return $this->hasMany('\App\Pagina\PaqueteVenta','cotizacion_id');
    } 
}
