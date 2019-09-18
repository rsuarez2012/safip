<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class BancoPagoPaquete extends Model
{
    protected $table = 'banco_pago_paquetes';
    protected $fillable = ['banco_emisor','banco_receptor','numero_operacion','paquete_abono_id'];
     // BANCO PAGO PAQUETES
    public function abono(){
    	return $this->belongsTo('\App\Pagina\PaqueteAbono','paquete_abono_id');
    }
}
