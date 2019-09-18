<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaListado extends Model
{
    protected $table = 'paginalistados';
    protected $fillable = ['codigo','hotel_id','noche_id','estado','paquete_id', 'destacado'];
    // HOTEL
    public function hotel(){
    	return $this->belongsTo('\App\Pagina\PaginaHotel','hotel_id');
    }
    // PAQUETE
    public function paquete(){
        return $this->belongsTo('\App\Pagina\PaginaPaquete','paquete_id');
    }
    // NOCHES
    public function noches(){
        return $this->belongsTo('\App\Pagina\PaginaNoche','noche_id');
    }
}
