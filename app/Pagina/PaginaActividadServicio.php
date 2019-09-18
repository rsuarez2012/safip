<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaActividadServicio extends Model
{
    protected $table = 'paginaactividadservicio';
    protected $fillable = ['servicio_id','actividad_id'];
    // ACTIVIDAD
    public function actividad(){
    	return $this->belongsTo('\App\Pagina\PaginaActividad','actividad_id');
    }
    // SERVICIO
    public function servicio(){
    	return $this->belongsTo('\App\Pagina\PaginaServicio','servicio_id');
    }
}
