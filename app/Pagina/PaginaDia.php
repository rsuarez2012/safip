<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaDia extends Model
{
    protected $table = 'paginadias';
    protected $fillable = ['nombre','descripcion','paquete_id','imagen'];
    // PAQUETE
    public function paquete(){
    	return $this->belongsTo('\App\Pagina\PaginaPaquete','paquete_id');
    }
    // ACTIVIDADES 
    public function actividades(){
    	return $this->hasMany('\App\Pagina\PaginaActividad','dia_id');
    }
}
