<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaRestaurante extends Model
{
    protected $table = 'paginarestaurantes';
    protected $fillable = ['nombre','peruano_id','comunidad_id','extranjero_id','destino_id'];

    // DESTINO
    public function destino(){
    	return $this->belongsTo('\App\Pagina\PaginaDestino','destino_id');
    }
    // PERUANO
    public function peruano(){
    	return $this->belongsTo('\App\Pagina\PaginaPeruano','peruano_id');
    }
    // COMUNIDAD
    public function comunidad(){
    	return $this->belongsTo('\App\Pagina\PaginaComunidad','comunidad_id');
    }
    // EXTRANJERO
    public function extranjero(){
    	return $this->belongsTo('\App\Pagina\PaginaExtranjero','extranjero_id');
    }
    // ACTIVIDAD
    public function actividad(){
        return $this->hasMany('\App\Pagina\PaginaActividadRestaurante','restaurante_id');
    }
}
