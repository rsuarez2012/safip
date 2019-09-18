<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaServicio extends Model
{
    protected $table = 'paginaservicios';
    protected $fillable = ['nombre','peruano_id','comunidad_id','user_id','operador_id'];
    // OPERADOR 
    public function operador(){
    	return $this->belongsTo('\App\Operador','operador_id');
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

    // ACTIVIDADES
   public function actividades(){
       return $this->hasMany('\App\Pagina\PaginaActividadServicio','servicio_id');
   }
}
