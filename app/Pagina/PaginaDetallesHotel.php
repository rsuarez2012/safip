<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaDetallesHotel extends Model
{
    protected $table = 'detalles_hotel';
    protected $fillable = ['hotel_id','resumen_hotel','descripcion_habitaciones'];
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
