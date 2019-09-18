<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $fillable = ['nombre'];

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
    //relacion a los hoteles
    public function hoteles()
    {
        return $this->belongsToMany('App\Pagina\PaginaHotel', 'hotel_servicio', 'servicio_id');
    }
}
