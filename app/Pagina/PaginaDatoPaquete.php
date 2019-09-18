<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaDatoPaquete extends Model
{
    protected $table = 'paginadatospaquetes';
    protected $fillable = ['texto','tipo', 'paquete_id'];

    // PAQUETE
    public function paquete(){
    	return $this->belongsTo('\App\Pagina\PaginaPaquete','paquete_id');
    }
}
