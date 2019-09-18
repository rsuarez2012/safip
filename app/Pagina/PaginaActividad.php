<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaActividad extends Model
{
    protected $table = 'paginaactividades';
    protected $fillable = ['nombre','tipo','dia_id','codigo'];
    // DESTINO
    public function dia(){
    	return $this->belongsTo('\App\Pagina\PaginaDia','dia_id');
    }
    // RESTAURANTE
    public function restaurante(){
    	return $this->hasMany('\App\Pagina\PaginaActividadRestaurante','actividad_id');
    }
    // SERVICIO
    public function servicio(){
    	return $this->hasMany('\App\Pagina\PaginaActividadServicio','actividad_id');
    }
}
