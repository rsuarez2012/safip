<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaDestinoPaquete extends Model
{
    protected $table = 'paginadestinospaquetes';
    protected $fillable = ['noche_id','paquete_id','destino_id'];
    // NOCHES
    public function noches(){
        return $this->belongsTo('\App\Pagina\PaginaNoche','noche_id');
    }
    // DESTINO
    public function destino(){
    	return $this->belongsTo('\App\Pagina\PaginaDestino','destino_id');
    }
    // PAQUETE
    public function paquete(){
    	return $this->belongsTo('\App\Pagina\PaginaPaquete','paquete_id');
    }

}
