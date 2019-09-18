<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaNoche extends Model
{
    protected $table = 'paginanoches';
    protected $fillable = ['cantidad'];
    // PaginaDestino
    public function paginaDestino(){
    	return $this->hasOne('\App\Pagina\PaginaDestinoPaquete','noche_id');
    }
    // listado
    public function listado(){
    	return $this->hasOne('\App\Pagina\PaginaListado','noche_id');
    }
}
