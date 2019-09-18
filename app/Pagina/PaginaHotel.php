<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaHotel extends Model
{
    protected $table = 'paginahoteles';
    protected $fillable = ['nombre','estrella','e_swb','e_dwb','e_tpl','e_chd','p_swb','p_dwb','p_tpl','p_chd','destino_id','categoria_id','check_in','check_out','enlace'];

    // DESTINO
    public function destino(){
    	return $this->belongsTo('\App\Pagina\PaginaDestino','destino_id');
    }
    // CATEGORIA
    public function categoria(){
    	return $this->belongsTo('\App\Pagina\PaginaCategoriaHotel','categoria_id');
    }

    public function listados(){
        return $this->hasMany(PaginaListado::class, 'hotel_id');
    }

    //relacion a los servicios
    public function servicios()
    {
        return $this->belongsToMany('App\Pagina\Servicio', 'hotel_servicio', 'hotel_id');
        //return $this->belongsToMany('App\Pagina\Servicio', 'hotel_servicio', 'hotel_id', 'servicio_id');
    }
}
