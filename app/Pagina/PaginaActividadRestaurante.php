<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaActividadRestaurante extends Model
{
    protected $table = 'paginaactividadrestaurante';
    protected $fillable = ['restaurante_id','actividad_id'];
    // ACTIVIDAD
    public function actividad(){
    	return $this->belongsTo('\App\Pagina\PaginaActividad','actividad_id');
    }
    // RESTAURANTE
    public function restaurante(){
    	return $this->belongsTo('\App\Pagina\PaginaRestaurante','restaurante_id');
    }
}
